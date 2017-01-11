<h3 class="page-title"> Документы для склада
    <small></small>
</h3>
<div class="row">
    <div class="col-md-10">
        <form class="form-horizontal" action="" method="post">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="icon-basket font-dark"></i>
                        <span class="caption-subject bold uppercase"> Ожидаемые приемки</span>
                    </div>
                    <div class="actions">
                        <div class="btn-group btn-group-devided">
                            <a class="btn blue outline generate_doc" data-category="1" data-toggle="modal" href="#document_modal">
                                <i class="fa fa-plus"></i> Сгенерировать
                            </a>
                        </div>
                    </div>
                </div>
                <div class="portlet-body custom-datatable">
                    <table class="table table-bordered" id="get_expected">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Название</th>
                            <th>Дата</th>
                            <th>
                                <input type="hidden" class="filter-form" value="1" name="category_id">
                            </th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="document_modal" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form method="post">
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption"><i class="fa fa-cogs"></i> </div>
                            <div class="actions">
                                <a href="#" class="btn btn-circle  btn-default btn-sm">
                                    <i class="fa fa-plus"></i> Сгенерировать
                                </a>
                            </div>
                        </div>
                        <div class="portlet-body" id="document_form_container">

                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    $ = jQuery.noConflict();
    $(document).ready(function () {
        ajax_datatable('get_expected');
        $("body").on("click", ".generate_doc", function () {
            var category_id = $(this).attr('data-category');
            var params = {
                'action': 'get_document_form',
                'values': {category_id: category_id},
                'callback': function (msg) {
                    ajax_respond(msg,
                        function (respond) { //success
                            $("#document_form_container").html(respond.template);
                        },
                        function (respond) { //fail
                        }
                    );
                }
            };
            ajax(params);
        });

        $("body").on("click", "#add_expecting_row", function () {
            var values = {
                'good_id': $("[name='expecting[good_id]']").val(),
                'quantity': $("[name='expecting[quantity]']").val(),
                'price': $("[name='expecting[price]']").val()
            };
            var params = {
                'action': 'get_expecting_row',
                'values': values,
                'callback': function (msg) {
                    ajax_respond(msg,
                        function (respond) { //success
                            var $expecting_tbody = $("#expecting_tbody");
                            $expecting_tbody.append(respond.template);
                            $expecting_tbody.find('.num').each(function() {
                                $(this).val($(this).closest('tr').index() + 1)
                            })
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
