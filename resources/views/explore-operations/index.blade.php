<x-app-layout>
    @section('pageTitle', 'Explore Operations')
    @section('custom_style')
        <link href="{{ asset('plugins/select2-4.1.0-rc.0/dist/css/select2.min.css') }}" rel="stylesheet">
        <link href="{{ asset('plugins/carousel/owl.carousel.min.css') }}" rel="stylesheet">
        <link href="{{ asset('plugins/fancybox/fancybox.css') }}" rel="stylesheet">
        <style>
            .pexp_ope{width: calc(100% - 294px);}
            .offer_error {
                border: 1px solid red !important;
            }
            .inline_row {
                display: flex;
            }
            .inline_row span {
                padding:0 3px 0 0;
            }
            .skl_ex_operation{
                height: 114px;
                margin: 0px 0px 4px 0px;
            }
            .resource_wrap [data-bs-toggle="tooltip"]{pointer-events:auto;}

            /*animation css*/
            .hide-right {
                transform: translateX(-100%); /* Move the div to the right side of the screen */
                opacity: 0; /* Make the div completely transparent */
            }
            .hide-left {
                transform: translateX(-100%); /* Move the div to the right side of the screen */
                opacity: 0; /* Make the div completely transparent */
            }
            .ofrpopup_wrap .modal-content {
                overflow: hidden;
            }
            .select2-dropdown {
                z-index:99999;
            }
            .select2-container .select2-search--inline .select2-search__field{background: none !important;}
        </style>
    @endsection

    <div class="main-wapper">
        <div class="explore_document">
            <div class="container">
                <div class="explore_document_page">
                    <div class="exp_doc_sec">
                        <div class="advance_filter">
                            <div class="adv_fil">
                                <i><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
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
                                    
                                    <h5>{!! __('Advanced Filters') !!}</h5>
                                </i>
                            </div>
                            @include('explore-operations.sidebar')
                        </div>
                        <div class="exp_ope pexp_ope">
                            <div class="eo_wrap">
                                <div class="eo_dtl">
                                    <h3>{!! __('Explore Operations') !!}</h3>
                                </div>
                                <div class="offer_wrap">
                                    <a href="{{route('offered-operations.index')}}">
                                    <i><img src="{{ asset('images/mipo/viewsentClock.svg') }}" alt="no-image"></i>{!! __('Sent Offers') !!}</a>
                                </div>
                            </div>
                            <div class="exprow">
                                <div class="expbtn_row">
                                    <div class="">
                                        <label class="btn active" for="doc1">
                                            <input type="radio" class="btn-check filter-document-type" name="doc_type"
                                                value="Cheque" id="doc1" checked>{!! __('Check') !!}
                                        </label>
                                        <label class="btn" for="doc2">
                                            <input type="radio" class="btn-check filter-document-type" name="doc_type"
                                                value="Invoice" id="doc2">{!! __('Invoices') !!}
                                        </label>
                                        <label class="btn" for="doc3">
                                            <input type="radio" class="btn-check filter-document-type" name="doc_type"
                                                value="Contract" id="doc3">{!! __('Contacts') !!}
                                        </label>
                                        <label class="btn" for="doc4">
                                            <input type="radio" class="btn-check filter-document-type" name="doc_type"
                                                value="Other" id="doc4">{!! __('Others') !!}
                                        </label>
                                    </div>
                                </div>
                                <div class="exp_sortby">
                                    <div class="select-dd">
                                        <span class="label">{!! __('Sort by:') !!}</span>
                                        <a href="javascript:void(0)" class="mb_sortby">
                                        <img src="{{ asset('images/mipo/exp_mobileSortby.svg') }}" alt="no-image">
                                        </a>
                                        <select name="sort_type_explore_operation" id="sort_type_explore_operation" class="form-select selectbox">
                                        <option value="DESC">{!! __('Most Recent') !!}</option>
                                        <option value="ASC">{!! __('Expiration') !!}</option>
                                        <option value="DESC">{!! __('Newest') !!}</option>
                                        <option value="ASC">{!! __('Oldest') !!}</option>
                                    </select>
                                    </div>
                                </div>
                            </div>

                            <div class="ope_titlerow">
                                <div class="title">
                                    <h3>{!! __('Operations') !!}</h3>
                                    <div class="checklab">
                                        <input class="form-check-input" type="checkbox" name="chk_all_explore" id="chk_all_explore">
                                        <label for="chk_all_explore">{!! __('Select All Operations') !!}</label>
                                    </div>
                                </div>
                                <div class="btnsbox">
                                    <a href="javascript:void(0)" class="updt evt_refresh_icon" data-device-type="dst" id="refresh_icon"> 
                                        <div class="mbupdate"><img src="{{ asset('images/mipo/mb_update.svg') }}"alt="no-image"></div>
                                        <img src="{{ asset('images/mipo/opupdate.svg') }}"alt="no-image"><span>{!! __('Update') !!}</span>
                                    </a>
                                    <a href="javascript:void(0)" class="ofr btn_group_offer" disabled>{!! __('OFFER') !!}</a>
                                    {{-- <a href="javascript:void(0)" class="ofr btn_group_offer" data-bs-toggle="modal" data-bs-target="#exampleModal" disabled>{!! __('OFFER') !!}</a> --}}
                                </div>
                            </div>
                        <!-- Button trigger modal -->

                            <!-- Modal -->
                        <div class="ofrpopup_wrap">
                            <div class="modal fade group_modal" id="group_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="headerblock">
                                                <div class="modal-header">
                                                    <h5 class="text-16-semibold" id="exampleModalLabel">{!! __('selected offers') !!}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                            {{-- nav tab:st --}}
                                                <div class="tab_row">
                                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                                        <li class="nav-item text-14-medium" role="presentation">
                                                            <button class="nav-link active_inactve_tab" data-currency="USD" id="amedlr-tab" data-bs-toggle="tab" data-bs-target="#amedlr" type="button" role="tab" aria-controls="amedlr" aria-selected="true">{!! __('American Dollar (USD)') !!}</button>
                                                        </li>
                                                        <li class="nav-item text-14-medium" role="presentation">
                                                            <button class="nav-link active_inactve_tab" data-currency="Gs." id="gugs-tab" data-bs-toggle="tab" data-bs-target="#gugs" type="button" role="tab" aria-controls="gugs" aria-selected="false">{!! __('Guarani (Gs.)') !!}</button>
                                                        </li>
                                                    </ul>
                                                        <div class="tab-content" id="ajax_group_explore_operation">
                                                            @if(false)
                                                            <div class="tab-pane fade" id="amedlr" role="tabpanel" aria-labelledby="amedlr-tab">
                                                                <div class="tabDetail_wrap">
                                                                    <div class="index_oprow">
                                                                        <div class="opration text-14-medium">{!! __('Operation') !!}</div>
                                                                        <div class="opration_col text-14-medium">
                                                                            <ul>
                                                                                <li>{!! __('Retention') !!}</li>
                                                                                <li>{!! __('Payment Method') !!}</li>
                                                                                <li>{!! __('Validity of Offer') !!}</li>
                                                                                <li>{!! __('Offer') !!}</li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>

                                                                  {{--   <div class="billbox">
                                                                        <div class="table_content">
                                                                            <div class="infobox">
                                                                                <div class="namebox">
                                                                                    <h3 class="text-16-semibold">{!! __('Arya Kagathara') !!}</h3>
                                                                                    <img src="{{ asset('images/mipo/singlestr.png') }}" alt="no-image">
                                                                                    <span>{!! __('4.5/5 (50)') !!}</span>
                                                                                </div>
                                                                                <div class="cheque">
                                                                                    <p class="text-12-medium">{!! __('CHEQUE - OP0001') !!} <span>{!! __('Bank Transfer') !!}</span></p>
                                                                                </div>
                                                                                <div class="company text-12-medium">
                                                                                    <a href="javascript:void(0)">{!! __('Cocacola Soda Ltd.') !!}</a>
                                                                                    <span>{!! __('Expires in 1 hour') !!}</span>
                                                                                    <p>{!! __('$80,00,000') !!}</p>
                                                                                </div>
                                                                            </div>
                                                                            <div class="input_column">
                                                                                <ul>
                                                                                    <li>
                                                                                        <div class="checkimg">
                                                                                            <input type="checkbox" name="ofr_type" id="ofrcheck1">
                                                                                            <label for="ofrcheck1"><img src="{{ asset('images/mipo/exp_mipo.svg') }}" alt="no-image"></label>
                                                                                        </div>
                                                                                    </li>

                                                                                    <li>
                                                                                        <div class="retention">
                                                                                            <input class="text-12-medium" type="number" placeholder="10,000">
                                                                                            <div class="dolr"><img src="{{ asset('images/mipo/ofr_dollar.svg') }}" alt="no-image"></div>
                                                                                        </div>
                                                                                    </li>

                                                                                    <li>
                                                                                        <div class="banktrans">
                                                                                            <select name="paymentofr" id="paymentofr" class="select_transfer text-12-medium">
                                                                                                <option value="banktra">{!! __('Bank Transfer') !!}</option>
                                                                                                <option value="cash">{!! __('Cash') !!}</option>
                                                                                                <option value="ewallet">{!! __('eWallet') !!}</option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </li>

                                                                                    <li>
                                                                                        <div class="validofr">
                                                                                            <input class="text-12-medium" type="number" placeholder="No.">
                                                                                            <select name="validity_select" id="validity_select" class="validityofr_select text-12-medium">
                                                                                                <option value="hour">{!! __('Hour') !!}</option>
                                                                                                <option value="day">{!! __('Day') !!}</option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </li>

                                                                                    <li>
                                                                                        <div class="retention ofdlr">
                                                                                            <input class="text-12-medium" type="number" placeholder="70,000">
                                                                                            <div class="dolr"><img src="{{ asset('images/mipo/ofr_dollar.svg') }}" alt="no-image"></div>
                                                                                            <a href="javascript:void(0)"><img src="{{ asset('images/mipo/ofrcloseicon.svg') }}" alt="no-image"></a>
                                                                                        </div>
                                                                                    </li>
                                                                                </ul>
                                                                                    <div class="offerboxlink">
                                                                                        <a href="javascript:void(0)" class="text-12-medium">{!! __('OFFER') !!}</a>
                                                                                    </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="table_content">
                                                                            <div class="infobox">
                                                                                <div class="cheque">
                                                                                    <p class="text-12-medium">{!! __('CHEQUE - OP0001') !!} <span>{!! __('Bank Transfer') !!}</span></p>
                                                                                </div>
                                                                                <div class="company text-12-medium">
                                                                                    <a href="javascript:void(0)">{!! __('Cocacola Soda Ltd.') !!}</a>
                                                                                    <span>{!! __('Expires in 1 hour') !!}</span>
                                                                                    <p>{!! __('$80,00,000') !!}</p>
                                                                                </div>
                                                                            </div>
                                                                            <div class="input_column">
                                                                                <ul>
                                                                                    <li>
                                                                                        <div class="checkimg">
                                                                                            <input type="checkbox" name="ofr_type" id="ofrcheck2">
                                                                                            <label for="ofrcheck2"><img src="http://localhost:8000/images/mipo/exp_mipo.svg" alt="no-image"></label>
                                                                                        </div>
                                                                                    </li>

                                                                                    <li>
                                                                                        <div class="retention">
                                                                                            <input class="text-12-medium" type="number" placeholder="10,000">
                                                                                            <div class="dolr"><img src="http://localhost:8000/images/mipo/ofr_dollar.svg" alt="no-image"></div>
                                                                                        </div>
                                                                                    </li>

                                                                                    <li>
                                                                                        <div class="banktrans">
                                                                                            <select name="paymentofr" id="paymentofr" class="select_transfer text-12-medium">
                                                                                                <option value="banktra">{!! __('Bank Transfer') !!}</option>
                                                                                                <option value="cash">{!! __('Cash') !!}</option>
                                                                                                <option value="ewallet">{!! __('eWallet') !!}</option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </li>

                                                                                    <li>
                                                                                        <div class="validofr">
                                                                                            <input class="text-12-medium" type="number" placeholder="No.">
                                                                                            <select name="validity_select" id="validity_select" class="validityofr_select text-12-medium">
                                                                                                <option value="hour">{!! __('Hour') !!}</option>
                                                                                                <option value="day">{!! __('Day') !!}</option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </li>

                                                                                    <li>
                                                                                        <div class="retention ofdlr">
                                                                                            <input class="text-12-medium" type="number" placeholder="70,000">
                                                                                            <div class="dolr"><img src="http://localhost:8000/images/mipo/ofr_dollar.svg" alt="no-image"></div>
                                                                                            <a href="javascript:void(0)"><img src="http://localhost:8000/images/mipo/ofrcloseicon.svg" alt="no-image"></a>
                                                                                        </div>
                                                                                    </li>
                                                                                </ul>
                                                                                    <div class="offerboxlink">
                                                                                        <a href="javascript:void(0)" class="text-12-medium">{!! __('OFFER') !!}</a>
                                                                                    </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="table_content total_wrap">
                                                                            <div class="totalbox">
                                                                                <input type="checkbox" name="ofr_type" id="total">
                                                                                <label for="total" class="text-14-medium">{!! __('Totals: $16,000,000') !!}</label>
                                                                            </div>
                                                                            <div class="input_column">
                                                                                <ul>
                                                                                    <li>
                                                                                        <div class="checkimg">
                                                                                            <input type="checkbox" name="ofr_type" id="ofrcheck3">
                                                                                            <label for="ofrcheck3"><img src="http://localhost:8000/images/mipo/exp_mipo.svg" alt="no-image"></label>
                                                                                        </div>
                                                                                    </li>

                                                                                    <li>
                                                                                        <div class="retention">
                                                                                            <input class="text-12-medium" type="number" placeholder="10,000">
                                                                                            <div class="dolr"><img src="http://localhost:8000/images/mipo/ofr_dollar.svg" alt="no-image"></div>
                                                                                        </div>
                                                                                    </li>

                                                                                    <li>
                                                                                        <div class="banktrans">
                                                                                            <select name="paymentofr" id="paymentofr" class="select_transfer text-12-medium">
                                                                                                <option value="banktra">{!! __('Bank Transfer') !!}</option>
                                                                                                <option value="cash">{!! __('Cash') !!}</option>
                                                                                                <option value="ewallet">{!! __('eWallet') !!}</option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </li>

                                                                                    <li>
                                                                                        <div class="validofr">
                                                                                            <input class="text-12-medium" type="number" placeholder="No.">
                                                                                            <select name="validity_select" id="validity_select" class="validityofr_select text-12-medium">
                                                                                                <option value="hour">{!! __('Hour') !!}</option>
                                                                                                <option value="day">{!! __('Day') !!}</option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </li>

                                                                                    <li>
                                                                                        <div class="retention ofdlr">
                                                                                            <input class="text-12-medium" type="number" placeholder="70,000">
                                                                                            <div class="dolr"><img src="http://localhost:8000/images/mipo/ofr_dollar.svg" alt="no-image"></div>
                                                                                            <a href="javascript:void(0)"><img src="http://localhost:8000/images/mipo/ofrcloseicon.svg" alt="no-image"></a>
                                                                                        </div>
                                                                                    </li>
                                                                                </ul>
                                                                                    <div class="offerboxlink">
                                                                                        <a href="javascript:void(0)" class="text-12-medium">{!! __('OFFER') !!}</a>
                                                                                    </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="billbox">
                                                                        <div class="table_content">
                                                                            <div class="infobox">
                                                                                <div class="namebox">
                                                                                    <h3 class="text-16-semibold">{!! __('Samir Kaila') !!}</h3>
                                                                                    <img src="{{ asset('images/mipo/singlestr.png') }}" alt="no-image">
                                                                                    <span>{!! __('4.5/5 (50)') !!}</span>
                                                                                </div>
                                                                                <div class="cheque">
                                                                                    <p class="text-12-medium">{!! __('CHEQUE - OP0001') !!} <span>{!! __('Bank Transfer') !!}</span></p>
                                                                                </div>
                                                                                <div class="company text-12-medium">
                                                                                    <a href="javascript:void(0)">{!! __('Cocacola Soda Ltd.') !!}</a>
                                                                                    <span>{!! __('Expires in 1 hour') !!}</span>
                                                                                    <p>{!! __('$80,00,000') !!}</p>
                                                                                </div>
                                                                            </div>
                                                                            <div class="input_column">
                                                                                <ul>
                                                                                    <li>
                                                                                        <div class="checkimg">
                                                                                            <input type="checkbox" name="ofr_type" id="ofrcheck4">
                                                                                            <label for="ofrcheck4"><img src="{{ asset('images/mipo/exp_mipo.svg') }}" alt="no-image"></label>
                                                                                        </div>
                                                                                    </li>

                                                                                    <li>
                                                                                        <div class="retention">
                                                                                            <input class="text-12-medium" type="number" placeholder="10,000">
                                                                                            <div class="dolr"><img src="{{ asset('images/mipo/ofr_dollar.svg') }}" alt="no-image"></div>
                                                                                        </div>
                                                                                    </li>

                                                                                    <li>
                                                                                        <div class="banktrans">
                                                                                            <select name="paymentofr" id="paymentofr" class="select_transfer text-12-medium">
                                                                                                <option value="banktra">{!! __('Bank Transfer') !!}</option>
                                                                                                <option value="cash">{!! __('Cash') !!}</option>
                                                                                                <option value="ewallet">{!! __('eWallet') !!}</option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </li>

                                                                                    <li>
                                                                                        <div class="validofr">
                                                                                            <input class="text-12-medium" type="number" placeholder="No.">
                                                                                            <select name="validity_select" id="validity_select" class="validityofr_select text-12-medium">
                                                                                                <option value="hour">{!! __('Hour') !!}</option>
                                                                                                <option value="day">{!! __('Day') !!}</option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </li>

                                                                                    <li>
                                                                                        <div class="retention ofdlr">
                                                                                            <input class="text-12-medium" type="number" placeholder="70,000">
                                                                                            <div class="dolr"><img src="{{ asset('images/mipo/ofr_dollar.svg') }}" alt="no-image"></div>
                                                                                            <a href="javascript:void(0)"><img src="{{ asset('images/mipo/ofrcloseicon.svg') }}" alt="no-image"></a>
                                                                                        </div>
                                                                                    </li>
                                                                                </ul>
                                                                                    <div class="offerboxlink">
                                                                                        <a href="javascript:void(0)" class="text-12-medium">{!! __('OFFER') !!}</a>
                                                                                    </div>
                                                                            </div>
                                                                        </div>
                                                                    </div> --}}

                                                                    <div class="modal-footer">
                                                                        <button type="button" class="mdl_close text-18-medium" data-bs-dismiss="modal">{!! __('Close') !!}</button>
                                                                        <button type="button" class="btn btn-primary bigofr">{!! __('OFFER') !!}</button>
                                                                    </div>
                            
                                                                    {{-- summary:st --}}
                                                                    <div class="grp_oprt_summary">
                                                                            <div class="grp_oprt_summary_row">
                                                                                <div class="grp_oprt_summary_col">
                                                                                    <div class="grp_oprt_summary_box">
                                                                                        <div class="grp_oprt_summary_title text-20-medium">{!! __('Individual Operation Summary') !!}</div>
                                                                                        <div class="grp_oprt_summary_block">
                                                                                            <div class="name_grp_oprt text-16-medium ">{!! __('Arya Kagathara') !!}</div>
                                                                                            <div class="grp_oprt_summary_dtlblk text-14-medium">
                                                                                                <div class="grp_oprt_summary_heading cqno"><span>{!! __('CHEQUE - OP0001') !!}</span></div>
                                                                                                <div class="grp_oprt_summary_dtl"><span>{!! __('8,000 U$D') !!}</span></div>
                                                                                            </div>
                            
                                                                                            <div class="grp_oprt_summary_dtlblk text-14-medium">
                                                                                                <div class="grp_oprt_summary_heading"><span>{!! __('Retention') !!}</span></div>
                                                                                                <div class="grp_oprt_summary_dtl"><span>{!! __('7,500 U$D') !!}</span></div>
                                                                                            </div>
                                                                                            <div class="grp_oprt_summary_dtlblk text-14-medium">
                                                                                                <div class="grp_oprt_summary_heading"><span>{!! __('Real Time Offer') !!}</span></div>
                                                                                                <div class="grp_oprt_summary_dtl"><span>{!! __('6,500 U$D') !!}</span></div>
                                                                                            </div>
                                                                                            <div class="grp_oprt_summary_dtlblk text-14-medium">
                                                                                                <div class="grp_oprt_summary_heading"><span>{!! __('Mipo Commission (20%)') !!}</span></div>
                                                                                                <div class="grp_oprt_summary_dtl"><span>{!! __('200 U$D') !!}</span></div>
                                                                                            </div>
                                                                                            <div class="grp_oprt_summary_dtlblk text-14-medium">
                                                                                                <div class="grp_oprt_summary_heading"><span>{!! __('MIPO+ Guaranteed Repurchase (2%)') !!}</span></div>
                                                                                                <div class="grp_oprt_summary_dtl"><span>{!! __('0 U$D') !!}</span></div>
                                                                                            </div>
                                                                                            <div class="grp_oprt_summary_dtlblk sum_ftr text-16-medium">
                                                                                                <div class="grp_oprt_summary_heading"><span>{!! __('Net Profit') !!}</span></div>
                                                                                                <div class="grp_oprt_summary_dtl"><span>{!! __('1.600 U$D') !!}</span></div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="grp_oprt_summary_col">
                                                                                    <div class="grp_oprt_summary_box">
                                                                                        <div class="grp_oprt_summary_title text-20-medium">{!! __('Overall Operation Summary') !!}</div>
                                                                                        <div class="grp_oprt_summary_block">
                                                                                            <div class="name_grp_oprt text-16-medium ">{!! __('Offer Totals') !!}</div>
                                                                                            <div class="grp_oprt_summary_dtlblk text-14-medium">
                                                                                                <div class="grp_oprt_summary_heading cqno"><span>{!! __('Group Offer - OP001') !!}</span></div>
                                                                                                <div class="grp_oprt_summary_dtl"><span>{!! __('8,000 U$D') !!}</span></div>
                                                                                            </div>
                            
                                                                                            <div class="grp_oprt_summary_dtlblk text-14-medium">
                                                                                                <div class="grp_oprt_summary_heading"><span>{!! __('Retention') !!}</span></div>
                                                                                                <div class="grp_oprt_summary_dtl"><span>{!! __('7,500 U$D') !!}</span></div>
                                                                                            </div>
                                                                                            <div class="grp_oprt_summary_dtlblk text-14-medium">
                                                                                                <div class="grp_oprt_summary_heading"><span>{!! __('Real Time Offer') !!}</span></div>
                                                                                                <div class="grp_oprt_summary_dtl"><span>{!! __('6,500 U$D') !!}</span></div>
                                                                                            </div>
                                                                                            <div class="grp_oprt_summary_dtlblk text-14-medium">
                                                                                                <div class="grp_oprt_summary_heading"><span>{!! __('Mipo Commission (20%)') !!}</span></div>
                                                                                                <div class="grp_oprt_summary_dtl"><span>{!! __('200 U$D') !!}</span></div>
                                                                                            </div>
                                                                                            <div class="grp_oprt_summary_dtlblk text-14-medium">
                                                                                                <div class="grp_oprt_summary_heading"><span>{!! __('Mipo Commission (20%)') !!}</span></div>
                                                                                                <div class="grp_oprt_summary_dtl"><span>{!! __('0 U$D') !!}</span></div>
                                                                                            </div>
                                                                                            <div class="grp_oprt_summary_dtlblk sum_ftr text-16-medium">
                                                                                                <div class="grp_oprt_summary_heading"><span>{!! __('Beneficio neto') !!}</span></div>
                                                                                                <div class="grp_oprt_summary_dtl"><span>{!! __('1.600 U$D') !!}</span></div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                    </div>
                                                                    {{-- summary:nd --}}
                                                                </div>
                                                            </div>

                                                            <div class="tab-pane fade" id="gugs" role="tabpanel" aria-labelledby="gugs-tab">
                                                                <div class="tabDetail_wrap">
                                                                    <div class="index_oprow">
                                                                        <div class="opration text-14-medium">{!! __('Operation') !!}</div>
                                                                        <div class="opration_col text-14-medium">
                                                                            <ul>
                                                                                <li>{!! __('Retention') !!}</li>
                                                                                <li>{!! __('Payment Method') !!}</li>
                                                                                <li>{!! __('Validity of Offer') !!}</li>
                                                                                <li>{!! __('Offer') !!}</li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>

                                                                    <div class="billbox">
                                                                        <div class="table_content">
                                                                            <div class="infobox">
                                                                                <div class="namebox">
                                                                                    <h3 class="text-16-semibold">{!! __('Arya Kagathara') !!}</h3>
                                                                                    <img src="{{ asset('images/mipo/singlestr.png') }}" alt="no-image">
                                                                                    <span>{!! __('4.5/5 (50)') !!}</span>
                                                                                </div>
                                                                                <div class="cheque">
                                                                                    <p class="text-12-medium">{!! __('CHEQUE - OP0001') !!} <span>{!! __('Bank Transfer') !!}</span></p>
                                                                                </div>
                                                                                <div class="company text-12-medium">
                                                                                    <a href="javascript:void(0)">{!! __('Cocacola Soda Ltd.') !!}</a>
                                                                                    <span>{!! __('Expires in 1 hour') !!}</span>
                                                                                    <p>{!! __('$80,00,000') !!}</p>
                                                                                </div>
                                                                            </div>
                                                                            <div class="input_column">
                                                                                <ul>
                                                                                    <li>
                                                                                        <div class="checkimg">
                                                                                            <input type="checkbox" name="ofr_type" id="ofrcheck1">
                                                                                            <label for="ofrcheck1"><img src="{{ asset('images/mipo/exp_mipo.svg') }}" alt="no-image"></label>
                                                                                        </div>
                                                                                    </li>

                                                                                    <li>
                                                                                        <div class="retention">
                                                                                            <input class="text-12-medium" type="number" placeholder="10,000">
                                                                                            <div class="dolr"><img src="{{ asset('images/mipo/ofr_dollar.svg') }}" alt="no-image"></div>
                                                                                        </div>
                                                                                    </li>

                                                                                    <li>
                                                                                        <div class="banktrans">
                                                                                            <select name="paymentofr" id="paymentofr" class="select_transfer text-12-medium">
                                                                                                <option value="banktra">{!! __('Bank Transfer') !!}</option>
                                                                                                <option value="cash">{!! __('Cash') !!}</option>
                                                                                                <option value="ewallet">{!! __('eWallet') !!}</option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </li>

                                                                                    <li>
                                                                                        <div class="validofr">
                                                                                            <input class="text-12-medium" type="number" placeholder="No.">
                                                                                            <select name="validity_select" id="validity_select" class="validityofr_select text-12-medium">
                                                                                                <option value="hour">{!! __('Hour') !!}</option>
                                                                                                <option value="day">{!! __('Day') !!}</option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </li>

                                                                                    <li>
                                                                                        <div class="retention ofdlr">
                                                                                            <input class="text-12-medium" type="number" placeholder="70,000">
                                                                                            <div class="dolr"><img src="{{ asset('images/mipo/ofr_dollar.svg') }}" alt="no-image"></div>
                                                                                            <a href="javascript:void(0)"><img src="{{ asset('images/mipo/ofrcloseicon.svg') }}" alt="no-image"></a>
                                                                                        </div>
                                                                                    </li>
                                                                                </ul>
                                                                                    <div class="offerboxlink">
                                                                                        <a href="javascript:void(0)" class="text-12-medium">{!! __('OFFER') !!}</a>
                                                                                    </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="table_content">
                                                                            <div class="infobox">
                                                                                <div class="cheque">
                                                                                    <p class="text-12-medium">{!! __('CHEQUE - OP0001') !!} <span>{!! __('Bank Transfer') !!}</span></p>
                                                                                </div>
                                                                                <div class="company text-12-medium">
                                                                                    <a href="javascript:void(0)">{!! __('Cocacola Soda Ltd.') !!}</a>
                                                                                    <span>{!! __('Expires in 1 hour') !!}</span>
                                                                                    <p>{!! __('$80,00,000') !!}</p>
                                                                                </div>
                                                                            </div>
                                                                            <div class="input_column">
                                                                                <ul>
                                                                                    <li>
                                                                                        <div class="checkimg">
                                                                                            <input type="checkbox" name="ofr_type" id="ofrcheck2">
                                                                                            <label for="ofrcheck2"><img src="http://localhost:8000/images/mipo/exp_mipo.svg" alt="no-image"></label>
                                                                                        </div>
                                                                                    </li>

                                                                                    <li>
                                                                                        <div class="retention">
                                                                                            <input class="text-12-medium" type="number" placeholder="10,000">
                                                                                            <div class="dolr"><img src="http://localhost:8000/images/mipo/ofr_dollar.svg" alt="no-image"></div>
                                                                                        </div>
                                                                                    </li>

                                                                                    <li>
                                                                                        <div class="banktrans">
                                                                                            <select name="paymentofr" id="paymentofr" class="select_transfer text-12-medium">
                                                                                                <option value="banktra">{!! __('Bank Transfer') !!}</option>
                                                                                                <option value="cash">{!! __('Cash') !!}</option>
                                                                                                <option value="ewallet">{!! __('eWallet') !!}</option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </li>

                                                                                    <li>
                                                                                        <div class="validofr">
                                                                                            <input class="text-12-medium" type="number" placeholder="No.">
                                                                                            <select name="validity_select" id="validity_select" class="validityofr_select text-12-medium">
                                                                                                <option value="hour">{!! __('Hour') !!}</option>
                                                                                                <option value="day">{!! __('Day') !!}</option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </li>

                                                                                    <li>
                                                                                        <div class="retention ofdlr">
                                                                                            <input class="text-12-medium" type="number" placeholder="70,000">
                                                                                            <div class="dolr"><img src="http://localhost:8000/images/mipo/ofr_dollar.svg" alt="no-image"></div>
                                                                                            <a href="javascript:void(0)"><img src="http://localhost:8000/images/mipo/ofrcloseicon.svg" alt="no-image"></a>
                                                                                        </div>
                                                                                    </li>
                                                                                </ul>
                                                                                    <div class="offerboxlink">
                                                                                        <a href="javascript:void(0)" class="text-12-medium">{!! __('OFFER') !!}</a>
                                                                                    </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="table_content total_wrap">
                                                                            <div class="totalbox">
                                                                                <input type="checkbox" name="ofr_type" id="total">
                                                                                <label for="total" class="text-14-medium">{!! __('Totals: $16,000,000') !!}</label>
                                                                            </div>
                                                                            <div class="input_column">
                                                                                <ul>
                                                                                    <li>
                                                                                        <div class="checkimg">
                                                                                            <input type="checkbox" name="ofr_type" id="ofrcheck3">
                                                                                            <label for="ofrcheck3"><img src="http://localhost:8000/images/mipo/exp_mipo.svg" alt="no-image"></label>
                                                                                        </div>
                                                                                    </li>

                                                                                    <li>
                                                                                        <div class="retention">
                                                                                            <input class="text-12-medium" type="number" placeholder="10,000">
                                                                                            <div class="dolr"><img src="http://localhost:8000/images/mipo/ofr_dollar.svg" alt="no-image"></div>
                                                                                        </div>
                                                                                    </li>

                                                                                    <li>
                                                                                        <div class="banktrans">
                                                                                            <select name="paymentofr" id="paymentofr" class="select_transfer text-12-medium">
                                                                                                <option value="banktra">{!! __('Bank Transfer') !!}</option>
                                                                                                <option value="cash">{!! __('Cash') !!}</option>
                                                                                                <option value="ewallet">{!! __('eWallet') !!}</option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </li>

                                                                                    <li>
                                                                                        <div class="validofr">
                                                                                            <input class="text-12-medium" type="number" placeholder="No.">
                                                                                            <select name="validity_select" id="validity_select" class="validityofr_select text-12-medium">
                                                                                                <option value="hour">{!! __('Hour') !!}</option>
                                                                                                <option value="day">{!! __('Day') !!}</option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </li>

                                                                                    <li>
                                                                                        <div class="retention ofdlr">
                                                                                            <input class="text-12-medium" type="number" placeholder="70,000">
                                                                                            <div class="dolr"><img src="http://localhost:8000/images/mipo/ofr_dollar.svg" alt="no-image"></div>
                                                                                            <a href="javascript:void(0)"><img src="http://localhost:8000/images/mipo/ofrcloseicon.svg" alt="no-image"></a>
                                                                                        </div>
                                                                                    </li>
                                                                                </ul>
                                                                                    <div class="offerboxlink">
                                                                                        <a href="javascript:void(0)" class="text-12-medium">{!! __('OFFER') !!}</a>
                                                                                    </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="billbox">
                                                                        <div class="table_content">
                                                                            <div class="infobox">
                                                                                <div class="namebox">
                                                                                    <h3 class="text-16-semibold">{!! __('Samir Kaila') !!}</h3>
                                                                                    <img src="{{ asset('images/mipo/singlestr.png') }}" alt="no-image">
                                                                                    <span>{!! __('4.5/5 (50)') !!}</span>
                                                                                </div>
                                                                                <div class="cheque">
                                                                                    <p class="text-12-medium">{!! __('CHEQUE - OP0001') !!} <span>{!! __('Bank Transfer') !!}</span></p>
                                                                                </div>
                                                                                <div class="company text-12-medium">
                                                                                    <a href="javascript:void(0)">{!! __('Cocacola Soda Ltd.') !!}</a>
                                                                                    <span>{!! __('Expires in 1 hour') !!}</span>
                                                                                    <p>{!! __('$80,00,000') !!}</p>
                                                                                </div>
                                                                            </div>
                                                                            <div class="input_column">
                                                                                <ul>
                                                                                    <li>
                                                                                        <div class="checkimg">
                                                                                            <input type="checkbox" name="ofr_type" id="ofrcheck4">
                                                                                            <label for="ofrcheck4"><img src="{{ asset('images/mipo/exp_mipo.svg') }}" alt="no-image"></label>
                                                                                        </div>
                                                                                    </li>

                                                                                    <li>
                                                                                        <div class="retention">
                                                                                            <input class="text-12-medium" type="number" placeholder="10,000">
                                                                                            <div class="dolr"><img src="{{ asset('images/mipo/ofr_dollar.svg') }}" alt="no-image"></div>
                                                                                        </div>
                                                                                    </li>

                                                                                    <li>
                                                                                        <div class="banktrans">
                                                                                            <select name="paymentofr" id="paymentofr" class="select_transfer text-12-medium">
                                                                                                <option value="banktra">{!! __('Bank Transfer') !!}</option>
                                                                                                <option value="cash">{!! __('Cash') !!}</option>
                                                                                                <option value="ewallet">{!! __('eWallet') !!}</option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </li>

                                                                                    <li>
                                                                                        <div class="validofr">
                                                                                            <input class="text-12-medium" type="number" placeholder="No.">
                                                                                            <select name="validity_select" id="validity_select" class="validityofr_select text-12-medium">
                                                                                                <option value="hour">{!! __('Hour') !!}</option>
                                                                                                <option value="day">{!! __('Day') !!}</option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </li>

                                                                                    <li>
                                                                                        <div class="retention ofdlr">
                                                                                            <input class="text-12-medium" type="number" placeholder="70,000">
                                                                                            <div class="dolr"><img src="{{ asset('images/mipo/ofr_dollar.svg') }}" alt="no-image"></div>
                                                                                            <a href="javascript:void(0)"><img src="{{ asset('images/mipo/ofrcloseicon.svg') }}" alt="no-image"></a>
                                                                                        </div>
                                                                                    </li>
                                                                                </ul>
                                                                                    <div class="offerboxlink">
                                                                                        <a href="javascript:void(0)" class="text-12-medium">{!! __('OFFER') !!}</a>
                                                                                    </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="modal-footer">
                                                                        <button type="button" class="mdl_close text-18-medium" data-bs-dismiss="modal">{!! __('Close') !!}</button>
                                                                        <button type="button" class="btn btn-primary bigofr">{!! __('OFFER') !!}</button>
                                                                    </div>
                            
                                                                    {{-- summary:st --}}
                                                                    <div class="grp_oprt_summary">
                                                                            <div class="grp_oprt_summary_row">
                                                                                <div class="grp_oprt_summary_col">
                                                                                    <div class="grp_oprt_summary_box">
                                                                                        <div class="grp_oprt_summary_title text-20-medium">{!! __('Individual Operation Summary') !!}</div>
                                                                                        <div class="grp_oprt_summary_block">
                                                                                            <div class="name_grp_oprt text-16-medium ">{!! __('Arya Kagathara') !!}</div>
                                                                                            <div class="grp_oprt_summary_dtlblk text-14-medium">
                                                                                                <div class="grp_oprt_summary_heading cqno"><span>{!! __('CHEQUE - OP0001') !!}</span></div>
                                                                                                <div class="grp_oprt_summary_dtl"><span>{!! __('8,000 U$D') !!}</span></div>
                                                                                            </div>
                            
                                                                                            <div class="grp_oprt_summary_dtlblk text-14-medium">
                                                                                                <div class="grp_oprt_summary_heading"><span>{!! __('Retention') !!}</span></div>
                                                                                                <div class="grp_oprt_summary_dtl"><span>{!! __('7,500 U$D') !!}</span></div>
                                                                                            </div>
                                                                                            <div class="grp_oprt_summary_dtlblk text-14-medium">
                                                                                                <div class="grp_oprt_summary_heading"><span>{!! __('Real Time Offer') !!}</span></div>
                                                                                                <div class="grp_oprt_summary_dtl"><span>{!! __('6,500 U$D') !!}</span></div>
                                                                                            </div>
                                                                                            <div class="grp_oprt_summary_dtlblk text-14-medium">
                                                                                                <div class="grp_oprt_summary_heading"><span>{!! __('Mipo Commission (20%)') !!}</span></div>
                                                                                                <div class="grp_oprt_summary_dtl"><span>{!! __('200 U$D') !!}</span></div>
                                                                                            </div>
                                                                                            <div class="grp_oprt_summary_dtlblk text-14-medium">
                                                                                                <div class="grp_oprt_summary_heading"><span>{!! __('MIPO+ Guaranteed Repurchase (2%)') !!}</span></div>
                                                                                                <div class="grp_oprt_summary_dtl"><span>{!! __('0 U$D') !!}</span></div>
                                                                                            </div>
                                                                                            <div class="grp_oprt_summary_dtlblk sum_ftr text-16-medium">
                                                                                                <div class="grp_oprt_summary_heading"><span>{!! __('Net Profit') !!}</span></div>
                                                                                                <div class="grp_oprt_summary_dtl"><span>{!! __('1.600 U$D') !!}</span></div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="grp_oprt_summary_col">
                                                                                    <div class="grp_oprt_summary_box">
                                                                                        <div class="grp_oprt_summary_title text-20-medium">{!! __('Overall Operation Summary') !!}</div>
                                                                                        <div class="grp_oprt_summary_block">
                                                                                            <div class="name_grp_oprt text-16-medium ">{!! __('Offer Totals') !!}</div>
                                                                                            <div class="grp_oprt_summary_dtlblk text-14-medium">
                                                                                                <div class="grp_oprt_summary_heading cqno"><span>{!! __('Group Offer - OP001') !!}</span></div>
                                                                                                <div class="grp_oprt_summary_dtl"><span>{!! __('8,000 U$D') !!}</span></div>
                                                                                            </div>
                            
                                                                                            <div class="grp_oprt_summary_dtlblk text-14-medium">
                                                                                                <div class="grp_oprt_summary_heading"><span>{!! __('Retention') !!}</span></div>
                                                                                                <div class="grp_oprt_summary_dtl"><span>{!! __('7,500 U$D') !!}</span></div>
                                                                                            </div>
                                                                                            <div class="grp_oprt_summary_dtlblk text-14-medium">
                                                                                                <div class="grp_oprt_summary_heading"><span>{!! __('Real Time Offer') !!}</span></div>
                                                                                                <div class="grp_oprt_summary_dtl"><span>{!! __('6,500 U$D') !!}</span></div>
                                                                                            </div>
                                                                                            <div class="grp_oprt_summary_dtlblk text-14-medium">
                                                                                                <div class="grp_oprt_summary_heading"><span>{!! __('Mipo Commission (20%)') !!}</span></div>
                                                                                                <div class="grp_oprt_summary_dtl"><span>{!! __('200 U$D') !!}</span></div>
                                                                                            </div>
                                                                                            <div class="grp_oprt_summary_dtlblk text-14-medium">
                                                                                                <div class="grp_oprt_summary_heading"><span>{!! __('Mipo Commission (20%)') !!}</span></div>
                                                                                                <div class="grp_oprt_summary_dtl"><span>{!! __('0 U$D') !!}</span></div>
                                                                                            </div>
                                                                                            <div class="grp_oprt_summary_dtlblk sum_ftr text-16-medium">
                                                                                                <div class="grp_oprt_summary_heading"><span>{!! __('Beneficio neto') !!}</span></div>
                                                                                                <div class="grp_oprt_summary_dtl"><span>{!! __('1.600 U$D') !!}</span></div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                    </div>
                                                                    {{-- summary:nd --}}
                                                                </div>
                                                            </div>
                                                            @endif
                                                        </div>
                                                </div>
                                                {{-- nav tab:nd --}}
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>

                            <div class="explore_document_wrap_main" id="ajax_explore_operations_list">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

{{-- 991 tab,mobile to new html :st--}}
    <div class="mobile_expop_wrap">
            <div class="titlewrap" id="eop_explore_side_bar_modal">
                <div class="titlebox">
                    <a href="javascript:;">
                        <img src="{{ asset('images/mipo/explorer_op_filter.svg') }}" class="day" alt="no-image">
                        <img src="{{ asset('images/mipo/adv_filter_white.svg') }}" class="night" alt="no-image">

                    </a>
                    <h2 class="text-20-semibold">{{ __('Explore Operations') }}</h2>
                </div>
                    @include('explore-operations.mobile-sidebar')
                <div class="repeat">
                    <a href="javascript:;" class="daywhite evt_refresh_icon" data-device-type="mob"><img src="{{ asset('images/mipo/explorer_op_repeat.svg') }}" alt="no-image"></a>
                    <a href="javascript:;" class="dark_repeat evt_refresh_icon" data-device-type="mob"><img src="{{ asset('images/mipo/whiteclockop.svg') }}" alt="no-image"></a>
                </div>
            </div>

            <div class="mobile_operation_tab">
                <div class="tab_row">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item text-16-medium evt_doc_type_mobile" role="presentation" data-doc-val="Cheque">
                            <button class="nav-link active" id="cheque-tab" data-bs-toggle="tab" data-bs-target="#cheque" type="button" role="tab" aria-controls="cheque" aria-selected="true">{!! __('Cheque') !!}</button>
                        </li>
                        <li class="nav-item text-16-medium evt_doc_type_mobile" role="presentation" data-doc-val="Invoice">
                            <button class="nav-link" id="invoices-tab" data-bs-toggle="tab" data-bs-target="#invoice" type="button" role="tab" aria-controls="invoices" aria-selected="false">{!! __('Invoices') !!}</button>
                        </li>
                        <li class="nav-item text-16-medium evt_doc_type_mobile" role="presentation"  data-doc-val="Contract">
                            <button class="nav-link" id="contact-tab" data-bs-toggle="tab"data-bs-target="#contract" type="button" role="tab" aria-controls="contact" aria-selected="false">{!! __('Contacts') !!}</button>
                        </li>
                        <li class="nav-item text-16-medium evt_doc_type_mobile" role="presentation" data-doc-val="Other">
                            <button class="nav-link" id="other-tab" data-bs-toggle="tab" data-bs-target="#other" type="button" role="tab" aria-controls="others" aria-selected="false">{!! __('Others') !!}</button>
                        </li>
                    </ul>

                    {{-- sorting icon --}}
                    <div class="mbop_sort">
                        <a href="javacript:;" class="daysort"><img src="{{ asset('images/mipo/mobile_operationofr.svg') }}" alt="no-image"></a>
                        <a href="javacript:;" class="nightsort"><img src="{{ asset('images/mipo/mobilewhitesorting.svg') }}" alt="no-image"></a>
                    </div>
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
                                        <label for="ltoh" class="text-16-medium">{{ __('Price - Low to High') }}</label>
                                        <input type="radio" class="evt_sort_type_mobile" value="ASC" name="sort_type_explore_operation" id="ltoh">
                                    </div>
                                    <div class="sortitem">
                                        <label for="htol" class="text-16-medium">{{ __('Price - High to Low') }}</label>
                                        <input type="radio" class="evt_sort_type_mobile" value="DESC" name="sort_type_explore_operation" id="htol">
                                    </div>
                                    <div class="sortitem">
                                        <label for="nf" class="text-16-medium">{{ __('Newest First') }}</label>
                                        <input type="radio" class="evt_sort_type_mobile" value="DESC" name="sort_type_explore_operation" id="nf">
                                    </div>
                                    <div class="sortitem">
                                        <label for="of" class="text-16-medium">{{ __('Oldest First') }}</label>
                                        <input type="radio" class="evt_sort_type_mobile" value="ASC" name="sort_type_explore_operation" id="of">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- sorting icon --}}
                    <div class="op_sentofr">
                        <div class="title text-18-semibold">{{ __('Operations') }}</div>
                        <div class="sentbtnbox">
                            <a href="{{route('offered-operations.index')}}" class="text-14-semibold"><i class="desktop"><img src="{{ asset('images/mipo/sent_offermb.svg') }}" alt="no-image"></i><i class="forhover"><img src="{{ asset('images/mipo/darkofrclock.svg') }}" alt="no-image"></i>{{ __('View Sent Offers') }}</a>
                        </div>
                    </div>

                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="ajax_explore_operations_list_mobile" role="tabpanel" aria-labelledby="home-tab">
                        
                        </div>
                    </div>
                    {{--  --}}
                </div>
            </div>
    </div>
{{-- 991 tab,mobile to new html :nd--}}

    @section('custom_script')
        <script>
            const url_load_more_explore_operations_data = "{{ route('explore-operations.ajax-load-more-explore-operations') }}";
            const url_get_explore_operations_group = "{{ route('explore-operations.ajax-get-explore-operations-group') }}";
            const url_save_group_offer = "{{ route('explore-operations.ajax-save-group-offer') }}"
            const MIPO_COMMISSION = "{{ $investor_commission }}";
            const MIPO_ADD_COMMISSION = "{{ $mipo_commission }}";
            const ajax_url_get_user = "{{ route('ajax.search-user') }}";
            const ajax_url_get_compnay = "{{ route('ajax.search-company') }}";
            const ajax_url_get_bank = "{{ route('ajax.search-bank') }}";
            var explore_operations_form_data = {};
        </script>
        <script src="{{ asset('plugins/select2-4.1.0-rc.0/dist/js/select2.min.js') }}"></script>
        <script src="{{ asset('plugins/carousel/owl.carousel.min.js') }}"></script>
        <script src="{{ asset('plugins/fancybox/fancybox.umd.js') }}"></script>
        <script src="{{ asset('js/jquery.formatCurrency-1.4.0.js') }}"></script>
        <script src="{{ asset('js/jquery.formatCurrency.all.js') }}"></script>
        <script src="{{ asset('js/explore-operations-list.js') }}"></script>
        <script src="{{ asset('js/crudoffer.js') }}"></script>
        <script src="{{ asset('js/custom-number-format.js') }}"></script>
        <script src="{{ asset('js/tour/desktoptour.js') }}"></script>
        {{-- <script src="{{ asset('js/tour/mobiletour.js') }}"></script> --}}

        {{-- popup script by k --}}

        <script>
            $(document).ready(function() {
                $(".ofrpopup_wrap .tab_row ul li button").click(function (e) {
                    let tab = $(this).attr('data-bs-target');
                    localStorage.setItem("ofrpopup_tab", tab);
                });
            });

            let selectedOfrpopupTab = localStorage.getItem("ofrpopup_tab");
            if(selectedOfrpopupTab){
                    $('.ofrpopup_wrap .tab_row ul li button').removeClass('active');
                    let activeTab = document.querySelector(`.ofrpopup_wrap .tab_row ul li button[data-bs-target="${selectedOfrpopupTab}"]`);
                    activeTab.classList.add('active');

                    const selectedOfrpopupTabWithoutHash = selectedOfrpopupTab.replace('#', '');
                    $('.ofrpopup_wrap .tab_row .tab-content .tab-pane').removeClass('show active');
                    let activeTabContent = document.querySelector(`.ofrpopup_wrap .tab_row .tab-content .tab-pane[id="${selectedOfrpopupTabWithoutHash}"]`);
                    activeTabContent.classList.add('show');
                    activeTabContent.classList.add('active');
            }else {
                    $('.ofrpopup_wrap .tab_row ul li button:first').addClass('active');
                    $('.ofrpopup_wrap .tab_row .tab-content .tab-pane:first').addClass('show');
                    $('.ofrpopup_wrap .tab_row .tab-content .tab-pane:first').addClass('active');
            }
        </script>

        {{-- popup script by k --}}
    @endsection
</x-app-layout>
