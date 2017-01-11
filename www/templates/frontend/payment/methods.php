
<div id="payment-block">
    <h2 class="text-center">Выберите способ оплаты</h2>
    <?php foreach ($methods as $method): ?>

        <form method="post" action="https://www.payanyway.ru/assistant.htm">
            <?php foreach ($params as $k => $param): ?>
                <input type="hidden" name="<?php echo $k; ?>" value="<?php echo $param; ?>">
            <?php endforeach; ?>
            <input type="hidden" name="paymentSystem.unitId" value="<?php echo $method['method_key']; ?>">
            <button type="submit" style="float: left;" value="Pay order" class="payment" data-id="<?php echo $method['method_key']; ?>">
                <span style="background-position: <?php echo $method['position']; ?>;"></span>
            </button>
        </form>

    <?php endforeach; ?>
    <div class="clear"></div>
</div>
<script type="text/javascript">
    $ = jQuery.noConflict();
    $(document).ready(function () {
//        $(".payment").click(function () {
//            var id = $(this).attr('data-id');
//            var params = {
//                'action': 'get_payment_url',
//                'values': {id: id},
//                'callback': function (msg) {
//                    ajax_respond(msg,
//                        function (respond) { //success
//
//                        },
//                        function (respond) { //fail
//                        }
//                    );
//                }
//            };
//            ajax(params);
//        })
    });
</script>
<style>
.payment {
    border: none;
}
    @media screen and (min-width:427px) {
        .payment {
            background: url('../../images/frontend/payment_methods/btn_pay.png') scroll no-repeat 0px 0px transparent;
            height: 105px;
            width: 190px;
            display: block;
            float:left;
            margin-bottom: 10px;
            cursor: pointer;

        }
        .payment span {
            background-image: url('../../images/frontend/payment_methods/pay_icons_sprite.png');
            background-repeat: no-repeat;
            background-color: transparent;
            height: 85px;
            width: 150px;
            margin: 4px 20px 16px;
            display: block;
        }
        .payment:hover
        {
            background-position: 0px -105px;
        }
        .payment:hover span
        {
            margin: 6px 20px 14px;
        }
        .payment:active
        {
            background-position: 0px -210px;
        }
        .payment:active span
        {
            margin: 8px 20px 12px;
        }
        #payment-block
        {
            max-width: 380px;
            margin: 0 auto;
            width: 100%;
        }
    }
    @media screen and (min-width:617px) {
        #payment-block
        {
            max-width: 570px;
            margin: 0 auto;
            width: 100%;
        }
    }
    @media screen and (max-width:426px) {
        .payment {
            background: url('../../images/frontend/payment_methods/btn_pay_mini.png') scroll no-repeat 0px 0px transparent;
            height: 70px;
            width: 143px;
            display: block;
            float:left;
            margin-bottom: 10px;
            cursor: pointer;
        }
        .payment span {
            background-image: url('../../images/frontend/payment_methods/pay_icons_sprite_mini.png');
            background-repeat: no-repeat;
            background-color: transparent;
            height: 70px;
            width: 106px;
            margin: -6px 16px 16px;
            display: block;
        }
        .payment:hover
        {
            background-position: 0px -75px;
        }
        .payment:hover span
        {
            margin: -5px 16px 14px;
        }
        .payment:active
        {
            background-position: 0px -151px;
        }
        .payment:active span
        {
            margin: -3px 16px 12px;
        }
        #payment-block
        {
            max-width: 287px;
            margin: 0 auto;
            width: 100%;
        }

    }
    /*.payment {*/
    /*background: url('images/btn_pay.png') scroll no-repeat 0px 0px transparent;*/
    /*height: 105px;*/
    /*width: 190px;*/
    /*display: block;*/
    /*float:left;*/
    /*margin-bottom: 10px;*/
    /*cursor: pointer;*/
    /*}*/
    /*.payment span {*/
    /*background-image: url('images/pay_icons_sprite.png');*/
    /*background-repeat: no-repeat;*/
    /*background-color: transparent;*/
    /*height: 85px;*/
    /*width: 150px;*/
    /*margin: 4px 20px 16px;*/
    /*display: block;*/
    /*}*/



</style>