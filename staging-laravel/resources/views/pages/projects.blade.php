@extends('layouts.app')

@section('title', 'Our Projects - Staging')

@section('content')

@include('components.breadcrumb', ['title' => 'Our Projects'])

<!-- Project Section Begin -->
<section class="project">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="section-title">
                    <span>Our works</span>
                    <h2>Latest projects</h2>
                </div>
                <div class="project__filter">
                    <ul>
                        <li class="active" data-filter="*">All</li>
                        @foreach($categories as $category)
                        <li data-filter=".{{ Str::slug($category) }}">{{ $category }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="row project__gallery">
            @foreach($projects as $project)
            <div class="col-lg-4 col-md-6 col-sm-6 mix {{ Str::slug($project->category) }}">
                <div class="project__item">
                    <div class="project__item__pic set-bg" data-setbg="{{ asset('storage/' . $project->thumbnail) }}">
                        <a href="{{ asset('storage/' . $project->thumbnail) }}" class="hover__item portfolio-btn"><i class="fa fa-search"></i></a>
                    </div>
                    <div class="project__item__text">
                        <h5><a href="{{ route('projects.show', $project->slug) }}">{{ $project->title }}</a></h5>
                        <span>{{ $project->category }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="row">
            <div class="col-lg-12">
                {{ $projects->links('components.pagination') }}
            </div>
        </div>
    </div>
</section>
<!-- Project Section End -->

@endsection

@push('scripts')
<script>
    // Mixitup filter
    var containerEl = document.querySelector('.project__gallery');
    var mixer = mixitup(containerEl);
</script>
@endpush
