<x-app-layout>
@section('custom_style')
    <link href="{{ asset('plugins/select2-4.1.0-rc.0/dist/css/select2.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('plugins/dropzone/dropzone.min.css') }}">
    <style>
        .bootstrap-tagsinput {
            min-height: 158px;
            padding: 10px;
            width: 100%;
            height: 40px;
            font-size: 14px;
            color: var(--mipo-black);
            font-weight: 500;
            border-radius: 4px;
            outline: 0;
            display: block;
            line-height: 1.5;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            -webkit-transition: border-color .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;
            transition: border-color .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;
            transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
            transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;
        }
        .bootstrap-tagsinput input {
            display: none;
        }
        /* .bootstrap-tagsinput input {
           border: none;
           box-shadow: none;
           outline: none;
           background-color: transparent;
           padding: 0 6px;
           margin: 0;
           width: auto;
           max-width: inherit;
        }
        .bootstrap-tagsinput.form-control input::-moz-placeholder {
           color: #777;
           opacity: 1;
        }
        .bootstrap-tagsinput.form-control input:-ms-input-placeholder {
           color: #777;
        }
        .bootstrap-tagsinput.form-control input::-webkit-input-placeholder {
           color: #777;
        }
        .bootstrap-tagsinput input:focus {
           border: none;
           box-shadow: none;
        } */
        .bootstrap-tagsinput .tag {
            position: relative;
            display: -webkit-inline-box;
            display: -ms-inline-flexbox;
            display: inline-flex;
            margin-left: 10px;
            padding: 3px 26px 3px 4px;
            font-size: 12px;
            color: var(--mipo-black);
            font-weight: 500;
            background-color: var(--mipo-light-gray);
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            border-radius: 5px;
            margin-bottom: 5px;
        }
        .bootstrap-tagsinput .tag [data-role="remove"] {
            position: absolute;
            right: 4px;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            width: 12px;
            height: 12px;
            cursor: pointer;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
        }
        .bootstrap-tagsinput .tag [data-role="remove"]:after {
            content: '×';
            padding: 0px 2px;
        }
        .select2-selection.select2-selection--multiple {
            min-height: 158px;
            padding: 10px;
            width: 100%;
            height: 40px;
            font-size: 14px;
            color: var(--mipo-black);
            font-weight: 500;
            border-radius: 4px;
            outline: 0;
            display: block;
            line-height: 1.5;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            -webkit-transition: border-color .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;
            transition: border-color .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;
            transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
            transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;
            -webkit-box-shadow: 0 0 4px rgba(0,0,0,.25);
            box-shadow: 0 0 4px rgba(0,0,0,.25);
        }
        .select2-container--default.select2-container--focus .select2-selection--multiple {
            border-color: #86b7fe;
            outline: 0;
            -webkit-box-shadow: 0 0 0 .25rem rgba(13,110,253,.25);
            box-shadow: 0 0 0 .25rem rgba(13,110,253,.25);
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            margin-top:9px;
            line-height:22px;
            background:var(--mipo-light-gray);
            border-radius:5px;
            border:none!important;
            padding:0 26px 0 4px;
            margin-left:10px;
            font-weight:500;
            color:var(--mipo-black);
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice__display {
            padding-right:0;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            left:auto;
            right:0;
            border:none;
            display:-ms-flexbox;
            display:-webkit-box;
            display:flex;
            -webkit-box-align:center;
            -ms-flex-align:center;
            align-items:center;
            -ms-flex-line-pack:center;
            align-content:center;
            height:100%;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove span {
            font-size:0;
            height:12px;
            width:12px;
            display:inline-block;
            vertical-align:top;
            background-image:url("{{ asset('images/closed-icon-black.svg') }}");
            background-position:center center;
            background-repeat:no-repeat;
            background-size:contain;
        }
        .select2-container--default .select2-selection--multiple {
            padding-bottom:9px;
        }
        .select2-container--default .select2-search--inline .select2-search__field {
            height:22px;
            margin-top:9px;
            line-height:22px;
            margin-left:10px;
        }
    </style>
@endsection

    <div class="operation_wrap">
        <div class="container">
            <div class="cr_op_heading">
                <div class="page_heading">
                    <div class="title">
                        <h3 class="text-24-semibold">{!! __('Create Operation') !!}</h3>
                        <div class="imgbox">
                            <i><img src="{{ asset('images/mipo/cr-op-img1.svg') }}" alt="no-image"></i>
                            <span class="text-14-medium">{!! __('Saving...') !!}</span>
                        </div>
                    </div>
                    <div class="buttons">
                        <a href="javascript:;" id="discard-operation-btn" class="dis_btn text-16-medium" onclick="if (confirm('Are you sure, you want to discard this?')) { document.getElementById('form-destroy-operation').submit(); }">{!! __('Discard') !!}</a>
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
                        <form action="{{ route('operations.destroy', ':operation') }}" method="POST" id="form-destroy-operation" class="d-none">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </div>
            </div>
            <form action="{{ route('operations.store') }}" method="POST" enctype="multipart/form-data" id="form-create-operation">
                @csrf
                <div class="create_opt_wrap">
                    <div class="left_form">
                        <div class="box_row">
                            <h6>{{ __('Type of document') }}</h6>
                            <div class="btn-wrap">
                                @permission('my-operations-create-check')
                                <label class="btn active" for="doc1">
                                    <input type="radio" class="btn-check document-type" name="doc_type" value="Cheque" id="doc1" checked>{{ __('Cheque')}}
                                </label>
                                @endpermission
                                @permission('my-operations-create-invoices')
                                <label class="btn" for="doc2">
                                    <input type="radio" class="btn-check document-type" name="doc_type" value="Invoice" id="doc2">{{ __('Invoice')}}
                                </label>
                                @endpermission
                                @permission('my-operations-create-contracts')
                                <label class="btn" for="doc3">
                                    <input type="radio" class="btn-check document-type" name="doc_type" value="Contract" id="doc3">{{ __('Contract')}}
                                </label>
                                @endpermission
                                @permission('my-operations-create-others')
                                <label class="btn" for="doc4">
                                    <input type="radio" class="btn-check document-type" name="doc_type" value="Other" id="doc4">{{ __('Other') }}
                                </label>
                                @endpermission
                            </div>
                        </div>
                        <div class="box_row" id="government-contract-row-box" style="display: none;">
                            <h6>{{ __('Is it a goverment document?') }}</h6>
                            <div class="btn-wrap">
                                <label class="btn" for="govDocY">
                                    <input type="radio" class="btn-check is-government-contract" name="is_government_contract" value="Yes" id="govDocY">{{ __('Yes') }}
                                </label>
                                <label class="btn active" for="govDocN">
                                    <input type="radio" class="btn-check is-government-contract" name="is_government_contract" value="No" id="govDocN" checked>{{ __('No') }}
                                </label>
                            </div>
                        </div>
                        <div class="box_row">
                            <div class="flxrow">
                                <div class="flexcol">
                                    <h6>{!! __('With or without Recurso') !!}</h6>
                                    <div class="btn-wrap">
                                        <label class="btn active" for="res1">
                                            <input type="radio" class="btn-check" name="responsibility" value="With" id="res1" checked>{{ __('With') }}
                                        </label>
                                        <label class="btn" for="res2">
                                            <input type="radio" class="btn-check" name="responsibility" value="Without" id="res2">{{ __('Without') }}
                                        </label>
                                    </div>
                                </div>
                                <div class="flexcol">
                                    <h6>{{ __('Collection Preference') }}</h6>
                                    <div class="btn-wrap">
                                        <label class="btn active" for="mode1">
                                            <input type="radio" class="btn-check preferred-payment-method" name="preferred_payment_method" value="Cash" id="mode1" checked>{{ __('Cash')}}
                                        </label>
                                        <label class="btn" for="mode2">
                                            <input type="radio" class="btn-check preferred-payment-method" name="preferred_payment_method" value="eWallet" id="mode2">{{ __('eWallet')}}
                                        </label>
                                        <label class="btn" for="mode3">
                                            <input type="radio" class="btn-check preferred-payment-method" name="preferred_payment_method" value="Bank Tran." id="mode3">{{ __('Bank Tran.')}}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box_row" id="contract-title-row-box">
                            <h6>{{ __('Title') }}</h6>
                            <input type="text"  class="form-control" name="contract_title" placeholder="">
                        </div>
                        <div class="box_row" id="description-row-box">
                            <h6>{{ __('Description') }}</h6>
                            <textarea rows="2" class="form-control" name="description" placeholder=""></textarea>
                        </div>
                        <div class="box_row">
                            <h6>{{ __('Seller') }}</h6>
                            <input type="text" class="form-control" name="seller_id" placeholder="" value="{{ Auth::user()->name }}">
                        </div>
                        <div class="box_row">
                            <h6>{{ __('Payer') }} <span> <a href="javascript:;" class="alert-link text-primary" id="evt_show_modal_payer">{{ __('Add')}}</a></span></h6>
                            <select name="issuer" id="issuer" class="form-control select2">

                            </select>
                            {{-- <input type="text" class="form-control" name="issuer" id="issuer" placeholder="" list="issuers"> --}}
                             {{-- <datalist id="issuers">
                                @foreach($issuers as $issuer)
                                    <option value="">{{ $issuer->company_name .' '.  $issuer->ruc_text_id }}</option>
                                @endforeach
                            </datalist>  --}}
                            
                        </div>
                        <div class="box_row">
                            <h6>{!! __('Dollars or Guarani') !!}</h6>
                            <div class="btn-wrap">
                                <label class="btn" for="currencyDollar">
                                    <input type="radio" class="btn-check" name="preferred_currency" value="USD" id="currencyDollar">{!! __('USD ($)') !!}
                                </label>
                                <label class="btn active" for="currencyGuarani">
                                    <input type="radio" class="btn-check" name="preferred_currency" value="Gs." id="currencyGuarani" checked>{!! __('Gs. (₲)') !!}
                                </label>
                            </div>
                        </div>
                        <div class="box_row">
                            <h6>{!! __('Nominal Value Document') !!}</h6>
                            <input type="text" class="form-control evt_validate_decimal op_amount" name="amount" id="amount" placeholder="">
                        </div>
                        <div class="box_row">
                            <h6>{!! __('Minimum amount willing to sell check') !!}</h6>
                            <input type="text" class="form-control evt_validate_decimal op_amount_req" name="amount_requested" placeholder="">
                        </div>
                        <div class="box_row">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" checked name="accept_below_requested" value="1" id="acceptOffers">
                                <label class="form-check-label" for="acceptOffers">
                                    {!! __('Accept offers below my minimum amount') !!}
                                </label>
                            </div>
                        </div>
                        <div class="box_row" id="invoice-type-row-box">
                            <h6>{{ __('Invoice Type') }}</h6>
                            <div class="btn-wrap">
                                <label class="btn active" for="inv1">
                                    <input type="radio" class="btn-check invoice-type" name="invoice_type" value="Service" id="inv1" checked>{{ __('Service') }}
                                </label>
                                <label class="btn" for="inv2">
                                    <input type="radio" class="btn-check invoice-type" name="invoice_type" value="Product" id="inv2">{{ __('Product') }}
                                </label>
                            </div>
                        </div>
                        <div class="box_row">
                            <h6>{{ __('Date of issue') }}</h6>
                            <input type="date" class="form-control evt_date_single"  data-date="" data-date-format="DD/MM/YYYY" id="issuance_date" name="issuance_date" placeholder="">
                        </div>
                        <div class="box_row">
                            <div class="flxrow">
                                <h6>{{ __('Due date') }}</h6>
                                <div class="form-check" id="evt_auto_expire">
                                    <input class="form-check-input" type="checkbox" name="auto_expire" value="on" id="autoExpire">
                                    <label class="form-check-label" for="autoExpire">
                                        {{ __('Automatic expiration') }}
                                    </label>
                                </div>
                            </div>
                            <input type="date" class="form-control evt_date_single" name="expiration_date" id="expiration_date" placeholder="">
                        </div>
                        <div class="box_row" id="expiration-add-day-row-box">
                            <h6>{{ __('Additional days') }}</h6>
                            <input type="number" readonly class="form-control" id="extra_expiration_days" name="extra_expiration_days" list="suggestions_expiration_add_days">
                            @if(config('constants.OPERATION_EXTRA_EXPIRE_DAYS'))
                                @foreach (config('constants.OPERATION_EXTRA_EXPIRE_DAYS') as $key => $day)
                                <span role="button" title="{{ __('Add Extra Days')}}" class="badge badge-dark text-dark evt_click_extra_expiration_days">{{$day}}</span>
                                @endforeach
                            @endif
                            {{-- <datalist id="suggestions_expiration_add_days">
                                @if(config('constants.OPERATION_EXTRA_EXPIRE_DAYS'))
                                    @foreach (config('constants.OPERATION_EXTRA_EXPIRE_DAYS') as $key => $day)
                                        <option value="{{$day}}">
                                    @endforeach
                                @endif
                            </datalist> --}}
                        </div>
                        <div class="box_row" id="check-number-row-box">
                            <h6>{!! __('Check number') !!}</h6>
                            <input type="text" class="form-control" name="check_number" placeholder="">
                        </div>

                        <div class="box_row" id="contract-number-row-box">
                            <h6>{!! __('Contract number') !!}</h6>
                            <input type="text" class="form-control" name="contract_number" placeholder="">
                        </div>
                        
                        {{-- <div class="box_row" id="issuer-company-type-row-box">
                            <h6>{{ __('Type of company') }}</h6>
                            <select class="form-select" name="issuer_company_type" id="issuer-company-type">
                                <option value="" selected>{{ __('Select') }}</option>
                                @if($companies)
                                    @foreach ($companies as $key => $val)
                                        <option value="{{ $val->name }}">{{ $val->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div> --}}
                        <div class="box_row" id="invoice-number-row-box">
                            <h6>{{ __('Invoice Number') }}</h6>
                            <input type="text" class="form-control" name="invoice_number" placeholder="">
                        </div>
                        {{-- <div class="box_row" id="tax-id-row-box">
                            <h6>{{ __('Tax ID') }}</h6>
                            <input type="text" class="form-control" name="tax_id" placeholder="">
                        </div> --}}
                        <div class="box_row" id="timbrado-row-box">
                            <h6>{{ __('Timbrado') }}</h6>
                            <input type="text" class="form-control" name="timbrado" placeholder="">
                        </div>
                        <div class="box_row" id="stamp-expiration-row-box">
                            <h6>{{ __('Stamp Expiration') }}</h6>
                            <input type="date" class="form-control" name="stamp_expiration" placeholder="">
                        </div>
                        {{--  <div class="box_row" id="authorized-personnel-row-box">
                            <h6>{{ __('Authorized personnel') }}</h6>
                            <input type="text" class="form-control" name="authorized_personnel" placeholder="">
                        </div> --}}
                        {{-- <div id="authorized-personnel-signature-row-box">
                            <div class="box_row">
                                <div class="file_row">
                                    <h6>{{ __('Signature: Upload a Picture') }}</h6>
                                    <span class="form-control browse">{{ __('Browse from the device') }}
                                        <input type="file" name="authorized_personnel_signature" placeholder="{{ __('Browse from the device') }}" accept="image/*" capture="camera">
                                    </span>
                                </div>
                            </div>
                            <div class="box_row" id="authorized-personnel-signature-preview-box" style="display: none;">
                                <div class="sign_row">
                                    <div class="sign_box"><img src="#" alt="mipo" id="authorized-personnel-signature-preview" style="display: none;"></div>
                                    <div class="cta-box">
                                        <img src="{{ asset('images/delete-icon.svg') }}" alt="mipo" role="button" id="delete-authorized-personnel-signature">
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        <div class="box_row" id="paying-bank-row-box">
                            <h6>{{ __('Paying Bank') }}</h6>
                            <select class="form-control" name="issuer_bank" id="issuer-bank" >
                                <option value="">{{ __('Select Issure Bank')}}</option>
                                @foreach($issuerBanks as $issuerBank)
                                    <option value="{{ $issuerBank->id }}">{{ $issuerBank->name }}</option>
                                @endforeach    
                            </select>
                        </div>
                        <div class="box_row">
                            <h6>{{ __('Legal direction') }}</h6>
                            <input type="text" class="form-control" name="legal_direction" id="legal_direction" >
                        </div>
                        <div class="box_row">
                            <h6>{{ __('Legal Telephone') }}</h6>
                            <input type="number" class="form-control" name="legal_telephone" id="legal_telephone" >
                        </div>
                        <div class="repeater" id="reference-repeater">
                            <div class="box_row">
                                <h6>{{ __('Commercial References (Optional)') }}</h6>
                            </div>
                            <div data-repeater-list="references" class="references-repeater">                                
                                <div data-repeater-item>
                                    <input type="hidden" name="id" value="">
                                    <div class="info_row">                                        
                                        <div class="cta_box">
                                            <div class="cta_inner">
                                                <img data-repeater-delete src="{{ asset('/images/delete-icon.svg') }}" alt="mipo" role="button">
                                            </div>
                                        </div>
                                        <div class="box_row">
                                            <h6>{{ __('Name') }}</h6>
                                            <input type="text" name="name" class="form-control" placeholder="" required>
                                        </div>
                                        <div class="box_row">
                                            <h6>{{ __('Company Name') }}</h6>
                                            <input type="text" name="company_name" class="form-control" placeholder="">
                                        </div>
                                        <div class="box_row">
                                            <h6>{{ __('Phone Number') }}</h6>
                                            <input type="text" name="phone_number" class="form-control" placeholder="">
                                        </div>
                                        <div class="box_row">
                                            <h6>{{ __('Email Address') }}</h6>
                                            <input type="email" name="email" class="form-control" placeholder="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <img data-repeater-create src="{{ asset('/images/plus-gray.svg') }}" alt="mipo" role="button">
                        </div>

                        <div class="terms_row">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="on" id="terms" name="tnc" required>
                                <label class="form-check-label" for="terms">
                                    {{ __('Accept') }} <a href="#">{{ __('terms & conditions') }}</a>
                                </label>
                            </div>
                        </div>
                        <div class="btnbox">
                            <input class="primary-btn" type="submit" value="{{ __('Submit') }}">
                        </div>                        
                    </div>
                    <!-- Left form end -->
                    <div class="right_block">
                        <div class="help_option">
                            <p>{{ __('Need help?') }} <a href="#">{{ __('Click here') }}</a></p>
                        </div>
                        <div class="file_row">
                            <h6>{{ __('Upload a Picture') }}</h6>
                            <div id="document-dropzone">
                                <div class="dz-message">
                                    <span class="form-control browse" role="button">{{ __('Browse from the device') }}
                                    </span>
                                </div>
                            </div>
                            <div id="document-preview" style="display: none;">
                                <div class="doc_row">
                                    <div class="doc_wrap">
                                        <div class="doc_img">
                                            <img src="{{ asset('images/mipo/pdf.png') }}" data-dz-thumbnail>
                                        </div>
                                        <div class="cta_box">
                                            <div class="cta_inner">
                                                <img src="{{ asset('/images/delete-icon.svg') }}" alt="mipo" role="button" class="dz-remove">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="input-row">
                                        <input type="text" class="form-control" name="document_name" placeholder="{{ __('Enter name of the document') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="documents-previews-wrapper dropzone-previews"></div>

                        <div class="opt_support_row">
                            <h5>{{ __('Supporting Attachments') }}</h5>
                            <div class="file_row">
                                <h6>{{ __('Upload a Picture') }}</h6>
                                <div id="supporting-attachment-dropzone">
                                    <div class="dz-message">
                                        <span class="form-control browse" role="button">{{ __('Browse from the device') }}
                                        </span>
                                    </div>
                                </div>

                                <div id="supporting-attachment-preview" style="display: none;">
                                    <div class="doc_row">
                                        <div class="doc_wrap">
                                            <div class="doc_img">
                                                <img src="{{ asset('images/mipo/pdf.png') }}" data-dz-thumbnail>
                                            </div>
                                            <div class="cta_box">
                                                <div class="cta_inner">
                                                    <img src="{{ asset('/images/delete-icon.svg') }}" alt="mipo" role="button" class="dz-remove">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="input-row">
                                            <input type="text" class="form-control" name="supporting_attachment_name" placeholder="{{ __('Enter name of the document') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="supporting-attachments-previews-wrapper dropzone-previews"></div>
                        </div>

                        {{-- <div class="tags_row">
                            <h6>{{ __('Tags') }}</h6>
                            <select name="tags[]" id="operation-tags" class="form-control" multiple>

                            </select>
                        </div> --}}
                    </div>
                    <!-- Right block end -->
                </div>
                <div class="create_opera_wrap_section">
                    <div class="box_wrap">
                        <div class="checkbox_section">
                            <div class="check_wrap">
                                <h6 class="text-16-medium">{!! __('Type of Document') !!}</h6>
                                <div class="btn-wrap">
                                    <label class="btn active text-14-medium" for="doc=1">
                                        <input type="radio" class="btn-check document-type" name="doc_type" value="Cheque" id="doc=1" checked>{!! __('Check') !!}
                                    </label>
                                    <label class="btn text-14-medium" for="doc=2">
                                        <input type="radio" class="btn-check document-type" name="doc_type" value="Invoice" id="doc=2">{!! __('Invoice') !!}
                                    </label>
                                    <label class="btn text-14-medium" for="doc=3">
                                        <input type="radio" class="btn-check document-type" name="doc_type" value="Contract" id="doc=3">{!! __('Contract') !!}
                                    </label>
                                    <label class="btn text-14-medium" for="doc=4">
                                        <input type="radio" class="btn-check document-type" name="doc_type" value="Other" id="doc=4">{!! __('Other') !!}
                                    </label>
                                </div>
                            </div>
                            <div class="check_wrap">
                                <h6 class="text-16-medium">{!! __('With or Without Recurso') !!}</h6>
                                <div class="btn-wrap">
                                    <label class="btn active text-14-medium" for="res=1">
                                        <input type="radio" class="btn-check" name="responsibility" value="With" id="res=1" checked>{!! __('With Recurso') !!}
                                    </label>
                                    <label class="btn text-14-medium" for="res=2">
                                        <input type="radio" class="btn-check" name="responsibility" value="Without" id="res=2">{!! __('Without Recurso') !!}
                                    </label>
                                </div>
                            </div>
                            <div class="check_wrap">
                                <h6 class="text-16-medium">{!! __('Payment Preference') !!}</h6>
                                <div class="btn-wrap">
                                    <label class="btn active text-14-medium" for="mode=1">
                                        <input type="radio" class="btn-check preferred-payment-method" name="preferred_payment_method" value="Cash" id="mode=1" checked>{!! __('Cash') !!}
                                    </label>
                                    <label class="btn text-14-medium" for="mode=2">
                                        <input type="radio" class="btn-check preferred-payment-method" name="preferred_payment_method" value="eWallet" id="mode=2">{!! __('eWallet') !!}
                                    </label>
                                    <label class="btn text-14-medium" for="mode=3">
                                        <input type="radio" class="btn-check preferred-payment-method" name="preferred_payment_method" value="Bank Tran." id="mode=3">{!! __('Bank Transfer') !!}
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box_wrap imgupload_wrap">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="file_row">
                                    <h6 class="text-14-medium">{!! __('Upload Document') !!}</h6>
                                    <div id="dropzone_wrap" class="opdp_zone">
                                        <div class="dz-message">
                                            <label for="dropzone_area" class="text-14-medium">{!! __('Upload a Picture') !!}</label>
                                            <span class="browse text-12-medium" role="button"><i><img src="{{ asset('images/mipo/cr-op-img2.svg') }}" alt="no-image"></i>{!! __('Upload From Device') !!}</span>
                                        </div>
                                    </div>
                                    <div class="up_docimages">
                                        <div id="document-preview" class="opdp_preview">
                                            <div class="doc_row">
                                                <div class="doc_wrap">
                                                    <div class="doc_img">
                                                        <img src="{{ asset('images/mipo/cr-op-img3.png') }}" alt="no-image">
                                                    </div>
                                                    <div class="cta_box">
                                                        <div class="cta_inner">
                                                            <img src="{{ asset('/images/mipo/cr-op-img4.svg') }}" alt="mipo" role="button" class="dz-remove">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="input-row">
                                                    <input type="text" class="text-14-medium" name="document_name" placeholder="{!! __('Insert Title of Document') !!}">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="document-preview" class="opdp_preview">
                                            <div class="doc_row">
                                                <div class="doc_wrap">
                                                    <div class="doc_img">
                                                        <img src="{{ asset('images/mipo/cr-op-img3.png') }}" alt="no-image">
                                                    </div>
                                                    <div class="cta_box">
                                                        <div class="cta_inner">
                                                            <img src="{{ asset('/images/mipo/cr-op-img4.svg') }}" alt="mipo" role="button" class="dz-remove">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="input-row">
                                                    <input type="text" class="form-control" name="document_name" placeholder="{!! __('Insert Title of Document') !!}">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="document-preview" class="opdp_preview">
                                            <div class="doc_row">
                                                <div class="doc_wrap">
                                                    <div class="doc_img">
                                                        <img src="{{ asset('images/mipo/cr-op-img3.png') }}" alt="no-image">
                                                    </div>
                                                    <div class="cta_box">
                                                        <div class="cta_inner">
                                                            <img src="{{ asset('/images/mipo/cr-op-img4.svg') }}" alt="mipo" role="button" class="dz-remove">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="input-row">
                                                    <input type="text" class="form-control" name="document_name" placeholder="{!! __('Insert Title of Document') !!}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="file_row">
                                    <h6 class="text-14-medium">{!! __('Supporting Attachments') !!}</h6>
                                    <div id="document_dropzone_wrapper" class="opdp_zone">
                                        <div class="dz-message">
                                            <label for="dropzone_area1" class="text-14-medium">{!! __('Subir una foto') !!}</label>
                                            <span class="browse text-12-medium" role="button"><i><img src="{{ asset('images/mipo/cr-op-img2.svg') }}" alt="no-image"></i>{!! __('Upload From Device') !!}</span>
                                        </div>
                                    </div>
                                    <div class="up_docimages">
                                        <div id="document-preview" class="opdp_preview">
                                            <div class="doc_row">
                                                <div class="doc_wrap">
                                                    <div class="doc_img">
                                                        <img src="{{ asset('images/mipo/cr-op-img3.png') }}" alt="no-image">
                                                    </div>
                                                    <div class="cta_box">
                                                        <div class="cta_inner">
                                                            <img src="{{ asset('/images/mipo/cr-op-img4.svg') }}" alt="mipo" role="button" class="dz-remove">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="input-row">
                                                    <input type="text" class="form-control" name="document_name" placeholder="{!! __('Insert Title of Document') !!}">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="document-preview" class="opdp_preview">
                                            <div class="doc_row">
                                                <div class="doc_wrap">
                                                    <div class="doc_img">
                                                        <img src="{{ asset('images/mipo/cr-op-img3.png') }}" alt="no-image">
                                                    </div>
                                                    <div class="cta_box">
                                                        <div class="cta_inner">
                                                            <img src="{{ asset('/images/mipo/cr-op-img4.svg') }}" alt="mipo" role="button" class="dz-remove">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="input-row">
                                                    <input type="text" class="form-control" name="document_name" placeholder="{!! __('Insert Title of Document') !!}">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="document-preview" class="opdp_preview">
                                            <div class="doc_row">
                                                <div class="doc_wrap">
                                                    <div class="doc_img">
                                                        <img src="{{ asset('images/mipo/cr-op-img3.png') }}" alt="no-image">
                                                    </div>
                                                    <div class="cta_box">
                                                        <div class="cta_inner">
                                                            <img src="{{ asset('/images/mipo/cr-op-img4.svg') }}" alt="mipo" role="button" class="dz-remove">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="input-row">
                                                    <input type="text" class="form-control" name="document_name" placeholder="{!! __('Insert Title of Document') !!}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box_wrap sepa_wrap">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="box_title_row">
                                    <label class="text-14-medium">{!! __('Title') !!}</label>
                                    <input type="text" class="form-control" name="title" placeholder="">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="box_row">
                                    <h6 class="text-14-medium">{!! __('Seller') !!}</h6>
                                    <input type="text" class="form-control" name="seller_id" placeholder="" value="{{ Auth::user()->name }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="box_row">
                                    <div class="heading_sec">
                                        <h6 class="text-14-medium">{!! __('Payer') !!} </h6>
                                        <span><a href="javascript:;" class="add_wrap text-14-medium" id="evt_show_modal_payer">{!! __('Add Payer') !!}</a></span>
                                    </div>
                                    <div class="sc_op_wrap">
                                        <select name="issuer" id="issuer" class="form-control select2 selectbox">
                                            @foreach($issuers as $issuer)
                                                <option value="">{{ $issuer->company_name .' '.  $issuer->ruc_text_id }}</option>
                                            @endforeach
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
                            <div class="box_tab" id="government-contract-row-box">
                                <h6 class="text-16-medium">{!! __('Commercial or Government') !!}</h6>
                                <div class="btn-wrap">
                                    <label class="btn text-14-medium" for="gov_doc_co">
                                        <input type="radio" class="btn-check is-government-contract" name="is_government_contract" value="Yes" id="gov_doc_co">{!! __('Comercial') !!}
                                    </label>
                                    <label class="btn active text-14-medium" for="gov_doc_go">
                                        <input type="radio" class="btn-check is-government-contract" name="is_government_contract" value="No" id="gov_doc_go" checked>{!! __('Government') !!}
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="box_nor_value">
                                    <label class="text-14-medium">{!! __('Document’s Nominal Value') !!}</label>
                                    <input type="text" class="form-control evt_validate_decimal op_amount op_gurani op_dollar" name="amount" id="amount" placeholder="">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="box_mini_value">
                                    <label class="text-14-medium">{!! __('Amount able to Sell Document (this value is not public)') !!}</label>
                                    <input type="text" class="form-control evt_validate_decimal op_amount_req op_gurani op_dollar" name="amount_requested" placeholder="">
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
                                    <label class="text-14-medium">{!! __('Date of Issuance') !!}</label>
                                    <div class="lain_sec">
                                        <input type="text" class="form-control evt_date_single"  data-date="" data-date-format="" id="issuance_date" name="issuance_date" placeholder="">
                                        <div class="cl_wrap"><img src="{{ asset('images/mipo/cr-op-img6.svg') }}" alt="no-image"></div>
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
                                                <label class="form-check-label text-14-medium" for="autoExpire-1">{!! __('Automatic expiration') !!}</label>
                                            </div>
                                        </div>
                                        <div class="lain_wrap">
                                            <input type="text" class="form-control evt_date_single" name="expiration_date" id="expiration_date" placeholder="">
                                            <div class="cl_wrapper"><img src="{{ asset('images/mipo/cr-op-img6.svg') }}" alt="no-image"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="boro" id="expiration-add-day-row-box">
                                    <label class="text-14-medium">{!! __('Additional Days Available After Expiration') !!}</label>
                                    <select class="form-control selectbox" name="extra_expiration_days" id="extra_expiration_days" >
                                        <option value="DESC">{!! __('30') !!}</option>
                                        <option value="ASC">{!! __('60') !!}</option>
                                        <option value="DESC">{!! __('120') !!}</option>
                                        <option value="ASC">{!! __('240') !!}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="box_invo" id="invoice-number-row-box">
                                    <label class="text-14-medium">{!! __('Invoice Number') !!}</label>
                                    <input type="text" class="form-control" name="invoice_number" placeholder="">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="box_invo" id="dcoument-number-row-box">
                                    <label class="text-14-medium">{!! __('Dcoument Number') !!}</label>
                                    <input type="text" class="form-control" name="dcoument Numberr" placeholder="">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="box_row">
                                    <label class="text-14-medium">{!! __('Stamped') !!}</label>
                                    <input type="text" class="form-control evt_date_single"  data-date="" data-date-format="" id="stamped" name="stamped" placeholder="">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="box_row">
                                    <div class="wrap_sec">
                                        <div class="ch_sec">
                                            <label class="text-14-medium">{!! __('Stamped Expiration Date') !!}</label>
                                        </div>
                                        <div class="lain_wrap">
                                            <input type="text" class="form-control evt_date_single" name="expiration_date" id="expiration_date" placeholder="">
                                            <div class="cl_wrapper"><img src="{{ asset('images/mipo/cr-op-img6.svg') }}" alt="no-image"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="box_row_wrap" id="check-number-row-box">
                                    <label class="text-14-medium">{!! __('Check number') !!}</label>
                                    <input type="number" class="form-control" name="check_number" placeholder="">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="box_bus" id="issuer-company-type-box">
                                    <label class="text-14-medium">{!! __('Type of Business') !!}</label>
                                    <select class="form-control selectbox" name="issuer_company_type" id="issuer-company-type">
                                        <option value="SA">{!! __('SA') !!}</option>
                                        <option value="LLP">{!! __('LLP') !!}</option>
                                        <option value="PVT LTD">{!! __('PVT LTD') !!}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="box_row_wrap" id="paying-bank-row-box">
                                    <label class="text-14-medium">{!! __('Payer’s Bank') !!}</label>
                                    <select class="form-control selectbox nice_wrap" name="issuer_bank" id="issuer-bank" >
                                        <option value="">{!! __('Select Issure Bank') !!}</option>
                                        @foreach($issuerBanks as $issuerBank)
                                            <option value="{{ $issuerBank->id }}">{{ $issuerBank->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="addresh_box">
                                    <label class="text-14-medium">{!! __('Legal Address') !!}</label>
                                    <input type="text" class="form-control" name="legal_direction" id="legal_direction" >
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="phone_box">
                                    <label class="text-14-medium">{!! __('Declared Phone') !!}</label>
                                    <input type="number" class="form-control" name="legal_telephone" id="legal_telephone" >
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box_wrap rewrap_section">
                        <div class="repeater" id="reference-repeater">
                            <div class="box_row">
                                <img data-repeater-create src="{{ asset('/images/mipo/cr-op-img7.svg') }}" alt="mipo" role="button">
                                <h6 class="text-14-medium">{{ __('Commercial References (Optional)') }}</h6>
                            </div>
                            <div data-repeater-list="references" class="references-repeater">                                
                                <div data-repeater-item>
                                    <input type="hidden" name="id" value="">
                                    <div class="info_row">                                        
                                        <div class="cta_box">
                                            <div class="cta_inner">
                                                <img src="{{ asset('/images/mipo/cr-op-img8.svg') }}" alt="mipo" role="button">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <div class="box">
                                                    <label class="text-14-medium">{!! __('Name') !!}</label>
                                                    <input type="text" name="name" class="form-control" placeholder="" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="box">
                                                    <label class="text-14-medium">{!! __('Business Name') !!}</label>
                                                    <input type="text" name="company_name" class="form-control" placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="box">
                                                    <label class="text-14-medium">{!! __('Phone Number') !!}</label>
                                                    <input type="number" name="phone_number" class="form-control" placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="box">
                                                    <label class="text-14-medium">{!! __('Email') !!}</label>
                                                    <input type="email" name="email" class="form-control" placeholder="">
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
                                    <input class="form-check-input" type="checkbox" value="on" id="terms-11" name="tnc" required>
                                    <label class="form-check-label text-14-medium" for="terms-11">
                                        {!! __('Accept') !!} <a href="#">{!! __('terms & conditions') !!}</a>
                                    </label>
                                </div>
                            </div>
                            <p class="text-14-medium">{!! __('When accepting and sending operation, it’ll be set on hold for verification and approval.') !!}</p>
                            <div class="btnbox">
                                <input class="sub_btn text-16-medium" type="submit" value="{!! __('Submit') !!}">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade map_modal" id="modal_payer_issuer" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalToggleLabel">{{ __('Add Payer/Issuer')}}</h5>
                    <a href="javascript:void(0)" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
                </div>
                <div class="modal-body">
                    <form action="javascript:void(0)" method="post" name="form_add_payer_issuer" id="form_add_payer_issuer">
                        @csrf
                        <div class="modal_form_row">
                            <div class="modal_form_col modal_form_col_half">
                                <div class="input-row">
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Name" required>
                                </div>
                            </div>
                            <div class="modal_form_col modal_form_col_half">
                                <div class="input-row">
                                    <input type="text" name="ruc" id="ruc" class="form-control" placeholder="{{ __('RUC')}}" required>
                                </div>
                            </div>
                            <div class="modal_form_col modal_form_submit">
                                <input type="submit" value="Submit" id="cmd_btn_add_payer" class="btn btn-primary">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@section('custom_script')
<script src="{{ asset('plugins/dropzone/dropzone.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-repeater/jquery.repeater.min.js') }}"></script>    
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
        let expiration_add_days = $('#expiration-add-day-row-box');
        let auto_expire = $('#evt_auto_expire');
        let paying_bank = $('#paying-bank-row-box');
        let stamp_expiration = $('#stamp-expiration-row-box');
        let contract_number = $('#contract-number-row-box');
        
        // let authorizedPersonnelSignature = $('#authorized-personnel-signature-row-box');
        // let tagsInput = $('input[name="tags"]');

        $(document).ready(function () {
            applyDocTypeChange($('input[name="doc_type"]').val());
            // pageLoadTags();

            $referenceRepeater = $('#reference-repeater').repeater({
                initEmpty: true,
                show: function () {
                    $(this).slideDown();
                },
                hide: function (deleteElement) {
                    if(confirm('Are you sure you want to delete this element?')) {
                        $(this).slideUp(deleteElement);
                    }
                },
                isFirstItemUndeletable: false,
            });

            $('#evt_show_modal_payer').click(function (e) { 
                e.preventDefault();
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
                                text: res.data.issuer_name+' '+ res.data.ruc,
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
                // tokenSeparators: [',', ';'],
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
                // let el = $(this);
                // tagsInput.tagsinput('add', {'key' : el.prop('name'), 'value' : el.val()});            
                submitOperationForm($('#form-create-operation'), (res) => {toastr.success(res.message);});
            }, 500));

            $(document).on('change', '#amount', debounce(function (e) {
                e.preventDefault();
                submitOperationForm($('#form-create-operation'), (res) => {toastr.success(res.message);});
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

            $(document).on('submit', '#form-create-operation', function(e) {
                e.preventDefault();
                e.stopPropagation();
                submitOperationForm($(this), (res) => {
                    $('.terms_row').remove();
                    
                    let timerInterval;
                    Swal.fire({
                        title: res.message,
                        html: 'You will be redirected to details page.',
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
            
            $('#form-create-operation :input').removeClass('is-invalid');
            $('#form-create-operation .invalid-feedback').remove();
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
            console.log(data);

            $.ajax({
                type: 'POST',
                dataType: 'JSON',
                headers: {
                    'X-CSRF-Token': "{{ csrf_token() }}",
                },
                url: el.attr('action'),
                data: data,
                cache: false,
                processData: false,
                contentType: false,
                success: function (res) {
                    if (res.success) {
                        console.log(res);
                        // toastr.success(res.message);                        

                        documentDropzone.removeAllFiles(true);
                        $('.documents-previews-wrapper').empty();
                        (res.documents).forEach(document => {
                            documentFile = { 
                                name: document.name, 
                                size: document.size * 1024,
                            };
                            
                            // documentDropzone.files.push(documentFile);
                            // documentFile.status = Dropzone.ADDED;
                            // documentDropzone.emit("addedfile", documentFile);
                            // documentDropzone.emit("thumbnail", documentFile, document.document_url);
                            // documentFile.accepted = true;
                            // documentFile.status = Dropzone.QUEUED;

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
                                    if(confirm("Are you sure you want to delete this file?")) {
                                        deleteDocument($(this), () => $(this).parents('.dz-image-preview').remove());
                                    }
                                });
                                // $(documentFile.previewElement).prepend(`<input type="hidden" name="file_id" value="${document.id}">`);
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
                                    if(confirm("Are you sure you want to delete this file?")) {
                                        deleteSupportingAttachment($(this), () => $(this).parents('.dz-image-preview').remove());
                                    }
                                });
                                // supportingAttachmentDropzone.emit("addedfile", supportingAttachmentFile);
                                // supportingAttachmentDropzone.emit("thumbnail", supportingAttachmentFile, supportingAttachment.attachment_url);
                                // supportingAttachmentDropzone.files.push(supportingAttachmentFile);
                            }, null, false);
                        });

                        $('.references-repeater').empty();
                        $referenceRepeater.setList(res.commercialReferences);

                        el.attr('action', res.updateLink);
                        el.remove('#update-method-input').prepend('<input type="hidden" id="update-method-input" name="_method" value="PUT">');
                        $('#discard-operation-btn').show();
                        let discardAction = $('#form-destroy-operation').attr('action');
                        discardAction = discardAction.replace(':operation', res.operation);
                        $('#form-destroy-operation').attr('action', discardAction);

                        callback(res);
                    }
                    else {
                        alert('Error '+ res.status + ': ' + res.message);
                    }
                    unsetLoadin();
                },
                statusCode: {
                    422: function (res) {
                        $.each(res.responseJSON.errors, function (key, value) {
                            let target = $('#form-create-operation [name="' + dotToArray(key) + '"]');
                            target.addClass('is-invalid');
                            let errorAlert = '<span class="invalid-feedback" role="alert">' + value + '</span>';
                            target.parent().append(errorAlert);
                        });
                        unsetLoadin();
                    }
                },
            });
        }

        function pageLoadTags () {
            // tagsInput.tagsinput('add', {'key' : $('.document-type').prop('name'), 'value' : $('.document-type').val()});
            // if ($('.is-government-contract').val() == 'Yes') {
            //     tagsInput.tagsinput('add', {'key' : $('.is-government-contract').prop('name'), 'value' : 'Government'});
            // }            
            // tagsInput.tagsinput('add', {'key' : $('.preferred-payment-method').prop('name'), 'value' : $('.preferred-payment-method').val()});
            // tagsInput.tagsinput('add', {'key' : $('.invoice-type').prop('name'), 'value' : $('.invoice-type').val()});
            // tagsInput.tagsinput('add', {'key' : $('#issuer').prop('name'), 'value' : $('#issuer').val()});
            // tagsInput.tagsinput('add', {'key' : $('#issuer-company-type').prop('name'), 'value' : $('#issuer-company-type').val()});
            // tagsInput.tagsinput('add', {'key' : $('#issuer-bank').prop('name'), 'value' : $('#issuer-bank').val()});
        }

        function applyDocTypeChange(value) {
            if (value == 'Cheque') {
                auto_expire.hide();
                governmentContract.hide();
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
                auto_expire.show();
                governmentContract.hide();
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
                paying_bank.hide();
                stamp_expiration.show();
                contract_number.hide();
                // authorizedPersonnelSignature.show();
            }
            else if (value == 'Contract') {
                governmentContract.show();
                if(governmentContract.find('input:checked').val() == 'Yes'){
                    // tagsInput.tagsinput('add', {'key' : governmentContract.find('input').prop('name'), 'value' : 'Government'});
                }
                auto_expire.show();
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
                timbrado.show();
                authorizedPersonnel.hide();
                expiration_add_days.show();
                paying_bank.hide();
                stamp_expiration.show();
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
                paying_bank.hide();
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
            url: "{{ route('operations.store') }}",
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
            acceptedFiles: 'image/*, application/pdf',
            // accept: function(file, done) {
            // },

            // params: function (files, xhr) {
            //     return {
            //         filename: '',
            //     }
            // },

            init: function () {
                documentDropzone = this;                

                this.on("sendingmultiple", function(data, xhr, formData) {

                    // displayName = file.previewElement.querySelector("input[name='document_name'");
                    // formData.append("documents[display_name]", $(displayName).val());

                    // $("#form-create-operation").trigger('submit');

                    // let x = $("#form-create-operation").serializeArray();
                    // $.each(x, function(i, field) {
                    //     formData.append(field.name, field.value);
                    // });
                });
                this.on("addedfile", function (file) {
                    removeBtn = file.previewElement.querySelector('.dz-remove');
                    removeBtn.addEventListener("click", function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        documentDropzone.removeFile(file);
                    });
                });
                this.on("addedfiles", function() {
                    submitOperationForm($('#form-create-operation'), (res) => {toastr.success(res.message);});
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
                            let target = $('#form-create-operation [name="' + dotToArray(key) + '"]');
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
            url: "{{ route('operations.store') }}",
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

            init: function () {
                supportingAttachmentDropzone = this;
                
                this.on("sendingmultiple", function(data, xhr, formData) {
                    
                });
                this.on("addedfile", function (file) {
                    removeBtn = file.previewElement.querySelector('.dz-remove');
                    removeBtn.addEventListener("click", function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        supportingAttachmentDropzone.removeFile(file);
                    });
                });
                this.on("addedfiles", function() {
                    submitOperationForm($('#form-create-operation'), (res) => {toastr.success(res.message);});
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
                            let target = $('#form-create-operation [name="' + dotToArray(key) + '"]');
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

    </script>
@endsection
</x-app-layout>

{{-- create operation pop up style by k --}}

<div class="drafts_wrap_delete_popup">
    <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog"></div>
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

{{-- create operation pop up style by k --}}