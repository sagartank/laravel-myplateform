$(document).ready(function () {
    initToolTip();
    $(".mobile_nav ul li a.avtar-box.avtar-box-mobile").on('click', function () {
        $('body').toggleClass('mobileopenmenu');
    });
    //start js for header dark mode
    $('.color_mode').click(function (e) {
        e.preventDefault();
        var mipo_theme_bgcolor = $("html").hasClass("dark-mode") ? 'no' : 'yes';
        sessionStorage.setItem("mipo_theme_bgcolor", mipo_theme_bgcolor);
    });

    $('.evt_dark_mode_right').change(function (e) {
        e.preventDefault();
        var el = $(this);
        var mipo_theme_bgcolor = $("html").hasClass("dark-mode") ? 'no' : 'yes';
        if (el.is(':checked')) {
            $("html").addClass("dark-mode");
        } else {
            $("html").removeClass("dark-mode");
        }
        sessionStorage.setItem("mipo_theme_bgcolor", mipo_theme_bgcolor);
    });

    if (sessionStorage.getItem("mipo_theme_bgcolor") == 'yes') {
        $("html").addClass("dark-mode");
        $('.evt_dark_mode_right').prop('checked', true);
    }
    //ebd js for header dark mode

    $('#web-logout').click(function (e) {
        e.preventDefault();
        $('#web-logout-form').submit();
    });

    $('.evt_date_single').daterangepicker({
        autoUpdateInput: false,
        showButtonPanel: false,
        singleDatePicker: true,
        showDropdowns: false,
        minYear: 1901,
        // autoApply: true,
        locale: {
            format: 'DD/MM/YYYY'
        },
        maxYear: parseInt(moment().format('YYYY'), 10)
    }, function (start, end, label) {
        /*  var years = moment().diff(start, 'years');
        alert("You are " + years + " years old!"); */
    }).on('apply.daterangepicker', function (ev, picker) {
        $(this).val(picker.startDate.format('DD/MM/YYYY'));
    });

    $('.evt_birth_date').daterangepicker({
        autoUpdateInput: false,
        showButtonPanel: false,
        singleDatePicker: true,
        showDropdowns: false,
        minYear: 1901,
        maxDate: new Date(),
        // autoApply: true,
        locale: {
            format: 'DD/MM/YYYY'
        },
        maxYear: parseInt(moment().format('YYYY'), 10)
    }, function (start, end, label) {
        /*  var years = moment().diff(start, 'years');
        alert("You are " + years + " years old!"); */
    }).on('apply.daterangepicker', function (ev, picker) {
        $(this).val(picker.startDate.format('DD/MM/YYYY'));
    });


    // dashboard sidebar by k
    jQuery(".filter_modal_cattitle a").on("click", function (e) {
        e.preventDefault();
        jQuery(this).parent().parent().find(".filter_catlist, .filter_modal_select, .mbexpbudget, .calender_wrap, .active_payment").slideToggle();
        jQuery(this).parent().toggleClass("active");

    });
    // dashboard sidebar by k
});

$(function () {
    $(".dropdown .custom_user_btn_dropdown").on('click', function (e) {
        $(this).parent().toggleClass('dropdown_active');
        $('.head_notify').removeClass('open');

        e.stopPropagation()
    });
    $(document).on("click", function (e) {
        if ($(e.target).is(".custom_user_list") === false) {
            $(".dropdown").removeClass("dropdown_active");
        }
    });
});

$(function () {
    $(".header_main .head_right .head_notify a").on('click', function (e) {
        $(this).parent().toggleClass('open');
        $('.user_box .dropdown').removeClass('dropdown_active');
        e.stopPropagation()
    });
    $(document).on("click", function (e) {
        if ($(e.target).is(".notify_dropdon") === false) {
            $(".head_notify").removeClass("open");
        }
    });
});

// dashboard sidebar by k

$(function () {
    $('.mobile_export_blk .filter_btn_wrap').on('click', function () {
        $('.mobile_export_blk').addClass('clicked');
        $('body').addClass('adv_mob_filter');
    });

    $('.mobile_export_blk .mobile_adv_filter a .light').on('click', function () {
        $('.mobile_export_blk').removeClass('clicked');
        $('body').removeClass('adv_mob_filter');
    });

    $('.mobile_export_blk .mobile_adv_filter a .dark').on('click', function () {
        $('.mobile_export_blk').removeClass('clicked');
        $('body').removeClass('adv_mob_filter');
    });
});

// dashboard sidebar by k

// received offer sidebar by k

$(function () {
    $('.drafts_main_wrapper .outter_drafts .drop_wrap .title_drafts a').on('click', function () {
        $('.mobile_operations_left').addClass('clicked');
        $('body').addClass('mob_filter');
    });

    $('.mobile_operations_left .mobile_filter .adv-filter .light').on('click', function () {
        $('.mobile_operations_left').removeClass('clicked');
        $('body').removeClass('mob_filter');
    });

    $('.mobile_operations_left .mobile_filter .adv-filter .dark').on('click', function () {
        $('.mobile_operations_left').removeClass('clicked');
        $('body').removeClass('mob_filter');
    });
});


$(function () {
    $('.drop_wrap .mobile_shortby a').on('click', function () {
        $('.drop_wrap').addClass('clicked');
        $('body').addClass('filter_blur');
    });

    $('.drop_wrap .mobile_shortby .backdrop_blurbg').on('click', function () {
        $('.drop_wrap').removeClass('clicked');
        $('body').removeClass('filter_blur');
    });

    $('.drop_wrap .mobile_shortby .backdrop_blurbg .mobile_fade .mobile_modal_header .light').on('click', function () {
        $('.drop_wrap').removeClass('clicked');
        $('body').removeClass('filter_blur');
    });

    $('.drop_wrap .mobile_shortby .backdrop_blurbg .mobile_fade .mobile_modal_header .dark').on('click', function () {
        $('.drop_wrap').removeClass('clicked');
        $('body').removeClass('filter_blur');
    });


    $('.deals_tabs .mobile_shortby a').on('click', function () {
        $('.deals_tabs').addClass('clicked');
        $('body').addClass('filter_blur');
    });

    $('.deals_tabs .mobile_shortby .backdrop_blurbg').on('click', function () {
        $('.deals_tabs').removeClass('clicked');
        $('body').removeClass('filter_blur');
    });

    $('.deals_tabs .mobile_shortby .backdrop_blurbg .mobile_fade .mobile_modal_header .light').on('click', function () {
        $('.deals_tabs').removeClass('clicked');
        $('body').removeClass('filter_blur');
    });

    $('.deals_tabs .mobile_shortby .backdrop_blurbg .mobile_fade .mobile_modal_header .dark').on('click', function () {
        $('.deals_tabs').removeClass('clicked');
        $('body').removeClass('filter_blur');
    });
});
var windowsize = $(window).width();
if (windowsize < 768) {
    // $('.widget-visible').css("display","none !important");
} else {
    var Tawk_API = Tawk_API || {},
    Tawk_LoadStart = new Date();
    (function () {
        var s1 = document.createElement("script"),
        s0 = document.getElementsByTagName("script")[0];
        s1.async = true;
        s1.src = 'https://embed.tawk.to/646352fe74285f0ec46bb89b/1h0hvocm4';
        s1.charset = 'UTF-8';
        s1.setAttribute('crossorigin', '*');
        s0.parentNode.insertBefore(s1, s0);
        
        Tawk_API.visitor = {
            name: "{{ Auth::user()->name }}",
            email: "{{ Auth::user()->email }}",
            hash: '{{ hash_hmac("sha256", "Auth::user()->email", "c0000f7e237423c6795f8648cbaddaccf202d277") }}'
        };
    })();

    $(document).on('click', '.evt_web_open_chat', function () {
        Tawk_API.toggle();
    });
}


// received offer sidebar by k
// received offer sidebar by k

//offered page view history table mobile
$('body').delegate('.mobile_offeredbox .bottom_link .gery', 'click', function () {
    $('.mobile_offeredbox').addClass('clicked');
    $('body').addClass('optab_filter');
});

$('body').delegate('.mobile_offeredbox .mobile_historytab .historybox .titlebox a', 'click', function () {
    $('.mobile_offeredbox').removeClass('clicked');
    $('body').removeClass('optab_filter');
});

//offered page view history table mobile 
$('body').delegate('.mobile_offered_operations_inner .filtericon a', 'click', function () {
    $('.mobile_offered_operations_inner').addClass('clicked');
    $('body').addClass('optab_filter');
});

$('body').delegate('.mobile_offered_operations_inner .explor_blurbg', 'click', function () {
    $('.mobile_offered_operations_inner').removeClass('clicked');
    $('body').removeClass('exptab_filter');
});

$('body').delegate('.explor_blurbg .mobile_sortby .titlebox .close', 'click', function () {
    $('.mobile_offered_operations_inner').removeClass('clicked');
    $('body').removeClass('optab_filter');
});

$('body').delegate('.explor_blurbg .mobile_sortby .titlebox .darkcls', 'click', function () {
    $('.mobile_offered_operations_inner').removeClass('clicked');
    $('body').removeClass('optab_filter');
});

//explorer operation sort by

//explorer operation sort
$('body').delegate('.mobile_operation_tab .mbop_sort a', 'click', function () {
    $('.mobile_operation_tab').addClass('clicked');
    $('body').addClass('exptab_filter');
});

$('body').delegate('.mobile_operation_tab .mobile_sortby', 'click', function () {
    $('.mobile_operation_tab').removeClass('clicked');
    $('body').removeClass('exptab_filter');
});

$('body').delegate('.mobile_sortby .titlebox .close', 'click', function () {
    $('.mobile_operation_tab').removeClass('clicked');
    $('body').removeClass('exptab_filter');
});

$('body').delegate('.mobile_sortby .titlebox .darkcls', 'click', function () {
    $('.mobile_operation_tab').removeClass('clicked');
    $('body').removeClass('exptab_filter');
});


//explorer operation mobile sidebar

$(function () {
    $('.mobile_expop_wrap .titlewrap .titlebox a').on('click', function () {
        $('.titlewrap').addClass('clicked');
        $('body').addClass('mob_filter');
    });

    $('.mobile_filter .adv-filter a').on('click', function () {
        $('.titlewrap').removeClass('clicked');
        $('body').removeClass('mob_filter');
    });

    $('.titlewrap .mobile_filter .adv-filter .dark').on('click', function () {
        $('.titlewrap').removeClass('clicked');
        $('body').removeClass('mob_filter');
    });
});

//offered page view operation btn to slide
$('body').delegate('.mobile_offeredbox .viewAll_op a', 'click', function () {
    $('.mobile_offeredbox').addClass('attach');
    $('body').addClass('view_open');
});

$('body').delegate('.mobile_view_op_tab .titlebox a', 'click', function () {
    $('.mobile_offeredbox').removeClass('attach');
    $('body').removeClass('view_open');
});

function initToolTip() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
}

$(document).on('click', '.evt_back_history_button', function (e) {
    window.history.back();
});

$(document).on('click', '.evt_share_btn', function (e) {
    e.preventDefault();
    try {
        var temp = document.createElement("input");
        temp.setAttribute("value", $(this).attr('data-share-val'));
        document.body.appendChild(temp);
        temp.select();
        document.execCommand("copy");
        document.body.removeChild(temp);
        toastr.success(copy_en_msg);
    } catch (error) {
        ajaxErrorMsg(error);
    }
});

$(document).ready(function () {
    var applyButton = $('.applyBtn');
    applyButton.text(apply_en_msg);

    var cancelButton = $('.cancelBtn');
    cancelButton.text(cancle_en_msg);
});


// deal review box radio btn active 
$('#rating-modal .pexp_ope .btn input[type=radio]').change(function() {
    $(this).parents('.btn').siblings('.btn').removeClass('active');
    if (this.checked) {
       $(this).parent().addClass('active');
    }
    else{
        $(this).parents('.btn').siblings('.btn').removeClass('active');
        // ...
    }
});

$(document).on('click', '.btn-errors-close', function (e) {
    $('#btn-errors-close').remove();
});


function loadMobileTawk() {
    var link = document.createElement('a');
    link.href = "https://tawk.to/chat/646352fe74285f0ec46bb89b/1h0hvocm4";
    link.target = '_blank';
    link.click();
  }
  // Add a click event listener to the button
  document.getElementById('evt_mobile_tawk').addEventListener('click', loadMobileTawk);

// install app:st
// let installPrompt = null;
// const installButton = document.querySelector("#install_our_app");

// window.addEventListener("beforeinstallprompt", (event) => {
//   event.preventDefault();
//   installPrompt = event;
//   installButton.removeAttribute("hidden");
// });


// installButton.addEventListener("click", async () => {
//     if (!installPrompt) {
//       return;
//     }
//     const result = await installPrompt.prompt();
//     console.log(`Install prompt was: ${result.outcome}`);
//     disableInAppInstallPrompt();
//   });
  
//   function disableInAppInstallPrompt() {
//     installPrompt = null;
//     installButton.setAttribute("hidden", "");
//   }

let installPrompt = null;
const installButton = document.querySelector("#install_our_app");

window.addEventListener("beforeinstallprompt", (event) => {
  event.preventDefault();
  installPrompt = event;

  // Check if the app is already installed
  if (isAppInstalled()) {
    installButton.setAttribute("hidden", "");
  } else {
    installButton.removeAttribute("hidden");
  }
});

installButton.addEventListener("click", async () => {
  if (!installPrompt) {
    return;
  }
  const result = await installPrompt.prompt();
  console.log(`Install prompt was: ${result.outcome}`);
  disableInAppInstallPrompt();
});

function disableInAppInstallPrompt() {
  installPrompt = null;
  installButton.setAttribute("hidden", "");
}

function isAppInstalled() {
  // Check if the app is already installed
  return window.matchMedia("(display-mode: standalone)").matches || window.navigator.standalone;
}

//install app:nd

//got to back:st
$(document).on('click', '.gotoback', function (e) {
    e.preventDefault();
    history.back();
});
//go to back:nd

// regtration install mipo:st
let reginstallPrompt = null;
const reginstallButton = document.querySelector("#regweb_trigger");

window.addEventListener("beforeinstallprompt", (event) => {
  event.preventDefault();
  reginstallPrompt = event;

  // Check if the app is already installed
  if (isAppInstalled()) {
    reginstallButton.setAttribute("hidden", "");
  } else {
    reginstallButton.removeAttribute("hidden");
  }
});

reginstallButton.addEventListener("click", async () => {
  if (!reginstallPrompt) {
    return;
  }
  const result = await reginstallPrompt.prompt();
  console.log(`Install prompt was: ${result.outcome}`);
  disableInAppInstallPrompt();
});

function disableInAppInstallPrompt() {
  reginstallPrompt = null;
  reginstallButton.setAttribute("hidden", "");
}

function isAppInstalled() {
  // Check if the app is already installed
  return window.matchMedia("(display-mode: standalone)").matches || window.navigator.standalone;
}
// regtration install mipo:nd

// userdtl install mipo:st
let userdtlinstallPrompt = null;
const userdtlinstallButton = document.querySelector("#userdeti_trigger");

window.addEventListener("beforeinstallprompt", (event) => {
  event.preventDefault();
  userdtlinstallPrompt = event;

  // Check if the app is already installed
  if (isAppInstalled()) {
    userdtlinstallButton.setAttribute("hidden", "");
  } else {
    userdtlinstallButton.removeAttribute("hidden");
  }
});

userdtlinstallButton.addEventListener("click", async () => {
  if (!userdtlinstallPrompt) {
    return;
  }
  const result = await userdtlinstallPrompt.prompt();
  console.log(`Install prompt was: ${result.outcome}`);
  disableInAppInstallPrompt();
});

function disableInAppInstallPrompt() {
  userdtlinstallPrompt = null;
  userdtlinstallButton.setAttribute("hidden", "");
}

function isAppInstalled() {
  // Check if the app is already installed
  return window.matchMedia("(display-mode: standalone)").matches || window.navigator.standalone;
}
// regtration install mipo:nd

// company page install mipo:st
let companyinstallPrompt = null;
const companyinstallButton = document.querySelector("#company_triger");

window.addEventListener("beforeinstallprompt", (event) => {
  event.preventDefault();
  companyinstallPrompt = event;

  // Check if the app is already installed
  if (isAppInstalled()) {
    companyinstallButton.setAttribute("hidden", "");
  } else {
    companyinstallButton.removeAttribute("hidden");
  }
});

companyinstallButton.addEventListener("click", async () => {
  if (!companyinstallPrompt) {
    return;
  }
  const result = await companyinstallPrompt.prompt();
  console.log(`Install prompt was: ${result.outcome}`);
  disableInAppInstallPrompt();
});

function disableInAppInstallPrompt() {
  companyinstallPrompt = null;
  companyinstallButton.setAttribute("hidden", "");
}

function isAppInstalled() {
  // Check if the app is already installed
  return window.matchMedia("(display-mode: standalone)").matches || window.navigator.standalone;
}
// company page install mipo:nd
$(document).ready(function() {

    // desktop app install notification

    let deskNotificationApp = $('#destop_notification_app');
    setTimeout(function() {
        let isDeskNotification = localStorage.getItem("desk_noti");
        if(isDeskNotification) {
            deskNotificationApp.hide();
        } else {
            deskNotificationApp.show();
        }
    }, 5000);
    $('#desktop-close-btn').click(function (e) { 
        e.preventDefault();
        var el = $(this);
        deskNotificationApp.hide();
        localStorage.setItem("desk_noti", false);
    });
    //desk install mipo
    let deskinstallPrompt = null;
    const deskinstallButton = document.querySelector("#desk_install_btn");
    
    // Check if the app is already installed
    if (isAppInstalled()) {
        deskinstallButton.setAttribute("hidden", "");
        localStorage.setItem('appInstalled', 'true');
        installButton.setAttribute("hidden", "");
        localStorage.setItem("desk_noti", false);
    }
    
    window.addEventListener("beforeinstallprompt", (event) => {
        event.preventDefault();
        deskinstallPrompt = event;
    
        // Check if the app is already installed
        if (!isAppInstalled()) {
            deskinstallButton.removeAttribute("hidden");
        }
    });
    
    deskinstallButton.addEventListener("click", async () => {
        if (!deskinstallPrompt) {
            return;
        }
        const result = await deskinstallPrompt.prompt();
        console.log(`Install prompt was: ${result.outcome}`);
        disableInAppInstallPrompt();
    });
    
    function disableInAppInstallPrompt() {
        // Set a flag in localStorage to indicate that the app has been installed
        localStorage.setItem('appInstalled', 'true');
        
        deskinstallPrompt = null;
        deskinstallButton.setAttribute("hidden", "");
    }
    
    function isAppInstalled() {
        // Check if the app is already installed by looking at the localStorage flag
        return localStorage.getItem('appInstalled') === 'true' ||
            window.matchMedia("(display-mode: standalone)").matches || window.navigator.standalone;
    }
    

    // iphone app install notification

    if (!navigator.userAgent.includes('Chrome') && navigator.userAgent.includes('Safari')) {
        console.log('Browser is Safari');
        let iphoneNotificationApp = document.getElementById('iphone_app_modal');
        let isIphoneNotification = localStorage.getItem("iphone_noti");
        setTimeout(function() {
            if (window.innerWidth < 768) {
                if(isIphoneNotification == null)
                iphoneNotificationApp.style.display = 'block';
            } else {
                iphoneNotificationApp.style.display = 'none';
            }
        }, 5000);
        document.getElementById('iphone-close-btn').addEventListener('click',function (e) {
            e.preventDefault();
            var ele = $(this);
            iphoneNotificationApp.style.display = 'none';
            localStorage.setItem("iphone_noti", false);
        });
        //iphone install mipo
        let iphoneinstallPrompt = null;
    const iphoneinstallButton = document.querySelector("#log_install_btn");
    
    // Check if the app is already installed
    if (isAppInstalled()) {
        iphoneinstallButton.setAttribute("hidden", "");
        localStorage.setItem('appInstalled', 'true');
        installButton.setAttribute("hidden", "");
        localStorage.setItem("desk_noti", false);
    }
    
    window.addEventListener("beforeinstallprompt", (event) => {
        event.preventDefault();
        iphoneinstallPrompt = event;
    
        // Check if the app is already installed
        if (!isAppInstalled()) {
            iphoneinstallButton.removeAttribute("hidden");
        }
    });
    
    iphoneinstallButton.addEventListener("click", async () => {
        if (!iphoneinstallPrompt) {
            return;
        }
        const result = await iphoneinstallPrompt.prompt();
        console.log(`Install prompt was: ${result.outcome}`);
        disableInAppInstallPrompt();
    });
    
    function disableInAppInstallPrompt() {
        // Set a flag in localStorage to indicate that the app has been installed
        localStorage.setItem('appInstalled', 'true');
        
        iphoneinstallPrompt = null;
        iphoneinstallButton.setAttribute("hidden", "");
    }
    
    function isAppInstalled() {
        // Check if the app is already installed by looking at the localStorage flag
        return localStorage.getItem('appInstalled') === 'true' ||
            window.matchMedia("(display-mode: standalone)").matches || window.navigator.standalone;
    }
    } else {
        console.log('Browser is not Safari');
    }

    // android app install notification

    let androidNotificationApp = document.getElementById('mobile_app_notification');
    let isAndroidNotification = localStorage.getItem("android_noti");
    setTimeout(function() {
        if (window.innerWidth < 768) {
            if(isAndroidNotification == null)
            androidNotificationApp.style.display = 'block';
        } else {
            androidNotificationApp.style.display = 'none';
        }
    }, 5000);
    document.getElementById('android-close-btn').addEventListener('click',function (e) {
        e.preventDefault();
        var ele = $(this);
        androidNotificationApp.style.display = 'none';
        localStorage.setItem("android_noti", false);
    });
    //android install mipo
    let androidinstallPrompt = null;
    const androidinstallButton = document.querySelector("#androi_install_btn");
    
    // Check if the app is already installed
    if (isAppInstalled()) {
        androidinstallButton.setAttribute("hidden", "");
        localStorage.setItem('appInstalled', 'true');
        installButton.setAttribute("hidden", "");
        localStorage.setItem("android_noti", false);
    }
    
    window.addEventListener("beforeinstallprompt", (event) => {
        event.preventDefault();
        androidinstallPrompt = event;
    
        // Check if the app is already installed
        if (!isAppInstalled()) {
            androidinstallButton.removeAttribute("hidden");
        }
    });
    
    androidinstallButton.addEventListener("click", async () => {
        if (!androidinstallPrompt) {
            return;
        }
        const result = await androidinstallPrompt.prompt();
        console.log(`Install prompt was: ${result.outcome}`);
        disableInAppInstallPrompt();
    });
    
    function disableInAppInstallPrompt() {
        // Set a flag in localStorage to indicate that the app has been installed
        localStorage.setItem('appInstalled', 'true');
        
        androidinstallPrompt = null;
        androidinstallButton.setAttribute("hidden", "");
    }
    
    function isAppInstalled() {
        // Check if the app is already installed by looking at the localStorage flag
        return localStorage.getItem('appInstalled') === 'true' ||
            window.matchMedia("(display-mode: standalone)").matches || window.navigator.standalone;
    }

    // authantication page app install notification

    let loginNotificationApp = document.getElementById('login_device_app');
    let isloginNotification = localStorage.getItem("login_noti");
    setTimeout(function() {
        if (window.innerWidth < 768) {
            if(isloginNotification == null)
            loginNotificationApp.style.display = 'block';
        } else {
            loginNotificationApp.style.display = 'none';
        }
    }, 5000);
    document.getElementById('login-close-btn').addEventListener('click',function (e) {
        e.preventDefault();
        var ele = $(this);
        loginNotificationApp.style.display = 'none';
        localStorage.setItem("login_noti", false);
    });
    //authentication install mipo
    let authinstallPrompt = null;
    const authinstallButton = document.querySelector("#desk_install_btn");
    
    // Check if the app is already installed
    if (isAppInstalled()) {
        authinstallButton.setAttribute("hidden", "");
        localStorage.setItem('appInstalled', 'true');
        installButton.setAttribute("hidden", "");
        localStorage.setItem("login_noti", false);
    }
    
    window.addEventListener("beforeinstallprompt", (event) => {
        event.preventDefault();
        authinstallPrompt = event;
    
        // Check if the app is already installed
        if (!isAppInstalled()) {
            authinstallButton.removeAttribute("hidden");
        }
    });
    
    authinstallButton.addEventListener("click", async () => {
        if (!authinstallPrompt) {
            return;
        }
        const result = await authinstallPrompt.prompt();
        console.log(`Install prompt was: ${result.outcome}`);
        disableInAppInstallPrompt();
    });
    
    function disableInAppInstallPrompt() {
        // Set a flag in localStorage to indicate that the app has been installed
        localStorage.setItem('appInstalled', 'true');
        
        authinstallPrompt = null;
        authinstallButton.setAttribute("hidden", "");
    }
    
    function isAppInstalled() {
        // Check if the app is already installed by looking at the localStorage flag
        return localStorage.getItem('appInstalled') === 'true' ||
            window.matchMedia("(display-mode: standalone)").matches || window.navigator.standalone;
    }
});


