<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use App\Models\Material;
use App\Models\MaterialCategory;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index()
    {
        $materials = Material::with('category')
            ->latest()
            ->paginate(20);
        
        return view('admin.materials.index', compact('materials'));
    }

    public function create()
    {
        $categories = MaterialCategory::active()->get();
        return view('admin.materials.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:material_categories,id',
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:materials',
            'description' => 'nullable|string',
            'base_price' => 'required|numeric|min:0',
            'brand' => 'nullable|string|max:100',
            'image' => 'nullable|image|max:2048',
            'specifications' => 'nullable|array',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('materials', 'public');
        }

        Material::create($validated);

        return redirect()->route('admin.materials.index')
            ->with('success', 'Material created successfully');
    }

    public function edit(Material $material)
    {
        $categories = MaterialCategory::active()->get();
        return view('admin.materials.edit', compact('material', 'categories'));
    }

    public function update(Request $request, Material $material)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:material_categories,id',
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:materials,slug,' . $material->id,
            'description' => 'nullable|string',
            'base_price' => 'required|numeric|min:0',
            'brand' => 'nullable|string|max:100',
            'image' => 'nullable|image|max:2048',
            'specifications' => 'nullable|array',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('materials', 'public');
        }

        $material->update($validated);

        return redirect()->route('admin.materials.index')
            ->with('success', 'Material updated successfully');
    }

    public function destroy(Material $material)
    {
        $material->delete();
        return back()->with('success', 'Material deleted');
    }
}