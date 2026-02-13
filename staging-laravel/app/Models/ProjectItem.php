<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id', 'material_id', 'color_option_id', 'quantity',
        'unit_type', 'unit_price', 'total_price', 'specifications', 'notes', 'sort_order'
    ];

    protected $casts = [
        'quantity' => 'decimal:2',
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
        'specifications' => 'array',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function colorOption()
    {
        return $this->belongsTo(ColorOption::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($item) {
            $item->total_price = $item->unit_price * $item->quantity;
        });

        static::updating(function ($item) {
            $item->total_price = $item->unit_price * $item->quantity;
        });
    }
}