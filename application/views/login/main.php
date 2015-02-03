<!DOCTYPE html>
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--><html lang="en"><!--<![endif]-->

<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Bootstrap Stylesheet -->
    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css" media="screen">

    <!--  Fluid Grid System -->
    <!--<link rel="stylesheet" href="/assets/css/fluid.css" media="screen">-->

    <!-- Login Stylesheet -->
    <link rel="stylesheet" href="/assets/css/form.css" media="screen">
    <link rel="stylesheet" href="/assets/css/login.css" media="screen">
    <link rel="stylesheet" href="/assets/plugins/zocial/zocial.css" media="screen">

    <title>Subianto & Siane</title>

</head>

<body>

<div id="da-home-wrap">
    <div id="da-home-wrap-inner">
        <div id="da-home-inner">
            <div id="da-home-box">
                <div id="da-home-box-header">
                    <span class="da-home-box-title">Login</span>
                </div>
                <form class="da-form da-home-form" method="post" action="/login/authenticate">
                    <div class="da-form-row">
                        <div class=" da-home-form-big">
                            <input type="text" name="username" id="da-login-username" placeholder="Username">
                        </div>
                        <div class=" da-home-form-big">
                            <input type="password" name="password" id="da-login-password" placeholder="Password">
                        </div>
                    </div>
                    <div class="da-form-row">
                        <ul class="da-form-list inline">
                            <li><input type="checkbox" name="remember" id="remember"> <label for="remember">Remember me</label></li>
                            <!-- <li class="pull-right"><a href="#">Forget password</a></li> -->
                        </ul>
                    </div>
                    <div class="da-home-form-btn-big">
                        <input type="submit" value="Login" id="da-login-submit" class="btn btn-danger btn-block">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JS Libs -->
<script src="/assets/js/libs/jquery-1.8.3.min.js"></script>
<script src="/assets/js/libs/jquery.placeholder.min.js"></script>
<script src="/assets/js/plugins/validate/jquery.validate.min.js"></script>

<!-- JS Login -->
<script src="/assets/js/core/dandelion.login.js"></script>

</body>
</html>
