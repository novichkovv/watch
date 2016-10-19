<div class="container">

    <div class="main-body col-md-4 col-md-offset-4 col-sm-8 col-sm-offset-2 col-xs-12 col-xs-offset-0">
        <div class="text-center">
            <img src="<?php echo SITE_DIR; ?>images/paypal.png" alt="Paypal" title="Paypal">
        </div>
        <br>
        <div class="credit-card-div">
            <div class="panel panel-default" >
                <div class="panel-heading">
                    <form id="payment_form" method="post">
                        <h3 class="text-center"> Order # <?php echo $order_id; ?></h3>
                        <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                        <br><br>
                        <div class="row ">
                            <div class="col-md-12">
                                <input type="text" data-require="1" name="cc_number" class="form-control" placeholder="XXXX XXXX XXXX XXXX" />
                                <div class="error-require validate-message">
                                    Required Field
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row ">
                            <div class="col-md-3 col-sm-3 col-xs-6">
                                <span class="help-block text-muted small-font" > Expiry Month</span>
                                <input id="month_input" name="cc_month" type="text" class="form-control" data-require="1" placeholder="MM" />
                                <div class="error-require validate-message">
                                    Required Field
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-6">
                                <span class="help-block text-muted small-font" >  Expiry Year</span>
                                <input name="cc_year" type="text" class="form-control" data-require="1" placeholder="YY" />
                                <div class="error-require validate-message">
                                    Required Field
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-6">
                                <span class="help-block text-muted small-font" >  CCV &nbsp; &nbsp; &nbsp; &nbsp; </span>
                                <input name="ccv" type="text" class="form-control" data-require="1" placeholder="CCV" />
                                <div class="error-require validate-message">
                                    Required Field
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-6">
                                <span class="help-block text-muted small-font" >  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </span>
                                <img style="margin-top: 8px;" src="<?php echo SITE_DIR; ?>images/card.png" class="img-rounded" />
                            </div>
                        </div>
                        <br>
                        <div class="row ">
                            <div class="col-md-12 pad-adjust">

                                <input name="cc_name" type="text" class="form-control" data-require="1" placeholder="CARDHOLDER NAME" />
                                <div class="error-require validate-message">
                                    Required Field
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <!--                        <div class="col-md-12 pad-adjust">-->
                            <!--                            <div class="checkbox">-->
                            <!--                                <label>-->
                            <!--                                    <input type="checkbox" checked class="text-muted"> Save details for fast payments <a href="#"> learn how ?</a>-->
                            <!--                                </label>-->
                            <!--                            </div>-->
                            <!--                        </div>-->
                        </div>
                        <div class="row ">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <input id="pay_btn" type="submit" name="pay_btn" class="btn btn-lg btn-info btn-block" value="PAY NOW <?php echo $order['price'] ?> บาท" />
                            </div>
                        </div>


                    </form>
                </div>
            </div>
        </div>

        <!-- CREDIT CARD DIV END -->
    </div>

</div><!-- /.container -->
<div class="container text-center">
    All transactions are committed in USD. You will be charged to USD <?php echo $price; ?>
</div>
<script type="text/javascript">
    $ = jQuery.noConflict();
    $(document).ready(function () {
        $("body").on("submit", "#payment_form", function () {
           return validate('payment_form');
        });

        $("#month_input").mask(99);
    });
</script>
<style>
    .main-body {
        margin-top: 70px;

    }
    #pay_btn {
        background-color: #395da1;
        border-radius: 0;
        border-color: #596d75;
        width: 100%;
        margin: auto;
    }
    #pay_btn:hover {
        background-color: #436ebd;
        border-color: #596d75;
        width: 100%;
        margin: auto;
    }
</style>
