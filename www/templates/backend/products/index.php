<h3 class="page-title"> Заказы
    <small></small>
</h3>
<div class="row">
    <div class="col-md-10">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-basket font-dark"></i>
                    <span class="caption-subject bold uppercase"> Список Товаров</span>
                </div>
                <div class="actions">
                    <div class="btn-group btn-group-devided">
                        <a id="add_product" href="#product_modal" data-toggle="modal" class="btn green btn-outline">
                            <i class="fa fa-plus"></i> Добавить Товар
                        </a>
                    </div>
                </div>
            </div>
            <div class="portlet-body custom-datatable">
                <table class="table table-bordered" id="get_orders">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Продукт</th>
                        <th>Url ключ</th>
                        <th>Ключ Лендинга</th>
                        <th>Ключ Лендинга 2</th>
                        <th>ID товара в партнерке</th>
                        <th>Webmaster ID</th>
                        <th>Цена</th>
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
<div class="modal fade" id="product_modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" id="product_modal_container">
        </div>
    </div>
</div>
<script type="text/javascript">
    $ = jQuery.noConflict();
    $(document).ready(function() {
        ajax_datatable('get_orders');
        $("body").on("click", ".show_product", function () {
            var id = $(this).attr('data-id');
            var params = {
                'action': 'get_product_modal_form',
                'values': {id: id},
                'callback': function (msg) {
                    ajax_respond(msg,
                        function (respond) { //success
                            $("#product_modal_container").html(respond.template);
                        },
                        function (respond) { //fail
                        }
                    );
                }
            };
            ajax(params);
        });

        $("body").on("submit", "#product_modal_form", function () {
            var params = {
                'action': 'edit_product_info',
                'get_from_form': 'product_modal_form',
                'callback': function (msg) {
                    ajax_respond(msg,
                        function (respond) { //success
                            $('#product_modal').modal('hide');
                            Notifier.success('Информация о товаре сохранена');
                            ajax_datatable('get_orders');
                        },
                        function (respond) { //fail
                        }
                    );
                }
            };
            ajax(params);
            return false;
        });

        $("body").on("click", "#add_product", function () {
            var params = {
                'action': 'get_product_form',
                'callback': function (msg) {
                    ajax_respond(msg,
                        function (respond) { //success
                            $("#product_modal_container").html(respond.template);
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