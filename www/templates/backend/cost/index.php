<h3 class="page-title"> Косты
    <small></small>
</h3>
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-basket font-dark"></i>
                    <span class="caption-subject bold uppercase"> Косты</span>
                </div>
                <div class="actions">
                    <div class="btn-group btn-group-devided">
                        <button type="submit" class="btn green btn-outline">
                            <i class="fa fa-save"></i> Save
                        </button>
                    </div>
                </div>
            </div>
            <div class="portlet-body custom-datatable" style="overflow-x: auto;">
                <form action="<?php echo SITE_DIR; ?>cost/" class="dropzone dropzone-file-area" id="dropzone" style="width: 500px; margin-top: 50px;">
                    <h3 class="sbold">Файлы CSV</h3>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="csv_form_modal" role="dialog" aria-hidden="true">
    <div class="page-loading page-loading-boxed">
        <img src="<?php echo SITE_DIR; ?>assets/global/img/loading-spinner-grey.gif" alt="" class="loading">
        <span> &nbsp;&nbsp;Chargement... </span>
    </div>
    <div class="modal-dialog modal-lg">
        <form method="post" id="cost_form" action="">
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption"><i class="fa fa-cogs"></i> </div>
                            <div class="actions">
                                <button type="submit" class="btn btn-circle  btn-default btn-sm">
                                    <i class="fa fa-plus"></i> Сохранить
                                </button>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <td>Дата</td>
                                    <td>Товар</td>
                                    <td>Охват</td>
                                    <td>Результат</td>
                                    <td>Затраты</td>
                                    <td>Оценка актуальности</td>
                                    <td>Кто</td>
                                    <td></td>
                                </tr>
                                </thead>
                                <tbody id="csv_modal_container">

                                </tbody>
                            </table>
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
        Dropzone.options.dropzone = {
            paramName: "file", // The name that will be used to transfer the file
            maxFilesize: 2, // MB
            createImageThumbnails: false,
            uploadMultiple: true,
            accept: function(file, done) {
                done();
            },
            init: function () {
                this.on("completemultiple", function(file) {
                    var params = {
                        'action': 'get_parsed_csv_table',
                        'callback': function (msg) {
                            ajax_respond(msg,
                                function (respond) { //success
                                    $("#csv_form_modal").modal('show');
                                    $("#csv_modal_container").html(respond.template);
                                },
                                function (respond) { //fail
                                }
                            );
                        }
                    };
                    ajax(params);
                });
            }
        };
        $("body").on("click", ".delete_cost", function () {
            $(this).closest('tr').remove();
        });

        $("body").on("submit", "#cost_form", function () {
            var params = {
                'action': 'save_costs',
                'get_from_form': 'cost_form',
                'callback': function (msg) {
                    $("#csv_form_modal").modal('hide');
                }
            };
            ajax(params);
            return false;
        });
    });
</script>