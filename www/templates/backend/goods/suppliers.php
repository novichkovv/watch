<h3 class="page-title"> Поставщики
    <small></small>
</h3>
<div class="row">
    <div class="col-md-6">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-basket font-dark"></i>
                    <span class="caption-subject bold uppercase"> Поставщики</span>
                </div>
                <div class="actions">
                    <div class="btn-group btn-group-devided">
                        <a id="add_btn" data-toggle="modal" href="#form_modal" type="submit" class="btn blue outline">
                            <i class="fa fa-plus"></i> Добавить
                        </a>
                    </div>
                </div>
            </div>
            <div class="portlet-body custom-datatable">
                <table class="table table-bordered" id="get_table">
                    <thead>
                    <tr></tr>
                    <tr>
                        <th>Наименование</th>
                        <th>Код</th>
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
<div class="modal fade" id="form_modal" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="row">
            <div class="col-md-12">
                <form class="form-horizontal" method="post" id="form">
                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption"><i class="fa fa-cogs"></i> </div>
                            <div class="actions">
                                <button class="save_btn btn btn-circle btn-default btn-sm">
                                    <i class="fa fa-plus"></i> Сохранить
                                </button>
                            </div>
                        </div>
                        <div class="portlet-body" id="form_container">

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="delete_modal" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="row">
            <div class="col-md-12">
                <div class="portlet box blue">
                    <div class="portlet-title">
                        <div class="caption"><i class="fa fa-trash"></i> Удаление</div>
                    </div>
                    <div class="portlet-body">
                        Вы уверены, что хотите удалить?
                        <hr>
                        <div class="text-center">
                            <button type="button" id="delete_btn" class="btn btn-danger">
                                Да
                            </button>
                            <button data-dismiss="modal" class="btn btn-default">
                                Отмена
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $ = jQuery.noConflict();
    $(document).ready(function () {
        crud();
    });
</script>
            