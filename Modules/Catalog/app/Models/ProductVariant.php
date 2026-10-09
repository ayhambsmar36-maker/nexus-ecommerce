<?php

namespace Modules\Catalog\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Cart\Models\CartItem;
// use Modules\Catalog\Database\Factories\ProductVariantFactory;

class ProductVariant extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'product_variants';

    protected $fillable = [
        'product_id',
        'sku',
        'price',
        'compare_price',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'compare_price' => 'decimal:2',
    ];

    // protected static function newFactory(): ProductVariantFactory
    // {
    //     // return ProductVariantFactory::new();
    // }
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function attributeValues()
    {
        return $this->belongsToMany(
            ProductAttributeValue::class,
            'variant_attribute_values',
            'product_variant_id',
            'product_attribute_value_id'
        );
    }

    public function inventory()
    {
        return $this->hasOne(Inventory::class, 'product_variant_id');
    }
    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'product_id');
    }
}
