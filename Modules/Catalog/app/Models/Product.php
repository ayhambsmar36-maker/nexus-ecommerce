<?php

namespace Modules\Catalog\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

// use Modules\Catalog\Database\Factories\ProductFactory;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'compare_price',
        'status',
        'slug',
        'sku',
        'is_featured',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'compare_price' => 'decimal:2',
        'is_featured' => 'boolean',
    ];

    // protected static function newFactory(): ProductFactory
    // {
    //     // return ProductFactory::new();
    // }
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product');
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function attributeValues()
    {
        return $this->belongsToMany(
            ProductAttributeValue::class,
            'product_selected_attributes', // اسم الجدول الوسيط
            'product_id',                  // المفتاح الأجنبي الخاص بالمنتج
            'attribute_value_id'           // المفتاح الأجنبي الخاص بقيمة الخاصية
        );
    }

    public static function booted()
    {
        static::creating(function ($product) {
            $product->slug = self::generateSlug($product->name);
            $product->sku = self::generateSku($product->name);
        });
    }

    public static function generateSlug(string $name)
    {

        $slug = 'NXS -'.Str::upper(Str::replace(' ', '-', $name)).'-'.Str::random(3);

        return $slug;

    }

    public static function generateSku(string $name)
    {
        $latineName = Str::transliterate($name);
        $sku = 'NXS -'.Str::upper(Str::substr($latineName, 0, 3)).'-'.Str::random(3);

        return $sku;
    }
}
