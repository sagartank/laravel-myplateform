<x-app-layout>
    @section('custom_style')
        <link href="{{ asset('plugins/select2-4.1.0-rc.0/dist/css/select2.min.css') }}" rel="stylesheet">
    @endsection

    <div class="profile_page">

        <div class="profile_sec">

            <div class="container">

                <div class="profile_inner">

                    <div class="profile_title">

                        <h2>{{ __('Profile') }}</h2>

                    </div>

                    <div class="profile_main_sec">

                        <ul class="nav nav-tabs" id="myTabProfile" role="tablist">

                            <li class="nav-item" role="presentation">

                                <a href="javascript:void(0)" class="nav-link active" id="personal_details-tab"
                                    data-bs-toggle="tab" data-bs-target="#personal_details-tab-pane" type="button"
                                    role="tab" aria-controls="personal_details-tab-pane"
                                    aria-selected="true">{{ __('Personal Details') }}</a>

                            </li>

                            <li class="nav-item" role="presentation">

                                <a href="javascript:void(0)" class="nav-link" id="credits-tab" data-bs-toggle="tab"
                                    data-bs-target="#credits-tab-pane" type="button" role="tab"
                                    aria-controls="credits-tab-pane" aria-selected="false">{{ __('Credits') }}</a>

                            </li>
                            @if ($user->account_type == $account_type[1] && $user->account_type != '')
                                <li class="nav-item" role="presentation">
                                    <a href="javascript:void(0)" class="nav-link" id="manage_user-tab"
                                        data-bs-toggle="tab" data-bs-target="#manage_user-tab-pane" type="button"
                                        role="tab" aria-controls="manage_user-tab-pane" aria-selected="false">
                                        {{ __('Manage
                                                                                                                                                                                                                                                                                        										User') }}</a>
                                </li>
                            @endif

                            <li class="nav-item" role="presentation">

                                <a href="javascript:void(0)" class="nav-link" id="settings-tab" data-bs-toggle="tab"
                                    data-bs-target="#settings-tab-pane" type="button" role="tab"
                                    aria-controls="settings-tab-pane" aria-selected="false">Settings</a>

                            </li>

                            <li class="nav-item" role="presentation">

                                <a href="javascript:void(0)" class="nav-link" id="favorites-tab" data-bs-toggle="tab"
                                    data-bs-target="#favorites-tab-pane" type="button" role="tab"
                                    aria-controls="favorites-tab-pane" aria-selected="false">Favorites</a>

                            </li>
                            <li class="nav-item" role="presentation">

                                <a href="javascript:void(0)" class="nav-link" id="plan-tab" data-bs-toggle="tab"
                                    data-bs-target="#plan-tab-pane" type="button" role="tab"
                                    aria-controls="plan-tab-pane" aria-selected="false">Plan</a>

                            </li>

                        </ul>

                        <div class="tab-content" id="myTabContentProfile">

                            <div class="tab-pane fade show active" id="personal_details-tab-pane" role="tabpanel"
                                aria-labelledby="personal_details-tab" tabindex="0">

                                <div class="profile_detail_tab_content">

                                    <div class="personal_profile_detail_main">

                                        <div class="profile_left">
                                            <div class="profile_img_blk">
                                                <div class="profile_img_main">
                                                    @if ($user->profile_image_url != '')
                                                        <img src="{{ $user->profile_image_url }}" alt="image"
                                                            id="profile_image_url">
                                                    @endif
                                                    <span class="file_box">

                                                        <form method="POST"
                                                            action="{{ route('profile.ajax-file-upload', $user->slug) }}"
                                                            id="userProfileForm" name="userProfileForm"
                                                            novalidate="novalidate" enctype="multipart/form-data">
                                                            @csrf
                                                            <input type="file" id="profile_image"
                                                                class="evt_file_upload" name="profile_image"
                                                                data-msg-accept="Please upload valid image."
                                                                data-msg-required="Please upload valid file.">
                                                        </form>

                                                        <svg width="16" height="16" viewBox="0 0 16 16"
                                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M11.6465 2.36544L13.625 4.34394M12.5 9.50019V13.0627C12.5 13.5102 12.3222 13.9395 12.0057 14.2559C11.6893 14.5724 11.2601 14.7502 10.8125 14.7502H2.9375C2.48995 14.7502 2.06072 14.5724 1.74426 14.2559C1.42779 13.9395 1.25 13.5102 1.25 13.0627V5.18769C1.25 4.74013 1.42779 4.31091 1.74426 3.99444C2.06072 3.67798 2.48995 3.50019 2.9375 3.50019H6.5M11.6465 2.36544L12.9117 1.09944C13.1755 0.835678 13.5332 0.6875 13.9062 0.6875C14.2793 0.6875 14.637 0.835678 14.9008 1.09944C15.1645 1.36319 15.3127 1.72093 15.3127 2.09394C15.3127 2.46695 15.1645 2.82468 14.9008 3.08844L6.9365 11.0527C6.53999 11.449 6.05102 11.7402 5.51375 11.9002L3.5 12.5002L4.1 10.4864C4.25996 9.94916 4.55123 9.46019 4.9475 9.06369L11.6465 2.36544V2.36544Z"
                                                                stroke="#FFD707" stroke-linecap="round"
                                                                stroke-linejoin="round"></path>
                                                        </svg>
                                                    </span>
                                                </div>
                                                <i>
                                                    <svg width="11" height="14" viewBox="0 0 11 14"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M2.49941 3C2.49941 2.20435 2.81548 1.44129 3.37809 0.87868C3.9407 0.31607 4.70376 0 5.49941 0C6.29506 0 7.05812 0.31607 7.62073 0.87868C8.18334 1.44129 8.49941 2.20435 8.49941 3C8.49941 3.79565 8.18334 4.55871 7.62073 5.12132C7.05812 5.68393 6.29506 6 5.49941 6C4.70376 6 3.9407 5.68393 3.37809 5.12132C2.81548 4.55871 2.49941 3.79565 2.49941 3ZM7.96023e-05 12.4033C0.0225598 10.9596 0.61184 9.5827 1.64072 8.56972C2.6696 7.55674 4.05555 6.98897 5.49941 6.98897C6.94327 6.98897 8.32923 7.55674 9.35811 8.56972C10.387 9.5827 10.9763 10.9596 10.9987 12.4033C11.0005 12.5005 10.9738 12.5961 10.9221 12.6784C10.8704 12.7607 10.7958 12.8261 10.7074 12.8667C9.07352 13.6158 7.29685 14.0024 5.49941 14C3.64208 14 1.87741 13.5947 0.291413 12.8667C0.20307 12.8261 0.128463 12.7607 0.076721 12.6784C0.0249789 12.5961 -0.00165456 12.5005 7.96023e-05 12.4033Z"
                                                            fill="#FFD707"></path>
                                                    </svg>
                                                </i>
                                            </div>

                                            {{-- old <div class="profile_img_blk">
													<div class="profile_img_main">
														@if ($user->profile_image_url != '')
															<img src="{{$user->profile_image_url}}" alt="image" id="profile_image_url" data-fancybox>
														@endif
													</div>
													<i>

														<svg width="11" height="14" viewBox="0 0 11 14" fill="none"

															xmlns="http://www.w3.org/2000/svg">

															<path fill-rule="evenodd" clip-rule="evenodd"

																d="M2.49941 3C2.49941 2.20435 2.81548 1.44129 3.37809 0.87868C3.9407 0.31607 4.70376 0 5.49941 0C6.29506 0 7.05812 0.31607 7.62073 0.87868C8.18334 1.44129 8.49941 2.20435 8.49941 3C8.49941 3.79565 8.18334 4.55871 7.62073 5.12132C7.05812 5.68393 6.29506 6 5.49941 6C4.70376 6 3.9407 5.68393 3.37809 5.12132C2.81548 4.55871 2.49941 3.79565 2.49941 3ZM7.96023e-05 12.4033C0.0225598 10.9596 0.61184 9.5827 1.64072 8.56972C2.6696 7.55674 4.05555 6.98897 5.49941 6.98897C6.94327 6.98897 8.32923 7.55674 9.35811 8.56972C10.387 9.5827 10.9763 10.9596 10.9987 12.4033C11.0005 12.5005 10.9738 12.5961 10.9221 12.6784C10.8704 12.7607 10.7958 12.8261 10.7074 12.8667C9.07352 13.6158 7.29685 14.0024 5.49941 14C3.64208 14 1.87741 13.5947 0.291413 12.8667C0.20307 12.8261 0.128463 12.7607 0.076721 12.6784C0.0249789 12.5961 -0.00165456 12.5005 7.96023e-05 12.4033Z"

																fill="#FFD707" />

														</svg>

													</i>

												</div> --}}

                                            <div class="profile_rating">
                                                <span>{{ __('Rating') }}</span>
                                                <ul class="rating_blk">
                                                    <li><img src="{{ app('common')->userRatingImage($user->ratings_avg_rating_number) }}"
                                                            title="user rating" alt="user rating"></li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="profile_center_part">

                                            <div class="title_edit_profile">ABOUT ME</div>

                                            <div class="edit_profile_form">
                                                <input type="hidden" value="{{ $user->slug }}"
                                                    id="web_user_login_slug" />
                                                <form action="{{ route('profile.update', $user->slug) }}"
                                                    class="form-validatin" method="post" novalidate="novalidate"
                                                    name="personalDetailsForm" id="personalDetailsForm"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="edit_profile_row">
                                                        {{-- <div class="edit_profile_col">
																<div class="file_upload_wp">
																	<label for="">{{ __('Profile picture') }}</label>
																	<div class="uploadFile">
																		<i class="">
																			<svg width="18" height="14"
																				viewBox="0 0 18 14" fill="none"
																				xmlns="http://www.w3.org/2000/svg">
																				<path
																					d="M1.6875 9.8125L5.55675 5.94325C5.71345 5.78655 5.89948 5.66225 6.10422 5.57744C6.30896 5.49263 6.52839 5.44899 6.75 5.44899C6.97161 5.44899 7.19104 5.49263 7.39578 5.57744C7.60052 5.66225 7.78655 5.78655 7.94325 5.94325L11.8125 9.8125M10.6875 8.6875L11.7443 7.63075C11.9009 7.47405 12.087 7.34975 12.2917 7.26494C12.4965 7.18013 12.7159 7.13649 12.9375 7.13649C13.1591 7.13649 13.3785 7.18013 13.5833 7.26494C13.788 7.34975 13.9741 7.47405 14.1307 7.63075L16.3125 9.8125M2.8125 12.625H15.1875C15.4859 12.625 15.772 12.5065 15.983 12.2955C16.194 12.0845 16.3125 11.7984 16.3125 11.5V2.5C16.3125 2.20163 16.194 1.91548 15.983 1.7045C15.772 1.49353 15.4859 1.375 15.1875 1.375H2.8125C2.51413 1.375 2.22798 1.49353 2.017 1.7045C1.80603 1.91548 1.6875 2.20163 1.6875 2.5V11.5C1.6875 11.7984 1.80603 12.0845 2.017 12.2955C2.22798 12.5065 2.51413 12.625 2.8125 12.625ZM10.6875 4.1875H10.6935V4.1935H10.6875V4.1875ZM10.9688 4.1875C10.9688 4.26209 10.9391 4.33363 10.8864 4.38637C10.8336 4.43912 10.7621 4.46875 10.6875 4.46875C10.6129 4.46875 10.5414 4.43912 10.4886 4.38637C10.4359 4.33363 10.4062 4.26209 10.4062 4.1875C10.4062 4.11291 10.4359 4.04137 10.4886 3.98863C10.5414 3.93588 10.6129 3.90625 10.6875 3.90625C10.7621 3.90625 10.8336 3.93588 10.8864 3.98863C10.9391 4.04137 10.9688 4.11291 10.9688 4.1875V4.1875Z"
																					stroke="#ADADAD" stroke-width="1.5"
																					stroke-linecap="round"
																					stroke-linejoin="round" />
																			</svg>
																		</i>
																		<span class="filename">{{ __('Attachment') }}</span>
																		<input type="file" class="inputfile form-control validImage" data-msg-accept="Please upload valid image." data-msg-required="Please upload valid file." id="profile_image" name="profile_image" name="file">
																	</div>
																</div>
															</div> --}}
                                                        <div class="edit_profile_col edit_profile_colhalf">
                                                            <label for="first_name">{{ __('Firstname') }}</label>
                                                            <input type="text" value="{{ $user->first_name }}"
                                                                name="first_name" readonly minlength="3"
                                                                data-msg-required="The first name is required."
                                                                id="first_name" class="edit_input">
                                                        </div>
                                                        <div class="edit_profile_col edit_profile_colhalf">
                                                            <label for="last_name">{{ __('Lastname') }}</label>
                                                            <input type="text" value="{{ $user->last_name }}"
                                                                readonly name="last_name" minlength="3"
                                                                data-msg-required="The last name is required."
                                                                id="last_name" class="edit_input">
                                                        </div>
                                                        <div class="edit_profile_col edit_profile_colhalf">
                                                            <label for="birth_date">{{ __('Date of Birth') }}</label>
                                                            <input type="date" name="birth_date"
                                                                value="{{ $user->birth_date }}" readonly
                                                                data-msg-required="The date of birth is required."
                                                                id="birth_date" class="edit_input">
                                                        </div>
                                                        <div class="edit_profile_col edit_profile_colhalf">
                                                            <label for="gender">{{ __('Gender') }}</label>
                                                            <input type="text" name="gender"
                                                                value="{{ $user->gender }}" readonly
                                                                id="gender" class="edit_input">
                                                            {{-- <select readonly name="gender" id="gender"
                                                                class="selectbox"
                                                                data-msg-required="The gender is required.">
                                                                <option {{ $user->gender == 'Male' ? 'selected' : '' }}
                                                                    value="Male">Male</option>
                                                                <option
                                                                    {{ $user->gender == 'Female' ? 'selected' : '' }}value="Female">
                                                                    Female</option>
                                                                <option
                                                                    {{ $user->gender == 'Other' ? 'selected' : '' }}
                                                                    value="Other">Other</option>
                                                            </select> --}}
                                                        </div>
                                                        <div class="edit_profile_col edit_profile_colhalf">
                                                            <label for="birth_date">{{ __('Country') }}</label>
                                                            <input type="text" name="country_id"
                                                                value="{{ $user->country?->name }}" readonly
                                                                id="country_id" class="edit_input">
                                                        </div>
                                                        {{-- <div class="edit_profile_col edit_profile_colhalf">
                                                            <label for="country_id">{{ __('Country') }}</label>
                                                            <select name="country_id" id="country_id"
                                                                class="selectbox" minlength="1" readonly
                                                                data-msg-required="The country is required.">
                                                                <option value="">{{ __('Select Country') }}
                                                                </option>
                                                                @if ($countries->count() > 0)
                                                                    @foreach ($countries as $val)
                                                                        <option
                                                                            {{ $user->country_id == $val->id ? 'selected' : '' }}
                                                                            value="{{ $val->id }}">
                                                                            {{ $val->name }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div> --}}
                                                        <div class="edit_profile_col edit_profile_colhalf">
                                                            <label for="state"> {{ __('State') }}</label>
                                                            <input type="text" name="state"
                                                                value="{{ $user->state }}" minlength="2" readonly
                                                                data-msg-required="The state is required."
                                                                id="state" class="edit_input">
                                                        </div>
                                                        {{-- <div class="edit_profile_col edit_profile_colhalf">
																<label for="state">State</label>
																<select name="state" id="state" class="selectbox">
																	<option value="Gujrat">Gujrat</option>
																	<option value="Punjab">Punjab</option>
																	<option value="Maharastra">Maharastra</option>
																</select>
															</div> --}}
                                                        <div class="edit_profile_col edit_profile_colhalf">
                                                            <label for="address">{{ __('Address') }}
                                                                <span id="link_addree_class" class="text-white badge text-bg-{{ ($user->address_verify == 'Yes') ? 'success' : 'primary' }}">
                                                                    @if($user->address_verify == 'Yes')
                                                                        {{ __('Verified')}}
                                                                    @elseif(!empty($user->address_verify_otp) && $user->address_verify == 'No')
                                                                        <a href="javascript:;" id="otp_verify_anchor_tag" class="evt_open_otp_verify_address_verify_modal"> {{ __('OTP Verfiy Address ')}}</a>
                                                                    @else
                                                                        {{ __('No Verified')}}
                                                                    @endif
                                                                </span>
                                                            </label>
                                                            <textarea name="address" id="address" minlength="2" readonly data-msg-required="The address is required."
                                                                class="edit_input">{{ $user->address }}</textarea>
                                                        </div>

                                                        <div class="edit_profile_col edit_profile_colhalf">
                                                            <div class="edit_profile_row">
                                                                <div class="edit_profile_col">
                                                                    <label for="city">{{ __('City') }}</label>
                                                                    <input type="text" name="city"
                                                                        id="city" value="{{ $user->city }}"
                                                                        minlength="2" readonly
                                                                        data-msg-required="The city is required."
                                                                        class="edit_input">
                                                                </div>
                                                                <div class="edit_profile_col">
                                                                    <label
                                                                        for="postal_code">{{ __('Postal Code') }}</label>
                                                                    <input type="number" readonly name="postal_code"
                                                                        id="postal_code"
                                                                        value="{{ $user->postal_code }}"
                                                                        class="edit_input">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="edit_profile_col title_form_blk">
                                                            <h6>{{ __('Change Password') }}</h6>
                                                        </div>
                                                        <div class="edit_profile_col edit_profile_colhalf">
                                                            <label for="oldpassword">{{ __('Old Password') }}</label>
                                                            <div class="input-group password">
                                                                <input type="password" name="oldpassword"
                                                                    id="oldpassword"
                                                                    data-msg-required="The old password is required."
                                                                    class="edit_input">
                                                                <span class="icon pass_txt_1"></span>
                                                            </div>
                                                        </div>
                                                        <div class="edit_profile_col edit_profile_colhalf">
                                                            <div class="edit_profile_row">
                                                                <div class="edit_profile_col">
                                                                    <label
                                                                        for="newpassword">{{ __('Password') }}</label>
                                                                    <div class="input-group password">
                                                                        <input type="password" name="newpassword"
                                                                            id="newpassword"
                                                                            data-msg-required="The new password is required."
                                                                            class="edit_input">
                                                                        <span class="icon pass_txt_2"></span>
                                                                    </div>
                                                                </div>
                                                                <div class="edit_profile_col">
                                                                    <label
                                                                        for="confirmpassword">{{ __('Confirm Password') }}</label>
                                                                    <div class="input-group password">
                                                                        <input type="password" name="confirmpassword"
                                                                            id="confirmpassword"
                                                                            data-msg-required="The confirm password required."
                                                                            class="edit_input">
                                                                        <span class="icon pass_txt_3"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="profile_right">
                                                        <div class="btn_submit_wrap">
                                                            <input type="submit" value="Save" id="btn-submit"
                                                                class="btn btn-primary">
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        {{-- <div class="profile_right">
												<div class="btn_submit_wrap">
													<input type="submit" value="Save" id="btn-submit" class="btn btn-primary">
												</div>
											</div> --}}
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="credits-tab-pane" role="tabpanel"
                                aria-labelledby="credits-tab" tabindex="0">

                                <div class="credits_tab_content">

                                    <div class="credits_tab_top">

                                        <div class="credits_tab_top_left">

                                            <h2>1 MICoin = 1 Gs</h2>

                                            <p>Every Transaction your referee purchases or sells generates tokens

                                                for you!</p>

                                        </div>

                                        <div class="credits_tab_top_right">

                                            <h6>Available MICoins</h6>

                                            <div class="credit_score">

                                                <span>15000 </span> Credit MICoins

                                            </div>

                                        </div>

                                    </div>

                                    <div class="credits_step_row">

                                        <div class="credits_step_col">

                                            <div class="credits_step_blk">

                                                <div class="credits_step_title">

                                                    <span>1</span>

                                                    Invite friends

                                                </div>

                                                <p>Send an invitation to your friends through emails or sharing

                                                    links</p>

                                            </div>

                                        </div>

                                        <div class="credits_step_col">

                                            <div class="credits_step_blk">

                                                <div class="credits_step_title">

                                                    <span>2</span>

                                                    They use MIPO

                                                </div>

                                                <p>They Signup as Investor or Seller and as they get to purchase or

                                                    sell documents</p>

                                            </div>

                                        </div>

                                        <div class="credits_step_col">

                                            <div class="credits_step_blk">

                                                <div class="credits_step_title">

                                                    <span>3</span>

                                                    You earn tokens

                                                </div>

                                                <p>You earn tokesn whcih you can exchnage at any time for cash! The

                                                    more users you recommend, the more $$ you can make</p>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="invite_referral_blk">

                                        <div class="invite_left_blk">

                                            <h6>Send invitation to your friends</h6>

                                            <div class="invite_left_listagrp">
                                                {{-- <div class="invite_left_lista">
														<div class="invite_left_input">
															<input type="email" name="" id="">
														</div>
														<div class="invite_left_input_submit">
															<input type="submit" class="btn btn-primary" value="Invite">
														</div>
													</div>

													<div class="invite_left_lista">
														<div class="invite_left_input">
															<input type="email" name="" id="">
														</div>
														<div class="invite_left_input_submit">
															<input type="submit" class="btn btn-primary" value="Invite">
														</div>
													</div>

													<div class="invite_left_lista">
														<div class="invite_left_input">
															<input type="email" name="" id="">
														</div>
														<div class="invite_left_input_submit">
															<input type="submit" class="btn btn-primary" value="Invite">
														</div>

													</div> --}}

                                                <form name="invite-form" id="inviteForm"
                                                    action="{{ route('profile.ajax-invite-friend') }}" method="post"
                                                    novalidate="novalidate">
                                                    <div class="invite_left_lista">
                                                        <div class="invite_left_input">
                                                            <input type="email" name="email_invite" required
                                                                minlength="5"
                                                                data-msg-required="The email is required."
                                                                id="email_invite">
                                                        </div>
                                                        <div class="invite_left_input_submit">
                                                            <input type="submit" id="btn-invite"
                                                                class="btn btn-primary" value="Invite">
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        <div class="referral_code_blk">

                                            <div class="referral_code_inner">

                                                <div class="referral_code_left">

                                                    Referral code <span> USER123</span>

                                                </div>

                                                <div class="referral_code_copy">

                                                    <a href="javascript:void(0)">

                                                        <svg width="35" height="39" viewBox="0 0 35 39"
                                                            fill="none" xmlns="http://www.w3.org/2000/svg">

                                                            <path
                                                                d="M24.2187 28.9063V34.9531C24.2187 36.0658 23.3157 36.9688 22.2031 36.9688H4.73437C4.1998 36.9688 3.68712 36.7564 3.30911 36.3784C2.93111 36.0004 2.71875 35.4877 2.71875 34.9531V12.1094C2.71875 10.9968 3.62175 10.0938 4.73437 10.0938H8.09375C8.99419 10.0931 9.89313 10.1675 10.7812 10.3159M24.2187 28.9063H30.2656C31.3782 28.9063 32.2812 28.0033 32.2812 26.8906V18.1563C32.2812 10.1654 26.4709 3.53446 18.8437 2.25342C17.9556 2.10495 17.0567 2.03064 16.1562 2.03125H12.7969C11.6842 2.03125 10.7812 2.93425 10.7812 4.04688V10.3177M24.2187 28.9063H12.7969C12.2623 28.9063 11.7496 28.6939 11.3716 28.3159C10.9936 27.9379 10.7812 27.4252 10.7812 26.8906V10.3177M32.2812 22.1875V18.8281C32.2812 17.2244 31.6442 15.6864 30.5102 14.5523C29.3762 13.4183 27.8381 12.7813 26.2344 12.7813H23.5469C23.0123 12.7813 22.4996 12.5689 22.1216 12.1909C21.7436 11.8129 21.5312 11.3002 21.5312 10.7656V8.07813C21.5312 7.28404 21.3748 6.49773 21.071 5.76409C20.7671 5.03045 20.3217 4.36385 19.7602 3.80234C19.1987 3.24084 18.5321 2.79543 17.7984 2.49154C17.0648 2.18766 16.2785 2.03125 15.4844 2.03125H13.4687"
                                                                stroke="#5C5C5C" stroke-width="4"
                                                                stroke-linecap="round" stroke-linejoin="round" />

                                                        </svg>

                                                    </a>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="convert_blk">

                                        <div class="convert_txt">

                                            Convert MICoins to Cash? <a href="#">Click here</a>

                                        </div>

                                        <div class="convert_icon">

                                            <svg width="126" height="134" viewBox="0 0 126 134" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">

                                                <path
                                                    d="M73.24 97.56V94.32C79 93.76 82.56 90.4 82.56 85.32C82.56 81.4 79.76 78.84 74.76 77.8L70.36 76.88C69 76.6 67.84 75.84 67.84 74.68C67.84 72.88 69.32 72.08 71.28 72.08C73.6 72.08 75.16 73.52 75.32 75.72H82.16C81.8 70.8 78.32 67.48 73.24 66.72V63.32H68.84V66.72C64.12 67.52 60.88 70.8 60.88 75.2C60.88 80.04 64.04 82.04 68.12 82.92L72.6 83.88C73.92 84.16 75.2 85.04 75.2 86.2C75.2 87.92 73.48 88.84 71.12 88.84C68.32 88.84 66.64 87.4 66.64 85.04H59.8C60.2 90.04 63.56 93.4 68.84 94.2V97.56H73.24Z"
                                                    fill="black" />

                                                <rect x="20.5" y="3.5" width="102" height="50"
                                                    rx="5.5" stroke="black" stroke-width="7" />

                                                <rect x="100.5" y="28.5" width="102" height="58"
                                                    rx="5.5" transform="rotate(90 100.5 28.5)" stroke="black"
                                                    stroke-width="7" />

                                                <line x1="32.5" y1="28.5" x2="111.5" y2="28.5"
                                                    stroke="black" stroke-width="7" stroke-linecap="round" />

                                                <path
                                                    d="M17.2322 100.768C18.2085 101.744 19.7915 101.744 20.7678 100.768L36.6777 84.8579C37.654 83.8816 37.654 82.2986 36.6777 81.3223C35.7014 80.346 34.1184 80.346 33.1421 81.3223L19 95.4645L4.85786 81.3223C3.88155 80.346 2.29864 80.346 1.32233 81.3223C0.346019 82.2986 0.346019 83.8816 1.32233 84.8579L17.2322 100.768ZM16.5 70L16.5 99L21.5 99L21.5 70L16.5 70Z"
                                                    fill="black" />

                                            </svg>

                                        </div>

                                    </div>

                                    <div class="term_con_blk">

                                        <a href="#">Terms & Conditions</a>

                                    </div>

                                </div>

                            </div>

                            <div class="tab-pane fade" id="manage_user-tab-pane" role="tabpanel"
                                aria-labelledby="manage_user-tab" tabindex="0">

                                <div class="manage_user_tab_content">

                                    <div class="manage_user_inner">

                                        <div class="manage_user_top">

                                            <div class="manage_user_left">{{ __('Users') }}</div>

                                            <div class="manage_user_add">
                                                <a href="javascript:void(0)"
                                                    class="btn btn-primary evt_user_modal_open" data-action="Add"
                                                    data-user-object="" data-form-name="#addsubUserForm"
                                                    data-modal-name="#add_new_user">
                                                    <i>

                                                        <svg width="11" height="12" viewBox="0 0 11 12"
                                                            fill="none" xmlns="http://www.w3.org/2000/svg">

                                                            <path d="M5.5 1.3125V10.6875M10.1875 6H0.8125"
                                                                stroke="white" stroke-width="1.5"
                                                                stroke-linecap="round" stroke-linejoin="round" />

                                                        </svg>

                                                    </i>

                                                    {{ __('Add a new user') }}

                                                </a>

                                            </div>

                                        </div>

                                        <div class="manage_user_bottom">

                                            <div class="manage_user_header manage_user_box">
                                                <div class="manage_user_name">
                                                    {{ __('NAME') }}
                                                </div>
                                                <div class="manage_user_action">
                                                    {{ __('ACTIONS') }}
                                                </div>
                                            </div>

                                            <div class="manage_user_box_wrap" id="ajax_enterprise_by_user_list">



                                                <div class="manage_user_box">

                                                    <div class="manage_user_name">

                                                        <div class="manage_user_image">

                                                            <img src="{{ asset('images/user-img.webp') }}"
                                                                alt="">

                                                        </div>

                                                        Michail Trudo

                                                    </div>

                                                    <div class="manage_user_action">

                                                        <div class="manage_user_action_wrap">

                                                            <div class="edit_manage_user">

                                                                <a href="javascript:void(0)" data-bs-toggle="modal"
                                                                    data-bs-target="#edit_user">

                                                                    <i>

                                                                        <svg width="16" height="16"
                                                                            viewBox="0 0 16 16" fill="none"
                                                                            xmlns="http://www.w3.org/2000/svg">

                                                                            <path
                                                                                d="M11.6465 2.36544L13.625 4.34394M12.5 9.50019V13.0627C12.5 13.5102 12.3222 13.9395 12.0057 14.2559C11.6893 14.5724 11.2601 14.7502 10.8125 14.7502H2.9375C2.48995 14.7502 2.06072 14.5724 1.74426 14.2559C1.42779 13.9395 1.25 13.5102 1.25 13.0627V5.18769C1.25 4.74013 1.42779 4.31091 1.74426 3.99444C2.06072 3.67798 2.48995 3.50019 2.9375 3.50019H6.5M11.6465 2.36544L12.9117 1.09944C13.1755 0.835678 13.5332 0.6875 13.9062 0.6875C14.2793 0.6875 14.637 0.835678 14.9008 1.09944C15.1645 1.36319 15.3127 1.72093 15.3127 2.09394C15.3127 2.46695 15.1645 2.82468 14.9008 3.08844L6.9365 11.0527C6.53999 11.449 6.05102 11.7402 5.51375 11.9002L3.5 12.5002L4.1 10.4864C4.25996 9.94916 4.55123 9.46019 4.9475 9.06369L11.6465 2.36544V2.36544Z"
                                                                                stroke="#0D6EFD"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round" />

                                                                        </svg>

                                                                    </i>

                                                                    Edit

                                                                </a>

                                                            </div>

                                                            <div class="delete_manage_user">

                                                                <a href="#">

                                                                    <i>

                                                                        <svg width="14" height="16"
                                                                            viewBox="0 0 14 16" fill="none"
                                                                            xmlns="http://www.w3.org/2000/svg">

                                                                            <path
                                                                                d="M9.055 5.75039L8.7955 12.5004M5.2045 12.5004L4.945 5.75039M12.421 3.34289C12.6775 3.38189 12.9325 3.42314 13.1875 3.46739M12.421 3.34364L11.62 13.7551C11.5873 14.1791 11.3958 14.575 11.0838 14.8638C10.7717 15.1526 10.3622 15.313 9.937 15.3129H4.063C3.63782 15.313 3.22827 15.1526 2.91623 14.8638C2.6042 14.575 2.41269 14.1791 2.38 13.7551L1.579 3.34289M12.421 3.34289C11.5554 3.21203 10.6853 3.11271 9.8125 3.04514M0.8125 3.46664C1.0675 3.42239 1.3225 3.38114 1.579 3.34289M1.579 3.34289C2.4446 3.21203 3.31468 3.11271 4.1875 3.04514M9.8125 3.04514V2.35814C9.8125 1.47314 9.13 0.735141 8.245 0.707391C7.41521 0.68087 6.58479 0.68087 5.755 0.707391C4.87 0.735141 4.1875 1.47389 4.1875 2.35814V3.04514M9.8125 3.04514C7.94029 2.90045 6.05971 2.90045 4.1875 3.04514"
                                                                                stroke="#DC3545"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round" />

                                                                        </svg>

                                                                    </i>

                                                                    Delete

                                                                </a>

                                                            </div>

                                                        </div>

                                                    </div>

                                                </div>


                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="tab-pane fade" id="settings-tab-pane" role="tabpanel"
                                aria-labelledby="settings-tab" tabindex="0">

                                <div class="settings_tab_content">

                                    <div class="settings_inner">

                                        <div class="settings_left">

                                            <div class="settings_blk">

                                                <h6>{{ __('NOTIFICATIONS') }}</h6>
                                                @forelse ($notifications as $key => $notification)
                                                <div class="filter_checkbox_wrap">
                                                    <input type="checkbox" name="user_notification" value="{{ $notification->notification_type }}" id="notification_{{$key}}">
                                                    <label for="notification_{{$key}}">{{ $notification->notification_title }}</label>
                                                </div>
                                                @empty
                                                    <p> {{ __(' No Record Found.')}}</p>
                                                @endforelse
                                            </div>

                                            <div class="settings_blk">
                                                <h6>{{ __('LANGUAGE') }}</h6>
                                                <div class="language_blk">
                                                    <div class="ent_lang dropdown">
                                                        <a class="lang-link"
                                                            href="javascript:;">{{ config('constants.languages.' . App()->getLocale()) }}
                                                            <i><img src="{{ asset('images/lang-icon.svg') }}"
                                                                    alt="language"></i></a>
                                                        <ul class="dropdown-menu">
                                                            @if ($language)
                                                                @foreach ($language as $short_code => $language_val)
                                                                    <li class="@if (App()->isLocale($short_code)) current @endif user-profile-setting-form"
                                                                        data-language-short-code="{{ $short_code }}"
                                                                        data-select-language="{{ $language_val }}"
                                                                        data-type="language">
                                                                        <a href="{{ url('locale', $short_code) }}">{{ $language_val }}
                                                                            @if (App()->isLocale($short_code))
                                                                                <i><img src="{{ asset('images/check-icon.svg') }}"
                                                                                        alt="language" /></i>
                                                                            @endif
                                                                        </a>
                                                                    </li>
                                                                @endforeach
                                                            @endif
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="settings_blk">
                                                <div class="preferred_main">
                                                    <h6>{{ __('PREFERRED DASHBOARD PRIORITY') }}</h6>
                                                    <div class="preferred_select">
                                                        <select name="preferred_dashboard" id="preferred_dashboard"
                                                            data-type="preferred_dashboard"
                                                            class="selectbox user-profile-setting-form">
                                                            @if ($preferred_dashboard)
                                                                @foreach ($preferred_dashboard as $key => $val)
                                                                    <option
                                                                        {{ $user->preferred_dashboard == $val ? 'selected' : '' }}
                                                                        value="{{ $val }}">
                                                                        {{ $val }}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="preferred_main">
                                                    <h6>{{ __('PREFERRED CURRENCY') }}</h6>
                                                    <div class="preferred_select">
                                                        <select name="preferred_currency" id="preferred_currency"
                                                            data-type="preferred_currency"
                                                            class="selectbox user-profile-setting-form">
                                                            @if ($currency_type)
                                                                @foreach ($currency_type as $key => $val)
                                                                    <option
                                                                        {{ $user->preferred_currency == $val ? 'selected' : '' }}
                                                                        value="{{ $val }}">
                                                                        {{ $val }}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="preferred_main">
                                                    <h6>{{ __('PREFERRED CONTACT METHOD') }}</h6>
                                                    <div class="preferred_select">
                                                        <select name="preferred_contact_method"
                                                            id="preferred_contact_method"
                                                            data-type="preferred_contact_method"
                                                            class="selectbox user-profile-setting-form">
                                                            @if ($preferred_contact_method)
                                                                @foreach ($preferred_contact_method as $key => $val)
                                                                    <option
                                                                        {{ $user->preferred_contact_method == $val ? 'selected' : '' }}
                                                                        value="{{ $val }}">
                                                                        {{ $val }}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="settings_right">

                                            <img src="{{ asset('images/undraw_contact_us_request.svg') }}"
                                                alt="">

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="tab-pane fade" id="favorites-tab-pane" role="tabpanel"
                                aria-labelledby="favorites-tab" tabindex="0">
                                <div class="prof_fav_wrap">
                                    <div class="row" id="ajax_favorites_by_user_list">

                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="plan-tab-pane" role="tabpanel"
                                aria-labelledby="plan-tab" tabindex="0">
                                <div class="credits_tab_content">
                                    <div class="credits_tab_top">
                                        <div class="credits_tab_top_left">
                                            <h2>{{$user->plan?->name}}</h2>
                                            <p>is your current selected plan</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <table class="table mt-3">
                                            <thead>
                                                <tr>
                                                <th scope="col">Subscription No</th>
                                                <th scope="col">Plan</th>
                                                <th scope="col">Price</th>
                                                <th scope="col">Start Date</th>
                                                <th scope="col">End Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if($user->subscriptionPlans)
                                                    @foreach($user->subscriptionPlans as $row)
                                                        <tr>
                                                            <th>{{$row->subscription_no}}</th>
                                                            <th>{{$row->name}}</th>
                                                            <td>{{$row->currency}}{{$row->price}}</td>
                                                            <td>{{$row->starts_at}}</td>
                                                            <td>{{$row->ends_at}}</td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                            </table>
                                        </div>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- Add User Modal Start -->
    <div class="modal fade add_new_user_modal" id="add_new_user" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">

            <div class="modal-content">

                <div class="modal-body">

                    {{-- <form action=""> --}}

                    <div class="add_user_modal_top">

                        <div class="add_new_user_title">

                            <h3>{{ __('Add new user') }}</h3>

                            <div class="add_new_user_btn">
                                <a href="javascript:void(0)" class="btn btn-secondary evt_close_modal"
                                    data-form-name="#addsubUserForm"
                                    data-modal-name="#add_new_user">{{ __('Close') }}</a>
                            </div>
                        </div>
                        <form action="{{ route('profile.store') }}" method="post" novalidate="novalidate"
                            name="addsubUserForm" id="addsubUserForm" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="user_id" id="user_id" value="">
                            <input type="hidden" name="action" id="action" value="">
                            <div class="mb-3">
                                <label for="first_name" class="col-form-label">{{ __('First Name') }}</label>
                                <input type="text" class="form-control" name="first_name" id="first_name"
                                    required data-msg-required="The first name is required.">
                            </div>

                            <div class="mb-3">
                                <label for="last_name" class="col-form-label">{{ __('Last Name') }}</label>
                                <input type="text" class="form-control" name="last_name" id="last_name" required
                                    data-msg-required="The last name is required.">
                            </div>

                            <div class="mb-3">
                                <label for="email" class="col-form-label">{{ __('Email') }}</label>
                                <input type="email" class="form-control" name="email" id="email" required
                                    data-msg-required="The email is required.">
                            </div>

                            <div class="mb-3">
                                <label for="phone_number" class="col-form-label">{{ __('Phone Number') }}</label>
                                <input type="number" class="form-control" name="phone_number" id="phone_number"
                                    required data-msg-required="The phone number is required.">
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">{{ __('Add') }}</button>
                                <button type="button" id="btn_sub_user_form"
                                    class="btn btn-secondary evt_close_modal" data-form-name="#addsubUserForm"
                                    data-modal-name="#add_new_user">{{ __('Close') }}</button>
                            </div>
                        </form>

                    </div>

                    {{-- <div class="add_user_modal_bottom">

						<div class="add_user_modal_permissions">

							PERMISSIONS

						</div>

					</div>

					<div class="add_user_modal_permissions_select">

						<div class="filter_checkbox_wrap">

							<input type="checkbox" name="" id="add_user_permissions_1">

							<label for="add_user_permissions_1">Permission #1</label>

						</div>

						<div class="filter_checkbox_wrap">

							<input type="checkbox" name="" id="add_user_permissions_2">

							<label for="add_user_permissions_2">Permission #2</label>

						</div>

						<div class="filter_checkbox_wrap">

							<input type="checkbox" name="" id="add_user_permissions_3">

							<label for="add_user_permissions_3">Permission #3</label>

						</div>

						<div class="filter_checkbox_wrap">

							<input type="checkbox" name="" id="add_user_permissions_4">

							<label for="add_user_permissions_4">Permission #4</label>

						</div>

					</div> --}}

                    {{-- </form> --}}

                </div>

            </div>

        </div>

    </div>
    <!-- Add User Modal End -->

    <!-- Edit User Modal Start -->
    <div class="modal fade add_new_user_modal" id="edit_user" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">

            <div class="modal-content">

                <div class="modal-body">

                    <form action="">

                        <div class="add_user_modal_top">

                            <div class="add_new_user_title">

                                <h3>Edit user</h3>

                                <div class="add_new_user_btn">

                                    <a href="javascript:void(0)" class="btn btn-primary">Add</a>

                                </div>

                            </div>

                            <div class="add_new_user_email">

                                <div class="manage_user_name">

                                    <div class="manage_user_image"><img src="./dist/images/user-img.webp"
                                            alt=""></div>

                                    Arya Kagathara

                                </div>

                            </div>

                        </div>

                        <div class="add_user_modal_bottom">

                            <div class="add_user_modal_permissions">

                                PERMISSIONS

                            </div>

                        </div>

                        <div class="add_user_modal_permissions_select">

                            <div class="filter_checkbox_wrap">

                                <input type="checkbox" name="" id="edit_user_1">

                                <label for="edit_user_1">Permission #1</label>

                            </div>

                            <div class="filter_checkbox_wrap">

                                <input type="checkbox" name="" id="edit_user_2">

                                <label for="edit_user_2">Permission #2</label>

                            </div>

                            <div class="filter_checkbox_wrap">

                                <input type="checkbox" name="" id="edit_user_3">

                                <label for="edit_user_3">Permission #3</label>

                            </div>

                            <div class="filter_checkbox_wrap">

                                <input type="checkbox" name="" id="edit_user_4">

                                <label for="edit_user_4">Permission #4</label>

                            </div>

                        </div>

                    </form>

                </div>

            </div>

        </div>
    </div>

    <div class="modal fade" id="otp_verify_address_verify_modal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('OTP Verify') }}</h5>
                    <button type="button" class="btn-close evt_close_modal" data-form-name="#otp_verify_address_form" data-modal-name="#otp_verify_address_verify_modal" aria-label="Close"></button>
                </div>
                <form name="otp_verify_address_form" class="form-validation" id="otp_verify_address_form" method="post"
                    action="{{route('profile.ajax-otp-verify-address')}}"
                    novalidate="novalidate">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="address_verify_otp" class="col-form-label">{{ __('OTP') }}</label>
                            <input type="number" class="form-control" name="address_verify_otp" id="address_verify_otp" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">{{ __('Verify') }}</button>
                        <button type="button" class="btn btn-secondary evt_close_modal" data-form-name="#otp_verify_address_form" data-modal-name="#otp_verify_address_verify_modal" >{{ __('Close') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Edit User Modal End -->
    @section('custom_script')
        <script src="{{ asset('plugins/select2-4.1.0-rc.0/dist/js/select2.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('plugins/sweetalert2/sweetalert2.all.min.js') }}" type="text/javascript"></script>
        <script>
            const url_load_more_user_data = "{{ route('profile.ajax-enterprise-by-user-list') }}";
            const url_load_more_favorite_user_data = "{{ route('profile.ajax-favorite-prfile-list') }}";
            $(function($) {

                let date = new Date();
                date.setFullYear(date.getFullYear());
                document.getElementById("birth_date").max = date.toISOString().split("T")[0];

                loadMoreUserData();
                loadMoreFavoriteUserData();

                $(".input-group.password .pass_txt_1").on("click", function() {
                    let input = $('#oldpassword');
                    if (input.attr("type") == "password") {
                        input.attr("type", "text");
                    } else {
                        input.attr("type", "password");
                    }
                });

                $(".input-group.password .pass_txt_2").on("click", function() {
                    let input = $('#newpassword');
                    if (input.attr("type") == "password") {
                        input.attr("type", "text");
                    } else {
                        input.attr("type", "password");
                    }
                });

                $(".input-group.password .pass_txt_3").on("click", function() {
                    let input = $('#confirmpassword');
                    if (input.attr("type") == "password") {
                        input.attr("type", "text");
                    } else {
                        input.attr("type", "password");
                    }
                });

                $('.evt_file_upload').on('change', function(e) {
                    e.preventDefault();
                    let form = $('#userProfileForm');
                    let form_valid = form.valid();
                    if (form_valid) {
                        setLoadin();
                        let actionUrl = form.attr('action');
                        let formData = new FormData($('#userProfileForm')[0]);
                        $.ajax({
                            type: "POST",
                            url: actionUrl,
                            data: formData,
                            dataType: 'json',
                            cache: false,
                            processData: false,
                            contentType: false,
                            success: function(res) {
                                unsetLoadin();
                                $("input[type='file']").val('');
                                if (res.status == true) {
                                    toastr.success(res.message);
                                    $('#profile_image_url').attr('src', res.data[0]
                                        .profile_image_url);
                                    $('#user-login-profile').attr('src', res.data[0]
                                        .profile_image_url);
                                } else {
                                    toastr.error(res.message);
                                }
                            },
                            error: function(xhr) {
                                $("input[type='file']").val('');
                                unsetLoadin();
                                ajaxErrorMsg(xhr);
                            }
                        });
                    } else {
                        $("input[type='file']").val('');
                        toastr.error('something went wrong please try again!');
                    }
                });

                /* end user profile personal details */
                $("#personalDetailsForm").submit(function(e) {
                    e.preventDefault();
                    let form = $(this);
                    let form_valid = form.valid();
                    if (form_valid) {
                        setLoadin();
                        let formData = new FormData($('#personalDetailsForm')[0]);
                        let actionUrl = form.attr('action');
                        $.ajax({
                            type: "POST",
                            url: actionUrl,
                            data: formData,
                            dataType: 'json',
                            cache: false,
                            processData: false,
                            contentType: false,
                            success: function(res) {
                                $("input[type='password']").val('');
                                unsetLoadin();
                                if (res.status == true) {
                                    toastr.success(res.message);
                                    $('#user-login-name').text((res.data[0].first_name + ' ' + res
                                        .data[0].last_name));
                                } else {
                                    toastr.error(res.message);
                                }
                            },
                            error: function(xhr) {
                                unsetLoadin();
                                ajaxErrorMsg(xhr);
                            }
                        });
                    }
                });
                /* end user profile personal details */

                /* start user profile Invite friends */
                $("#inviteForm").submit(function(e) {
                    e.preventDefault();
                    let form = $(this);
                    let form_valid = form.valid();
                    if (form_valid) {
                        setLoadin();
                        let formData = new FormData($('#inviteForm')[0]);
                        formData.append('referral_code', 'USER123');
                        formData.append('email', $("#email_invite").val());

                        let actionUrl = form.attr('action');
                        $.ajax({
                            type: "POST",
                            url: actionUrl,
                            data: formData,
                            dataType: 'json',
                            cache: false,
                            processData: false,
                            contentType: false,
                            success: function(res) {
                                $("#email_invite").val('');
                                unsetLoadin();
                                if (res.status == true) {
                                    toastr.success(res.message);
                                } else {
                                    toastr.error(res.message);
                                }
                            },
                            error: function(xhr) {
                                unsetLoadin();
                                ajaxErrorMsg(xhr);
                            }
                        });
                    }
                });
                /* end user profile Invite friends */

                /* start user profile setting */
                $('.user-profile-setting-form').change(function(e) {
                    e.preventDefault();
                    let self = $(this);
                    let type = self.attr('data-type');
                    var formData = {}
                    var user_login_id = $('#web_user_login_slug').val();
                    if (type == 'preferred_dashboard') {
                        formData = {
                            'type': type,
                            'preferred_dashboard': self.val()
                        };
                    } else if (type == 'preferred_currency') {
                        formData = {
                            'type': type,
                            'preferred_currency': self.val()
                        };
                    } else if (type == 'preferred_contact_method') {
                        formData = {
                            'type': type,
                            'preferred_contact_method': self.val()
                        };
                    } else if (type == 'language') {
                        formData = {
                            'type': type,
                            'language': self.attr('data-select-language')
                        };
                    }
                    formData.user_login_id = user_login_id;
                    if (formData != null && user_login_id != '') {
                        setLoadin();
                        $.ajax({
                            type: "POST",
                            url: "{{ route('profile.ajax-user-profile-setting') }}",
                            data: (formData),
                            dataType: 'json',
                            success: function(res) {
                                unsetLoadin();
                                if (res.status == true) {
                                    toastr.success(res.message);
                                } else {
                                    toastr.error(res.message);
                                }
                            },
                            error: function(xhr) {
                                unsetLoadin();
                                ajaxErrorMsg(xhr);
                            }
                        });
                    }
                });
                /* end user profile setting */

                $('#addsubUserForm').submit(function(e) {
                    e.preventDefault();
                    let form = $(this);
                    let form_valid = form.valid();
                    if (form_valid) {
                        setLoadin();
                        let formData = new FormData($('#addsubUserForm')[0]);
                        let actionUrl = form.attr('action');
                        $.ajax({
                            type: "POST",
                            url: actionUrl,
                            data: formData,
                            dataType: 'json',
                            cache: false,
                            processData: false,
                            contentType: false,
                            success: function(res) {
                                unsetLoadin();
                                if (res.status == true) {
                                    toastr.success(res.message);
                                    $('#add_new_user').modal('hide');
                                    $('#addsubUserForm')[0].reset();
                                    loadMoreUserData();
                                } else {
                                    toastr.error(res.message);
                                }
                            },
                            error: function(xhr) {
                                unsetLoadin();
                                ajaxErrorMsg(xhr);
                            }
                        });
                    }
                });

                $('.evt_close_modal').click(function(e) {
                    e.preventDefault();
                    var self = $(this);

                    var modal_name = self.attr('data-modal-name');
                    var form_name = self.attr('data-form-name');

                    $(modal_name).modal('hide');
                    $(form_name)[0].reset();

                });

                $('.evt_open_otp_verify_address_verify_modal').click(function(e) {
                    e.preventDefault();
                    var self = $(this);
                    $('#otp_verify_address_verify_modal').modal('show');
                });

                $("#otp_verify_address_form").submit(function(e) {
                    e.preventDefault();
                    let form = $(this);
                    let form_valid = form.valid();
                    if (form_valid) {
                        setLoadin();
                        let formData = new FormData($('#otp_verify_address_form')[0]);
                        let actionUrl = form.attr('action');
                        $.ajax({
                            type: "POST",
                            url: actionUrl,
                            data: formData,
                            dataType: 'json',
                            cache: false,
                            processData: false,
                            contentType: false,
                            success: function(res) {
                                unsetLoadin();
                                $(form)[0].reset();
                                if (res.status == true) {
                                    $('.evt_open_otp_verify_address_verify_modal').unbind('click');
                                    $('#otp_verify_anchor_tag').removeClass('evt_open_otp_verify_address_verify_modal');
                                    $('#otp_verify_anchor_tag').text('Verified');
                                    $('#link_addree_class').removeClass('text-bg-primary');
                                    $('#link_addree_class').addClass('text-bg-success');
                                    $('#otp_verify_address_verify_modal').modal('hide');
                                    toastr.success(res.message);
                                } else {
                                    toastr.error(res.message);
                                }
                            },
                            error: function(xhr) {
                                unsetLoadin();
                                ajaxErrorMsg(xhr);
                            }
                        });
                    }
                });
            });

            $(document).on('click', '.evt_paginate_user .pagination a', function(e) {
                e.preventDefault();
                var page_no = $(this).attr('href').split('page=')[1];
                loadMoreUserData(page_no);
            });

            $(document).on('click', '.evt_got_to_page', debounce(function(e) {
                e.preventDefault();
                var self = $(this);
                var last_page_no = self.attr('data-last-page');
                var input_page_no = $('#page_no').val();

                if (parseInt(last_page_no) >= parseInt(input_page_no)) {
                    loadMoreUserData($('#page_no').val());
                } else {
                    toastr.error(`Maximum page no ${last_page_no}`);
                }

            }, 200));

            $(document).on('click', '.evt_user_modal_open', function(e) {
                e.preventDefault();
                var self = $(this);
                const form_obj = $('#addsubUserForm');

                var modal_name = self.attr('data-modal-name');
                var form_name = self.attr('data-form-name');
                var user_data = self.attr('data-user-object');
                var action_name = self.attr('data-action');

                form_obj.find('#action').val(action_name);
                form_obj.find('#user_id').val('');
                form_obj.find('[type=submit]').text(action_name);

                if (user_data && user_data != '') {
                    user_data = JSON.parse(user_data);

                    form_obj.find('#user_id').val(user_data.id);
                    form_obj.find('#first_name').val(user_data.first_name);
                    form_obj.find('#last_name').val(user_data.last_name);
                    form_obj.find('#email').val(user_data.email);
                    form_obj.find('#phone_number').val(user_data.phone_number);
                }

                $(modal_name).modal('show');
            });

            function loadMoreUserData(page_no = null) {
                setLoadin();
                $.ajax({
                    type: 'POST',
                    url: url_load_more_user_data + '?page=' + page_no,
                    data: {},
                    dataType: 'json',
                    cache: false,
                    success: function(res) {
                        unsetLoadin();
                        if (res.status == true) {
                            $('#ajax_enterprise_by_user_list').html(res.data.dhtml);
                        } else {
                            toastr.error(res.message);
                        }
                    },
                    error: function(xhr) {
                        unsetLoadin();
                        ajaxErrorMsg(xhr);
                    }
                });
            }

            // js favorites
            $(document).on('click', '.evt_paginate_user_favorites .pagination a', function(e) {
                e.preventDefault();
                var page_no = $(this).attr('href').split('page=')[1];
                loadMoreFavoriteUserData(page_no);
            });

            $(document).on('click', '.evt_got_to_page_favorites', debounce(function(e) {
                e.preventDefault();
                var self = $(this);
                var last_page_no = self.attr('data-last-page');
                var loadMoreFavoriteUserData = $('#page_no_favorites').val();

                if (parseInt(last_page_no) >= parseInt(input_page_no)) {
                    loadMoreFavoriteUserData($('#page_no_favorites').val());
                } else {
                    toastr.error(`Maximum page no ${last_page_no}`);
                }
            }, 200));

            $(document).on('click', '.evt_favorite_delete', function(e) {
                e.preventDefault();
                var favorite_id = $(this).attr('data-favorite-id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Are you sure, you want to delete this?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#0D6EFD',
                    cancelButtonColor: '#2E365A',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        setLoadin();
                        $.ajax({
                            type: "POST",
                            url: "{{ route('profile.ajax-favorite-prfile-delete') }}",
                            data: {
                                'favorite_id': favorite_id
                            },
                            dataType: 'json',
                            success: function(res) {
                                unsetLoadin();
                                if (res.status == true) {
                                    toastr.success(res.message);
                                    loadMoreFavoriteUserData();
                                } else {
                                    toastr.error(res.message);
                                }
                            },
                            error: function(xhr) {
                                unsetLoadin();
                                ajaxErrorMsg(xhr);
                            }
                        });
                    }
                })
            });

            function loadMoreFavoriteUserData(page_no = null) {
                setLoadin();
                $.ajax({
                    type: 'POST',
                    url: url_load_more_favorite_user_data + '?page=' + page_no,
                    data: {},
                    dataType: 'json',
                    cache: false,
                    success: function(res) {
                        unsetLoadin();
                        if (res.status == true) {
                            $('#ajax_favorites_by_user_list').html(res.data.dhtml);
                        } else {
                            toastr.error(res.message);
                        }
                    },
                    error: function(xhr) {
                        unsetLoadin();
                        ajaxErrorMsg(xhr);
                    }
                });
            }

        </script>
    @endsection
</x-app-layout>
