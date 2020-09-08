<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name=”viewport” content=”width=device-width, maximum-scale=1, minimum-scale=0.5″ />    
    <title>ระบบกิจกรรมนักศึกษา| Login สำหรับนักศึกษา</title>
    <!-- GLOBAL MAINLY STYLES-->
    <link href="../../assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../../assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
    <link href="../../assets/vendors/themify-icons/css/themify-icons.css" rel="stylesheet" />
    <!-- THEME STYLES-->
    <link href="../../assets/css/main.css" rel="stylesheet" />
    <!-- PAGE LEVEL STYLES-->
    <link href="../../assets/css/pages/auth-light.css" rel="stylesheet" />
</head>

<body class="bg-silver-300">
    <div class="content">
        <div class="brand">
        <div><p><img src="../../assets/img/head-ftu.png" /></p></div>
            <a class="link" href="../../welcome/home.php" style="color:#528124;">
                <h2>ระบบกิจกรรมนักศึกษา</h2>
            </a>
        </div>
        <div id="error">
            <?php
            if (isset($error)) {
            ?>
                <div class="alert alert-danger alert-bordered">
                    <i class="fa fa-warning"></i> &nbsp; <?php echo $error; ?> !
                </div>
            <?php
            }
            ?>
        </div>
        <form id="login-form" action="mlogin.php" method="post">
            <h2 class="login-title">Log in</h2>
            <h5 class="login-title">(สำหรับนักศึกษา)</h5>

            <div class="form-group">
                <div class="input-group-icon right">
                    <div class="input-icon"><i class="fa fa-id-card"></i></div>
                    <input class="form-control" type="text" name="stdID" placeholder="Student ID" autocomplete="off">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group-icon right">
                    <div class="input-icon"><i class="fa fa-lock font-16"></i></div>
                    <input class="form-control" type="password" name="stdPassword" placeholder="Password">
                </div>
            </div>
            <div class="form-group">
                <button class="btn btn-info btn-block" type="submit" name="btlogin">Login</button>
            </div>
            <div class="text-center">ยังไม่ได้ลงทะเบียน?
                <a class="color-blue" href="register.php">Register</a>
            </div>
        </form>
    </div>
    <!-- BEGIN PAGA BACKDROPS-->
    <div class="sidenav-backdrop backdrop"></div>
    <div class="preloader-backdrop">
        <div class="page-preloader">Loading</div>
    </div>
    <!-- END PAGA BACKDROPS-->
    <!-- CORE PLUGINS -->
    <script src="../../assets/vendors/jquery/dist/jquery.min.js" type="text/javascript"></script>
    <script src="../../assets/vendors/popper.js/dist/umd/popper.min.js" type="text/javascript"></script>
    <script src="../../assets/vendors/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- PAGE LEVEL PLUGINS -->
    <script src="../../assets/vendors/jquery-validation/dist/jquery.validate.min.js" type="text/javascript"></script>
    <!-- CORE SCRIPTS-->
    <script src="../../assets/js/app.js" type="text/javascript"></script>
    <!-- PAGE LEVEL SCRIPTS-->
    <script type="text/javascript">
        $(function() {
            $('#login-form').validate({
                errorClass: "help-block",
                rules: {
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true
                    }
                },
                highlight: function(e) {
                    $(e).closest(".form-group").addClass("has-error")
                },
                unhighlight: function(e) {
                    $(e).closest(".form-group").removeClass("has-error")
                },
            });
        });
    </script>
</body>

</html>