@extends('layouts.app')

@section('title', 'Contact Us - Staging')

@section('content')

@include('components.breadcrumb', ['title' => 'Contact Us'])

<!-- Contact Section Begin -->
<section class="contact spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-5">
                <div class="contact__text">
                    <div class="section-title">
                        <span>Information</span>
                        <h2>Contact Details</h2>
                    </div>
                    <p>As you might expect of a company that began as a high-end interiors contractor, we pay strict 
                    attention.</p>
                    <ul>
                        <li>
                            <span class="icon_pin_alt"></span>
                            <p>7176 Blue Spring Lane, Santa Monica, CA 90403</p>
                        </li>
                        <li>
                            <span class="icon_phone"></span>
                            <p>+84 123 456 789</p>
                        </li>
                        <li>
                            <span class="icon_mail_alt"></span>
                            <p>info@staging.com</p>
                        </li>
                    </ul>
                    <div class="contact__social">
                        <a href="#"><i class="fa fa-facebook"></i></a>
                        <a href="#"><i class="fa fa-twitter"></i></a>
                        <a href="#"><i class="fa fa-instagram"></i></a>
                        <a href="#"><i class="fa fa-linkedin"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="contact__form">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    <form action="{{ route('contact.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <input type="text" name="name" placeholder="Your Name" value="{{ old('name') }}" required>
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <input type="email" name="email" placeholder="Your Email" value="{{ old('email') }}" required>
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-lg-12">
                                <input type="text" name="subject" placeholder="Subject" value="{{ old('subject') }}" required>
                                @error('subject')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-lg-12">
                                <textarea name="message" placeholder="Your Message" required>{{ old('message') }}</textarea>
                                @error('message')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <button type="submit" class="site-btn">Send Message</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Contact Section End -->

<!-- Map Section Begin -->
<div class="map">
    <iframe 
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3305.715220363292!2d-118.2453201849866!3d34.05223418060604!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80c2c648fa1d4803%3A0xdec27bf11f9fd336!2sLos%20Angeles%2C%20CA%2C%20USA!5e0!3m2!1sen!2s!4v1635959567400!5m2!1sen!2s" 
        width="100%" 
        height="500" 
        style="border:0;" 
        allowfullscreen="" 
        loading="lazy">
    </iframe>
</div>
<!-- Map Section End -->

@endsection
