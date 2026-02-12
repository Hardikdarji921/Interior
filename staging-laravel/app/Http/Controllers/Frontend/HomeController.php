<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Project;
use App\Models\BlogPost;
use App\Models\Testimonial;

class HomeController extends Controller
{
    public function index()
    {
        $services = Service::where('is_active', true)

                          ->orderBy('order')

                          ->take(6)

                          ->get();

        
        $featuredProjects = Project::where('is_featured', true)

                                   ->latest()

                                   ->take(6)

                                   ->get();

        
        $latestPosts = BlogPost::whereNotNull('published_at')

                               ->where('published_at', '<=', now())

                               ->latest('published_at')

                               ->take(3)

                               ->get();

        
        $testimonials = Testimonial::where('is_active', true)

                                   ->inRandomOrder()

                                   ->take(5)

                                   ->get();

        return view('pages.home', compact(
            'services', 'featuredProjects', 'latestPosts', 'testimonials'
        ));
    }
}
