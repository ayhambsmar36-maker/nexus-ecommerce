<?php

namespace Modules\Catalog\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// use Modules\Catalog\Database\Factories\ProductAttributeValueFactory;

class ProductAttributeValue extends Model
{
    use HasFactory;

    protected $table = 'product_attribute_values';

    protected $fillable = [
        'attribute_id',
        'value',
    ];
    /**
     * The attributes that are mass assignable.
     */

    // protected static function newFactory(): ProductAttributeValueFactory
    // {
    //     // return ProductAttributeValueFactory::new();
    // }
    public function attribute()
    {

        return $this->belongsTo(ProductAttribute::class, 'product_attribute_id');
    }

    public function variants()
    {
        return $this->belongsToMany(
            ProductVariant::class,
            'variant_attribute_values',
            'attribute_value_id',
            'variant_id'
        );
    }
}
