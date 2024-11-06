<div class="modal fade" id="suggest_more_info_modal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalToggleLabel">{{ __('Suggest More Info') }}</h5>
                <button type="button" class="btn-close close_modal" data-form-name="#form_suggest_more_info" data-modal-name="#suggest_more_info_modal"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3 form-validation" name="form_suggest_more_info" action="{{route('suggestion.store')}}" id="form_suggest_more_info" method="post" autocomplete="off" novalidate="novalidate" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="company_id" id="company_id" value="{{$company_id}}"/>
                    <input type="hidden" name="profile_id" id="profile_id" value="{{$profile_id}}"/>
                    <input type="hidden" name="suggest_type" id="suggest_type" value="{{$suggest_type}}"/>
                    <div class="col-md-6">
                        <label for="first_name" class="form-label">{{ __('First Name') }}</label>
                        <input type="text" class="form-control" id="first_name" minlength="3" name="first_name" required>
                    </div>
                    <div class="col-md-6">
                        <label for="last_name" class="form-label">{{ __('Last Name') }}</label>
                        <input type="text" class="form-control" id="last_name"  minlength="3" name="last_name" required>
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">{{ __('Email') }}</label>
                        <input type="email" class="form-control" id="email" minlength="3" name="email" required>
                    </div>
                    <div class="col-md-6">
                        <label for="phone_number" class="form-label">{{ __('Phone Number') }}</label>
                        <input type="text" class="form-control" id="phone_number" minlength="10" name="phone_number">
                    </div>
                    <div class="col-12">
                        <label for="message" class="form-label">{{ __('Message') }}</label>
                        <textarea style="height: 100px" class="form-control" minlength="5" name="message" id="message" required></textarea>
                    </div>
                    <div class="col-12">
                        <input type="submit" class="btn btn-primary" name="send" value="{{ __('Send')}}"/>
                        <button type="button" class="btn btn-secondary close_modal" data-form-name="#form_suggest_more_info" data-modal-name="#suggest_more_info_modal">{{ __('Close')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>