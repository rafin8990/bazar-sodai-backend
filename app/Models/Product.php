<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'original_price',
        'category_id',
        'image',
        'weight',
        'in_stock',
        'is_top_selling',
        'is_new_arrival',
        'is_featured',
        'nutritional_info',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}
