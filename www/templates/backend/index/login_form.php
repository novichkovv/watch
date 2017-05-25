    <body class="login">
    <style>
        .login{background-color:#364150!important}.login .logo{margin:60px auto 0;padding:15px;text-align:center}.login .content{background-color:#fff;-webkit-border-radius:7px;-moz-border-radius:7px;-ms-border-radius:7px;-o-border-radius:7px;border-radius:7px;width:400px;margin:40px auto 10px;padding:10px 30px 30px;overflow:hidden;position:relative}.login .content h3{color:#4db3a5;text-align:center;font-size:28px;font-weight:400!important}.login .content h4{color:#555}.login .content .hint{color:#999;padding:0;margin:15px 0 7px}.login .content .forget-form,.login .content .login-form{padding:0;margin:0}.login .content .form-control{background-color:#dde3ec;height:43px;color:#8290a3;border:1px solid #dde3ec}.login .content .form-control:active,.login .content .form-control:focus{border:1px solid #c3ccda}.login .content .form-control::-moz-placeholder{color:#8290a3;opacity:1}.login .content .form-control:-ms-input-placeholder{color:#8290a3}.login .content .form-control::-webkit-input-placeholder{color:#8290a3}.login .content select.form-control{padding-left:9px;padding-right:9px}.login .content .forget-form,.login .content .register-form{display:none}.login .content .form-title{font-weight:300;margin-bottom:25px}.login .content .form-actions{clear:both;border:0;border-bottom:1px solid #eee;padding:25px 30px;margin-left:-30px;margin-right:-30px}.login .content .form-actions>.btn{margin-top:-2px}.login-options{margin-top:30px;margin-bottom:30px;overflow:hidden}.login-options h4{float:left;font-weight:600;font-size:15px;color:#7d91aa!important}.login-options .social-icons{float:right;padding-top:3px}.login-options .social-icons li a{border-radius:15px!important;-moz-border-radius:15px!important;-webkit-border-radius:15px!important}.login .content .form-actions .checkbox{margin-left:0;padding-left:0}.login .content .forget-form .form-actions{border:0;margin-bottom:0;padding-bottom:20px}.login .content .register-form .form-actions{border:0;margin-bottom:0;padding-bottom:0}.login .content .form-actions .btn{margin-top:1px;font-weight:600;padding:10px 20px!important}.login .content .form-actions .btn-default{font-weight:600;padding:10px 25px!important;color:#6c7a8d;background-color:#fff;border:none}.login .content .form-actions .btn-default:hover{background-color:#fafaff;color:#45b6af}.login .content .forget-password{font-size:14px;float:right;display:inline-block;margin-top:10px}.login .content .check{color:#8290a3}.login .content .rememberme{margin-left:8px}.login .content .create-account{margin:0 -40px -30px;padding:15px 0 17px;text-align:center;background-color:#6c7a8d;-webkit-border-radius:0 0 7px 7px;-moz-border-radius:0 0 7px 7px;-ms-border-radius:0 0 7px 7px;-o-border-radius:0 0 7px 7px;border-radius:0 0 7px 7px}.login .content .create-account>p{margin:0}.login .content .create-account p a{font-weight:600;font-size:14px;color:#c3cedd}.login .content .create-account a{display:inline-block;margin-top:5px}.login .copyright{text-align:center;margin:0 auto 30px 0;padding:10px;color:#7a8ca5;font-size:13px}@media (max-width:440px){.login .content,.login .logo{margin-top:10px}.login .content{width:280px}.login .content h3{font-size:22px}.forget-password{display:inline-block;margin-top:20px}.login-options .social-icons{float:left;padding-top:3px}.login .checkbox{font-size:13px}}
        .page-content-wrapper .page-content {
            margin-left: 0 !important;
        }
        #forget_form {
            display: none;
        }
    </style>

    <div class="content">
    <!-- BEGIN LOGIN FORM -->
    <form id="login_form" action="" method="post">
        <h3 class="form-title">Авторизация</h3>
        <div class="alert alert-danger display-hide">
            <button class="close" data-close="alert"></button>
                <span>
                Enter any username and password. </span>
        </div>
        <div class="form-group">
            <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
            <label class="control-label visible-ie8 visible-ie9">Логин</label>
            <input class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off" placeholder="Логин" name="email"/>
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Пароль</label>
            <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="Пароль" name="password"/>
        </div>
        <div class="form-actions text-center">
            <button type="submit" name="login_btn" class="btn btn-success uppercase">Войти</button>
            <label class="rememberme check">
                <input type="checkbox" class="icheck" name="remember" value="1" checked> Запомнить
            </label>
<!--            <a href="#" id="forget-password" class="forget-password">Забыли Пароль?</a>-->
        </div>
        <div style="height: 100px;">

        </div>
    </form>
    <!-- END LOGIN FORM -->
    <!-- BEGIN FORGOT PASSWORD FORM -->
    <form id="forget_form" action="" method="post">
        <h3>Забыли Пароль?</h3>
        <p>
            Укажите Email для восстановления пароля.
        </p>
        <div class="form-group">
            <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="email"/>
        </div>
        <div class="form-actions">
            <button type="button" id="back_btn" class="btn btn-default">Назад</button>
            <button type="submit" class="btn btn-success uppercase pull-right">Отправить</button>
        </div>
    </form>
    <!-- END FORGOT PASSWORD FORM -->
    </div>
    <div class="copyright">
      @ <?php echo date('Y'); ?> Koh Phangan
    </div>
</body>
<script type="text/javascript">
    $ = jQuery.noConflict();
    $(document).ready(function () {
        $("#forget-password").click(function()
        {
            $('#login_form').slideUp();
            $('#forget_form').slideDown();
        });
        $("#back_btn").click(function()
        {
            $('#login_form').slideDown();
            $('#forget_form').slideUp();
        });
    });
</script>