<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'icon', 'description', 'unit_type', 
        'has_color_options', 'is_active', 'order'
    ];

    protected $casts = [
        'has_color_options' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function materials()
    {
        return $this->hasMany(Material::class, 'category_id');
    }

    public function colorOptions()
    {
        return $this->hasMany(ColorOption::class, 'category_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}