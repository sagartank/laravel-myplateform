<x-app-layout>
    @section('pageTitle', 'My Operations')
    @section('custom_style')
        <link href="{{ asset('plugins/select2-4.1.0-rc.0/dist/css/select2.min.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('plugins/dropzone/dropzone.min.css') }}">
        <link href="{{ asset('plugins/carousel/owl.carousel.min.css')}}" rel="stylesheet">
        <style>
            .select2-dropdown.increasezindex {
                z-index: 99999;
            }

            .active-selected-div {
                background-color: var(--m-hover-hover);
            }
            .skl_operation {
                height: 110px;
                margin-bottom: 4px;
            }
            .user_rating li{
                max-width : 100% !important;
            }
            .swal2-container {z-index: 9999 !important;}
        </style>
    @endsection
    <div class="my_operations_page">
        <div class="my_operations_title_sec">
            <div class="container">
                <div class="my_operations_title my-op-title">
                    <div class="my_operations_left">
                        <h2 class="text-24-semibold">{!! __('My Operations') !!}</h2>
                        <div class="my_operations_right">
                            @permission('my-operations-create')
                            {{--   <div class="create_operation">
                                <a data-bs-toggle="modal" id="btn_bulk_modal_show" class="bulk-upload text-16-medium">
                                    <i><img src="{{ asset('images/mipo/add-bulk.svg') }}" alt="no-image"></i>
                                    {!! __('Bulk Upload') !!}
                                </a>
                            </div> --}}
                            <div class="create_operation">
                                <a href="{{ route('operations.create') }}" class="create_op text-16-medium">
                                    <i>
                                        <svg width="22" height="22" viewBox="0 0 11 12" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M5.5 1.3125V10.6875M10.1875 6H0.8125" stroke="white" stroke-width="1.5"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </i>
                                    {!! __('Create a operation') !!}
                                </a>
                            </div>
                            @endpermission
                        </div>
                    </div>
                    <div class="mobile_operations_left" id="op_list_side_bar_modal">
                        <div class="mob_title">
                            
                            <h2 class="text-20-semibold">{!! __('My Operations') !!}</h2>
                        </div>
                        @include('operations.mobile-sidebar')
                        <div class="mobile_operations_right">
                            <div class="mob_createbtn" id="evt_mob_createbtn" data-url="{{ route('operations.create') }}"><img src="{{ asset('images/mipo/addsubmit.svg') }}" alt="no-image"></div>
                            <div class="mob_export_section evt_download_pdf_seller" title="Export" data-href="{{ route('profile.public-seller-pdf') }}"
                            data-seller-slug="{{ $user->slug }}"><img src="{{ asset('images/mipo/mobileexportbtn.svg') }}" alt="no-image"></div>
                        </div>
                    </div>
                    <div class="op-tabbox">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            @permission('my-operations-offers')
                            <li class="nav-item" role="presentation">
                                <a href="javascript:void(0)" class="nav-link evt_operations_tab public_pro_show" id="operations-tab"
                                    data-bs-toggle="tab" data-bs-target="#operations-tab-pane" type="button"
                                    role="tab" aria-controls="operations-tab-pane"
                                    aria-selected="true">{!! __('Offers') !!}</a>
                            </li>
                            @endpermission
                            @permission('my-operations-tab-operations')
                            <li class="nav-item" role="presentation">
                                <a href="javascript:void(0)" class="nav-link evt_operations_tab public_pro_show" id="drafts-tab"
                                    data-bs-toggle="tab" data-bs-target="#drafts-tab-pane" type="button" role="tab"
                                    aria-controls="drafts-tab-pane" aria-selected="false">{!! __('Operations') !!}</a>
                            </li>
                            @endpermission
                            @permission('mi-operations')
                            <li class="nav-item" role="presentation">
                                <a href="javascript:void(0)" class="nav-link evt_operations_tab public_pro" id="mi-operations-tab"
                                    data-bs-toggle="tab" data-bs-target="#mi-operations-tab-pane" type="button"
                                    role="tab" aria-controls="mi-operations-tab-pane"
                                    aria-selected="false">{!! __('Public Profile') !!}</a>
                            </li>
                            @endpermission
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="my_operations_sectopn">
            <div class="container">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade" id="operations-tab-pane" role="tabpanel" aria-labelledby="operations-tab" tabindex="0">
                        <div class="my_operations_bottom">
                            <div class="my_operations_part">
                                <div class="{{ ($offers->count() > 0 ) ? 'my_firstopera' : '' }}">
                                    @if (isset($offers) && $offers->count() > 0)
                                    <div class="opera_wrapper">
                                        <div class="my_operations_title text-18-semibold">{!! __('Operations') !!}</div>
                                        <div class="select-dd">
                                            <span class="label text-14-medium">{!! __('Sort by:') !!}</span>
                                            <select name="sort_type_operation_by_offer" id="sort_type_operation_by_offer" class="form-select nice_selectbox selectbox text-14-semibold">
                                                <option value="DESC">{!! __('Newest') !!}</option>
                                                <option value="ASC">{!! __('Oldest') !!}</option>
                                            </select>
                                        </div>
                                    </div>
                                    @endif
                                    <div class="listwrap_operations" id="ajax_offers_list">
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="my_operations_part" id="hide_show_amount">
                                @if (isset($offers) && $offers->count() > 0)
                                    <div class="my_operations_part_inner">
                                        <div class="my_operations_part_chart">
                                            <div class="operations_chart_list_wrap" id="ajax_high_low_amount_list">

                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="my_operations_part d-none" id="hide_show_group_offer_div"></div>
                            <div class="my_operations_part ajax_send_offer_group_page" id="ajax_send_offer_group_page">
                            </div>
                        </div>
                    </div>
                    
                    <div class="tab-pane fade" id="drafts-tab-pane" role="tabpanel" aria-labelledby="drafts-tab" tabindex="0">
                        <div class="drafts_sec">
                            <div class="drafts_sec_inner">
                                <div class="drafts_main_wrapper">
                                    <div class="drafts_sec_left">
                                        <div class="drafts_left_top">
                                            @permission('my-operations-tab-operations-adanced-fiters')
                                                @include('operations.sidebar')
                                            @endpermission
                                        </div>
                                    </div>
                                    <div class="drafts_left_lista outter_drafts">
                                        <div class="drop_wrap">
                                            <div class="title_drafts">
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
                                                <h6 class="text-24-semibold">{!! __('Operations') !!}</h6>
                                            </div>
                                            <div class="select-dd">
                                                <span class="label text-14-medium">{!! __('Sort by:') !!}</span>
                                                <select name="sort_type_lates_deals" id="sort_type_operation" class="form-select nice_selectbox selectbox text-14-semibold">
                                                    <option value="DESC">{!! __('Newest') !!}</option>
                                                    <option value="ASC">{!! __('Oldest') !!}</option>
                                                </select>
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
                                        <div class="wrapper_drafts_section">
                                            <div class="drafts_sec_right_action">
                                                <div class="draft_sec_checkbox">
                                                    <input class="form-check-input" type="checkbox" name="chk_all_explore" id="chk_all_explore">
                                                    <label for="chk_all_explore" class="text-14-medium">{!! __('Select all Operations') !!}</label>
                                                </div>
                                                <div class="draft_btnbox">
                                                    @permission('my-operations-tab-operations-revert')
                                                    <a href="javascript:;" data-href="{{ \Route('operations.ajax-change-status') }}" class="evt_revert_multiple_operation text-14-medium">
                                                        <i><img src="{{ asset('images/mipo/revert-left.svg') }}" alt="no-image"></i>
                                                        {!! __('Revert') !!}
                                                    </a>
                                                    @endpermission
                                                    @permission('my-operations-tab-operations-delete')
                                                    <a href="javascript:;" data-href="{{ \Route('operations.ajax-delete-multiple') }}" class="evt_delete_multiple_operation text-14-medium">
                                                        <i><img src="{{ asset('images/mipo/delete-white.svg') }}" alt="no-image"></i>
                                                        {!! __('Delete') !!}
                                                    </a>
                                                    <a href="javascript:;" data-href="{{ \Route('operations.ajax-delete-multiple') }}" class="evt_del evt_delete_multiple_operation">
                                                        <i><img src="{{ asset('images/mipo/delete-white.svg') }}" alt="no-image"></i>
                                                    </a>
                                                    @endpermission
                                                </div>
                                            </div>
                                            <div id="ajax_operations_list" class="inner_drafts">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="drafts_sec_right">
                                        <div class="drafts_sec_right_inner">
                                            @php
                                            /*   $sold = $unsold = $draft = $rejected = $approved = $pending = $counter = $completed = 0;
                                            if (isset($mi_operations_dashboard) && $mi_operations_dashboard->count() > 0) {
                                                $sold = $mi_operations_dashboard->pluck('offers')->flatten()->where('offer_status', 'Completed')->count();
                                                $draft = $mi_operations_dashboard->where('operations_status', 'Draft')->count();
                                                $rejected = $mi_operations_dashboard->where('operations_status', 'Rejected')->count();
                                                $approved = $mi_operations_dashboard->where('operations_status', 'Approved')->count();
                                                $pending = $mi_operations_dashboard->where('operations_status', 'Pending')->count();
                                                $unsold = $mi_operations_dashboard->where('expiration_date', '<', date('Y-m-d'))->where('operations_status', '!=', 'Approved')->count();
                                            } */

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
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="mi-operations-tab-pane" role="tabpanel" aria-labelledby="mi-operations-tab" tabindex="0">
                        {{-- @if (isset($offers) && $offers->count() > 0) --}}
                        <div class="mi_operation_sec">
                            <div class="mi_operation_inner">
                                <div class="mi_operation_title">
                                    <h5 class="text-24-semibold">{{ __('Public Profile') }}</h5>
                                    <div class="export_wrap">
                                        <a href="javascript:;" class="text-14-medium evt_download_pdf_seller" data-href="{{ route('profile.public-seller-pdf') }}"
                                        data-seller-slug="{{ $user->slug }}">
                                            <i><img src="{{ asset('images/mipo/publicexport.svg') }}" alt="no-image"></i>
                                            {!! __('Export') !!}
                                        </a>
                                    </div>
                                </div>
                                <div class="operation_public">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4">
                                            <div class="identity_box">
                                                <div class="person_box">
                                                    <div class="person_img">
                                                        <img src="{{ $user->profile_image_url }}" alt="no-image">
                                                    </div>
                                                    <div class="person_name">
                                                        <h6 class="text-16-medium">{!! __('Commercial Name') !!}</h6>
                                                        <p class="text-14-medium">{{ $user->issuer?->commercial_name }}</p>
                                                    </div>
                                                </div>
                                            
                                                <div class="more_detail">
                                                    {{-- <div class="detail">
                                                        <p class="text-14-medium">{!! __('Country') !!}:</p>
                                                        <span class="text-14-medium">Paraguay</span>
                                                    </div --}}
                                                    <div class="detail">
                                                        <p class="text-14-medium">{!! __('City name') !!}:</p>
                                                        <span class="text-14-medium">{{ $user->city?->name }}</span>
                                                    </div>
                                                    <div class="detail">
                                                        <p class="text-14-medium">{!! __('RUC') !!}:</p>
                                                        <span class="text-14-medium">{{ $user->issuer?->ruc_code }}</span>
                                                    </div>
                                                    <div class="detail">
                                                        <p class="text-14-medium">{!! __('Date of Registry') !!}:</p>
                                                        <span class="text-14-medium">{{ $user->user_registered_at }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-9 col-md-8">
                                            <div class="public_caption pubpro_sec">
                                                <div class="left_part">
                                                    <div class="name_box">
                                                        <h5 class="text-20-medium">{{ app('common')->lockUserDetail($user, []) }}</h5>
                                                        <div class="rating text-16-medium">
                                                            <i><img src="{{ asset('images/mipo/public-img2.svg') }}" alt="no-image"></i>
                                                            {{  floor($user->ratings_avg_rating_number).'/5'  }} ({{ $user->ratings_count}})
                                                        </div>
                                                    </div>
                                                    <div class="company text-14-medium">{!! $user->issuer?->industry_type !!}</div>
                                                </div>
                                                <a href="javascript:;" class="mobile_show_btn text-14-medium evt_web_open_chat">
                                                    {!! __('Suggest more info') !!}
                                                    <i><img src="{{ asset('images/mipo/public-img3.svg') }}" alt="no-image"></i>
                                                </a>
                                                <div class="right_part">
                                                    <a href="javascript:;" class="show_btn text-14-medium evt_web_open_chat">
                                                        {!! __('Suggest more info') !!}
                                                        <i><img src="{{ asset('images/mipo/public-img3.svg') }}" alt="no-image"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="public_caption public_info">
                                                <h6 class="text-16-semibold">{!! __('Information') !!}</h6>
                                                <p class="text-16-medium">
                                                    {!! $user->issuer?->basic_info !!}
                                                </p>
                                            </div>
                                            <div class="public_caption public_chart">
                                                <div class="row">
                                                    <div class="col-lg-4 col-6 evt_mi_operation_status" role="button" data-bs-toggle="tooltip" data-bs-placement="top" data-status-name="Approved">
                                                        <div class="public_data_block">
                                                            <div class="text">
                                                                <p class="text-20-medium">{{  ($approved - $sold)  }}</p>
                                                            </div>
                                                            <h6 class="text-14-medium">{!! __('Available Documents') !!}</h6>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-6 evt_mi_operation_status" role="button" data-bs-toggle="tooltip" data-bs-placement="top" data-status-name="Sold">
                                                        <div class="public_data_block">
                                                            <div class="text">
                                                                <p class="text-20-medium">{{ $sold }}</p>
                                                            </div>
                                                            <h6 class="text-14-medium">{!! __('Documents Sold') !!}</h6>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-6 evt_mi_operation_status" data-status-name="All" role="button">
                                                        <div class="public_data_block">
                                                            <div class="text">
                                                                <p class="text-20-medium">{{ $sold + $unsold }}</p>
                                                            </div>
                                                            <h6 class="text-14-medium">{!! __('Historic Operations') !!}</h6>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-6 evt_mi_operation_status" data-status-name="Unsold" role="button">
                                                        <div class="public_data_block">
                                                            <div class="text">
                                                                <p class="text-20-medium">{{ $unsold }}</p>
                                                            </div>
                                                            <h6 class="text-14-medium">{!! __('Unsold Operations') !!}</h6>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-6  evt_mi_operation_status" data-status-name="Rejected" role="button">
                                                        <div class="public_data_block">
                                                            <div class="text">
                                                                <p class="text-20-medium">{{ ($openDisputes - $solvedDisputes) }}</p>
                                                            </div>
                                                            <h6 class="text-14-medium">{!! __('Open Disputes') !!}</h6>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-6 evt_mi_operation_status"  data-status-name="Approved" role="button">
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
                                                                <p class="text-20-medium"> {{ round($average_rating_days, 2) ?? 0 }}</p>
                                                            </div>
                                                            <h6 class="text-14-medium">{!! __('Average Day Delay in Payment') !!}</h6>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-6">
                                                        <div class="public_data_block">
                                                            <div class="text">
                                                                <p class="text-20-medium"> {{ round($average_retention, 2) ?? 0 }}%</p>
                                                            </div>
                                                            <h6 class="text-14-medium">{!! __('Average Retention') !!}</h6>
                                                        </div>
                                                    </div>
                                                    @php
                                                    $usd_amount_avg =  $average_operation_values->where('preferred_currency', config('constants.CURRENCY_TYPE')[0])->avg('amount');
                                                    $gs_amount_avg = $average_operation_values->where('preferred_currency', config('constants.CURRENCY_TYPE')[1])->avg('amount');
                                                @endphp
                                                    <div class="col-lg-4 col-6">
                                                        <div class="public_data_block">
                                                            <div class="text">
                                                                <p class="text-20-medium">{!! ('USD') !!} {{ app('common')->currencyNumberFormat(config('constants.CURRENCY_TYPE')[0], $usd_amount_avg) }}</p>
                                                                <p class="text-20-medium">{!! ('GS') !!} {{ app('common')->currencyNumberFormat(config('constants.CURRENCY_TYPE')[1], $gs_amount_avg) }}</p>
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
                                                                <p class="text-20-medium">{!! ($user->issuer?->registry_in_mipo == 'Yes') ? __('Yes') : __('No') !!}</p>
                                                            </div>
                                                            <div class="img">
                                                                <i><img src="{{ asset('images/mipo/public-img4.svg') }}" alt="no-image"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-6">
                                                        <div class="public_data_block">
                                                            <div class="text">
                                                                <p class="text-20-medium">{!! ($user->address_verify == 'Yes') ? __('Yes') : __('No') !!}</p>
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
                                                                <canvas id="pie_chart_mi_operations_div"></canvas>
                                                                {{-- <img src="{{ asset('images/mipo/public-img5.png') }}" alt="no-image"> --}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="public_caption public_additional">
                                                <h6 class="text-16-semibold">{!! __('Additional Information') !!}</h6>
                                                {!! $user->issuer?->additional_info !!}
                                            </div>
                                            <div class="public_caption public_review">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="investor_review">
                                                            @php
                                                                $one_rat = $user->ratings->whereBetween('rating_number', [0.5, 1]);
                                                                $two_rat = $user->ratings->whereBetween('rating_number', [1.5, 2]);
                                                                $three_rat = $user->ratings->whereBetween('rating_number', [2.5, 3]);
                                                                $four_rat = $user->ratings->whereBetween('rating_number', [3.5, 4]);
                                                                $five_rat = $user->ratings->whereBetween('rating_number', [4.5, 5]);

                                                                $total_rating_user = ($one_rat->count() + $two_rat->count() + $three_rat->count() + $four_rat->count() + $five_rat->count());
                                                                $total_rating_user = ($total_rating_user > 0 ? $total_rating_user : 1);
                                                                
                                                                $five_rat_user = floor((($five_rat->count() * 100) / $total_rating_user));
                                                                $four_rat_user = floor((($four_rat->count() * 100) / $total_rating_user));
                                                                $three_rat_user = floor((($three_rat->count() * 100) / $total_rating_user));
                                                                $two_rat_user = floor((($two_rat->count() * 100) / $total_rating_user));
                                                                $one_rat_user = floor((($one_rat->count() * 100) / $total_rating_user));

                                                                $total_avg = floor($user->ratings->pluck('rating_number')->avg());
                                                            @endphp
                                                            <h3 class="text-16-semibold">{!! __('Investor Reviews') !!}:</h3>
                                                            <div class="rate_star text-16-medium">
                                                                <ul class="user_rating">
                                                                    <li><img src="{{ app('common')->userRatingImage($total_avg) }}" alt="no-image"></li>
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
                                                            @if ($user->ratings->count() > 0)
                                                                @foreach ($user->ratings as $key => $user_rating)
                                                                <div class="multi_section">
                                                                    <p class="text-14-medium">{{  app('common')->displayStart($user_rating->rating_by_user->name) }}</p>
                                                                    <div class="rate_block text-14-medium">
                                                                        {{ round($user_rating->rating_number, 2) }}
                                                                        <ul>
                                                                            <li><img src="{{ app('common')->issuerRatingImage($user_rating->rating_number) }}" alt="no-image"></li>
                                                                        </ul>
                                                                    </div>
                                                                    <span class="text-14-medium">{{  $user_rating->feedback_description }}</span>
                                                                </div>
                                                                @endforeach
                                                                <div class="show_btn">
                                                                    <a href="javascript:;" class="text-14-medium">
                                                                        {!! __('Show more') !!}
                                                                        <i><img src="{{ asset('images/mipo/public-img9.svg') }}" alt="no-image"></i>
                                                                    </a>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @if($user->issuer?->issuers_attach_images->count() > 0)
                                                <div class="public_caption public_main_wrapper">
                                                    <div class="public_slider owl-carousel">
                                                        @forelse ($user->issuer->issuers_attach_images as $issuer_attach_image)
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
                                                                        <p class="text-14-semibold">{{ $blog->created_at->format('d') }} <br>
                                                                            @if(app()->getLocale() == 'es' && $blog->created_at!='')
                                                                            {{  config('constants.MONTHS_NAME')[\Carbon\Carbon::createFromDate($blog->created_at)->format('m')] }}
                                                                            @else
                                                                            {{ strtoupper($blog->created_at->format('M')) }}
                                                                            @endif
                                                                            </p>
                                                                    </div>
                                                                </div>
                                                                <div class="news_text">
                                                                    <h6 class="text-14-semibold">{!! $blog->getTranslation('title', session('locale', 'es')) !!}</h6>
                                                                    <p class="text-14-medium">{!! $blog->getTranslation('excerpt', session('locale', 'es')) !!}</p>
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
                        {{-- @endif --}}
                    </div>

                </div>
            </div>
        </div>
    </div>


    
    {{-- pdf modal --}}
    <x-confrim-offer-contract-modal></x-confrim-offer-contract-modal>
    {{--------------------------------------------- view operation Modal :st----------------------------------------}}
    <div class="group-ofr-popup">
        <div class="modal fade" id="group_offer_operation_popup" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title text-20-medium">{!! __('Group offer') !!}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="ajax_group_offer_operation_view">
                </div>
            </div>
            </div>
        </div>
    </div>
{{--------------------------------------------- view operation Modal :end----------------------------------------}}

{{-- Operations tab pop up by k --}}
<div class="drafts_wrap_bulk_popup">
    <div class="modal fade" id="bulkexampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-20-medium" id="exampleModalLabel">{!! __('Attachments') !!}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="dropzone">
                        <form action="{{ route('operations.bulk-upload') }}" id="bulk_upload_modal_form" name="bulk_upload_modal_form" method="POST" enctype="multipart/form-data" class="dropzone needsclick">
                            <div class="dzone">
                                @csrf
                                <div class="dz-message needsclick">
                                    <span class="text">
                                        <img src="{{ asset('images/mipo/dropzoneicon.svg') }}" alt="no-image">
                                        <div class="content">
                                            <h5 class="text-14-semibold">{!! __('Drop Files Here or') !!}</h5>
                                            <p class="text-14-semibold">{!! __('Upload File') !!}</p>
                                        </div>
                                        <div class="formate text-14-medium">{!! __('Supported Formats: xlsx') !!}</div>
                                    </span>
                                </div>
                            </div>
                            <div class="sub_btn">
                                <button type="button" class="btn-secondary text-16-medium" data-bs-dismiss="modal">{!! __('Cancel') !!}</button>
                                <input type="submit" value="{{ __('Submit') }}" id="btn_bulk_upload_modal_form" class="btn-primary text-16-medium">
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <p class="text-16-medium">
                        {!! __('Download sample xlsx file') !!}
                        <a href="javascript:;" class="text-16-medium">{!! __(' click here') !!}</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="drafts_wrap_popup">
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-20-medium" id="exampleModalLabel">{!! __('Revert Selected Operations') !!}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-14-medium">
                    {!! __('Are you sure you wish to revert selected operations?') !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-secondary text-16-medium" data-bs-dismiss="modal">{!! __('Cancel') !!}</button>
                    <button type="button" class="btn-primary text-16-medium">{!! __('Revert') !!}</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="drafts_wrap_delete_popup">
    <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-20-medium" id="exampleModalLabel">{!! __('Delete Operations') !!}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-14-medium">
                    {!! __('Are you sure you wish to delete operations?') !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-secondary text-16-medium" data-bs-dismiss="modal">{!! __('Cancel') !!}</button>
                    <button type="button" class="btn-primary text-16-medium">{!! __('Delete') !!}</button>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- Operations tab pop up by k --}}

    @section('custom_script')
        <script>
            const url_load_more_operations_data = "{{ route('operations.ajax-load-more-operations') }}";
            const url_load_more_offers_data = "{{ route('operations.ajax-load-more-offers-list') }}";
            const url_load_more_offer_contract_data = "{{ route('operations.ajax-load-more-offers-contract-list') }}";
            const url_deals = "{{ route('deals.index') }}";
            const url_load_operations_tags = "{{ route('operations.ajax-search-operations-tags') }}";
            const pichart_labels = {!! json_encode($pichart_labels) !!};
            const pichart_data = {!! json_encode($pichart_data) !!};

            var operations_form_data = {};
            var operation_filter_dashboard = true;

            const url_load_operations_by_offer = "{{ route('operations.ajax-operations-by-offer') }}";
            const url_send_single_counter_offer = "{{ route('operations.ajax-send-single-counter-page') }}";
            const url_cofirm_offer = "{{ route('counter-offer.ajax-confirm-offer-pdf') }}";
            const url_offer_status = "{{ route('counter-offer.ajax-save-offer-status') }}";
            const url_operations_high_low_amount = "{{ route('operations.ajax-operations-high-low-amount') }}";
            const url_offered_by_id = "{{ route('offered-operations.ajax-offers-by-id') }}";

        </script>
        <script src="{{ asset('plugins/dropzone/dropzone.min.js') }}"></script>
        <script src="{{ asset('plugins/select2-4.1.0-rc.0/dist/js/select2.min.js') }}"></script>
        <script src="{{ asset('plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
        <script src="{{ asset('plugins/chart/chart.min.js') }}"></script>
        <script src="{{ asset('js/jquery.formatCurrency-1.4.0.js') }}"></script>
        <script src="{{ asset('js/jquery.formatCurrency.all.js') }}"></script>
        <script src="{{ asset('js/custom-number-format.js') }}"></script>
        <script src="{{ asset('js/owl.carousel.min.js')}}"></script>
        <script src="{{ asset('js/operations.js') }}"></script>
        <script src="{{ asset('js/deals-contracts.js') }}"></script>
        <script src="{{ asset('js/tour/desktoptour.js') }}"></script>

        {{-- offer tab by k --}}
        <script>
            $(function () {
                
                $('#evt_mob_createbtn').click(function(){
                    window.location.href = $(this).attr('data-url');
                })

                $(document).on("click", ".my_operations_bottom .my_operations_part .my_firstopera .mobile_group_offer_part", function() {
                    $('.my_operations_bottom').addClass('clicked');
                    $('body').addClass('offer_mobile_sec');
                });

                $(document).on("click", ".my_operations_bottom .my_operations_part .my_fourthopera .heading a", function() {
                    $('.my_operations_bottom').removeClass('clicked');
                    $('body').removeClass('offer_mobile_sec');
                });
            });
            $(function () {
                $(document).on("click", ".my_operations_bottom .my_operations_part .my_firstopera .mobile_single_offer_part", function() {
                    $('.my_operations_bottom').addClass('mobile_first_click');
                    $('body').addClass('offer_mobile_sec');
                });

                $(document).on("click", ".my_operations_bottom .my_operations_part .my_secondopera .heading a", function() {
                    $('.my_operations_bottom').removeClass('mobile_first_click');
                    $('body').removeClass('offer_mobile_sec');
                });
            });
            $(function () {
                $(document).on("click", ".my_operations_bottom .my_operations_part .my_secondopera .lishow_wrap .opera_oction", function() {
                    $('.my_operations_bottom').addClass('mobile_second_click');
                    $('body').addClass('offer_mobile_sec');
                });

                $(document).on("click", ".my_operations_bottom .my_operations_part .my_thirdopera .heading a", function() {
                    $('.my_operations_bottom').removeClass('mobile_second_click');
                    $('body').removeClass('offer_mobile_sec');
                });
                $(document).on("click", ".my_operations_bottom .my_operations_part .my_thirdopera .view", function() {
                    $('.my_operations_bottom').addClass('third_mobile_click');
                    $('body').addClass('mobile_modal_click');
                    $('body').removeClass('offer_mobile_sec');
                });
                $(document).on("click", ".my_operations_bottom .my_operations_part .movi_popup_history .movi_header a", function() {
                    $('.my_operations_bottom').removeClass('third_mobile_click');
                });
            });
        </script>
        {{-- offer tab by k --}}

        {{-- public profile tab by k --}}
        <script>
            $(document).ready(function(){
                $(".public_pro") .click(function(){
                    $(".my_operations_right").hide();
                });
                $(".public_pro_show") .click(function(){
                    $(".my_operations_right").show();
                });
            });
            $(document).ready(function(){
                $(".public_pro") .click(function(){
                    $(".mob_createbtn").hide();
                });
                $(".public_pro_show") .click(function(){
                    $(".mob_createbtn").show();
                });
            });
            $(document).ready(function(){
                $(".public_pro_show") .click(function(){
                    $(".mob_export_section").hide();
                });
                $(".public_pro") .click(function(){
                    $(".mob_export_section").show();
                });
            });
            $('.public_slider').owlCarousel({
                items:5,
                loop:true,
                nav: true,
                dots: false,
                margin: 16,
                responsiveClass:true,
                navText: ['<img src="{{ asset('images/mipo/publicleft.svg') }}" alt="no-image">','<img src="{{ asset('images/mipo/publicright.svg') }}" alt="no-image">'],
                responsive:{
                    0:{
                        items:3,
                        nav:false,
                    },
                    768:{
                        items:3,
                        nav:false,
                    },
                    992:{
                        items:4,
                        nav:true,
                    },
                    1400:{
                        items:5,
                        nav:true,
                    }
                },
            });
        </script>
        {{-- public profile by k --}}
    <script>
        $(document).on('click', '#evt_cmd_single_offer_show_line_chart', function(){
            $('#single_offer_show_line_chart_modal').modal('show');
        });

        $(document).on('click', '.evt_download_pdf_seller', function(e) {
                e.preventDefault();
                var self = $(this);
                var route_url = self.attr('data-href');
                var seller_slug = self.attr('data-seller-slug');
                // var pie_chart_image = document.getElementById('pie_chart').toDataURL();
                var form_data = [];

                form_data.push({
                    name: "seller_slug",
                    value: seller_slug
                },
                {
                    name: "action",
                    value: 'pdf'
                },
                {
                    name: "pie_chart_image",
                    value: null
                    // value: pie_chart_image
                });

                ajax_pdf(route_url, 'POST', form_data, randomString());
            });
    </script>
    @endsection
</x-app-layout>