<x-guest-layout>
    @section('pageTitle', 'Verification IPV') 
    @section('custom_style')
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
    <style>
        img.portimg {
            max-height: 200px;
        }
    </style>
    @endsection

        <div class="user-verification-page user-verification-page-v2">
            <div class="page-logo">
                <a href="javascript:;"><img src="{{ asset('images/logo.svg') }}" alt="mipo" /></a>
            </div>

            <div class="user-block-main">
                <div class="user-block-inners">
                    <div class="user-block-left_form">
                        <div class="user-title">
                            <h5>{{ __('IPV verification') }}</h5>
                            <p>{{ __('Upload Document Image Front and Back') }} <span class="req_star">*</span></p>
                        </div>
                        @include('components.message')
                        <div class="user-form-block">
                            <form action="{{ route('verify.in-person') }}" method="POST" enctype="multipart/form-data" id="verifyInPerson">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                    <div class="upload-photo-block">
                                        <div class="input-row">
                                            <label class="form-label" for="id_proof_image_front">
                                                <i>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                    <rect width="20" height="20" fill="white"/>
                                                    <path d="M12.25 6.99997H12.2575" stroke="#939393" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path d="M3.25 5.49997C3.25 4.90323 3.48705 4.33094 3.90901 3.90898C4.33097 3.48702 4.90326 3.24997 5.5 3.24997H14.5C15.0967 3.24997 15.669 3.48702 16.091 3.90898C16.5129 4.33094 16.75 4.90323 16.75 5.49997V14.5C16.75 15.0967 16.5129 15.669 16.091 16.091C15.669 16.5129 15.0967 16.75 14.5 16.75H5.5C4.90326 16.75 4.33097 16.5129 3.90901 16.091C3.48705 15.669 3.25 15.0967 3.25 14.5V5.49997Z" stroke="#939393" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path d="M3.25 13L7 9.24999C7.696 8.58024 8.554 8.58024 9.25 9.24999L13 13" stroke="#939393" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path d="M11.5 11.5L12.25 10.75C12.946 10.0802 13.804 10.0802 14.5 10.75L16.75 13" stroke="#939393" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>

                                                </i>
                                            {{ __('Upload Photo of the Front of the Document') }}</label>
                                            <div class="input-group upload_input">
                                                <input class="form-control @error('id_proof_image_front') is-invalid @enderror fileUpload" type="file" multiple id="id_proof_image_front" name="id_proof_image_front[]" accept="image/jpeg, image/jpg" required>
                                            </div>
                                            <div class= "place-holder-btn">
                                                <div class="placeholder-img"  id="placeholder-img-wrap-front" >
                                                    <img src="#" id="placeholder-img" class="portimg" style="display: none"> 
                                                </div>
                                                
                                            </div>
                                            
                                        </div>
                                    </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="upload-photo-block">
                                            <div class="input-row">
                                                <label class="form-label" for="id_proof_image_backend">
                                                <i>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                    <rect width="20" height="20" fill="white"/>
                                                    <path d="M12.25 6.99997H12.2575" stroke="#939393" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path d="M3.25 5.49997C3.25 4.90323 3.48705 4.33094 3.90901 3.90898C4.33097 3.48702 4.90326 3.24997 5.5 3.24997H14.5C15.0967 3.24997 15.669 3.48702 16.091 3.90898C16.5129 4.33094 16.75 4.90323 16.75 5.49997V14.5C16.75 15.0967 16.5129 15.669 16.091 16.091C15.669 16.5129 15.0967 16.75 14.5 16.75H5.5C4.90326 16.75 4.33097 16.5129 3.90901 16.091C3.48705 15.669 3.25 15.0967 3.25 14.5V5.49997Z" stroke="#939393" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path d="M3.25 13L7 9.24999C7.696 8.58024 8.554 8.58024 9.25 9.24999L13 13" stroke="#939393" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path d="M11.5 11.5L12.25 10.75C12.946 10.0802 13.804 10.0802 14.5 10.75L16.75 13" stroke="#939393" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>

                                                </i>
                                                {{ __('Upload Photo of the Back of the Document') }}</label>
                                                <div class="input-group upload_input">
                                                    <input class="form-control @error('id_proof_image_backend') is-invalid @enderror fileUpload" type="file" multiple id="id_proof_image_backend" name="id_proof_image_backend[]" accept="image/jpeg, image/jpg" required>
                                                </div>
                                                <div class="place-holder-btn">
                                                    <div class="placeholder-img" id="placeholder-img-wrap-backend" > 
                                                        <img src="#" id="placeholder-img" class="portimg" style="display: none">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="dropzone" id="documentFrontSide">
                                        <div class="dz-message">
                                                <span class="d-block h5 mb-1">Upload Document Image Front and Back</span>
                                        </div>
                                    </div>
                                    <div class="dropzone--front-previews div-table"></div>
                                    <div id="preview-template-front-side" style="display: none;">
                                        <div class="dz-preview dz-file-preview div-tr">
                                            <div class="dz-details">
                                                <div class="dz-filename div-td"><span data-dz-name></span></div>
                                                <div class="dz-size div-td" data-dz-size></div>
                                                <div class="dz-image div-td">
                                                    <img data-dz-thumbnail />
                                                </div>
                                            </div>
                                            <div class="dz-progress div-td"><span class="dz-upload" data-dz-uploadprogress></span></div>
                                            <div class="div-td">
                                                <div class="dz-success-mark"><span>✔</span></div>
                                                <div class="dz-error-mark"><span>✘</span></div>
                                            </div>
                                            <a href="#!" data-dz-remove class="btn-floating ph red white-text waves-effect waves-light"><i class="material-icons white-text">clear</i></a>
                                            <div class="dz-error-message div-td"><span data-dz-errormessage></span></div>
                                        </div>
                                    </div>
                                    </br>
                                    <div class="dropzone" id="documentBackSide">
                                        <div class="dz-message">
                                                <span class="d-block h5 mb-1">
                                                    {!! __('Upload Document Image Front and Back') }}</span>
                                        </div>
                                    </div>
                                    <div class="dropzone-back-previews div-table"></div>

                                    <div id="preview-template-back-side" style="display: none;">
                                        <div class="dz-preview dz-file-preview div-tr">
                                            <div class="dz-details">
                                                <div class="dz-filename div-td"><span data-dz-name></span></div>
                                                <div class="dz-size div-td" data-dz-size></div>
                                                <div class="dz-image div-td">
                                                    <img data-dz-thumbnail />
                                                </div>
                                            </div>
                                            <div class="dz-progress div-td"><span class="dz-upload" data-dz-uploadprogress></span></div>
                                            <div class="div-td">
                                                <div class="dz-success-mark"><span>✔</span></div>
                                                <div class="dz-error-mark"><span>✘</span></div>
                                            </div>
                                            <a href="#!" data-dz-remove class="btn-floating ph red white-text waves-effect waves-light"><i class="material-icons white-text">clear</i></a>
                                            <div class="dz-error-message div-td"><span data-dz-errormessage></span></div>
                                        </div>
                                    </div> --}}
                                    <div class="col-md-12">
                                        <div class="btnbox_wrap">
                                            <div class="box">
                                                <input class="btn-secondary" type="submit" value="{{ __('Continue') }}">
                                                <i><img src="{{asset('images/mipo/user-verifyleft.svg')}}" alt="mipo"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="user-block-right-box">
                        <div class="user-block-right-inner">
                            <div class="user_block_right_top">
                                <h3>{!! __('Download our App') !!}</h3>
                                <p>{!! __('Desktop and Mobile Available') !!}</p>
                                <div class="icon_apps">
                                    <ul>
                                        <li><a href="javascript:;"><img src="{{ asset('images/marketing/Microsoft.svg') }}" alt="microsoft"></a></li>
                                        <li><a href="javascript:;"><img src="{{ asset('images/marketing/Apple.svg') }}" alt="apple"></a></li>
                                        <li><a href="javascript:;"><img src="{{ asset('images/marketing/chrome.svg') }}" alt="chrome"></a></li>
                                        <li><a href="javascript:;"><img src="{{ asset('images/marketing/android.svg') }}" alt="android"></a></li>
                                        <li><a href="javascript:;"><img src="{{ asset('images/marketing/firefox.svg') }}" alt="firefox"></a></li>
                                        <li><a href="javascript:;"><img src="{{ asset('images/marketing/safari.svg') }}" alt="safari"></a></li>
                                    </ul>
                                </div>
                                <div class="webapp_btn">
                                    <a href="javascript:;" id="regweb_trigger">
                                        <img src="{{asset('images/webapp-icon.png')}}" alt="mipo">
                                    </a>
                                </div>
                            </div>
                            <div class="mipo_viewer_bottom">
                                <img src="{{asset('images/mipo-viwer.png')}}" alt="mipo">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class= "mipo_sa">
                <p>{!! __(Config::get('constants.COPY_RIGHT')) !!}</p>
            </div>
        </div>

    @section('custom_script')
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
   <script>       
        function readURL() {
            var $input = $(this);
            var $newinput =  $(this).parent().parent().parent().find('.portimg ');
            if (this.files && this.files[0]) {
                let filetype = this.files[0].type;
                var extention = this.files[0].name.split('.').pop();
                 console.log(extention);
                var reader = new FileReader();
                reader.onload = function (e) {
                    reset($newinput.next('.delbtn'), true);
                    if(filetype == 'application/pdf' || filetype == 'text/plain' || filetype == 'text/plain' || extention == 'csv' || extention == 'xlsx'){
                        $newinput.attr('src', '/images/mipo/pdf.png').show();
                    }else{
                        $newinput.attr('src', e.target.result).show();
                    }
                    $newinput.after('<div class = "del_btn"><button type="button" class="delbtn removebtn"><svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11.055 6.74999L10.7955 13.5M7.2045 13.5L6.945 6.74999M14.421 4.34249C14.6775 4.38149 14.9325 4.42274 15.1875 4.46699M14.421 4.34324L13.62 14.7547C13.5873 15.1787 13.3958 15.5746 13.0838 15.8634C12.7717 16.1522 12.3622 16.3126 11.937 16.3125H6.063C5.63782 16.3126 5.22827 16.1522 4.91623 15.8634C4.6042 15.5746 4.41269 15.1787 4.38 14.7547L3.579 4.34249M14.421 4.34249C13.5554 4.21163 12.6853 4.11232 11.8125 4.04474M2.8125 4.46624C3.0675 4.42199 3.3225 4.38074 3.579 4.34249M3.579 4.34249C4.4446 4.21163 5.31468 4.11232 6.1875 4.04474M11.8125 4.04474V3.35774C11.8125 2.47274 11.13 1.73474 10.245 1.70699C9.41521 1.68047 8.58479 1.68047 7.755 1.70699C6.87 1.73474 6.1875 2.47349 6.1875 3.35774V4.04474M11.8125 4.04474C9.94029 3.90005 8.05971 3.90005 6.1875 4.04474" stroke="#DC3545" stroke-linecap="round" stroke-linejoin="round"/></svg></button> </div>');
                }
                reader.readAsDataURL(this.files[0]);
            }
        }
        $(".fileUpload").change(readURL);
        $("form").on('click', '.delbtn', function (e) {
            reset($(this));
        });

        function reset(elm, prserveFileName) {
            if (elm && elm.length > 0) {
                var $input = elm;
                
                // $input.prev('.portimg').attr('src', '').hide();
                $input.parents('.placeholder-img').find('.portimg').attr('src', '').hide();
                if (!prserveFileName) {
                    $($input).parents('.input-row').find('input.fileUpload ').val("");
                    //input.fileUpload and input#uploadre both need to empty values for particular div
                }
                elm.remove();
            }
        }
        
   </script>
    @endsection
</x-guest-layout>   