<form method="post" id="order_form">
<!--    <div class="modal-header">-->
<!--        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>-->
<!--        <h4 class="modal-title">Заказ № --><?php //echo $order['id']; ?><!--</h4>-->
<!--    </div>-->
    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption font-red-sunglo">
                <i class="icon-basket font-red-sunglo"></i>
                <span class="caption-subject bold uppercase"> Заказ № <?php echo $order['id']; ?></span>
                <b style="margin-left:30px; color: #555; font-size: 21px;"><?php echo $user['phone']; ?></b>
                <span style="margin-left: 20px; color: #777; font-size: 20px;"><?php echo $user['user_name']; ?></span>
            </div>
            <div class="actions">
                <button type="submit" class="btn btn-outline blue" name="save_order_btn">
                    <i class="fa fa-save"> Сохранить </i>
                </button>
            </div>
        </div>
        <div class="portlet-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label">Продукт</label>
                        <input type="text" class="form-control" value="<?php echo $product['product_name']; ?>" disabled>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label">Дата Заказа</label>
                        <input type="text" class="form-control" value="<?php echo $order['create_date']; ?>" disabled>
                    </div>
                </div>
            </div>
<!--                <div class="row">-->
<!--                    <div class="col-md-5">-->
<!--                        <div class="form-group">-->
<!--                            <label class="control-label">Имя (в заказе)</label>-->
<!--<!--                            <input type="text" class="form-control" name="user[user_name]" value="--><?php ////echo $user['user_name']; ?><!--<!--">-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
            <div class="row">
                <div class="col-md-7">
                    <label class="control-label">Товары в заказе</label>
                    <table class="table table-bordered">
                        <tbody id="goods_container">
                            <?php require_once TEMPLATE_DIR . 'orders' . DS . 'ajax' . DS . 'goods_table.php'; ?>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-3">
                    <label class="control-label">Добавить товар</label>
                    <select class="form-control" id="add_good">
                        <option value=""></option>
                        <?php if ($goods): ?>
                            <?php foreach ($goods as $good): ?>
                                <option value="<?php echo $good['id']; ?>"> <?php echo $good['good_name']; ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption font-red-sunglo">
                <i class="icon-basket font-red-sunglo"></i>
                <span class="caption-subject bold uppercase"> Адрес</span>
            </div>
            <div class="actions">
            </div>
        </div>
        <div class="portlet-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label">Адрес Строкой</label>
                        <div class="col-md-11">
                            <input type="text" class="form-control" name="address[address]" id="address_input" autocomplete="off" value="<?php echo $address['address']; ?>">
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn outline blue normalize"><i class="fa fa-check"></i> </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label">Индекс</label>
                        <input type="text" id="zip_input" name="address[zip]" class="form-control" value="<?php echo $address['zip']; ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label">Регион</label>
                        <input type="text" name="address[region]" class="form-control" value="<?php echo $address['region']; ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label">Район</label>
                        <input type="text" name="address[area]" class="form-control" value="<?php echo $address['area']; ?>">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <label class="control-label">Город</label>
                    <input type="text" name="address[city]" class="form-control" value="<?php echo $address['city']; ?>">
                </div>
                <div class="col-md-4">
                    <label class="control-label">Место</label>
                    <input type="text" name="address[place]" class="form-control" value="<?php echo $address['place']; ?>">
                </div>
                <div class="col-md-4">
                    <label class="control-label">Улица</label>
                    <input type="text" name="address[street]" class="form-control" value="<?php echo $address['street']; ?>">
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <label class="control-label">Дом</label>
                    <input type="text" name="address[house]" class="form-control" value="<?php echo $address['house']; ?>">
                </div>
                <div class="col-md-3">
                    <label class="control-label">Строение</label>
                    <input type="text" name="address[building]" class="form-control" value="<?php echo $address['building']; ?>">
                </div>
                <div class="col-md-3">
                    <label class="control-label">Структура</label>
                    <input type="text" name="address[structure]" class="form-control" value="<?php echo $address['structure']; ?>">
                </div>
                <div class="col-md-3">
                    <label class="control-label">Квартира</label>
                    <input type="text" name="address[flat]" class="form-control" value="<?php echo $address['flat']; ?>">
                </div>
            </div>
        </div>
    </div>
    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption font-red-sunglo">
                <i class="icon-basket font-red-sunglo"></i>
                <span class="caption-subject bold uppercase"> Пользователь</span>
            </div>
            <div class="actions">
            </div>
        </div>
        <div class="portlet-body">
            <div class="row">
                <div class="col-md-3">
                    <label class="control-label">Имя</label>
                    <input type="text" class="form-control" name="address[first_name]" value="<?php echo $address['first_name']; ?>">
                </div>
                <div class="col-md-3">
                    <label class="control-label">Отчество</label>
                    <input type="text" class="form-control" name="address[middle_name]" value="<?php echo $address['middle_name']; ?>">
                </div>
                <div class="col-md-3">
                    <label class="control-label">Фамилия</label>
                    <input type="text" class="form-control" name="address[last_name]" value="<?php echo $address['last_name']; ?>">
                </div>
                <div class="col-md-3">
                    <label class="control-label">Телефон</label>
                    <input type="text" class="form-control" name="address[phone]" value="<?php echo $address['phone']; ?>">
                </div>
            </div>
        </div>
    </div>
    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption font-red-sunglo">
                <i class="icon-basket font-red-sunglo"></i>
                <span class="caption-subject bold uppercase"> Способы доставки</span>
            </div>
            <div class="actions">
                <button type="button" class="btn outline blue" id="get_delivery_methods">Получить</button>
            </div>
        </div>
        <div class="portlet-body">
            <div class="row">
            </div>
        </div>
    </div>
    <input type="hidden" name="order[id]" value="<?php echo $order['id']; ?>">
    <input type="hidden" name="user[id]" value="<?php echo $user['id']; ?>">
    <input type="hidden" name="address[id]" value="<?php echo $address['id']; ?>">
</form>

<script type="text/javascript">
    $ = jQuery.noConflict();
    $(document).ready(function () {
        $("body").on("submit", "#order_form", function () {
            if(validate('order_form')) {
                var params = {
                    'action': 'save_order',
                    'get_from_form': 'order_form',
                    'callback': function (msg) {
                        ajax_respond(msg,
                            function (respond) { //success
                                Notifier.success('Данные сохранены')
                            },
                            function (respond) { //fail
                            }
                        );
                    }
                };
                ajax(params);
            }
            return false;
        });

        $("body").on("click", "#get_delivery_methods", function () {
            var zip = $("#zip_input").val();
            var params = {
                'action': 'get_delivery_methods',
                'get_from_form': 'order_form',
                'callback': function (msg) {
                    ajax_respond(msg,
                        function (respond) { //success
                            $("#methods_container").html(respond.template);
                        },
                        function (respond) { //fail
                        }
                    );
                }
            };
            ajax(params);
        });

        $("body").on("change", "#add_good", function () {
            var val = $(this).val();
            var last_id = $('.good_tr').last().attr('data-id');
            var params = {
                'action': 'add_good',
                'values': {good_id: val, 'last_id': last_id},
                'callback': function (msg) {
                    ajax_respond(msg,
                        function (respond) { //success
                            $("#goods_container").append(respond.template);
                        },
                        function (respond) { //fail
                        }
                    );

                }
            };
            ajax(params);
        });

        var options = {
            serviceUrl:'http://ahunter.ru/site/suggest/address',
            params: { output: "json" },
            noCache: true,
            triggerSelectOnValidInput: false,
            paramName: "query",
            maxHeight: 500
        };
        $('#address_input').autocomplete( options );

        $("body").on("click", ".normalize", function () {
            var address = $("#address_input").val();
            var params = {
                'action': 'normalize_address',
                'values': {address: address},
                'callback': function (msg) {
                    ajax_respond(msg,
                        function (respond) { //success
                            for(var i in respond.address) {
                                $('[name="address[' + i + ']"]').val(respond.address[i]);
                            }
                            var params = {
                                'action': 'get_delivery_methods',
                                'values': {zip: respond.address['zip']},
                                'callback': function (msg) {
                                    ajax_respond(msg,
                                        function (respond) { //success
                                            $("#methods_container").html(respond.template);
                                        },
                                        function (respond) { //fail
                                        }
                                    );
                                }
                            };
                            ajax(params);
                        },
                        function (respond) { //fail
                        }
                    );
                }
            };
            ajax(params);
        });
    });
</script>