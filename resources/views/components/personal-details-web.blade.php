@props(['user', 'cities', 'userLevels'])

<div class="pro_tab_detail">
    <div class="row">
        <div class="col-lg-3">
            <div class="profile_lftpart">
                <div class="profile-pic">
                    <div class="profile-img">
                        <div class="input-container">
                            <img src="{{ $user->profile_image_url }}" id="profile_image_url" alt="no-image">
                        </div>

                        <form method="POST"
                            action="{{ route('profile.ajax-file-upload', $user->slug) }}"
                            id="userProfileForm" name="userProfileForm"
                            novalidate="novalidate" enctype="multipart/form-data">
                            @csrf
                            <input type="file" id="profile_image" name="profile_image" class="pic_up evt_file_upload">
                        </form>
                        <i><img src="{{ asset('images/mipo/procam.svg') }}" alt="no-image"></i>

                    </div>
                    <div class="textprobox">
                        <h3 class="text-16-medium">{{ $user->first_name }}</h3>
                        <span class="text-14-medium">{{ $user->account_type }}</span>
                    </div>
                </div>
                <div class="pro_contactbox">
                    <ul>
                        <li class="text-14-medium"><a href="mailto=javascript:;"><i><img  src="{{ asset('images/mipo/promail.svg') }}"  alt="no-image"></i>{{ $user->email }}</a></li>
                        <li class="text-14-medium"><a href="mailto=tel:{{ $user->phone_number }}"><i><img src="{{ asset('images/mipo/pro_call.svg') }}" alt="no-image"></i>{{ $user->phone_number }}</a></li>
                        <li class="text-14-medium"><i><img src="{{ asset('images/mipo/pro_location.svg') }}" alt="no-image"></i>{{ $user->city->name ?? '' }}</li>
                    </ul>
                </div>
                <div class="statusWrapper">
                    <a href="javacript:;" class="statusbox evt_account_status_modal">
                        <div class="lft">
                            <div class="imgbox">
                                <img src="{{ app('common')->userLevelImage($user->user_level) }}" alt="no-image">
                                {{-- <img src="{{ asset('images/mipo/status_gold64.svg') }}" alt="no-image"> --}}
                            </div>
                        </div>
                        <div class="rght">
                            <h3 class="text-24-semibold">{!! __($user->user_level) !!}</h3>
                            <p class="text-16-medium">{!! __('Account Status') !!}</p>
                        </div>
                    </a>
                    <div class="ratingBox">
                        <i><img src="{{ asset('images/mipo/singlestr24.png') }}" alt="no-image"></i>
                        <p class="text-16-medium">{{ round($user->ratings_avg_rating_number, 2) }}/5</p>
                    </div>
                </div>
                <a class="mb_statuswrap evt_account_status_modal">
                    <div class="lft">
                        <i><img src="{{ asset('images/mipo/singlestr48.png') }}" alt="no-image"></i>
                        <p class="text-20-semibold">{{ round($user->ratings_avg_rating_number, 2) }}/5</p>
                    </div>
                    <div class="rght">
                        <i><img src="{{ asset('images/mipo/gold48.png') }}" alt="no-image"></i>
                        <p class="text-20-semibold">{!! __($user->user_level) !!}</p>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="prodata_rightpart">
                @if($user->address_verify == 'No' && !empty($user->address_verify_otp))
                    <div class="attention_wrap warning">
                        <div class="titlebox">
                            <span class="text-16-semibold"><i><img src="{{ asset('images/mipo/red_exclamation24.svg') }}" alt="no-image"></i>{!! __('Incomplete KYC Verification') !!}</span>
                        </div>
                        <div class="attentionbox">
                            <p class="text-16-medium">{!! __(
                                'The verification’s essential to have a verified account. When verifying the KYC address, you’ll be able to unlock functions and additional benefits. If you’re selling documents, buyers will have extra security tool to know it’s a real address.',
                            ) !!}</p>
                            <div class="preofr">
                                <a href="javascript:;" class="text-16-medium evt_open_otp_verify_address_verify_modal" data-bs-toggle="modal"
                                    data-bs-target="#otp_verify_address_verify_modal">{!! __('Request KYC Verification') !!}</a>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="formfield_wrap">
                    <input type="hidden" value="{{ $user->slug }}"
                    id="web_user_login_slug" />
                <form action="{{ route('profile.update', $user->slug) }}"
                    class="form-validatin" method="post" novalidate="novalidate"
                    name="personalDetailsForm" id="personalDetailsForm"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        @if($user->is_user_company == '1')
                        <div class="profile_inputbox nob">
                            <label for="company_name" class="text-14-medium">{!! __('Name of Business') !!}</label>
                            <input type="text" class="text-14-medium" id="company_name" name="first_name"
                               value="{{ $user->issuer->company_name }}" readonly>
                        </div>
                        @endif
                        <div class="col-lg-6">
                            <div class="lft">
                                @if($user->is_user_company == '1')
                                <div class="profile_inputbox">
                                    <label for="commercial_name" class="text-14-medium">{!! __('Commercial Name') !!}</label>
                                    <input type="text" class="text-14-medium" id="commercial_name" name="last_name"
                                    value="{{ $user->issuer->commercial_name }}" readonly>
                                </div>
                                @endif
                                @if($user->is_user_company == '0')
                                <div class="profile_inputbox">
                                    <label for="first_name" class="text-14-medium">{!! __('Name') !!}</label>
                                    <input type="text" class="text-14-medium" id="first_name" name="first_name"
                                    value="{{ $user->first_name }}"  readonly>
                                </div>
                                <div class="profile_inputbox">
                                    <label for="birth_date" class="text-14-medium">{!! __('Date of Birth') !!}</label>
                                    <input type="text" id="birth_date" name="birth_date" class="evt_birth_date" placeholder="DD/MM/YYYY"
                                    value=" {{ ($user->birth_date) ?  \Carbon\Carbon::parse($user->birth_date)->format('d/m/Y') : '' }}"
                                    disabled readonly
                                    >
                                </div>
                                @endif

                                @if($user->is_user_company == '1')
                                    <div class="profile_inputbox">
                                        <div class="idvd_contain">
                                            <div class="id_vdBoxfirst">
                                                <label for="ci"
                                                    class="text-14-medium">{!! __('RUC') !!}*</label>
                                                <input type="text" class="text-14-medium" id="ci"
                                                    name="ci" value="{{ $user->issuer?->ruc_text_id }}" readonly>
                                            </div>
                                            <div class="id_vdsecond">
                                                <label for="dv"  class="text-14-medium">{!! __('D.V') !!}</label>
                                                <input type="text" class="text-14-medium" id="dv" name="dv" value="{{ $user->issuer?->ruc_code_optional }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="profile_inputbox">
                                        <div class="idvd_contain">
                                            <div class="id_vdBoxfirst">
                                                <label for="ci"
                                                    class="text-14-medium">{!! __('C.I') !!}*</label>
                                                <input type="text" class="text-14-medium" id="ci"
                                                    name="ci" value="{{ $user->issuer?->ruc_text_id }}" readonly>
                                            </div>
                                            
                                            <div class="id_vdsecond">
                                                <label for="dv"  class="text-14-medium">{!! __('D.V') !!}</label>
                                                <input type="text" class="text-14-medium" id="dv" name="dv" value="{{ $user->issuer?->ruc_code_optional }}" readonly disabled>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="profile_inputbox">
                                    <label for="phone_number" class="text-14-medium">{!! __('Phone Number') !!}</label>
                                    <input type="text" class="text-14-medium" id="phone_number" name="phone_number" value="{{ $user->phone_number }}" readonly disabled>
                                </div>

                                {{-- <div class="profile_inputbox">
                                    <label for="address" class="text-14-medium">{!! __('Address') !!}</label>
                                    <input type="text" class="text-14-medium" id="address" name="address" value="{{ $user->address }}" readonly disabled>

                                    <div class="notverified">
                                        @if($user->address_verify == 'No')
                                        <div class="errbox">
                                            <i><img src="{{ asset('images/mipo/cross14.svg') }}"alt="no-image"></i><span class="text-12-medium">{!! __('Not Verified') !!}</span>
                                        </div>
                                        @endif
                                        @if($user->address_verify == 'Yes')
                                        <div class="verified">
                                            <i><img  src="{{ asset('images/mipo/greencheck_icon.svg') }}"alt="no-image"></i><span class="text-12-medium">{!! __('Verified') !!}</span>
                                        </div>
                                        @endif
                                    </div>
                                </div> --}}

                                <div class="profile_inputbox">
                                    <label for="city" class="text-14-medium">{!! __('City') !!}</label>
                                    <select class="form-select selectbox text-14-medium init_nice_select" name="city" id="city" readonly disabled>
                                        @foreach ($cities as $city)
                                            <option {{ ($city->id == $user->city_id) ? 'selected' : ''}} value="{{ $city->id }}"> {{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="right">
                                @if($user->is_user_company == '1')
                                    <div class="profile_inputbox">
                                        <label for="doc" class="text-14-medium">{!! __('Date of Constitution') !!}</label>
                                        <input type="text" id="birth_date" placeholder="DD/MM/YYYY" name="birth_date" 
                                         value=" {{ ($user->birth_date) ?  \Carbon\Carbon::parse($user->birth_date)->format('d/m/Y') : '' }}"
                                         class="evt_birth_date"
                                         readonly disabled
                                         >
                                    </div>
                                @endif

                                @if($user->is_user_company == '0')
                                    <div class="profile_inputbox">
                                        <label for="last_name" class="text-14-medium">{!! __('Last Name') !!}</label>
                                        <input type="text" class="text-14-medium" id="last_name" name="last_name" value="{{ $user->last_name }}" readonly>
                                    </div>
                                @endif
                                
                                @if($user->is_user_company == '0')
                                <div class="profile_inputbox select-dd">
                                    <label for="lname" class="text-14-medium">{!! __('Marital Status') !!}</label>
                                    <select class="form-select selectbox text-14-medium init_nice_select"
                                        @error('marital_status') is-invalid @enderror id="marital_status" name="marital_status" readonly disabled>
                                        <option value="">{{ __('N/A') }}</option>
                                        @foreach (config('constants.MARITAL_STATUS') as $marital_status_val)
                                            <option {{ ($user->marital_status == $marital_status_val) ? 'selected' : ''}} value="{{ $marital_status_val }}"> {{ $marital_status_val }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif
                                <div class="profile_inputbox">
                                    <label for="email" class="text-14-medium">{!! __('Email') !!}</label>
                                    <input type="text" class="text-14-medium" id="email" value="{{ $user->email }}" name="email" readonly disabled>
                                </div>

                                {{-- <div class="profile_inputbox">
                                    <div class="imgbox">
                                    </div>
                                </div> --}}
                                <div class="profile_inputbox">
                                    <label for="address" class="text-14-medium">{!! __('Address') !!}</label>
                                    <input type="text" class="text-14-medium" id="address" name="address" value="{{ $user->address }}" readonly disabled>

                                    <div class="notverified">
                                        @if($user->address_verify == 'No')
                                        <div class="req_verify"><a href="javascript:;" class="text-14-medium evt_web_open_chat">{!! __('Request Verification') !!}</a></div>
                                        <div class="errbox">
                                            <i><img src="{{ asset('images/mipo/cross14.svg') }}"alt="no-image"></i><span class="text-12-medium">{!! __('Not Verified') !!}</span>
                                        </div>
                                        @endif
                                        @if($user->address_verify == 'Yes')
                                        <div class="verified">
                                            <i><img  src="{{ asset('images/mipo/greencheck_icon.svg') }}"alt="no-image"></i><span class="text-12-medium">{!! __('Verified') !!}</span>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="relevant_attch">
                            <div class="profile_inputbox uploadfilebox">
                                <label for="relevantDoc" class="text-14-medium">{!! __('Relevant Attachments') !!}</label>
                                {{-- <form> --}}
                                    <label for="user_profile_attache" class="custom-file-upload">
                                        <div class="uploadbox">
                                            <i> <img src="{{ asset('images/mipo/uploaddefault_img.svg') }}"  alt="no-image"></i>
                                            <p class="text-12-medium">{!! __('Upload Files') !!}</p>
                                        </div>
                                    </label>
                                    <input id="user_profile_attache" name='user_profile_attache' type="file"  style="display:none;">
                                {{-- </form> --}}
                            </div>
                            <p class="text-14-medium">{!! __(
                                'Use this attachment fields, to provide MIPO important updates such as last tax returns, additional documents, work certificates, ID renewal and any information you might wish to provide us with.',
                            ) !!}</p>
                        </div>

                        <div class="change_passwordWrap">
                            <div class="titlebox">
                                <h3 class="text-16-medium">{!! __('Change Password') !!}</h3>
                            </div>
                            <div class="paswordbox">
                                <div class="profile_inputbox">
                                    <label for="oldpassword" class="text-14-medium">{!! __('Previous Password') !!}</label>
                                    <input type="password" class="text-14-medium" id="oldpassword" name="oldpassword"
                                        placeholder="••••••••••••••••••" data-msg-required="The old password is required.">
                                </div>
                                <div class="eyebtn">
                                    <i class="icon" id="oldpassicon"></i>
                                </div>
                            </div>
                            <div class="newpass">
                                <div class="profile_inputbox">
                                    <label for="newpassword" class="text-14-medium">{!! __('New Password') !!}
                                        <i><svg xmlns="http://www.w3.org/2000/svg" width="16" height="17"
                                                viewBox="0 0 16 17" fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M15.1996 8.9001C15.1996 10.7036 14.4832 12.4332 13.2079 13.7084C11.9327 14.9837 10.2031 15.7001 8.39961 15.7001C6.59614 15.7001 4.86653 14.9837 3.59128 13.7084C2.31604 12.4332 1.59961 10.7036 1.59961 8.9001C1.59961 7.09663 2.31604 5.36702 3.59128 4.09177C4.86653 2.81652 6.59614 2.1001 8.39961 2.1001C10.2031 2.1001 11.9327 2.81652 13.2079 4.09177C14.4832 5.36702 15.1996 7.09663 15.1996 8.9001ZM6.59961 8.3001C6.59961 8.14097 6.66282 7.98836 6.77535 7.87583C6.88787 7.76331 7.04048 7.7001 7.19961 7.7001H7.40201C7.61173 7.70001 7.8188 7.74704 8.0079 7.83771C8.19701 7.92838 8.36333 8.06038 8.49458 8.22396C8.62583 8.38754 8.71864 8.57852 8.76618 8.78278C8.81371 8.98705 8.81475 9.19938 8.76921 9.4041L8.40121 11.0569C8.39473 11.0862 8.39492 11.1166 8.40177 11.1458C8.40862 11.175 8.42194 11.2022 8.44076 11.2256C8.45959 11.249 8.48342 11.2678 8.5105 11.2807C8.53758 11.2936 8.56721 11.3002 8.59721 11.3001H8.79961C8.95874 11.3001 9.11135 11.3633 9.22387 11.4758C9.3364 11.5884 9.39961 11.741 9.39961 11.9001C9.39961 12.0592 9.3364 12.2118 9.22387 12.3244C9.11135 12.4369 8.95874 12.5001 8.79961 12.5001H8.59721C8.38749 12.5002 8.18042 12.4532 7.99132 12.3625C7.80221 12.2718 7.63589 12.1398 7.50464 11.9762C7.37339 11.8127 7.28057 11.6217 7.23304 11.4174C7.18551 11.2132 7.18447 11.0008 7.23001 10.7961L7.59801 9.1433C7.60449 9.11401 7.6043 9.08364 7.59745 9.05444C7.5906 9.02524 7.57728 8.99795 7.55845 8.9746C7.53963 8.95124 7.5158 8.93242 7.48872 8.91952C7.46164 8.90663 7.432 8.89999 7.40201 8.9001H7.19961C7.04048 8.9001 6.88787 8.83688 6.77535 8.72436C6.66282 8.61184 6.59961 8.45923 6.59961 8.3001ZM7.99961 6.1001C8.21178 6.1001 8.41527 6.01581 8.56529 5.86578C8.71532 5.71575 8.79961 5.51227 8.79961 5.3001C8.79961 5.08792 8.71532 4.88444 8.56529 4.73441C8.41527 4.58438 8.21178 4.5001 7.99961 4.5001C7.78744 4.5001 7.58395 4.58438 7.43392 4.73441C7.2839 4.88444 7.19961 5.08792 7.19961 5.3001C7.19961 5.51227 7.2839 5.71575 7.43392 5.86578C7.58395 6.01581 7.78744 6.1001 7.99961 6.1001Z"
                                                    fill="#C6C6C6" />
                                            </svg></i>
                                    </label>
                                    <input type="password" class="text-14-medium" id="newpassword" name="newpassword"
                                        placeholder="••••••••••••••••••" data-msg-required="The new password is required.">
                                    <div class="eyebtn">
                                        <i class="icon" id="newpassicon"></i>
                                    </div>
                                </div>
                                <div class="profile_inputbox">
                                    <label for="confirmpassword" class="text-14-medium">{!! __('Confirm New Password') !!}
                                        <i><svg xmlns="http://www.w3.org/2000/svg" width="16" height="17"
                                                viewBox="0 0 16 17" fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M15.1996 8.9001C15.1996 10.7036 14.4832 12.4332 13.2079 13.7084C11.9327 14.9837 10.2031 15.7001 8.39961 15.7001C6.59614 15.7001 4.86653 14.9837 3.59128 13.7084C2.31604 12.4332 1.59961 10.7036 1.59961 8.9001C1.59961 7.09663 2.31604 5.36702 3.59128 4.09177C4.86653 2.81652 6.59614 2.1001 8.39961 2.1001C10.2031 2.1001 11.9327 2.81652 13.2079 4.09177C14.4832 5.36702 15.1996 7.09663 15.1996 8.9001ZM6.59961 8.3001C6.59961 8.14097 6.66282 7.98836 6.77535 7.87583C6.88787 7.76331 7.04048 7.7001 7.19961 7.7001H7.40201C7.61173 7.70001 7.8188 7.74704 8.0079 7.83771C8.19701 7.92838 8.36333 8.06038 8.49458 8.22396C8.62583 8.38754 8.71864 8.57852 8.76618 8.78278C8.81371 8.98705 8.81475 9.19938 8.76921 9.4041L8.40121 11.0569C8.39473 11.0862 8.39492 11.1166 8.40177 11.1458C8.40862 11.175 8.42194 11.2022 8.44076 11.2256C8.45959 11.249 8.48342 11.2678 8.5105 11.2807C8.53758 11.2936 8.56721 11.3002 8.59721 11.3001H8.79961C8.95874 11.3001 9.11135 11.3633 9.22387 11.4758C9.3364 11.5884 9.39961 11.741 9.39961 11.9001C9.39961 12.0592 9.3364 12.2118 9.22387 12.3244C9.11135 12.4369 8.95874 12.5001 8.79961 12.5001H8.59721C8.38749 12.5002 8.18042 12.4532 7.99132 12.3625C7.80221 12.2718 7.63589 12.1398 7.50464 11.9762C7.37339 11.8127 7.28057 11.6217 7.23304 11.4174C7.18551 11.2132 7.18447 11.0008 7.23001 10.7961L7.59801 9.1433C7.60449 9.11401 7.6043 9.08364 7.59745 9.05444C7.5906 9.02524 7.57728 8.99795 7.55845 8.9746C7.53963 8.95124 7.5158 8.93242 7.48872 8.91952C7.46164 8.90663 7.432 8.89999 7.40201 8.9001H7.19961C7.04048 8.9001 6.88787 8.83688 6.77535 8.72436C6.66282 8.61184 6.59961 8.45923 6.59961 8.3001ZM7.99961 6.1001C8.21178 6.1001 8.41527 6.01581 8.56529 5.86578C8.71532 5.71575 8.79961 5.51227 8.79961 5.3001C8.79961 5.08792 8.71532 4.88444 8.56529 4.73441C8.41527 4.58438 8.21178 4.5001 7.99961 4.5001C7.78744 4.5001 7.58395 4.58438 7.43392 4.73441C7.2839 4.88444 7.19961 5.08792 7.19961 5.3001C7.19961 5.51227 7.2839 5.71575 7.43392 5.86578C7.58395 6.01581 7.78744 6.1001 7.99961 6.1001Z"
                                                    fill="#C6C6C6" />
                                            </svg></i>
                                    </label>
                                    <input type="password" class="text-14-medium" id="confirmpassword" name="confirmpassword"
                                        placeholder="••••••••••••••••••" data-msg-required="The confirm password required.">
                                        <div class="eyebtn">
                                            <i class="icon" id="confirmpass"></i>
                                        </div>
                                </div>
                            </div>
                        </div>
                        <div class="savebtn">
                            <button type="submit" class="text-16-medium">{{ __('Save') }}</button>
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>

</div>


<!-- Modal -->
<div class="statusbox_modal">
    <div class="modal fade" id="evt_account_status_modal" tabindex="-1" aria-labelledby="test_midal"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close evt_account_status_modal_close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="light"><img src="{{ asset('images/mipo/blk_close.svg') }}" alt="no-image"></span>
                        <span aria-hidden="true" class="dark"><img src="{{ asset('images/mipo/modal_blackclose.svg') }}" alt="no-image"></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="img_txtbox">
                        <div class="imgbox">
                            @if($user->user_level == 'Platinum')
                                <img src="{{ asset('images/mipo/platinum134.svg') }}" alt="no-image">
                            @elseif($user->user_level == 'Gold')
                                <img src="{{ asset('images/mipo/gold134.svg') }}" alt="no-image">
                            @elseif($user->user_level == 'Silver')
                                <img src="{{ asset('images/mipo/silver134.svg') }}" alt="no-image">
                            @elseif($user->user_level == 'Bronze')
                                <img src="{{ asset('images/mipo/bronze134.svg') }}" alt="no-image">
                            @else
                                <img src="{{ asset('images/mipo/noobie134.svg') }}" alt="no-image">
                            @endif
                        </div>
                        <p class="text-20-semibold">{{ __($user->user_level) }}</p>
                    </div>

                    <div class="lavelTable">
                        <table>
                            <thead>
                                <tr class="forbg">
                                    <th class="text-14-medium">{!! __('Status') !!}</th>
                                    <th class="text-14-medium">{!! __('Transactions in QTY') !!}</th>
                                    <th class="text-14-medium">{!! __('Transactions in Value') !!} </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($userLevels as $userLevel)
                                <tr>
                                    <td class="text-12-medium">
                                        <div class="badgebox">
                                            @if($userLevel->name == 'Platinum')
                                                <div class="icon"><img src="{{ asset('images/mipo/platinum42.svg') }}" alt="no-image"></div>
                                            @elseif($userLevel->name == 'Gold')
                                                <div class="icon"><img src="{{ asset('images/mipo/gold42.svg') }}" alt="no-image"></div>
                                            @elseif($userLevel->name == 'Silver')
                                                <div class="icon"><img src="{{ asset('images/mipo/silver42.svg') }}" alt="no-image"></div>
                                            @elseif($userLevel->name == 'Bronze')
                                                <div class="icon"><img src="{{ asset('images/mipo/bronze42.svg') }}" alt="no-image"></div>
                                            @else
                                                <div class="icon"><img src="{{ asset('images/mipo/noobie42.svg') }}" alt="no-image"></div>
                                            @endif
                                            <i><img src="{{ asset('images/mipo/badge_lock.svg') }}" alt="no-image"></i>
                                            <p class="text-14-medium">{!! __($userLevel->name) !!}</p>
                                        </div>
                                    </td>
                                    <td class="text-12-medium">
                                        <span class="text-12-medium ">{{ $userLevel->number_of_deals }}</span>
                                    </td>
                                    <td class="text-12-medium">
                                        <span class="text-12-medium ">{!! __('Less than') !!} {{ $userLevel->amount_of_sales_pyg }}</span>
                                    </td>
                                </tr>
                                @endforeach
                            {{--   <tr>
                                    <td class="text-12-medium">
                                        <div class="badgebox">
                                            <div class="icon"><img src="{{ asset('images/mipo/gold42.svg') }}"
                                                    alt="no-image"></div>
                                            <i><img src="{{ asset('images/mipo/badge_lock.svg') }}"
                                                    alt="no-image"></i>
                                            <p class="text-14-medium">{!! __('Gold') !!}</p>
                                        </div>
                                    </td>
                                    <td class="text-12-medium">
                                        <span class="text-12-medium ">50 to 100</span>
                                    </td>
                                    <td class="text-12-medium">
                                        <span class="text-12-medium ">{!! __('Less than') !!} 500.000.000</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-12-medium">
                                        <div class="badgebox">
                                            <div class="icon"><img src="{{ asset('images/mipo/silver42.svg') }}"
                                                    alt="no-image"></div>
                                            <i><img src="{{ asset('images/mipo/badge_lock.svg') }}"
                                                    alt="no-image"></i>
                                            <p class="text-14-medium">{!! __('Silver') !!}</p>
                                        </div>
                                    </td>
                                    <td class="text-12-medium">
                                        <span class="text-12-medium ">50 to 100</span>
                                    </td>
                                    <td class="text-12-medium">
                                        <span class="text-12-medium ">{!! __('Less than') !!} 500.000.000</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-12-medium">
                                        <div class="badgebox">
                                            <div class="icon"><img src="{{ asset('images/mipo/bronze42.svg') }}"
                                                    alt="no-image"></div>
                                            <i><img src="{{ asset('images/mipo/badge_lock.svg') }}"
                                                    alt="no-image"></i>
                                            <p class="text-14-medium">{!! __('Bronze') !!}</p>
                                        </div>
                                    </td>
                                    <td class="text-12-medium">
                                        <span class="text-12-medium ">50 to 100</span>
                                    </td>
                                    <td class="text-12-medium">
                                        <span class="text-12-medium ">{!! __('Less than') !!} 500.000.000</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-12-medium">
                                        <div class="badgebox">
                                            <div class="icon"><img src="{{ asset('images/mipo/noobie42.svg') }}"
                                                    alt="no-image"></div>
                                            <p class="text-14-medium">{!! __('Noobie') !!}</p>
                                        </div>
                                    </td>
                                    <td class="text-12-medium">
                                        <span class="text-12-medium ">1</span>
                                    </td>
                                    <td class="text-12-medium">
                                        <span class="text-12-medium ">{!! __('Less than') !!} 1</span>
                                    </td>
                                </tr> --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="kyc_verify_modal">
    <div class="modal fade" id="otp_verify_address_verify_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="text-20-medium">{!! __('Address Verification') !!}</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="verified_statusCheck">
                    <p class="text-14-medium">{!! __('Status') !!}:<span> {!! __('Not Verified') !!}</span></p>
                </div>
                <div class="modal-body">
                    <form name="otp_verify_address_form" class="form-validation" id="otp_verify_address_form" method="post"action="{{route('profile.ajax-otp-verify-address')}}" novalidate="novalidate">
                    <div class="otpbox">
                        <p class="text-12-medium">{!! __('We’ve sent the CODE to the legal address registered in our system for the account verification.') !!}</p>
                        <div class="input-row">
                            <div class="input-group pin multibox">
                                <span class="one-colum"><input
                                        class="form-control text-20-medium @if (session('error')) is-invalid @endif"
                                        type="text" name="address_verify_otp[]" inputmode="numeric"
                                        autocomplete="one-time-code" maxlength="1" pattern="\d{1}" required
                                        autofocus></span>
                                <span class="one-colum"><input
                                        class="form-control text-20-medium  @if (session('error')) is-invalid @endif"
                                        type="text" name="address_verify_otp[]" inputmode="numeric"
                                        autocomplete="one-time-code" maxlength="1" pattern="\d{1}" required></span>
                                <span class="one-colum"><input
                                        class="form-control text-20-medium @if (session('error')) is-invalid @endif"
                                        type="text" name="address_verify_otp[]" inputmode="numeric"
                                        autocomplete="one-time-code" maxlength="1" pattern="\d{1}" required></span>
                                <span class="one-colum"><input
                                        class="form-control text-20-medium @if (session('error')) is-invalid @endif"
                                        type="text" name="address_verify_otp[]" inputmode="numeric"
                                        autocomplete="one-time-code" maxlength="1" pattern="\d{1}" required></span>
                                <span class="one-colum"><input
                                        class="form-control text-20-medium @if (session('error')) is-invalid @endif"
                                        type="text" name="address_verify_otp[]" inputmode="numeric"
                                        autocomplete="one-time-code" maxlength="1" pattern="\d{1}" required></span>
                                <span class="one-colum"><input
                                        class="form-control text-20-medium @if (session('error')) is-invalid @endif"
                                        type="text" name="address_verify_otp[]" inputmode="numeric"
                                        autocomplete="one-time-code" maxlength="1" pattern="\d{1}" required></span>
                            </div>
                            @if (session('error'))
                                <div class="invalid-feedback d-block text-center">
                                    {{ session('error') }}
                                </div>
                            @endif
                        </div>
                        <div class="submitbtn">
                            <button type="submit" value="{!! __('Submit') !!}" class="text-18-medium">Submit</button>
                            {{-- <input type="submit" class="text-18-medium" value="{!! __('Submit') !!}"/> --}}
                        </div>
                        <div class="resend_code text-12-medium">
                            <p>{!! __('Didn’t receive the code?') !!}</p>
                            <a href="javacript:;"> {!! __('Resend Code') !!}</a>
                        </div>
                    </div>
                </form>
                </div>

            </div>
        </div>
    </div>
</div>


{{-- mobile same modal status --}}
