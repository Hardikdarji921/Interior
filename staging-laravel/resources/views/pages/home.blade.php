@extends('layouts.app')

@section('title', 'Staging - Interior Design Agency')

@section('content')

<!-- Hero Section Begin -->
@include('partials.hero-slider')
<!-- Hero Section End -->

<!-- Services Section Begin -->
@include('partials.services-section')
<!-- Services Section End -->

<!-- About Section Begin -->
<section class="about spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="about__text">
                    <div class="section-title">
                        <span>Who are we</span>
                        <h2>We propose and discuss design rules</h2>
                    </div>
                    <p>Metasurfaces are generally designed by placing scatterers in periodic or pseudo-periodic 
                    grids. We propose and discuss design rules for functional metasurfaces with randomly 
                    placed. Anisotropic elements that randomly sample. Quisque sit amet nisl ante.</p>
                    <a href="{{ route('about') }}" class="primary-btn">Learn More</a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about__pic">
                    <div class="about__pic__inner">
                        <img src="{{ asset('img/about-pic.jpg') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- About Section End -->

<!-- Project Section Begin -->
@include('partials.projects-section')
<!-- Project Section End -->

<!-- Counter Section Begin -->
<section class="counter spad set-bg" data-setbg="{{ asset('img/counter-bg.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="counter__item">
                    <div class="counter__number">
                        <h2 class="count">85</h2>
                    </div>
                    <p>Projects Completed</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="counter__item">
                    <div class="counter__number">
                        <h2 class="count">127</h2>
                    </div>
                    <p>Happy Clients</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="counter__item">
                    <div class="counter__number">
                        <h2 class="count">36</h2>
                    </div>
                    <p>Awards Received</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="counter__item">
                    <div class="counter__number">
                        <h2 class="count">74</h2>
                    </div>
                    <p>Coffee Cups</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Counter Section End -->

<!-- Testimonial Section Begin -->
@include('partials.testimonial-section')
<!-- Testimonial Section End -->

<!-- Call To Action Section Begin -->
@include('partials.call-to-action')
<!-- Call To Action Section End -->

<!-- Blog Section Begin -->
@include('partials.blog-section')
<!-- Blog Section End -->

@endsection

@push('scripts')
<script>
    // Counter Up
    $('.count').each(function () {
        $(this).prop('Counter', 0).animate({
            Counter: $(this).text()
        }, {
            duration: 4000,
            easing: 'swing',
            step: function (now) {
                $(this).text(Math.ceil(now));
            }
        });
    });
</script>
@endpush
