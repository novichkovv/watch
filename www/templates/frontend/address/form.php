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

    <div class="main-body col-md-8 col-sm-8 col-sm-offset-2 col-xs-offset-0 col-xs-12">
        <div id="panel" class="row" style="height: 500px; background-color: #fff">
            <div class="col-md-3 hidden-xs" style="background-color: #f2f2f2; height: 100%; padding: 0 !important;">
                <div id="left-banner">
                    <img style="width: 90%; margin: 10%;" src="<?php echo SITE_DIR; ?>images/paypal.png">
                </div>
            </div>
            <div class="col-md-9">
                <img class="visible-xs" style="width: 70%; margin: 10px auto;" src="<?php echo SITE_DIR; ?>images/paypal.png">
                <div id="account_info">
                    <h3 class="title">ข้อมูลบัญชี</h3>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="email">อีเมล์</label>
                                <input id="email" class="form-control" placeholder="อีเมล์" type="email" name="user[email]" data-require="1" data-validate="email">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="phine">หมายเลขโทรศัพท์</label>
                                <input id="phone" class="form-control" placeholder="หมายเลขโทรศัพท์" type="tel" name="user[phone]" data-validate="email">
                            </div>
                        </div>
                    </div>
                </div>
                <div id="payment_info">
                    <h3 class="title">ข้อมูลการชำระเงิน</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cc_number">หมายเลขบัตร</label>
                                <input type="text" name="cc_number" placeholder="XXXX XXXX XXXX XXXX" class="form-control" id="cc_number">
                            </div>
                        </div>
                        <div class="col-md-2 col-xs-4">
                            <div class="form-group">
                                <label for="cc_month">เดือน</label>
                                <input type="text" name="cc_month" placeholder="<?php echo date('m'); ?>" class="form-control" id="cc_month">
                            </div>
                        </div>
                        <div class="col-md-2 col-xs-4">
                            <div class="form-group">
                                <label for="cc_year">ปี</label>
                                <input type="text" name="cc_year" placeholder="<?php echo date('y'); ?>" class="form-control" id="cc_year">
                            </div>
                        </div>
                        <div class="col-md-2 col-xs-4">
                            <div class="form-group">
                                <label for="cc_cvv">CVV</label>
                                <input type="text" name="cc_cvv" placeholder="XXX" class="form-control" id="cc_cvv">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-9">
                            <div class="form-group">
                                <label for="cc_name">ชื่อผู้ถือบัตร</label>
                                <input type="text" name="cc_name" placeholder="CARDHOLDER NAME" class="form-control" id="cc_name">
                            </div>
                        </div>
                        <div class="col-md-3 text-right hidden-xs">
                            <img src="<?php echo SITE_DIR; ?>images/card.png" style="height: 60px; max-width: 100%; margin-top: 10px;">
                        </div>
                    </div>
                    <div class="row ">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <input id="pay_btn" type="submit" name="pay_btn" class="btn btn-lg btn-info btn-block" value="PAY NOW <?php echo $order['price'] ?> บาท" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
<!--        <h3 class="text-center"> </h3>-->
<!--        <form id="address_form" method="post" class="form-horizontal">-->
<!--            <div class="text-center">-->
<!--                <h3> Fill in the delivery form</h3>-->
<!--            </div>-->
<!--            <div class="panel panel-default" style="padding: 30px; background-color: rgba(255,255,255,0.4); border-radius: 0; border-color: #1c79bb">-->
<!--                <div class="panel-body">-->
<!--                    <div class="form-group">-->
<!--                        <label class="control-label col-md-3">Email *</label>-->
<!--                        <div class="col-md-9">-->
<!--                            <input type="text" class="form-control" data-require="1" data-validate="email" name="user[email]">-->
<!--                            <div class="error-require validate-message">-->
<!--                                Required Field-->
<!--                            </div>-->
<!--                            <div class="error-validate validate-message">-->
<!--                                Incorrect Email-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="form-group">-->
<!--                        <label class="control-label col-md-3">Phone *</label>-->
<!--                        <div class="col-md-9">-->
<!--                            <input type="text" class="form-control" data-require="1" name="user[phone]">-->
<!--                            <div class="error-require validate-message">-->
<!--                                Required Field-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="form-group">-->
<!--                        <label class="control-label col-md-3">Full Name *</label>-->
<!--                        <div class="col-md-9">-->
<!--                            <input type="text" class="form-control" data-require="1" name="user[user_name]">-->
<!--                            <div class="error-require validate-message">-->
<!--                                Required Field-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="form-group">-->
<!--                        <label class="control-label col-md-3">Address *</label>-->
<!--                        <div class="col-md-9">-->
<!--                            <input type="text" class="form-control" data-require="1" name="address[address]">-->
<!--                            <div class="error-require validate-message">-->
<!--                                Required Field-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="form-group">-->
<!--                        <label class="control-label col-md-3">City *</label>-->
<!--                        <div class="col-md-9">-->
<!--                            <input type="text" class="form-control" data-require="1" name="address[city]">-->
<!--                            <div class="error-require validate-message">-->
<!--                                Required Field-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="form-group">-->
<!--                        <label class="control-label col-md-3">Region *</label>-->
<!--                        <div class="col-md-9">-->
<!--                            <input type="text" class="form-control" data-require="1" name="address[region]">-->
<!--                            <div class="error-require validate-message">-->
<!--                                Required Field-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="form-group">-->
<!--                        <label class="control-label col-md-3">Postal Code</label>-->
<!--                        <div class="col-md-9">-->
<!--                            <input type="text" class="form-control" data-require="1" name="address[zip]">-->
<!--                            <div class="error-require validate-message">-->
<!--                                Required Field-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="form-group text-center">-->
<!--                        <button type="submit" name="add_order_btn" class="btn btn-lg btn-info">-->
<!--                            Save Address-->
<!--                        </button>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <input type="hidden" name="product_id" value="--><?php //echo $_GET['product_id']; ?><!--">-->
<!--        </form>-->

    </div>
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