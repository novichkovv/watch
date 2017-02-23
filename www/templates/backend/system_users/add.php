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
                <label>Вид</label>
                <select class="form-control" name="view_type">
                    <option value="1" <?php if($user['view_type'] == 1)echo 'selected'; ?>>Полный</option>
                    <option value="2" <?php if($user['view_type'] == 2)echo 'selected'; ?>>Вебмастер</option>
                </select>
            </div>
            <div class="form-group">
                <label>Продукты</label>
                <select name="user_products[]" class="form-control select2" multiple>
                    <?php foreach($products as $product): ?>
                        <option value="<?php echo $product['id']; ?>" <?php if($user_products && in_array($product['id'], $user_products)) echo 'selected'; ?>>
                            <?php echo $product['product_name']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Имя</label>
                <input type="text" class="form-control" name="user_name" value="<?php echo $user['user_name']; ?>">
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
        $(".select2").select2();
        $("#user_form").submit(function()
        {
//            return validate('user_form');
        });
    });
</script>
<style>
    .select2-container {
        padding: 0 !important;
        border: none !important;
    }
</style>