/**
 * Created by asus1 on 01.06.2016.
 */
/**
 * Created by novichkov on 10.03.15.
 */
$ = jQuery.noConflict();
var $body = $("body");
$(document).ready(function()
{
    $.datepicker.setDefaults({
        numberOfMonths: 2,
        dateFormat: "yy-mm-dd"
    });
    $("#logout_button").click(function(e)
    {
        e.preventDefault();
        $("#log_out").submit();
    });
    $("#log-button").click(function()
    {
        $("#log").slideToggle();
    });
    $("#log").dblclick(function()
    {
        $(this).slideUp();
    });

    $(".datepicker").datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true
    });

    $('.phone-input').mask('999-999-9999AAAAAAAAAAAAAAAA', {'translation': {A: {pattern: /.*/}}});

    jQuery(document).ready(function() {
        Metronic.init(); // init metronic core componets
        Layout.init(); // init layout
        QuickSidebar.init() // init quick sidebar
        Index.init();
        Index.initDashboardDaterange();
        Index.initJQVMAP(); // init index page's custom scripts
        Index.initCalendar(); // init index page's custom scripts
        Index.initCharts(); // init index page's custom scripts
        Index.initChat();
        Index.initMiniCharts();
//        Index.initIntro();
        Tasks.initDashboardWidget();
    });

});


/**
 *
 * @param params
 */

var ajax = function ajax(params)
{
    var $preloader;
    if(params.nopreloader === undefined && params.header_preloader === undefined) {
        $preloader = $("#preloader-bg");
        $preloader.show();
    }
    if(params.header_preloader !== undefined) {
        $preloader = $("#header_preloader");
        $preloader.show();
    }

    if(!params.values) params.values = {};
    params.values.ajax = true;
    params.values.action = params.action;
    params.values.common = params.common;
    if(params.get_from_form)
    {
        var val;
        $("#" + params.get_from_form + " input, #" + params.get_from_form + " textarea, #" + params.get_from_form + " select").each(function()
        {
            if($(this).attr('type') == 'radio' || $(this).attr('type') == 'checkbox') {
                val = $("[name='" + $(this).attr('name') + "']:checked").val();
            } else {
                val = $(this).val();
            }
            params.values[$(this).attr('name')] = val;
        });
        $("#" + params.get_from_form + " .summernote").each(function()
        {
            val = $(this).code();
            params.values[$(this).attr('data-name')] = val;
        });
    }
    var res;
    $.ajax(
        {

            url: params.url ? params.url : '',
            type: 'post',
            data: params.values,
            success: function(result)
            {
                if(params.nopreloader === undefined) {
                    $preloader.hide();
                }
                params.callback(result);
                $(".datepicker").datepicker();
            }
        }
    );
};

/**
 *
 * @param form_id
 * @returns {boolean}
 */

var validate = function validate(form_id)
{
    var form = $("#" + form_id);
    var validate = true;
    $('.error-require, .error-validate, .error-min, .error-max, .error-one_ten, .error-numeric').each(function()
    {
        $(this).slideUp();
    });

    $(form).find('[data-require="1"], select.data-required').each(function()
    {
        if(!$(this).val() || $(this).val() == '' || $(this).val() == null)
        {
            console.log($(this).attr('name') + ' - ' + $(this).val());
            $(this).parent().find('.error-require').slideDown();
            validate = false;
        }
    });

    $(form).find('[data-validate="email"]').each(function()
    {
        var regexp = /^[-\w.]+@([A-z0-9][-A-z0-9]+\.)+[A-z]{2,4}$/;
        if($(this).val() && !regexp.test($(this).val())) {
            if(!$(this).attr('.error-require') || $(this).parent().find('.error-require').css('display') == 'none')
                $(this).parent().find('.error-validate').slideDown();
            validate = false;
        }
    });

    $(form).find('[data-validate="password"]').each(function()
    {
        if($(this).val() != $(form).find('[data-validate="rpassword"]').val())
        {
            if(!$(this).parent().find('.error-require').length || $(this).parent().find('.error-require').css('display') == 'none') {
                $(this).parent().find('.error-validate').slideDown();
            }
            validate = false;
        }
    });

    $(form).find('[data-min]').each(function()
    {
        var min = $(this).attr('data-min');
        if($(this).val().length < min && $(this).parent().find('.error-require').css('display') == 'none') {
            $(this).parent().find('.error-min').slideDown();
            validate = false;
        }
    });

    $(form).find('[data-max]').each(function()
    {
        var min = $(this).attr('data-max');
        if($(this).val().length < min && $(this).parent().find('.error-require').css('display') == 'none') {
            $(this).parent().find('.error-max').slideDown();
            validate = false;
        }
    });

    $(form).find('[data-one_ten="1"]').each(function()
    {
        var val = $(this).val();
        if((isNaN(parseInt(val)) || parseInt(val) < 0 || parseInt(val) > 10)) {
            $(this).parent().find('.error-one_ten').slideDown();
            validate = false;
        }
    });

    $(form).find('[data-validate="numeric"]').each(function()
    {
        var val = $(this).val();
        if(val && typeof val != 'undefined' && val != null && isNaN(parseInt(val))) {
            $(this).parent().find('.error-validate').slideDown();
            validate = false;
        }
    });

    $(form).find('[data-validate="emails"]').each(function()
    {
        var val = $(this).val();
        if(val) {
            var regexp = /^[-\w.]+@([A-z0-9][-A-z0-9]+\.)+[A-z]{2,4}$/;
            var arr = val.split(';');
            for(var i in arr) {
                if(arr[i] != '' && !regexp.test(arr[i])) {
                    $(this).parent().find('.error-validate').slideDown();
                    validate = false;
                }
            }
        }
    });

    return(validate);

};


/**
 *
 * @param id
 */

function ajax_datatable(id, display_records, options)
{
    if(display_records === undefined) {
        display_records = 10;
    }
    var params = {
        "destroy": $.fn.dataTable.isDataTable("#" + id),
        "bJQueryUI": false,
        "bAutoWidth": false,
        "iDisplayLength": display_records,
        //"sPaginationType": "full_numbers",
        "sDom": '<"datatable-header"Tfl><"datatable-scroll"t><"datatable-footer"ip>',
        "sAjaxSource": '?',
        "bServerSide": true,
        "fnServerParams": function ( aoData ) {
            aoData.push(
                { "name": "ajax", "value": true },
                { "name": "action", "value": id }
            );
            var params = Object();
            $("#" + id + ' .filter-field, .filter-field[data-id="' + id + '"]').each(function(){
                if($(this).val())
                    params[$(this).attr('name')] = {"value" : $(this).val(), "sign" : $(this).attr('data-sign')};
            });
            aoData.push({"name" : "params", "value" : JSON.stringify(params)});
        },
        "oLanguage": {
            "sLengthMenu": "<span></span> _MENU_",
            "oPaginate": { "sFirst": "First", "sLast": "Last", "sNext": "<i class=\"fa fa-angle-right\"></i>", "sPrevious": "<i class=\"fa fa-angle-left\"></i>" }
        },
        "oTableTools": {
            "sRowSelect": "single",
            "sSwfPath": "/media/swf/copy_csv_xls_pdf.swf",
            "aButtons": [
                {
                    "sExtends": "copy",
                    "sButtonText": "Copy",
                    "sButtonClass": "btn"
                },
                {
                    "sExtends": "print",
                    "sButtonText": "Print",
                    "sButtonClass": "btn"
                },
                {
                    "sExtends": "collection",
                    "sButtonText": "Save <span class='caret'></span>",
                    "sButtonClass": "btn btn-primary",
                    "aButtons": [ "csv", "xls", "pdf" ]
                }
            ]
        }
    };
    if(undefined !== options) {
        for(var key in options) {
            params[key] = options[key];
        }
    }
    var oTable = $("#" + id).dataTable(params);

    $('#' + id + ' .filter-field, .filter-field[data-id="' + id + '"]').change(function(){
        oTable.fnFilter();
    });

    $(".range-input-1, .range-input-2").datepicker({
        format: 'yyyy-mm-dd'
    });

    $('#' + id + ' .filter-range, .filter-range[data-id="' + id + '"]').change(function() {
        var $cont = $(this).closest('.date-range');
        var input1 = $cont.find('.range-input-1');
        var input2 = $cont.find('.range-input-2');
        var input1_val = input1.val() ? input1.val() : '2010-01-01';
        var input2_val = input2.val() ? input2.val() : '2030-01-01';
        var $hidden_input = $cont.find('.range-hidden-input');
        var value = input1_val + ' - ' + input2_val;
        $hidden_input.val(value);
        oTable.fnFilter();
    });

    return oTable;
}

/**
 *
 * @param selector
 * @param action
 */

function ajax_select2(selector, action)
{
    $(selector).select2({
        ajax: {
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params,
                    action: action,
                    ajax: 'true'
                };
            },
            results: function(data) {
                return {  results: data };

            },
            cache: true
        },
        minimumInputLength: 2
    });
}


/**
 *
 * @param params
 */

function ajax_file_upload(params)
{
    var btnUpload = $('#'+ (params.button ? params.button : 'upload_btn'));
    var status = $('#' + (params.status ? params.status : 'upload_status'));
    new AjaxUpload(btnUpload, {
        action: params.action ? params.action : '',
        name: params.name ? params.name : 'file',
        data: params.data,
        onSubmit: function(file, ext){
            if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext)) && typeof params.check != 'function'){
                status.text('Only JPG, PNG or GIF files are allowed');
                return false;
            } else if(typeof params.check == 'function') {
                if(!params.check(file, ext)) {
                    return false;
                }
            }
            status.html(params.status_upload ? params.status_upload : '<img src="../../assets/global/img/loading-spinner-grey.gif" />');
        },
        onComplete: function(file, msg){
            console.log(msg);
            status.html('');
            try {
                var respond = JSON.parse(msg);
            }
            catch (e) {
                console.log(e);
                params.error();
            }
            console.log(respond);

            params.success(respond);
        }
    });
}

/**
 *
 * @param function_name
 * @returns {boolean}
 */

function function_exists( function_name ) {
    if (typeof function_name == 'string'){
        return (typeof window[function_name] == 'function');
    } else{
        return (function_name instanceof Function);
    }
}

/**
 *
 * @param needle
 * @param haystack
 * @returns {boolean}
 */

function in_array(needle, haystack) {
    var found = false, key;

    for (key in haystack) {
        if (haystack[key] == needle) {
            found = true;
            break;
        }
    }
    return found;
}

function ajax_respond(msg, success, unsuccess, ret) {

    try {
        var respond = JSON.parse(msg);
    }
    catch (e) {
        if(ret) {
            return e;
        } else {
            toastr.error('Unexpexted error!');
        }
    }
    if(respond.status == 1) {
        success(respond);
        return false;
    } else {
        if(ret) {
            return respond.error;
        } else {
            for(var i in respond.error) {
                for(var j in respond.error[i]) {
                    for(var type in respond.error[i][j]) {
                        toastr.error(respond.error[i][j][type]['text']);
                    }
                }
            }
        }
        if(typeof unsuccess == 'function') {
            unsuccess(respond);
        }
    }
}

/**
 *
 * @param selector
 * @returns {{}}
 */

function get_from_form(selector)
{
    var val;
    var res = {};
    $(selector + " input, " + selector + " textarea, " + selector + " select").each(function()
    {
        if($(this).attr('type') == 'radio' || $(this).attr('type') == 'checkbox') {
            val = $("[name='" + $(this).attr('name') + "']:checked").val();
        } else {
            val = $(this).val();
        }
        res[$(this).attr('name')] = val;
    });
    $(selector + " .summernote").each(function()
    {
        val = $(this).code();
        res[$(this).attr('data-name')] = val;
    });

    return res;
}

function crud(params)
{
    if(undefined === params) {
        params = {};
    }
    if(undefined === params.prefix) {
        params.prefix = '';
    }
    var defaults = {
        data_table: params.prefix + 'get_table',
        add_btn: "#" + params.prefix + "add_btn",
        edit_btn: "." + params.prefix + "edit_btn",
        save_btn: "#" + params.prefix + "save_btn",
        form: "#" + params.prefix + "form",
        form_container: "#" + params.prefix + "form_container",
        get_form_action: params.prefix + "get_form",
        save_form_action: params.prefix + "save_form",
        form_modal: "#" + params.prefix + "form_modal",
        delete_modal: "#" + params.prefix + "delete_modal",
        delete_btn: "." + params.prefix + "delete_btn",
        delete_submit_btn: "#" + params.prefix + "delete_btn",
        get_form_callback: function() {

        },
        save_success_callback: function() {
            Notifier.success('Успешно!');
            $(params.form_modal).modal('hide');
            if(params.data_table) {
                ajax_datatable(params.data_table);
            }
        },
        save_fail_callback: function() {
            Notifier.danger('Неудачно!');
        },
        delete_callback: function () {
            Notifier.success('Успешно!');
            $(params.delete_modal).modal('hide');
            if(params.data_table) {
                ajax_datatable(params.data_table);
            }
        }
    };

    for(var i in defaults) {
        if(undefined === params[i]) {
            params[i] = defaults[i];
        }
    }

    if(params.data_table) {
        ajax_datatable(params.data_table);
    }

    $("body").on("click", params.delete_btn, function () {
        var id = $(this).attr('data-id');
        $(params.delete_submit_btn).attr('data-id', id);
    });

    $("body").on("click", params.delete_submit_btn, function () {
        var id = $(this).attr('data-id');
        var p = {
            'action': 'delete_item',
            'values': {id: id},
            'callback': function (msg) {
                ajax_respond(msg,
                    function (respond) { //success
                        params.delete_callback(respond);
                    },
                    function (respond) { //fail
                    }
                );
            }
        };
        ajax(p);
    });

    $(params.add_btn).click(function() {
        var p = {
            'action': params.get_form_action,
            'callback': function (msg) {
                ajax_respond(msg,
                    function (respond) { //success
                        $(params.form_container).html(respond.template);
                        params.get_form_callback(respond);
                    },
                    function (respond) { //fail
                    }
                );
            }
        };
        ajax(p);
    });

    $("body").on('click', params.edit_btn, function() {
        var id = $(this).attr('data-id');
        var p = {
            'action': params.get_form_action,
            'values': {'id': id},
            'callback': function (msg) {
                ajax_respond(msg,
                    function (respond) { //success
                        $(params.form_container).html(respond.template);
                        params.get_form_callback(respond);
                    },
                    function (respond) { //fail
                    }
                );
            }
        };
        ajax(p);
    });

    $("body").on("submit", params.form, function (e) {
        e.preventDefault();
        var form_id = $(this).attr('id');
        console.log(form_id);
        if(validate(form_id)) {
            var p = {
                'action': params.save_form_action,
                'get_from_form': form_id,
                'callback': function (msg) {
                    ajax_respond(msg,
                        function (respond) { //success
                            params.save_success_callback(respond);
                        },
                        function (respond) { //fail
                            params.save_fail_callback(respond);
                        }
                    );
                }
            };
            ajax(p);
        }
        return false;
    });
}

function round(x)
{
    if(isNaN(x)) {
        throw 'Round function expexts argument 1 to be a number';
    }
    return Math.round(parseFloat(x) * 100) / 100;
}
"use strict";!function(t){"function"==typeof define&&define.amd?define(["jquery"],t):"object"==typeof exports?module.exports=t(require("jquery")):t(jQuery||Zepto)}(function(t){var a=function(a,e,n){a=t(a);var r,s=this,o=a.val();e="function"==typeof e?e(a.val(),void 0,a,n):e;var i={invalid:[],getCaret:function(){try{var t,e=0,n=a.get(0),r=document.selection,s=n.selectionStart;return r&&-1===navigator.appVersion.indexOf("MSIE 10")?(t=r.createRange(),t.moveStart("character",a.is("input")?-a.val().length:-a.text().length),e=t.text.length):(s||"0"===s)&&(e=s),e}catch(o){}},setCaret:function(t){try{if(a.is(":focus")){var e,n=a.get(0);n.setSelectionRange?n.setSelectionRange(t,t):n.createTextRange&&(e=n.createTextRange(),e.collapse(!0),e.moveEnd("character",t),e.moveStart("character",t),e.select())}}catch(r){}},events:function(){a.on("keyup.mask",i.behaviour).on("paste.mask drop.mask",function(){setTimeout(function(){a.keydown().keyup()},100)}).on("change.mask",function(){a.data("changed",!0)}).on("blur.mask",function(){o===a.val()||a.data("changed")||a.triggerHandler("change"),a.data("changed",!1)}).on("keydown.mask, blur.mask",function(){o=a.val()}).on("focus.mask",function(a){n.selectOnFocus===!0&&t(a.target).select()}).on("focusout.mask",function(){n.clearIfNotMatch&&!r.test(i.val())&&i.val("")})},getRegexMask:function(){for(var t,a,n,r,o,i,c=[],l=0;l<e.length;l++)t=s.translation[e.charAt(l)],t?(a=t.pattern.toString().replace(/.{1}$|^.{1}/g,""),n=t.optional,r=t.recursive,r?(c.push(e.charAt(l)),o={digit:e.charAt(l),pattern:a}):c.push(n||r?a+"?":a)):c.push(e.charAt(l).replace(/[-\/\\^$*+?.()|[\]{}]/g,"\\$&"));return i=c.join(""),o&&(i=i.replace(new RegExp("("+o.digit+"(.*"+o.digit+")?)"),"($1)?").replace(new RegExp(o.digit,"g"),o.pattern)),new RegExp(i)},destroyEvents:function(){a.off(["keydown","keyup","paste","drop","blur","focusout",""].join(".mask "))},val:function(t){var e,n=a.is("input"),r=n?"val":"text";return arguments.length>0?(a[r]()!==t&&a[r](t),e=a):e=a[r](),e},getMCharsBeforeCount:function(t,a){for(var n=0,r=0,o=e.length;o>r&&t>r;r++)s.translation[e.charAt(r)]||(t=a?t+1:t,n++);return n},caretPos:function(t,a,n,r){var o=s.translation[e.charAt(Math.min(t-1,e.length-1))];return o?Math.min(t+n-a-r,n):i.caretPos(t+1,a,n,r)},behaviour:function(a){a=a||window.event,i.invalid=[];var e=a.keyCode||a.which;if(-1===t.inArray(e,s.byPassKeys)){var n=i.getCaret(),r=i.val(),o=r.length,c=o>n,l=i.getMasked(),u=l.length,h=i.getMCharsBeforeCount(u-1)-i.getMCharsBeforeCount(o-1);return i.val(l),!c||65===e&&a.ctrlKey||(8!==e&&46!==e&&(n=i.caretPos(n,o,u,h)),i.setCaret(n)),i.callbacks(a)}},getMasked:function(t){var a,r,o=[],c=i.val(),l=0,u=e.length,h=0,f=c.length,v=1,d="push",k=-1;for(n.reverse?(d="unshift",v=-1,a=0,l=u-1,h=f-1,r=function(){return l>-1&&h>-1}):(a=u-1,r=function(){return u>l&&f>h});r();){var p=e.charAt(l),g=c.charAt(h),m=s.translation[p];m?(g.match(m.pattern)?(o[d](g),m.recursive&&(-1===k?k=l:l===a&&(l=k-v),a===k&&(l-=v)),l+=v):m.optional?(l+=v,h-=v):m.fallback?(o[d](m.fallback),l+=v,h-=v):i.invalid.push({p:h,v:g,e:m.pattern}),h+=v):(t||o[d](p),g===p&&(h+=v),l+=v)}var y=e.charAt(a);return u!==f+1||s.translation[y]||o.push(y),o.join("")},callbacks:function(t){var r=i.val(),s=r!==o,c=[r,t,a,n],l=function(t,a,e){"function"==typeof n[t]&&a&&n[t].apply(this,e)};l("onChange",s===!0,c),l("onKeyPress",s===!0,c),l("onComplete",r.length===e.length,c),l("onInvalid",i.invalid.length>0,[r,t,a,i.invalid,n])}};s.mask=e,s.options=n,s.remove=function(){var t=i.getCaret();return i.destroyEvents(),i.val(s.getCleanVal()),i.setCaret(t-i.getMCharsBeforeCount(t)),a},s.getCleanVal=function(){return i.getMasked(!0)},s.init=function(e){if(e=e||!1,n=n||{},s.byPassKeys=t.jMaskGlobals.byPassKeys,s.translation=t.jMaskGlobals.translation,s.translation=t.extend({},s.translation,n.translation),s=t.extend(!0,{},s,n),r=i.getRegexMask(),e===!1){n.placeholder&&a.attr("placeholder",n.placeholder),a.attr("autocomplete","off"),i.destroyEvents(),i.events();var o=i.getCaret();i.val(i.getMasked()),i.setCaret(o+i.getMCharsBeforeCount(o,!0))}else i.events(),i.val(i.getMasked())},s.init(!a.is("input"))};t.maskWatchers={};var e=function(){var e=t(this),r={},s="data-mask-",o=e.attr("data-mask");return e.attr(s+"reverse")&&(r.reverse=!0),e.attr(s+"clearifnotmatch")&&(r.clearIfNotMatch=!0),"true"===e.attr(s+"selectonfocus")&&(r.selectOnFocus=!0),n(e,o,r)?e.data("mask",new a(this,o,r)):void 0},n=function(a,e,n){n=n||{};var r=t(a).data("mask"),s=JSON.stringify,o=t(a).val()||t(a).text();try{return"function"==typeof e&&(e=e(o)),"object"!=typeof r||s(r.options)!==s(n)||r.mask!==e}catch(i){}};t.fn.mask=function(e,r){r=r||{};var s=this.selector,o=t.jMaskGlobals,i=t.jMaskGlobals.watchInterval,c=function(){return n(this,e,r)?t(this).data("mask",new a(this,e,r)):void 0};return t(this).each(c),s&&""!==s&&o.watchInputs&&(clearInterval(t.maskWatchers[s]),t.maskWatchers[s]=setInterval(function(){t(document).find(s).each(c)},i)),this},t.fn.unmask=function(){return clearInterval(t.maskWatchers[this.selector]),delete t.maskWatchers[this.selector],this.each(function(){var a=t(this).data("mask");a&&a.remove().removeData("mask")})},t.fn.cleanVal=function(){return this.data("mask").getCleanVal()},t.applyDataMask=function(a){a=a||t.jMaskGlobals.maskElements;var n=a instanceof t?a:t(a);n.filter(t.jMaskGlobals.dataMaskAttr).each(e)};var r={maskElements:"input,td,span,div",dataMaskAttr:"*[data-mask]",dataMask:!0,watchInterval:300,watchInputs:!0,watchDataMask:!1,byPassKeys:[9,16,17,18,36,37,38,39,40,91],translation:{0:{pattern:/\d/},9:{pattern:/\d/,optional:!0},"#":{pattern:/\d/,recursive:!0},A:{pattern:/[a-zA-Z0-9]/},S:{pattern:/[a-zA-Z]/}}};t.jMaskGlobals=t.jMaskGlobals||{},r=t.jMaskGlobals=t.extend(!0,{},r,t.jMaskGlobals),r.dataMask&&t.applyDataMask(),setInterval(function(){t.jMaskGlobals.watchDataMask&&t.applyDataMask()},r.watchInterval)});