<!-- Testimonial Section Begin -->
<section class="testimonial spad set-bg" data-setbg="{{ asset('img/testimonial-bg.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="section-title">
                    <span>Testimonials</span>
                    <h2>What your clients say</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="testimonial__carousel">
                    @foreach($testimonials as $testimonial)
                    <div class="testimonial__item">
                        <div class="row d-flex justify-content-center">
                            <div class="col-xl-9 col-lg-10">
                                <p>“{{ $testimonial->content }}”</p>
                                <div class="testimonial__client__info">
                                    <h5>{{ $testimonial->client_name }}</h5>
                                    <span>{{ $testimonial->client_position }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="row d-flex justify-content-center">
            <div class="col-xl-6 col-lg-8 col-md-7 col-sm-10">
                <div class="testimonial__client">
                    @foreach($testimonials as $testimonial)
                    <div class="testimonial__client__pic {{ $loop->first ? 'active' : '' }}">
                        <img src="{{ asset('storage/' . ($testimonial->avatar ?? 'img/testimonial/default-avatar.jpg')) }}" alt="">
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Testimonial Section End -->
