<h3 class="page-title"> Аккаунты M1
    <small></small>
</h3>
<div class="row">
    <div class="col-md-8">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-basket font-dark"></i>
                    <span class="caption-subject bold uppercase"> Список аккаунтов</span>
                </div>
                <div class="actions">
                    <div class="btn-group btn-group-devided">
                        <a id="add_account" data-toggle="modal" href="#account_modal" class="btn blue btn-outline">
                            <i class="fa fa-plus"></i> Добавить
                        </a>
                    </div>
                </div>
            </div>
            <div class="portlet-body" style="overflow-x: auto;">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <td>Название</td>
                        <td>Webmaster ID</td>
                        <td>API KEY</td>
                        <td></td>
                    </tr>
                    </thead>
                    <tbody>
                        <?php if ($accounts): ?>
                            <?php foreach($accounts as $account): ?>
                                <tr>
                                    <td><?php echo $account['account_name']; ?></td>
                                    <td><?php echo $account['webmaster_id']; ?></td>
                                    <td><?php echo $account['api_key']; ?></td>
                                    <td>
                                        <a data-id="<?php echo $account['id']; ?>" data-toggle="modal" href="#account_modal" class="edit_account btn btn-xs btn-icon btn-default">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <a data-id="<?php echo $account['id']; ?>" data-toggle="modal" href="#delete_modal" class="btn btn-xs btn-icon btn-default text-danger">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="account_modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" id="account_modal_container">

        </div>
    </div>
</div>
<script type="text/javascript">
    $ = jQuery.noConflict();
    $(document).ready(function() {
        $("#add_account").click(function () {
            var params = {
                'action': 'get_account_form',
                'callback': function (msg) {
                    ajax_respond(msg,
                        function (respond) { //success
                            $("#account_modal_container").html(respond.template);
                        },
                        function (respond) { //fail
                        }
                    );
                }
            };
            ajax(params);
        });

        $(".edit_account").click(function () {
            var id = $(this).attr('data-id');
            var params = {
                'action': 'get_account_form',
                'values': {id: id},
                'callback': function (msg) {
                    ajax_respond(msg,
                        function (respond) { //success
                            $("#account_modal_container").html(respond.template);
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