<?php

namespace App\Services;

use App\Models\Material;
use App\Models\ColorOption;
use App\Models\CalculationHistory;
use App\Models\Coupon;
use App\Models\Project;
use App\Models\ProjectItem;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class CalculatorService
{
    /**
     * Calculate material cost with optional coupon
     */
    public function calculate(int $materialId, float $quantity, ?int $colorOptionId = null, ?string $projectName = null, ?string $couponCode = null): array
    {
        $material = Material::with('category')->findOrFail($materialId);
        
        // Get unit price based on color selection
        $unitPrice = $material->getPriceForColor($colorOptionId, $quantity);
        
        // Calculate subtotal
        $subtotal = $unitPrice * $quantity;
        
        // Apply coupon if provided
        $coupon = null;
        $discountAmount = 0;
        
        if ($couponCode) {
            $coupon = Coupon::where('code', $couponCode)->first();
            if ($coupon && $coupon->isValid($subtotal, Auth::id())) {
                // Check if coupon applies to this category
                if (empty($coupon->applicable_categories) || 
                    in_array($material->category_id, $coupon->applicable_categories)) {
                    $discountAmount = $coupon->calculateDiscount($subtotal);
                }
            }
        }
        
        // Apply tax (GST 18%)
        $taxRate = 0.18;
        $taxableAmount = $subtotal - $discountAmount;
        $taxAmount = $taxableAmount * $taxRate;
        
        // Calculate total
        $totalCost = $taxableAmount + $taxAmount;

        // Build breakdown
        $breakdown = [
            'material_name' => $material->name,
            'category' => $material->category->name,
            'quantity' => $quantity,
            'unit' => $material->category->unit_type,
            'unit_price' => $unitPrice,
            'subtotal' => $subtotal,
            'coupon_code' => $couponCode,
            'discount_amount' => $discountAmount,
            'tax_rate' => $taxRate * 100,
            'tax_amount' => $taxAmount,
            'total_cost' => $totalCost,
            'color' => null,
        ];
        
        // Add color details if selected
        if ($colorOptionId) {
            $color = ColorOption::find($colorOptionId);
            if ($color) {
                $breakdown['color'] = [
                    'name' => $color->name,
                    'hex_code' => $color->hex_code,
                    'finish_type' => $color->finish_type,
                ];
            }
        }

        // Save to history
        $this->saveCalculation($materialId, $colorOptionId, $quantity, $unitPrice, $totalCost, $breakdown, $projectName);

        return [
            'success' => true,
            'material' => $material,
            'calculation' => $breakdown,
            'coupon_applied' => $coupon && $discountAmount > 0,
        ];
    }

    /**
     * Add item to project
     */
    public function addToProject(int $projectId, array $itemData): ProjectItem
    {
        $project = Project::findOrFail($projectId);
        
        $material = Material::findOrFail($itemData['material_id']);
        $colorOption = isset($itemData['color_option_id']) ? ColorOption::find($itemData['color_option_id']) : null;
        
        $unitPrice = $material->getPriceForColor($colorOption?->id, $itemData['quantity']);
        
        $item = ProjectItem::create([
            'project_id' => $projectId,
            'material_id' => $itemData['material_id'],
            'color_option_id' => $itemData['color_option_id'] ?? null,
            'quantity' => $itemData['quantity'],
            'unit_type' => $material->category->unit_type,
            'unit_price' => $unitPrice,
            'total_price' => $unitPrice * $itemData['quantity'],
            'specifications' => $itemData['specifications'] ?? null,
            'notes' => $itemData['notes'] ?? null,
            'sort_order' => $project->items()->count(),
        ]);

        // Recalculate project totals
        $project->calculateTotals();

        return $item;
    }

    /**
     * Validate and apply coupon to project
     */
    public function applyCoupon(Project $project, string $couponCode): array
    {
        $coupon = Coupon::where('code', $couponCode)->first();

        if (!$coupon) {
            return ['success' => false, 'message' => 'Invalid coupon code'];
        }

        if (!$coupon->isValid($project->subtotal, $project->user_id)) {
            return ['success' => false, 'message' => 'Coupon is expired or invalid'];
        }

        // Check category restrictions
        if (!empty($coupon->applicable_categories)) {
            $projectCategories = $project->items()
                ->with('material.category')
                ->get()
                ->pluck('material.category_id')
                ->unique()
                ->toArray();

            $hasValidCategory = count(array_intersect($projectCategories, $coupon->applicable_categories)) > 0;
            
            if (!$hasValidCategory) {
                return ['success' => false, 'message' => 'Coupon not applicable to items in this project'];
            }
        }

        $project->update(['coupon_id' => $coupon->id]);
        $project->calculateTotals();

        $discount = $coupon->calculateDiscount($project->subtotal);

        return [
            'success' => true,
            'message' => 'Coupon applied successfully',
            'discount' => $discount,
            'new_total' => $project->total_amount,
        ];
    }

    /**
     * Calculate paint specifically (with area dimensions)
     */
    public function calculatePaint(float $width, float $height, int $coats = 2, ?int $colorOptionId = null, ?int $materialId = null): array
    {
        // Calculate area
        $area = $width * $height;
        $totalArea = $area * $coats;
        
        // Get default paint material if not specified
        if (!$materialId) {
            $material = Material::whereHas('category', function($q) {
                $q->where('slug', 'paint');
            })->first();
            $materialId = $material?->id;
        }
        
        if (!$materialId) {
            throw new \Exception('No paint material found');
        }
        
        return $this->calculate($materialId, $totalArea, $colorOptionId, 'Wall Painting Project');
    }

    /**
     * Calculate furniture cost
     */
    public function calculateFurniture(int $materialId, int $pieces, ?int $colorOptionId = null): array
    {
        return $this->calculate($materialId, $pieces, $colorOptionId, 'Furniture Purchase');
    }

    /**
     * Save calculation to history
     */
    private function saveCalculation(int $materialId, ?int $colorOptionId, float $quantity, float $unitPrice, float $totalCost, array $breakdown, ?string $projectName): void
    {
        $data = [
            'material_id' => $materialId,
            'color_option_id' => $colorOptionId,
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'total_cost' => $totalCost,
            'breakdown' => $breakdown,
            'project_name' => $projectName,
        ];
        
        // Add user ID if authenticated
        if (auth()->check()) {
            $data['user_id'] = auth()->id();
        } else {
            $data['session_id'] = Session::getId();
        }
        
        CalculationHistory::create($data);
    }

    /**
     * Get calculation history for current user/session
     */
    public function getHistory(int $limit = 10): \Illuminate\Database\Eloquent\Collection
    {
        $query = CalculationHistory::with(['material', 'colorOption']);
        
        if (auth()->check()) {
            $query->where('user_id', auth()->id());
        } else {
            $query->where('session_id', Session::getId());
        }
        
        return $query->latest()->limit($limit)->get();
    }

    /**
     * Compare multiple materials
     */
    public function compare(array $materialIds, float $quantity): array
    {
        $results = [];
        
        foreach ($materialIds as $id) {
            $calc = $this->calculate($id, $quantity);
            $results[] = $calc['calculation'];
        }
        
        // Sort by total cost
        usort($results, function($a, $b) {
            return $a['total_cost'] <=> $b['total_cost'];
        });
        
        return $results;
    }
}