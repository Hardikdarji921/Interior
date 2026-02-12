<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;

class BlogController extends Controller
{
    public function index()
    {
        $posts = BlogPost::whereNotNull('published_at')

                         ->where('published_at', '<=', now())

                         ->latest('published_at')

                         ->paginate(6);

        
        return view('pages.blog', compact('posts'));
    }

    public function show(BlogPost $post)
    {
        $post->increment('views');
        
        $relatedPosts = BlogPost::where('id', '!=', $post->id)

                                ->latest('published_at')

                                ->take(3)

                                ->get();

        
        return view('pages.blog-details', compact('post', 'relatedPosts'));
    }
}
