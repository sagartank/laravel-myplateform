<x-app-layout>
    @section('pageTitle', 'Edit New Operation')
    @section('custom_style')
        <link rel="stylesheet" href="{{ asset('plugins/dropzone/basic.min.css') }}">
        <link href="{{ asset('plugins/select2-4.1.0-rc.0/dist/css/select2.min.css') }}" rel="stylesheet">
        <style>
        .create_opera_wrap_section .sepa_wrap .box_row .sc_op_wrap .select2{
            padding: 0px !important;
        }
        </style>
    @endsection
    
    <div class="operation_wrap">
        <div class="container">
            <div class="cr_op_heading">
                <div class="cr_iconbox">
                    <div class="left_arrow">
                        <a href="{{ route('operations.index') }}" class="light"><img src="{{ asset('images/mipo/cr-op-img21.svg') }}" alt="no-image"></a>
                        <a href="{{ route('operations.index') }}" class="dark"><img src="{{ asset('images/mipo/cr-op-img22.svg') }}" alt="no-image"></a>
                    </div>
                    <div class="plus_iconbox">
                        <a href="{{ route('operations.create') }}"><img src="{{ asset('images/mipo/cr-op-img23.svg') }}" alt="no-image"></a>
                    </div>
                </div>
                <div class="page_heading">
                    <div class="title">
                        <a href="{{ route('operations.index') }}"><img src="{{ asset('images/mipo/cr-op-img21.svg') }}" alt="no-image"></a>
                        <h3 class="text-24-semibold">{!! __('Edit Operation') !!}</h3>
                        <div class="imgbox">
                            <div id="evt_saving_msg" style="display: none">
                                <i><img src="{{ asset('images/mipo/cr-op-img1.svg') }}" alt="no-image"></i>
                                <span class="text-14-medium">{!! __('Saving...') !!}</span>
                            </div>
                        </div>
                    </div>
                    <div class="buttons">
                        {{--  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#discardexampleModal">
                            Launch demo modal
                        </button> --}}
                        <a href="javascript:;" id="discard-operation-btn" class="dis_btn text-16-medium" data-bs-toggle="modal" data-bs-target="#discardexampleModal">{!! __('Discard') !!}</a>
                        <a href="{{ route('operations.create') }}" class="create_btnwrap text-16-medium">
                            <i>
                                <svg width="20" height="20" viewBox="0 0 11 12" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5.5 1.3125V10.6875M10.1875 6H0.8125" stroke="white" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </i>
                            {!! __('Create New Operation') !!}
                        </a>
                        <form action="{{ route('operations.destroy', $operation) }}" method="POST" id="form-destroy-operation" class="d-none">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </div>
            </div>
            <form action="{{ route('operations.update', $operation) }}" method="POST" enctype="multipart/form-data" id="form-update-operation">
                @csrf
                @method('PUT')
                <div class="create_opera_wrap_section">
                    <div class="box_wrap">
                        <div class="checkbox_section">
                            <div class="check_wrap">
                                <h6 class="text-16-medium">{!! __('Type of Document') !!}</h6>
                                <div class="btn-wrap">
                                    @permission('my-operations-create-check')
                                    <label class="btn text-14-medium @if($operation->operation_type == 'Cheque') active @endif" for="doc1">
                                        <input type="radio" class="btn-check document-type" name="doc_type" value="Cheque" id="doc1" @if($operation->operation_type == 'Cheque') checked @endif>{!! __('Check') !!}
                                    </label>
                                    @endpermission
                                    @permission('my-operations-create-invoices')
                                    <label class="btn text-14-medium @if($operation->operation_type == 'Invoice') active @endif" for="doc2">
                                        <input type="radio" class="btn-check document-type" name="doc_type" value="Invoice" id="doc2" @if($operation->operation_type == 'Invoice') checked @endif>{!! __('Invoice') !!}
                                    </label>
                                    @endpermission
                                    @permission('my-operations-create-contracts')
                                    <label class="btn text-14-medium @if($operation->operation_type == 'Contract') active @endif" for="doc3">
                                        <input type="radio" class="btn-check document-type" name="doc_type" value="Contract" id="doc3" @if($operation->operation_type == 'Contract') checked @endif>{!! __('Contract') !!}
                                    </label>
                                    @endpermission
                                    @permission('my-operations-create-others')
                                    <label class="btn text-14-medium @if($operation->operation_type == 'Other') active @endif" for="doc4">
                                        <input type="radio" class="btn-check document-type" name="doc_type" value="Other" id="doc4" @if($operation->operation_type == 'Other') checked @endif>{!! __('Other') !!}
                                    </label>
                                    @endpermission
                                </div>
                            </div>

                            <div class="check_wrap">
                                <h6 class="text-16-medium">{!! __('With or Without Recurso') !!}</h6>
                                <div class="btn-wrap">
                                    <label class="btn @if($operation->responsibility == 'With') active @endif text-14-medium" for="res1">
                                        <input type="radio" class="btn-check" name="responsibility" value="With" id="res1" @if($operation->responsibility == 'With') checked @endif>{!! __('With Recurso') !!}
                                    </label>
                                    <label class="btn @if($operation->responsibility == 'Without') active @endif text-14-medium" for="res2">
                                        <input type="radio" class="btn-check" name="responsibility" value="Without" id="res2" @if($operation->responsibility == 'Without') checked @endif>{!! __('Without Recurso') !!}
                                    </label>
                                </div>
                            </div>

                            <div class="check_wrap">
                                <h6 class="text-16-medium">{!! __('Payment Preference') !!}</h6>
                                <div class="btn-wrap">

                                    @if (config('constants.PREFERRED_MODE'))
                                        @foreach (config('constants.PREFERRED_MODE') as $key => $val)
                                            <label class="btn @if($operation->preferred_payment_method == $val) active @endif text-14-medium" for="mode_{{ $key }}">
                                                <input type="radio" class="btn-check preferred-payment-method" name="preferred_payment_method" value="{{ $val }}" id="mode_{{ $key }}" @if($operation->preferred_payment_method == $val) checked @endif>
                                                {!! __($key) !!}
                                            </label>
                                        @endforeach
                                    @endif
                                    {{--    <label class="btn @if($operation->preferred_payment_method == 'Cash') active @endif text-14-medium" for="mode1">
                                        <input type="radio" class="btn-check preferred-payment-method" name="preferred_payment_method" value="Cash" id="mode1" @if($operation->preferred_payment_method == 'Cash') checked @endif>{!! __('Cash') !!}
                                    </label> --}}
                                    {{-- <label class="btn @if($operation->preferred_payment_method == 'eWallet') active @endif text-14-medium" for="mode2">
                                        <input type="radio" class="btn-check preferred-payment-method" name="preferred_payment_method" value="eWallet" id="mode2" @if($operation->preferred_payment_method == 'eWallet') checked @endif>{!! __('eWallet') !!}
                                    </label>
                                    <label class="btn @if($operation->preferred_payment_method == 'Bank Tran.') active @endif text-14-medium" for="mode3">
                                        <input type="radio" class="btn-check preferred-payment-method" name="preferred_payment_method" value="Bank Tran." id="mode3" @if($operation->preferred_payment_method == 'Bank Tran.') checked @endif>{!! __('Bank Transfer') !!}
                                    </label> --}}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="box_wrap imgupload_wrap">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="file_row">
                                    <h6 class="text-14-medium">{!! __('Upload Document') !!}</h6>
                                    <div id="document-dropzone" class="opdp_zone">
                                        <div class="dz-message">
                                            <label for="dropzone_area" class="text-14-medium">{!! __('Upload a Picture') !!}</label>
                                            <span class="form-control browse" role="button">
                                                <i class="light"><img src="{{ asset('images/mipo/cr-op-img2.svg') }}" alt="no-image"></i>
                                                <i class="dark"><img src="{{ asset('images/mipo/cr-op-img18.svg') }}" alt="no-image"></i>
                                                {!! __('Upload From Device') !!}
                                            </span>
                                        </div>
                                        <div id="document-preview" style="display: none;">
                                            <div class="doc_row">
                                                <div class="doc_wrap">
                                                    <div class="doc_img">
                                                        <img src="{{ asset('images/mipo/pdf.png') }}" data-dz-thumbnail>
                                                    </div>
                                                    <div class="cta_box">
                                                        <div class="cta_inner">
                                                            <img src="{{ asset('/images/mipo/cr-op-img4.svg') }}" alt="mipo" role="button" class="dz-remove">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="input-row">
                                                    <input type="text" class="form-control" name="document_name" placeholder="{{ __('Insert Title of Document') }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="documents-previews-wrapper dropzone-previews"></div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="file_row">
                                    <h6 class="text-14-medium">{!! __('Supporting Attachments') !!}</h6>
                                    <div id="supporting-attachment-dropzone" class="opdp_zone">
                                        <div class="dz-message">
                                            <label for="dropzone_area2" class="text-14-medium">{!! __('Upload a Picture') !!}</label>
                                            <span class="form-control browse" role="button">
                                                <i class="light"><img src="{{ asset('images/mipo/cr-op-img2.svg') }}" alt="no-image"></i>
                                                <i class="dark"><img src="{{ asset('images/mipo/cr-op-img18.svg') }}" alt="no-image"></i>
                                                {!! __('Upload From Device') !!}
                                            </span>
                                        </div>

                                        <div id="supporting-attachment-preview" style="display: none;">
                                            <div class="doc_row">
                                                <div class="doc_wrap">
                                                    <div class="doc_img">
                                                        <img src="{{ asset('images/mipo/pdf.png') }}" data-dz-thumbnail>
                                                    </div>
                                                    <div class="cta_box">
                                                        <div class="cta_inner">
                                                            <img src="{{ asset('/images/mipo/cr-op-img4.svg') }}" alt="mipo" role="button" class="dz-remove">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="input-row">
                                                    <input type="text" class="form-control" name="supporting_attachment_name" placeholder="{{ __('Insert Title of Document') }}">
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="supporting-attachments-previews-wrapper dropzone-previews"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box_wrap sepa_wrap">
                        <div class="row">
                            <div class="col-lg-12" id="contract-title-row-box">
                                <div class="box_title_row">
                                    <label class="text-14-medium" for="contract_title">{!! __('Title') !!}</label>
                                    <input type="text" class="form-control" name="contract_title" id="contract_title" value="{{ $operation->contract_title }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="box_row">
                                    <h6 class="text-14-medium">{!! __('Seller') !!}</h6>
                                    <input type="text" class="form-control" name="seller_id" value="{{ Auth::user()->name }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="box_row">
                                    <div class="heading_sec">
                                        <h6 class="text-14-medium">{!! __('Payer') !!} </h6>
                                        <span><a href="javascript:;" class="add_wrap text-14-medium" id="evt_show_modal_payer">{!! __('Add Payer') !!}</a></span>
                                    </div>
                                    <div class="sc_op_wrap">
                                        <select name="issuer" id="issuer" class="form-control select2">
                                            <option value="{{ $operation->issuer?->id }}">{{ $operation->issuer?->company_name }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="chinco_wrap">

                            <div class="box_tab">
                                <h6 class="text-16-medium">{!! __('Dollars or Guarani') !!}</h6>
                                <div class="btn-wrap">
                                    <label class="btn @if($operation->preferred_currency == 'USD') active @endif text-14-medium" for="currencyDollar_1">
                                        <input type="radio" class="btn-check" name="preferred_currency" value="USD" id="currencyDollar_1" @if($operation->preferred_currency == 'USD') checked @endif> {!! __('USD ($)') !!}
                                    </label>
                                    <label class="btn @if($operation->preferred_currency == 'Gs.') active @endif text-14-medium" for="currencyGuarani_1">
                                        <input type="radio" class="btn-check" name="preferred_currency" value="Gs." id="currencyGuarani_1" @if($operation->preferred_currency == 'Gs.') checked @endif> {!! __('Gs. (₲)') !!}
                                    </label>
                                </div>
                            </div>
                        
                            <div class="box_tab" id="invoice-type-row-box">
                                <h6 class="text-16-medium">{!! __('Type of Inovice') !!}</h6>
                                <div class="btn-wrap">
                                    <label class="btn  @if($operation->invoice_type == 'Service') active @endif text-14-medium" for="inv_1">
                                        <input type="radio" class="btn-check invoice-type" name="invoice_type" value="Service" id="inv_1" @if($operation->invoice_type == 'Service') checked @endif>{!! __('Service') !!}
                                    </label>
                                    <label class="btn  @if($operation->invoice_type == 'Product') active @endif text-14-medium" for="inv_2">
                                        <input type="radio" class="btn-check invoice-type" name="invoice_type" value="Product" id="inv_2" @if($operation->invoice_type == 'Product') checked @endif>{!! __('Product') !!}
                                    </label>
                                </div>
                            </div>

                            <div class="box_tab" id="government-contract-row-box" style="display: none;">
                                <h6 class="text-16-medium">{!! __('Commercial or Government') !!}</h6>
                                <div class="btn-wrap">
                                    <label class="btn text-14-medium" for="govDocY">
                                        <input type="radio" class="btn-check is-government-contract" name="is_government_contract" value="Yes" id="govDocY">{!! __('Comercial') !!}
                                    </label>
                                    <label class="btn active text-14-medium" for="govDocN">
                                        <input type="radio" class="btn-check is-government-contract" name="is_government_contract" value="No" id="govDocN" checked>{!! __('Government') !!}
                                    </label>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="box_nor_value">
                                    <label class="text-14-medium" for="amount">{!! __('Document’s Nominal Value') !!}</label>
                                    <input type="text" class="form-control evt_validate_decimal op_amount op_gurani op_dollar" value="{{ $operation->amount }}" id="amount">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="box_mini_value">
                                    <label class="text-14-medium" for="amount_requested">{!! __('Amount able to Sell Document (this value is not public)') !!}</label>
                                    <input type="text" class="form-control evt_validate_decimal op_amount_req op_gurani op_dollar" value="{{ $operation->amount_requested }}" id="amount_requested">
                                </div>
                            </div>
                            <div class="box_checkwrap">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" @if($operation->accept_below_requested) checked @endif name="accept_below_requested" value="1" id="acceptOffers_1">
                                    <label class="form-check-label text-14-medium" for="acceptOffers_1">
                                        {!! __('Accept Offers below amount requested') !!}
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    @php
                    $expiration_date = $issuance_date = $stamp_expiration = '';
                    if(isset($operation->issuance_date) && $operation->issuance_date !='') {
                        $issuance_date = \Carbon\Carbon::createFromFormat('Y-m-d', $operation->issuance_date)->format('d/m/Y');
                    }
                    if(isset($operation->expiration_date) && $operation->expiration_date !='') {
                        $expiration_date = \Carbon\Carbon::createFromFormat('Y-m-d', $operation->expiration_date)->format('d/m/Y');
                    }
                    if(isset($operation->stamp_expiration) && $operation->stamp_expiration !='') {
                        $stamp_expiration = \Carbon\Carbon::createFromFormat('Y-m-d', $operation->stamp_expiration)->format('d/m/Y');
                    }
                @endphp
                    <div class="box_wrap date-wrapper">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="box_row">
                                    <label class="text-14-medium">{!! __('Date of Issuance') !!}</label>
                                    <div class="lain_sec">
                                        <input type="text" class="form-control" value="{{ $issuance_date }}" readonly id="issuance_date" name="issuance_date" >
                                        <div class="cl_wrap evt_icon_issuance_date"><img src="{{ asset('images/mipo/cr-op-img6.svg') }}" alt="no-image"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="box_row">
                                    <div class="wrap_sec">
                                        <div class="ch_sec">
                                            <label class="text-14-medium">{!! __('Expiration Date') !!}</label>
                                            <div class="form-check" id="evt_auto_expire">
                                                <input class="form-check-input" type="checkbox" name="auto_expire" @if($operation->auto_expire) checked @endif value="on" id="autoExpire-1">
                                                <label class="form-check-label text-14-medium" for="autoExpire-1">{!! __('Automatic Expiration') !!}</label>
                                            </div>
                                        </div>
                                        <div class="lain_wrap">
                                            <input type="text" class="form-control" readonly value="{{ $expiration_date }}" name="expiration_date" id="expiration_date">
                                            <div class="cl_wrapper evt_icon_expiration_date"><img src="{{ asset('images/mipo/cr-op-img6.svg') }}" alt="no-image"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6" id="expiration-add-day-row-box">
                                <div class="boro">
                                    <label class="text-14-medium" for="extra_expiration_days">{!! __('Additional Days Available After Expiration') !!}</label>
                                    <select class="form-control selectbox" name="extra_expiration_days" id="extra_expiration_days">
                                        @if(config('constants.OPERATION_EXTRA_EXPIRE_DAYS'))
                                            @foreach (config('constants.OPERATION_EXTRA_EXPIRE_DAYS') as $key => $day)
                                                <option value="{{ $day }}">{{ $day }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6" id="invoice-number-row-box">
                                <div class="box_invo">
                                    <label class="text-14-medium" for="invoice_number">{!! __('Invoice Number') !!}</label>
                                    <input type="text" class="form-control" name="invoice_number" id="invoice_number" value="{{ $operation->invoice_number }}">
                                </div>
                            </div>
                            <div class="col-lg-6"  id="contract-number-row-box">
                                <div class="box_invo">
                                    <label class="text-14-medium" for="contract_number">{!! __('Document Number') !!}</label>
                                    <input type="text" class="form-control" name="contract_number" id="contract_number" value="{{ $operation->contract_number }}">
                                </div>
                            </div>
                            <div class="col-lg-6" data-info="Timbrado" id="timbrado-row-box">
                                <div class="box_row">
                                    <label class="text-14-medium">{!! __('Stamped') !!}</label>
                                    <input type="text" class="form-control" id="timbrado" name="timbrado" value="{{ $operation->timbrado }}">
                                </div>
                            </div>
                            <div class="col-lg-6" id="stamp-expiration-row-box">
                                <div class="box_row">
                                    <div class="wrap_sec">
                                        <div class="ch_sec">
                                            <label class="text-14-medium" for="stamp_expiration">{!! __('Stamped Expiration Date') !!}</label>
                                        </div>
                                        <div class="lain_wrap">
                                            <input type="text" class="form-control" value="{{ $stamp_expiration }}" readonly name="stamp_expiration" id="stamp_expiration">
                                            <div class="cl_wrapper evt_icon_stamp_expiration"><img src="{{ asset('images/mipo/cr-op-img6.svg') }}" alt="no-image"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6" id="check-number-row-box">
                                <div class="box_row_wrap">
                                    <label class="text-14-medium" for="check_number">{!! __('Check number') !!}</label>
                                    <input type="number" class="form-control" value="{{ $operation->check_number }}" name="check_number" id="check_number">
                                </div>
                            </div>
                            <div class="col-lg-6" id="issuer-company-type-row-box">
                                <div class="box_bus">
                                    <label class="text-14-medium" for="issuer-company-type">{!! __('Type of Business') !!}</label>
                                    <select class="form-control selectbox" name="issuer_company_type" id="issuer-company-type">
                                        <option value="">{!! __('Select a Business') !!}</option>
                                        @if($companies)
                                            @foreach($companies as $key => $val)
                                                <option value="{{ $val->name }}" {{($operation->issuer_company_type == $val->name) ? 'selected' : ''}}>{{ __( $val->name) }}</option>
                                            @endforeach
                                        @endif  
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6" id="paying-bank-row-box">
                                <div class="box_row_wrap">
                                    <label class="text-14-medium" for="issuer-bank">{!! __('Payer’s Bank') !!}</label>
                                    <select class="form-control selectbox nice_wrap" name="issuer_bank" id="issuer-bank">
                                        <option value="">{!! __('Select Issure Bank') !!}</option>
                                        @foreach($issuerBanks as $issuerBank)
                                            <option value="{{ $issuerBank->id }}" {{ ($operation->issuer_bank_id == $issuerBank->id) ? 'selected' : ''}}>{{ $issuerBank->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="addresh_box">
                                    <label class="text-14-medium" for="legal_direction">{!! __('Legal Address') !!}</label>
                                    <input type="text" class="form-control" name="legal_direction" id="legal_direction" value="{{$operation->legal_direction}}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="phone_box">
                                    <label class="text-14-medium" for="legal_telephone">{!! __('Declared Phone') !!}</label>
                                    <input type="number" class="form-control" name="legal_telephone" id="legal_telephone" value="{{$operation->legal_telephone}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box_wrap rewrap_section">
                        <div class="repeater" id="reference-repeater">
                            <div class="box_row">
                                <i class="light"><img data-repeater-create src="{{ asset('/images/mipo/cr-op-img7.svg') }}" alt="mipo" role="button"></i>
                                <i class="dark"><img data-repeater-create src="{{ asset('/images/mipo/cr-op-img19.svg') }}" alt="mipo" role="button"></i>
                                <h6 class="text-14-medium">{{ __('Commercial References (Optional)') }}</h6>
                            </div>

                            <div data-repeater-list="references" class="references-repeater">   
                                @forelse($operation->references as $reference)                             
                                    <div data-repeater-item class="repeater_section">
                                        <input type="hidden" name="id" value="{{ $reference->id }}">
                                        <div class="info_row">                                        
                                            <div class="cta_box">
                                                <div class="cta_inner">
                                                    <i class="light"><img data-repeater-delete src="{{ asset('/images/mipo/cr-op-img8.svg') }}" alt="mipo" role="button"></i>
                                                    <i class="dark"><img data-repeater-delete src="{{ asset('/images/mipo/cr-op-img20.svg') }}" alt="mipo" role="button"></i>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <div class="box">
                                                        <label class="text-14-medium" for="name">{!! __('Name') !!}</label>
                                                        <input type="text" name="name" class="form-control" value="{{ $reference->name }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="box">
                                                        <label class="text-14-medium" for="company_name">{!! __('Business Name') !!}</label>
                                                        <input type="text" name="company_name" class="form-control" value="{{ $reference->company_name }}">
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="box">
                                                        <label class="text-14-medium" for="phone_number">{!! __('Phone Number') !!}</label>
                                                        <input type="number" name="phone_number" class="form-control" value="{{ $reference->phone_number }}">
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="box">
                                                        <label class="text-14-medium" for="email">{!! __('Email') !!}</label>
                                                        <input type="email" name="email" class="form-control" value="{{ $reference->email }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div data-repeater-item class="repeater_section">
                                        <input type="hidden" name="id" value="">
                                        <div class="info_row">                                        
                                            <div class="cta_box">
                                                <div class="cta_inner">
                                                    <i class="light"><img data-repeater-delete src="{{ asset('/images/mipo/cr-op-img8.svg') }}" alt="mipo" role="button"></i>
                                                    <i class="dark"><img data-repeater-delete src="{{ asset('/images/mipo/cr-op-img20.svg') }}" alt="mipo" role="button"></i>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <div class="box">
                                                        <label class="text-14-medium" for="name">{!! __('Name') !!}</label>
                                                        <input type="text" name="name" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="box">
                                                        <label class="text-14-medium" for="company_name">{!! __('Business Name') !!}</label>
                                                        <input type="text" name="company_name" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="box">
                                                        <label class="text-14-medium" for="phone_number">{!! __('Phone Number') !!}</label>
                                                        <input type="number" name="phone_number" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="box">
                                                        <label class="text-14-medium" for="email">{!! __('Email') !!}</label>
                                                        <input type="email" name="email" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforelse
                            </div>

                        </div>
                        <div class="termbox">
                            <div class="terms_row">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="on" id="terms" name="tnc" required>
                                    <label class="form-check-label text-14-medium" for="terms">
                                        {!! __('Accept') !!} <a href="{{ route('privacy-policy') }}" target="_blank">{!! __('terms and conditions') !!}</a>
                                    </label>
                                </div>
                            </div>
                            <p class="text-14-medium">{!! __('When accepting and sending operation, it’ll be set on hold for verification and approval.') !!}</p>
                            <div class="btnbox">
                                <div class="cmd-btn-op-sbm-loader"></div>
                                <input class="sub_btn text-16-medium cmd-btn-op-sbm" type="submit" value="{!! __('Submit') !!}">
                            </div>
                        </div>
                        <div class="dissub_box">
                            <a href="javascript:;" class="discard text-14-semibold" data-bs-toggle="modal" data-bs-target="#discardexampleModal">{!! __('Discard') !!}</a>
                            <a href="javascript:;" class="submit text-14-semibold" data-bs-toggle="modal" data-bs-target="#subexampleModal">{!! __('Submit') !!}</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

        {{-- all modal --}}
    {{-- create operation pop up style by k --}}
<div class="drafts_wrap_submit_popup">
    <div class="modal fade" id="subexampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-20-medium" id="exampleModalLabel">{!! __('Send Operation') !!}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-14-medium">
                    {!! __('Are you sure you wish to send operation for verification?') !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-secondary text-16-medium" data-bs-dismiss="modal">{!! __('No') !!}</button>
                    <button type="button" class="btn-primary text-16-medium" id="evt_cmd_mob_update_form" data-form-name="form-update-operation">{!! __('Yes') !!}</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="drafts_wrap_discard_popup">
    <div class="modal fade" id="discardexampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-20-medium" id="exampleModalLabel">{!! __('Discard Operation') !!}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-14-medium">
                    {!! __('Are you sure you wish to discard operation?') !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-secondary text-16-medium" data-bs-dismiss="modal">{!! __('Cancel') !!}</button>
                    <button type="button" class="btn-primary text-16-medium" id="evt_cmd_discarm_operation">{!! __('Confirm') !!}</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="drafts_wrap_addpayer_popup">
    <div class="modal fade" id="modal_payer_issuer" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-20-medium" id="exampleModalToggleLabel">{!! __('Add Payer') !!}</h5>
                    <a href="javascript:void(0)" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
                </div>
                <form action="javascript:void(0)" method="post" name="form_add_payer_issuer" id="form_add_payer_issuer">
                    @csrf
                    <div class="modal-body">
                        <div class="bupe_wrap">
                            <h6 class="text-14-medium">{!! __('Business or Person') !!}</h6>
                            <div class="btn-wrap">
                                <label class="btn active text-16-medium" for="business">
                                    <input type="radio" class="btn-check evt_payer_type" name="payer_type" value="business" id="business" checked>{!! __('Business') !!}
                                </label>
                                <label class="btn text-16-medium" for="person">
                                    <input type="radio" class="btn-check evt_payer_type" name="payer_type" value="person" id="person">{!! __('Person') !!}
                                </label>
                            </div>
                        </div>
                        <div class="firstlast_wrap">

                            <div class="name_wrap hide_show_person">
                                <label class="text-14-medium" for="name">{!! __('Name') !!}</label>
                                <input type="text" class="form-control" id="name" name="name" >
                            </div>

                            <div class="name_wrap hide_show_person">
                                <label class="text-14-medium" for="lastname">{!! __('Last Name') !!}</label>
                                <input type="text" class="form-control" id="lastname" name="lastname" >
                            </div>

                            <div class="name_wrap hide_show_business">
                                <label class="text-14-medium" for="businessname">{!! __('Business Name') !!}</label>
                                <input type="text" class="form-control" id="businessname" name="name" >
                            </div>
                            <div class="cidv_sec">
                                <div class="ci_wrap">
                                    <label class="text-14-medium" id="ruc"><span id="ruc_change_txt">{{ __('RUC') }}</span>*</label>
                                    <input type="text" class="form-control" id="ruc" name="ruc" >
                                </div>
                                <div class="dv_wrap">
                                    <label class="text-14-medium" for="dv">{!! __('D.V.') !!}</label>
                                    <input type="text" class="form-control" id="dv" name="dv" >
                                </div>
                            </div>
                        </div>
                        <div class="atencion_sec">
                            <div class="head">
                                <i><img src="{{ asset('images/mipo/cr-op-img9.svg') }}" alt="no-image"></i>
                                <h6 class="text-14-semibold">{!! __('Atención') !!}</h6>
                            </div>
                            <p class="text-14-medium">{!! __('To search for the verification digit, click here and enter the identification number to obtain the verification digit') !!}</p>
                            <div class="click_btn">
                                <a href="https://ruc.com.py/" target="_blank" class="text-14-medium">{!! __('Click here') !!}</a>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" value="{!! __('Add') !!}" id="cmd_btn_add_payer" class="add_wrapper text-16-medium">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- create operation pop up style by k --}}
    @section('custom_script')
        <script src="{{ asset('plugins/jquery-repeater/jquery.repeater.min.js') }}"></script>
        <script src="{{ asset('plugins/dropzone/dropzone.min.js') }}"></script>
        {{-- <script src="{{ asset('plugins/bootstrap-tags/bootstrap-tags-input.min.js') }}"></script> --}}
        <script src="{{ asset('plugins/select2-4.1.0-rc.0/dist/js/select2.min.js') }}"></script>
        <script src="{{ asset('plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
        <script src="{{ asset('js/jquery.formatCurrency-1.4.0.js') }}"></script>
        <script src="{{ asset('js/jquery.formatCurrency.all.js') }}"></script>
        <script src="{{ asset('js/custom-number-format.js') }}"></script>
        <script>Dropzone.autoDiscover = false;</script>
        <script>
            let governmentContract = $('#government-contract-row-box');
            let contractTitle = $('#contract-title-row-box');
            let description = $('#description-row-box');
            let checkNumber = $('#check-number-row-box');
            let invoiceType = $('#invoice-type-row-box');
            let invoiceNumber = $('#invoice-number-row-box');
            let issuerCompanyType = $('#issuer-company-type-row-box');
            let taxId = $('#tax-id-row-box');
            let timbrado = $('#timbrado-row-box');
            let authorizedPersonnel = $('#authorized-personnel-row-box');
            // let authorizedPersonnelSignature = $('#authorized-personnel-signature-row-box');
            let tagsInput = $('input[name="tags"]');
            let expiration_add_days = $('#expiration-add-day-row-box');
            let operation_type = "{{$operation->operation_type}}";
            let auto_expire = $('#evt_auto_expire');
            let paying_bank = $('#paying-bank-row-box');
            let stamp_expiration = $('#stamp-expiration-row-box');
            let contract_number = $('#contract-number-row-box');
            
            $(document).ready(function () {

                $('.evt_payer_type').change(function (e) { 
                    e.preventDefault();
                    var _val = $(this).val();
                    var txt_name  = '';
                    $('.hide_show_business').hide();
                    $('.hide_show_person').hide();
                    if(_val == 'business') {
                        txt_name = 'RUC';
                        $('.hide_show_business').show();
                    } else if(_val == 'person') {
                        txt_name = 'C.I';
                        $('.hide_show_person').show();
                    }
                    $('#ruc_change_txt').text(txt_name);
                });

                $('#issuance_date').daterangepicker({
                    autoUpdateInput: false,
                    showButtonPanel: false,
                    singleDatePicker: true,
                    showDropdowns: false,
                    minYear: 1901,
                    // autoApply: true,
                    locale: {
                        format: 'DD/MM/YYYY'
                    },
                    maxYear: parseInt(moment().format('YYYY'), 10)
                }, function (start, end, label) {
                }).on('apply.daterangepicker', function (ev, picker) {
                    $(this).val(picker.startDate.format('DD/MM/YYYY'));
                });

                $('#expiration_date').daterangepicker({
                    autoUpdateInput: false,
                    showButtonPanel: false,
                    singleDatePicker: true,
                    showDropdowns: false,
                    minYear: 1901,
                    // autoApply: true,
                    locale: {
                        format: 'DD/MM/YYYY'
                    },
                    maxYear: parseInt(moment().format('YYYY'), 10)
                }, function (start, end, label) {
                }).on('apply.daterangepicker', function (ev, picker) {
                    $(this).val(picker.startDate.format('DD/MM/YYYY'));
                });

                $('#stamp_expiration').daterangepicker({
                    autoUpdateInput: false,
                    showButtonPanel: false,
                    singleDatePicker: true,
                    showDropdowns: false,
                    minYear: 1901,
                    // autoApply: true,
                    locale: {
                        format: 'DD/MM/YYYY'
                    },
                    maxYear: parseInt(moment().format('YYYY'), 10)
                }, function (start, end, label) {
                }).on('apply.daterangepicker', function (ev, picker) {
                    $(this).val(picker.startDate.format('DD/MM/YYYY'));
                });

                applyDocTypeChange(operation_type);
                // pageLoadTags($('input[name="doc_type"]').val());
    
                $referenceRepeater = $('#reference-repeater').repeater({
                    initEmpty: "{{ $operation->references->isEmpty() }}",
                    show: function () {
                        $(this).slideDown();
                    },
                    hide: function (deleteElement) {
                        if(confirm(repeater_delete_en_msg)) {
                            $(this).slideUp(deleteElement);
                        }
                    },
                    isFirstItemUndeletable: false,
                });
                
                $('#evt_show_modal_payer').click(function (e) {
                    e.preventDefault();
                    $('.hide_show_person').hide();
                    $('.hide_show_business').show();
                    $('#form_add_payer_issuer')[0].reset();
                    $('#modal_payer_issuer').modal('show');
                });

                $('#form_add_payer_issuer').submit(function (e) {
                    e.preventDefault();
                    $('#cmd_btn_add_payer').val('Please Wait...');
                    $("#cmd_btn_add_payer").attr("disabled", true);
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('operations.ajax-add-payer-issuer') }}",
                        dataType: 'json',
                        data: $('#form_add_payer_issuer').serialize(),
                        success: function (res) {
                            $('#cmd_btn_add_payer').val('Submit');
                            $("#cmd_btn_add_payer").attr("disabled", false);
                            if (res.status == true) {
                                var issuer_data = {
                                    id: res.data.id,
                                    text: res.data.issuer_name + ' ' + res.data.ruc,
                                };

                                var issuer_option = new Option(issuer_data.text, issuer_data.id, false, false);
                                $('#issuer').append(issuer_option).trigger('change');

                                toastr.success(res.message);
                                $('#form_add_payer_issuer')[0].reset();
                                $('#modal_payer_issuer').modal('hide');
                            } else {
                                toastr.error(res.message);
                            }
                        },
                        error: function (xhr) {
                            $('#cmd_btn_add_payer').val('Submit');
                            $("#cmd_btn_add_payer").attr("disabled", false);
                            unsetLoadin();
                            ajaxErrorMsg(xhr);
                        }
                    });
                });

                $("#issuer").select2({
                    ajax: {
                        url: "{{ route('operations.ajax-payer-issuer-list') }}",
                        dataType: 'json',
                        delay: 500,
                        data: function (params) {
                            return {
                                query: params.term, // search term
                                page: params.page
                            };
                        },
                        processResults: function (data, params) {
                            return {
                                    results: data.results
                                };
                        },
                        cache: true
                    }
                });

                $("#operation-tags").select2({
                    tags: true,
                    tokenSeparators: [',', ';'],
                    ajax: {
                        url: "{{ route('operations.ajax-get-tags-list') }}",
                        dataType: 'json',
                        delay: 500,
                        data: function (params) {
                            return {
                                query: params.term, // search term
                                page: params.page
                            };
                        },
                        processResults: function (data, params) {
                            params.page = params.page || 1;
                            return {
                                results: data.results,
                                pagination: {
                                    more: (params.page * data.tags.per_page) < data.tags.total
                                }
                            };
                        },
                        cache: true
                    },
                    templateResult: function (res) {
                        if (res.loading) {
                            return null;
                        }
                        return res.text;
                    },
                    templateSelection: function (res) {
                        return res.text;
                    },
                });
                
                $(document).on('click', '.evt_click_extra_expiration_days', function (e) {
                    e.preventDefault();
                    if($(this).text()!='') {
                        $('#extra_expiration_days').val($(this).text());
                    }
                });

                $(document).on('change', '.document-type', function (e) {
                    e.preventDefault();
                    let el = $(this);
                    applyDocTypeChange(el.val());
                    // tagsInput.tagsinput('add', {'key' : el.prop('name'), 'value' : el.val()});            
                });
    
                // $(document).on('change', '.is-government-contract', function (e) {
                //     e.preventDefault();
                //     let el = $(this);
                //     if (el.val() == 'Yes') {
                //         tagsInput.tagsinput('add', {'key' : el.prop('name'), 'value' : 'Government'});
                //     }
                //     else {
                //         tagsInput.tagsinput('remove', {'key' : el.prop('name'), 'value' : 'Government'});
                //     }            
                // });
    
                // $(document).on('change', '.preferred-payment-method', function (e) {
                //     e.preventDefault();
                //     let el = $(this);
                //     tagsInput.tagsinput('add', {'key' : el.prop('name'), 'value' : el.val()});            
                // });
    
                // $(document).on('change', '.invoice-type', function (e) {
                //     e.preventDefault();
                //     let el = $(this);
                //     tagsInput.tagsinput('add', {'key' : el.prop('name'), 'value' : el.val()});            
                // });
    
                $(document).on('change', '#issuer', debounce(function (e) {
                    e.preventDefault();
                    let el = $(this);
                    // tagsInput.tagsinput('add', {'key' : el.prop('name'), 'value' : el.val()});      
                    submitOperationForm($('#form-update-operation'), (res) => {toastr.success(res.message);});      
                }, 500));
    
                $(document).on('change', '#amount', debounce(function (e) {
                    e.preventDefault();
                    submitOperationForm($('#form-update-operation'), (res) => {toastr.success(res.message);});
                }, 500));

                // $(document).on('change', '#issuer-company-type', function (e) {
                //     e.preventDefault();
                //     let el = $(this);
                //     tagsInput.tagsinput('add', {'key' : el.prop('name'), 'value' : el.val()});            
                // });
    
                // $(document).on('change', '#issuer-bank', debounce(function (e) {
                //     e.preventDefault();
                //     let el = $(this);
                //     tagsInput.tagsinput('add', {'key' : el.prop('name'), 'value' : el.val()});            
                // }, 500));
    
                // $("input[name='authorized_personnel_signature']").change(function(e) {
                //     let output = $('#authorized-personnel-signature-preview');
                //     output.attr('src', URL.createObjectURL(e.target.files[0]));
                //     output.show();
                //     output.onload = () => {
                //         URL.revokeObjectURL(output.src);
                //     };
                //     $('#authorized-personnel-signature-preview-box').show();
                // });
    
                // $(document).on('click', '#delete-authorized-personnel-signature', function (e) {
                //     e.preventDefault();
                //     $("input[name='authorized_personnel_signature']").val('');
                //     $.ajax({
                //         type: 'POST',
                //         dataType: 'JSON',
                //         headers: {
                //             'X-CSRF-Token': "{{ csrf_token() }}",
                //         },
                //         url: "{{ route('operations.ajax-delete-authorized-personnel-signature') }}",
                //         data: 'slug=' + $(this).data("operation-slug"),
                //         success: function (res) {
                //             if (res.success) {
                //                 console.log(res.message);
                //             }
                //             else {
                //                 alert('Error '+ res.status + ': ' + res.message);
                //             }
                //         },
                //     });
                //     $('#authorized-personnel-signature-preview-box').hide();
                // });

                $(document).on('submit', '#form-update-operation', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    var terms = $('#terms');
                    if(terms.is(":checked")) {
                        submitOperationForm($(this), (res) => {
                            // toastr.success(res.message);
                            let timerInterval;
                            Swal.fire({
                                title: res.message,
                                html: operation_draft_en_msg,
                                timer: 4000,
                                timerProgressBar: true,
                                didOpen: () => {
                                    Swal.showLoading();                            
                                },
                                willClose: () => {
                                    clearInterval(timerInterval);
                                }
                                }).then((result) => {
                                if (result.dismiss === Swal.DismissReason.timer) {
                                    window.location.href = res.detailsLink;
                                }
                            });
                        });
                    } else {
                        toastr.error(terms_accept_en_msg);
                    }
                });
            });
    
            // tagsInput.tagsinput({
            //     itemValue: 'key',
            //     itemText: 'value',
            //     onTagExists: function(item, $tag) {
            //         $tag.hide();
            //         tagsInput.tagsinput('remove', item);
            //         tagsInput.tagsinput('add', item);
            //         $tag.fadeIn();
            //     }
            // });

            function submitOperationForm (el, callback = () => {}) {
                $('#form-update-operation :input').removeClass('is-invalid');
                $('#form-update-operation .invalid-feedback').remove();
                setLoadin();

                var currency_type = $("input[name='preferred_currency']:checked").val();
                var amount_ = currency_inr_operation(currency_type, $('#amount').val());
                var amount_requested = currency_inr_operation(currency_type, $('#amount_requested').val());
                
                let data = new FormData(el[0]);
                data.append('amount', amount_);
                data.append('amount_requested', amount_requested);

                // const tags = tagsInput.tagsinput('items').map(({ value }) => value);
                // tags.forEach((tag, i) => {
                //     data.append('operation_tags[' + i + ']', tag);
                // });

                documentDropzone.files.forEach((file, i) => {
                    data.append('documents[' + i + ']', file);
                    displayName = file.previewElement.querySelector("input[name='document_name']");
                    data.append('document_names[' + i + ']', $(displayName).val());
                });

                supportingAttachmentDropzone.files.forEach((file, i) => {
                    data.append('supporting_attachments[' + i + ']', file);
                    displayName = file.previewElement.querySelector("input[name='supporting_attachment_name']");
                    data.append('supporting_attachment_names[' + i + ']', $(displayName).val());
                });

                $.ajax({
                    type: 'POST',
                    dataType: 'JSON',
                    headers: {
                        'X-CSRF-Token': "{{ csrf_token() }}",
                    },
                    url: "{{ route('operations.update', $operation) }}",
                    data: data,
                    cache: false,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $('.cmd-btn-op-sbm-loader').html(btn_common_loader);
                        $('.cmd-btn-op-sbm').hide();
                        $('#evt_saving_msg').show();
                    },
                    success: function (res) {
                        $('.cmd-btn-op-sbm-loader').html(null);
                        $('.cmd-btn-op-sbm').show();
                        $('#evt_saving_msg').hide();
                        if (res.success) {
                            // toastr.success(res.message);
                            $('#subexampleModal').modal('hide');
                            // location.href = res.redirectTo;
                            documentDropzone.removeAllFiles(true);
                            $('.documents-previews-wrapper').empty();
                            (res.documents).forEach(document => {
                                documentFile = { name: document.name, size: document.size * 1024 };
                                documentDropzone.displayExistingFile(documentFile, document.extension == 'pdf' ? "{{ asset('images/mipo/pdf.png') }}" : document.document_url, function () {
                                    displayName = documentFile.previewElement.querySelector("input[name='document_name']");
                                    $(displayName).val(document.display_name);
                                    $(displayName).data("document-slug", document.slug);
                                    $(displayName).on('change', function (e) {
                                        e.preventDefault();
                                        debounce(updateDocumentDisplayName($(this)), 900);
                                    });
                                    deleteDocumentBtn = $(documentFile.previewElement).find('.dz-remove');                                    
                                    deleteDocumentBtn.addClass('delete-document-btn');
                                    deleteDocumentBtn.data("document-slug", document.slug);                                    
                                    $(deleteDocumentBtn).on('click', function (e) {
                                        e.preventDefault();
                                        if(confirm(ays_delete_file_en_msg)) {
                                            deleteDocument($(this), () => $(this).parents('.dz-image-preview').remove());
                                        }
                                    });
                                }, null, false);
                            });

                            supportingAttachmentDropzone.removeAllFiles(true);
                            $('.supporting-attachments-previews-wrapper').empty();
                            (res.supportingAttachments).forEach(supportingAttachment => {
                                supportingAttachmentFile = { name: supportingAttachment.name, size: supportingAttachment.size * 1024 };
                                supportingAttachmentDropzone.displayExistingFile(supportingAttachmentFile, supportingAttachment.extension == 'pdf' ? "{{ asset('images/mipo/pdf.png') }}" : supportingAttachment.attachment_url, function () {
                                    displayName = supportingAttachmentFile.previewElement.querySelector("input[name='supporting_attachment_name']");
                                    $(displayName).val(supportingAttachment.display_name);
                                    $(displayName).data("supporting-attachment-slug", supportingAttachment.slug);
                                    $(displayName).on('change', function (e) {
                                        e.preventDefault();
                                        debounce(updateSupportingAttachmentDisplayName($(this)), 900);
                                    });
                                    deleteSupportingAttachementBtn = $(supportingAttachmentFile.previewElement).find('.dz-remove');                                    
                                    deleteSupportingAttachementBtn.addClass('delete-supporting-attachment-btn');
                                    deleteSupportingAttachementBtn.data("supporting-attachment-slug", supportingAttachment.slug);                                    
                                    $(deleteSupportingAttachementBtn).on('click', function (e) {
                                        e.preventDefault();
                                        if(confirm(ays_delete_file_en_msg)) {
                                            deleteSupportingAttachment($(this), () => $(this).parents('.dz-image-preview').remove());
                                        }
                                    });
                                }, null, false);
                            });

                            $('.references-repeater').empty();
                            $referenceRepeater.setList(res.commercialReferences);

                            callback(res);
                        }
                        else {
                            alert('Error '+ res.status + ': ' + res.message);
                        }
                    },
                    error: function (xhr) {
                        $('.cmd-btn-op-sbm-loader').html(null);
                        $('.cmd-btn-op-sbm').show();
                        $('#subexampleModal').modal('hide');
                        ajaxErrorMsg(xhr);
                    },
                    statusCode: {
                        422: function (res) {
                            $('.cmd-btn-op-sbm-loader').html(null);
                            $('.cmd-btn-op-sbm').show();
                            $.each(res.responseJSON.errors, function (key, value) {
                                let target = $('#form-update-operation [name="' + dotToArray(key) + '"]');
                                target.addClass('is-invalid');
                                let errorAlert = '<span class="invalid-feedback" role="alert">' + value + '</span>';
                                target.parent().append(errorAlert);
                            });
                        }
                    },
                });
            }
    
            function pageLoadTags (value) {
                // tagsInput.tagsinput('add', {'key' : $('.document-type').prop('name'), 'value' : $('.document-type').val()});
                if (value == 'Contract' || value == 'Other') {
                    if ($('.is-government-contract').val() == 'Yes') {
                        // tagsInput.tagsinput('add', {'key' : $('.is-government-contract').prop('name'), 'value' : 'Government'});
                    }
                }   
                if ($('.preferred-payment-method').val()) {    
                    // tagsInput.tagsinput('add', {'key' : $('.preferred-payment-method').prop('name'), 'value' : $('.preferred-payment-method').val()});
                }
                if (value == 'Invoice') {
                    if ($('.invoice-type').val()) {
                        // tagsInput.tagsinput('add', {'key' : $('.invoice-type').prop('name'), 'value' : $('.invoice-type').val()});
                    }
                }                
                if ($('#issuer').val()) {
                    // tagsInput.tagsinput('add', {'key' : $('#issuer').prop('name'), 'value' : $('#issuer').val()});
                }
                if (value == 'Invoice' || value == 'Contract' || value == 'Other') {
                    if ($('#issuer-company-type').val()) {
                        // tagsInput.tagsinput('add', {'key' : $('#issuer-company-type').prop('name'), 'value' : $('#issuer-company-type').val()});
                    }
                }
                if ($('#issuer-bank').val()) {
                    // tagsInput.tagsinput('add', {'key' : $('#issuer-bank').prop('name'), 'value' : $('#issuer-bank').val()});
                }
            }
    
            function applyDocTypeChange(value) {
                if (value == 'Cheque') {
                    governmentContract.hide();
                    auto_expire.hide();
                    // tagsInput.tagsinput('remove', governmentContract.find('input').prop('name'));
                    contractTitle.hide();
                    description.hide();
                    checkNumber.show();
                    invoiceType.hide();
                    // tagsInput.tagsinput('remove', invoiceType.find('input').prop('name'));
                    invoiceNumber.hide();
                    issuerCompanyType.hide();
                    // tagsInput.tagsinput('remove', issuerCompanyType.find('input').prop('name'));
                    taxId.hide();
                    timbrado.hide();
                    authorizedPersonnel.hide();
                    expiration_add_days.hide();
                    paying_bank.show();
                    stamp_expiration.hide();
                    contract_number.hide();
                    // authorizedPersonnelSignature.hide();
                }
                else if (value == 'Invoice') {
                    governmentContract.hide();
                    auto_expire.show();
                    // tagsInput.tagsinput('remove', governmentContract.find('input').prop('name'));
                    contractTitle.hide();
                    description.hide();
                    checkNumber.hide();
                    invoiceType.show();
                    if(invoiceType.find('input:checked').length){
                        // tagsInput.tagsinput('add', {'key' : invoiceType.find('input').prop('name'), 'value' : invoiceType.find('input:checked').val()});
                    }
                    invoiceNumber.show();
                    issuerCompanyType.show();
                    if(issuerCompanyType.find('select').val()){
                        // tagsInput.tagsinput('add', {'key' : issuerCompanyType.find('select').prop('name'), 'value' : issuerCompanyType.find('select').val()});
                    }
                    taxId.show();
                    timbrado.show();
                    authorizedPersonnel.show();
                    expiration_add_days.show();
                    paying_bank.show();
                    stamp_expiration.show();
                    contract_number.hide();
                    // authorizedPersonnelSignature.show();
                }
                else if (value == 'Contract') {
                    auto_expire.show();
                    governmentContract.show();
                    if(governmentContract.find('input:checked').val() == 'Yes'){
                        // tagsInput.tagsinput('add', {'key' : governmentContract.find('input').prop('name'), 'value' : 'Government'});
                    }
                    contractTitle.show();
                    description.hide();
                    checkNumber.hide();
                    invoiceType.hide();
                    // tagsInput.tagsinput('remove', invoiceType.find('input').prop('name'));
                    invoiceNumber.hide();
                    issuerCompanyType.show();
                    if(issuerCompanyType.find('select').val()){
                        // tagsInput.tagsinput('add', {'key' : issuerCompanyType.find('select').prop('name'), 'value' : issuerCompanyType.find('select').val()});
                    }
                    taxId.hide();
                    timbrado.hide();
                    authorizedPersonnel.hide();
                    expiration_add_days.show();
                    paying_bank.show();
                    stamp_expiration.hide();
                    contract_number.show();
                    // authorizedPersonnelSignature.show();
                }
                else if (value == 'Other') {
                    auto_expire.show();
                    governmentContract.show();
                    if(governmentContract.find('input:checked').val() == 'Yes'){
                        // tagsInput.tagsinput('add', {'key' : governmentContract.find('input').prop('name'), 'value' : 'Government'});
                    }
                    contractTitle.show();
                    description.show();
                    checkNumber.hide();
                    invoiceType.hide();
                    // tagsInput.tagsinput('remove', invoiceType.find('input').prop('name'));
                    invoiceNumber.hide();
                    issuerCompanyType.show();
                    if(issuerCompanyType.find('select').val()){
                        // tagsInput.tagsinput('add', {'key' : issuerCompanyType.find('select').prop('name'), 'value' : issuerCompanyType.find('select').val()});
                    }
                    taxId.hide();
                    timbrado.hide();
                    authorizedPersonnel.hide();
                    expiration_add_days.show();
                    paying_bank.show();
                    stamp_expiration.hide();
                    contract_number.hide();
                    // authorizedPersonnelSignature.show();
                }
            }

            function updateDocumentDisplayName (el) {
                $.ajax({
                    type: 'POST',
                    dataType: 'JSON',
                    headers: {
                        'X-CSRF-Token': "{{ csrf_token() }}",
                    },
                    url: "{{ route('operations.ajax-update-document-display-name') }}",
                    data: 'slug=' + el.data("document-slug") + '&display_name=' + el.val(),                    
                    success: function (res) {
                        if (res.success) {
                            console.log(res.message);                        
                        }
                        else {
                            alert('Error '+ res.status + ': ' + res.message);
                        }
                    },
                });
            }

            function updateSupportingAttachmentDisplayName (el) {
                $.ajax({
                    type: 'POST',
                    dataType: 'JSON',
                    headers: {
                        'X-CSRF-Token': "{{ csrf_token() }}",
                    },
                    url: "{{ route('operations.ajax-update-supporting-attachment-display-name') }}",
                    data: 'slug=' + el.data("supporting-attachment-slug") + '&display_name=' + el.val(),                    
                    success: function (res) {
                        if (res.success) {
                            console.log(res.message);                        
                        }
                        else {
                            alert('Error '+ res.status + ': ' + res.message);
                        }
                    },
                });
            }

            function deleteDocument (el, callback) {
                $.ajax({
                    type: 'POST',
                    dataType: 'JSON',
                    headers: {
                        'X-CSRF-Token': "{{ csrf_token() }}",
                    },
                    url: "{{ route('operations.ajax-delete-document-file') }}",
                    data: 'slug=' + el.data("document-slug"),                    
                    success: function (res) {
                        if (res.success) {
                            console.log(res.message);
                            callback();
                        }
                        else {
                            alert('Error '+ res.status + ': ' + res.message);
                        }
                    },
                });
            }

            function deleteSupportingAttachment (el, callback) {
                $.ajax({
                    type: 'POST',
                    dataType: 'JSON',
                    headers: {
                        'X-CSRF-Token': "{{ csrf_token() }}",
                    },
                    url: "{{ route('operations.ajax-delete-supporting-attachment-file') }}",
                    data: 'slug=' + el.data("supporting-attachment-slug"),                    
                    success: function (res) {
                        if (res.success) {
                            console.log(res.message);
                            callback();
                        }
                        else {
                            alert('Error '+ res.status + ': ' + res.message);
                        }
                    },
                });
            }
    
            documentDropzone = new Dropzone("#document-dropzone", {
                // Dropzone.options.formCreateCase = {
                url: "{{ route('operations.update', $operation) }}",
                paramName: 'documents',
                autoProcessQueue: false,
                uploadMultiple: true,
                // addRemoveLinks: true,
                parallelUploads: 100,
                maxFiles: 100,
    
                previewsContainer: ".documents-previews-wrapper",
                previewTemplate: document.getElementById('document-preview').innerHTML,
                thumbnailWidth: null,
                thumbnailHeight: null,
    
                capture: 'camera',
                acceptedFiles: 'image/*,application/pdf',
                // accept: function(file, done) {
                // },
    
                // params: function (files, xhr) {
                //     return {
                //         filename: '',
                //     }
                // },
                // dictCancelUploadConfirmation: true,
                // dictRemoveFileConfirmation: "Are you sure you want to delete this file?",
    
                init: function () {
                    documentDropzone = this;
                    
                    let crossOrigin = null; // Added to the `img` tag for crossOrigin handling
                    let resizeThumbnail = false; // Tells Dropzone whether it should resize the image first
                    <?php
                        if($operation->documents->isNotEmpty()) {
                            foreach($operation->documents as $document) {
                                ?>
                                var mockFile = { name: "{{ $document->name }}", size: "{{ $document->size * 1024 }}" };                            
                                documentDropzone.displayExistingFile(mockFile, "{{ $document->extension == 'pdf' ? asset('images/mipo/pdf.png') : route('secure-image', Crypt::encryptString($document->path)) }}", function () {
                                    displayName = mockFile.previewElement.querySelector("input[name='document_name'");
                                    $(displayName).val("{{ $document->display_name }}");
                                    $(displayName).data("document-slug", "{{ $document->slug }}");
                                    $(displayName).on('change', function (e) {
                                        e.preventDefault();
                                        debounce(updateDocumentDisplayName($(this)), 900);
                                    });
                                    deleteDocumentBtn = $(mockFile.previewElement).find('.dz-remove');                                    
                                    deleteDocumentBtn.addClass('delete-document-btn');
                                    deleteDocumentBtn.data("document-slug", "{{ $document->slug }}");                                    
                                    $(deleteDocumentBtn).on('click', function (e) {
                                        e.preventDefault();
                                        if(confirm(ays_delete_file_en_msg)) {
                                            deleteDocument($(this), () => $(this).parents('.dz-image-preview').remove());
                                        }
                                    });
                                }, crossOrigin, resizeThumbnail);
                                <?php
                            }
                        }
                    ?>

                    this.on("sendingmultiple", function(data, xhr, formData) {
    
                        // displayName = file.previewElement.querySelector("input[name='document_name'");
                        // formData.append("documents[display_name]", $(displayName).val());
    
                        // $("#form-update-operation").trigger('submit');
    
                        // let x = $("#form-update-operation").serializeArray();
                        // $.each(x, function(i, field) {
                        //     formData.append(field.name, field.value);
                        // });
                    });
                    this.on("addedfile", function (file) {
                        removeBtn = file.previewElement.querySelector('.dz-remove');
                        /* code comment dev by sagar 2/11/23
                        removeBtn.addEventListener("click", function(e) {
                            e.preventDefault();
                            e.stopPropagation();
                            documentDropzone.removeFile(file);
                        }); */
                    });
                    this.on("addedfiles", function() {
                        submitOperationForm($('#form-update-operation'), (res) => {toastr.success(res.message);});
                    });
                    this.on("success", function (file, res) {
                        if (file.previewElement) {
                            return file.previewElement.classList.add("dz-success");
                        }
                        console.log(res.message);
                    });
                    this.on("queuecomplete", function (file) {
    
                    });
                    this.on("error", function (file, res) {
                        if(res.message !== undefined && res.message !== null)
                            $(file.previewElement).find('.dz-error-message').text(res.message);
                        // if(res.errors !== undefined)
                        //     $(file.previewElement).find('.dz-error-message').text(res.errors.file);
                    });
                    this.on("uploadprogress", function (file, progress, bytesSent) {
                        // if (file.previewElement) {
                        //     for (let node of file.previewElement.querySelectorAll("[data-dz-uploadprogress]")) {
                        //         node.style.width = progress + "%";
                        //         node.querySelector(".progress-text").textContent = Math.round(progress) + "%";
                        //     }
                        // }
                    });
                    this.on("successmultiple", function (files, res) {
                        console.log(res.message);
                        // location.href = res.redirectTo;
                    });
                    this.on("errormultiple", function (files, res, xhr) {
                        if (xhr.status === 422) {
                            $.each(res.errors, function (key, value) {
                                let target = $('#form-update-operation [name="' + dotToArray(key) + '"]');
                                target.addClass('is-invalid');
                                let errorAlert = '<span class="invalid-feedback" role="alert">' + value + '</span>';
                                target.parent().append(errorAlert);
                            });
                        }
                        alert('Error '+ res.code + ':'+ res.message);
                    });
                },
                // };
            });
    
            supportingAttachmentDropzone = new Dropzone("#supporting-attachment-dropzone", {
                // Dropzone.options.formCreateCase = {
                url: "{{ route('operations.update', $operation) }}",
                paramName: 'supporting_attachments',
                autoProcessQueue: false,
                uploadMultiple: true,
                // addRemoveLinks: true,
                parallelUploads: 100,
                maxFiles: 100,
    
                previewsContainer: ".supporting-attachments-previews-wrapper",
                previewTemplate: document.getElementById('supporting-attachment-preview').innerHTML,
                thumbnailWidth: null,
                thumbnailHeight: null,
    
                capture: 'camera',
                acceptedFiles: 'image/*,application/pdf',
                // accept: function(file, done) {
                // },
                // dictCancelUploadConfirmation: true,
                // dictRemoveFileConfirmation: "Are you sure you want to delete this file?",

                init: function () {
                    supportingAttachmentDropzone = this;

                    let crossOrigin = null; // Added to the `img` tag for crossOrigin handling
                    let resizeThumbnail = false; // Tells Dropzone whether it should resize the image first
                    <?php
                        if($operation->supportingAttachments->isNotEmpty()) {
                            foreach($operation->supportingAttachments as $supportingAttachment) {
                                ?>
                                var mockFile = { name: "{{ $supportingAttachment->name }}", size: "{{ $supportingAttachment->size * 1024 }}" };                            
                                supportingAttachmentDropzone.displayExistingFile(mockFile, "{{ $supportingAttachment->extension == 'pdf' ? asset('images/mipo/pdf.png') : route('secure-image', Crypt::encryptString($supportingAttachment->path)) }}", function () {
                                    displayName = mockFile.previewElement.querySelector("input[name='supporting_attachment_name'");
                                    $(displayName).val("{{ $supportingAttachment->display_name }}");
                                    $(displayName).data("supporting-attachment-slug", "{{ $supportingAttachment->slug }}");
                                    $(displayName).on('change', function (e) {
                                        e.preventDefault();
                                        debounce(updateSupportingAttachmentDisplayName($(this)), 900);
                                    });
                                    deleteSupportingAttachmentBtn = $(mockFile.previewElement).find('.dz-remove');
                                    deleteSupportingAttachmentBtn.addClass('delete-supporting-attachment-btn');
                                    deleteSupportingAttachmentBtn.data("supporting-attachment-slug", "{{ $supportingAttachment->slug }}");
                                    $(deleteSupportingAttachmentBtn).on('click', function (e) {
                                        e.preventDefault();
                                        if(confirm(ays_delete_file_en_msg)) {
                                            deleteSupportingAttachment($(this), () => $(this).parents('.dz-image-preview').remove());
                                        }
                                    });
                                }, crossOrigin, resizeThumbnail);
                                <?php
                            }
                        }
                    ?>
                    
                    this.on("sendingmultiple", function(data, xhr, formData) {
                        
                    });
                    this.on("addedfile", function (file) {
                        removeBtn = file.previewElement.querySelector('.dz-remove');
                        /* code comment dev by sagar 2/11/23
                        removeBtn.addEventListener("click", function(e) {
                            e.preventDefault();
                            e.stopPropagation();
                            supportingAttachmentDropzone.removeFile(file);
                        }); */
                    });
                    this.on("addedfiles", function() {
                        submitOperationForm($('#form-update-operation'), (res) => {toastr.success(res.message);});
                    });
                    this.on("success", function (file, res) {
                        if (file.previewElement) {
                            return file.previewElement.classList.add("dz-success");
                        }
                        console.log(res.message);
                    });
                    this.on("queuecomplete", function (file) {
    
                    });
                    this.on("error", function (file, res) {
                        if(res.message !== undefined && res.message !== null)
                            $(file.previewElement).find('.dz-error-message').text(res.message);
                        // if(res.errors !== undefined)
                        //     $(file.previewElement).find('.dz-error-message').text(res.errors.file);
                    });
                    this.on("uploadprogress", function (file, progress, bytesSent) {
                        // if (file.previewElement) {
                        //     for (let node of file.previewElement.querySelectorAll("[data-dz-uploadprogress]")) {
                        //         node.style.width = progress + "%";
                        //         node.querySelector(".progress-text").textContent = Math.round(progress) + "%";
                        //     }
                        // }
                    });
                    this.on("successmultiple", function (files, res) {
                        console.log(res.message);
                        location.href = res.redirectTo;
                    });
                    this.on("errormultiple", function (files, res, xhr) {
                        if (xhr.status === 422) {
                            $.each(res.errors, function (key, value) {
                                let target = $('#form-update-operation [name="' + dotToArray(key) + '"]');
                                target.addClass('is-invalid');
                                let errorAlert = '<span class="invalid-feedback" role="alert">' + value + '</span>';
                                target.parent().append(errorAlert);
                            });
                        }
                        alert('Error '+ res.code + ':'+ res.message);
                    });
                },
                // };
            });

            $(document).on('click', '.evt_icon_issuance_date', function(event){
                event.preventDefault();
                $('#issuance_date').click();
            });

            $(document).on('click', '.evt_icon_expiration_date', function(event){
                event.preventDefault();
                $('#expiration_date').click();
            });

            $(document).on('click', '.evt_icon_stamp_expiration', function(event){
                event.preventDefault();
                $('#stamp_expiration').click();
            });

            $(document).on('click', '#evt_cmd_mob_update_form', function(e){
                e.preventDefault();
                submitOperationForm($('#form-update-operation'), (res) => { toastr.success(res.message); });
            });
            $(document).on('click', '#evt_cmd_discarm_operation', function(e){
                e.preventDefault();
                document.getElementById('form-destroy-operation').submit();
            });
            
        </script>
    @endsection
</x-app-layout>
    