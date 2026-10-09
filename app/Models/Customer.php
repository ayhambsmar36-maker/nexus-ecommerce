<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Modules\Cart\Models\Cart;
use Laravel\Sanctum\HasApiTokens;
use Modules\Cart\Models\CartItem;
use Modules\Order\Models\Order;
class Customer extends Authenticatable 
{
    use HasApiTokens;
      
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
    ];
    protected $hidden = [
        'password',
    ];
      protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
    public function activeCart(){
        return $this->hasOne(Cart::class)->where('status', 'active');
    }
    public function cartItems()
    {
        return $this->hasManyThrough(CartItem::class, Cart::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
