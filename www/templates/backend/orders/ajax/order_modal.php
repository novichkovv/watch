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
                    <label class="control-label col-md-4">Имя (в заказе)</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="user[user_name]" value="<?php echo $user['user_name']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4">Имя</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="address[first_name]" value="<?php echo $user['first_name']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4">Отчество</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="address[middle_name]" value="<?php echo $user['middle_name']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4">Фамилия</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="address[last_name]" value="<?php echo $user['last_name']; ?>">
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
                        <input type="text" id="zip-input" class="form-control" name="address[zip]" value="<?php echo $address['zip']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4">Регион</label>
                    <div class="col-md-6 suggest-group">
                        <input type="text" class="form-control suggest region-suggest" data-level="1" name="address[region][name]" value="<?php echo $address['region']; ?>">
                        <input type="hidden" class="suggest-guid suggest-input" name="address[region][guid]">
                        <input type="hidden" class="suggest-code suggest-input" name="address[region][code]">
                        <div class="suggest_container"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4">Район</label>
                    <div class="col-md-6 suggest-group">
                        <input type="text" class="suggest form-control county-suggest" data-level="2" name="address[county][name]" value="<?php echo $address['county']; ?>">
                        <input type="hidden" class="suggest-input suggest-guid" name="address[county][guid]">
                        <input type="hidden" class="suggest-input suggest-code" name="address[county][code]">
                        <input type="hidden" class="suggest-input suggest-regioncode" name="address[county][regioncode]">
                        <div class="suggest_container"></div>

                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4">Населенный Пункт</label>
                    <div class="col-md-6 suggest-group">
                        <input type="text" class="suggest form-control city-suggest" data-level="3" name="address[city]" value="<?php echo $address['city']; ?>">
                        <input type="hidden" class="suggest-input suggest-guid" name="address[city][guid]">
                        <input type="hidden" class="suggest-input suggest-parent" name="address[city][parent]">
                        <div class="suggest_container"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4">Улица</label>
                    <div class="col-md-6 suggest-group">
                        <input type="text" class="suggest street-suggest form-control" data-level="4" name="address[street]" value="<?php echo $address['street']; ?>">
                        <input type="hidden" class="suggest-guid" name="address[street][guid]">
                        <input type="hidden" class="suggest-parent" name="address[street][parent]">
                        <div class="suggest_container"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4">Дом</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="address[building]" value="<?php echo $address['building']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4">Квартира</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="address[apartment]" value="<?php echo $address['apartment']; ?>">
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