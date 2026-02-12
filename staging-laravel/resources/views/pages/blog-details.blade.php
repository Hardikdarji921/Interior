@extends('layouts.app')

@section('title', $post->title . ' - Staging Blog')

@section('meta_description', Str::limit($post->excerpt, 160))

@section('content')

@include('components.breadcrumb', ['title' => 'Blog Details'])

<!-- Blog Details Section Begin -->
<section class="blog-details spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="blog__details__content">
                    <div class="blog__details__pic">
                        <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}">
                        <div class="label">{{ $post->published_at->format('M d, Y') }}</div>
                    </div>
                    <div class="blog__details__text">
                        <ul class="blog__details__tags">
                            <li><i class="fa fa-user"></i> {{ $post->author_name }}</li>
                            <li><i class="fa fa-clock-o"></i> {{ $post->published_at->format('M d, Y') }}</li>
                            <li><i class="fa fa-eye"></i> {{ $post->views }} views</li>
                        </ul>
                        <h2>{{ $post->title }}</h2>
                        <div class="content">
                            {!! $post->content !!}
                        </div>
                    </div>
                    <div class="blog__details__share">
                        <span>Share:</span>
                        <a href="#"><i class="fa fa-facebook"></i></a>
                        <a href="#"><i class="fa fa-twitter"></i></a>
                        <a href="#"><i class="fa fa-linkedin"></i></a>
                        <a href="#"><i class="fa fa-pinterest"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="blog__sidebar">
                    <div class="blog__sidebar__search">
                        <form action="#">
                            <input type="text" placeholder="Search...">
                            <button type="submit"><i class="fa fa-search"></i></button>
                        </form>
                    </div>
                    <div class="blog__sidebar__recent">
                        <h5>Recent Posts</h5>
                        @foreach($relatedPosts as $related)
                        <a href="{{ route('blog.show', $related->slug) }}" class="blog__sidebar__recent__item">
                            <div class="blog__sidebar__recent__item__pic">
                                <img src="{{ asset('storage/' . $related->featured_image) }}" alt="" width="70">
                            </div>
                            <div class="blog__sidebar__recent__item__text">
                                <h6>{{ Str::limit($related->title, 40) }}</h6>
                                <span>{{ $related->published_at->format('M d, Y') }}</span>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Blog Details Section End -->

@endsection
