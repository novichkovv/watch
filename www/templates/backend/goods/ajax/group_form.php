<div class="form-group">
    <label class="control-label col-md-4">Название Группы *</label>
    <div class="col-md-6">
        <input name="group[group_name]" value="<?php echo $group['group_name']; ?>" data-require="1" type="text" class="form-control">
        <div class="error-require validate-message">
            Обязательное поле
        </div>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-4">Ключ</label>
    <div class="col-md-6">
        <input name="group[group_key]" value="<?php echo $group['group_key']; ?>" type="text" class="form-control">
    </div>
</div>
<?php if ($group['id']): ?>
    <input type="hidden" name="group[id]" id="group_id" value="<?php echo $group['id']; ?>">
<?php endif; ?>