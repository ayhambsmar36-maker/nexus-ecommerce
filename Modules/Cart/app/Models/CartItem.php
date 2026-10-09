<?php

namespace Modules\Cart\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Cart\Models\Cart;
use Modules\Catalog\Models\ProductVariant;
// use Modules\Cart\Database\Factories\CartItemFactory;

class CartItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'cart_id',
        'product_variant_id',
        'quantity'
    ];
    protected $table = 'cart_items';
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }
    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }
    // protected static function newFactory(): CartItemFactory
    // {
    //     // return CartItemFactory::new();
    // }
}
