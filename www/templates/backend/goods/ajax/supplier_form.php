<div class="form-group">
    <label class="control-label col-md-4">Наименование *</label>
    <div class="col-md-6">
        <input type="text" data-require="1" class="form-control" name="supplier[supplier_name]" value="<?php echo $supplier['supplier_name']; ?>">
        <div class="error-require validate-message">
            Обязательное поле
        </div>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-4">Код *</label>
    <div class="col-md-6">
        <input type="text" data-require="1" class="form-control" name="supplier[supplier_code]" value="<?php echo $supplier['supplier_code']; ?>">
        <div class="error-require validate-message">
            Обязательное поле
        </div>
    </div>
</div>
<?php if (!empty($supplier['id'])): ?>
    <input type="hidden" value="<?php echo $supplier['id']; ?>" name="supplier[id]">
<?php endif; ?>