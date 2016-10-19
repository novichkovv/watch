<div class="container" style="margin-top: 40px; ">
    <div class="main-body col-md-8 col-sm-8 col-sm-offset-2 col-xs-offset-0 col-xs-12">
        <h3 class="text-center"> </h3>
        <form id="address_form" method="post" class="form-horizontal">
            <div class="text-center">
                <h3> Fill in the delivery form</h3>
            </div>
            <div class="panel panel-default" style="padding: 30px; background-color: rgba(255,255,255,0.4); border-radius: 0; border-color: #1c79bb">
                <div class="panel-body">
                    <div class="form-group">
                        <label class="control-label col-md-3">Email *</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" data-require="1" data-validate="email" name="user[email]">
                            <div class="error-require validate-message">
                                Required Field
                            </div>
                            <div class="error-validate validate-message">
                                Incorrect Email
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Phone *</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" data-require="1" name="user[phone]">
                            <div class="error-require validate-message">
                                Required Field
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Full Name *</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" data-require="1" name="user[user_name]">
                            <div class="error-require validate-message">
                                Required Field
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Address *</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" data-require="1" name="address[address]">
                            <div class="error-require validate-message">
                                Required Field
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">City *</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" data-require="1" name="address[city]">
                            <div class="error-require validate-message">
                                Required Field
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Region *</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" data-require="1" name="address[region]">
                            <div class="error-require validate-message">
                                Required Field
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Postal Code</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" data-require="1" name="address[zip]">
                            <div class="error-require validate-message">
                                Required Field
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" name="add_order_btn" class="btn btn-lg btn-info">
                            Save Address
                        </button>
                    </div>
                </div>
            </div>
            <input type="hidden" name="product_id" value="<?php echo $_GET['product_id']; ?>">
        </form>
    </div>
</div>