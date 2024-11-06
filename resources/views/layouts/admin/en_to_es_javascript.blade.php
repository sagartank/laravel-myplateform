<script>
    // document.oncontextmenu = new Function("return false;")

    var login_user_id = parseInt("{{ Auth::user()->id }}");
    var route_name = ("{{ \Route::currentRouteName() }}");
    var notifications_all_read_url = ("{{ route('notifications-all-read') }}");
    var paco_img = "{{ asset('images/mipo/paco-tour.svg') }}";
    var ays_en_msg = "{{ __('Are you sure?') }}";
    var ays_delete_en_msg = "{{ __('Are you sure, you want to delete this?') }}";
    var yes_delete_en_msg = "{{ __('Yes, delete it!') }}";
    var error_something_en_msg = "{{ __('Something went wrong please try again!') }}";
    var cancel_en_msg = "{{ __('Cancel') }}";
    var repeater_delete_en_msg = "{{ __('Are you sure you want to delete this element?') }}";
    var ays_delete_file_en_msg = "{{ __('Are you sure you want to delete this file?') }}";
    var offer_en_msg = "{{ __('Offer') }}";
    var loadin_en_msg = "{{ __('Loading...') }}";
    var show_less_en_msg = "{{ __('Show less') }}";
    var show_more_en_msg = "{{ __('Show more') }}";
    var offer_cp_en_msg = "{{ __('OFFER') }}";
    var ays_delete_send_offer_en_msg = "{{ __('Are you sure, you want to permanently delete this?') }}";
    var dashboard_risk_in_chart_en_msg = "{{ __('Investments') }}";
    var dashboard_risk__mipo_chart_en_msg = "{{ __('MIPO+ investments') }}";
    var sch_seller_en_msg = "{{ __('Search Seller') }}";
    var sch_payer_en_msg = "{{ __('Search Payer') }}";
    var sch_bank_en_msg = "{{ __('Search Bank') }}";
    var sch_pay_issuer_en_msg = "{{ __('Search Payer Issuers') }}";
    var sch_tag_en_msg = "{{ __('Search Tags') }}";
    var operation_draft_en_msg ="{{ __('You will be redirected to details page.') }}";
    var operation_delete_at_list_one_en_msg = "{{ __('Please select at least one item') }}";
    var apply_en_msg = "{{ __('Apply') }}";
    var cancle_en_msg = "{{ __('Cancel') }}";
    var yes_en_msg = "{{ __('Yes') }}";
    var please_wait_en_msg = "{{ __('Please Wait....') }}";
    var terms_accept_en_msg = "{{ __('Please accept terms & conditions') }}";
    var saving_en_msg = "{{ __('Saving...') }}";
    var submit_en_msg = "{{ __('Submit') }}";
    var aye_status_en_msg = "{{ __('Are you sure, you want to') }}";
    var this_en_msg = "{{ __('this') }}";
    var approved_en_msg = "{{ __('Approved') }}";
    var revert_en_msg = "{{ __('Revert') }}";
    var ays_approve_en_msg = "{{ __('Are you sure, you want to approve this?') }}";
    var ays_revert_en_msg = "{{ __('Are you sure, you want to revert this?') }}";
    var ays_notification_en_msg = "{{ __('Are you sure, you want to read the notification this?') }}";
    var ays_sing_en_msg = "{{ __('Are you sure, you want to sign it?') }}";
    var ays_delete_prm_file_en_msg = "{{ __('Are you sure, you want to permanently delete this?') }}";
</script>

