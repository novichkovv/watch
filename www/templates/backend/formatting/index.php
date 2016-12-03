<br>
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-bar-chart font-green-haze"></i>
                    <span class="caption-subject bold uppercase font-green-haze"> Форматирование текста коммента</span>
                    <span class="caption-helper"></span>
                </div>
                <div class="tools">
                    <a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
                    <!--                    <a href="#portlet-config" data-toggle="modal" class="config" data-original-title="" title=""> </a>-->
                    <!--                    <a href="javascript:;" class="reload" data-original-title="" title=""> </a>-->
                    <a href="javascript:;" class="fullscreen" data-original-title="" title=""> </a>
                    <a href="javascript:;" class="remove" data-original-title="" title=""> </a>
                </div>
            </div>
            <div class="portlet-body">
                <form method="post" enctype="multipart/form-data" class="form-horizontal">
                    <div class="form-group">
                        <label class="control-label col-md-4">
                            Лимит
                        </label>
                        <div class="col-md-8">
                            <input class="form-control" type="text" name="total" value="<?php echo $_POST['total'] ? $_POST['total'] : 10000000; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4">
                            Отсуп
                        </label>
                        <div class="col-md-8">
                            <input class="form-control" type="text" name="offset" value="<?php echo $_POST['offset'] ? $_POST['offset'] : 0; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4">
                            Отметок в одном комментарии
                        </label>
                        <div class="col-md-8">
                            <input class="form-control" type="text" name="switch" value="<?php echo $_POST['switch'] ? $_POST['switch'] : 9; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4">
                            Файл
                        </label>
                        <div class="col-md-8">
                            <input class="form-control" type="file" name="file">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-4 col-md-8">
                            <button class="btn outline blue" name="generate_btn" value="1">Погнали</button>
                        </div>
                    </div>
                </form>
            </div>
            <?php if ($res): ?>
                <h3>Готово</h3>
                Всего: <?php echo $count; ?><br>
                <textarea class="form-control" rows="6" id="text"><?php echo $res; ?></textarea><br>
                <button type="button" class="btn btn-default btn-sm" id="clipboard"><i class="fa fa-clipboard"></i> В буфер</button>
            <?php endif; ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-instagram font-green-haze"></i>
                    <span class="caption-subject bold uppercase font-green-haze"> Mass Planner аккаунты</span>
                    <span class="caption-helper"></span>
                </div>
                <div class="tools">
                    <a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
                    <!--                    <a href="#portlet-config" data-toggle="modal" class="config" data-original-title="" title=""> </a>-->
                    <!--                    <a href="javascript:;" class="reload" data-original-title="" title=""> </a>-->
                    <a href="javascript:;" class="fullscreen" data-original-title="" title=""> </a>
                    <a href="javascript:;" class="remove" data-original-title="" title=""> </a>
                </div>
            </div>
            <div class="portlet-body">
                <form method="post" class="form-horizontal" enctype="multipart/form-data">
                    <div class="form-group">
                        <label class="control-label col-md-4">
                            Аккаунты (login:password)
                        </label>
                        <div class="col-md-8"><input class="form-control" type="file" name="accounts" placeholder="accounts"></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4">
                            Прокси (ip:port:type:proxy_login:proxy_pswd)
                        </label>
                        <div class="col-md-8"><input class="form-control" type="file" name="proxy" placeholder="proxy"></div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-4 col-md-4">
                            <button class="btn blue outline" name="generate_inst_btn" value="1"><i class="fa fa-instagram"></i> Погнали</button>
                        </div>
                    </div>
                </form>
                <?php if ($inst_res): ?>
                    <div class="res">
                        <h3>Готово</h3>
                        Всего: <?php echo $inst_count; ?><br>
                        <textarea class="res_text" cols="60" rows="4"><?php echo $inst_res; ?></textarea><br>
                        <button type="button" class="res_clipboard">Копировать в буфер</button>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-vk font-green-haze"></i>
                    <span class="caption-subject bold uppercase font-green-haze"> LSender VK Pro аккаунты</span>
                    <span class="caption-helper"></span>
                </div>
                <div class="tools">
                    <a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
                    <!--                    <a href="#portlet-config" data-toggle="modal" class="config" data-original-title="" title=""> </a>-->
                    <!--                    <a href="javascript:;" class="reload" data-original-title="" title=""> </a>-->
                    <a href="javascript:;" class="fullscreen" data-original-title="" title=""> </a>
                    <a href="javascript:;" class="remove" data-original-title="" title=""> </a>
                </div>
            </div>
            <div class="portlet-body">
                <form method="post" enctype="multipart/form-data" class="form-horizontal">
                    <div class="form-group">
                        <label class="control-label col-md-4">
                            Аккаунты (login:password)
                        </label>
                        <div class="col-md-8"><input class="form-control" type="file" name="accounts" placeholder="accounts"></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4">
                            Прокси (ip:port:type:proxy_login:proxy_pswd)
                        </label>
                        <div class="col-md-8"><input class="form-control" type="file" name="proxy" placeholder="proxy"></div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-4 col-md-4">
                            <button class="btn blue outline" name="generate_vk_btn" value="1"><i class="fa fa-vk"></i> Погнали</button>
                        </div>
                    </div>
                </form>
                <?php if ($inst_res): ?>
                    <div class="res">
                        <h3>Готово</h3>
                        Всего: <?php echo $vk_count; ?><br>
                        <textarea class="res_text" cols="60" rows="4"><?php echo $vk_res; ?></textarea><br>
                        <button type="button" class="res_clipboard">Копировать в буфер</button>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var button = document.getElementById("clipboard"),
        input =  document.getElementById("text");

    button.addEventListener("click", function(event) {
        event.preventDefault();
        // Select the input node's contents
        input.select();
        // Copy it to the clipboard
        document.execCommand("copy");
    });

    var button1 = document.getElementsByClassName("res_clipboard"),
        input1 =  document.getElementsByClassName("res_text");

    button1.addEventListener("click", function(event) {
        event.preventDefault();
        // Select the input node's contents
        input1.select();
        // Copy it to the clipboard
        document.execCommand("copy");
    });
</script>


