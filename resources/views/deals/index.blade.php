<x-app-layout>
    @section('pageTitle', 'Deals')
    @section('custom_style')
        <link href="{{ asset('plugins/select2-4.1.0-rc.0/dist/css/select2.min.css') }}" rel="stylesheet">
        <link href="{{ asset('plugins/carousel/owl.carousel.min.css') }}" rel="stylesheet">
        <link href="{{ asset('plugins/intl-tel-input-17.0.19/build/css/intlTelInput.min.css') }}" rel="stylesheet" />
        <style>
            .skl_deal_list{
                height: 114px;
                margin: 0px 0px 4px 0px;
            }
        </style>
    @endsection

    @php
        $preferred_currency_val = Auth()->user()->preferred_currency ?? 'USD';
        $preferred_dashboard_val = Auth()->user()->preferred_dashboard ?? 'Borrower';
    @endphp
    <div class="main_deals">
        <div class="container">
            <div class="deals_wrapper">
                <div class="left_deals_sidebar">
                    @include('deals.sidebar')
                </div>
                <div class="right_deals_content">
                    <div class="deals_tabs_header">
                        <h3 class="text-24-semibold">{!! __('Deals') !!}</h3>
                        <div class="sort_block">
                            <div class="select-dd">
                                <span class="label text-14-medium">{!! __('Sort by') !!}:</span>
                                <select name="sort_type_lates_deals" id="sort_type_operation" class="form-select nice_selectbox selectbox text-14-semibold">
                                    <option value="DESC">{!! __('Newest') !!}</option>
                                    <option value="amount_desc">{{ __('High to low') }}</option>
                                    <option value="amount_asc">{{ __('Low to high') }}</option>
                                    <option value="ASC">{!! __('Oldest') !!}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mobile_deals" id="deal_list_side_bar_modal">
                        <div class="mob_title">
                            <a href="javascript:void(0)">
                                <svg width="28" height="28" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g id="sort 1">
                                        <g id="Group">
                                            <path id="Vector" d="M15.0013 10.8327H5.0013C4.5013 10.8327 4.16797 10.4993 4.16797 9.99935C4.16797 9.49935 4.5013 9.16602 5.0013 9.16602H15.0013C15.5013 9.16602 15.8346 9.49935 15.8346 9.99935C15.8346 10.4993 15.5013 10.8327 15.0013 10.8327Z" fill="#0D6EFD"/>
                                        </g>
                                        <g id="Group_2">
                                            <path id="Vector_2" d="M12.5013 15.8327H7.5013C7.0013 15.8327 6.66797 15.4993 6.66797 14.9993C6.66797 14.4993 7.0013 14.166 7.5013 14.166H12.5013C13.0013 14.166 13.3346 14.4993 13.3346 14.9993C13.3346 15.4993 13.0013 15.8327 12.5013 15.8327Z" fill="#0D6EFD"/>
                                        </g>
                                        <g id="Group_3">
                                            <path id="Vector_3" d="M17.5013 5.83268H2.5013C2.0013 5.83268 1.66797 5.49935 1.66797 4.99935C1.66797 4.49935 2.0013 4.16602 2.5013 4.16602H17.5013C18.0013 4.16602 18.3346 4.49935 18.3346 4.99935C18.3346 5.49935 18.0013 5.83268 17.5013 5.83268Z" fill="#0D6EFD"/>
                                        </g>
                                    </g>
                                </svg>
                            </a>
                            <h3 class="text-20-semibold">{!! __('Deals') !!}</h3>
                        </div>
                        @include('deals.mobile-sidebar')
                        <div class="mobile_operations_right">
                            <div class="mob_createbtn evt_refresh_icon" data-device-type="mob"><img src="{{ asset('images/mipo/deals-img15.svg') }}" alt="no-image"></div>
                        </div>
                    </div>
                    <div class="deals_tabs">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a href="#buyer" class="nav-link" id="nav_buy" data-active-name="buyer" data-bs-toggle="tab" data-bs-target="#buyer">{!! __('Bought') !!}</a>
                            </li>
                            <li class="nav-item">
                                <a href="#seller" class="nav-link" id="nav_sell" data-active-name="seller" data-bs-toggle="tab" data-bs-target="#seller">{!! __('Sold') !!}</a>
                            </li>
                        </ul>
                        <div class="update_box">
                            <a href="javascript:;" class="up-box text-14-medium evt_refresh_icon" data-device-type="dst"><i><img src="{{ asset('images/mipo/deals-img1.svg') }}" alt="no-image"></i>{!! __('Update') !!}</a>
                        </div>
                        <div class="mobile_shortby">
                            <a href="javascript:;" class="light"><img src="{{ asset('images/mipo/shortbymobile.svg') }}" alt="no-image"></a>
                            <a href="javascript:;" class="dark"><img src="{{ asset('images/mipo/mobilewhitesorting.svg') }}" alt="no-image"></a>
                            <div class="backdrop_blurbg">
                                <div class="mobile_fade">
                                    <div class="mobile_content">
                                        <div class="mobile_modal_header">
                                            <h5 class="text-18-semibold">{!! __('SORT BY') !!}</h5>
                                            <a href="javascript:;" class="light"><img src="{{ asset('images/mipo/mobileshortclosebtn.svg') }}" alt="no-image"></a>
                                            <a href="javascript:;" class="dark"><img src="{{ asset('images/mipo/mobileshortdarkclosebtn.svg') }}" alt="no-image"></a>
                                        </div>
                                        <div class="mobile_modal_body">
                                            <div class="radio_wrap">
                                                <label for="opert_curr_usd_6" class="text-16-medium">{!! __('Newest') !!}</label>
                                                <input type="radio" name="preferred_currency[]" value="USD" id="opert_curr_usd_6">
                                            </div>
                                            <div class="radio_wrap">
                                                <label for="opert_curr_usd_7" class="text-16-medium">{!! __('Oldest') !!}</label>
                                                <input type="radio" name="preferred_currency[]" value="USD" id="opert_curr_usd_7">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="deals_textbox" class="tab-content">
                        <div class="tab-pane fade" id="buyer">
                            <div id="ajax_deals_list_buyer"></div>
                            {{-- <div class="deals_bought_caption">
                                <div class="left_part">
                                    <div class="cap_box">
                                        <a href="javascript:;" class="name text-14-medium">{!! __('CHEQUE - OP0001') !!}</a>
                                        <span class="cash text-14-medium">{!! __('Cash') !!}</span>
                                        <a href="javascript:;" class="seller_name text-14-medium">{!! __('John Doe') !!}</a>
                                        <span class="seller_btn text-12-medium">{!! __('Seller') !!}</span>
                                        <i><img src="{{ asset('images/mipo/deals-img2.svg') }}" alt="no-image"></i>
                                        <a href="javascript:;" class="payer_name text-14-medium">{!! __('Arya Kagathara') !!}</a>
                                    </div>
                                    <a href="javascript:;" class="company_name text-14-medium">{!! __('Cocacola Soda Ltd.') !!}</a>
                                    <div class="imagesbox">
                                        <ul class="first">
                                            <li class="text-14-medium">
                                                <i class="light"><img src="{{ asset('images/mipo/deals-img3.svg') }}" alt="no-image"></i>
                                                <i class="dark"><img src="{{ asset('images/mipo/deals-img13.svg') }}" alt="no-image"></i>
                                                {!! __('Con Recurso') !!}
                                            </li>
                                            <li class="text-14-medium">
                                                <i class="light"><img src="{{ asset('images/mipo/deals-img4.svg') }}" alt="no-image"></i>
                                                <i class="dark"><img src="{{ asset('images/mipo/deals-img14.svg') }}" alt="no-image"></i>
                                                {!! __('0') !!}
                                            </li>
                                        </ul>
                                        <ul class="second">
                                            <li><i><img src="{{ asset('images/mipo/deals-img5.svg') }}" alt="no-image"></i></li>
                                            <li><i><img src="{{ asset('images/mipo/deals-img6.svg') }}" alt="no-image"></i></li>
                                            <li><i><img src="{{ asset('images/mipo/deals-img7.svg') }}" alt="no-image"></i></li>
                                            <li><i><img src="{{ asset('images/mipo/deals-img8.svg') }}" alt="no-image"></i></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="right_part">
                                    <div class="first_right">
                                        <div class="first">
                                            <i><img src="{{ asset('images/mipo/deals-img9.svg') }}" alt="no-image"></i>
                                            <ul>
                                                <li><img src="{{ asset('images/mipo/deals-img10.svg') }}" alt="no-image"></li>
                                                <li><img src="{{ asset('images/mipo/deals-img11.svg') }}" alt="no-image"></li>
                                            </ul>
                                            <p class="text-14-medium">{!! __('Rajkot') !!}</p>
                                        </div>
                                        <span class="ex_wrap text-14-medium">{!! __('Expires in 12 Days') !!}</span>
                                    </div>
                                    <div class="second_right">
                                        <p class="text-14-medium">{!! __('Awaiting Documents from Seller') !!}</p>
                                        <span class="text-14-semibold">{!! __('USD 0') !!}</span>
                                    </div>
                                </div>
                                <a href="javascript:;" class="full_link"></a>
                            </div>
                            <div class="deals_mobile_bought_caption">
                                <div class="left_part">
                                    <div class="cap_box">
                                        <div class="first_bought">
                                            <a href="javascript:;" class="name text-14-medium">{!! __('CHEQUE - OP0001') !!}</a>
                                            <span class="cash text-14-medium">{!! __('Cash') !!}</span>
                                        </div>
                                        <div class="second_bought">
                                            <a href="javascript:;" class="seller_name text-12-medium">{!! __('John Doe') !!}</a>
                                            <span class="seller_btn text-12-medium">{!! __('Seller') !!}</span>
                                            <i><img src="{{ asset('images/mipo/deals-img2.svg') }}" alt="no-image"></i>
                                            <a href="javascript:;" class="payer_name text-12-medium">{!! __('Arya Kagathara') !!}</a>
                                        </div>
                                        <a href="javascript:;" class="company_name text-14-medium">{!! __('Cocacola Soda Ltd.') !!}</a>
                                    </div>
                                    <div class="imagesbox">
                                        <ul class="first">
                                            <li class="text-14-medium">
                                                <i class="light"><img src="{{ asset('images/mipo/deals-img3.svg') }}" alt="no-image"></i>
                                                <i class="dark"><img src="{{ asset('images/mipo/deals-img13.svg') }}" alt="no-image"></i>
                                                {!! __('Con Recurso') !!}
                                            </li>
                                            <li class="text-14-medium">
                                                <i class="light"><img src="{{ asset('images/mipo/deals-img4.svg') }}" alt="no-image"></i>
                                                <i class="dark"><img src="{{ asset('images/mipo/deals-img14.svg') }}" alt="no-image"></i>
                                                {!! __('0') !!}
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="right_part">
                                    <div class="first_right">
                                        <p class="text-14-medium">{!! __('Awaiting Documents from Seller') !!}</p>
                                        <span class="text-14-semibold">{!! __('USD 0') !!}</span>
                                    </div>
                                    <div class="second_right">
                                        <span class="ex_wrap text-12-medium">{!! __('Expires in 12 Days') !!}</span>
                                        <i><img src="{{ asset('images/mipo/deals-img9.svg') }}" alt="no-image"></i>
                                    </div>
                                </div>
                                <a href="javascript:;" class="full_link"></a>
                            </div>
                            <div class="op_empty deals_op_empty">
                                <div class="ope_notfoundWrap">
                                    <div class="imgbox">
                                        <i class="day"><img src="{{ asset('images/mipo/operaempty.svg') }}" alt="no-image"></i>
                                        <i class="night"><img src="{{ asset('images/mipo/operanightmode.svg') }}" alt="no-image"></i>
                                        <strong class="text-20-semibold">{{ __('No operation has been closed yet')}}</strong>
                                        <p class="text-16-medium">{{ __('Start sending offers and start closing deals')}}</p>
                                        <div class="newoprationBtn">
                                            <a href="{{route('operations.create')}}" class="text-16-medium"><i><img src="{{ asset("images/mipo/deals-img12.svg") }}" alt="no-image"></i>{{ __('Explore Operations') }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                        </div>

                        <div class="tab-pane fade" id="seller">
                            <div id="ajax_deals_list_seller"></div>
                          {{--   <div class="deals_sold_caption">
                                <div class="left_part">
                                    <div class="cap_box">
                                        <a href="javascript:;" class="name text-14-medium">{!! __('CHEQUE - OP0001') !!}</a>
                                        <span class="cash text-14-medium">{!! __('Cash') !!}</span>
                                        <a href="javascript:;" class="payer_name text-14-medium">{!! __('Arya Kagathara') !!}</a>
                                        <i><img src="{{ asset('images/mipo/deals-img2.svg') }}" alt="no-image"></i>
                                        <a href="javascript:;" class="seller_name text-14-medium">{!! __('John Doe') !!}</a>
                                        <span class="seller_btn text-12-medium">{!! __('Buyer') !!}</span>
                                    </div>
                                    <a href="javascript:;" class="company_name text-14-medium">{!! __('Cocacola Soda Ltd.') !!}</a>
                                    <div class="imagesbox">
                                        <ul class="first">
                                            <li class="text-14-medium">
                                                <i class="light"><img src="{{ asset('images/mipo/deals-img3.svg') }}" alt="no-image"></i>
                                                <i class="dark"><img src="{{ asset('images/mipo/deals-img13.svg') }}" alt="no-image"></i>
                                                {!! __('Con Recurso') !!}
                                            </li>
                                            <li class="text-14-medium">
                                                <i class="light"><img src="{{ asset('images/mipo/deals-img4.svg') }}" alt="no-image"></i>
                                                <i class="dark"><img src="{{ asset('images/mipo/deals-img14.svg') }}" alt="no-image"></i>
                                                {!! __('0') !!}
                                            </li>
                                        </ul>
                                        <ul class="second">
                                            <li><i><img src="{{ asset('images/mipo/deals-img5.svg') }}" alt="no-image"></i></li>
                                            <li><i><img src="{{ asset('images/mipo/deals-img6.svg') }}" alt="no-image"></i></li>
                                            <li><i><img src="{{ asset('images/mipo/deals-img7.svg') }}" alt="no-image"></i></li>
                                            <li><i><img src="{{ asset('images/mipo/deals-img8.svg') }}" alt="no-image"></i></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="right_part">
                                    <div class="first_right">
                                        <div class="first">
                                            <i><img src="{{ asset('images/mipo/deals-img9.svg') }}" alt="no-image"></i>
                                            <ul>
                                                <li><img src="{{ asset('images/mipo/deals-img10.svg') }}" alt="no-image"></li>
                                                <li><img src="{{ asset('images/mipo/deals-img11.svg') }}" alt="no-image"></li>
                                            </ul>
                                            <p class="text-14-medium">{!! __('Rajkot') !!}</p>
                                        </div>
                                        <span class="ex_wrap text-14-medium">{!! __('Expires in 12 Days') !!}</span>
                                    </div>
                                    <div class="second_right">
                                        <p class="text-14-medium">{!! __('Send Document to MIPO') !!}</p>
                                        <span class="text-14-semibold">{!! __('USD 0') !!}</span>
                                    </div>
                                </div>
                                <a href="javascript:;" class="full_link"></a>
                            </div>
                            <div class="deals_mobile_sold_caption">
                                <div class="left_part">
                                    <div class="cap_box">
                                        <div class="first_sold">
                                            <a href="javascript:;" class="name text-14-medium">{!! __('CHEQUE - OP0001') !!}</a>
                                            <span class="cash text-14-medium">{!! __('Cash') !!}</span>
                                        </div>
                                        <div class="second_sold">
                                            <a href="javascript:;" class="payer_name text-12-medium">{!! __('Arya Kagathara') !!}</a>
                                            <i><img src="{{ asset('images/mipo/deals-img2.svg') }}" alt="no-image"></i>
                                            <a href="javascript:;" class="seller_name text-12-medium">{!! __('John Doe') !!}</a>
                                            <span class="seller_btn text-12-medium">{!! __('Buyer') !!}</span>
                                        </div>
                                        <a href="javascript:;" class="company_name text-14-medium">{!! __('Cocacola Soda Ltd.') !!}</a>
                                    </div>
                                    <div class="imagesbox">
                                        <ul class="first">
                                            <li class="text-14-medium">
                                                <i class="light"><img src="{{ asset('images/mipo/deals-img3.svg') }}" alt="no-image"></i>
                                                <i class="dark"><img src="{{ asset('images/mipo/deals-img13.svg') }}" alt="no-image"></i>
                                                {!! __('Con Recurso') !!}
                                            </li>
                                            <li class="text-14-medium">
                                                <i class="light"><img src="{{ asset('images/mipo/deals-img4.svg') }}" alt="no-image"></i>
                                                <i class="dark"><img src="{{ asset('images/mipo/deals-img14.svg') }}" alt="no-image"></i>
                                                {!! __('0') !!}
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="right_part">
                                    <div class="first_right">
                                        <p class="text-14-medium">{!! __('Send Document to MIPO') !!}</p>
                                        <span class="text-14-semibold">{!! __('USD 0') !!}</span>
                                    </div>
                                    <div class="second_right">
                                        <span class="ex_wrap text-12-medium">{!! __('Expires in 12 Days') !!}</span>
                                        <i><img src="{{ asset('images/mipo/deals-img9.svg') }}" alt="no-image"></i>
                                    </div>
                                </div>
                                <a href="javascript:;" class="full_link"></a>
                            </div>
                            <div class="op_empty deals_op_empty">
                                <div class="ope_notfoundWrap">
                                    <div class="imgbox">
                                        <i class="day"><img src="{{ asset('images/mipo/operaempty.svg') }}" alt="no-image"></i>
                                        <i class="night"><img src="{{ asset('images/mipo/operanightmode.svg') }}" alt="no-image"></i>
                                        <strong class="text-20-semibold">{{ __('No operation has been sold yet')}}</strong>
                                        <p class="text-16-medium">{{ __('Start Creating Operations')}}</p>
                                        <div class="newoprationBtn">
                                            <a href="{{route('operations.create')}}" class="text-16-medium"><i><img src="{{ asset("images/mipo/addplus.png") }}" alt="no-image"></i>{{ __('Create New Operation') }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @section('custom_script')
        <script>
            const ajax_deals_list_seller_url = "{{ route('deals.ajax-deals-list-seller') }}";
            const ajax_deals_list_buyer_url = "{{ route('deals.ajax-deals-list-buyer') }}";
            const ajax_url_get_seller = "{{ route('profile.ajax-search-seller') }}";
            const ajax_url_get_buyer = "{{ route('profile.ajax-search-buyer') }}";
            const ajax_url_resend_otp_url = "{{ route('counter-offer.ajax-confirm-offer-pdf') }}";
        </script>
        <script src="{{ asset('plugins/intl-tel-input-17.0.19/build/js/intlTelInput-jquery.min.js') }}"></script>
        <script src="{{ asset('plugins/select2-4.1.0-rc.0/dist/js/select2.min.js') }}"></script>
        <script src="{{ asset('plugins/carousel/owl.carousel.min.js') }}"></script>
        <script src="{{ asset('js/deals-contracts.js') }}"></script>
        <script src="{{ asset('js/deals-list-web.js') }}"></script>
        <script>
            $(document).ready(function() {
                $("#nav_buy").click(function() {
                    $("#head_seller").hide();
                });
                $("#nav_buy").click(function() {
                    $("#head_buyer").show();
                });
                $("#nav_sell").click(function() {
                    $("#head_buyer").hide();
                });
                $("#nav_sell").click(function() {
                    $("#head_seller").show();
                });
                $('.mobile_deals .mob_title a').on('click', function () {
                    $('.mobile_deals').addClass('clicked');
                    $('body').addClass('mob_filter');
                });

                $('.mobile_deals .mobile_filter .adv-filter .light').on('click', function () {
                    $('.mobile_deals').removeClass('clicked');
                    $('body').removeClass('mob_filter');
                });

                $('.mobile_deals .mobile_filter .adv-filter .dark').on('click', function () {
                    $('.mobile_deals').removeClass('clicked');
                    $('body').removeClass('mob_filter');
                });

                $(".deals_tabs ul li a").click(function (e) {
                    let tab = $(this).attr('data-bs-target');
                    localStorage.setItem("buyerseller_tab", tab);
                });
            });
            let selectedBuysellTab = localStorage.getItem("buyerseller_tab");
            if(selectedBuysellTab){
                    $('.deals_tabs ul li a').removeClass('active');
                    let activeTab = document.querySelector(`.deals_tabs ul li a[data-bs-target="${selectedBuysellTab}"]`);
                    activeTab.classList.add('active');

                    const selectedBuysellTabWithoutHash = selectedBuysellTab.replace('#', '');
                    $('.deals_textbox .tab-pane').removeClass('show active');
                    let activeTabContent = document.querySelector(`.deals_textbox .tab-pane[id="${selectedBuysellTabWithoutHash}"]`);
                    activeTabContent.classList.add('show');
                    activeTabContent.classList.add('active');
            }else {
                    $('.deals_tabs ul li a:first').addClass('active');
                    $('.deals_textbox .tab-pane:first').addClass('show');
                    $('.deals_textbox .tab-pane:first').addClass('active');
            }
        </script>
    @endsection
</x-app-layout>
