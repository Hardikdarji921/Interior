<!-- Blog Section Begin -->
<section class="latest spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <span>Latest News</span>
                    <h2>From our blog</h2>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach($latestPosts as $post)
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="blog__item">
                    <div class="blog__item__pic set-bg" data-setbg="{{ asset('storage/' . $post->featured_image) }}">
                        <div class="label">{{ $post->created_at->format('M d, Y') }}</div>
                    </div>
                    <div class="blog__item__text">
                        <h5><a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a></h5>
                        <p>{{ Str::limit($post->excerpt, 100) }}</p>
                        <a href="{{ route('blog.show', $post->slug) }}">Read more</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
<!-- Blog Section End -->
