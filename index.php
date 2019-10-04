<?php
session_start();

include('inc/global_vars.php');

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>
        <?php echo $site['title']; ?>.
    </title>

    <link rel="apple-touch-icon" sizes="57x57" href="images/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="images/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="images/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="images/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="images/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="images/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="images/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="images/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="images/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="images/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="images/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon-16x16.png">
    <!-- <link rel="manifest" href="/manifest.json"> -->
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="images/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="plugins/iCheck/square/blue.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body class="hold-transition login-page">
    <div class="row">
        <div class="col-lg-12">
            <center>
                <b><?php echo $site['title']; ?></b>
            </center>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="login-box">
                <div id="login_form">
                    <div class="login-box-body">
                        <center>
                            <h3>Admin Login</h3>
                        </center>

                        <p class="login-box-msg">Sign in</p>
                        
                        <div id="status_message"></div>
                        
                        <form action="login.php" method="post">
                            <div class="form-group has-feedback">
                                <input type="text" class="form-control" placeholder="username" name="username" id="username">
                                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                            </div>
                            <div class="form-group has-feedback">
                                <input type="password" class="form-control" placeholder="********" name="password" id="password">
                                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <button type="submit" class="btn btn-block btn-primary btn-flat full-width">Sign In</button>
                                </div>
                            </div>
                        </form>

                        <div class="social-auth-links text-center"></div>                    
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="login-box">
                <div id="login_form">
                    <div class="login-box-body">
                        <center>
                            <h3>Reseller Login</h3>
                        </center>
                        
                        <p class="login-box-msg">Sign in</p>
                        
                        <div id="status_message"></div>
                        
                        <form action="login.php" method="post">
                            <div class="form-group has-feedback">
                                <input type="text" class="form-control" placeholder="username" name="username" id="username">
                                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                            </div>
                            <div class="form-group has-feedback">
                                <input type="password" class="form-control" placeholder="********" name="password" id="password">
                                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <button type="submit" class="btn btn-block btn-primary btn-flat full-width">Sign In</button>
                                </div>
                            </div>
                        </form>

                        <div class="social-auth-links text-center"></div>                    
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="plugins/iCheck/icheck.min.js"></script>
    <script>
        $(function() {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });

        function switch_content(div_name) {
            if (div_name == 'register') {
                $("login").hide();
                $("register").show();
            }
            if (div_name == 'login') {
                $("register").hide();
                $("login").show();
            }
        }
    </script>

    
    <?php if(!empty($_SESSION['alert']['status'])){ ?>
        <script>
            document.getElementById('status_message').innerHTML = '<div class="callout callout-<?php echo $_SESSION['alert']['status']; ?> lead"><p><?php echo $_SESSION['alert']['message']; ?></p></div>';
            setTimeout(function() {
                $('#status_message').fadeOut('fast');
            }, 5000);
        </script>
    <?php unset($_SESSION['alert']); ?>
<?php } ?>
</body>

</html>