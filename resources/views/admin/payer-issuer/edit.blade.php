<x-app-admin-layout>
    @section('pageTitle', 'Payer Issuer Edit')
    @section('custom_style')
    <link href="{{ asset('plugins/fancybox/fancybox.css') }}" rel="stylesheet">
    <style>
        .ck-editor__editable_inline {
            min-height: 250px;
        }
    </style>
    @endsection
    <x-slot name="header">
        <x-header>
            {{ __('Edit Payer Issuer') }}
            <x-slot name="right">
                <a href="{{ route('admin.payer-issuer.index') }}">
                    <button type="button" class="btn btn-sm btn-dark">{{ __('Back') }}</button>
                </a>
            </x-slot>
        </x-header>
    </x-slot>
    @include('components.message')
    <div class="py-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('admin.payer-issuer.update', $edit) }}" name="edit_payer_form" id="edit_payer_form" enctype="multipart/form-data" method="post">
                            <div class="card-body">
                                @csrf
                                @method('put')
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="first_name">{{ __('First Name') }}</label>
                                            <input type="text" name="first_name" id="first_name"
                                                class="form-control @error('name') is-invalid @enderror"
                                                placeholder="{{ __('First Name') }}" value="{{ old('first_name', $edit->first_name) }}">
                                            @error('name')
                                                <x-error-alert :message="$message" />
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="last_name">{{ __('Last Name') }}</label>
                                            <input type="text" name="last_name" id="last_name"
                                                class="form-control @error('last_name') is-invalid @enderror"
                                                placeholder="Last Name" value="{{ old('last_name', $edit->last_name) }}">
                                            @error('last_name')
                                                <x-error-alert :message="$message" />
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label class="form-label"
                                                for="company_name">{{ __('Company Name') }}</label>
                                            <input type="text" name="company_name" id="company_name"
                                                class="form-control @error('company_name') is-invalid @enderror"
                                                placeholder="{{ __('Company Name') }}"
                                                value="{{ old('company_name', $edit->company_name) }}">
                                            @error('company_name')
                                                <x-error-alert :message="$message" />
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="industry_type">{{ __('Industry Type') }}</label>
                                            <input type="text" name="industry_type" id="name"
                                                class="form-control @error('industry_type') is-invalid @enderror"
                                                placeholder="{{ __('Industry Type') }}" value="{{ old('industry_type') }}">
                                            @error('industry_type')
                                                <x-error-alert :message="$message" />
                                            @enderror
                                        </div>
                                    </div> --}}
                                    {{-- <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="tradename">{{ __('Trade Name') }}</label>
                                            <input type="text" name="tradename" id="name"
                                                class="form-control @error('tradename') is-invalid @enderror"
                                                placeholder="{{ __('Trade Name') }}" value="{{ old('tradename', $edit->tradename) }}">
                                            @error('tradename')
                                                <x-error-alert :message="$message" />
                                            @enderror
                                        </div>
                                    </div> --}}
                                    <div class="col-md-3">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="ruc_text_id">{{ __('RUC') }}</label>
                                            <input type="text" name="ruc_text_id" id="ruc_text_id"
                                                class="form-control @error('ruc_text_id') is-invalid @enderror"
                                                placeholder="{{ __('RUC') }}" value="{{ old('ruc_text_id', $edit->ruc_text_id) }}">
                                            @error('ruc_text_id')
                                                <x-error-alert :message="$message" />
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="ruc_code_optional">{{ __('RUC Code') }}</label>
                                            <input type="text" name="ruc_code_optional" id="ruc_code_optional"
                                                class="form-control @error('ruc_code_optional') is-invalid @enderror"
                                                placeholder="{{ __('RUC Code') }}" value="{{ old('ruc_code_optional',  $edit->ruc_code_optional) }}">
                                            @error('ruc_code_optional')
                                                <x-error-alert :message="$message" />
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4 mt-4">
                                        <label class="form-label" for="mipo_verified_y">{{ __('Mipo Verified') }}</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" {{ ($edit->registry_in_mipo == 'Yes') ? 'checked' : ''}}  type="radio" name="registry_in_mipo" id="mipo_verified_y" value="Yes">
                                            <label class="form-check-label" for="mipo_verified_y">{{ __('Yes')}}</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" {{ ($edit->registry_in_mipo == 'No') ? 'checked' : ''}} type="radio" name="registry_in_mipo" id="mipo_verified_n" value="No">
                                            <label class="form-check-label" for="mipo_verified_n">{{ __('No')}}</label>
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="gender">{{ __('Gender') }}</label>
                                            <select name="gender" id="gender"
                                                class="form-control @error('gender') is-invalid @enderror">
                                                <option value=""> {{ __('Select Gender') }}</option>
                                                <option value="Male">
                                                    {{ __('Male') }}</option>
                                                <option 
                                                    value="Female">{{ __('Female') }}</option>
                                                <option
                                                    value="Other">{{ __('Other') }}</option>
                                            </select>
                                            @error('gender')
                                                <x-error-alert :message="$message" />
                                            @enderror
                                        </div>
                                    </div> --}}
                                  {{--   <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="marital_status">{{ __('Marital status') }}</label>
                                            <select name="marital_status" id="marital_status"
                                                class="form-control @error('marital_status') is-invalid @enderror">
                                                <option value=""> {{ __('Select Marital') }}</option>
                                                @foreach ($marital_status as $marital_status_val)
                                                <option  {{ ($edit->marital_status == $marital_status_val) ? 'selected' : ''}} value="{{ $marital_status_val }}"> {{ $marital_status_val }}</option>
                                                @endforeach
                                            </select>
                                            @error('marital_status')
                                                <x-error-alert :message="$message" />
                                            @enderror
                                        </div>
                                    </div> --}}
                                {{--  <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="country_id">{{ __('Country') }}</label>
                                            <select name="country_id" id="country_id"
                                                class="form-control @error('country_id') is-invalid @enderror">
                                                <option value=""> {{ __('Select Country') }}</option>
                                                @if ($countries)
                                                    @foreach ($countries as $country)
                                                        <option
                                                            value="{{ $country->id }}">{{ $country->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @error('country_id')
                                                <x-error-alert :message="$message" />
                                            @enderror
                                        </div>
                                    </div> --}}
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="city_name">{{ __('City Name') }}</label>
                                            <select class="form-select @error('city') is-invalid @enderror" id="city_name" name="city_name" required>
                                                <option value="">{{ __('Select a city') }}</option>
                                                @foreach($cities as $city)
                                                    <option {{ ($edit->city_id == $city->id) ? 'selected' : ''}} value="{{ $city->id }}">{{ $city->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('city_name')
                                                <x-error-alert :message="$message" />
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label class="form-label"
                                                for="registered_at">{{ __('Registered') }}</label>
                                            <input type="date" name="registered_at" id="registered_at"
                                                class="form-control @error('registered_at') is-invalid @enderror"
                                                placeholder="Registered" value="{{ $edit->registered_at }}" max="{{ date('d-m-Y') }}"/>
                                            @error('registered_at')
                                                <x-error-alert :message="$message" />
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="issuers_image">{{ __('Porfile Image') }}</label>
                                            <input type="file" name="issuers_image"  id="issuers_image" class="form-control  @error('issuers_image') is-invalid @enderror"/>
                                            @error('issuers_image')
                                                <x-error-alert :message="$message" />
                                            @enderror
                                        </div>
                                        @if (!empty($edit->issuers_image))
                                        <img width="100" src="{{ route('secure-image', Crypt::encryptString($edit->issuers_image)) }}"  alt="mipo" class="img-fluid img-thumbnail rounded mt-2"  data-fancybox role="button"/>
                                        @endif
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="commercial_name">{{ __('Commercial Name') }}</label>
                                            <input type="text" name="commercial_name" id="commercial_name" class="form-control @error('commercial_name') is-invalid @enderror"  placeholder="{{ __('Commercial Name') }}" value="{{  $edit->commercial_name }}"/>
                                            @error('commercial_name')
                                                <x-error-alert :message="$message" />
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="address">{{ __('Address') }}</label>
                                            <textarea name="address" id="address" class="form-control @error('address') is-invalid @enderror" rows="6" placeholder="{{ __('Address') }}">{{  $edit->address }}</textarea>
                                            @error('address')
                                                <x-error-alert :message="$message" />
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4 mt-4">
                                        <label class="form-label" for="verified_address_y">{{ __('Address Verified') }}</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" {{ ($edit->verified_address == 'Yes') ? 'checked' : ''}}    name="verified_address" id="verified_address_y" value="Yes">
                                            <label class="form-check-label" for="verified_address_y">{{ __('Yes')}}</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" {{ ($edit->verified_address == 'No') ? 'checked' : ''}} name="verified_address" id="verified_address_n" value="No">
                                            <label class="form-check-label" for="verified_address_n">{{ __('No')}}</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label class="form-label"for="heading"> {{ __('Heading') }}</label>
                                            <input type="text" name="heading" id="heading" class="form-control @error('heading') is-invalid @enderror" value="{{ $edit->heading }}">
                                            @error('heading')
                                                <x-error-alert :message="$message" />
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="body-basic_info">{{ __('Basic Information') }}</label>
                                            <textarea name="basic_info" id="body-basic_info" class="form-control @error('basic_info') is-invalid @enderror" rows="6"
                                                placeholder="{{ __('Basic Information') }}">
                                                {!!  $edit->address !!}
                                            </textarea>
                                            @error('basic_info')
                                                <x-error-alert :message="$message" />
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="body-additional_info">{{ __('Additional Information') }}</label>
                                            <textarea name="additional_info" id="body-additional_info" class="form-control @error('additional_info') is-invalid @enderror" rows="6" placeholder="{{ __('Additional Information') }}">
                                                {!!  $edit->additional_info !!}
                                            </textarea>
                                            @error('additional_info')
                                                <x-error-alert :message="$message" />
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="issuers_attach_images">{{ __('Attach Image') }}</label>
                                            <input type="file" name="issuers_attach_images[]" multiple id="issuers_attach_images" class="form-control  @error('issuers_attach_images') is-invalid @enderror"/>
                                            @error('issuers_attach_images')
                                                <x-error-alert :message="$message" />
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                @if(isset($edit->issuers_attach_images) && $edit->issuers_attach_images->count() > 0)
                                                    @foreach ($edit->issuers_attach_images as $val)
                                                        @if($val->path!='')
                                                            @php
                                                                $file_ext = strtolower($val->extension);
                                                            @endphp
                                                            @if($file_ext == 'pdf' && $val->path!='')
                                                                <div class="form-check form-check-inline div-remove-image" role="button">
                                                                    <a href="{{ $val->path ? route('secure-pdf', Crypt::encryptString($val->path)) : '#' }}" target="_blank">
                                                                        <img width="100" src="{{ asset('images/mipo/pdf.png') }}" alt="mipo" class="img-fluid img-thumbnail rounded mt-2">
                                                                    </a>
                                                                    <img role="button" class="center-block d-block mx-auto delete-image pt-2" data-href="{{route('admin.payer-issuer.ajax-delete-issuer-attach-image', $val->slug)}}" title="Delete" src="{{ asset('/images/delete-icon.svg') }}"/>
                                                                </div>
                                                            @else
                                                                <div class="form-check form-check-inline div-remove-image" role="button">
                                                                    <img width="100" src="{{ $val->path ? route('secure-image', Crypt::encryptString($val->path)) : '#' }}" alt="mipo" class="img-fluid img-thumbnail rounded mt-2"  data-fancybox>
                                                                    <img role="button" class="center-block d-block mx-auto delete-image pt-2" data-href="{{route('admin.payer-issuer.ajax-delete-issuer-attach-image', $val->slug)}}" title="Delete" src="{{ asset('/images/delete-icon.svg') }}"/>
                                                                </div>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <fieldset>
                                        <hr>
                                        <legend>{{ __('Types of Process') }}</legend>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="bcp">{{ __('BCP Status') }}</label>
                                                    <select name="bcp" id="bcp" class="form-control">
                                                        <option value="0">{{ __('N/A') }}</option>
                                                        <option {{ ($edit->bcp=="1")? "selected" : "" }} value="1">{{ __('Yes') }}</option>
                                                        <option {{ ($edit->bcp=="2")? "selected" : "" }} value="2">{{ __('No') }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="inforconf">{{ __('Inforconf Status') }}</label>
                                                    <select name="inforconf" id="inforconf" class="form-control">
                                                        <option value="0">{{ __('N/A') }}</option>
                                                        <option {{ ($edit->inforconf=="1")? "selected" : "" }} value="1">{{ __('Yes') }}</option>
                                                        <option {{ ($edit->inforconf=="2")? "selected" : "" }}  value="2">{{ __('No') }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="infocheck">{{ __('Infocheck Status') }}</label>
                                                    <select name="infocheck" id="infocheck" class="form-control">
                                                        <option value="0">{{ __('N/A') }}</option>
                                                        <option {{ ($edit->infocheck=="1")? "selected" : "" }} value="1">{{ __('Yes') }}</option>
                                                        <option {{ ($edit->infocheck=="2")? "selected" : "" }} value="2">{{ __('No') }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="criterium">{{ __('Criterium Status') }}</label>
                                                    <select name="criterium" id="criterium" class="form-control">
                                                        <option value="0">{{ __('N/A') }}</option>
                                                        <option {{ ($edit->criterium=="1")? "selected" : "" }} value="1">{{ __('Yes') }}</option>
                                                        <option {{ ($edit->criterium=="2")? "selected" : "" }} value="2">{{ __('No') }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        </fieldset>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row py-2">
                                    <div class="col-md-12">
                                        <x-submit-button class="mr-4">
                                            {{ __('Update') }}
                                        </x-submit-button>
                                        <a href="{{ route('admin.payer-issuer.index') }}">
                                            <button type="button"
                                                class="btn waves-effect waves-light btn-outline-dark rounded-md">{{ __('Cancel') }}</button>
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
        <script src="{{ asset('plugins/ckeditor5-build-classic/ckeditor.js') }}"></script>
        <script src="{{ asset('plugins/fancybox/fancybox.umd.js') }}"></script>
        <script>
            $(function() {
                $("textarea[id^='body-']").each(function() {
                    let el = $(this).attr('id');
                    let key = ($(this).attr('id')).replace('body-', '');
                    window['contentEditor' + key] = ClassicEditor
                        .create(document.querySelector('#' + el), {
                            toolbar: {
                                items: [
                                    'heading', '|',
                                    'fontfamily', 'fontsize', '|',
                                    'alignment', '|',
                                    'fontColor', 'fontBackgroundColor', '|',
                                    'bold', 'italic', 'strikethrough', 'underline', 'subscript',
                                    'superscript', '|',
                                    'link', '|',
                                    'outdent', 'indent', '|',
                                    'bulletedList', 'numberedList', /*'todoList',*/ '|',
                                    'code', 'codeBlock', '|',
                                    'insertTable', '|',
                                    'blockQuote', '|',
                                    'undo', 'redo'
                                ],
                                shouldNotGroupWhenFull: true,
                            },
                        })
                        .catch(error => {
                            console.error(error);
                        });
                });

                $('.delete-image').click(function(e){
                Swal.fire({
                title: 'Are you sure?',
                text: "Are you sure, you want to delete this?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#13153B',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const self = $(this);
                        const url_link = self.attr('data-href');
                        $.ajax({
                            type: 'GET',
                            url: url_link,
                            dataType: 'json',
                            success: function (res) {
                                if(res.status == true){
                                    toastr.success(res.message);
                                    self.parent('.div-remove-image').remove();
                                    Swal.fire(
                                        'Deleted!',
                                        'Your file has been deleted.',
                                        'success'
                                    )
                                }
                            },
                            error: function (data) {
                                toastr.error('something went wrong please try again!');
                                console.log(data);
                            }
                        });
                    }
                });
            });
            
            });
        </script>
    @endsection
</x-app-admin-layout>
