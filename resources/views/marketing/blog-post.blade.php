<x-app-marketing-layout>
    
<div class="detail_blog">
    <div class="container">
        <div class="detail_wrap">
            <h4>{{ $blog->getTranslation('excerpt', 'es') }}</h4>
            {{-- <h4>{{ $blog->getTranslation('excerpt', session('locale', 'es')) }}</h4> --}}
            <span>{{ \Carbon\Carbon::parse($blog->created_at)->format('F d, Y') }}</span>
            <div class="images">
                <img src="{{ $blog->blog_image_url }}" alt="detail">
            </div>
            {!! $blog->getTranslation('body', 'es') !!}
            {{-- {!! $blog->getTranslation('body', session('locale', 'es')) !!} --}}
        </div>
    </div>
</div>

</x-app-marketing-layout>