<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Project;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::latest()->paginate(9);
        $categories = Project::distinct()->pluck('category');
        
        return view('pages.projects', compact('projects', 'categories'));
    }

    public function show(Project $project)
    {
        $relatedProjects = Project::where('category', $project->category)

                                  ->where('id', '!=', $project->id)

                                  ->take(3)

                                  ->get();

        
        return view('pages.project-details', compact('project', 'relatedProjects'));
    }
}
