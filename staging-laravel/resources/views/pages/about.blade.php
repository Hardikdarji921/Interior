@extends('layouts.app')

@section('title', 'About Us - Staging')

@section('content')

@include('components.breadcrumb', ['title' => 'About Us'])

<!-- About Section Begin -->
<section class="about spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="about__text">
                    <div class="section-title">
                        <span>About us</span>
                        <h2>We are the best interior design agency in the world</h2>
                    </div>
                    <p>Metasurfaces are generally designed by placing scatterers in periodic or pseudo-periodic 
                    grids. We propose and discuss design rules for functional metasurfaces with randomly 
                    placed. Anisotropic elements that randomly sample. Quisque sit amet nisl ante.</p>
                    <p>Fusce mattis nunc lacus, vulputate facilisis dui efficitur ut. Vestibulum sit amet metus 
                    euismod, condimentum lectus id, ultrices sem. Morbi in erat malesuada, sollicitudin massa at.</p>
                    <a href="{{ route('services') }}" class="primary-btn">Our Services</a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about__pic">
                    <div class="about__pic__inner">
                        <img src="{{ asset('img/about/about-1.jpg') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- About Section End -->

<!-- Team Section Begin -->
<section class="team spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="section-title">
                    <span>Our Team</span>
                    <h2>Meet our team</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="team__item">
                    <img src="{{ asset('img/team/team-1.jpg') }}" alt="">
                    <h5>John Smith</h5>
                    <span>CEO & Founder</span>
                    <div class="team__item__social">
                        <a href="#"><i class="fa fa-facebook"></i></a>
                        <a href="#"><i class="fa fa-twitter"></i></a>
                        <a href="#"><i class="fa fa-instagram"></i></a>
                        <a href="#"><i class="fa fa-linkedin"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="team__item">
                    <img src="{{ asset('img/team/team-2.jpg') }}" alt="">
                    <h5>Sarah Johnson</h5>
                    <span>Lead Designer</span>
                    <div class="team__item__social">
                        <a href="#"><i class="fa fa-facebook"></i></a>
                        <a href="#"><i class="fa fa-twitter"></i></a>
                        <a href="#"><i class="fa fa-instagram"></i></a>
                        <a href="#"><i class="fa fa-linkedin"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="team__item">
                    <img src="{{ asset('img/team/team-3.jpg') }}" alt="">
                    <h5>Michael Brown</h5>
                    <span>Architect</span>
                    <div class="team__item__social">
                        <a href="#"><i class="fa fa-facebook"></i></a>
                        <a href="#"><i class="fa fa-twitter"></i></a>
                        <a href="#"><i class="fa fa-instagram"></i></a>
                        <a href="#"><i class="fa fa-linkedin"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Team Section End -->

@include('partials.testimonial-section')

@endsection
