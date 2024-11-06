<x-app-admin-layout>
    @section('pageTitle', 'Plan Edit')
@section('custom_style')
@endsection
    <x-slot name="header">
        <x-header>
            {{ __('Edit Plan ( '.$plan->name.' )') }}
            <x-slot name="right"></x-slot>
        </x-header>
    </x-slot>

    <div class="py-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('admin.plans.update', $plan) }}" method="POST">
                            <div class="card-body">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="name">Name</label>
                                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Name" value="{{ old('name', $plan->name) }}" required autofocus>
                                            @error('name')
                                                <x-error-alert :message="$message" />
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="price">Price</label>
                                            <input type="text" name="price" id="price" class="form-control @error('price') is-invalid @enderror" placeholder="Price" value="{{ old('price', $plan->price) }}" required autofocus>
                                            @error('price')
                                                <x-error-alert :message="$message" />
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="offer_price">Offer Price</label>
                                            <input type="text" name="offer_price" id="offer_price" class="form-control @error('offer_price') is-invalid @enderror" placeholder="Offer Price" value="{{ old('offer_price', $plan->offer_price) }}" required autofocus>
                                            @error('offer_price')
                                                <x-error-alert :message="$message" />
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="duration">Duration</label>
                                            <select name="duration" id="duration" class="form-control">
                                                <option value="">Select</option>
                                                <option value="month" @if($plan->duration == 'month') selected @endif>Month</option>
                                                <option value="year" @if($plan->duration == 'year') selected @endif>Year</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="sort_order">Sort Order</label>
                                            <input type="number" name="sort_order" id="sort_order" class="form-control @error('sort_order') is-invalid @enderror" placeholder="Sort Order" value="{{ old('sort_order', $plan->sort_order) }}" required autofocus>
                                            @error('sort_order')
                                                <x-error-alert :message="$message" />
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="sort_order">Status</label>
                                            <div class="form-check">
                                            <input class="form-check-input" type="radio" name="is_active" id="is_active_yes" value="1" @if($plan->is_active == '1') checked @endif>
                                            <label class="form-check-label" for="is_active_yes">Yes</label>
                                            </div>
                                            <div class="form-check">
                                            <input class="form-check-input" type="radio" name="is_active" id="is_active_no" value="0" @if($plan->is_active == '0') checked @endif>
                                            <label class="form-check-label" for="is_active_no">No</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="is_free_plan">Is Free ?</label>
                                            <select name="is_free_plan" id="is_free_plan" class="form-control">
                                                <option value="">Select</option>
                                                <option value="1" @if($plan->is_free_plan == '1') selected @endif>Yes</option>
                                                <option value="0" @if($plan->is_free_plan == '0') selected @endif>No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="suitable_for_account_type">Suitable for Account Type ? </label>
                                            <select name="suitable_for_account_type" id="suitable_for_account_type" class="form-control">
                                                <option value="">Select</option>
                                                <option value="Individual" @if($plan->suitable_for_account_type == 'Individual') selected @endif>Individual</option>
                                                <option value="Enterprise" @if($plan->suitable_for_account_type == 'Enterprise') selected @endif>Enterprise</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="suitable_for_account_opener">Suitable for Account Opener?</label>
                                            <select name="suitable_for_account_opener" id="suitable_for_account_opener" class="form-control">
                                                <option value="">Select</option>
                                                <option value="Borrower" @if($plan->suitable_for_account_opener == 'Borrower') selected @endif>As Borrower</option>
                                                <option value="Investor" @if($plan->suitable_for_account_opener == 'Investor') selected @endif>As Investor</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="user_level_id">User Level</label>
                                            <select name="user_level_id" id="user_level_id" class="form-control">
                                                <option value="">Select</option>
                                                @foreach($userLevels as $level)
                                                <option value="{{$level->id}}" @if($plan->user_level_id == $level->id) selected @endif>{{$level->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-3 col-form-label">Buy & Sell</label>
                                    <div class="col-sm-9">
                                        <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="buy_sell" id="buy_sell_yes" value="yes" @if($plan->is_active == 'yes') checked @endif>
                                        <label class="form-check-label" for="buy_sell_yes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="buy_sell" id="buy_sell_no" value="no" @if($plan->is_active == 'no') checked @endif>
                                        <label class="form-check-label" for="buy_sell_no">No</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-3 col-form-label">Basic Dashboard</label>
                                    <div class="col-sm-9">
                                        <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="basic_dashboard" id="basic_dashboard_yes" value="yes" @if($plan->basic_dashboard == 'yes') checked @endif>
                                        <label class="form-check-label" for="basic_dashboard_yes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="basic_dashboard" id="basic_dashboard_no" value="no" @if($plan->basic_dashboard == 'no') checked @endif>
                                        <label class="form-check-label" for="basic_dashboard_no">No</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-3 col-form-label">Enterprise Dashboard</label>
                                    <div class="col-sm-9">
                                        <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="enterprise_dashboard" id="enterprise_dashboard_yes" value="yes" @if($plan->enterprise_dashboard == 'yes') checked @endif>
                                        <label class="form-check-label" for="enterprise_dashboard_yes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="enterprise_dashboard" id="enterprise_dashboard_no" value="no" @if($plan->enterprise_dashboard == 'no') checked @endif>
                                        <label class="form-check-label" for="enterprise_dashboard_no">No</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="multi_user_account" class="col-sm-3 col-form-label">Multi User Account</label>
                                    <div class="col-sm-3">
                                        <input type="number" name="multi_user_account" id="multi_user_account" class="form-control @error('multi_user_account') is-invalid @enderror" placeholder="1, 5, 10, ..." value="{{ $plan->multi_user_account }}" required autofocus>
                                            @error('multi_user_account')
                                                <x-error-alert :message="$message" />
                                            @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-3 col-form-label">Exportable PDF</label>
                                    <div class="col-sm-9">
                                        <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="exportable_pdf" id="exportable_pdf_yes" value="yes" @if($plan->exportable_pdf == 'yes') checked @endif>
                                        <label class="form-check-label" for="exportable_pdf_yes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="exportable_pdf" id="exportable_pdf_no" value="no" @if($plan->exportable_pdf == 'no') checked @endif>
                                        <label class="form-check-label" for="exportable_pdf_no">No</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-3 col-form-label">Offer Notifications</label>
                                    <div class="col-sm-9">
                                        <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="offer_notifications" id="offer_notifications_yes" value="yes" @if($plan->offer_notifications == 'yes') checked @endif>
                                        <label class="form-check-label" for="offer_notifications_yes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="offer_notifications" id="offer_notifications_no" value="no" @if($plan->offer_notifications == 'no') checked @endif>
                                        <label class="form-check-label" for="offer_notifications_no">No</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-3 col-form-label">Legal Advice</label>
                                    <div class="col-sm-9">
                                        <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="legal_advice" id="legal_advice_yes" value="payable" @if($plan->legal_advice == 'payable') checked @endif>
                                        <label class="form-check-label" for="legal_advice_yes">Payable</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="legal_advice" id="legal_advice_no" value="free" @if($plan->legal_advice == 'free') checked @endif>
                                        <label class="form-check-label" for="legal_advice_no">Free</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-3 col-form-label">Monthly Reports</label>
                                    <div class="col-sm-9">
                                        <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="monthly_reports" id="monthly_reports_yes" value="yes" @if($plan->monthly_reports == 'yes') checked @endif>
                                        <label class="form-check-label" for="monthly_reports_yes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="monthly_reports" id="monthly_reports_no" value="no" @if($plan->monthly_reports == 'no') checked @endif>
                                        <label class="form-check-label" for="monthly_reports_no">No</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-3 col-form-label">Newsletters</label>
                                    <div class="col-sm-9">
                                        <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="newsletters" id="newsletters_yes" value="yes" @if($plan->newsletters == 'yes') checked @endif>
                                        <label class="form-check-label" for="newsletters_yes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="newsletters" id="newsletters_customizable" value="customizable" @if($plan->newsletters == 'customizable') checked @endif>
                                        <label class="form-check-label" for="newsletters_customizable">Customizable</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-3 col-form-label">Investor Commission</label>
                                    <div class="col-sm-3">
                                        <input type="number" name="investor_commission" id="investor_commission" class="form-control @error('investor_commission') is-invalid @enderror" placeholder="10%, 20%, 30%,..." value="{{ $plan->investor_commission }}" required autofocus>
                                            @error('investor_commission')
                                                <x-error-alert :message="$message" />
                                            @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-3 col-form-label">Mipo+ Commission</label>
                                    <div class="col-sm-3">
                                        <input type="number" name="mipo_commission" id="mipo_commission" class="form-control @error('mipo_commission') is-invalid @enderror" placeholder="1%, 2%,..." value="{{ $plan->mipo_commission }}" required autofocus>
                                            @error('mipo_commission')
                                                <x-error-alert :message="$message" />
                                            @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row py-2">
                                    <div class="col-md-12">
                                        <x-submit-button class="mr-4">
                                            {{ __('Submit') }}
                                        </x-submit-button>
                                        <a href="{{ route('admin.plans.index') }}">
                                            <button type="button" class="btn waves-effect waves-light btn-outline-dark rounded-md">Cancel</button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@section('custom_script')
@endsection
</x-app-admin-layout>
