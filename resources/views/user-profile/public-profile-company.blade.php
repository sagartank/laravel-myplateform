<x-app-layout>
    @section('pageTitle', 'Profile Payer')
    @section('custom_style')
        <link href="{{ asset('plugins/carousel/owl.carousel.min.css')}}" rel="stylesheet">
        <style>
            .evt_is_favorites.active i svg path {
                fill:#DC3545;
            }
            .issuer_rating li {
                max-width : 100% !important;
            }
            .d-none-review {
                display: none
            }
            .img_rotate img {
                transform: rotate(180deg)
            }
        </style>
    @endsection

    @php
        $is_favorites = $issuer->favorites->count() > 0 ? 'active' : '';
    @endphp

    <div class="profile_page">
        <div class="container">
            <div class="profile_title">
                <div class="title">
                    <a href="javascript:;" class="evt_back_history_button">
                        <img src="{{ asset('images/mipo/dashboardsubpageleft.svg') }}" class="day" alt="no-image">
                        <img src="{{ asset('images/mipo/white_lft_aro.svg') }}" class="night" alt="no-image">
                    </a>
                    <h5 class="text-24-semibold">{{ __('Public Payer') }}</h5>
                </div>
                <div class="btnbox_section">
                    <div class="claim_wrap">
                        <a href="javascript:;" class="text-14-medium">{!! __('Claim Profile') !!}</a>
                    </div>
                    <div class="mob_fav_sec evt_is_favorites {{ $is_favorites }}" role="button">
                        <i>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M19.4974 12.5717L11.9974 19.9997L4.49737 12.5717C4.00268 12.0903 3.61301 11.5117 3.35292 10.8723C3.09282 10.2329 2.96793 9.54664 2.98611 8.85662C3.00428 8.1666 3.16513 7.48782 3.45853 6.86303C3.75192 6.23823 4.17151 5.68094 4.69086 5.22627C5.21021 4.77159 5.81808 4.42938 6.47618 4.22117C7.13429 4.01296 7.82838 3.94327 8.51474 4.01649C9.2011 4.08971 9.86487 4.30425 10.4642 4.64659C11.0636 4.98894 11.5856 5.45169 11.9974 6.00569C12.4109 5.45571 12.9335 4.99701 13.5325 4.65829C14.1314 4.31958 14.7939 4.10814 15.4783 4.03721C16.1627 3.96628 16.8545 4.03739 17.5101 4.24608C18.1658 4.45477 18.7714 4.79656 19.2889 5.25005C19.8064 5.70354 20.2248 6.25897 20.5178 6.88158C20.8108 7.50419 20.9721 8.18057 20.9917 8.8684C21.0112 9.55622 20.8886 10.2407 20.6315 10.8789C20.3744 11.5172 19.9883 12.0955 19.4974 12.5777" fill="#E5E5E5"/>
                            </svg>
                            {{-- <img src="{{ asset('images/mipo/localprofile-img1.svg') }}" alt="no-image"> --}}
                        </i>
                    </div>
                    <div class="mob_export_section evt_download_pdf_company"  data-href="{{ route('profile.public-payer-profile-pdf') }}"
                        data-company-slug="{{ $issuer->slug }}">
                        <img src={{ asset('images/mipo/mobileexportbtn.svg') }} alt="no-image">
                    </div>
                    <div class="export_wrap">
                        <a href="javascript:;" class="text-14-medium evt_download_pdf_company"
                        data-href="{{ route('profile.public-payer-profile-pdf') }}"
                        data-company-slug="{{ $issuer->slug }}">
                            <i><img src="{{ asset('images/mipo/publicexport.svg') }}" alt="no-image"></i>
                            {!! __('Export') !!}
                        </a>
                    </div>
                </div>
            </div>
            <div class="pro_wrap_section">
                <div class="row">
                    <div class="col-lg-3 col-md-4">
                        <div class="identity_box">
                            <div class="person_box">
                                <div class="person_img">
                                    <img src="{{ $issuer->company_image_url }}" alt="no-image">
                                </div>
                                <div class="person_name">
                                    <h6 class="text-16-medium">{!! __('Commercial Name') !!}</h6>
                                    <p class="text-14-medium">{{ $issuer->commercial_name }}</p>
                                </div>
                            </div>
                            <div class="more_detail">
                            {{--  <div class="detail">
                                    <p class="text-14-medium">{!! __('Country') !!}:</p>
                                    <span class="text-14-medium">{!! __('Paraguay') !!}</span>
                                </div> --}}
                                <div class="detail">
                                    <p class="text-14-medium">{!! __('City name') !!}:</p>
                                    <span class="text-14-medium">{{ $issuer->city?->name }}</span>
                                </div>
                                <div class="detail">
                                    <p class="text-14-medium">{!! __('RUC') !!}:</p>
                                    <span class="text-14-medium">{{ $issuer->ruc_code }}</span>
                                </div>
                                <div class="detail">
                                    <p class="text-14-medium">{!! __('Date of Registry') !!}:</p>
                                    <span class="text-14-medium">{{ $issuer->registered_at }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
        
                    <div class="col-lg-9 col-md-8">
                        <div class="public_caption pubpro_sec">
                            <div class="left_part">
                                <div class="name_box">
                                    <h5 class="text-20-medium">{{ $issuer->company_name }}</h5>
                                    <div class="rating text-16-medium">
                                        <i><img src="{{ asset('images/mipo/public-img2.svg') }}" alt="no-image"></i>
                                        {{ floor($issuer->ratings_avg_rating_number) }}{!! __('/5') !!} ({{ floor($issuer->ratings_count) }})
                                    </div>
                                </div>
                                <div class="company text-14-medium">{{ $issuer->industry_type }}</div>
                            </div>
                            <a href="javascript:;" class="mobile_show_btn text-14-medium evt_web_open_chat">
                                {!! __('Suggest more info') !!}
                                <i><img src="{{ asset('images/mipo/public-img3.svg') }}" alt="no-image"></i>
                            </a>
                            <div class="right_part">
                                <div class="favorite_sec text-16-medium evt_is_favorites {{ $is_favorites }}" role="button">
                                    <i>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M19.4974 12.5717L11.9974 19.9997L4.49737 12.5717C4.00268 12.0903 3.61301 11.5117 3.35292 10.8723C3.09282 10.2329 2.96793 9.54664 2.98611 8.85662C3.00428 8.1666 3.16513 7.48782 3.45853 6.86303C3.75192 6.23823 4.17151 5.68094 4.69086 5.22627C5.21021 4.77159 5.81808 4.42938 6.47618 4.22117C7.13429 4.01296 7.82838 3.94327 8.51474 4.01649C9.2011 4.08971 9.86487 4.30425 10.4642 4.64659C11.0636 4.98894 11.5856 5.45169 11.9974 6.00569C12.4109 5.45571 12.9335 4.99701 13.5325 4.65829C14.1314 4.31958 14.7939 4.10814 15.4783 4.03721C16.1627 3.96628 16.8545 4.03739 17.5101 4.24608C18.1658 4.45477 18.7714 4.79656 19.2889 5.25005C19.8064 5.70354 20.2248 6.25897 20.5178 6.88158C20.8108 7.50419 20.9721 8.18057 20.9917 8.8684C21.0112 9.55622 20.8886 10.2407 20.6315 10.8789C20.3744 11.5172 19.9883 12.0955 19.4974 12.5777" fill="#E5E5E5"/>
                                        </svg>
                                        {{-- <img src="{{ asset('images/mipo/localprofile-img1.svg') }}" alt="no-image"> --}}
                                    </i>
                                    {!! __('Favorites') !!}
                                </div>

                                <a href="javascript:;" class="show_btn text-14-medium evt_web_open_chat">
                                    {!! __('Suggest more info') !!}
                                    <i><img src="{{ asset('images/mipo/public-img3.svg') }}" alt="no-image"></i>
                                </a>
                            </div>
                        </div>
                        <div class="public_caption public_info">
                            <h6 class="text-16-semibold">{!! __('Information') !!}</h6>
                            <p class="text-16-medium">{!! $issuer->basic_info !!}</p>
                        </div>
                        @php
                        $sold = $unsold = $draft = $rejected = $approved = $pending = $openDisputes = $solvedDisputes = 0;
                        if (isset($offers_status_dashboard) && $offers_status_dashboard->count()) {
                            $soldApproved = $offers_status_dashboard?->where('offer_status', 'Approved')->first()?->total_offer_status;
                            $soldCompleted = $offers_status_dashboard?->where('offer_status', 'Completed')->first()?->total_offer_status;
                            $sold = $soldApproved + $soldCompleted;

                            $solvedDisputes = $deal_disputes_dashboard->deals_disputes->where('resolved_by', '1')->count();
                            $openDisputes = $deal_disputes_dashboard->deals_disputes->count();

                        }
                        if (isset($operations_status_dashboard) && $operations_status_dashboard->count()) {
                            $draft = $operations_status_dashboard?->where('operations_status', 'Draft')->first()?->total_operations_status;
                            $rejected = $operations_status_dashboard?->where('operations_status', 'Rejected')->first()?->total_operations_status;
                            $approved = $operations_status_dashboard?->where('operations_status', 'Approved')->first()?->total_operations_status;
                            $unsold = $approved;
                            $pending = $operations_status_dashboard?->where('operations_status', 'Pending')->first()?->total_operations_status;

                        }
                    @endphp
                        <div class="public_caption public_chart">
                            <div class="row">
                                <div class="col-lg-4 col-6">
                                    <div class="public_data_block">
                                        <div class="text">
                                            <p class="text-20-medium">{{  ($approved - $sold)  }}</p>
                                        </div>
                                        <h6 class="text-14-medium">{!! __('Available Documents') !!}</h6>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-6">
                                    <div class="public_data_block">
                                        <div class="text">
                                            <p class="text-20-medium">{{  $sold  }}</p>
                                        </div>
                                        <h6 class="text-14-medium">{!! __('Documents Sold') !!}</h6>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-6">
                                    <div class="public_data_block">
                                        <div class="text">
                                            <p class="text-20-medium">{{ $sold + $unsold }}</p>
                                        </div>
                                        <h6 class="text-14-medium">{!! __('Historic Operations') !!}</h6>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-6">
                                    <div class="public_data_block">
                                        <div class="text">
                                            <p class="text-20-medium">{{ $unsold }}</p>
                                        </div>
                                        <h6 class="text-14-medium">{!! __('Unsold Operations') !!}</h6>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-6">
                                    <div class="public_data_block">
                                        <div class="text">
                                            <p class="text-20-medium">{{ ($openDisputes - $solvedDisputes) }}</p>
                                        </div>
                                        <h6 class="text-14-medium">{!! __('Open Disputes') !!}</h6>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-6">
                                    <div class="public_data_block">
                                        <div class="text">
                                            <p class="text-20-medium">{{ $solvedDisputes }}</p>
                                        </div>
                                        <h6 class="text-14-medium">{!! __('Solved Disputes') !!}</h6>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-6">
                                    <div class="public_data_block">
                                        <div class="text">
                                            <p class="text-20-medium">{{ round($average_issuer_rating_days, 2) ?? 0 }}</p>
                                        </div>
                                        <h6 class="text-14-medium">{!! __('Average Day Delay in Payment') !!}</h6>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-6">
                                    <div class="public_data_block">
                                        <div class="text">
                                            <p class="text-20-medium">{{ round($average_retention, 2) ?? 0 }}%</p>
                                        </div>
                                        <h6 class="text-14-medium">{!! __('Average Retention') !!}</h6>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-6">
                                    <div class="public_data_block">
                                    @php
                                            $usd_amount_avg =  $average_operation_values->where('preferred_currency', config('constants.CURRENCY_TYPE')[0])->avg('amount');
                                            $gs_amount_avg = $average_operation_values->where('preferred_currency', config('constants.CURRENCY_TYPE')[1])->avg('amount');
                                        @endphp
                                        <div class="text">
                                            <p class="text-20-medium">{!! ('USD') !!} {{ round($usd_amount_avg, 2) ?? 0 }}</p>
                                            <p class="text-20-medium">{!! ('GS') !!} {{ round($gs_amount_avg, 2) ?? 0 }}</p>
                                        </div>
                                        <h6 class="text-14-medium">{!! __('Transactional Average') !!}</h6>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-6">
                                    <div class="public_data_block">
                                        <div class="text">
                                            <p class="text-20-medium high_red">{!! $average_discount !!} %</p>
                                        </div>
                                        <h6 class="text-14-medium">{!! __('Average Discount') !!}</h6>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-6">
                                    <div class="public_data_block">
                                        <div class="text">
                                            <p class="text-20-medium">{!! ($issuer->registry_in_mipo == 'Yes') ? __('Yes') : __('No') !!}</p>
                                        </div>
                                        <div class="img">
                                            <i><img src="{{ asset('images/mipo/public-img4.svg') }}" alt="no-image"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-6">
                                    <div class="public_data_block">
                                        <div class="text">
                                            <p class="text-20-medium">{!! ($issuer->verified_address == 'Yes') ? __('Yes') : __('No') !!}</p>
                                        </div>
                                        <h6 class="text-14-medium">{!! __('Verified Address') !!}</h6>
                                    </div>
                                </div>
                                <div class="col-lg-8 col-12">
                                    <div class="chart_content">
                                        <div class="content">
                                            <h6 class="text-20-medium">{!! __('Available Documents') !!}</h6>
                                            <p class="text-14-medium">{!! __('By Type') !!}</p>
                                        </div>
                                        <div class="chart">
                                            <canvas id="pie_chart"></canvas>
                                            {{-- <img src="{{ asset('images/mipo/public-img5.png') }}" alt="no-image"> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="public_caption public_additional">
                            <h6 class="text-16-semibold">{!! __('Additional Information') !!}</h6>
                            {{-- <p class="text-16-medium">{!! __('Carnicos y Lacteos') !!}: 0%</p> --}}
                            {!! $issuer->additional_info !!}
                        </div>
                        <div class="public_caption public_review">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="investor_review">
                                        @php
                                        $one_rat = $issuer->ratings->whereBetween('rating_number', [0.5, 1]);
                                        $two_rat = $issuer->ratings->whereBetween('rating_number', [1.5, 2]);
                                        $three_rat = $issuer->ratings->whereBetween('rating_number', [2.5, 3]);
                                        $four_rat = $issuer->ratings->whereBetween('rating_number', [3.5, 4]);
                                        $five_rat = $issuer->ratings->whereBetween('rating_number', [4.5, 5]);

                                        $total_rating_user = ($one_rat->count() + $two_rat->count() + $three_rat->count() + $four_rat->count() + $five_rat->count());
                                        $total_rating_user = ($total_rating_user > 0 ? $total_rating_user : 1);

                                        $five_rat_user = floor((($five_rat->count() * 100) / $total_rating_user));
                                        $four_rat_user = floor((($four_rat->count() * 100) / $total_rating_user));
                                        $three_rat_user = floor((($three_rat->count() * 100) / $total_rating_user));
                                        $two_rat_user = floor((($two_rat->count() * 100) / $total_rating_user));
                                        $one_rat_user = floor((($one_rat->count() * 100) / $total_rating_user));

                                        $total_avg = floor($issuer->ratings->pluck('rating_number')->avg());

                                        @endphp
                                        <h3 class="text-16-semibold">{!! __('Investor Reviews') !!}:</h3>
                                        <div class="rate_star text-16-medium">
                                            <ul class="issuer_rating">
                                                <li><img src="{{ app('common')->issuerRatingImage($total_avg) }}" alt="no-image"></li>
                                            {{--  <li><img src="{{ asset('images/mipo/public-img6.svg') }}" alt="no-image"></li>
                                                <li><img src="{{ asset('images/mipo/public-img8.svg') }}" alt="no-image"></li>
                                                <li><img src="{{ asset('images/mipo/public-img7.svg') }}" alt="no-image"></li>
                                                <li><img src="{{ asset('images/mipo/public-img7.svg') }}" alt="no-image"></li> --}}
                                            </ul>
                                            {{ $total_avg }} {!! __('of') !!} 5
                                        </div>
                                        <h4 class="text-16-medium">{{ $total_rating_user }} {!! __('Ratings') !!}</h4>
                                        <div class="progress_section">
                                
                                            <div class="prog_wrap">
                                                <h6 class="text-16-medium">5 {!! __('stars') !!}</h6>
                                                <div class="progress" role="progressbar" aria-label="warning example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                                    <div class="progress-bar" style="width: {{ $five_rat_user }}%"></div>
                                                </div>
                                                <h6 class="text-16-medium"> {{ $five_rat_user }}%</h6>
                                            </div>
                        
                                            <div class="prog_wrap">
                                                <h6 class="text-16-medium">4 {!! __('stars') !!}</h6>
                                                <div class="progress" role="progressbar" aria-label="warning example" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                                                    <div class="progress-bar" style="width: {{ $four_rat_user }}%"></div>
                                                </div>
                                                <h6 class="text-16-medium">{{ $four_rat_user }}%</h6>
                                            </div>
                                            
                                            <div class="prog_wrap">
                                                <h6 class="text-16-medium">3 {!! __('stars') !!}</h6>
                                                <div class="progress" role="progressbar" aria-label="warning example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                                    <div class="progress-bar" style="width: {{ $three_rat_user }}%"></div>
                                                </div>
                                                <h6 class="text-16-medium">{{ $three_rat_user }}%</h6>
                                            </div>

                                            <div class="prog_wrap">
                                                <h6 class="text-16-medium">2 {!! __('stars') !!}</h6>
                                                <div class="progress" role="progressbar" aria-label="warning example" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                    <div class="progress-bar" style="width: {{ $two_rat_user }}%"></div>
                                                </div>
                                                <h6 class="text-16-medium">{{ $two_rat_user }}%</h6>
                                            </div>

                                            <div class="prog_wrap">
                                                <h6 class="text-16-medium">1 {!! __('stars') !!}</h6>
                                                <div class="progress" role="progressbar" aria-label="warning example" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                    <div class="progress-bar" style="width: {{ $one_rat_user }}%"></div>
                                                </div>
                                                <h6 class="text-16-medium">{{ $one_rat_user }}%</h6>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="multi_reviews">
                                        @if ($issuer->ratings->count() > 0)
                                            @foreach ($issuer->ratings->take(5) as $key => $issuer_rating)
                                                <div class="multi_section">
                                                <p class="text-14-medium">{{  app('common')->displayStart($issuer_rating->rating_by_user->name) }}</p>
                                                <div class="rate_block text-14-medium">
                                                    {{ $issuer_rating->rating_number }}
                                                    <ul>
                                                        <li><img src="{{ app('common')->issuerRatingImage($issuer_rating->rating_number) }}" alt="no-image"></li>
                                                    </ul>
                                                </div>
                                                <span class="text-14-medium">{{  $issuer_rating->feedback_description }}</span>
                                            </div>
                                            @endforeach
                                            @foreach ($issuer->ratings->skip(5) as $key => $issuer_rating)
                                                <div class="multi_section skip_data_show_review d-none-review">
                                                    <p class="text-14-medium">{{  app('common')->displayStart($issuer_rating->rating_by_user->name) }}</p>
                                                    <div class="rate_block text-14-medium">
                                                        {{ $issuer_rating->rating_number }}
                                                        <ul>
                                                            <li><img src="{{ app('common')->issuerRatingImage($issuer_rating->rating_number) }}" alt="no-image"></li>
                                                        </ul>
                                                    </div>
                                                    <span class="text-14-medium">{{  $issuer_rating->feedback_description }}</span>
                                                </div>
                                            @endforeach
                                            @if($issuer->ratings->count() > 5 )
                                                <div class="show_btn">
                                                    <a href="javascript:;" class="text-14-medium">
                                                        <span class="show_more_review">{!! __('Show more') !!}</span>
                                                        <i class="add_img_rotate"><img src="{{ asset('images/mipo/public-img9.svg') }}" alt="no-image"></i>
                                                    </a>
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if($issuer->issuers_attach_images->count() > 0)
                            <div class="public_caption public_main_wrapper">
                                <div class="public_slider owl-carousel">
                                    @forelse ($issuer->issuers_attach_images as $issuer_attach_image)
                                    <div class="public_img">
                                        <img src="{{ $issuer_attach_image->issuers_attach_image_url }}" alt="no-image">
                                    </div>
                                    @empty
                                        <p>{{ __('No Slider Image')}}</p>
                                    @endforelse
                                </div>
                            </div>
                        @endif

                        <div class="public_caption public_news_section">
                            <h6 class="text-20-semibold">{!! __('Related news') !!}</h6>
                            <div class="row">
                                @forelse ($blogs as $blog)
                                        <div class="col-lg-4 col-md-6">
                                            <a href="{{ route('blog.post', $blog->slug) }}" class="news_box">
                                                <div class="news_img">
                                                    <div class="img">
                                                        <img src="{{ $blog->blog_image_url }}" alt="no-image">
                                                    </div>
                                                    <div class="date_box">
                                                        <p class="text-14-semibold">{{ $blog->created_at->format('d') }} <br> {{ strtoupper($blog->created_at->format('M')) }}</p>
                                                    </div>
                                                </div>
                                                <div class="news_text">
                                                    <h6 class="text-14-semibold">{!! $blog->getTranslation('title', 'es') !!}</h6>
                                                    <p class="text-14-medium">{!! $blog->getTranslation('excerpt', 'es') !!}</p>
                                                    <span class="text-14-medium">
                                                        {!! __('Read more') !!}
                                                        <i><img src="{{ asset('images/mipo/public-img14.svg') }}" alt="no-image"></i>
                                                    </span>
                                                </div>
                                            </a>
                                        </div>
                                    @empty
                                        <p>{{ __('No Blog')}}</p>
                                    @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('custom_script')
        <script src="{{ asset('plugins/chart/chart.min.js') }}"></script>
        <script src="{{ asset('js/suggestion_claim.js') }}"></script>
        <script>
            const issuer_id = '{{ $issuer->id }}';
            const pichart_labels = {!! json_encode($pichart_labels) !!};
            const pichart_data = {!! json_encode($pichart_data) !!};
            $(document).ready(function() {
                const data = {
                    labels: pichart_labels,
                    datasets: [{
                        label: 'OPERATIONS',
                        data: pichart_data,
                        backgroundColor: [
                            'rgb(13, 110, 253, 1.0)',
                            'rgb(220,53,69,1.0)',
                            'rgb(13, 110, 253, 0.8)',
                            'rgb(220,53,69, 0.8)',
                            'rgb(13, 110, 253, 0.6)',
                            'rgb(220,53,69,0.6)',
                            'rgb(13, 110, 253, 0.4)',
                            'rgb(220,53,69, 0.4)',
                        ],
                        hoverOffset: 4
                    }]
                };
                new Chart(document.getElementById('pie_chart'), {
                    type: 'pie',
                    data: data,
                    options: {
                        plugins: {
                            responsive: true,
                            legend: {
                                position: 'bottom',
                            },
                        }
                    }
                });

                $('.evt_is_favorites').click(function(e) {
                    e.preventDefault();
                    setLoadin();
                    var self = $(this);
                    $.ajax({
                        type: "POST",
                        url: "{{ route('favourite.store') }}",
                        data: {
                            'issuer_id': issuer_id,
                            'type': 'issuer'
                        },
                        dataType: 'json',
                        cache: false,
                        success: function(res) {
                            unsetLoadin();
                            if (res.status == true) {
                                if (self.hasClass('active')) {
                                    self.removeClass('active');
                                } else {
                                    self.addClass('active');
                                }
                                toastr.success(res.message);
                            } else {
                                toastr.error(res.message);
                            }
                        },
                        error: function(xhr) {
                            unsetLoadin();
                            ajaxErrorMsg(xhr);
                        }
                    });
                });
            });

            $(document).on('click', '.evt_download_pdf_company', function(e) {
                e.preventDefault();
                var self = $(this);
                var route_url = self.attr('data-href');
                var company_slug = self.attr('data-company-slug');
                var form_data = [];

                form_data.push({
                    name: "company_slug",
                    value: company_slug
                },
                {
                    name: "action",
                    value: 'pdf'
                }
                );

                ajax_pdf(route_url, 'POST', form_data, randomString());
            });

            $(document).on('click', '.show_more_review', function(e) {
                e.preventDefault();
                var flag_  = $('.skip_data_show_review').toggle('slow');
                setTimeout(() => {
                    if($('.skip_data_show_review').is(':hidden')) {
                    $(this).text(shw_more_en_msg);
                    $('.add_img_rotate').removeClass('img_rotate');
                } else {
                    $('.add_img_rotate').addClass('img_rotate');
                    $(this).text(shw_less_en_msg);
                }
                }, 1000);
            });
        </script>
    @endsection
</x-app-layout>
