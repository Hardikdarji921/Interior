<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use App\Models\ColorOption;
use App\Models\MaterialCategory;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function index()
    {
        $colors = ColorOption::with('category')->latest()->paginate(20);
        return view('admin.colors.index', compact('colors'));
    }

    public function create()
    {
        $categories = MaterialCategory::where('has_color_options', true)->get();
        return view('admin.colors.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:material_categories,id',
            'name' => 'required|string|max:100',
            'hex_code' => 'required|string|size:7|starts_with:#',
            'color_code' => 'nullable|string|max:50',
            'price_multiplier' => 'nullable|numeric|min:0.1|max:10',
            'fixed_price' => 'nullable|numeric|min:0',
            'finish_type' => 'nullable|string|max:50',
        ]);

        ColorOption::create($validated);

        return redirect()->route('admin.colors.index')
            ->with('success', 'Color option created');
    }

    public function edit(ColorOption $color)
    {
        $categories = MaterialCategory::where('has_color_options', true)->get();
        return view('admin.colors.edit', compact('color', 'categories'));
    }

    public function update(Request $request, ColorOption $color)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:material_categories,id',
            'name' => 'required|string|max:100',
            'hex_code' => 'required|string|size:7|starts_with:#',
            'price_multiplier' => 'nullable|numeric|min:0.1|max:10',
            'fixed_price' => 'nullable|numeric|min:0',
            'finish_type' => 'nullable|string|max:50',
            'is_active' => 'boolean',
        ]);

        $color->update($validated);

        return redirect()->route('admin.colors.index')
            ->with('success', 'Color updated');
    }

    public function destroy(ColorOption $color)
    {
        $color->delete();
        return back()->with('success', 'Color deleted');
    }
}