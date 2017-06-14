// Выгрузка cookie
function getCookie(name) {
    var matches = document.cookie.match(new RegExp(
        "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ))
    return matches ? decodeURIComponent(matches[1]) : undefined
}


function lastpack(numpack) {
    var minNumPack = 6; // Минимальное количество упаковок
    var lastClass = $('.lastpack'); // Объект
    var numpackCookie = getCookie("lastpack");

    if(numpackCookie == undefined) {
        document.cookie = numpack;
    } else {
        var numpack =  numpackCookie;
    }
    
    if (numpack > minNumPack) {
        numpack--;

        var numObj = new Array();
        if (numpack < 10) {
            numObj[0] = "0";
            numObj[1] = numpack;
        } else {
            var numObj = numpack+"";
        }

        document.cookie = "lastpack="+numpack;
        lastClass.html("<li>0</li><li>"+numObj[0]+"</li><li>"+numObj[1]+"</li>");
    } else {
        lastClass.html("<li>0</li><li>0</li><li>"+minNumPack+"</li>");
    }

    setTimeout(lastpack, 45000, numpack);
}

$(document).ready(function() {

    // Подгрузка цен
    $('[name="country"]').on('change', function() {
        var geoKey = $(this).find('option:selected').val();
        var data = $jsonData.prices[geoKey];
        var price = data.price;
        var currency = data.currency

        $('.price_land_s1').text(price);
        $('.price_land_curr').text(currency);
    });

    // Плавный скролл
    // $('a[href*=#]').click( function(){
    //     var scroll_el = $(this).attr('href');
    //     if ($(scroll_el).length != 0) {
    //         $('html, body').animate({ scrollTop: $(scroll_el).offset().top }, 500);
    //     }
    //     return false;
    // });
    (function anchors() {

      var link = $('.anchor');

      link.on('click', menuAnchor);

      function menuAnchor(e) {
        e.preventDefault();
        var anchor = $(this).attr('href'),
            toTop = $(anchor).offset().top;
        $('body, html').animate({scrollTop : toTop}, 500);
      }
    })();

    // Инициализация таймера
    initializeClock('timer', deadline);

    // Инициализация функции lastpack
    lastpack(20);

    // Смена цвета
    $('.color-block ul>li').click(function() {
        $('body').find('input.dop_params').val($(this).attr('value'));
        $('body').find('.color-block ul').children('li').removeClass('active');
        $('body').find('.info-block3 .content ul>li').children('div').removeClass('active');
        $('body').find('.info-block3 .preview>img').hide();
        $('body').find('.color-block ul>li.' + $(this).attr('class')).addClass('active');
        $('body').find('.info-block3 .content ul>li[value="' + $(this).attr('value') + '"]>div').addClass('active');
        $('body').find('.info-block3 .preview>img[alt="' + $(this).attr('value') + '"]').fadeIn();
        $(this).parent().children('li').removeClass('active');
        $(this).addClass('active');
    });
    
    $('.info-block3 .content ul>li>div').click(function() {
        $('body').find('input.dop_params').val($(this).attr('value'));
        $('body').find('.info-block3 .content ul>li').children('div').removeClass('active');
        $(this).parents('.right-side').find('.preview>img').hide();
        $('body').find('.color-block ul').children('li').removeClass('active');
        $('body').find('.info-block3 .content ul>li.' + $(this).parent().attr('class') + '>div').addClass('active');
        $('body').find('.info-block3 .preview>img[alt="' + $(this).parent().attr('value') + '"]').fadeIn();
        $('body').find('.color-block ul>li[value="' + $(this).parent().attr('value') + '"]').addClass('active');
        $(this).parent().children('div').removeClass('active');
        $(this).addClass('active');
    });

});