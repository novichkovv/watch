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
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                    <tr>
                        <th>id</th>
                        <th>Статус</th>
                        <th>Цена</th>
                        <th>Выплата</th>
                        <th>Дата Создания</th>
                        <th>Дата Платежа</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $ = jQuery.noConflict();
    $(document).ready(function() {
//запускаем плагин, селектор '#js-Field' соответствует полю, где вводится адрес
//        $('#autocomplete').autocomplete( options );
        ajax_datatable('get_orders', 25, {
            "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                if (aData[1] == "Оплачено") {
                    $('td', nRow).css('background-color', '#e1ffe6');
                }
                if (aData[1] == "Отказано") {
                    $('td', nRow).css('background-color', '#ffe6e1');
                }
                if (aData[1] == "В обработке" || aData[6] == "Доставлено") {
                    $('td', nRow).css('background-color', '#dce0ff');
                }
            }
        });

    });
</script>
<style>
    .custom-datatable table td {
        padding: 2px !important;
    }
</style>