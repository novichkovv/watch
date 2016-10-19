<h3 class="page-title"> <?php echo ($_GET['id'] ? 'Редактировать' : 'Добавить'); ?> Сотрудника
    <small></small>
</h3>
<div class="row">
    <div class="col-md-offset-1 col-md-4 col-sm-6">
        <form action="" method="post" id="user_form">
            <div class="form-group">
                <label>Email</label>
                <input type="text" class="form-control" name="email" value="<?php echo $user['email']; ?>" data-require="1">
                <div class="error-require validate-message">
                    Введите Email
                </div>
            </div>
            <div class="form-group">
                <label>Группа Пользователей</label>
                <select name="user_group_id" class="form-control">
                    <?php foreach($user_groups as $group): ?>
                        <option value="<?php echo $group['id']; ?>" <?php if($user['user_group_id'] == $group['id'])echo 'selected'; ?>>
                            <?php echo $group['group_name']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Пароль</label>
                <input type="password" class="form-control" name="user_password" data-validate="password" value=""<?php if($_GET['id']) echo ' placeholder="Оставьте пустым, если не меняете"' ?>>
            </div>
            <div class="form-group">
                <label>Подтверждение Пароля</label>
                <input type="password" class="form-control" name="confirm" data-validate="repeat_password" value=""<?php if($_GET['id']) echo ' placeholder="Оставьте пустым, если не меняете"' ?>>
                <div class="error-validate validate-message">
                    Пароли не совпадают
                </div>
            </div>
            <div class="form-group">
                <input class="btn btn-primary btn-lg" type="submit" name="save_user_btn" value="Сохранить">
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    $ = jQuery.noConflict();
    $(document).ready(function()
    {
        $("#user_form").submit(function()
        {
//            return validate('user_form');
        });
    });
</script>