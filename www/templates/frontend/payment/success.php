<!-- Facebook Pixel Code -->
<script>
    !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
        n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
        document,'script','https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '327972760869811');
    fbq('track', 'PageView');
    fbq('track', 'AddToCart');
</script>
<noscript><img height="1" width="1" style="display:none"
               src="https://www.facebook.com/tr?id=327972760869811&ev=PageView&noscript=1"
    /></noscript>
<!-- DO NOT MODIFY -->
<!-- End Facebook Pixel Code -->
<style>
    @media screen and (min-width: 768px) {
        html {
            background: url(/images/1.jpg) no-repeat center center fixed;

            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }
        body {
            background-color: rgba(2, 8, 12, 0.69);
            height: 100%;
            margin: 0;
            position: absolute;
            width: 100%;
        }
    }

    #left-banner {
        width: 100%;
        background-color: #ffffff;
    }
    .navbar {
        display: none !important;
    }
    .title {
        font-size: 2.3rem;
        line-height: 1.2;
        padding-bottom: 0.3em;
        border-bottom: 1px solid #e5e5e5;


    }
    input {
        border-radius: 0 !important;
    }
    @media screen and (max-width: 767px) {
        .container {
            width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
        }
        .main-body {
            width: 100% !important;
            margin: 0 !important;
        }
    }
</style>
<form method="post" id="form" action="payment">
    <div class="container" style="margin-top: 40px; ">
        <div class="main-body col-md-8 col-sm-8 col-sm-offset-2 col-xs-offset-0 col-xs-12">
            <div id="panel" class="row" style="height: 550px; background-color: #fff">
                <div class="col-md-3 hidden-xs" style="background-color: #f2f2f2; height: 100%; padding: 0 !important;">

                    <!--                    <div id="left-banner">-->
                    <!--                        <img style="width: 90%; margin: 10%;" src="--><?php //echo SITE_DIR; ?><!--images/paypal.png">-->
                    <!--
                            </div>-->
                </div>

                <div class="col-md-9">
                    <div style="background-color: #0070ba;    border-radius: 25px;
    font-size: 15px;
    color: #fff;
    margin-top: 30px;
    text-align: center;
    line-height: 1.5;
    padding-bottom: 15px;
    padding-top: 13px;
    padding-left: 30px;
    padding-right: 30px;">
                        คำขอของคุณได้รับการส่ง</div>
                    <br><br><br>
                    <div id="account_info">
                        <h4 style="font-size: 30px;" class="text-center">
                            ขอแสดงความยินดี!
                        </h4>
                        <div class="text-center" style="font-size: 20px;">
                            ผู้ประกอบการจะได้รับในการติดต่อกับคุณในไม่ช้า
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</form>
<script type="text/javascript">
    $ = jQuery.noConflict();
    $(document).ready(function () {
        $("#cc_number").mask('9999 9999 999999999999');
        var $month = $("#cc_month");
        var $year = $("#cc_year");
        var $cvv = $("#cc_cvv");
        var $name = $("#cc_name");
        $month.mask('99');
        $month.keyup(function() {
            if($(this).val().length == 2) {
                $year.focus();
            }
        });
        $year.mask('99');
        $year.keyup(function() {
            if($(this).val().length == 2) {
                $cvv.focus();
            }
        });
        $year.mask('999');
        $cvv.keyup(function() {
            if($(this).val().length == 3) {
                $name.focus();
            }
        });
        $name.keyup(function() {
            $(this).val($(this).val().toUpperCase());
        });

        $("body").on("submit", "#form", function () {
            return validate('form')
        });
    });
</script>
<style>
    body {
        /*background: url(/images/1.jpg);*/
        /*background-color: #0a6aa1;*/
    }
</style>