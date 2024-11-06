<x-app-layout>
    @section('pageTitle', 'Dashboard')
    @section('custom_style')
    <style>
        #duration_date_range {
            background: transparent !important;
            border: none !important;
            color: #ffffff !important;
        }
    </style>
        <link href="{{ asset('plugins/carousel/owl.carousel.min.css')}}" rel="stylesheet">
    @endsection
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    @php
        $preferred_currency_val = Auth()->user()->preferred_currency ?? 'Gs.';
        $preferred_dashboard_val = Auth()->user()->preferred_dashboard ?? 'Investor';
    @endphp
    <div class="dashboard_wrap">
        <div class="container">
            @permission('filters-on-top')
            <div class="dashboard_top">
                <div class="mobile_dash_heading">
                    <div class="heading_box">
                        <h2>{!! __('Dashboard') !!}</h2>
                        <h6>{!! __('Real Time Investment Metrics') !!}</h6>
                    </div>
                    <div class="member_block">
                        <div class="member_badge">
                            <div class="mem-status">
                                <span>{{ $user_level_name }}</span>
                            </div>
                            <i><img src="{{ app('common')->userLevelImage($user_level_name) }}" alt="no-image"></i>
                        </div>
                    </div>

                </div>
                <div class="buttons_wrap">
                    <div class="btns_left">
                        <div class="buysell_btn">
                            <input type="hidden" id="select_preferred_dashboard" value="{{ $preferred_dashboard_val }}"/>
                            @foreach ($preferred_dashboard as $val => $txt)
                                <a href="javascript:;" data-val="{{ $val }}" class="{{ ($preferred_dashboard_val == $val) ? 'active' : ''}} evt_user_type_tab">{!! __($txt) !!}</a>
                            @endforeach
                        </div>
                    
                        <div class="usgs_btn">
                            @foreach ($currency_type as $val)
                                <a href="javascript:;" data-val="{{ $val }}" class="{{ ($preferred_currency_val == $val) ? 'active' : ''}} evt_currency_type_tab">{{ $val }}</a>
                            @endforeach
                            <input type="hidden" id="select_currency_type" value="{{ $preferred_currency_val }}"/>
                        </div>

                        <div class="select-dd" id="sel_wrapsecond">
                            <span class="label">{{ __('Duration') }}: </span>
                            <input type="text" name="duration_date_range" readonly id="duration_date_range" />
                        </div>
                    </div>

                    <div class="btns_right">
                        <a class="btn-w-icon up_acc" href="{{route('user.plans')}}">
                            <i><img src="{{ asset('images/mipo/dash-acc.svg') }}" alt="no-image"></i>
                            <span>{{ __('Upgrade Account') }}</span>
                        </a>
                        <a class="btn-w-icon" href="javascript:;">
                            <i><img src="{{ asset('images/mipo/dash-contact.svg') }}" alt="no-image"></i>
                            <span class="evt_web_open_chat">{{ __('Contact Support') }}</span>
                        </a>
                    </div>
                </div>

                <div class="dash_heading">
                    <div class="heading_box">
                        <h2>{!! __('Dashboard') !!}</h2>
                        <h6>{!! __('Real Time Investment Metrics') !!}</h6>
                    </div>

                    <div class="member_block">
                        <div class="member_badge">
                            <div class="mem-status">
                                <span>{{ $user_level_name }}</span>
                                <p>{!! __('Account Status') !!}</p>
                            </div>
                            <i><img src="{{ app('common')->userLevelImage($user_level_name) }}" alt="no-image"></i>
                        </div>

                        <!-- <div class="pro_block">
                            <div class="pro_text">
                                @php
                                $result_data = app('common')->becomingUserLevel($user_level_name);
                                @endphp
                                <span><strong>{{  $result_data['complete_deals'] }}</strong>/{{  $result_data['total_next_level'] }}</span>
                            </div>

                            <div class="progress">
                                <div class="progress-bar w-75" role="progressbar" aria-valuenow="75" aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>

                            <div class="deal_txt">
                                <p>{{ __('Only') }} {{ ( $result_data['total_next_level'] - $result_data['complete_deals'] )}} {{__(' deals away for becoming')}} {{  $result_data['next_user_level_name'] }}</p>
                            </div>

                        </div> -->

                    </div>

                </div>

            </div>
            @endpermission
            <div class="dash_mem_blocks" id=ajax_first_div>

                {{-- show Finalized Deals, Deals Finalized Operations --}}

            </div>

            <div class="dash_updates">

                <div class="row">
                    @permission('latest-updates-in-deals')
                    <div class="col-lg-8">

                        <div class="deals_block">

                            <div class="deal_heading">

                                <div class="title_box">

                                    <h3>{!! __('Latest Operations Updates') !!}</h3>

                                    <div class="sub_text">

                                        <p>{!! __('Operations with Pendings') !!}</p>

                                        {{-- <i><img src="{{ asset('images/info2.svg') }}" alt="no-image"></i> --}}

                                    </div>

                                </div>

                                <div class="deal_cta">

                                    <div class="select-dd">

                                        <span class="label">{!! __('Sort by:') !!}</span>

                                        <select name="sort_type_lates_deals" id="sort_type_lates_deals" class="form-select selectbox">
                                            <option value="DESC">{{ __('Expiration') }}</option>
                                            <option value="DESC">{{ __('Newest') }}</option>
                                            <option value="ASC">{{ __('Oldest') }}</option>
                                        </select>
                                        

                                    </div>

                                    <a href="javascript:;" class="btn-next">
                                        <img src="{{ asset('images/mipo/right_blue.svg') }}" alt="no-image">
                                    </a>
                                </div>

                            </div>

                            <div class="deal_table_wrap">
                                <div class="deal_table" id="ajax_latest_update_in_deals_table_div">


                                </div>
                            </div>

                        </div>

                    </div>
                    @endpermission
                    @permission('latest-updates-in-deals-graph')
                    <div class="col-lg-4">

                        <div class="deals_block mobile_de_wrap">

                            <div class="deal_heading">

                                <div class="title_box">

                                    <h3 id="dsh_pie_chart_title">{!! __('Portfolio Asset Allocation') !!}</h3>

                                    <div class="sub_text">

                                        <p id="dsh_pie_chart_sub_title">{!! __('Porcentual composition') !!}</p>

                                        {{-- <i><img src="{{ asset('images/info2.svg') }}" alt="no-image"></i> --}}

                                    </div>

                                </div>

                            </div>

                            <div class="chart_block">
                                <div id="div_pie_chart_deals">
                                    {{--  load pie Latest update in deals --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endpermission
                </div>
            </div>


            <div id="ajax_last_section_div">
                {{-- show here sub-user-roi-and-important --}}
            </div>


        </div>

    </div>

    @section('custom_script')
        <script>
            var url_ajax_dashboard_type = "{{ route('dashboard.ajax-type') }}";
            var current_date_month = "{{ $current_date_month }}";
            var current_end_date_month = "{{ $current_end_date_month }}";
        </script>
        {{-- <script src="{{ asset('plugins/daterangepicker/moment.min.js') }}"></script>
        <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script> --}}
        {{-- <script src="{{ asset('plugins/chart/chart.bundle.js') }}"></script> --}}
        <script src="{{ asset('plugins/chart/chart.min.js') }}"></script>
        {{-- <script src="{{ asset('plugins/chart/chartjs-gauge.js') }}"></script> --}}
        <script src="{{ asset('js/owl.carousel.min.js')}}"></script>
        <script src="{{ asset('js/dashboard.js') }}"></script>
        <script src="{{ asset('js/tour/desktoptour.js') }}"></script>
    @endsection
</x-app-layout>
