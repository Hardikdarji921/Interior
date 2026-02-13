<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalculationHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'session_id', 'material_id', 'color_option_id',
        'quantity', 'unit_price', 'total_cost', 'breakdown', 'project_name'
    ];

    protected $casts = [
        'quantity' => 'decimal:2',
        'unit_price' => 'decimal:2',
        'total_cost' => 'decimal:2',
        'breakdown' => 'array',
    ];

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function colorOption()
    {
        return $this->belongsTo(ColorOption::class, 'color_option_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}