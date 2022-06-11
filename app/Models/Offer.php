<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = [
        'offer_product_type_id',
        'affected_product_type_id',
        'discount_value',
        'minimum_products_count',
        'shipping_offer',
    ];
}
