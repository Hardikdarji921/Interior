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
                    <p>{{ Str::limit($service->description, 100) }}</p>
                    <a href="{{ route('services.show', $service->slug) }}">Read more</a>
                </div>
            </div>
            @endforeach
        </div>
        <div class="counter__content">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="counter__item">
                        <div class="counter__number">
                            <h2 class="count">85</h2>
                            <span>Projects</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="counter__item">
                        <div class="counter__number">
                            <h2 class="count">127</h2>
                            <span>Clients</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="counter__item">
                        <div class="counter__number">
                            <h2 class="count">36</h2>
                            <span>Awards</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Services Section End -->
