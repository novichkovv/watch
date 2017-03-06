<h3 class="page-title"> Доставка
    <small></small>
</h3>
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-basket font-dark"></i>
                    <span class="caption-subject bold uppercase"> Доставка</span>
                </div>
                <div class="actions">
                    <div class="btn-group btn-group-devided">
                        <form method="post" id="report_form" enctype="multipart/form-data" action="">
                            <input id="report_input" name="file" type="file" class="btn green btn-outline">
                        </form>
                    </div>
                </div>
            </div>
            <div class="portlet-body custom-datatable" style="overflow-x: auto;">
                <div class="topscroll">
                    <div class="fake"></div>
                </div>
                <table class="table table-bordered" id="get_delivery_table">
                    <thead>
                    <tr>
                        <td><!--Заказ--></td>
                        <td><!--Заказ--></td>
                        <td><!--Посылка--></td>
                        <td><!--Последний почтовый статус--></td>
                        <td><!--Акт--></td>
                        <td><!--Дата файла--></td>
                        <td><!--Дата поступления--></td>
                        <td><!--Номер клиента--></td>
                        <td><!--Клиент--></td>
                        <td><!--Номер ДС--></td>
                        <td><!--Состояние--></td>
                        <td><!--Нахождение--></td>
                        <td><!--Дата статуса--></td>
                        <td><!--Стоимость--></td>
                        <td><!--За доставку--></td>
                        <td><!--Город--></td>
                        <td><!--Вес--></td>
                        <td><!--Зона--></td>
                        <td><!--Получено с клиента--></td>
                        <td><!--Агентское вознаграждение--></td>
                        <td><!--Сумма к перечислению заказчику--></td>
                        <td><!--Стоимость услуг--></td>
                        <td><!--Стоимость страхования--></td>
                        <td><!--date_pay--></td>
                        <td><!--Тип доставки--></td>
                        <td><!--last_call--></td>
                        <td><!--last_delivery--></td>
                        <td><!--package_comment--></td>
                        <td><!--product_description--></td>
                        <td><!--Оценочная стоимость--></td>
                        <td><!--Почтовый тариф--></td>
                        <td><!--Barcode--></td>
                        <td><!--Акт за услуги B2C--></td>
                        <td><!--Доп. услуги--></td>
                        <td><!--Дата первого звонка--></td>
                        <td><!--Количество звонков--></td>
                        <td><!--Первая доставка--></td>
                        <td><!--Результативная доставка--></td>
                        <td><!--Причины переноса доставки--></td>
                    </tr>
                    <tr>
                        <th></th>
                        <th>Заказ</th>
                        <th>Посылка</th>
                        <th>Последний почтовый статус</th>
                        <th>Дата</th>
                        <th>Дата поступления</th>
                        <th>User id</th>
                        <th>Акт</th>
                        <th>Клиент</th>
                        <th>Номер ДС</th>
                        <th>Состояние</th>
                        <th>Нахождение</th>
                        <th>Дата статуса</th>
                        <th>Стоимость</th>
                        <th>За доставку</th>
                        <th>Город</th>
                        <th>Вес</th>
                        <th>Зона</th>
                        <th>Получено с клиента</th>
                        <th>Агентское вознаграждение</th>
                        <th>Сумма к перечислению заказчику</th>
                        <th>Стоимость услуг</th>
                        <th>Стоимость страхования</th>
                        <th>date_pay</th>
                        <th>Тип доставки</th>
                        <th>last_call</th>
                        <th>last_delivery</th>
                        <th>package_comment</th>
                        <th>product_description</th>
                        <th>Оценочная стоимость</th>
                        <th>Почтовый тариф</th>
                        <th>Barcode</th>
                        <th>Акт за услуги B2C</th>
                        <th>Доп. услуги</th>
                        <th>Дата первого звонка</th>
                        <th>Количество звонков</th>
                        <th>Первая доставка</th>
                        <th>Результативная доставка</th>
                        <th>Причины переноса доставки</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $ = jQuery.noConflict();
    $(document).ready(function () {
        ajax_datatable('get_delivery_table');
        $("#report_input").change(function() {
            $("#report_form").submit();
        });
        var container = $('.custom-datatable');
        var topscroll = $('.topscroll');
        topscroll.width(container.width());
        $('.fake').width($('.table').width() + 2200);

        topscroll.scroll(function(e){
            container.scrollLeft($(this).scrollLeft());
        });
        container.scroll(function(e){
            topscroll.scrollLeft($(this).scrollLeft());
        });
    });
</script>
<style>
    .custom-datatable {
        /*width: 300px;*/
        /*height: 200px;*/
        overflow-x: scroll;
        overflow-y: hidden;
    }
    .table td{
        /*width: 800px;*/
        font-size: 12px !important;
    }

    .topscroll {
        position: absolute;
        /*width: 300px;*/
        /*height: 20px;*/
        overflow-x: scroll;
    }
    .fake {
        height: 1px;
    }
</style>