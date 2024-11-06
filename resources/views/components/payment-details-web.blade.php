@props(['banks'])
<div class="protabdetail">
        <div class="protab_outerbox">
            <div class="paydetailbox">
                <div class="titlebox">
                    <h3 class="text-20-semibold">{!! __('Payment Details') !!}</h3>
                    <div class="paymethodbtn">
                        <a href="javascript:;" class="text-16-medium evt_bank_modal_open"
                        data-action="Add"
                        data-user-object=""
                        data-form-name="#addUserBankForm"
                        data-modal-name="#add_new_bank_modal"
                        ><i><img src="{{ asset('images/mipo/payplus.svg') }}" alt="no-image"></i>{!! __('Payment Method') !!}</a>
                    </div>
                </div>
            </div>

            <div id="ajax_bank_details_list">


            </div>
            

            
        </div>
</div>

{{-- no payment found:st --}}
<div class="ope_notfoundWrap payment_not" id="evt_payment_not" style="display: none">
    <div class="imgbox">
        <div class="day"><img src="{{ asset('images/mipo/no_paymentfound_day.svg') }}" alt="no-image"></div>
        <div class="night"><img src="{{ asset('images/mipo/no_paymentfound_night.svg') }}" alt="no-image"></div>
    <strong class="text-20-semibold">{!! __('No Payment Method Available') !!}</strong>
    <p class="text-16-medium">{!! __('Add payment methods to your account') !!}</p>

        <div class="newoprationBtn">
            <a href="javascipt:;" class="text-16-medium evt_bank_modal_open" 
            data-action="Add"
            data-user-object=""
            data-form-name="#addUserBankForm"
            data-modal-name="#add_new_bank_modal"
            ><i><img src="{{ asset('images/mipo/payplus.svg') }}" alt="no-image"></i> {!! __('Add Payment Method') !!}</a>
        </div>
    </div>
</div>


{{-- pay method modal and edit:st --}}
<div class="pay_method_modal">
    <div class="modal fade" id="add_new_bank_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="text-24-medium">{!! __('Add Payment Method') !!}</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('profile.ajax-save-update-bank-detail') }}" method="post" novalidate="novalidate"  name="addUserBankForm" id="addUserBankForm" class="form-validation" enctype="multipart/form-data">
                    @csrf
                        <input type="hidden" name="user_id" id="user_id" value="">
                        <input type="hidden" name="bank_id" id="bank_id" value="">
                        <input type="hidden" name="action" id="action" value="Add">

                    <div class="modal-body">
                        <div class="profile_inputbox">
                        <label for="bene_name" class="text-14-medium">{!! __('Bank Transfer or e-Wallet?') !!}</label>
                            <div class="inradiobox">
                                <label class="radio-inline text-12-medium"><input type="radio" name="preferred_payment_method" value="Bank" class="evt_payment_options">{!! __('Bank Transfer') !!}</label>
                                <label class="radio-inline text-12-medium"><input type="radio" name="preferred_payment_method" value="eWallet" class="evt_payment_options">{!! __('e-Wallet') !!}</label>
                            </div>
                        </div>

                        <div id="bank_details_div" style="display: none">
                            <div class="profile_inputbox">
                                <label for="bank_name" class="text-14-medium">{!! __('Name of Institution') !!}</label>
                                <select class="form-select selectbox text-14-medium init_nice_select" name="bank_name" id="bank_name" data-msg-required="The bank name is required."> 
                                    @foreach($banks as $bank)
                                        <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="profile_inputbox">
                                <label for="bene_name" class="text-14-medium">{!! __('Name of Beneficiary') !!}</label>
                                <input type="text" class="text-14-medium" id="account_name" name="account_name"  data-msg-required="The account name is required.">
                            </div>
                            <div class="profile_inputbox">
                                <label for="account_name" class="text-14-medium">{!! __('Account Number') !!}</label>
                                <input type="text" class="text-14-medium" id="account_number" name="account_number"  data-msg-required="The account name is required.">
                            </div>
                        </div>

                        <div id="ewallet_div" style="display: none">
                            <div class="profile_inputbox">
                                <label for="ph_no" class="text-14-medium">{!! __('Company') !!}</label>
                                <input type="text" class="text-14-medium" id="phone_company" name="phone_company">
                            </div>
                            <div class="profile_inputbox">
                                <label for="ph_no" class="text-14-medium">{!! __('Phone Number') !!}</label>
                                <input type="text" class="text-14-medium" id="phone_number" name="phone_number">
                            </div>
                        </div>
                        
                        <div class="profile_inputbox">
                            <label for="identification_id" class="text-14-medium" id="identification_label_txt">{!! __('Document Number') !!}</label>
                            <input type="text" class="text-14-medium" id="identification_id" name="identification_id">
                        </div>

                        <div class="profile_inputbox">
                            <label for="payment_note" class="text-14-medium">{!! __('Payment Note') !!} / {!! __('Observations') !!}</label>
                            <input type="text" class="text-14-medium" id="payment_note" name="payment_note">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="javascript:;" class="text-16-medium close" data-bs-dismiss="modal">{!! __('Close') !!}</a>
                        <button type="submit" class="text-16-medium">{!! __('Add') !!}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- delete model:st --}}
<div class="delete_modal">
    <div class="modal fade" id="delete_confirm" tabindex="-1" aria-labelledby="delete_confirm" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="text-24-medium">{!! __('Remove Payment Method') !!}</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <p class="text-14-medium ">Are you sure you wish to erase a payment method?</p>
                <div class="modal-footer">
                    <a href="javascript:;" class="text-16-medium close" data-bs-dismiss="modal">{!! __('Cancel') !!}</a>
                    <button class="text-16-medium">{!! __('Delete') !!}</button>
                </div>
            </div>
        </div>
    </div>    
</div>