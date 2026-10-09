<?php

namespace Modules\Catalog\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// use Modules\Catalog\Database\Factories\ProductAttributeFactory;

class ProductAttribute extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'product_attributes';

    protected $fillable = [
        'name',
    ];

    // protected static function newFactory(): ProductAttributeFactory
    // {
    //     // return ProductAttributeFactory::new();
    // }
    public function values()
    {
        return $this->hasMany(ProductAttributeValue::class, 'product_attribute_id');
    }
}
