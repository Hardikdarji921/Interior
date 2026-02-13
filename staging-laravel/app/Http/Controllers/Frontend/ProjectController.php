<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Routing\Controller;
use App\Models\Project;
use App\Models\ProjectItem;
use App\Models\Material;
use App\Models\ColorOption;
use App\Services\CalculatorService;
use App\Services\PdfService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    protected $calculator;
    protected $pdfService;

    public function __construct(CalculatorService $calculator, PdfService $pdfService)
    {
        $this->calculator = $calculator;
        $this->pdfService = $pdfService;
    }

    public function index()
    {
        $projects = Project::forUser(Auth::id())
            ->withCount('items')
            ->latest()
            ->paginate(10);

        return view('pages.projects.index', compact('projects'));
    }

    public function create()
    {
        return view('pages.projects.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'client_name' => 'nullable|string|max:255',
            'client_email' => 'nullable|email',
            'client_phone' => 'nullable|string|max:20',
            'project_address' => 'nullable|string',
            'valid_until' => 'nullable|date|after:today',
        ]);

        $project = Project::create(array_merge($validated, [
            'user_id' => Auth::id(),
            'valid_until' => $validated['valid_until'] ?? now()->addDays(30),
        ]));

        return redirect()->route('projects.show', $project)
            ->with('success', 'Project created successfully. Start adding items!');
    }

    public function show(Project $project)
    {
        $this->authorize('view', $project);
        
        $project->load(['items.material.category', 'items.colorOption', 'coupon']);
        
        // Get available materials for adding new items
        $categories = \App\Models\MaterialCategory::active()
            ->with(['materials' => function($q) { $q->active(); }, 'colorOptions'])
            ->get();

        return view('pages.projects.show', compact('project', 'categories'));
    }

    public function addItem(Request $request, Project $project)
    {
        $this->authorize('update', $project);

        $validated = $request->validate([
            'material_id' => 'required|exists:materials,id',
            'color_option_id' => 'nullable|exists:color_options,id',
            'quantity' => 'required|numeric|min:0.01',
            'room_name' => 'nullable|string|max:100',
            'dimensions' => 'nullable|string|max:100',
            'notes' => 'nullable|string',
        ]);

        $specifications = [];
        if ($request->room_name) $specifications['room'] = $request->room_name;
        if ($request->dimensions) $specifications['dimensions'] = $request->dimensions;

        $itemData = array_merge($validated, ['specifications' => $specifications]);
        
        $this->calculator->addToProject($project->id, $itemData);

        return back()->with('success', 'Item added to project');
    }

    public function removeItem(Project $project, ProjectItem $item)
    {
        $this->authorize('update', $project);
        
        $item->delete();
        $project->calculateTotals();

        return back()->with('success', 'Item removed');
    }

    public function applyCoupon(Request $request, Project $project)
    {
        $this->authorize('update', $project);

        $request->validate(['coupon_code' => 'required|string']);

        $result = $this->calculator->applyCoupon($project, $request->coupon_code);

        if ($result['success']) {
            return back()->with('success', 'Coupon applied! You saved ₹' . number_format($result['discount'], 2));
        }

        return back()->with('error', $result['message']);
    }

    public function downloadQuotation(Project $project)
    {
        $this->authorize('view', $project);
        
        return $this->pdfService->streamQuotation($project);
    }

    public function updateStatus(Request $request, Project $project)
    {
        $this->authorize('update', $project);

        $validated = $request->validate([
            'status' => 'required|in:draft,quoted,approved,completed,cancelled',
        ]);

        $project->update($validated);

        return back()->with('success', 'Project status updated');
    }

    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);
        
        $project->delete();
        return redirect()->route('projects.index')->with('success', 'Project deleted');
    }
}