<!DOCTYPE html>
<!-- saved from url=(0040)http://reals-gooods.ru/antigravitycase1/ -->
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Антигравитационный чехол для iPhone, Samsung</title>
    
    <meta name="viewport" content="width=480">
    <meta name="description" content="Уникальная новинка - чехол для телефона, который крепится к любой поверхности!">
    <meta name="keywords" content="чехол для айфона, чехол для самсунг, антигравитационный чехол, чехол для iPhone, чехол для samsung, купить чехол для телефона">
    
    <link rel="icon" href="http://reals-gooods.ru/antigravitycase1/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="http://reals-gooods.ru/antigravitycase1/favicon.ico" type="image/x-icon">

    <link href="<?php echo $dir; ?>css/css.css" rel="stylesheet">
    <link media="all" href="<?php echo $dir; ?>css/main.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="<?php echo $dir; ?>js/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo $dir; ?>js/init.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo $dir; ?>css/roboto.css">
    <script src="<?php echo $dir; ?>js/jquery.js" type="text/javascript"></script>
    <script src="<?php echo $dir; ?>js/plugins.js" type="text/javascript"></script>
    <script src="<?php echo $dir; ?>js/detect.js" type="text/javascript"></script>
    <script>
        !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
            n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
            document,'script','https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '<?php echo ($pixel ? $pixel : '1816280065250492'); ?>');
        fbq('track', 'PageView');
        fbq('track', 'AddToCart');
    </script>
    <noscript><img height="1" width="1" style="display:none"
                   src="https://www.facebook.com/tr?id=<?php echo ($pixel ? $pixel : '1816280065250492'); ?>&ev=PageView&noscript=1"
        /></noscript>
</head>
    <body>
    <div class="container">
        <div id="step_1" class="step active" style="padding-top: 0 !important;">
            <div style="width: 100%; padding-top: 20px; padding-bottom: 30px; background-color: white; font-size: 35px;">
                <span style="color: #24221f; text-shadow: 1px 1px #bebebd">Выберите модель</span>
            </div>
            <div class="model-button" data-model="1">
                <div class="h1">IPhone 5, 5s</div>
                <div class="img">
                    <img src="<?php echo SITE_DIR; ?>templates/frontend/landings/gravity_checkout/img/iphone5.jpg">
                </div>
            </div>
            <div class="model-button" data-model="2">
                <div class="h1">IPhone 6, 6s</div>
                <div class="img">
                    <img src="<?php echo SITE_DIR; ?>templates/frontend/landings/gravity_checkout/img/iphone6.jpg">
                </div>
            </div>
        </div>
        <div id="step_2" class=" step" style="padding-top: 0 !important;">
            <div style="width: 100%; padding-top: 20px; padding-bottom: 30px; background-color: white; font-size: 35px;">
                <span style="color: #24221f; text-shadow: 1px 1px #bebebd">Выберите Цвет</span>
            </div>
            <div class="color-button" data-color="1">
                <div class="h1">Черный</div>
                <div class="img">
                    <img src="<?php echo SITE_DIR; ?>templates/frontend/landings/gravity_checkout/img/black.jpg">
                </div>
            </div>
            <div class="color-button" data-color="2">
                <div class="h1">Белый</div>
                <div class="img">
                    <img src="<?php echo SITE_DIR; ?>templates/frontend/landings/gravity_checkout/img/white.jpg">
                </div>
            </div>
            <div class="navigate-button" data-hide="2" data-show="1">< Выбор модели</div>
        </div>

    </div>
    <script type="text/javascript">
        $ = jQuery.noConflict();
        $(document).ready(function () {
//            $(".step").click(function () {
//                var step = $(this).attr('data-step');
//                var next_step = parseInt(step) + 1;
//                $(this).
//            })
            $("body").on('click', '.navigate-button', function () {
                var show_step = $(this).attr('data-show');
                var hide_step = $(this).attr('data-hide');
                step_back(hide_step, show_step);
            });
            $("body").on('click', '.model-button', function() {
                $('.model-button').removeClass('selected');
                $(this).addClass('selected');
//                alert(1);
                step(1, 2);
//                $("#step_1").animate({
//                    'margin-left': "-=30",
//                    'opacity': 0
//                }, 300, function () {
//                    $("#step_1").hide();
//                    $("#step_2").animate({
//                        'margin-left': "-=30",
//                        'opacity': '1'
//                    });
//                });

//                $("#step_1").fadeOut();
            });
        });
        function step(hide_step, show_step)
        {
            var $show_step = $("#step_" + show_step);
            var $hide_step = $("#step_" + hide_step);
            $show_step.css('margin-left', 30);
            $hide_step.animate({
                'margin-left': "-=30",
                'opacity': 0
            }, 300, function () {
                $hide_step.hide();
                $show_step.show();
                $show_step.animate({
                    'margin-left': "-=30",
                    'opacity': '1'
                });
            });
        }

        function step_back(hide_step, show_step)
        {
            var $show_step = $("#step_" + show_step);
            var $hide_step = $("#step_" + hide_step);
            $show_step.css('margin-left', 30);
            $("#step_" + hide_step).animate({
                'margin-left': "+=30",
                'opacity': 0
            }, 300, function () {
                $hide_step.hide();
                $show_step.show();
                $show_step.animate({
                    'margin-left': "-=30",
                    'opacity': '1'
                });
            });
        }
    </script>
    </body>
</html>