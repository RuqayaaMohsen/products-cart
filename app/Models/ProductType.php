<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ProductType extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name'
    ];

    public function offer(): HasOne
    {
        return $this->hasOne(Offer::class,'affected_product_type_id');
    }
}
