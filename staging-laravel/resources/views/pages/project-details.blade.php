@extends('layouts.app')

@section('title', $project->title . ' - Staging')

@section('meta_description', Str::limit($project->description, 160))

@section('content')

@include('components.breadcrumb', ['title' => 'Project Details'])

<!-- Project Details Section Begin -->
<section class="project-details spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="project__details__content">
                    <div class="project__details__pic">
                        <img src="{{ asset('storage/' . $project->thumbnail) }}" alt="{{ $project->title }}">
                    </div>
                    <div class="project__details__text">
                        <h2>{{ $project->title }}</h2>
                        <p>{{ $project->description }}</p>
                        
                        @if($project->gallery)
                        <div class="project__gallery__slider owl-carousel">
                            @foreach($project->gallery as $image)
                            <div class="project__gallery__item">
                                <img src="{{ asset('storage/' . $image) }}" alt="">
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="project__sidebar">
                    <div class="project__sidebar__about">
                        <h4>Project Information</h4>
                        <ul>
                            <li><span>Client:</span> {{ $project->client ?? 'Private' }}</li>
                            <li><span>Location:</span> {{ $project->location ?? 'Not specified' }}</li>
                            <li><span>Date:</span> {{ $project->completed_date ? $project->completed_date->format('F Y') : 'Ongoing' }}</li>
                            <li><span>Budget:</span> {{ $project->budget ? '$' . number_format($project->budget) : 'Confidential' }}</li>
                            <li><span>Category:</span> {{ $project->category }}</li>
                        </ul>
                    </div>
                    <div class="project__sidebar__help">
                        <h4>Need help?</h4>
                        <p>Contact us for more information about this project or to discuss your own project.</p>
                        <a href="{{ route('contact') }}" class="primary-btn">Contact Us</a>
                    </div>
                </div>
            </div>
        </div>
        
        @if($relatedProjects->count() > 0)
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title mt-5">
                    <span>Similar Projects</span>
                    <h2>Related works</h2>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach($relatedProjects as $related)
            <div class="col-lg-4 col-md-6">
                <div class="project__item">
                    <div class="project__item__pic set-bg" data-setbg="{{ asset('storage/' . $related->thumbnail) }}">
                    </div>
                    <div class="project__item__text">
                        <h5><a href="{{ route('projects.show', $related->slug) }}">{{ $related->title }}</a></h5>
                        <span>{{ $related->category }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</section>
<!-- Project Details Section End -->

@endsection
