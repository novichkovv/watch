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
                            <input data-sign="=" type="text" placeholder="Поиск" name="o.my_name" class="form-control filter-field" value="<?php echo $my_name; ?>">
                        </td>
                        <td>
                            <input data-sign="=" type="text" placeholder="Поиск" name="DATE(o.create_date)" class="form-control filter-field datepicker">
                        </td>
                        <td>
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
                        <th>Коммент</th>
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

        $("body").on("keyup", ".region-suggest", function () {
            var $group = $(this).closest('.suggest-group');
            var val = $(this).val();
            var $container = $group.find('.suggest_container');
            if(val.length > 2) {
                console.log(val);
                var values = {'val': val};
                var params = {
                    'action': 'suggest_region',
                    'values': values,
                    'callback': function (msg) {
                        ajax_respond(msg,
                            function (respond) { //success
                                $container.html('');
                                for(var i in respond.suggest) {
                                    $container.append('' +
                                        '<div class="suggest_item" data-guid="' + respond.suggest[i]['AOGUID'] + '" data-code="' + respond.suggest[i]['CODE'] + '" data-regioncode="' + respond.suggest[i]['REGIONCODE'] + '">' +
                                            respond.suggest[i]['OFFNAME'] + ' ' + respond.suggest[i]['SHORTNAME'] +
                                        '</div>' +
                                        '');
                                }
                            },
                            function (respond) { //fail
                            }
                        );

                    }
                };
                ajax(params);
            }
        });

        $("body").on("keyup", ".county-suggest", function () {
            var $group = $(this).closest('.suggest-group');
            var val = $(this).val();
            var $container = $group.find('.suggest_container');
            if(val.length > 2) {
                var values = {'val': val};
                var $region = $(".region-suggest");
                var region_code = $region.val();
                if(region_code) {
                    values.region_code = $region.closest('.suggest-group').find('.suggest-code').val();
                }
                var params = {
                    'action': 'suggest_county',
                    'values': values,
                    'callback': function (msg) {
                        ajax_respond(msg,
                            function (respond) { //success
                                $container.html('');
                                for(var i in respond.suggest) {
                                    console.log(respond);
                                    $container.append('' +
                                        '<div class="suggest_item" data-guid="' + respond.suggest[i]['AOGUID'] + '" data-regioncode="' + respond.suggest[i]['REGIONCODE'] + '" data-code="' + respond.suggest[i]['AREACODE'] + '">' +
                                        respond.suggest[i]['OFFNAME'] + ' ' + respond.suggest[i]['SHORTNAME'] +
                                        '</div>' +
                                        '');
                                }
                            },
                            function (respond) { //fail
                            }
                        );

                    }
                };
                ajax(params);
            }
        });

        $("body").on("keyup", ".city-suggest", function () {
            var $group = $(this).closest('.suggest-group');
            var val = $(this).val();
            var $container = $group.find('.suggest_container');
            if(val.length > 2) {
                var values = {'val': val};
                var $region = $(".region-suggest");
                var region_code = $region.val();
                if(region_code) {
                    values.region_code = $region.closest('.suggest-group').find('.suggest-code').val();
                }
                var $county = $(".county-suggest");
                if($county.val()) {
                    values.county_code = $county.closest('.suggest-group').find('.suggest-code').val();
                }
                var params = {
                    'action': 'suggest_city',
                    'values': values,
                    'callback': function (msg) {
                        ajax_respond(msg,
                            function (respond) { //success
                                $container.html('');
                                for(var i in respond.suggest) {
                                    console.log(respond);
                                    $container.append('' +
                                        '<div class="suggest_item" data-guid="' + respond.suggest[i]['AOGUID'] + '" data-regioncode="' + respond.suggest[i]['REGIONCODE'] + '" data-countycode="' +
                                        respond.suggest[i]['AREACODE'] + '" data-code="' + respond.suggest[i]['AREACODE'] + '" data-postalcode="' + respond.suggest[i]['POSTALCODE'] + '">' +
                                            respond.suggest[i]['OFFNAME'] + ' ' + respond.suggest[i]['SHORTNAME'] + (respond.suggest[i]['PARENTNAME'] ? ' ' + respond.suggest[i]['PARENTNAME'] : '') +
                                        '</div>' +
                                        '');
                                }
                            },
                            function (respond) { //fail
                            }
                        );

                    }
                };
                ajax(params);
            }
        });

        $("body").on("keyup", ".street-suggest", function () {
            var $group = $(this).closest('.suggest-group');
            var val = $(this).val();
            var $container = $group.find('.suggest_container');
            if(val.length > 2) {
                var values = {'val': val};
                var $region = $(".region-suggest");
                var region_code = $region.val();
                if(region_code) {
                    values.region_code = $region.closest('.suggest-group').find('.suggest-code').val();
                }
                var $county = $(".county-suggest");
                if($county.val()) {
                    values.county_code = $county.closest('.suggest-group').find('.suggest-code').val();
                }
                var $city = $(".city-suggest");
                if($city.val()) {
                    values.city_code = $city.closest('.suggest-group').find('.suggest-code').val();
                    values.parent = $city.closest('.suggest-group').find('.suggest-guid').val();
                }
                var params = {
                    'action': 'suggest_street',
                    'values': values,
                    'callback': function (msg) {
                        ajax_respond(msg,
                            function (respond) { //success
                                $container.html('');
                                for(var i in respond.suggest) {
                                    $container.append('' +
                                        '<div class="suggest_item" data-guid="' + respond.suggest[i]['AOGUID'] + '" data-regioncode="' + respond.suggest[i]['REGIONCODE'] + '" data-countycode="' +
                                        respond.suggest[i]['AREACODE'] + '" data-code="' + respond.suggest[i]['AREACODE'] + '" data-postalcode="' + respond.suggest[i]['POSTALCODE'] + '">' +
                                        respond.suggest[i]['OFFNAME'] + ' ' + respond.suggest[i]['SHORTNAME'] + (respond.suggest[i]['PARENTNAME'] ? ' ' + respond.suggest[i]['PARENTNAME'] : '') +
                                        '</div>' +
                                        '');
                                }
                            },
                            function (respond) { //fail
                            }
                        );

                    }
                };
                ajax(params);
            }
        });

        $("body").on("click", ".suggest_item", function () {
            var name = $(this).html();
            var guid = $(this).attr('data-guid');
            var parent = $(this).attr('data-parent');
            var code = $(this).attr('data-code');
            var region_code = $(this).attr('data-regioncode');
            var county_code = $(this).attr('data-countycode');
            var $group = $(this).closest('.suggest-group');
            var $region = $('.region-suggest');
            var $region_group = $region.closest('.suggest-group');
            var $county = $('.county-suggest');
            var $county_group = $county.closest('.suggest-group');
            var postalcode = $(this).attr('data-postalcode');
            if(postalcode) {
                $("#zip-input").val(postalcode);
            }
            if($(this).closest(".suggest-group").find('.suggest').hasClass('county-suggest') && !$region.val()) {
                var params = {
                    'action': 'get_region',
                    'values': {'region_code' : region_code},
                    'callback': function (msg) {
                        ajax_respond(msg,
                            function (respond) { //success
                                $region.val(respond.region['OFFNAME'] + ' ' + respond.region['SHORTNAME']);
                                $region_group.find('.suggest-guid').val(respond.region['AOGUID'])
                                $region_group.find('.suggest-code').val(respond.region['CODE'])
                            },
                            function (respond) { //fail
                            }
                        );
                    }
                };
                ajax(params);
            }

            if($(this).closest(".suggest-group").find('.suggest').hasClass('city-suggest') && (!$region.val() || !$county.val())) {
                params = {
                    'action': 'get_region',
                    'values': {'region_code' : region_code, 'county_code': county_code},
                    'callback': function (msg) {
                        ajax_respond(msg,
                            function (respond) { //success
                                $region.val(respond.region['OFFNAME'] + ' ' + respond.region['SHORTNAME']);
                                $region.closest('.suggest-group').find('.suggest-guid').val(respond.region['AOGUID']);
                                $region.closest('.suggest-group').find('.suggest-code').val(respond.region['CODE']);
                                if(undefined !== respond.county) {
                                    $county.val(respond.county['OFFNAME'] + ' ' + respond.county['SHORTNAME']);
                                    $county.closest('.suggest-group').find('.suggest-guid').val(respond.county['AOGUID']);
                                    $county.closest('.suggest-group').find('.suggest-code').val(respond.county['AREACODE']);
                                }
                            },
                            function (respond) { //fail
                            }
                        );
                    }
                };
                ajax(params);
            }

            $group.find('.suggest').val(name);
            $group.find('.suggest-guid').val(guid);
            $group.find('.suggest-parent').val(parent);
            $group.find('.suggest-code').val(code);
            $group.find('.suggest_container').html('');
        });

        $("body").on("keyup", ".suggest", function () {
            var level = $(this).attr('data-level');
            $(this).closest('.suggest-group').find('.suggest-input').val('');
            for(var i = parseInt(level) + 1; i < 5; i++) {
                $("[data-level='" + i + "']").closest('.suggest-group').find('.suggest-input, .suggest').val('');
            }
        });
    });
</script>