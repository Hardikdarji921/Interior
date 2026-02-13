<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    // Map 'name' to 'title' since your table uses 'title'
    protected $fillable = [
        'user_id', 'title', 'slug', 'description', 'client', 'location',
        'completed_date', 'budget', 'category', 'thumbnail', 'gallery', 'is_featured',
        // New calculator fields
        'client_name', 'client_email', 'client_phone', 'project_address',
        'status', 'subtotal', 'tax_amount', 'discount_amount', 'total_amount',
        'coupon_id', 'valid_until', 'notes'
    ];

    protected $casts = [
        'gallery' => 'array',
        'completed_date' => 'date',
        'budget' => 'decimal:2',
        'is_featured' => 'boolean',
        'subtotal' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'valid_until' => 'datetime',
    ];

    // Accessor for 'name' to use 'title'
    public function getNameAttribute()
    {
        return $this->title;
    }

    // Mutator for 'name' to set 'title'
    public function setNameAttribute($value)
    {
        $this->attributes['title'] = $value;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(ProjectItem::class)->orderBy('sort_order');
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function calculateTotals()
    {
        $subtotal = $this->items->sum('total_price');
        $taxRate = 0.18; // 18% GST
        $taxAmount = $subtotal * $taxRate;
        
        $discountAmount = 0;
        if ($this->coupon_id && $this->coupon) {
            $discountAmount = $this->coupon->calculateDiscount($subtotal);
        }

        $total = $subtotal + $taxAmount - $discountAmount;

        $this->update([
            'subtotal' => $subtotal,
            'tax_amount' => $taxAmount,
            'discount_amount' => $discountAmount,
            'total_amount' => max(0, $total),
        ]);

        return $this;
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'draft' => 'secondary',
            'quoted' => 'info',
            'approved' => 'success',
            'completed' => 'primary',
            'cancelled' => 'danger',
        ];
        return $badges[$this->status] ?? 'secondary';
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}