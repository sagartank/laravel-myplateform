!(function (n) {
    n(document).ready(function () {
        "use strict";
        n(".input-group.password .icon").on("click", function (t) {
            n(this).parent().toggleClass("show");
        }),
            n(".ent_lang .lang-link").on("click", function (t) {
                n(this).parent().toggleClass("show"), n(this).parent().find(".dropdown-menu").toggleClass("show"), t.preventDefault;
            }),
            n(".selectbox").niceSelect();
    }),
        n(".radio_tabs .btn-wrap .btn").each(function (t, e) {
            n(this).prop("checked") && n("article").eq(t).addClass("on");
        }),
        n(".radio_tabs .btn-wrap .btn").on("change", function () {
            n(this).prop("checked");
            var t = n(".radio_tabs .btn-wrap .btn").index(this);
            n(".content_main .tab_content").removeClass("active"), n(".content_main .tab_content").eq(t).addClass("active");
        }),
        n(document).ready(function () {
            n(document).on("change", ".btn-wrap .btn", function () {
                n(this).addClass("active").siblings().removeClass("active");
            }),
                n(document).on("change", ".check-btn-wrap .btn", function () {
                    n(this).toggleClass("active");
                }),
                n(document).on("click", ".more_option", function (t) {
                    t.preventDefault(), n(this).toggleClass("open");
                }),
                n(document).on("click", ".upload-photo-box-right .camera-block a", function (t) {
                    t.preventDefault(),
                        n(".img-box.camara").hide(),
                        n(".img-box.camara_counter").show(),
                        setTimeout(function () {
                            n(".img-box.camara").show(), n(".img-box.camara_counter").hide();
                        }, 4e3);
                }),
                n(document).on("click", ".header_main .head_right .color_mode a", function (t) {
                    t.preventDefault(), n("html").toggleClass("dark-mode");
                });
        });
})(jQuery);
