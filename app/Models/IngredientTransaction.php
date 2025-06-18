<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IngredientTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'ingredient_id',
        'type',
        'quantity',
        'unit_price',
        'total_amount',
        'note',
        'reference_number',
        'transaction_date'
    ];

    protected $casts = [
        'quantity' => 'decimal:2',
        'unit_price' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'transaction_date' => 'datetime'
    ];

    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class);
    }

    protected static function booted()
    {
        static::created(function ($transaction) {
            $ingredient = $transaction->ingredient;
            
            switch ($transaction->type) {
                case 'import':
                    $ingredient->increment('current_stock', $transaction->quantity);
                    break;
                case 'export':
                    $ingredient->decrement('current_stock', $transaction->quantity);
                    break;
                case 'adjustment':
                    $ingredient->update(['current_stock' => $transaction->quantity]);
                    break;
            }
        });
    }
}