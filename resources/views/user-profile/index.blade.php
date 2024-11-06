
<x-app-layout>
    @section('pageTitle', 'Profile')
    @section('custom_style')
        <link href="{{ asset('plugins/select2-4.1.0-rc.0/dist/css/select2.min.css') }}" rel="stylesheet">
    @endsection

   
   {{--  <div class="payment_gateway">
        <div class="container">
            <div class="arobox">
                <a href="javascript:;">
                    <i><img src="{{ asset('images/mipo/topleftAro.svg') }}" class="day" alt="no-image"></i>
                    <i><img src="{{ asset('images/mipo/white_lft_aro.svg') }}" class="night" alt="no-image"></i>
                </a>
                <h2 class="text-24-semibold">{!! __('Payment') !!}</h2>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="imgbox">
                        <img src="{{ asset('images/mipo/pay_gatway.png') }}" alt="no-image">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="payment_contain">
                        <div class="mobile_lr head">
                            <p class="text-14-medium">{!! __('Details') !!}</p>
                            <h6 class="text-14-medium">{!! __('Total') !!}</h6>
                        </div>
                    <div class="payment_content">
                        <div class="mobile_lr innerdatail">
                                <p class="text-14-medium">{!! __('Commission') !!}</p>
                                <h6 class="text-14-medium">GS 00.00</h6>
                        </div>
                        <div class="mobile_lr innerdatail">
                            <p class="text-14-medium">{!! __('MIPO+') !!}</p>
                            <h6 class="text-14-medium">GS 00.00</h6>
                        </div>
                        <div class="mobile_lr">
                            <p class="text-14-medium">{!! __('Total') !!}</p>
                            <h6 class="text-14-medium">GS 00.00</h6>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="profile_page">
        <div class="profile_sec">
            <div class="container">
                <div class="profile_title">
                    <div class="arobox">
                        <div class="gotoback">
                            <i><img src="{{ asset('images/mipo/topleftAro.svg') }}" class="day" alt="no-image"></i>
                            <i><img src="{{ asset('images/mipo/white_lft_aro.svg') }}" class="night" alt="no-image"></i>
                        </div>
                        <h2 class="text-24-semibold">{!! __('Profile') !!}</h2>
                    </div>
                </div>
                <div class="profile_tab_row">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item text-14-medium" role="presentation">
                          <button class="nav-link" id="home-tab" data-bs-toggle="tab" data-bs-target="#personal_detail" type="button" role="tab" aria-controls="home" aria-selected="true">{!! __('Personal Details') !!}</button>
                        </li>
                        <li class="nav-item text-14-medium" role="presentation">
                          <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#payment_details" type="button" role="tab" aria-controls="profile" aria-selected="false">{!! __('Payment Details') !!}</button>
                        </li>
                        <li class="nav-item text-14-medium" role="presentation">
                            <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#micoins" type="button" role="tab" aria-controls="contact" aria-selected="false">{!! __('MiCoins') !!}</button>
                        </li>
                        <li class="nav-item text-14-medium" role="presentation">
                            <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#role" type="button" role="tab" aria-controls="contact" aria-selected="false">{!! __('Role') !!}</button>
                          </li>

                        <li class="nav-item text-14-medium" role="presentation">
                            <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#manage_user" type="button" role="tab" aria-controls="contact" aria-selected="false">{!! __('Manage Users') !!}</button>
                        </li>
                        <li class="nav-item text-14-medium" role="presentation">
                            <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#favorites" type="button" role="tab" aria-controls="contact" aria-selected="false">{!! __('Favorites') !!}</button>
                        </li>
                        <li class="nav-item text-14-medium" role="presentation">
                            <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#settings" type="button" role="tab" aria-controls="contact" aria-selected="false">{!! __('Settings') !!}</button>
                        </li>
                        {{-- <li class="nav-item text-14-medium" role="presentation">
                            <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#plans" type="button" role="tab" aria-controls="contact" aria-selected="false">{!! __('Plans') !!}</button>
                        </li> --}}
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <input type="hidden" value="{{ $user->slug }}"
                        id="web_user_login_slug" />
                        <div class="tab-pane fade" id="personal_detail" role="tabpanel" aria-labelledby="personal-tab">
                            <x-personal-details-web :user="$user" :cities="$cities" :userLevels="$userLevels"/>
                        </div>

                        <div class="tab-pane fade" id="payment_details" role="tabpanel" aria-labelledby="payment-tab">
                            <x-payment-details-web :banks="$banks"/>
                        </div>

                        <div class="tab-pane fade" id="micoins" role="tabpanel" aria-labelledby="miicon-tab">
                            <x-micoin-web :total_micoin_credit="$total_micoin_credit" :referrer_code="$referrer_code"/>
                        </div>

                        <div class="tab-pane fade" id="role" role="tabpanel" aria-labelledby="role-tab">
                            <x-user-role-permission-web/>
                        </div>

                        <div class="tab-pane fade" id="manage_user" role="tabpanel" aria-labelledby="manageuser-tab">
                            <x-manage-users-web :roles="$roles"/>
                        </div>

                        <div class="tab-pane fade" id="favorites" role="tabpanel" aria-labelledby="favorites-tab">
                            <x-favorites-web/>
                        </div>

                        <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="settinfg-tab">
                            <x-settings-web :user="$user" :preferred_dashboard="$preferred_dashboard" :currency_type="$currency_type" :preferred_contact_method="$preferred_contact_method" :notifications="$notifications" />
                        </div>

                       {{--  <div class="tab-pane fade" id="plans" role="tabpanel" aria-labelledby="plan-tab"> 
                            <x-plans-web :user="$user" />
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    <!-- Add User Modal End -->
    @section('custom_script')
        <script>
            const url_load_more_user_data = "{{ route('profile.ajax-enterprise-by-user-list') }}";
            const url_load_more_favorite_user_data = "{{ route('profile.ajax-favorite-prfile-list') }}";
            const url_load_more_bank_user_data = "{{ route('profile.ajax-bank-list') }}";
            const url_load_more_role_data = "{{ route('role.ajax-role-list') }}";
            const url_user_profile_setting = "{{ route('profile.ajax-user-profile-setting') }}";
            const url_favorite_profile_delete = "{{ route('profile.ajax-favorite-prfile-delete') }}";
        </script>
        <script src="{{ asset('plugins/select2-4.1.0-rc.0/dist/js/select2.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('plugins/sweetalert2/sweetalert2.all.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/user-profile-web.js') }}" type="text/javascript"></script>
        <script>
            $(document).ready(function () {
                $(".evt_account_status_modal").click(function (e) { 
                    e.preventDefault();
                    $('#evt_account_status_modal').modal('show');
                });
                $(".profile_tab_row ul li button").click(function (e) {
                    let tab = $(this).attr('data-bs-target');
                    localStorage.setItem("profile_tab", tab);
                });

               
            });

            let selectedProfileTab = localStorage.getItem("profile_tab");
            if(selectedProfileTab){
                $('.profile_tab_row ul li button').removeClass('active');
                let activeTab = document.querySelector(`.profile_tab_row ul li button[data-bs-target="${selectedProfileTab}"]`);
                activeTab.classList.add('active');

                const selectedProfileTabWithoutHash = selectedProfileTab.replace('#', '');
                $('.profile_tab_row .tab-content .tab-pane').removeClass('show active');
                let activeTabContent = document.querySelector(`.profile_tab_row .tab-content .tab-pane[id="${selectedProfileTabWithoutHash}"]`);
                activeTabContent.classList.add('show');
                activeTabContent.classList.add('active');
            }else {
                $('.profile_tab_row ul li button:first').addClass('active');
                $('.profile_tab_row .tab-content .tab-pane:first').addClass('show');
                $('.profile_tab_row .tab-content .tab-pane:first').addClass('active');
            }

            $('#user_profile_attache').change(function() {
                var i = $(this).prev('label').clone();
                var file = $('#user_profile_attache')[0].files[0].name;
                $(this).prev('label').text(file);
            });
        </script>
    @endsection
</x-app-layout>
