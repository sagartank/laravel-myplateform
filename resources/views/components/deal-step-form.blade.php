@props(['langs', 'operation_detail', 'type', 'preferred_payment_method_deals', 'progress'])


@php
    $is_cashed = $is_rate = false;
    $qr_code_step_id = 0;
    $preferred_payment_method_deals = $operation_detail->preferred_payment_method;
    if ($type == 'Seller') {
        $is_rate = $operation_detail->is_rated_seller;
        $is_cashed = $operation_detail->is_cashed_seller;
        $is_filed = $operation_detail->is_filed_seller;
        $is_qr_code = $operation_detail->is_qr_code_seller;
        $is_deals_contract = $operation_detail->is_seller_deals_contract;
        $offer_status = $operation_detail->offer_status;
        $is_payment = $operation_detail->is_payment_seller;
        $is_cashe_date = $operation_detail->cashed_date_seller;
    } elseif ($type == 'Buyer') {
        $is_rate = $operation_detail->is_rated_buyer;
        $is_cashed = $operation_detail->is_cashed_buyer;
        $is_filed = $operation_detail->is_filed_buyer;
        $is_qr_code = $operation_detail->is_qr_code_buyer;
        $is_deals_contract = $operation_detail->is_buyer_deals_contract;
        $offer_status = $operation_detail->offer_status;
        $is_payment = $operation_detail->is_payment_buyer;
        $is_cashe_date = $operation_detail->cashed_date_buyer;
    }
@endphp

{{-- 
/* Note ::  
Investor as Buyer
 Borrower as Seller
*/ --}}
{{-- <div class="col-lg-8"> --}}
<div class="contract_wrapper">
    <div class="sign_contractbox">
        @if($is_deals_contract == 'Yes' && !empty($operation_detail->deals_contract->deals_contract_file))
            <div class="innerbox">
                <div class="leftpart">
                    <h3 class="text-14-medium">{{ __('Sign Contract') }}</h3>
                    <p class="text-14-medium">{{ __('Status') }}: <span class="green_success">{{ __('Finished') }}</span></p>
                </div>
                <div class="rightpart">
                    <div class="signContract_btn">
                        <a href="{{ $operation_detail->deals_contract->deals_contract_file_pdf_url }}" class="text-14-medium green_download">{{ __('Download Contract') }}</a>
                    </div>
                </div>
            </div>
        @endif

        @if($progress && $operation_detail->is_disputed == 'No' && $is_deals_contract == 'No')
        <div class="innerbox">
            <div class="leftpart">
                <h3 class="text-14-medium">{{ __('Sign Contract') }}</h3>
                <p class="text-14-medium">{{ __('Status') }}: <span class="green_success">{{ __('Pending') }}</span></p>
            </div>
            <div class="rightpart">
                <div class="signContract_btn">
                    <a href="javascript:;" id="btn_sign_contract" data-offer-id="{{$operation_detail->id}}" data-status="Approved" class="text-14-medium">{{ __('Sign Contract') }}</a>
                </div>
            </div>
        </div>
    @endif
    @if($progress)
    @foreach ($progress as $key => $val)
    @php
        $is_data = app('common')->dealsTracking_new($val->title_en, $operation_detail->operations->first()->id, $operation_detail->id, $type);
    @endphp

    @if ($val->file_upload == 'Yes' && $operation_detail->offer_status != 'Completed')
        <div class="attach_wrap">
            <div class="innerbox">
                <div class="leftpart">
                    <h3 class="text-14-medium">{{ __('Attachments')}}</h3>
                </div>
                <div class="rightpart">
                    <div class="signContract_btn">
                        <a href="javascript:;" class="text-14-medium blueLink evt_show_attachments_modal" data-file-show="deals">{{ __('View Attachment') }}</a>
                    </div>
                </div>
            </div>
            <div class="attachmentBox">
                <div id="dropzone">
                    <form action="{{ route('deals.ajax-file-upload') }}" id="deals-file-dropzone" data-step-id="{{ $val->id }}" name="deals-file" method="POST" enctype="multipart/form-data" class="dropzone needsclick">
                        @csrf
                        <div class="dz-message needsclick">
                            <span class="text">
                                <img src="{{ asset('images/mipo/dropzoneicon.svg') }}" alt="no-image">
                                <div class="content">
                                    <h5 class="text-14-semibold">{!! __('Drop Files Here or') !!}</h5>
                                    <p class="text-14-semibold">{!! __('Upload File') !!}</p>
                                </div>
                                
                                <div class="formate text-14-medium">{{ __('Supported Formats') }}:{!! __('PDF, Word, PPT, JPG, PNG, HEIF') !!}</div>
                                {{-- <div id="file-previews"></div> --}}
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    @if($type == 'Seller')
        @if(strtolower($operation_detail->preferred_payment_method ) != 'cash' && $type == 'Seller' && $val->cashed == 'Yes')
            <div class="innerbox">
                <div class="leftpart">
                    <h3 class="text-14-medium">{{ __('Payment Receipt Confirmation') }}</h3>
                    <p class="text-14-medium">{{ __('Status') }}: 
                        @if($is_cashed == 'No')
                        <span span class="">{{ __('Pending') }}</span>
                        @else
                        <span class="green_success">{{ __('Finished') }}</span>
                        @endif
                    </p>
                </div>
                <div class="rightpart">
                    <div class="form-check form-switch">
                        @if(isset($is_data['class']) && $is_data['class'] == 'current' && $is_cashed == 'No')
                        <input class="form-check-input evt_is_cashed_switch" data-offer-slug="{{ $operation_detail->slug }}" data-step-id="{{ $val->id }}" type="checkbox" role="switch" id="cashswitch-{{ $key }}">
                        @else
                        <input class="form-check-input" type="checkbox" {{($is_cashed == 'Yes') ? 'checked' : ''}} role="switch" disabled>
                        @endif
                        <label class="form-check-label" for="cashswitch-{{ $key }}"></label>
                    </div>
                </div>
            </div>
        @endif

        @if(strtolower($operation_detail->preferred_payment_method ) == 'cash' && $type == 'Seller' && $val->qr_code == 'Yes')
        @php
            $qr_code_step_id = $val->step_id;
        @endphp
            @if(isset($is_data['class']) && $is_data['class'] == 'current' && $is_qr_code =='No' )
                <div class="innerbox" id="is_qr_code-{{ $key }}"  data-step-id="{{ $val->id }}"  data-type="{{ $type }}" data-offer-slug="{{ $operation_detail->slug }}">
            @else
                <div class="innerbox">
            @endif
            <div class="leftpart">
                <h3 class="text-14-medium">{{ __('Cash Payment') }}</h3>
                <p class="text-14-medium">{{ __('Status') }}: 
                    @if($is_qr_code == 'No')
                    <span span class="">{{ __('Pending') }}</span>
                    @else
                    <span class="green_success">{{ __('Finished') }}</span>
                    @endif
                </p>
            </div>
            <div class="rightpart">
                <div class="signContract_btn">
                    @if(isset($is_data['class']) && $is_data['class'] == 'current' && $is_qr_code =='No')
                    <a href="javascript:;" class="text-14-medium evt_qr_code_modal"  id="is_qr_code-{{ $key }}"  data-step-id="{{ $val->id }}"  data-type="{{ $type }}" data-offer-slug="{{ $operation_detail->slug }}">{{ __('Get QR')}}</a>
                @else
                    <a href="javascript:;" class="text-14-medium {{ ($is_qr_code =='No') ? 'greybtn' : 'green_download' }}  disabled" disabled>{{ __('Get QR')}}</a>
                @endif
                </div>
            </div>
        </div>
        @endif
        
        @if($val->rate == 'Yes')
            <div class="innerbox">
                <div class="leftpart">
                    <h3 class="text-14-medium">{{ __('Review') }}</h3>
                    @if($is_rate == 'No')
                        <p class="text-14-medium">{{ __('Status') }}: <span class="blue">{{ __('Pending') }}</span></p>
                    @else
                        <p class="text-14-medium">{{ __('Status') }}: <span class="{{ ($is_cashed == 'No') ? 'greydisable' : 'green_success' }}">{{ __('Finished') }}</span></p>
                    @endif
                </div>
                <div class="rightpart">
                    <div class="signContract_btn">
                        @if(isset($is_data['class']) && $is_data['class'] == 'current' && ($is_rate == 'No' || $operation_detail->offer_status != 'Completed'))
                        <a href="#rating-modal" data-bs-toggle="modal" class="text-14-medium">{{ __('Leave Review') }}</a>
                        @else
                        <a href="javascript:;" class="text-14-medium  {{ ($is_rate == 'No') ? 'greybtn' : 'green_download' }}">{{ __('Leave Review') }}</a>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    @endif

    @if($type == 'Buyer')
    {{-- @if ($operation_detail->is_mipo_commission_payment == 'No' && isset($val->mipo_commission_payment) && $val->mipo_commission_payment == 'Yes') --}}
        @if (isset($val->mipo_commission_payment) && $val->mipo_commission_payment == 'Yes')
            <div class="innerbox is_payment_div">
                <div class="leftpart">
                    <h3 class="text-14-medium">{{ __('MIPO Commission Payment') }}</h3>
                    <p class="text-14-medium">{{ __('Status') }}: 
                        @if($operation_detail->is_mipo_commission_payment == 'No')
                        <span span class="">{{ __('Pending') }}</span>
                        @else
                        <span class="green_success">{{ __('Finished') }}</span></p>
                        @endif
                    </p>
                </div>
                <div class="rightpart">
                    <div class="signContract_btn">
                        @if(isset($is_data['class']) && $is_data['class'] == 'current')
                            @if($operation_detail->is_mipo_commission_payment == 'No')
                                <a href="javascript:;" data-pay-now-url="{{ route('deals.mipo-commission-payment', [$operation_detail->slug, $val->id]) }}"  data-deals-track-id="{{ $val->id }}" data-step-id="{{ $val->id }}" data-offer-slug="{{ $operation_detail->slug }}" class="text-14-medium blue btn_payment_mipo_commission_modal">{{ __('Pay Now') }}</a>
                            @elseif($operation_detail->is_mipo_commission_payment == 'Yes')
                                <a href="javascript:;" class="text-14-medium green_download">{{ __('Paid') }}</a>
                            @endif
                        @else
                            <a href="javascript:;" class="text-14-medium {{ ($operation_detail->is_mipo_commission_payment == 'Yes') ? 'green_download' : 'greybtn'}}">
                            {{
                                ($operation_detail->is_mipo_commission_payment == 'Yes') ? __('Paid') :   __('Pay Now') 
                            }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @endif
        
        @if ($is_payment == 'No' && isset($val->payment) && $val->payment == 'Yes' && $preferred_payment_method_deals != 'Cash')
            <div class="innerbox is_bank_detail_div">
                <div class="leftpart">
                    <h3 class="text-14-medium">{{ __("Seller's Payment") }}</h3>
                    <p class="text-14-medium">
                        @if($operation_detail->is_cashed_seller == 'No')
                        <span span class="">{{ __('Pending') }}</span>
                        @else
                        <span class="green_success">{{ __('Finished') }}</span>
                        @endif
                    </p>
                </div>
                <div class="rightpart">
                    <div class="signContract_btn">
                        @if(isset($is_data['class']) && $is_data['class'] == 'current')
                            <a href="#payment-data-modal" data-bs-toggle="modal" class="text-14-medium">{{ __("Seller's Details") }}</a>
                        @else
                            <a href="javascript:;" class="text-14-medium {{ ($operation_detail->is_cashed_seller == 'No')? 'greybtn' : 'green_download' }}" disabled>{{ __("Seller's Details") }}</a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="paynoteSeller text-14-medium">{{ __('After Paying Seller, please upload the payment receipt in the below attachment') }}</div>
        @endif

    @if ($is_payment == 'No' && isset($val->payment) && $val->payment == 'Yes' && $preferred_payment_method_deals == 'Cash')
        <div class="innerbox is_bank_detail_div">
            <div class="leftpart">
                <h3 class="text-14-medium">{{ __("Seller's Payment") }}</h3>
                <p class="text-14-medium">
                    @if($operation_detail->is_cashed_seller == 'No')
                    <span span class="">{{ __('Pending') }}</span>
                    @else
                    <span class="green_success">{{ __('Finished') }}</span>
                    @endif
                </p>
            </div>
            <div class="rightpart">
                <div class="signContract_btn">
                    @if(isset($is_data['class']) && $is_data['class'] == 'current')
                        <a href="#buyer-to-seller-payment-modal" data-bs-toggle="modal" class="text-14-medium">{{ __("Seller's Details") }}</a>
                    @else
                        {{-- <a href="#buyer-to-seller-payment-modal" data-bs-toggle="modal" class="text-14-medium {{ ($operation_detail->is_cashed_seller == 'No')? 'greybtn' : 'green_download' }}" disabled>{{ __("Seller's Details") }}</a> --}}
                        <a class="text-14-medium {{ ($operation_detail->is_cashed_seller == 'No')? 'greybtn' : 'green_download' }}" disabled>{{ __("Seller's Details") }}</a>
                    @endif
                </div>
            </div>
        </div>
        <div class="paynoteSeller text-14-medium">{{ __("Scan the seller's QR code after making the cash payment to confirm a successful transaction.") }}</div>
    @endif
        
        @if($val->cashed == 'Yes')
            <div class="innerbox">
                <div class="leftpart">
                    <h3 class="text-14-medium">{{ __('Document Cashing') }}</h3>
                    @if($is_cashed == 'No')
                        <p class="text-14-medium">{{ __('Status') }}: <span class="blue">{{ __('Pending') }}</span></p>
                    @else
                        <p class="text-14-medium">{{ __('Status') }}: <span class="{{ ($is_cashed == 'No') ? 'greydisable' : 'green_success' }}">{{ __('Cashed ') }} {{ $is_cashe_date }}</span></p>
                    @endif
                </div>
                <div class="rightpart">
                    <div class="signContract_btn">
                        @if(isset($is_data['class']) && $is_data['class'] == 'current' && $is_cashed == 'No')
                        <a href="javascript:;" class="text-14-medium blue evt_is_cashed_switch" data-offer-slug="{{ $operation_detail->slug }}" data-step-id="{{ $val->id }}">{{ __('Cashed') }}</a>
                        @else
                        <a href="javascript:;" class="text-14-medium {{ ($is_cashed == 'No') ? 'greybtn' : 'green_download' }}">{{ __('Cashed') }}</a>
                        @endif
                    </div>
                </div>
            </div>
        @endif
        
        {{-- @if($is_rate == 'No'  && $val->rate == 'Yes') --}}
        @if($val->rate == 'Yes')
            <div class="innerbox">
                <div class="leftpart">
                    <h3 class="text-14-medium">{{ __('Review') }}</h3>
                    @if($is_rate == 'No')
                        <p class="text-14-medium">{{ __('Status') }}: <span class="blue">{{ __('Pending') }}</span></p>
                    @else
                        <p class="text-14-medium">{{ __('Status') }}: <span class="{{ ($is_cashed == 'No') ? 'greydisable' : 'green_success' }}">{{ __('Finished') }}</span></p>
                    @endif
                </div>
                <div class="rightpart">
                    <div class="signContract_btn">
                        @if(isset($is_data['class']) && $is_data['class'] == 'current' && ($is_rate == 'No' || $operation_detail->offer_status != 'Completed'))
                        <a href="#rating-modal" data-bs-toggle="modal" class="text-14-medium">{{ __('Leave Review') }}</a>
                        @else
                        <a href="javascript:;" class="text-14-medium  {{ ($is_rate == 'No') ? 'greybtn' : 'green_download' }}">{{ __('Leave Review') }}</a>
                        @endif
                    </div>
                </div>
            </div>
        @endif
        
    @endif
    {{--     <div class="innerbox">
            <div class="leftpart">
                <h3 class="text-14-medium">Seller’s Payment</h3>
                <p class="text-14-medium">Status: <span class="greydisable">Pending</span></p>
            </div>
            <div class="rightpart">
                <div class="signContract_btn">
                    <a href="javascript:;" class="text-14-medium greybtn">Pay Now</a>
                </div>
            </div>
        </div>
        
        
        
        <div class="innerbox">
            <div class="leftpart">
                <h3 class="text-14-medium">Review</h3>
                <p class="text-14-medium">Status: <span class="greydisable">Pending</span></p>
            </div>
            <div class="rightpart">
                <div class="signContract_btn">
                    <a href="javascript:;" class="text-14-medium greybtn">View Review</a>
                </div>
            </div>
        </div> --}}
        @endforeach
        @endif
        {{-- alag alag --}}
        {{-- evt_extra_file_doc --}}
    {{--     <div class="attach_wrap">
            <div class="innerbox">
                <div class="leftpart">
                    <h3 class="text-14-medium">{{ __('Attachments')}} </h3>
                </div>
                <div class="rightpart">
                    <div class="signContract_btn">
                        <a href="javascript:;" class="text-14-medium blueLink evt_show_attachments_modal" data-file-show="deals_attached_file">{{ __('View Attachment') }}</a>
                    </div>
                </div>
            </div>
            <div class="attachmentBox">
                <div id="dropzone">
                    <form action="{{ route('deals.ajax-file-upload') }}" id="deals-attached-file-dropzone" name="deals-attached-file" method="POST" enctype="multipart/form-data" class="dropzone needsclick">
                        @csrf
                        <div class="dz-message needsclick">
                            <span class="text">
                                <img src="{{ asset('images/mipo/dropzoneicon.svg') }}" alt="no-image">
                                <div class="content">
                                    <h5 class="text-14-semibold">{!! __('Drop Files Here or') !!}</h5>
                                    <p class="text-14-semibold">{!! __('Upload File') !!}</p>
                                </div>
                                <div class="formate text-14-medium">{{ __('Supported Formats') }}:{!! __('PDF, Word, PPT, JPG, PNG, HEIF') !!}</div>
                                {{-- <div id="file-previews"></div> --}}
                            {{-- </span>
                        </div>
                    </form>
                </div>
            </div>
        </div> --}}

        {{-- alag alag --}}
        @if($operation_detail->offer_status != 'Completed')
        <div class="innerbox">
            <div class="leftpart">
                <h3 class="text-14-medium">{{ __('Request Document Custody Service (Optional)') }}</h3>
                <p class="text-14-medium">{{ __('Status') }}: <span class="green_success">{{ __('Pending') }}</span></p>
            </div>
            <div class="rightpart">
                <div class="signContract_btn">
                    <a href="javascript:;" class="text-14-medium evt_web_open_chat">{{ __('Send Request') }}</a>
                </div>
            </div>
        </div>
        @endif

    </div>
</div>
{{-- </div> --}}

{{-- pay qr modal:st --}}
<div class="pay_qr_modal">
    <div class="modal fade" id="evt_qr_code_modal_open"  tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="modal-title text-20-medium" id="exampleModalLabel">QR DE PAGO
                            </h5>
                        </div>
                        <div class="status">
                            <p class="text-14-medium">Status: <span class="text-14-medium">Pendiente</span></p>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            {!! QrCode::size(200)->generate(
                                route('deals-scane-qrcode', [
                                    'slug' => $operation_detail->slug,
                                    'user_type' => $type,
                                    'step_id' => $qr_code_step_id,
                                ]),
                            ) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="qrdetail">
                            <p class="text-left text-12-medium">OBSERVACIÓN: Tener en cuenta que una vez escaneado este QR por el comprador, el 
                                sistema dará por paga la transacción, únicamente mostrar QR cuando haya recibido el 
                                dinero en efectivo. MIPO recomienda realizar pagos via transferencia bancaria por 
                                seguridad.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- pay qr modal:nd --}}