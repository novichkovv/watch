<form method="post" id="order_modal_form" class="form-horizontal">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Заказ № <?php echo $order['id']; ?></h4>
    </div>
    <div class="modal-body with-padding">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-red-sunglo">
                    <i class="icon-settings font-red-sunglo"></i>
                    <span class="caption-subject bold uppercase"> Информация о Заказе</span>
                </div>
                <div class="actions">
                </div>
            </div>
            <div class="portlet-body">
                <div class="form-group">
                    <label class="control-label col-md-4">Дата Заказа</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" value="<?php echo $order['create_date']; ?>" disabled>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4">Название Продукта</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" value="<?php echo $product['product_name']; ?>" disabled>
                    </div>
                </div>
            </div>
        </div>
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-red-sunglo">
                    <i class="icon-settings font-red-sunglo"></i>
                    <span class="caption-subject bold uppercase"> Информация о Пользователе</span>
                </div>
                <div class="actions"></div>

            </div>
            <div class="portlet-body">
                <div class="form-group">
                    <label class="control-label col-md-4">Имя</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="user[user_name]" value="<?php echo $user['user_name']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4">Телефон</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="user[phone]" value="<?php echo $user['phone']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4">Email</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="user[email]" value="<?php echo $user['email']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4">Индекс</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="address[zip]" value="<?php echo $address['zip']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4">Провинция</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="address[region]" value="<?php echo $address['region']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4">Город</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="address[city]" value="<?php echo $address['city']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4">Адрес</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="address[address]" value="<?php echo $address['address']; ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Сохранить изменения</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
    </div>
    <input type="hidden" name="order[id]" value="<?php echo $order['id']; ?>">
    <input type="hidden" name="user[id]" value="<?php echo $user['id']; ?>">
    <input type="hidden" name="address[id]" value="<?php echo $address['id']; ?>">
</form>