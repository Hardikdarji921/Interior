<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'description', 'client', 'location', 
        'completed_date', 'budget', 'category', 'thumbnail', 
        'gallery', 'is_featured'
    ];

    protected $casts = [
        'gallery' => 'array',
        'completed_date' => 'date',
        'budget' => 'decimal:2',
        'is_featured' => 'boolean',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
