<div class="form-group">
    <label class="control-label col-md-4">Название Цвета *</label>
    <div class="col-md-6">
        <input name="color[color_name]" value="<?php echo $color['color_name']; ?>" data-require="1" type="text" class="form-control">
        <div class="error-require validate-message">
            Обязательное поле
        </div>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-4">Код</label>
    <div class="col-md-6">
        <input name="color[color_code]" value="<?php echo $color['color_code']; ?>" type="text" class="form-control">
    </div>
</div>
<?php if ($color['id']): ?>
    <input type="hidden" name="color[id]" id="color_id" value="<?php echo $color['id']; ?>">
<?php endif; ?>