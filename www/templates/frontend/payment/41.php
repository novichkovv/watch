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
<div class="container" style="margin-top: 40px; ">

    <form action="<?php echo SITE_DIR; ?>checkout/success/" method="post">
        <div class="main-body col-md-8 col-sm-8 col-sm-offset-2 col-xs-offset-0 col-xs-12">
            <div id="panel" class="row" style="height: 500px; background-color: #fff">
                <div class="col-md-3 hidden-xs" style="background-color: #f2f2f2; height: 100%; padding: 0 !important;">
                    <div id="left-banner">
                        <!--                    <img style="width: 90%; margin: 10%;" src="--><?php //echo SITE_DIR; ?><!--images/paypal.png">-->
                    </div>
                </div>
                <br>
                <div class="col-md-9">
                    <img class="visible-xs" style="width: 70%; margin: 10px auto;" src="<?php echo SITE_DIR; ?>images/paypal.png">
                    <div id="account_info">
                        <h3 class="title">ข้อมูลบัญชี</h3>
                        <div class="row">
                            <div class="col-sm-6 col-md-8">
                                <div class="form-group">
                                    <label for="email">อีเมล์</label>
                                    <input id="email" class="form-control" placeholder="อีเมล์" type="email" name="user[email]" data-require="1" data-validate="email">
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-8">
                                <div class="form-group">
                                    <label for="phine">หมายเลขโทรศัพท์</label>
                                    <input id="phone" class="form-control" placeholder="หมายเลขโทรศัพท์" type="tel" name="user[phone]" data-validate="email">
                                </div>
                            </div>
                        </div>
                    </div>
                    <br><br>
                    <div class="row ">
                        <div class="col-md-6 col-sm-8 col-xs-12">
                            <input id="pay_btn" type="submit" name="order_btn" class="btn btn-lg btn-info btn-block" value="ปุ่มบันทึก" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="product_id" value="<?php echo $_GET['product_id']; ?>">
    </form>
</div>
<script type="text/javascript">
    $ = jQuery.noConflict();
    $(document).ready(function () {
        $("body").on("submit", "#address_form", function () {
            return validate('address_form')
        });
    });
</script>
<style>
    body {
        /*background: url(/images/1.jpg);*/
        /*background-color: #0a6aa1;*/
    }
</style>