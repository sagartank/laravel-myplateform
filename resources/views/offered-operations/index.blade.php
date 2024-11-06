<x-app-layout>
    @section('pageTitle', 'Offered Operations')
    @section('custom_style')
        <link href="{{ asset('plugins/select2-4.1.0-rc.0/dist/css/select2.min.css') }}" rel="stylesheet">
        <link href="{{ asset('plugins/carousel/owl.carousel.min.css') }}" rel="stylesheet">
        <link href="{{ asset('plugins/fancybox/fancybox.css') }}" rel="stylesheet">
    @endsection

    <div class="offered_operations_page">
        <div class="container">
            <div class="offered_operations_inner">
                <div class="offered_operations_top">
                    <div class="offered_operations_title">
                        <a href="{{ route('explore-operations.index') }}">
                            <i><img src="{{ asset('images/mipo/topleftAro.svg') }}" class="day" alt="no-image"></i>
                            <i><img src="{{ asset('images/mipo/white_lft_aro.svg') }}" class="night" alt="no-image"></i>
                        </a>
                        <h2 class="text-24-semibold">{{ __('Offered Operations') }}</h2>
                    </div>

                    <div class="offered_operations_filter">
                        <div class="sortwrp">
                            <label for="sort_type_offered_operation" class="text-14-medium">{{ __('Sort by:') }}</label>
                            <select name="sort_type_offered_operation" id="sort_type_offered_operation"
                                class="form-select selectbox text-14-semibold">
                                <option value="DESC">{{ __('Newest') }}</option>
                                <option value="amount_desc">{{ __('High to low') }}</option>
                                <option value="amount_asc">{{ __('Low to high') }}</option>
                                <option value="ASC">{{ __('Oldest') }}</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{--  --}}
                <div class="mobile_offered_operations_inner">
                    <div class="offered_operations_title">
                        <a href="{{ route('explore-operations.index') }}">
                            <i><img src="{{ asset('images/mipo/topleftAro.svg') }}" class="day" alt="no-image"></i>
                            <i><img src="{{ asset('images/mipo/white_lft_aro.svg') }}" class="night" alt="no-image"></i>
                        </a>
                        <h2 class="text-24-semibold">{{ __('Offered Operations') }}</h2>
                    </div>
                    <div class="filtericon">
                        <a href="javascript:;">
                            <div class="imgbox"><img src="{{ asset('images/mipo/mobile_operationofr.svg') }}" alt="no-image"></div>
                            <div class="darkimg"><img src="{{ asset('images/mipo/mobilewhitesorting.svg') }}" alt="no-image"></div>
                        </a>
                        <div class="explor_blurbg">
                            <div class="mobile_sortby">
                                <div class="srtinner">
                                
                                    <div class="titlebox">
                                        <div class="name text-18-semibold">{{ __('SORT BY')}}</div>
                                        <a class="close" href="javacript:;"><img src="{{ asset('images/mipo/mobilesortbyblk.svg') }}" alt="no-image"></a>
                                        <a class="darkcls" href="javacript:;"><img src="{{ asset('images/mipo/sortdark_mobile.svg') }}" alt="no-image"></a>
                                    </div>
    
                                    <div class="sortbox">
                                        <div class="sortitem">
                                            <label for="ltoh" class="text-16-medium evt_mo_sort">{{ __('Price - Low to High') }}</label>
                                            <input type="radio" name="sort_type_offered_operation" value="amount_asc" id="ltoh">
                                        </div>
                                        <div class="sortitem">
                                            <label for="htol" class="text-16-medium evt_mo_sort">{{ __('Price - High to Low') }}</label>
                                            <input type="radio" name="sort_type_offered_operation" value="amount_desc" id="htol">
                                        </div>
                                        <div class="sortitem">
                                            <label for="nf" class="text-16-medium evt_mo_sort">{{ __('Newest First')}}</label>
                                            <input type="radio" name="sort_type_offered_operation" value="DESC" id="nf">
                                        </div>
                                        <div class="sortitem">
                                            <label for="of" class="text-16-medium evt_mo_sort">{{ __('Oldest First') }}</label>
                                            <input type="radio" name="sort_type_offered_operation" value="ASC" id="of">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                   
                </div>

                <div class="offered_operations_bottom">
                    <div class="offered_operations_lista">
                        <div class="offered_oprt_wrap">

                            <div class="offered_oprt_dtlmain_wrap" id="ajax_offered_operations_list">

                            </div>

                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    </div>

    <div class="view-history-popup">
        <div class="modal fade" id="offered_history_modal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="text-20-medium">{{ __('Offer History') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="ajax_offered_history_list">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- ------------------------------------------- view operation Modal :st-------------------------------------- --}}
    <div class="group-ofr-popup">
        <div class="modal fade" id="group_offer_operation_popup" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-20-medium">{!! __('Group offer') !!}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="ajax_group_offer_operation_view">
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- ------------------------------------------- view operation Modal :end-------------------------------------- --}}

    {{-- pdf modal --}}
    <x-confrim-offer-contract-modal></x-confrim-offer-contract-modal>

    {{-- -------------------------------------------- update offer modal :st ---------------------------------------- --}}
    <div class="update-ofr-popup">
        <!-- Modal -->
        <div class="modal fade" id="update_offer_popup" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-20-medium">{!! __('Offer') !!}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="ajax_update_offer_view">

                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- ------------------------------------------- update offer modal :nd ---------------------------------------- --}}

    @section('custom_script')
        <script>
            const url_load_more_offered_operations_data =
            "{{ route('offered-operations.ajax-load-more-offered-operations') }}";
            const url_offered_operations_update = "{{ route('offered-operations.ajax-update-offer') }}";
            const url_offered_counter_update_status = "{{ route('counter-offer.ajax-save-offer-status') }}";
            const url_offered_approved_update_status = "{{ route('counter-offer.ajax-confirm-offer-pdf') }}";
            const url_offered_operations_history = "{{ route('offered-operations.ajax-offers-id-list') }}";
            const url_offered_by_id = "{{ route('offered-operations.ajax-offers-by-id') }}";
        </script>
        <script src="{{ asset('plugins/select2-4.1.0-rc.0/dist/js/select2.min.js') }}"></script>
        <script src="{{ asset('plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
        <script src="{{ asset('plugins/carousel/owl.carousel.min.js') }}"></script>
        <script src="{{ asset('js/deals-contracts.js') }}"></script>
        <script src="{{ asset('js/jquery.formatCurrency-1.4.0.js') }}"></script>
        <script src="{{ asset('js/jquery.formatCurrency.all.js') }}"></script>
        <script src="{{ asset('js/custom-number-format.js') }}"></script>
        <script src="{{ asset('js/offered-operations-list.js') }}"></script>
        <script src="{{ asset('plugins/fancybox/fancybox.umd.js') }}"></script>
    @endsection
</x-app-layout>
