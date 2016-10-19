<h3 class="page-title"> Заказы
    <small></small>
</h3>
<div class="row">
    <div class="col-md-10">
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
            <div class="portlet-body custom-datatable">
                <table class="table table-bordered" id="get_orders">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Продукт</th>
                        <th>Статус</th>
                        <th>Дата Создания</th>
                        <th>Дата Оплаты</th>
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