<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ColorOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'name', 'hex_code', 'color_code',
        'price_multiplier', 'fixed_price', 'finish_type', 'is_active'
    ];

    protected $casts = [
        'price_multiplier' => 'decimal:2',
        'fixed_price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(MaterialCategory::class, 'category_id');
    }

    public function getPriceDisplayAttribute()
    {
        if ($this->fixed_price) {
            return '₹' . number_format($this->fixed_price, 2) . ' per sq ft';
        }
        
        if ($this->price_multiplier != 1.00) {
            $percent = ($this->price_multiplier - 1) * 100;
            $sign = $percent > 0 ? '+' : '';
            return $sign . number_format($percent, 0) . '% from base price';
        }
        
        return 'Base price';
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}