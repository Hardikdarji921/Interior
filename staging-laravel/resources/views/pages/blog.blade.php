@extends('layouts.app')

@section('title', 'Blog - Staging')

@section('content')

@include('components.breadcrumb', ['title' => 'Our Blog'])

<!-- Blog Section Begin -->
<section class="blog spad">
    <div class="container">
        <div class="row">
            @foreach($posts as $post)
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="blog__item">
                    <div class="blog__item__pic set-bg" data-setbg="{{ asset('storage/' . $post->featured_image) }}">
                        <div class="label">{{ $post->published_at->format('M d, Y') }}</div>
                    </div>
                    <div class="blog__item__text">
                        <ul>
                            <li><i class="fa fa-user"></i> {{ $post->author_name }}</li>
                            <li><i class="fa fa-eye"></i> {{ $post->views }} views</li>
                        </ul>
                        <h5><a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a></h5>
                        <p>{{ Str::limit($post->excerpt, 120) }}</p>
                        <a href="{{ route('blog.show', $post->slug) }}">Read more</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="row">
            <div class="col-lg-12">
                {{ $posts->links('components.pagination') }}
            </div>
        </div>
    </div>
</section>
<!-- Blog Section End -->

@endsection
