@extends('layouts.app')

@section('title', 'Our Services - Staging')

@section('content')

@include('components.breadcrumb', ['title' => 'Our Services'])

<!-- Services Section Begin -->
<section class="services spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <span>Our specialization</span>
                    <h2>What we do</h2>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach($services as $service)
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="services__item">
                    <img src="{{ asset('img/services/' . $service->icon) }}" alt="{{ $service->title }}">
                    <h4>{{ $service->title }}</h4>
                    <p>{{ $service->description }}</p>
                    <a href="{{ route('services.show', $service->slug) }}">Read more</a>
                </div>
            </div>
            @endforeach
        </div>
        <div class="row">
            <div class="col-lg-12">
                {{ $services->links('components.pagination') }}
            </div>
        </div>
    </div>
</section>
<!-- Services Section End -->

@endsection
