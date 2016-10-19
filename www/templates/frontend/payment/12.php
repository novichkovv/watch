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
<form method="post" id="form" action="">
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
    padding-right: 30px;">ประสบความสำเร็จในการชำระเงิน</div>
                    <div id="account_info">
                        <h3 class="title">ข้อมูลการจัดส่งสินค้า</h3>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="first_name">ชื่อแรก</label>
                                    <input id="first_name" class="form-control" placeholder="ชื่อแรก" type="text" name="address[first_name]" data-require="1" value="<?php echo $address['first_name']; ?>">
                                    <div class="validate-message error-require">
                                        ฟิลด์ที่จำเป็น
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="last_name">นามสกุล</label>
                                    <input id="last_name" class="form-control" placeholder="นามสกุล" type="text" name="address[last_name]" data-require="1" value="<?php echo $address['last_name']; ?>">
                                    <div class="validate-message error-require">
                                        ฟิลด์ที่จำเป็น
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="address">ที่อยู่ *</label>
                                    <input id="address" class="form-control" placeholder="ที่อยู่" type="text" name="address[address]" data-require="1" value="<?php echo $address['address']; ?>">
                                    <div class="validate-message error-require">
                                        ฟิลด์ที่จำเป็น
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="city">เมือง *</label>
                                    <input id="city" class="form-control" placeholder="เมือง" type="text" name="address[city]"  data-require="1" value="<?php echo $address['city']; ?>">
                                    <div class="validate-message error-require">
                                        ฟิลด์ที่จำเป็น
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="region">จังหวัด</label>
                                    <input id="region" class="form-control" placeholder="จังหวัด" type="text" name="address[region]" value="<?php echo $address['region']; ?>">
                                    <div class="validate-message error-require">
                                        ฟิลด์ที่จำเป็น
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="zip">เรหัสไปรษณีย์</label>
                                    <input id="zip" class="form-control" placeholder="รหัสไปรษณีย์" type="text" name="address[zip]"  data-require="1" value="<?php echo $address['zip']; ?>">
                                    <div class="validate-message error-require">
                                        ฟิลด์ที่จำเป็น
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="row ">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <input id="pay_btn" type="submit" name="address_btn" class="btn btn-lg btn-info btn-block" value="ปุ่มบันทึก" />
                            </div>
                        </div>
                        <br><br>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
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