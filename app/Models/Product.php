<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'name',
        'category_id',
        'original_price',
        'sale_price',
        'description',
        'image',
        'is_available',
    ];

    protected $casts = [
        'original_price' => 'float',
        'sale_price' => 'float',
        'is_available' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
