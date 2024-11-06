
<x-app-marketing-layout>
    @section('pageTitle', 'About')
    <div class="work about_work">
        <div class="container">
            <div class="work_wrap">
                <div class="title">
                    <h3>{{ __('How does Mipo work') }}?</h3>
                    <p>{{ __('Step by step tutorial that you can understand when you first use Mipo apps') }}.</p>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="accordion" id="accordionExample">
                            @if($homeSlides->isNotEmpty())
                                @foreach($homeSlides as $key => $homeSlide)
                                <div class="accordion-item upload-platform evt_home_slide_img" data-home-slide-img="{{ $homeSlide->gif_image_url }}">
                                    <h4 class="accordion-header">
                                        <button class="accordion-button {{ ($key == 0) ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne_{{ $key }}" aria-expanded="true" aria-controls="collapseOne">
                                            {{ $homeSlide->getTranslation('title', session('locale', 'es')) }}
                                        </button>
                                    </h4>
                                    <div id="collapseOne_{{ $key }}" class="accordion-collapse collapse {{ ($key == 0) ? 'show' : '' }}" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <p>{{ $homeSlide->getTranslation('text', session('locale', 'es')) }}</p>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6">
                        @if($homeSlides->isNotEmpty())
                            @foreach($homeSlides as $key => $homeSlide)
                                @if($key == 0)
                                    <div class="work-img platform">
                                        <img id="set-home-slide-img" src="{{ $homeSlide->gif_image_url }}" alt="gif">
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="mobile_work">
                    @if($homeSlides->isNotEmpty())
                        @foreach($homeSlides as $key => $homeSlide)
                            <div class="mobi_section">
                                <div class="image">
                                    <img src="{{ $homeSlide->gif_image_url }}" alt="mipo-work">
                                </div>
                                <h4>{{ $homeSlide->getTranslation('title', session('locale', 'es')) }}</h4>
                                <p>{{ $homeSlide->getTranslation('text', session('locale', 'es')) }}</p>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="borrower_investor">
        <div class="container">
            <div class="boin_wrap">
                <div class="row">
                    <div class="col-lg-6">
                        {{-- <div class="borrower_part">
                            <div class="title">
                                <h3>{{ __('Seller') }}</h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent convallis viverra ante a consectetur.</p>
                                <div class="buy_btn">
                                    <a href="javascript:;">{{ __('For Seller') }} <i><img src="{{ asset('images/marketing/left-arrow.svg') }}" alt="left"></i></a>
                                </div>
                            </div>
                            <div class="borrower_img">
                                <img src="{{ asset('images/marketing/borrower-img.webp') }}" alt="borrower">
                            </div>
                        </div> --}}

                        <div class="borrower_part">
                            <div class="title">
                                <h3>{{ $howToWork->getTranslation('heading_text_seller', session('locale', 'es')) }}</h3>
                                <p>
                                    {{ $howToWork->getTranslation('sub_heading_text_seller', session('locale', 'es')) }}
                                </p>
                                <div class="buy_btn">
                                    <a href="javascript:;">
                                        {{ $howToWork->getTranslation('button_text_seller', session('locale', 'es')) }}
                                        <i><img src="{{ asset('images/marketing/left-arrow.svg') }}" width="24" height="24" alt="left"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="borrower_img">
                                <img src="{{ $howToWork->seller_image_url }}" alt="borrower">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                       {{--  <div class="borrower_part">
                            <div class="title">
                                <h3>{{ __('Buyer') }}</h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent convallis viverra ante a consectetur.</p>
                                <div class="buy_btn">
                                    <a href="javascript:;">{{ __('For Buyer') }} <i><img src="{{ asset('images/marketing/left-arrow.svg') }}" alt="left"></i></a>
                                </div>
                            </div>
                            <div class="borrower_img">
                                <img src="{{ asset('images/marketing/investor-img.webp')}}" alt="investor">
                            </div>
                        </div> --}}
                        <div class="borrower_part">
                            <div class="title">
                                <h3>{{ $howToWork->getTranslation('heading_text_buyer', session('locale', 'es')) }}</h3>
                                <p>
                                    {{ $howToWork->getTranslation('sub_heading_text_buyer', session('locale', 'es')) }}
                                </p>
                                <div class="buy_btn">
                                    <a href="javascript:;"> {{ $howToWork->getTranslation('button_text_buyer', session('locale', 'es')) }}<i><img src="{{ asset('images/marketing/left-arrow.svg') }}" width="24" height="24" alt="left"></i></a>
                                </div>
                            </div>
                            <div class="borrower_img">
                                <img src="{{ $howToWork->buyer_image_url }}" alt="investor">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="av_device">
        <div class="container">
            <div class="device_wrap">
                <div class="title_box">
                    <h2>{{ __('Mipo now available on all your devices') }}</h2>
                </div>
                <ul>
                    <li><a href="javascript:;"><img src="{{ asset('images/marketing/Microsoft.svg') }}" alt="microsoft"></a></li>
                    <li><a href="javascript:;"><img src="{{ asset('images/marketing/Apple.svg') }}" alt="apple"></a></li>
                    <li><a href="javascript:;"><img src="{{ asset('images/marketing/android.svg') }}" alt="android"></a></li>
                </ul>
                <div class="download_btn">
                    <a href="javascript:;">{{ __('Download Here') }}</a>
                </div>
                <div class="webapp_btn">
                    <a href="javascript:;"><img src="{{ asset('images/marketing/webapp.svg') }}" alt="webapp"></a>
                </div>
            </div>
        </div>
    </div>
</x-app-marketing-layout>