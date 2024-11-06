<x-app-admin-layout>
    @section('pageTitle', 'Settings')
    @section('custom_style')
    <style>
        .ck-editor__editable_inline {
            min-height: 350px;
        }
    </style>
    @endsection
    <x-slot name="header">
        <x-header>
            {{ __('Settings') }}
            <x-slot name="right">

            </x-slot>
        </x-header>
    </x-slot>
    <div class="py-2">
        <div class="container-fluid">
            @permission('setting-language')
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('admin.settings.update', $edit) }}" method="POST">
                            <div class="card-body">
                                @csrf
                                @method('PUT')
                                {{--  <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="languages">{{ __('LANGUAGE') }}</label>
                                            <select class="form-control" name="languages" id="languages">
                                                @foreach (config('constants.languages') as $short_code => $language)
                                                    <option data-href="{{ url('locale', $short_code) }}"
                                                        {{ App()->isLocale($short_code) ? 'selected' : '' }}
                                                        value="{{ $short_code }}"> {{ $language }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="form-label" for="gs_amount">Gs. {{ __('Amount') }}</label>
                                        <input type="number" name="gs_amount" id="gs_amount" required class="form-control @error('gs_amount') is-invalid @enderror" value="{!! old('gs_amount',  $edit->gs_amount) !!}">
                                        @error('gs_amount')
                                        <x-error-alert :message="$message" />
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="form-label" for="body-description-en">{{ __('Account Selection') }} En</label>
                                        <textarea name="account_selection_en" id="body-description-en" class="form-control @error('account_selection_en') is-invalid @enderror" rows="6" placeholder="Body">{!! old('account_selection_en',  $edit->account_selection_en) !!}</textarea>
                                        @error('account_selection_en')
                                        <x-error-alert :message="$message" />
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="form-label" for="body-description-es">{{ __('Account Selection') }} Es</label>
                                        <textarea name="account_selection_es" id="body-description-es" class="form-control @error('account_selection_es') is-invalid @enderror" rows="6" placeholder="Body">{!! old('account_selection_es',  $edit->account_selection_es) !!}</textarea>
                                        @error('account_selection_es')
                                        <x-error-alert :message="$message" />
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="form-label" for="body-bank_details-es">{{ __('Bank Details') }}</label>
                                        <textarea name="bank_details" id="body-bank_details-es" class="form-control @error('bank_details') is-invalid @enderror" rows="6" placeholder="Bank Details">{!! old('bank_details',  $edit->bank_details) !!}</textarea>
                                        @error('bank_details')
                                        <x-error-alert :message="$message" />
                                        @enderror
                                    </div>
                                </div>

                                {{--  <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label" for="day_hour">Day / Hour</label>
                                                <input type="number" name="day_hour" id="day_hour" class="form-control @error('day_hour') is-invalid @enderror"  placeholder="day hour" value="{{ old('day_hour', $edit->day_hour) }}" required autofocus>
                                                @error('day_hour')
                                                <x-error-alert :message="$message" />
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label" for="mipo_commission">Mipo Commission</label>
                                                <input type="number" name="mipo_commission" id="mipo_commission" class="form-control @error('mipo_commission') is-invalid @enderror"  placeholder="mipo commission" value="{{ old('mipo_commission', $edit->mipo_commission) }}" required>
                                                @error('mipo_commission')
                                                <x-error-alert :message="$message" />
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label" for="mipo_payment_commission">Mipo Payment Commission</label>
                                                <input type="number" name="mipo_payment_commission" id="mipo_payment_commission" class="form-control @error('mipo_payment_commission') is-invalid @enderror"  placeholder="mipo payment commission" value="{{ old('mipo_payment_commission', $edit->mipo_payment_commission) }}" required>
                                                @error('mipo_payment_commission')
                                                <x-error-alert :message="$message" />
                                                @enderror
                                            </div>
                                        </div>
                                    </div> --}}
                            </div>
                            <div class="card-footer">
                                <div class="row py-2">
                                    <div class="col-md-12">
                                        <x-submit-button class="mr-4">
                                            {{ __('Update') }}
                                        </x-submit-button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endpermission
        </div>
    </div>
    @section('custom_script')
    <script src="{{ asset('plugins/ckeditor5-build-classic/ckeditor.js') }}"></script>
    <script>
    $(function() {
        
        /* $('#languages').change(function(e) {
            e.preventDefault();
            var self = $(this);
            var url_lang = self.find('option:selected').attr('data-href');
            window.location.href = url_lang;
        }); */

        $("textarea[id^='body-']").each(function () {
            let el = $(this).attr('id');
            let key = ($(this).attr('id')).replace('body-', '');
            window['contentEditor'+key] = ClassicEditor
                .create(document.querySelector('#' + el), {
                    toolbar: {
                        items: [
                            'heading', '|',
                            'fontfamily', 'fontsize', '|',
                            'alignment', '|',
                            'fontColor', 'fontBackgroundColor', '|',
                            'bold', 'italic', 'strikethrough', 'underline', 'subscript', 'superscript', '|',
                            'link', '|',
                            'outdent', 'indent', '|',
                            'bulletedList', 'numberedList', /*'todoList',*/ '|',
                            'code', 'codeBlock', '|',
                            'insertTable', '|',
                            'blockQuote', '|',
                            'undo', 'redo',
                            // '|', 'uploadImage'
                        ],
                        shouldNotGroupWhenFull: true,
                    },
                })
                .catch(error => {
                    console.error(error);
                });
        });
    });
    </script>
    @endsection
</x-app-admin-layout>
