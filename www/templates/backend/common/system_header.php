<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<head>
    <meta charset="utf-8"/>
    <title>
        <?php if ($common_vars['new_approved_orders']): ?>
            (<?php echo $common_vars['new_approved_orders']; ?>)
        <?php endif; ?>
        Backend
    </title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <meta content="" name="description"/>
    <meta content="" name="author"/>
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
    <link href="<?php echo SITE_DIR; ?>css/backend/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo SITE_DIR; ?>css/backend/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo SITE_DIR; ?>css/backend/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo SITE_DIR; ?>css/backend/assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo SITE_DIR; ?>css/backend/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo SITE_DIR; ?>css/backend/assets/admin/pages/css/tasks.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo SITE_DIR; ?>css/backend/assets/global/plugins/bootstrap-toastr/toastr.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo SITE_DIR; ?>css/backend/assets/global/css/components.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo SITE_DIR; ?>css/backend/assets/global/css/plugins.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo SITE_DIR; ?>css/backend/assets/global/plugins/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet" type="text/css">
    <link href="<?php echo SITE_DIR; ?>css/backend/assets/admin/layout/css/layout.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo SITE_DIR; ?>css/backend/assets/admin/layout/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color"/>
    <link href="<?php echo SITE_DIR; ?>css/backend/assets/admin/layout/css/custom.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo SITE_DIR; ?>css/backend/style.css" rel="stylesheet" type="text/css"/>
    <?php if ($styles): ?>
        <?php foreach ($styles as $style): ?>
            <link href="<?php echo $style; ?>" rel="stylesheet" type="text/css"/>
        <?php endforeach; ?>
    <?php endif; ?>
    <link rel="shortcut icon" href="<?php echo SITE_DIR; ?>images/favicon.ico"/>
    <!--[if lt IE 9]>
    <script src="<?php echo SITE_DIR; ?>css/backend/assets/global/plugins/respond.min.js"></script>
    <script src="<?php echo SITE_DIR; ?>css/backend/assets/global/plugins/excanvas.min.js"></script>
    <![endif]-->
    <script src="<?php echo SITE_DIR; ?>css/backend/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
    <script src="<?php echo SITE_DIR; ?>css/backend/assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
    <script src="<?php echo SITE_DIR; ?>css/backend/assets/global/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script>
    <script src="<?php echo SITE_DIR; ?>css/backend/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="<?php echo SITE_DIR; ?>css/backend/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
    <script src="<?php echo SITE_DIR; ?>css/backend/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <script src="<?php echo SITE_DIR; ?>css/backend/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
    <script src="<?php echo SITE_DIR; ?>css/backend/assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
    <script src="<?php echo SITE_DIR; ?>css/backend/assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
    <script src="<?php echo SITE_DIR; ?>css/backend/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
    <script src="<?php echo SITE_DIR; ?>css/backend/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>
    <script src="<?php echo SITE_DIR; ?>css/backend/assets/global/plugins/datatables/all.min.js" type="text/javascript"></script>
    <script src="<?php echo SITE_DIR; ?>css/backend/assets/global/scripts/metronic.js" type="text/javascript"></script>
    <script src="<?php echo SITE_DIR; ?>css/backend/assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
    <script src="<?php echo SITE_DIR; ?>css/backend/assets/admin/layout/scripts/quick-sidebar.js" type="text/javascript"></script>
    <script src="<?php echo SITE_DIR; ?>css/backend/assets/admin/pages/scripts/index.js" type="text/javascript"></script>
    <script src="<?php echo SITE_DIR; ?>css/backend/assets/admin/pages/scripts/tasks.js" type="text/javascript"></script>
    <script src="<?php echo SITE_DIR; ?>css/backend/assets/global/plugins/bootstrap-toastr/toastr.min.js" type="text/javascript"></script>
    <script src="<?php echo SITE_DIR; ?>js/backend/notifier.js" type="text/javascript"></script>
    <script src="<?php echo SITE_DIR; ?>js/backend/script.js" type="text/javascript"></script>
    <?php if ($scripts): ?>
        <?php foreach ($scripts as $script): ?>
            <script src="<?php echo $script; ?>" type="text/javascript"></script>
        <?php endforeach; ?>
    <?php endif; ?>
    <script type="text/javascript">
//        var i = 0;
//        setInterval(function() {
//            if(i%2 === 0) {
//                $("title").html('*****');
//            } else {
//                $("title").html('Новый заказ');
//            }
//            i++;
//            console.log(i);
//        }, 1000);

    </script>
</head>

