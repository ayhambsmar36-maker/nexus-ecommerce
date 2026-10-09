<?php

namespace Modules\Cart\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Cart\Models\CartItem;
use App\Models\Customer;

// use Modules\Cart\Database\Factories\CartFactory;

class Cart extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'customer_id',
        'status',
    ];
    protected $table = 'carts';
    public function items()
    {
        return $this->hasMany(CartItem::class);
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
   
    // protected static function newFactory(): CartFactory
    // {
    //     // return CartFactory::new();
    // }
}
