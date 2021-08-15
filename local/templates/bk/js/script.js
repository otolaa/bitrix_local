/**/
var showMessage = function(text, title, cansel, mClass) {
    /**/
    $(".popup-form").remove();
    $(".modal-backdrop").remove();
    var modalClass = ["modal-md","modal-lg","modal-xl"];
    var mClass = (mClass ? mClass: 0);
    var cansel = (cansel ? cansel : false);
    var submit = (submit ? submit : "Отправить");
    var title = (title ? title : "Сообщение");
    var modalHeader = $('<div/>').addClass('modal-header').append('<h5 class="modal-title">'+ title +'</h5>'+'<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>');
    var modalBody = $('<div/>').addClass('modal-body').append(text);
    var modalFooter = (cansel ? $('<div/>').addClass('modal-footer').append('<button type="button" class="btn btn-default" data-dismiss="modal">'+ cansel +'</button>') : $('<div/>').addClass('modal-footer'));
    /**/
    var modalContent = $('<div/>').addClass('modal-content').append(modalHeader).append(modalBody).append(modalFooter);
    var modalDialog = $('<div/>').addClass('modal-dialog modal-dialog-centered').addClass(modalClass[mClass]).html(modalContent);
    var popup = $('<div/>').addClass('popup-form').addClass('modal').addClass('fade').attr("tabindex", -1).attr("role", "dialog").attr("aria-labelledby", "popup-form").append(modalDialog).appendTo('body');
    $('.popup-form').modal();
}

/**/
var showWait = function () {
    $(".showWait").remove();
    var scrolled = window.pageYOffset || document.documentElement.scrollTop; /* узнаем отступ от прокрутки окна чтобы было видно загрузчик и т.д. */
    scrolled = scrolled + 200;
    $('<div/>').addClass('showWait').css('top', scrolled+'px').append('<img src="/static/loading_ico.svg">').appendTo('body');
    return false;
}

var closeWait = function () {
    $(".showWait").remove();
    return false;
}

/* addFormSubmitNew */
var addFormSubmitNew = function (event) {
    event.preventDefault();
    var req = $(this).find('[required]'), _submit = $(this).find('button[type=submit]');
    var error = false;
    var url = $(this).attr("action");
    req.each(function() {
        /* если не checkbox */
        if($(this).attr('type') != "checkbox") {
            if ($(this).val() == "") {
                $(this).css({'border-color':'#dc3545','color':'#dc3545'});
                if ($(this).parent().find('.req-notice').length == 0) {
                    //$(this).parent().append('<span class=req-notice>заполните обязательное поле</span>');
                }
                error = true;
            } else {
                $(this).css({'border-color':'#9a9da0','color':'#000'});
                $(this).parent().find('.req-notice').remove();
            }
        }
        /* если он майл */
        if($(this).attr('type') != "checkbox" && $(this).val() != "" && $(this).attr('type') == 'email') {
            var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
            if(reg.test($(this).val()) == false) {
                $(this).css({'border-color':'#dc3545','color':'#dc3545'});
                error = true;
            }
        }
        /* если он checkbox */
        if($(this).attr('type') == "checkbox") {
            if($(this).prop("checked") == false){
                $(this).parent().find('span').css({'border-color':'#dc3545'});
                if ($(this).parent().parent().find('.req-notice').length == 0) {
                    //$(this).parent().parent().append('<div class=req-notice>заполните обязательное поле</div>');
                }
                error = true;
            }else{
                $(this).parent().parent().find('span').css({'background':'','border-color':'','color':''});
                $(this).parent().parent().find('.req-notice').remove();
            }
        }
    });
    if(error){
        return false;
    }
    $.ajax({
        url: url,
        type: $(this).attr("method"),
        dataType: "JSON",
        data: new FormData(this),
        processData: false,
        contentType: false,
        beforeSend: function() { _submit.attr("disabled", 'disabled'); showWait(); },
        complete: function() { _submit.removeAttr("disabled"); closeWait(); },
        success: function (res){
            if(res.redirect_URL){
                if(res.html){ showMessage(res.html, res.title, res.cansel); }
                window.location.replace(res.redirect_URL);
            }else if(res.error){
                /**/
                showMessage(res.error, res.title, res.cansel, res.mClass);
                if(res.jq){ JQ(res.jq);	}
            }else if(res.alert){
                /**/
                showMessage(res.alert, res.title, res.cansel, res.mClass);
                if(res.jq){ JQ(res.jq);	}
            }else if(res.reload){
                window.location.replace(document.URL);
            }else if(res.setcookie){
                /**/
                setcookie(res.setcookie, res.value, res.expires, res.path, res.domain, res.secure);
                /*setCookies(res.setcookie, res.value);*/
                if(res.jq){ JQ(res.jq); }
                if(res.redirect_link){ window.location.replace(res.redirect_link); }
            }else if(res.jq){
                /**/
                JQ(res.jq);
            }else{
                /**/
            }
        },
        error: function (res){
            console.log(res);
        }
    });
    return false;
}

/* JQ */
var JQ = function(jq) {
    $.each(jq, function(i, n){
        /**/
        switch (i) {
            case "remove":
                $.each(n, function(select, value){
                    $(select).remove();
                });
                break;
            case "val":
            case "html":
            case "text":
            case "prepend":
            case "append":
            case "hide":
            case "show":
                $.each(n, function(select, value){
                    $(select)[i](value);
                });
                break;
            case "attr":
                $.each(n, function(select, value){
                    $(select).attr({"rel":value});
                });
                break;
            case "attributeName":
                $.each(n, function(select, value){
                    $.each(value, function(atr, px){
                        $(select).attr(atr, px);
                    });
                });
                break;
            case "CSS":
                $.each(n, function(select, value){
                    $.each(value, function(atr, px){
                        $(select).css(atr, px);
                    });
                });
                break;
            case "reset":
                $.each(n, function(select, value){
                    $(select).trigger('reset');
                });
                break;
            case "replaceWith":
                $.each(n, function(select, value){
                    $(select).replaceWith(value);
                });
                break;
            case "modal":
                $.each(n, function(select, value){
                    $(select).modal(value);
                });
                break;
            case "reCaptcha":
                /* return Google reCaptcha V3 */
                grecaptcha.ready(function (){
                    grecaptcha.execute(n.tokenKey,{ action:n.sid}).then(function(token){
                        var recaptchaResponse = document.getElementById(n.recaptchaResponse);
                        recaptchaResponse.value = token;
                    });
                });
                break;
            /* default: alert('***'); */
        }
    });
}

$(document).ready(function () {
    /* плавный скроулинг якорей */
    $("body").on('click', '[href*="#"]', function(e){
        e.preventDefault();
        var fixed_offset = 60;
        $('html,body').stop().animate({ scrollTop: $(this.hash).offset().top - fixed_offset }, 1000);
        return false;
    });
    /* phone
    $.mask.definitions['~'] = "[+-]";
    $('input.phone').mask("+7(999) 999 99-99"); */
    /* the submit forms */
    $(document).on("submit", "form.SubmitFormAjax", addFormSubmitNew);
});