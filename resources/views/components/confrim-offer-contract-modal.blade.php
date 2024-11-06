<div class="modal fade bd-example-modal-lg" id="confrim_offer_contract_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-20-semibold" id="exampleModalLabel">{{ __('Deals contract paper') }}</h5>
                <button type="button" class="close evt_sign_contract_btn" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">
                        <img src="{{ asset('images/mipo/blk_close.svg') }}" alt="no-image">
                    </span>
                </button>
            </div>
            <div class="modal-body" id="ajax_confrim_offer_contract">

            </div>
            <div class="modal-body">
                {{-- <h6>OTP : <span id="deal_otp"></span></h6> --}}
                <form name="deals_contract_form" id="deals_contract_form" action="{{ route('counter-offer.ajax-confirm-offer-save') }}" method="post" novalidate="novalidate" enctype="multipart/form-data" class="form-validation">
                    @csrf
                  {{--   <div class="form-group col-md-6 mb-2">
                        <input type="text" class="form-control" required id="deals_contract_name" name="deals_contract_name" placeholder="Name">
                    </div> --}}
                    {{-- <div class="form-group col-md-6 mb-2" id="evt_div_select_box_deals_contract_name">
                        <select class="evt_div_select_option_box form-control" id="deals_contract_name" name="deals_contract_name" required>
                        
                        </select>
                    </div> --}}
                   {{--  <div class="form-group col-md-6 mb-2">
                        <input type="text" class="form-control" required id="deals_contract_ids" name="deals_contract_ids" placeholder="Id No">
                    </div>
                    <div class="form-group col-md-6 mb-2">
                        <input type="text" class="form-control" required id="deals_contract_phone" name="deals_contract_phone" placeholder="Phone Number">
                    </div>
                    <div class="form-group row mb-2">
                        <div class="col-md-6">
                            <input type="number" class="form-control" required id="deals_contract_otp" name="deals_contract_otp" placeholder="OTP">
                        </div>
                        <div class="col-md-3">
                            <span type="button" class="btn btn-primary btn-sm" name="deals_contract_otp_resend" id="deals_contract_otp_resend">{{ __('Resend OTP') }}</span>
                        </div>
                    </div> --}}
                    {{--  <div class="form-group col-md-6 mb-2">
                        <input type="file" class="form-control" required id="deals_contract_file" name="deals_contract_file" placeholder="file">
                    </div> --}}
                 
                    <div class="form-group row mb-2 blankfield">
                        <div class="col-md-6">
                            <input type="number" class="form-control" required id="deals_contract_otp" name="deals_contract_otp" placeholder="OTP">
                        </div>
                        <div class="col-md-3">
                            <span type="button" class="btn btn-primary btn-sm" name="deals_contract_otp_resend" id="deals_contract_otp_resend">{{ __('Resend OTP') }}</span>
                        </div>
                    </div>
                    <div class="form-check contra_privacy">
                        <input class="form-check-input" type="checkbox" required name="deals_contract_verify" id="deals_contract_verify">
                        {{-- <label class="form-check-label" for="deals_contract_verify">
                            {{ __('Al continuar, reconozco haber leído Bases y Condiciones y Politicas de Privacidad.')}}
                        </label> --}}
                        <p class="text-14-medium">Al continuar, reconozco haber leído <a href="javacript:;">Bases y Condiciones</a> y <a href="javascript:;">Politicas de Privacidad.</a></p>
                    </div>
                    <div class="form-check contra_submit">
                        <button type="submit" class="btn btn-primary">{{ __('Submit')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>