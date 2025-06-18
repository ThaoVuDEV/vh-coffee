<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'capacity',
        'status',
        'location',
        'description',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
    
    public function getStatusTextAttribute()
    {
        return match($this->status) {
            'available' => 'Trống',
            'occupied' => 'Đang sử dụng',
            'reserved' => 'Đã đặt',
            'maintenance' => 'Bảo trì',
            default => 'Không xác định'
        };
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'available' => 'bg-green-100 text-green-800',
            'occupied' => 'bg-red-100 text-red-800',
            'reserved' => 'bg-yellow-100 text-yellow-800',
            'maintenance' => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }
    
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function currentOrder()
    {
        return $this->hasOne(Order::class)->where('status', 'pending');
    }

 
}