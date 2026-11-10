<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbandonedCart extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'product_id',
        'product_name',
        'product_price',
        'customer_name',
        'customer_phone',
        'customer_address',
        'ip_address',
        'status',
        'recovery_note',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}

