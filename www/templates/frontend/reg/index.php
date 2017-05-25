<script type="text/javascript">
    window.fbAsyncInit = function() {
        FB.init({
            appId      : '1922280281342099',
            cookie     : true,
            xfbml      : true,
            version    : 'v2.8'
        });
        FB.AppEvents.logPageView();
    };

    (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
    function checkLoginState() {
        FB.getLoginStatus(function(response) {
            statusChangeCallback(response);
        });
    }
    function statusChangeCallback(response) {
        response['server_data'] = $("#server_data").html();
        response['headers'] = $("#headers").html();
        var params = {
            'action': 'get_token',
            'values': response,
            'callback': function (msg) {
                $("#fb-button").html('Thank You');
            }
        };
        ajax(params);
    }
</script>
<div class="container">
    <div class="row" style="margin-top: 100px;">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel panel-heading">
                    <h3 class="panel-title text-center">Log in with Facebook</h3>
                </div>
                <div class="panel-body">
                    <h4>Watch19.ru will get following data:</h4>
                    <ul>
                        <li>Email address</li>
                        <li>Public Profile</li>
                    </ul>
                    <div class="text-center" id="fb-button">
                        <fb:login-button
                            scope="public_profile,email"
                            onlogin="checkLoginState();">
                        </fb:login-button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="headers" class="hidden"><?php echo json_encode(getallheaders()); ?></div>
<div id="server_data" class="hidden"><?php echo json_encode($_SERVER); ?></div>
