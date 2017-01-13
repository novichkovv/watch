<h3 class="page-title"> Товар на Складе
    <small></small>
</h3>
<div class="row">
    <div class="col-md-10">
        <form class="form-horizontal" action="" method="post">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="icon-basket font-dark"></i>
                        <span class="caption-subject bold uppercase"> Информация о товаре</span>
                    </div>
                    <div class="actions">
                        <div class="btn-group btn-group-devided">
                            <button type="submit" name="save_good_btn" class="btn blue outline">
                                <i class="fa fa-save"></i> Сохранить
                            </button>
                        </div>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="form-group">
                        <label class="control-label col-md-3">Наименование</label>
                        <div class="col-md-8">
                            <input type="text" name="good[good_name]" class="form-control" value="<?php echo $good['good_name']; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Группа</label>
                        <div class="col-md-7">
                            <select name="good[group_id]" id="group_select" class="form-control">
                                <option value=""></option>
                                <?php if ($groups): ?>
                                    <?php foreach ($groups as $group): ?>
                                        <option value="<?php echo $group['id']; ?>" data-code="<?php echo $group['group_key']; ?>"
                                        <?php if ($good['group_id'] == $group['id']): ?>
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
                        <label class="control-label col-md-3">Поставщик</label>
                        <div class="col-md-7">
                            <select name="good[supplier_id]" id="supplier_select" class="form-control">
                                <option value="" data-code="SU"></option>
                                <?php if ($suppliers): ?>
                                    <?php foreach ($suppliers as $supplier): ?>
                                        <option data-code="<?php echo $supplier['supplier_code']; ?>" value="<?php echo $supplier['id']; ?>" data-code="<?php echo $supplier['supplier_key']; ?>"
                                            <?php if ($good['supplier_id'] == $supplier['id']): ?>
                                                selected
                                            <?php endif; ?>>
                                            <?php echo $supplier['supplier_name']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <a href="<?php echo SITE_DIR; ?>goods/suppliers/" data-toggle="modal" class="btn outline green"><i class="fa fa-plus"></i> </a>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Артикул</label>
                        <div class="col-md-7">
                            <input type="text" id="stock_number" name="good[stock_number]" value="<?php echo $good['stock_number'] ? $good['stock_number'] : 'SUGGCDCL001'; ?>" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <button id="verify_stock_number" type="button" class="btn outline red"><i class="fa fa-check"></i> </button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Остаток</label>
                        <div class="col-md-8">
                            <input type="text" name="good[quantity]" value="<?php echo $good['quantity']; ?>" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Цвет</label>
                        <div class="col-md-7">
                            <select name="good[color_id]" id="color_select" class="form-control">
                                <option value="" data-code="CR"></option>
                                <?php if ($colors): ?>
                                    <?php foreach ($colors as $color): ?>
                                        <option data-code="<?php echo $color['color_code']; ?>" value="<?php echo $color['id']; ?>"
                                            <?php if ($good['color_id'] == $color['id']): ?>
                                                selected
                                            <?php endif; ?>>
                                            <?php echo $color['color_name']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <a href="#color_modal" data-toggle="modal" class="btn outline green add_color"><i class="fa fa-plus"></i> </a>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Код</label>
                        <div class="col-md-8">
                            <input type="text" name="good[good_code]" id="good_code" class="form-control" value="<?php echo $good['good_code'] ? $good['good_code'] : 'CD'; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Стоимость</label>
                        <div class="col-md-8">
                            <input type="text" name="good[price]" class="form-control" value="<?php echo $good['price']; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Вес</label>
                        <div class="col-md-8">
                            <input type="text" name="good[weight]" class="form-control" value="<?php echo $good['weight']; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Длина</label>
                        <div class="col-md-8">
                            <input type="text" name="good[length]" class="form-control" value="<?php echo $good['length']; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Ширина</label>
                        <div class="col-md-8">
                            <input type="text" name="good[width]" class="form-control" value="<?php echo $good['width']; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Высота</label>
                        <div class="col-md-8">
                            <input type="text" name="good[height]" class="form-control" value="<?php echo $good['height']; ?>">
                        </div>
                    </div>

                    <?php if (!empty($goog['id'])): ?>
                        <div class="form-group">
                            <label class="control-label col-md-3">Дата</label>
                            <div class="col-md-8">
                                <input disabled type="text" class="form-control" value="<?php echo $good['create_date']; ?>">
                            </div>
                        </div>

                    <?php endif; ?>
                    <input type="hidden" value="<?php echo $good['id']; ?>" name="good[id]">
                </div>
            </div>
        </form>
    </div>

</div>
<div class="row">
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
    <div class="col-md-6">
        <form class="form-horizontal" action="" method="post">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="icon-basket font-dark"></i>
                        <span class="caption-subject bold uppercase"> Цвета Товаров</span>
                    </div>
                    <div class="actions">
                        <div class="btn-color btn-color-devided">
                            <a href="#color_modal" data-toggle="modal" class="btn blue outline add_color">
                                <i class="fa fa-plus"></i> Добавить
                            </a>
                        </div>
                    </div>
                </div>
                <div class="portlet-body custom-datatable">
                    <table class="table table-bordered" id="get_colors_list">
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
<div class="modal fade" id="color_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="color_form" class="form-horizontal" action="" method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Цвета Товаров</h4>
                </div>
                <div class="modal-body with-padding" id="color_form_container">

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="delete_color_modal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content red">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="fa fa-trash"></i> Удаление Цвета</h4>
            </div>
            <div class="modal-body with-padding">
                Удалить Цвет?
            </div>
            <div class="modal-footer">
                <button type="button" id="delete_color_btn" class="btn btn-primary">Да</button>
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

        $("body").on("change", "#group_select", function () {
            var code = $(this).find('option:selected').attr('data-code');
            var $stock_number = $("#stock_number");
            var val = $stock_number.val();
            var new_val = val.charAt(0) + val.charAt(1) + code + val.charAt(4) + val.charAt(5) + val.charAt(6) + val.charAt(7) + val.charAt(8) + val.charAt(9) + val.charAt(10);
            console.log(val);
            $stock_number.val(new_val);
        });

        $("body").on("change", "#color_select", function () {
            var code = $(this).find('option:selected').attr('data-code');
            var $stock_number = $("#stock_number");
            var val = $stock_number.val();
            var new_val = val.charAt(0) + val.charAt(1) + val.charAt(2) + val.charAt(3) + val.charAt(4) + val.charAt(5) + code + val.charAt(8) + val.charAt(9) + val.charAt(10);
            $stock_number.val(new_val);
        });

        $("body").on("change", "#supplier_select", function () {
            var code = $(this).find('option:selected').attr('data-code');
            var $stock_number = $("#stock_number");
            var val = $stock_number.val();
            var new_val = code + val.charAt(2) + val.charAt(3) + val.charAt(4) + val.charAt(5) + val.charAt(6) + val.charAt(7) + val.charAt(8) + val.charAt(9) + val.charAt(10);
            $stock_number.val(new_val);
        });

        $("body").on("change", "#good_code", function () {
            var code = $(this).val();
            var $stock_number = $("#stock_number");
            var val = $stock_number.val();
            var new_val = val.charAt(0) + val.charAt(1) + val.charAt(2) + val.charAt(3) + code + val.charAt(6) + val.charAt(7) + val.charAt(8) + val.charAt(9) + val.charAt(10);
            $stock_number.val(new_val);
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

        ajax_datatable('get_colors_list');
        $("body").on("submit", "#color_form", function () {
            if(validate('color_form')) {
                var params = {
                    'action': 'save_color',
                    'get_from_form': 'color_form',
                    'callback': function (msg) {
                        ajax_respond(msg,
                            function (respond) { //success
                                ajax_datatable('get_colors_list');
                                $("#color_select").html('');
                                for(var i in respond.colors) {
                                    $("#color_select").append(
                                        '<option value="' + respond.colors[i]['id'] + '"' + (respond.colors[i]['id'] == $("#color_id").val() ? ' selected' : '') + '>' + respond.colors[i]['color_name'] + '</option>'
                                    );
                                }
                                $("#color_modal").modal('hide');
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

        $("body").on("click", ".add_color", function () {
            var params = {
                'action': 'get_color_form',
                'callback': function (msg) {
                    ajax_respond(msg,
                        function (respond) { //success
                            $("#color_form_container").html(respond.template);
                        },
                        function (respond) { //fail
                        }
                    );
                }
            };
            ajax(params);
        });

        $("body").on("click", ".edit_color", function () {
            var id = $(this).attr('data-id');
            var params = {
                'action': 'get_color_form',
                'values': {'id': id},
                'callback': function (msg) {
                    ajax_respond(msg,
                        function (respond) { //success
                            $("#color_form_container").html(respond.template);
                        },
                        function (respond) { //fail
                        }
                    );
                }
            };
            ajax(params);
        });

        $("body").on("click", ".delete_color", function () {
            var id = $(this).attr('data-id');
            $("#delete_color_btn").attr('data-id', id);
        });

        $("body").on("click", "#delete_color_btn", function () {
            var id = $(this).attr('data-id');
            var params = {
                'action': 'delete_color',
                'values': {'id': id},
                'callback': function (msg) {
                    ajax_respond(msg,
                        function (respond) { //success
                            ajax_datatable('get_colors_list');
                            $("#color_select").html('');
                            for(var i in respond.colors) {
                                $("#color_select").append(
                                    '<option value="' + respond.colors[i]['id'] + '">' + respond.colors[i]['color_name'] + '</option>'
                                );
                            }
                            $("#delete_color_modal").modal('hide');
                        },
                        function (respond) { //fail
                        }
                    );
                }
            };
            ajax(params);
        });

        $("body").on("click", "#verify_stock_number", function () {
            $btn = $(this);
            var stock_number = $("#stock_number").val();
            var params = {
                'action': 'verify_stock_number',
                'values': {val: stock_number},
                'callback': function (msg) {
                    ajax_respond(msg,
                        function (respond) { //success
                            $btn.removeClass('red');
                            $btn.addClass('green');
                        },
                        function (respond) { //fail
                            $btn.removeClass('green');
                            $btn.addClass('red');
                        }
                    );
                }
            };
            ajax(params);
        });
    });
</script>