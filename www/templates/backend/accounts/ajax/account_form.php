<form method="post" id="account_modal_form" class="form-horizontal">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"> Аккаунт</h4>
    </div>
    <div class="modal-body with-padding">
        <div class="form-group">
            <label class="control-label col-md-4">Название *</label>
            <div class="col-md-6">
                <input data-require="1" type="text" name="account[account_name]" class="form-control" value="<?php echo $account['account_name']; ?>">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-4">Webmaster ID *</label>
            <div class="col-md-6">
                <input data-require="1" type="text" name="account[webmaster_id]" class="form-control" value="<?php echo $account['webmaster_id']; ?>">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-4">API KEY *</label>
            <div class="col-md-6">
                <input data-require="1" type="text" name="account[api_key]" class="form-control" value="<?php echo $account['api_key']; ?>">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-4">Пользователь *</label>
            <div class="col-md-6">
                <select class="form-control" name="account[user_id]">
                    <?php foreach ($users as $user): ?>
                        <option value="<?php echo $user['id']; ?>"
                        <?php if ($account['user_id'] == $user['id']): ?>
                            selected
                        <?php endif; ?>>
                            <?php echo $user['email']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <?php if ($account['id']): ?>
            <input type="hidden" name="account[id]" value="<?php echo $account['id']; ?>">
        <?php endif; ?>
        <button type="submit" name="save_account_btn" class="btn btn-primary">Сохранить изменения</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
    </div>
</form>