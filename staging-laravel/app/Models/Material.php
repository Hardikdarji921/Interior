<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'name', 'slug', 'description', 'image',
        'base_price', 'brand', 'specifications', 'is_active'
    ];

    protected $casts = [
        'specifications' => 'array',
        'base_price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(MaterialCategory::class, 'category_id');
    }

    public function prices()
    {
        return $this->hasMany(MaterialPrice::class);
    }

    public function colorPrices()
    {
        return $this->hasMany(MaterialPrice::class)->whereNotNull('color_option_id');
    }

    public function getPriceForColor($colorOptionId = null, $quantity = 1)
    {
        $query = $this->prices();
        
        if ($colorOptionId) {
            $query->where('color_option_id', $colorOptionId);
        } else {
            $query->whereNull('color_option_id');
        }

        $price = $query->first();

        if (!$price) {
            // Calculate from base price and color multiplier
            $basePrice = $this->base_price;
            
            if ($colorOptionId) {
                $colorOption = ColorOption::find($colorOptionId);
                if ($colorOption) {
                    if ($colorOption->fixed_price) {
                        return $colorOption->fixed_price;
                    }
                    return $basePrice * $colorOption->price_multiplier;
                }
            }
            
            return $basePrice;
        }

        // Apply bulk discount if applicable
        $finalPrice = $price->price_per_unit;
        if ($quantity >= $price->min_quantity && $price->bulk_discount_percent > 0) {
            $finalPrice = $finalPrice * (1 - ($price->bulk_discount_percent / 100));
        }

        return $finalPrice;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}