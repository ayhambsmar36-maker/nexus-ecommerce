<?php

namespace Modules\Order\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Order\Models\Order;
use Modules\Catalog\Models\ProductVariant;

class OrderItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        "order_id",
        "product_variant_id",
        "product_name",
        "variant_sku",
        "price",
        "quantity",
        "sub_total",
    ];
    protected $table = 'order_items';
   

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }
}
