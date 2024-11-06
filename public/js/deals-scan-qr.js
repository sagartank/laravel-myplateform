$(document).ready(function () {
    $('#cameraLink').click(function (e) {
        e.preventDefault();
        Html5Qrcode.getCameras().then(devices => {
            if (devices && devices.length) {
                $('#scan_qr_modal').modal('show');
                var cameraId = devices[0].id;
                const html5QrCode = new Html5Qrcode("my-qr-reader");
                    html5QrCode.start(
                    cameraId, 
                    {
                        facingMode: { exact: "environment"},
                        // deviceId: { exact: cameraId},
                        // facingMode: "environment",
                        fps: 10 , // Optional, frame per seconds for qr code scanning
                        // qrbox: { width: 250, height: 450 }  // Optional, if you want bounded box UI
                        qrbox: { width: 250, height: 250 }  // Optional, if you want bounded box UI
                        // deviceId: { exact: 'back' }
                    },
                    (decodedText, decodedResult) => {
                        console.log(`Scan result: ${decodedText}`, decodedResult);
                        $.ajax({
                            type: "GET",
                            url: decodedText,
                            data: [],
                            dataType: 'json',
                            beforeSend: function () {
                                // toastr.success('QR Code Scanner loading');
                            },
                            success: function (res) {
                                if (res.status == true) {
                                    toastr.success(res.message);
                                    // $('#html5-qrcode-button-camera-stop').trigger('click');
                                    $('#scan_qr_modal').modal('hide');
                                    location.reload();
                                } else {
                                    toastr.error(res.message);
                                }
                            },
                            error: function (xhr) {
                                ajaxErrorMsg(xhr);
                            }
                        });
                    },
                    (errorMessage) => {
                        // console.error(`errorMessage: `, errorMessage);
                    })
                    .catch((err) => {
                        console.error(`catch: err `, err);
                    });
            } else {
                toastr.error(no_camera_en_msg);
                $('#scan_qr_modal').modal('hide');
            }
            }).catch(err => {
                $('#scan_qr_modal').modal('hide');
                toastr.error(no_camera_en_msg);
                console.error(`errorMessage: err `, err);
            });

        /*  setTimeout(() => {
            var html5QrcodeScanner = new Html5QrcodeScanner("my-qr-reader", { fps: 10, qrbox: 250 });
            var is_qr = html5QrcodeScanner.render(onScanSuccess);
            setTimeout(() => {
            if(is_qr == undefined) {
                // var is_qr = html5QrcodeScanner.render(onScanSuccess);
            }
        }, 900)
            console.log('is_qr', is_qr);

            function onScanSuccess(decodedText, decodedResult) {
                console.log(`Scan url: ${decodedText}`);
                console.log(`Scan result: ${decodedText}`, decodedResult);
                $.ajax({
                    type: "GET",
                    url: decodedText,
                    data: [],
                    dataType: 'json',
                    beforeSend: function () {
                        toastr.success('QR Code Scanner loading');
                    },
                    success: function (res) {
                        if (res.status == true) {
                            toastr.success(res.message);
                            $('#html5-qrcode-button-camera-stop').trigger('click');
                            $('#scan_qr_modal').modal('hide');
                            location.reload();
                        } else {
                            toastr.error(res.message);
                        }
                    },
                    error: function (xhr) {
                        ajaxErrorMsg(xhr);
                    }
                });
            }

            console.log(`html5QrcodeScanner: run `);
        }, 600); */
    });

    $('.scan_qr_modal_close').click(function (e) {
        e.preventDefault();
        /*  html5QrCode.stop().then((ignore) => {
            // QR Code scanning is stopped.
            }).catch((err) => {
            // Stop failed, handle it.
            }); */
        /* var html5QrCode = new html5QrCode("my-qr-reader", { fps: 10, qrbox: 250 });
        html5QrCode.clear() */;
        $('#html5-qrcode-button-camera-stop').trigger('click');
        $('#scan_qr_modal').modal('hide');
        location.reload();
    });

    $('body').click(function (e) {
        var is_open_modal = $('#scan_qr_modal').is(':visible');
        if(is_open_modal == true) {
            location.reload();
        }
    });
});

