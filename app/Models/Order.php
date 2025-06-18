<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'table_id',
        'subtotal',
        'discount_amount',
        'discount_percent',
        'tax_amount',
        'total_amount',
        'cash_received',
        'change_amount',
        'status',
        'payment_status',
        'notes',
        'completed_at'
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'discount_percent' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'cash_received' => 'decimal:2',
        'change_amount' => 'decimal:2',
        'completed_at' => 'datetime'
    ];

    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_items')
                    ->withPivot('quantity', 'unit_price', 'total_price', 'notes')
                    ->withTimestamps();
    }

    public static function generateOrderNumber()
    {
        $lastOrder = self::latest()->first();
        $lastNumber = $lastOrder ? intval(substr($lastOrder->order_number, 1)) : 0;
        return '#' . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
    }

    public function calculateTotals()
    {
        $this->subtotal = $this->orderItems->sum('total_price');
        $this->tax_amount = $this->subtotal * 0.1; // 10% tax
        $this->total_amount = $this->subtotal + $this->tax_amount - $this->discount_amount;
        
        if ($this->cash_received > 0) {
            $this->change_amount = max(0, $this->cash_received - $this->total_amount);
        }
        
        $this->save();
    }
}