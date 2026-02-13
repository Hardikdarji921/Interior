<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 'description', 'type', 'value', 'min_order_amount',
        'max_discount', 'usage_limit', 'usage_per_user',
        'starts_at', 'expires_at', 'is_active', 'applicable_categories'
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'min_order_amount' => 'decimal:2',
        'max_discount' => 'decimal:2',
        'applicable_categories' => 'array',
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function isValid($orderAmount = 0, $userId = null)
    {
        $now = Carbon::now();

        // Check active status
        if (!$this->is_active) return false;

        // Check date range
        if ($now < $this->starts_at || $now > $this->expires_at) return false;

        // Check minimum order amount
        if ($orderAmount < $this->min_order_amount) return false;

        // Check total usage limit
        if ($this->usage_limit !== null) {
            $usedCount = Project::where('coupon_id', $this->id)->whereNotNull('coupon_id')->count();
            if ($usedCount >= $this->usage_limit) return false;
        }

        // Check per-user limit
        if ($userId && $this->usage_per_user) {
            $userUsedCount = Project::where('user_id', $userId)
                ->where('coupon_id', $this->id)
                ->count();
            if ($userUsedCount >= $this->usage_per_user) return false;
        }

        return true;
    }

    public function calculateDiscount($amount)
    {
        if ($this->type === 'percentage') {
            $discount = $amount * ($this->value / 100);
            if ($this->max_discount && $discount > $this->max_discount) {
                return $this->max_discount;
            }
            return $discount;
        }

        // Fixed amount
        return min($this->value, $amount);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where('starts_at', '<=', Carbon::now())
            ->where('expires_at', '>=', Carbon::now());
    }
}