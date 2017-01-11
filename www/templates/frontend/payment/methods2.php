<div style="width: 100%">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-xs-6">
                <div class="pay_button">
                    <img class="pay_button_img" src="<?php echo SITE_DIR; ?>images/frontend/payment_methods/visa.jpg">
                </div>
            </div>
            <div class="col-md-3 col-xs-6">
                <div class="pay_button">
                    <img class="pay_button_img" src="<?php echo SITE_DIR; ?>images/frontend/payment_methods/qiwi.jpg">
                </div>
            </div>
<!--        </div>-->
<!--        <div class="row">-->


            <div class="col-md-3 col-xs-6">
                <div class="pay_button">
                    <img class="pay_button_img" src="<?php echo SITE_DIR; ?>images/frontend/payment_methods/webmoney.jpg">
                </div>
            </div>
            <div class="col-md-3 col-xs-6">
                <div class="pay_button">
                    <img class="pay_button_img" src="<?php echo SITE_DIR; ?>images/frontend/payment_methods/yandex.jpg">
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .pay_button {
        box-shadow: 3px 3px 3px black;
        border-radius: 3px;
        width: 90%;
        height: auto;
        margin: 10%;
        transition: all 0.2s ease 0s;
        padding: 5%;
    }
    .pay_button:hover {
        box-shadow: 2px 2px 2px grey;
    }
    .pay_button_img {
        width: 90%;
        /*display: block;*/
        margin: auto;
    }
</style>