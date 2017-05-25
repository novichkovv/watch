<div class="form-group">
    <label class="control-label col-md-4">Наименование *</label>
    <div class="col-md-6">
        <input type="text" data-require="1" class="form-control" name="checkout_method[method_name]" value="<?php echo $checkout_method['method_name']; ?>">
        <div class="error-require validate-message">
            Обязательное поле
        </div>
    </div>
</div>
<!--<div class="form-group">-->
<!--    <label class="control-label col-md-4">Код *</label>-->
<!--    <div class="col-md-6">-->
<!--        <input type="text" data-require="1" class="form-control" name="checkout_method[checkout_method_code]" value="--><?php //echo $checkout_method['checkout_method_code']; ?><!--">-->
<!--        <div class="error-require validate-message">-->
<!--            Обязательное поле-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<?php if (!empty($checkout_method['id'])): ?>
    <input type="hidden" value="<?php echo $checkout_method['id']; ?>" name="checkout_method[id]">
<?php endif; ?>