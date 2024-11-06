<div class="row">
    @if($blogs->isNotEmpty())
        @foreach($blogs as $blog)
            <div class="col-lg-4 col-md-6">
                <a href="{{ route('blog.post', $blog->slug) }}" class="imgtext">
                    <div class="image">
                        <img src="{{ $blog->blog_image_url }}" alt="business">
                    </div>
                    <div class="textbox">
                       {{--  <span>{{ $blog->getTranslation('title', session('locale', 'es')) }}</span>
                        <h6>{{ $blog->getTranslation('excerpt', session('locale', 'es')) }}</h6> --}}
                        <span>{{ $blog->getTranslation('title', 'es') }}</span>
                        <h6>{{ $blog->getTranslation('excerpt', 'es') }}</h6>
                        <p>{{ $blog->created_at->format('d / m / Y'); }}</p>
                    </div>
                </a>
            </div>
        @endforeach
    @else
        <div class="col-md-12">
            No blogs yet!
        </div>    
    @endif
</div>