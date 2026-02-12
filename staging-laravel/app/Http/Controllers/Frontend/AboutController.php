<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;

class AboutController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::where('is_active', true)

                                   ->inRandomOrder()

                                   ->take(3)

                                   ->get();

        
        return view('pages.about', compact('testimonials'));
    }
}
