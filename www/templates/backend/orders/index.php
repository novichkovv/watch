<h3 class="page-title"> Заказы
    <small></small>
</h3>
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-basket font-dark"></i>
                    <span class="caption-subject bold uppercase"> Список Заказов</span>
                </div>
                <div class="actions">
                    <div class="btn-group btn-group-devided">
<!--                        <button type="submit" class="btn green btn-outline">-->
<!--                            <i class="fa fa-save"></i> Save-->
<!--                        </button>-->
                    </div>
                </div>
            </div>
            <div class="portlet-body custom-datatable" style="overflow-x: auto;">
                <table class="table table-bordered" id="get_orders">
                    <thead>
                    <tr>
                        <td>
                            <input type="text" data-sign="=" placeholder="Поиск" name="o.id" class="form-control filter-field">
                        </td>
                        <td>
                            <select data-sign="=" class="form-control filter-field filter-select" name="o.product_id">
                                <option value="">Все Товары</option>
                                <?php foreach ($products as $product): ?>
                                    <option value="<?php echo $product['id']; ?>"><?php echo $product['product_name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td>
                            <select data-sign="=" name="o.status_id" class="form-control filter-field filter-select">
                                <option value="">Все</option>
                                <option value="0">Не принят</option>
                                <?php foreach ($order_statuses as $status): ?>
                                    <option value="<?php echo $status['id']; ?>">
                                        <?php echo $status['status_name']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td>
                            <input data-sign="like" type="text" placeholder="Поиск" name="u.user_name" class="form-control filter-field">
                        </td>
                        <td>
                            <input data-sign="like" type="text" placeholder="Поиск" name="u.phone" class="form-control filter-field">
                        </td>
                        <td>
                            <input data-sign="=" type="text" placeholder="Поиск" name="o.my_name" class="form-control filter-field">
                        </td>
                        <td>
                            <input data-sign="=" type="text" placeholder="Поиск" name="DATE(o.create_date)" class="form-control filter-field datepicker">
                        </td>
                        <td>
                        </td>
                    </tr>
                    <tr>
                        <th>#</th>
                        <th>Продукт</th>
                        <th>Статус</th>
                        <th>Имя</th>
                        <th>Телефон</th>
                        <th>My Name</th>
                        <th>Дата Создания</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="order_modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" id="order_modal_container">

        </div>
    </div>
</div>
<script type="text/javascript">
    $ = jQuery.noConflict();
    $(document).ready(function() {
        ajax_datatable('get_orders');
        $("body").on("click", ".show_order", function () {
            var id = $(this).attr('data-id');
            var params = {
                'action': 'get_order_modal_form',
                'values': {id: id},
                'callback': function (msg) {
                    ajax_respond(msg,
                        function (respond) { //success
                            $("#order_modal_container").html(respond.template);
                        },
                        function (respond) { //fail
                        }
                    );
                }
            };
            ajax(params);
        });

        $("body").on("submit", "#order_modal_form", function () {
            var params = {
                'action': 'edit_order_info',
                'get_from_form': 'order_modal_form',
                'callback': function (msg) {
                    ajax_respond(msg,
                        function (respond) { //success
                            ajax_datatable('get_orders');
                            $('#order_modal').modal('hide');
                            Notifier.success('Информация о заказе сохранена');
                        },
                        function (respond) { //fail
                        }
                    );
                }
            };
            ajax(params);
            return false;
        });
    });
</script>