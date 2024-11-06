<x-guest-layout>
    @section('custom_style')
<style>
    #ipv_image_preview {
        width: 100%;
        height: 100%;
        object-fit: cover;
        position: absolute;
        top: 0;
        left: 0;
    }

    .camera_final_btn [type="button"]:not(:disabled), 
    .camera_final_btn [type="reset"]:not(:disabled), 
    .camera_final_btn [type="submit"]:not(:disabled), 
    .camera_final_btn button:not(:disabled) {
        height: 40px; 
        padding: 0 18px; 
        color: #0D6EFD;
        font-size: 16px;
        font-weight: 500;
        border-radius:4px;
        background-color: #EEF8FF;
        border: none;
 }
    .camera_final_btn [type="button"]:not(:disabled):hover, 
    .camera_final_btn [type="reset"]:not(:disabled):hover, 
    .camera_final_btn [type="submit"]:not(:disabled):hover, 
    .camera_final_btn button:not(:disabled):hover{
        background-color: #0D6EFD;
        color: #FFF;
}
</style>
    @endsection
	<section>
        @include('components.message')
        <form action="{{ route('store.ipv-photo') }}" method="POST" enctype="multipart/form-data">
            @csrf   
            <input type="hidden" name="ipv_image" id="ipv_image">
            <div class="ipv_main_page ipv_click">
                <div class="cam_not_section">
                    <div class="cam_not">
                        <div class="camera">
                            <i><img src="{{asset('images/mipo/ipv-not-found.svg')}}" alt="mipo"></i>
                            <p class="text-14-medium">{!! __('The camera is not active') !!}</p>
                            <div class="btn_section">
                                <a href="javascript:;" class="text-14-medium">{!! __('Allow Camera') !!}</a>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="camera_screen">
                    <div class="camera_screen_inner">
                        <video id="ipv_video">{{ __('Video stream not available.') }}</video>
                        <img src="#" style="display: none" id="ipv_image_preview">
                        <canvas id="canvas" style="display: none"></canvas>
                    </div>
                </div> --}}
                <div class="camera_controll" id="startbuttonDiv">
                    <div class="camera_icon">
                        <a href="#" id="startbutton">
                            <svg width="42" height="42" viewBox="0 0 42 42" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect x="3" y="3" width="36" height="36" rx="18" fill="white"/>
                                <g clip-path="url(#clip0_96_654)">
                                <path d="M24.75 9.75C25.3807 9.7498 25.9882 9.98801 26.4507 10.4169C26.9132 10.8457 27.1964 11.4336 27.2438 12.0625L27.25 12.25C27.25 12.5562 27.3624 12.8517 27.5659 13.0805C27.7693 13.3093 28.0497 13.4554 28.3537 13.4913L28.5 13.5H29.75C30.7065 13.4999 31.6269 13.8654 32.3228 14.5216C33.0188 15.1778 33.4376 16.0751 33.4938 17.03L33.5 17.25V28.5C33.5001 29.4565 33.1346 30.3769 32.4784 31.0728C31.8222 31.7688 30.9249 32.1876 29.97 32.2438L29.75 32.25H12.25C11.2935 32.2501 10.3731 31.8846 9.67717 31.2284C8.98124 30.5722 8.56237 29.6749 8.50625 28.72L8.5 28.5V17.25C8.49995 16.2935 8.86541 15.3731 9.5216 14.6772C10.1778 13.9812 11.0751 13.5624 12.03 13.5063L12.25 13.5H13.5C13.8315 13.5 14.1495 13.3683 14.3839 13.1339C14.6183 12.8995 14.75 12.5815 14.75 12.25C14.7498 11.6193 14.988 11.0118 15.4169 10.5493C15.8457 10.0868 16.4336 9.80355 17.0625 9.75625L17.25 9.75H24.75ZM21 18.5C20.0707 18.4999 19.1746 18.8449 18.4852 19.468C17.7958 20.0911 17.3623 20.948 17.2688 21.8725L17.255 22.0625L17.25 22.25L17.255 22.4375C17.2917 23.1703 17.5425 23.8762 17.9765 24.4679C18.4104 25.0595 19.0084 25.5108 19.6963 25.766C20.3842 26.0211 21.1318 26.0688 21.8466 25.9033C22.5614 25.7377 23.2119 25.366 23.7176 24.8344C24.2232 24.3028 24.5618 23.6345 24.6914 22.9123C24.8209 22.1901 24.7358 21.4458 24.4466 20.7715C24.1573 20.0972 23.6766 19.5226 23.0639 19.1189C22.4513 18.7151 21.7337 18.4999 21 18.5Z" fill="black"/>
                                </g>
                                <rect x="0.5" y="0.5" width="41" height="41" rx="20.5" stroke="white"/>
                                <defs>
                                <clipPath id="clip0_96_654">
                                <rect x="6" y="6" width="30" height="30" fill="white"/>
                                </clipPath>
                                </defs>
                            </svg>
                        </a>
                    </div>
                    <div class="camera_txt">
                    {!! __('Click on the button to capture photo') !!}
                    </div>
                </div>
                <div class="camera_controll" style="display: none;" id="retakebuttonDiv">
                    <div class="container">
                        <div class="camera_controll_inner">
                            <div class="camera_icon_reload">
                                <a href="#" id="retakebutton">
                                    <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_96_669)">
                                        <path d="M30 16.4999C29.6332 13.8603 28.4086 11.4144 26.515 9.53917C24.6213 7.66392 22.1636 6.4633 19.5205 6.12225C16.8774 5.78121 14.1954 6.31865 11.8878 7.65179C9.58017 8.98494 7.77487 11.0398 6.75 13.4999M6 7.49993V13.4999H12" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M6 19.5C6.36684 22.1397 7.5914 24.5855 9.48504 26.4608C11.3787 28.336 13.8364 29.5366 16.4795 29.8777C19.1226 30.2187 21.8046 29.6813 24.1122 28.3481C26.4198 27.015 28.2251 24.9601 29.25 22.5M30 28.5V22.5H24" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </g>
                                        <defs>
                                        <clipPath id="clip0_96_669">
                                        <rect width="36" height="36" fill="white"/>
                                        </clipPath>
                                        </defs>
                                    </svg>
                                </a>
                            </div>
                            <div class="camera_final_btn">
                                <button type="submit">
                                {!! __('Entregar') !!}
                                    <i>
                                        <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g clip-path="url(#clip0_381_67)">
                                            <path d="M9 15.33L13.165 11.165" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M9 7L13.165 11.165" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            </g>
                                            <defs>
                                            <clipPath id="clip0_381_67">
                                            <rect width="22" height="22" fill="white"/>
                                            </clipPath>
                                            </defs>
                                        </svg>
                                    </i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
	</section>
   @section('custom_script')
        <script>
            // generateRandomCode();
            var file_extensions_valid = ['png','jpg','jpeg','JPG','PNG','JPEG'];
            /* var time = 120;
            var timer;
            var timerInterval;
            var newCodeInterval;
            initCode();
 */
            function initCode() {
                displayCodeTimer();

                newCodeInterval = setInterval(() => {
                    generateRandomCode();
                    clearInterval(timerInterval);
                    displayCodeTimer();
                }, time * 1000);

            }

            const newCodeTimer = document.querySelector('.new-code-timer');
            function displayCodeTimer() {
                timer = time;
                timerInterval = setInterval(() => {
                    timer = timer - 1;                    
                    if (timer >= 0) {
                        newCodeTimer.textContent = 'Time remaining: ' + timer + 's';
                    }                    
                }, 1000);
            }

            function generateRandomCode() {
                $.ajax({
                    type: 'POST',
                    dataType: 'JSON',
                    headers: {
                        'X-CSRF-Token': "{{ csrf_token() }}",
                    },
                    url: "{{ route('ajax-generate-random-code') }}",
                    success: function (res) {
                        if (res.success == true) {
                            $('#random-code').empty().text(res.randomCode);
                        } else {
                            $('#btn_submit').remove();
                            alert('Error '+ res.status + ': ' + res.message);
                        }
                    },
                    error: function (xhr) {
                        $('#btn_submit').remove();
                        ajaxErrorMsg(xhr);
                    }
                });
            }

            $(document).ready(function () {
                let output = $('#placeholder-img-front');
                var img_show_div = document.getElementById('placeholder-img-wrap-front');
                $("#id_proof_image_front").change(function(e) {
                    fileList = [];
                    var totalfiles = document.getElementById('id_proof_image_front').files.length;
                    for (var index = 0; index < totalfiles; index++) {
                        var file_name =  e.target.files[index].name;
                        var file_extensions = file_name.split('.').pop();
                        if(file_extensions_valid.includes(file_extensions)) {
                            fileList.push(URL.createObjectURL(e.target.files[index]));
                        }  else {
                            alert('Please upload valid file. jpeg / jpg / png.');
                            $("#id_proof_image_front").val('').trigger('change');
                        }
                    }
                    $('#placeholder-img-wrap-front').show();
                    $('#placeholder-img-wrap-front').empty();
                    fileList.forEach(img_src_val => {
                    var img_ele = document.createElement('img');
                        img_ele.src = img_src_val;
                        img_show_div.appendChild(img_ele);
                    });
                });

                var img_show_div_backend = document.getElementById('placeholder-img-wrap-backend');
                $("#id_proof_image_backend").change(function(e) {
                    fileListBackend = [];
                    var totalfiles = document.getElementById('id_proof_image_backend').files.length;
                    for (var index = 0; index < totalfiles; index++) {
                        var file_name =  e.target.files[index].name;
                        var file_extensions = file_name.split('.').pop();
                        if(file_extensions_valid.includes(file_extensions)) {
                            fileListBackend.push(URL.createObjectURL(e.target.files[index]));
                        }  else {
                            alert('Please upload valid file. jpeg / jpg / png.');
                            $("#id_proof_image_backend").val('').trigger('change');
                        }
                    }
                    $('#placeholder-img-wrap-backend').show();
                    $('#placeholder-img-wrap-backend').empty();
                    fileListBackend.forEach(img_src_val => {
                    var img_ele = document.createElement('img');
                        img_ele.src = img_src_val;
                        img_show_div_backend.appendChild(img_ele);
                    });
                });
            });

            (() => {

                const width = 595; // We will scale the photo width to this
                let height = 0; // This will be computed based on the input stream

                var localstream;
                let streaming = false;

                let video = document.getElementById("ipv_video");
                let canvas = document.getElementById("canvas");
                let photo = document.getElementById("ipv_image_preview");
                let startButton = document.getElementById("startbutton");
                let startButtonDiv = document.getElementById("startbuttonDiv");
                let retakeButton = document.getElementById("retakebutton");
                let retakeButtonDiv = document.getElementById("retakebuttonDiv");

                function startup() {

                    navigator.mediaDevices
                        .getUserMedia({ video: true, audio: false })
                        .then((stream) => {
                            localstream = stream;
                            video.srcObject = stream;
                            video.play();
                        })
                        .catch((err) => {
                            console.error(`An error occurred: ${err}`);
                        });

                    video.addEventListener(
                        "canplay",
                        (ev) => {
                            if (!streaming) {
                                height = video.videoHeight / (video.videoWidth / width);

                                // Firefox currently has a bug where the height can't be read from
                                // the video, so we will make assumptions if this happens.

                                if (isNaN(height)) {
                                    height = width / (4 / 3);
                                }

                                //video.setAttribute("width", width);
                                //video.setAttribute("height", height);
                                canvas.setAttribute("width", width);
                                canvas.setAttribute("height", height);
                                streaming = true;
                            }
                        },
                        false
                    );

                    startButton.addEventListener(
                        "click",
                        (ev) => {
                            // takepicture();
                            ev.preventDefault();
                            // document.getElementById('gen_random_btn').remove();
                            // setTimeout(takepicture, 3000);
                            startButtonDiv.style.display = "none";
                            retakeButtonDiv.style.display = "flex";
                            takepicture();
                        },
                        false
                    );

                    retakeButton.addEventListener(
                        "click",
                        (ev) => {
                            ev.preventDefault();
                            retakeButtonDiv.style.display = "none";
                            startButtonDiv.style.display = "flex";
                            photo.style.display = 'none';
                            video.style.display = 'block';

                            navigator.mediaDevices
                                .getUserMedia({ video: true, audio: false })
                                .then((stream) => {
                                    localstream = stream;
                                    video.srcObject = stream;
                                    video.play();
                                    console.log('doooooooond');
                                })
                                .catch((err) => {
                                    console.error(`An error occurred: ${err}`);
                                });
                        },
                        false
                    );

                    clearphoto();
                }

                // Fill the photo with an indication that none has been
                // captured.

                function clearphoto() {
                    const context = canvas.getContext("2d");
                    context.fillStyle = "#d9dade";
                    context.fillRect(0, 0, canvas.width, canvas.height);

                    const data = canvas.toDataURL("image/png");
                    photo.setAttribute("src", data);
                }

                // Capture a photo by fetching the current contents of the video
                // and drawing it into a canvas, then converting that to a PNG
                // format data URL. By drawing it on an offscreen canvas and then
                // drawing that to the screen, we can change its size and/or apply
                // other changes before drawing it.

                function takepicture() {
                    const context = canvas.getContext("2d");
                    if (width && height) {
                        canvas.width = width;
                        canvas.height = height;
                        context.drawImage(video, 0, 0, width, height);

                        const data = canvas.toDataURL("image/png");
                        photo.setAttribute("src", data);
                        streaming = false;
                        video.pause();
                        video.src = "";
                        localstream.getTracks()[0].stop();
                        video.style.display = 'none';
                        photo.style.display = 'block';
                        // startButton.style.pointerEvents = "none";
                        // startButton.style.cursor = "default";
                        document.getElementById('ipv_image').value = data;
                    } else {
                        clearphoto();
                    }
                }

                window.addEventListener("load", startup, false);
            })();

           
            
        </script>
        {{-- ipv style by k --}}

        <script>

        </script>

        {{-- ipv style by k --}}
    @endsection
</x-guest-layout>
