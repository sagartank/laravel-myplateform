var offeredOperationsPage = {
    modalOfferGroupByOpearionList: function (custome_len = 5) {
        var temp = '';
        for (var i = 1; i < custome_len; i++) {
            temp += `<div class="operatorbox_outer skeleton_loader"><div class="grp-ofr-operation_box"><div class="leftpart"><div class="opecheck_all_wrp"><a href="javascript:;" class="name text-16-medium"></a><div class="imgbox"><i></i><span class="text-16-medium"></span></div></div><div class="company"><a href="javascript:;" class="text-14-medium invoice"></a><span></span><a href="javascript:;" class="text-14-medium"></a></div><div class="resource_wrap"><ul class="first"></ul></div><div class="whattakes"><ul></ul></div></div><div class="rightpart"><div class="userLocation"><p class="text-16-medium"></p></div><div class="expireDay text-14-medium"></div><div class="iconsrow"></div></div></div><div class="showmore_wrap"><div class="showmore"><a href="javascript:void(0)"><span class="show-More text-12-medium"></span><i></i></a></div></div><a href="javascript:;" class="full_link"></a></div><div class="operatorbox_outer skeleton_loader"><div class="grp-ofr-operation_box"><div class="leftpart"><div class="opecheck_all_wrp"><a href="javascript:;" class="name text-16-medium"></a><div class="imgbox"><i></i><span class="text-16-medium"></span></div></div><div class="company"><a href="javascript:;" class="text-14-medium invoice"></a><span></span><a href="javascript:;" class="text-14-medium"></a></div><div class="resource_wrap"><ul class="first"></ul></div><div class="whattakes"><ul></ul></div></div><div class="rightpart"><div class="userLocation"><p class="text-16-medium"></p></div><div class="expireDay text-14-medium"></div><div class="iconsrow"></div></div></div><div class="showmore_wrap"><div class="showmore"><a href="javascript:void(0)"><span class="show-More text-12-medium"></span><i></i></a></div></div><a href="javascript:;" class="full_link"></a></div>`;
        }
        return temp;
    },
    list: function (custome_len = 5) {
        var temp = '';
        for (var i = 1; i < custome_len; i++) {
            temp += `<div class="offered_opboxWrap skeleton_loader"><div class="offered_opbox"><div class="leftpart"><div class="multiimgbox"><div class="imgbox"></div><div class="nameDate"><strong class="text-12-medium"></strong><span class="text-12-medium"></span></div></div><div class="lastofr"><div class="opecheck_all_wrp text-16-medium"></div><div class="company text-16-medium"></div><div class="resource_wrap"></div><div class="whattakes"></div></div></div><div class="rightpart"><div class="userLocation"></div><div class="expireDay text-14-medium" data-info="operation expire_at"></div><div class="down_share"></div><div class="reject_acceptbox"></div></div><a class="full_link"></a></div><div class="skeleton_loader"><div class="lftbox"><div class="links"></div></div><div class="rhgtbox"><div class="tag"></div></div></div></div>`;
        }
        return temp;
    },
}

var OperationsPage = {
    list: function (custome_len = 5) {
        var temp = '';
        for (var i = 1; i < custome_len; i++) {
            temp += `<div class="operatorbox_outer skeleton_loader skl_operation"><div class="operation_box"><div class="leftpart"><div class="top_part_cheque_select"></div><div class="drafts_sec_imgbox"><div class="img"></div><div class="ds_text"><div class="opecheck_all_wrp"><a href="javascript:;" class="codeid text-12-medium"></a><span class="cash text-12-medium"></span><a href="javascript:;" class="name text-12-medium"></a><div class="imgbox"></div></div><div class="company"><a href="javascript:;" class="text-12-medium"></a></div><div class="resource_wrap"><p class="text-12-medium"></p><span class="text-12-medium"></span></div><div class="whattack"><p class="text-12-medium"></p><span class="text-12-medium"></span></div></div></div></div><div class="rightpart"><div class="rejected"><p class="text-12-semibold"></p></div><div class="expireDay text-12-medium"></div><div class="down_share"></div></div><a href="javascript:void(0)" class="full_link"></a></div></div>`;
        }
        return temp;
    },
}

var ExploreOperationsPage = {
    list: function (custome_len = 5) {
        var temp = '';
        for (var i = 1; i < custome_len; i++) {
            temp += `<div class="operatorbox_outer skeleton_loader skl_ex_operation"><div class="operation_box"><div class="leftpart"><div class="top_part_cheque_select"></div><div class="opecheck_all_wrp"><a href="javascript:;" class="codeid"></a><span class="cash"></span><a href="javascript:;" class="name"></a><div class="imgbox"><i></i><span></span></div></div><div class="company"><a href="javascript:;"></a></div><div class="resource_wrap"></div><div class="whattakes"></div></div><div class="rightpart"><div class="userLocation"><div class="mipoplus"></div><p></p></div><div class="expireDay"></div><div class="down_share"></div></div><a href="javascript:;" class="full_link"></a></div></div>`;
        }
        return temp;
    },

    list_mobile: function (custome_len = 5) {
        var temp = '';
        for (var i = 1; i < custome_len; i++) {
            temp +=`<div class="mb_operationbox skeleton_loader"><div class="leftpart"><div class="checknum_namebox"><div class="numbox text-14-medium"></div><a class="namebox text-14-medium"></a></div><a class="company text-14-medium"></a><p class="text-14-medium"></p></div><div class="rightpart"><div class="star_rating"></div><p class="text-12-medium"></p><div class="prize"><span class="text-12-medium"></span></div></div><a class="full_link" href="javacript:;"></a></div>`;
        }
        return temp;
    },
}

var DealPage = {
    list: function (custome_len = 5, device_type) {
        var temp = '';
        for (var i = 1; i < custome_len; i++) {
            if(device_type == 'mob') {
                temp +=`<div class="deals_mobile_bought_caption skl_deal_list skeleton_loader"><div class="left_part"><div class="cap_box"><div class="first_bought"><a href="javascript:;" class="name text-14-medium"></a><span class="cash text-14-medium"></span></div><div class="second_bought"><a href="javascript:;" class="seller_name text-12-medium"></a><span class="seller_btn text-12-medium"></span><a href="javascript:;" class="payer_name text-12-medium"></a></div><a href="javascript:;" class="company_name text-14-medium"></a></div><div class="imagesbox"></div></div><div class="right_part"><div class="first_right"><p class="text-14-medium"></p><span class="text-14-semibold"></span></div><div class="second_right"><span class="ex_wrap text-12-medium"></span></div></div><a href="javascript:;" class="full_link"></a></div>`;
            } else {
                temp +=`<div class="deals_bought_caption skl_deal_list skeleton_loader"><div class="left_part"><div class="cap_box"><a href="javascript:;" class="name text-14-medium"></a><span class="cash text-14-medium"></span><a href="javascript:;" class="seller_name text-14-medium"></a><span class="seller_btn text-12-medium"></span><a href="javascript:;" class="payer_name text-14-medium"></a></div><a href="javascript:;" class="company_name text-14-medium"></a><div class="imagesbox"></div></div><div class="right_part"><div class="first_right"><div class="first"><p class="text-14-medium"></p></div><span class="ex_wrap text-14-medium"></span></div><div class="second_right"><p class="text-14-medium"></p><span class="text-14-semibold"></span></div></div><a href="javascript:;" class="full_link"></a></div>`;
            }
        }
        return temp;
    },
}

var btn_single_offer_loader = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="visually-hidden"></span>`;
var btn_common_loader = `<button class="btn btn-primary" type="button" disabled="disabled"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only"></span></button>`;