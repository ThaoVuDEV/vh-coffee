<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'unit',
        'current_stock',
        'min_stock',
        'max_stock',
        'unit_price',
        'supplier_id',
        'status',
        'product_id'
    ];

    protected $casts = [
        'current_stock' => 'decimal:2',
        'min_stock' => 'decimal:2',
        'max_stock' => 'decimal:2',
        'unit_price' => 'decimal:2'
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function transactions()
    {
        return $this->hasMany(IngredientTransaction::class);
    }

    // Kiểm tra tình trạng tồn kho
    public function getStockStatusAttribute()
    {
        if ($this->current_stock <= $this->min_stock) {
            return 'low'; // Hết hàng hoặc sắp hết
        } elseif ($this->current_stock >= $this->max_stock) {
            return 'high'; // Tồn kho cao
        }
        return 'normal'; // Bình thường
    }

    public function getStockStatusTextAttribute()
    {
        switch ($this->stock_status) {
            case 'low':
                return 'Sắp hết hàng';
            case 'high':
                return 'Tồn kho cao';
            default:
                return 'Bình thường';
        }
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
