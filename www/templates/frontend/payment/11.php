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
    #validation_error {
        color: red;
        font-size: 23px;
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
                                    <input id="email" class="form-control" placeholder="อีเมล์" type="email" name="user[email]" data-require="1" data-validate="email" value="<?php echo $user['email']; ?>">
                                    <div class="validate-message error-require">
                                        ฟิลด์ที่จำเป็น
                                    </div>
                                    <div class="validate-message error-validate">
                                        อีเมลไม่ถูกต้อง
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="phine">หมายเลขโทรศัพท์</label>
                                    <input id="phone" class="form-control" placeholder="หมายเลขโทรศัพท์" type="tel" name="user[phone]"  data-require="1" value="<?php echo $user['phone']; ?>">
                                    <div class="validate-message error-require">
                                        ฟิลด์ที่จำเป็น
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="payment_info">
                        <h3 class="title">ข้อมูลการชำระเงิน</h3>
                        <div id="validation_error">
                            <?php echo $validation_error; ?>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="cc_number">หมายเลขบัตร</label>
                                    <input type="text" name="cc_number" placeholder="XXXX XXXX XXXX XXXX" class="form-control" id="cc_number" data-require="1">
                                    <div class="validate-message error-require">
                                        ฟิลด์ที่จำเป็น
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 col-xs-4">
                                <div class="form-group">
                                    <label for="cc_month">เดือน</label>
                                    <input type="text" name="cc_month" placeholder="<?php echo date('m'); ?>" class="form-control" id="cc_month" data-require="1">
                                    <div class="validate-message error-require">
                                        ฟิลด์ที่จำเป็น
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 col-xs-4">
                                <div class="form-group">
                                    <label for="cc_year">ปี</label>
                                    <input type="text" name="cc_year" placeholder="<?php echo date('y'); ?>" class="form-control" id="cc_year" data-require="1">
                                    <div class="validate-message error-require">
                                        ฟิลด์ที่จำเป็น
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 col-xs-4">
                                <div class="form-group">
                                    <label for="cc_cvv">CVV</label>
                                    <input type="text" name="cc_cvv" placeholder="XXX" class="form-control" id="cc_cvv" data-require="1">
                                    <div class="validate-message error-require">
                                        ฟิลด์ที่จำเป็น
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label for="cc_name">ชื่อผู้ถือบัตร</label>
                                    <input type="text" name="cc_name" placeholder="CARDHOLDER NAME" class="form-control" id="cc_name" data-require="1">
                                    <div class="validate-message error-require">
                                        ฟิลด์ที่จำเป็น
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 text-right hidden-xs">
                                <img src="<?php echo SITE_DIR; ?>images/card.png" style="height: 60px; max-width: 100%; margin-top: 10px;">
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <input id="pay_btn" type="submit" name="pay_btn" class="btn btn-lg btn-info btn-block" value="PAY NOW <?php echo $product['price'] ?> บาท" />
                            </div>
                        </div>
                        <br>
                        <div class="row text-center" style="font-size: 12px;">
                            <div class="col-md-12">
                                All transactions are committed in USD. You will be charged to USD <?php echo $product['price_usd']; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" name="price_usd" value="<?php echo $product['price_usd']; ?>">
    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
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