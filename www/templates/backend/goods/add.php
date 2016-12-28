<h3 class="page-title"> Товар на Складе
    <small></small>
</h3>
<div class="row">
    <div class="col-md-6">
        <form class="form-horizontal" action="" method="post">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="icon-basket font-dark"></i>
                        <span class="caption-subject bold uppercase"> Информация о товаре</span>
                    </div>
                    <div class="actions">
                        <div class="btn-group btn-group-devided">
                            <button type="submit" class="btn blue outline">
                                <i class="fa fa-save"></i> Сохранить
                            </button>
                        </div>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="form-group">
                        <label class="control-label col-md-4">Наименование</label>
                        <div class="col-md-6">
                            <input type="text" name="good[good_name]" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4">Группа</label>
                        <div class="col-md-6">
                            <select name="good[group_id]" id="group_select" class="form-control">
                                <?php if ($groups): ?>
                                    <?php foreach ($groups as $group): ?>
                                        <option value="<?php echo $group['id']; ?>"
                                        <?php if ($good['group_id'] == $good['id']): ?>
                                            selected
                                        <?php endif; ?>>
                                            <?php echo $group['group_name']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <a href="#group_modal" data-toggle="modal" class="btn outline green add_group"><i class="fa fa-plus"></i> </a>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4">Артикул</label>
                        <div class="col-md-6">
                            <input type="text" name="good[stock_number]" value="<?php echo $good['stock_number']; ?>" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4">Остаток</label>
                        <div class="col-md-6">
                            <input type="text" name="good[quantity]" value="<?php echo $good['quantity']; ?>" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4">Стоимость</label>
                        <div class="col-md-6">
                            <input type="text" name="good[price]" class="form-control" value="<?php echo $good['price']; ?>">
                        </div>
                    </div>
                    <?php if (!empty($goog['id'])): ?>
                        <div class="form-group">
                            <label class="control-label col-md-4">Дата</label>
                            <div class="col-md-6">
                                <input disabled type="text" class="form-control" value="<?php echo $good['create_date']; ?>">
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-6">
        <form class="form-horizontal" action="" method="post">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="icon-basket font-dark"></i>
                        <span class="caption-subject bold uppercase"> Группы Товаров</span>
                    </div>
                    <div class="actions">
                        <div class="btn-group btn-group-devided">
                            <a href="#group_modal" data-toggle="modal" class="btn blue outline add_group">
                                <i class="fa fa-plus"></i> Добавить
                            </a>
                        </div>
                    </div>
                </div>
                <div class="portlet-body custom-datatable">
                    <table class="table table-bordered" id="get_groups_list">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Название</th>
                            <th>Ключ</th>
                            <th></th>
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
<div class="modal fade" id="group_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="group_form" class="form-horizontal" action="" method="">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Группа Товаров склада</h4>
                </div>
                <div class="modal-body with-padding" id="group_form_container">

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="delete_group_modal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content red">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="fa fa-trash"></i> Удаление Группы</h4>
            </div>
            <div class="modal-body with-padding">
                Удалить Группу?
            </div>
            <div class="modal-footer">
                <button type="button" id="delete_group_btn" class="btn btn-primary">Да</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $ = jQuery.noConflict();
    $(document).ready(function () {
        ajax_datatable('get_groups_list');
        $("body").on("submit", "#group_form", function () {
            if(validate('group_form')) {
                var params = {
                    'action': 'save_group',
                    'get_from_form': 'group_form',
                    'callback': function (msg) {
                        ajax_respond(msg,
                            function (respond) { //success
                                ajax_datatable('get_groups_list');
                                $("#group_select").html('');
                                for(var i in respond.groups) {
                                    $("#group_select").append(
                                        '<option value="' + respond.groups[i]['id'] + '"' + (respond.groups[i]['id'] == $("#group_id").val() ? ' selected' : '') + '>' + respond.groups[i]['group_name'] + '</option>'
                                    );
                                }
                                $("#group_modal").modal('hide');
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

        $("body").on("click", ".add_group", function () {
            var params = {
                'action': 'get_group_form',
                'callback': function (msg) {
                    ajax_respond(msg,
                        function (respond) { //success
                            $("#group_form_container").html(respond.template);
                        },
                        function (respond) { //fail
                        }
                    );
                }
            };
            ajax(params);
        });

        $("body").on("click", ".edit_group", function () {
            var id = $(this).attr('data-id');
            var params = {
                'action': 'get_group_form',
                'values': {'id': id},
                'callback': function (msg) {
                    ajax_respond(msg,
                        function (respond) { //success
                            $("#group_form_container").html(respond.template);
                        },
                        function (respond) { //fail
                        }
                    );
                }
            };
            ajax(params);
        });

        $("body").on("click", ".delete_group", function () {
            var id = $(this).attr('data-id');
            $("#delete_group_btn").attr('data-id', id);
        });

        $("body").on("click", "#delete_group_btn", function () {
            var id = $(this).attr('data-id');
            var params = {
                'action': 'delete_group',
                'values': {'id': id},
                'callback': function (msg) {
                    ajax_respond(msg,
                        function (respond) { //success
                            ajax_datatable('get_groups_list');
                            $("#group_select").html('');
                            for(var i in respond.groups) {
                                $("#group_select").append(
                                    '<option value="' + respond.groups[i]['id'] + '">' + respond.groups[i]['group_name'] + '</option>'
                                );
                            }
                            $("#delete_group_modal").modal('hide');
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