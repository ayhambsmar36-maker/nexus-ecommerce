<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'customer_id',
        'label',
        'is_default',
        'country',
        'city',
        'area',
        'street',
        'building_number',
        'floor',
        'notes',
        'lat',
        'lng',
        'formatted_address',
        'phone'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function getFullAddressAttribute()
    {
        return "{$this->label},{$this->building_number},{$this->street}, {$this->area}, {$this->city}, {$this->country}";
    }
}
