<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialPrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'material_id', 'color_option_id', 'price_per_unit',
        'unit_type', 'min_quantity', 'max_quantity', 'bulk_discount_percent'
    ];

    protected $casts = [
        'price_per_unit' => 'decimal:2',
        'bulk_discount_percent' => 'decimal:2',
    ];

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function colorOption()
    {
        return $this->belongsTo(ColorOption::class, 'color_option_id');
    }
}