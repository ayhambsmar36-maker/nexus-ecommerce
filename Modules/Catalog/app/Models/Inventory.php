<?php

namespace Modules\Catalog\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// use Modules\Catalog\Database\Factories\InventoryFactory;

class Inventory extends Model
{
    use HasFactory;

    protected $table = 'inventories';

    protected $fillable = [
        'variant_id',
        'quantity',
        'low_stock_threshold',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'low_stock_threshold' => 'integer',
    ];
    /**
     * The attributes that are mass assignable.
     */

    // protected static function newFactory(): InventoryFactory
    // {
    //     // return InventoryFactory::new();
    // }
    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }

    /**
     * if(numberOfProduct<=numberOfLimit)then true
     * the numberOfLimted is equal 5 units of product
     */
    public function isLowStock(): bool
    {
        return $this->quantity <= $this->low_stock_threshold;
    }

    /**
     *  if(numberOfProduct==0)then true
     */
    public function isOutOfStock(): bool
    {
        return $this->quantity <= 0;
    }
}
