<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Routing\Controller;
use App\Services\CalculatorService;
use App\Models\MaterialCategory;
use App\Models\Material;
use App\Models\ColorOption;
use Illuminate\Http\Request;

class CalculatorController extends Controller
{
    protected $calculator;

    public function __construct(CalculatorService $calculator)
    {
        $this->calculator = $calculator;
    }

    /**
     * Show calculator page
     */
    public function index()
    {
        $categories = MaterialCategory::active()
            ->with(['materials' => function($q) {
                $q->active();
            }, 'colorOptions' => function($q) {
                $q->active();
            }])
            ->orderBy('order')
            ->get();

        $history = $this->calculator->getHistory(5);

        return view('pages.calculator', compact('categories', 'history'));
    }

    /**
     * Calculate material cost (AJAX)
     */
    public function calculate(Request $request)
    {
        $validated = $request->validate([
            'material_id' => 'required|exists:materials,id',
            'quantity' => 'required|numeric|min:0.01',
            'color_option_id' => 'nullable|exists:color_options,id',
            'project_name' => 'nullable|string|max:255',
            'width' => 'nullable|numeric|min:0', // For paint calculations
            'height' => 'nullable|numeric|min:0',
            'coats' => 'nullable|integer|min:1|max:5',
        ]);

        try {
            // If width and height provided, calculate paint
            if ($request->filled('width') && $request->filled('height')) {
                $result = $this->calculator->calculatePaint(
                    $request->width,
                    $request->height,
                    $request->coats ?? 2,
                    $request->color_option_id,
                    $request->material_id
                );
            } else {
                $result = $this->calculator->calculate(
                    $request->material_id,
                    $request->quantity,
                    $request->color_option_id,
                    $request->project_name
                );
            }

            return response()->json([
                'success' => true,
                'data' => $result,
                'html' => view('partials.calculation-result', ['calc' => $result['calculation']])->render()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * Quick calculate for specific category
     */
    public function quickCalculate($categorySlug)
    {
        $category = MaterialCategory::where('slug', $categorySlug)
            ->with(['materials' => function($q) {
                $q->active();
            }, 'colorOptions' => function($q) {
                $q->active();
            }])
            ->firstOrFail();

        return view('pages.calculator-quick', compact('category'));
    }

    /**
     * Get colors for material (AJAX)
     */
    public function getColors($materialId)
    {
        $material = Material::with('category.colorOptions')->findOrFail($materialId);
        
        $colors = $material->category->colorOptions ?? collect();

        return response()->json([
            'has_colors' => $material->category->has_color_options,
            'colors' => $colors
        ]);
    }

    /**
     * Get calculation history
     */
    public function history()
    {
        $history = $this->calculator->getHistory(50);
        return view('pages.calculator-history', compact('history'));
    }

    /**
     * Compare materials
     */
    public function compare(Request $request)
    {
        $validated = $request->validate([
            'material_ids' => 'required|array|min:2|max:4',
            'material_ids.*' => 'exists:materials,id',
            'quantity' => 'required|numeric|min:0.01',
        ]);

        $results = $this->calculator->compare(
            $request->material_ids,
            $request->quantity
        );

        return response()->json([
            'success' => true,
            'comparisons' => $results
        ]);
    }
}