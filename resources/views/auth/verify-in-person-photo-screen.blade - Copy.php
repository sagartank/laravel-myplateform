<x-guest-layout>
    @section('custom_style')
        <style>            
            .ipv-colum-block .placeholder-img {
                background-color: #d9dade;
                min-height: unset;
            }
            .ipv-colum-block .verification-code .code-img {
                display: -webkit-box; display: -ms-flexbox; display: flex;
                -webkit-box-align: center; -ms-flex-align: center; align-items: center;
                -webkit-box-pack: center; -ms-flex-pack: center; justify-content: center;
                font-weight: 500;
                font-size: 32px;
                letter-spacing: 0.5em;
                text-align: center;
                padding: 35px 0;
            }
            /* .upload-photo-box-right .img-box::after {
                display: none;
            } */
        </style>
    @endsection

        <div class="ipv-verification-page">
            <div class="page-logo">
                <a href="javascript:;"><img src="{{ asset('images/logo.svg') }}" alt="mipo" /></a>
            </div>

            <div class="ipv-block-main">

                <div class="user-title">
                    <h5>{{ __('IPV Verification') }}</h5>
                </div>
                @include('components.message')
                <form action="{{ route('store.ipv-photo') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="ipv-colum-block">
                        <div class="right-colum">
                            <div class="upload-photo-big">
                                <input type="hidden" name="ipv_image" id="ipv_image">
                                <div class="title">{{ __('Please give access to your device to turn on the camera') }}</div>
                                <div class="upload-photo-box-right">
                                    <div class="img-box">
                                        <video id="ipv_video">{{ __('Video stream not available.') }}</video>
                                        <img src="#" style="display: none" id="ipv_image_preview">
                                    </div>
                                    <canvas id="canvas" style="display: none"></canvas>
                                    <div class="camera-block">
                                        <a href="#" id="startbutton" class="active"><img src="{{ asset('images/camera.svg') }}" alt="mipo" /></a>
                                        <a href="#" id="retakebutton" class="" style="display: none"><h6>{{ __('Retake Picture') }}</h6></a>
                                    </div>
                                </div>
                                <div class="bootom-text">
                                    <p>{{ __('Write down the IPV code in a blank paper and turn on the web camera and capture your
                                        photo hold that paper') }} </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="upload-submit-btn" id="btn_submit">
                        <div class="btnbox">
                            <input class="btn primary-btn" type="submit" value="{{ __('Submit') }}">
                        </div>
                    </div>
                </form>
            </div>
        </div>

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
                let retakeButton = document.getElementById("retakebutton");

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

                                video.setAttribute("width", width);
                                video.setAttribute("height", height);
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
                            startButton.style.display = "none";
                            retakeButton.style.display = "flex";
                            takepicture();
                        },
                        false
                    );

                    retakeButton.addEventListener(
                        "click",
                        (ev) => {
                            ev.preventDefault();
                            retakeButton.style.display = "none";
                            startButton.style.display = "flex";
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
    @endsection
</x-guest-layout>
