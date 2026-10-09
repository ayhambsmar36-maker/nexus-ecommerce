<?php

namespace Modules\Order\Models;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Override;
use Illuminate\Support\Str;
use Modules\Order\Models\OrderItem;
// use Modules\Order\Database\Factories\OrderFactory;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'customer_id',
        'notes',
        'order_number',
        'status',
        'payment_method',
        'payment_status',
        'subtotal',
        'shipping_cost',
        'total',
        'paid_at',
        'shipped_at',
        'delivered_at',
        'cancelled_at',
    ];
  protected $casts = [
        'paid_at' => 'datetime',
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];
    protected $attributes = [
        'status' => 'pending',
        'payment_method' => 'cod',
        'payment_status' => 'pending',
        'shipping_cost' => 0,
    ];
    protected $table = 'orders';
    #[Override]
    protected static function booted()
    {
        static::creating(function ($order) {
            $order->order_number = static::generateOrderNumber();
            $order->total = $order->subtotal + $order->shipping_cost;
        });
        static::updating(function ($order) {
            $order->total = $order->subtotal + $order->shipping_cost;
        });
    }
    protected static function generateOrderNumber():string
    {
        return 'ORD-' . now()->format('Ymd') . '-' .strtoupper(Str::random(6));
    }
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
   public function canCancel(): bool
    {
        return $this->status === 'pending';
    }
    public function canShip(): bool
    {
        return $this->status === 'pending' && $this->payment_status !== 'failed';
    }
    public function canDeliver(): bool
    {
        return $this->status === 'shipped';
    }
}
