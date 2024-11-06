<x-app-layout>
@section('pageTitle', 'Create New Operation')
@section('custom_style')
    <link href="{{ asset('plugins/select2-4.1.0-rc.0/dist/css/select2.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('plugins/dropzone/dropzone.min.css') }}">
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
                        <a href="{{ route('operations.index') }}">
                            <img src="{{ asset('images/mipo/dashboardsubpageleft.svg') }}" class="day" alt="no-image">
                            <img src="{{ asset('images/mipo/white_lft_aro.svg') }}" class="night" alt="no-image">

                        </a>
                        <h3 class="text-24-semibold">{!! __('Create Operation') !!}</h3>
                        <div class="imgbox">
                            <div id="evt_saving_msg" style="display: none">
                                <i><img src="{{ asset('images/mipo/cr-op-img1.svg') }}" alt="no-image"></i>
                                <span class="text-14-medium">{!! __('Saving...') !!}</span>
                            </div>
                        </div>
                    </div>
                    <div class="buttons">
                    {{--   <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#discardexampleModal">
                            Launch demo modal
                        </button>
                        <a href="javascript:;" id="discard-operation-btn" class="dis_btn text-16-medium" onclick="if (confirm('Are you sure, you want to discard this?')) { document.getElementById('form-destroy-operation').submit(); }">{!! __('Discard') !!}</a>
                        --}}
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
                        {{-- <form action="{{ route('operations.destroy', ':operation') }}" method="POST" id="form-destroy-operation" class="d-none">
                            @csrf
                            @method('DELETE')
                        </form> --}}
                    </div>
                </div>
            </div>
            <form action="{{ route('operations.store') }}" method="POST" enctype="multipart/form-data" id="form-create-operation" autocomplete="off">
                @csrf
                <div class="create_opera_wrap_section">
                    <div class="box_wrap">
                        <div class="checkbox_section">
                            <div class="check_wrap">
                                <h6 class="text-16-medium">{!! __('Type of Document') !!}</h6>
                                <div class="btn-wrap">
                                    @permission('my-operations-create-check')
                                    <label class="btn active text-14-medium" for="doc1">
                                        <input type="radio" class="btn-check document-type" name="doc_type" value="Cheque" id="doc1" checked>{!! __('Check') !!}
                                    </label>
                                    @endpermission
                                    @permission('my-operations-create-invoices')
                                    <label class="btn text-14-medium" for="doc2">
                                        <input type="radio" class="btn-check document-type" name="doc_type" value="Invoice" id="doc2">{!! __('Invoice') !!}
                                    </label>
                                    @endpermission
                                    @permission('my-operations-create-contracts')
                                    <label class="btn text-14-medium" for="doc3">
                                        <input type="radio" class="btn-check document-type" name="doc_type" value="Contract" id="doc3">{!! __('Contract') !!}
                                    </label>
                                    @endpermission
                                    @permission('my-operations-create-others')
                                    <label class="btn text-14-medium" for="doc4">
                                        <input type="radio" class="btn-check document-type" name="doc_type" value="Other" id="doc4">{!! __('Other') !!}
                                    </label>
                                    @endpermission
                                </div>
                            </div>

                            <div class="check_wrap">
                                <h6 class="text-16-medium">{!! __('With or Without Recurso') !!}</h6>
                                <div class="btn-wrap">
                                    <label class="btn active text-14-medium" for="res1">
                                        <input type="radio" class="btn-check" name="responsibility" value="With" id="res1" checked>{!! __('With Recurso') !!}
                                    </label>
                                    <label class="btn text-14-medium" for="res2">
                                        <input type="radio" class="btn-check" name="responsibility" value="Without" id="res2">{!! __('Without Recurso') !!}
                                    </label>
                                </div>
                            </div>

                            <div class="check_wrap">
                                <h6 class="text-16-medium">{!! __('Payment Preference') !!}</h6>
                                <div class="btn-wrap">
                                    @if (config('constants.PREFERRED_MODE'))
                                        @foreach (config('constants.PREFERRED_MODE') as $key => $val)
                                            <label class="btn @if($loop->last) active @endif text-14-medium" for="mode_{{ $key }}">
                                                <input type="radio" class="btn-check preferred-payment-method" name="preferred_payment_method" value="{{ $val }}" id="mode_{{ $key }}"  @if($loop->last) checked @endif >{!! __($key) !!}
                                            </label>
                                        @endforeach
                                    @endif
                                    {{--  <label class="btn text-14-medium" for="mode2">
                                        <input type="radio" class="btn-check preferred-payment-method" name="preferred_payment_method" value="eWallet" id="mode2">{!! __('eWallet') !!}
                                    </label>
                                    <label class="btn text-14-medium" for="mode3">
                                        <input type="radio" class="btn-check preferred-payment-method" name="preferred_payment_method" value="Bank Tran." id="mode3">{!! __('Bank Transfer') !!}
                                    </label --}}
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
                                    <input type="text" class="form-control" name="contract_title" id="contract_title">
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
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="chinco_wrap">

                            <div class="box_tab">
                                <h6 class="text-16-medium">{!! __('Dollars or Guarani') !!}</h6>
                                <div class="btn-wrap">
                                    <label class="btn text-14-medium" for="currencyDollar_1">
                                        <input type="radio" class="btn-check" name="preferred_currency" value="USD" id="currencyDollar_1">{!! __('USD ($)') !!}
                                    </label>
                                    <label class="btn active text-14-medium" for="currencyGuarani_1">
                                        <input type="radio" class="btn-check" name="preferred_currency" value="Gs." id="currencyGuarani_1" checked>{!! __('Gs. (₲)') !!}
                                    </label>
                                </div>
                            </div>

                            <div class="box_tab" id="invoice-type-row-box">
                                <h6 class="text-16-medium">{!! __('Type of Inovice') !!}</h6>
                                <div class="btn-wrap">
                                    <label class="btn active text-14-medium" for="inv_1">
                                        <input type="radio" class="btn-check invoice-type" name="invoice_type" value="Service" id="inv_1" checked>{!! __('Service') !!}
                                    </label>
                                    <label class="btn text-14-medium" for="inv_2">
                                        <input type="radio" class="btn-check invoice-type" name="invoice_type" value="Product" id="inv_2">{!! __('Product') !!}
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
                                    <input type="text" class="form-control evt_validate_decimal op_amount op_gurani op_dollar" id="amount">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="box_mini_value">
                                    <label class="text-14-medium" for="amount_requested">{!! __('Amount able to Sell Document (this value is not public)') !!}</label>
                                    <input type="text" class="form-control evt_validate_decimal op_amount_req op_gurani op_dollar" id="amount_requested">
                                </div>
                            </div>

                            <div class="box_checkwrap">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" checked name="accept_below_requested" value="1" id="acceptOffers_1">
                                    <label class="form-check-label text-14-medium" for="acceptOffers_1">
                                        {!! __('Accept Offers below amount requested') !!}
                                    </label>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="box_wrap date-wrapper">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="box_row">
                                    <label class="text-14-medium" for="issuance_date">{!! __('Date of Issuance') !!}</label>
                                    <div class="lain_sec">
                                        <input type="text" class="form-control" readonly id="issuance_date" name="issuance_date" >
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
                                                <input class="form-check-input" type="checkbox" name="auto_expire" value="on" id="autoExpire-1">
                                                <label class="form-check-label text-14-medium" for="autoExpire-1">{!! __('Automatic Expiration') !!}</label>
                                            </div>
                                        </div>
                                        <div class="lain_wrap">
                                            <input type="text" class="form-control" readonly name="expiration_date" id="expiration_date">
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
                                    <input type="text" class="form-control" name="invoice_number" id="invoice_number">
                                </div>
                            </div>

                            <div class="col-lg-6" id="contract-number-row-box">
                                <div class="box_invo">
                                    <label class="text-14-medium" for="contract_number">{!! __('Document Number') !!}</label>
                                    <input type="text" class="form-control" name="contract_number" id="contract_number">
                                </div>
                            </div>

                            <div class="col-lg-6" data-info="Timbrado" id="timbrado-row-box">
                                <div class="box_row">
                                    <label class="text-14-medium" for="timbrado">{!! __('Stamped') !!}</label>
                                    <input type="text" class="form-control" id="timbrado" name="timbrado">
                                </div>
                            </div>
                            
                            <div class="col-lg-6" id="stamp-expiration-row-box">
                                <div class="box_row">
                                    <div class="wrap_sec">
                                        <div class="ch_sec">
                                            <label class="text-14-medium" for="stamp_expiration">{!! __('Stamped Expiration Date') !!}</label>
                                        </div>
                                        <div class="lain_wrap">
                                            <input type="text" class="form-control" readonly name="stamp_expiration" id="stamp_expiration">
                                            <div class="cl_wrapper evt_icon_stamp_expiration"><img src="{{ asset('images/mipo/cr-op-img6.svg') }}" alt="no-image"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6" id="check-number-row-box">
                                <div class="box_row_wrap">
                                    <label class="text-14-medium" for="check_number">{!! __('Check number') !!}</label>
                                    <input type="number" class="form-control" name="check_number" id="check_number">
                                </div>
                            </div>

                            <div class="col-lg-6" id="issuer-company-type-row-box">
                                <div class="box_bus">
                                    <label class="text-14-medium" for="issuer-company-type">{!! __('Type of Business') !!}</label>
                                    <select class="form-control selectbox" name="issuer_company_type" id="issuer-company-type">
                                        <option value="" selected>{{ __('Select a Business') }}</option>
                                        @if($companies)
                                            @foreach ($companies as $key => $val)
                                                <option value="{{ $val->name }}">{!! __($val->name) !!}</option>
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
                                            <option value="{{ $issuerBank->id }}">{{ $issuerBank->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="addresh_box">
                                    <label class="text-14-medium" for="legal_direction">{!! __('Legal Address') !!}</label>
                                    <input type="text" class="form-control" name="legal_direction" id="legal_direction">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="phone_box">
                                    <label class="text-14-medium" for="legal_telephone">{!! __('Declared Phone') !!}</label>
                                    <input type="number" class="form-control" name="legal_telephone" id="legal_telephone">
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
                                                    <input type="text" name="name" class="form-control" required>
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
                                                <div class="delete_btn" data-repeater-delete>
                                                    <a href="javascript:;" class="text-18-medium">{!! __('Delete') !!}</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
                    <button type="button" class="btn-primary text-16-medium" id="evt_cmd_mob_create_form" data-form-name="form-create-operation">{!! __('Yes') !!}</button>
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
                    <button type="button" class="btn-primary text-16-medium">{!! __('Confirm') !!}</button>
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
    <script>
        const url_payer_issuer_add = "{{ route('operations.ajax-add-payer-issuer') }}";
        const url_payer_issuer_list = "{{ route('operations.ajax-payer-issuer-list') }}";
        const url_tag_list = "{{ route('operations.ajax-get-tags-list') }}";
        const pdf_img = "{{ asset('images/mipo/pdf.png') }}";
        const url_update_doc_name_display = "{{ route('operations.ajax-update-document-display-name') }}";
        const url_update_supp_name_display = "{{ route('operations.ajax-update-supporting-attachment-display-name') }}";
        const url_delete_doc_img = "{{ route('operations.ajax-delete-document-file') }}";
        const url_delete_supp_img = "{{ route('operations.ajax-delete-supporting-attachment-file') }}";
        const url_operation_create = "{{ route('operations.store') }}";
        const cmd_save_verification_en_msg = "{!! __('Are you sure you wish to send operation for verification?') !!}";
    </script>
    <script src="{{ asset('plugins/dropzone/dropzone.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-repeater/jquery.repeater.min.js') }}"></script>    
    {{-- <script src="{{ asset('plugins/bootstrap-tags/bootstrap-tags-input.min.js') }}"></script> --}}
    <script src="{{ asset('plugins/select2-4.1.0-rc.0/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('js/jquery.formatCurrency-1.4.0.js') }}"></script>
    <script src="{{ asset('js/jquery.formatCurrency.all.js') }}"></script>
    <script src="{{ asset('js/custom-number-format.js') }}"></script>
    <script>Dropzone.autoDiscover = false;</script>
    <script src="{{ asset('js/operation-create-web.js') }}"></script>
    <script src="{{ asset('js/tour/desktoptour.js') }}"></script>
@endsection
</x-app-layout>
