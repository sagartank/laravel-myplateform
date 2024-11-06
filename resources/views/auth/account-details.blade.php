<x-guest-layout>
    @section('custom_style')
    <style>
        .is-invalid{
            color: #842029 !important
        }
    </style>
    @endsection

    <div class="account_main">
        <div class="page-logo">
            <a href="/"><img src="{{ asset('images/logo.svg') }}" alt="" /></a>
        </div>
        <div class="account_wrap">
            <div class="sec_title">
                <h3>{{ __('Account Selection') }}</h3>
            </div>
            @include('components.message')
            <form action="{{ route('details.account') }}" method="POST">
                @csrf
                <div class="form_wrap">
                    <div class="left_block">
                        <div class="radio_tabs">
                            <h6>{{ __('What type of account you want to open?') }}</h6>
                            <div class="btn-wrap">
                                <label class="btn active" for="btnradio1">
                                    <input type="radio" class="btn-check" name="account_type" value="individual"
                                        id="btnradio1" autocomplete="off" checked required>
                                    <span>{{ __('Individual') }}</span>
                                    <i><svg width="32" height="40" viewBox="0 0 32 40" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M22.8751 9C22.8751 10.8234 22.1508 12.572 20.8615 13.8614C19.5722 15.1507 17.8235 15.875 16.0001 15.875C14.1768 15.875 12.4281 15.1507 11.1388 13.8614C9.84945 12.572 9.12512 10.8234 9.12512 9C9.12512 7.17664 9.84945 5.42795 11.1388 4.13864C12.4281 2.84933 14.1768 2.125 16.0001 2.125C17.8235 2.125 19.5722 2.84933 20.8615 4.13864C22.1508 5.42795 22.8751 7.17664 22.8751 9V9ZM2.25195 34.883C2.31087 31.2756 3.78524 27.836 6.35711 25.3057C8.92898 22.7755 12.3923 21.3575 16.0001 21.3575C19.608 21.3575 23.0713 22.7755 25.6431 25.3057C28.215 27.836 29.6894 31.2756 29.7483 34.883C25.4352 36.8607 20.7451 37.8814 16.0001 37.875C11.0941 37.875 6.43745 36.8043 2.25195 34.883Z"
                                                stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg></i>
                                </label>
                                @if ($user && (is_null($user->enterprise_id) || $user->enterprise_id == 0))
                                    <label class="btn" for="btnradio2">
                                        <input type="radio" class="btn-check" name="account_type" value="enterprise"
                                            id="btnradio2" autocomplete="off" required>
                                        <span>{{ __('Enterprise') }}</span>
                                        <i><svg width="40" height="36" viewBox="0 0 40 36" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M2.125 34.5H37.875M4.875 1.5V34.5M24.125 1.5V34.5M35.125 9.75V34.5M10.375 8.375H11.75M10.375 13.875H11.75M10.375 19.375H11.75M17.25 8.375H18.625M17.25 13.875H18.625M17.25 19.375H18.625M10.375 34.5V28.3125C10.375 27.174 11.299 26.25 12.4375 26.25H16.5625C17.701 26.25 18.625 27.174 18.625 28.3125V34.5M3.5 1.5H25.5M24.125 9.75H36.5M29.625 16.625H29.6397V16.6397H29.625V16.625ZM29.625 22.125H29.6397V22.1397H29.625V22.125ZM29.625 27.625H29.6397V27.6397H29.625V27.625Z"
                                                    stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg></i>
                                    </label>
                                @endif
                            </div>
                        </div>
                        <div class="content_main">
                            <div class="tab_content active">
                                <div class="ind_block">
                                    @if(App()->isLocale('en'))
                                        {!! app('common')->getSettingsVal()->account_selection_en !!}
                                    @else
                                        {!! app('common')->getSettingsVal()->account_selection_es!!}
                                    @endif
                                </div>
                            </div>
                            <div class="tab_content">
                                <div class="enter_block">
                                    <div class="box_row">
                                        <h6>{{ __('How many users will use the platform?') }}</h6>
                                        <div class="opt_wrap">
                                            <div class="btn-wrap">
                                                <label class="btn" for="users1">
                                                    <input type="radio" class="btn-check" name="ent_no_of_users"
                                                        id="users1" value="1">1
                                                </label>
                                                <label class="btn" for="users2">
                                                    <input type="radio" class="btn-check" name="ent_no_of_users"
                                                        id="users2" value="3">3
                                                </label>
                                                <label class="btn" for="users3">
                                                    <input type="radio" class="btn-check" name="ent_no_of_users"
                                                        id="users3" value="5">5
                                                </label>
                                                <label class="btn" for="users4">
                                                    <input type="radio" class="btn-check" name="ent_no_of_users"
                                                        id="users4" value="10">10
                                                </label>
                                            </div>
                                            <div class="more"><a href="#">{{ __('more') }}</a></div>
                                        </div>
                                    </div>
                                    <!-- row end-->
                                    <div class="box_row">
                                        <h6>{{ __('How many operation deals you’re thinking todo on the platform per day?') }}
                                        </h6>
                                        <div class="opt_wrap">
                                            <div class="btn-wrap">
                                                <label class="btn" for="optradio1">
                                                    <input type="radio" class="btn-check"
                                                        name="ent_no_of_deals_per_day" id="optradio1" value="1">1
                                                </label>
                                                <label class="btn" for="optradio2">
                                                    <input type="radio" class="btn-check"
                                                        name="ent_no_of_deals_per_day" id="optradio2" value="3">3
                                                </label>
                                                <label class="btn" for="optradio3">
                                                    <input type="radio" class="btn-check"
                                                        name="ent_no_of_deals_per_day" id="optradio3"
                                                        value="5">5
                                                </label>
                                                <label class="btn" for="optradio4">
                                                    <input type="radio" class="btn-check"
                                                        name="ent_no_of_deals_per_day" id="optradio4"
                                                        value="10">10
                                                </label>
                                            </div>
                                            <div class="more"><a href="#">{{ __('more') }}</a></div>
                                        </div>
                                    </div>
                                    <!-- row end-->
                                    <div class="box_row">
                                        <h6>{{ __('Enter your business type') }}</h6>
                                        <input type="text" name="ent_business_type" id="ent_business_type"
                                            class="form-control @error('ent_business_type') is-invalid @enderror">
                                    </div>
                                    <!-- row end-->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="right_block">
                        <div class="box_row">
                            <h6>{{ __('Why are you opening the account?') }}</h6>
                            <div class="check-btn-wrap">
                                <label class="btn" for="account1">
                                    <input type="checkbox" class="btn-check" id="account1"
                                        name="account_roles[as_borrower]">
                                    <span>{{ __('As Borrower') }}</span>
                                    <i><svg width="44" height="44" viewBox="0 0 44 44" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <g clip-path="url(#clip0_164_37)">
                                                <path
                                                    d="M25.6665 5.5V12.8333C25.6665 13.3196 25.8597 13.7859 26.2035 14.1297C26.5473 14.4735 27.0136 14.6667 27.4998 14.6667H34.8332"
                                                    stroke-width="3" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <path
                                                    d="M9.1665 14.6667V9.16667C9.1665 8.19421 9.55281 7.26158 10.2404 6.57394C10.9281 5.88631 11.8607 5.5 12.8332 5.5H25.6665L34.8332 14.6667V34.8333C34.8332 35.8058 34.4469 36.7384 33.7592 37.4261C33.0716 38.1137 32.139 38.5 31.1665 38.5H21.9998"
                                                    stroke-width="3" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <path
                                                    d="M11 31.1665C14.0376 31.1665 16.5 28.7041 16.5 25.6665C16.5 22.6289 14.0376 20.1665 11 20.1665C7.96243 20.1665 5.5 22.6289 5.5 25.6665C5.5 28.7041 7.96243 31.1665 11 31.1665Z"
                                                    stroke="black" stroke-width="3" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <path
                                                    d="M8.25 31.1665L5.5 40.3332L11 37.5832L16.5 40.3332L13.75 31.1665"
                                                    stroke-width="3" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                            </g>
                                            <defs>
                                                <clipPath id="clip0_164_37">
                                                    <rect width="44" height="44" fill="white" />
                                                </clipPath>
                                            </defs>
                                        </svg></i>
                                </label>
                                <label class="btn" for="account2">
                                    <input type="checkbox" class="btn-check" id="account2"
                                        name="account_roles[as_investor]">
                                    <span>{{ __('As Investor') }}</span>
                                    <i><svg width="44" height="44" viewBox="0 0 44 44" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <g clip-path="url(#clip0_164_46)">
                                                <path
                                                    d="M29.3332 16.5C34.3958 16.5 38.4998 14.0376 38.4998 11C38.4998 7.96243 34.3958 5.5 29.3332 5.5C24.2706 5.5 20.1665 7.96243 20.1665 11C20.1665 14.0376 24.2706 16.5 29.3332 16.5Z"
                                                    stroke-width="3" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <path
                                                    d="M20.1665 11V18.3333C20.1665 21.3712 24.2713 23.8333 29.3332 23.8333C34.395 23.8333 38.4998 21.3712 38.4998 18.3333V11"
                                                    stroke-width="3" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <path
                                                    d="M20.1665 18.3335V25.6668C20.1665 28.7047 24.2713 31.1668 29.3332 31.1668C34.395 31.1668 38.4998 28.7047 38.4998 25.6668V18.3335"
                                                    stroke-width="3" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <path
                                                    d="M20.1665 25.6665V32.9998C20.1665 36.0377 24.2713 38.4998 29.3332 38.4998C34.395 38.4998 38.4998 36.0377 38.4998 32.9998V25.6665"
                                                    stroke-width="3" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <path
                                                    d="M12.8333 16.5H8.25C7.52065 16.5 6.82118 16.7897 6.30546 17.3055C5.78973 17.8212 5.5 18.5207 5.5 19.25C5.5 19.9793 5.78973 20.6788 6.30546 21.1945C6.82118 21.7103 7.52065 22 8.25 22H10.0833C10.8127 22 11.5122 22.2897 12.0279 22.8055C12.5436 23.3212 12.8333 24.0207 12.8333 24.75C12.8333 25.4793 12.5436 26.1788 12.0279 26.6945C11.5122 27.2103 10.8127 27.5 10.0833 27.5H5.5"
                                                    stroke-width="3" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <path d="M9.1665 27.4998V29.3332M9.1665 14.6665V16.4998"
                                                    stroke-width="3" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                            </g>
                                            <defs>
                                                <clipPath id="clip0_164_46">
                                                    <rect width="44" height="44" fill="white" />
                                                </clipPath>
                                            </defs>
                                        </svg></i>
                                </label>
                            </div>
                        </div>
                        <!-- row end-->
                        <div class="box_row">
                            <h6>{{ __('What’s your occupation?') }}</h6>
                            <input type="text" id="occupation" name="occupation"
                                class="form-control @error('occupation') is-invalid @enderror"
                                value="{{ old('occupation') }}">
                        </div>
                        <!-- row end-->
                        <div class="box_row">
                            <h6>{{ __('Write something about yourself?') }}</h6>
                            <textarea id="bio" name="bio" class="form-control @error('bio') is-invalid @enderror">{{ old('bio') }}</textarea>
                        </div>
                        <!-- row end-->
                        <div class="box_row">
                            <h6 class="@error('preferred_payment_method') is-invalid @enderror">{{ __('What’ll be your preferred way to deal/transaction in the platform?') }}</h6>
                            <div class="pay_opt">
                                <label class="label" for="payopt1">
                                    <input class="form-check-input evt_payment_options" type="radio"
                                        name="preferred_payment_method" value="Bank" id="payopt1">
                                    <span>{{ __('Bank Transaction') }}</span>
                                </label>
                            <label class="label" for="payopt2">
                                    <input class="form-check-input evt_payment_options" type="radio"
                                        name="preferred_payment_method" value="Cash" id="payopt2">
                                    <span>{{ __('Cash') }}</span>
                                </label>
                                <label class="label" for="payopt3">
                                    <input class="form-check-input evt_payment_options" type="radio"
                                        name="preferred_payment_method" value="eWallet" id="payopt3">
                                    <span>{{ __('eWallet') }}</span>
                                </label>
                            <label class="label" for="payopt4">
                                    <input class="form-check-input evt_payment_options" type="radio"
                                        name="preferred_payment_method" value="Other" id="payopt4">
                                    <span>{{ __('Other') }}</span>
                                </label>
                                @error('preferred_payment_method')
                                    <x-error-alert :message="$message" />
                                @enderror
                            </div>
                        </div>
                        <div class="box_row" data-info="bank-details">
                            <fieldset id="bank_details_div" style="display: none">
                                <legend>{{ __('Bank Details') }}</legend>
                                <div class="box_row">
                                    <h6>{{ __('Bank Name') }}</h6>
                                    <select name="bank_name" class="form-select form-control" id="bank_name" data-msg-required="The bank name is required.">
                                            @foreach($banks as $bank)
                                            <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                                            @endforeach
                                    </select>
                                </div>
                                <div class="box_row">
                                    <h6>{{ __('Account Name') }}</h6>
                                    <input type="text" id="account_name" name="account_name"
                                        class="form-control @error('bank_name') is-invalid @enderror"
                                        value="{{ old('account_name') }}">
                                </div>
                                <div class="box_row">
                                    <h6>{{ __('Account Number') }}</h6>
                                    <input type="text" id="account_number" name="account_number"
                                        class="form-control @error('bank_name') is-invalid @enderror"
                                        value="{{ old('account_number') }}">
                                </div>
                            </fieldset>
                            <fieldset id="ewallet_div" style="display: none">
                                <legend>{{ __('eWallet') }}</legend>
                                <div class="box_row">
                                    <h6>{{ __('Phone Company') }}</h6>
                                    <input type="text" id="phone_company" name="phone_company"
                                        class="form-control @error('phone_company') is-invalid @enderror"
                                        value="{{ old('phone_company') }}">
                                </div>
                                <div class="box_row">
                                    <h6>{{ __('Phone Number') }}</h6>
                                    <input type="text" id="phone_number" name="phone_number"
                                        class="form-control @error('bank_name') is-invalid @enderror"
                                        value="{{ old('phone_number') }}">
                                </div>
                            </fieldset>
                            <div class="box_row" id="bank_ewallet_div" style="display: none">
                                <h6>{{ __('Identification Id') }}</h6>
                                <input type="text" id="identification_id" name="identification_id"
                                    class="form-control @error('identification_id') is-invalid @enderror"
                                    value="{{ old('identification_id') }}">
                            </div>
                            <div class="box_row">
                                <h6>{{ __('Payment Note')}}</h6>
                                <textarea id="payment_note" name="payment_note" class="form-control @error('payment_note') is-invalid @enderror">{{ old('payment_note') }}</textarea>
                            </div>
                        </div>

                        <div class="box_row">
                            <h6>{{ __('What’s your preferred currency?') }}</h6>
                            <select name="preferred_currency" id="preferred_currency" data-type="preferred_currency"
                                class="form-select form-control @error('preferred_currency') is-invalid @enderror">
                                @if (count(config('constants.CURRENCY_TYPE')))
                                    @foreach (config('constants.CURRENCY_TYPE') as $currencyType)
                                        <option {{ old('preferred_currency') == $currencyType ? 'selected' : '' }}
                                            value="{{ $currencyType }}">{{ $currencyType }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <!-- row end-->
                        <div class="box_row">
                            <h6>{{ __('What’s your estimated budget?') }}</h6>
                            <input id="estimated_budget" name="estimated_budget" type="text"
                                class="evt_validate_decimal form-control @error('estimated_budget') is-invalid @enderror"
                                value="{{ old('estimated_budget') }}">
                        </div>
                        <!-- row end-->
                        <div class="btnbox">
                            <input class="btn btn-secondary" type="submit" value="{{ __('Submit') }}">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @section('custom_script')
        <script>
            $(document).ready(function() {
                var bank_div =  $('#bank_details_div');
                var ewallet_div =  $('#ewallet_div');
                var bank_ewallet_div = $('#bank_ewallet_div');
                $('.evt_payment_options').change(function (e) { 
                    e.preventDefault();
                    ewallet_div.hide();
                    bank_div.hide();
                    bank_ewallet_div.hide();
                    var payment_val = $(this).val();
                    if(payment_val!='') {
                        if(payment_val == 'Bank') {
                            bank_div.show();
                            bank_ewallet_div.show();
                        } else if(payment_val == 'eWallet') {
                            ewallet_div.show();
                            bank_ewallet_div.show();
                        }
                    }
                });
            })
        </script>
    @endsection
</x-guest-layout>
