// developer js
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).on('click', '.evt_home_slide_img', function (e) {
    e.preventDefault;
    var getImg = $(this).attr('data-home-slide-img');
    var setImg = $('#set-home-slide-img').attr('src', getImg);
});

$(document).on('submit', '#form-contact-us', function (e) {
    e.preventDefault();
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: ajax_url_contact_send,
        data: $(this).serialize(),
        success: function (res) {
            if (res.status == true) {
                toastr.success(res.message);
                $('#form-contact-us').trigger("reset");
            }
            else {
                toastr.error(res.message);
            }
        },
        error: function (xhr) {
            // ajaxErrorMsg(xhr);
            if (xhr.status === 422) {
                    toastr.error(all_fields_are_required_en_msg);
            } else {
                toastr.error(xhr.statusText);
            }
        }
    });
});

function ajaxErrorMsg(xhr) {
    if (xhr.status === 422) {
        $.each(xhr.responseJSON.errors, function (key, val) {
            toastr.error(val);
        });
    } else {
        toastr.error(xhr.statusText);
    }
}

// designer js
// ========== header:start ==========

$(document).ready(function(){
    $(window).scroll(function(){
        var sticky = $('.header'),
            scroll = $(window).scrollTop();
        
        if (scroll >= 1) sticky.addClass('fixed');
        else sticky.removeClass('fixed');
    });
});

// ========== header:end ==========

// ========== mobile menu:start ==========

$(document).ready(function () {
    $(".menu-toggler").click(function () {
        $(this).toggleClass("active"), $(".navigation_bar").slideToggle(400);
    });

	$(".menu-toggler .menu-toggler-icon").on("click", function (e) {
		e.preventDefault();
		$(this).toggleClass("active");
		$("body").toggleClass("show_menu");
		$("body").toggleClass("scrolldesable");
	});
});

// ========== mobile menu:end ==========

// ========== banner animation:start ==========

function checkPosition() {
    if (window.matchMedia('(min-width: 991px)').matches) {
        gsap.registerPlugin(ScrollTrigger);

        ScrollTrigger.defaults({
        toggleActions: "restart pause resume pause",
        });

        const timelineHeader = gsap.timeline({
        scrollTrigger: {
            id: "zoom", 
            trigger: ".banner_section",
            scrub: 1.5, 
            force3D: true,
            start: "top top",
            end: "100% 50px",
            pin: true,
        }
        });
        timelineHeader
        .to(".gs_pro", {
            scale: 0,
            opacity: 0,
            left: '50%',
            top: 500,
            marginLeft:- $('.banner_wrap .gs_pro img').width() / 2
        }, "sameTime")
        .to(".user", {
            scale: 0,
            opacity: 0,
            left: '50%',
            top: 500,
            marginLeft:-$('.banner_wrap .user img').width() / 2
        }, "sameTime")
        .to(".us_wrep", {
            scale: 0,
            opacity: 0,
            right: '50%',
            top: 500,
            marginRight:-$('.banner_wrap .us_wrep img').width() / 2
        }, "sameTime")
        .to(".data_wrap", {
            scale: 0,
            opacity: 0,
            right: '50%',
            top: 500,
            marginRight:-$('.banner_wrap .data_wrap img').width() / 2
        }, "sameTime")
    } else {
        //...
    }
}

checkPosition()

// ========== banner animation:end ==========

// ========== slider:start ==========

$('.bnr_wrap').owlCarousel({
    items: 4,
    loop: true,
    nav: false,
    dots: false,
    margin: 16,
    slideBy : 1,
	smartSpeed : 2000,
    autoplay : true,
	autoplaySpeed : 2000,
    responsiveClass: true,
    responsive:{
        0:{
            items:1,
        },
        768:{
            items:2,
        },
        992:{
            items:4,
        }
    },
});

// ========== slider:end ==========

// ========== work-section:start ==========

$(document).ready(function(){
    $(".approve, .multi_offer, .best_offer, .paid").hide();

    $(".upload-platform") .click(function(){
        $(".approve, .multi_offer, .best_offer, .paid").hide();
    });
    $(".upload-platform") .click(function(){
        $(".platform").show();
    });
});
$(document).ready(function(){
    $(".get-approve") .click(function(){
        $(".platform, .multi_offer, .best_offer, .paid").hide();
    });
    $(".get-approve") .click(function(){
        $(".approve").show();
    });
});
$(document).ready(function(){
    $(".multipal-offer") .click(function(){
        $(".platform, .approve, .best_offer, .paid").hide();
    });
    $(".multipal-offer") .click(function(){
        $(".multi_offer").show();
    });
});
$(document).ready(function(){
    $(".choose_offer") .click(function(){
        $(".platform, .approve, .multi_offer, .paid").hide();
    });
    $(".choose_offer") .click(function(){
        $(".best_offer").show();
    });
});
$(document).ready(function(){
    $(".get_paid") .click(function(){
        $(".platform, .approve, .multi_offer, .best_offer").hide();
    });
    $(".get_paid") .click(function(){
        $(".paid").show();
    });
});

// ========== work-section:end ==========

// ========== footer:start ==========

$(document).ready(function () {
	$(".ent_lang .lang-link").on("click", function (e) {
		$(this).parent().toggleClass("show");
		$(this).parent().find(".dropdown-menu").toggleClass("show");
		e.preventDefault;
	});
});

// ========== footer:end ==========


// marketing watch demo:st
 var modalVideo = document.getElementById('marketing_demo_vid');
 $('#watch_demo').on('hidden.bs.modal', function () {
   modalVideo.pause();
 });

 //three dot hide

 // marketing watch demo:nd