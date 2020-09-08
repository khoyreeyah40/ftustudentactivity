<?php
require_once("../class/session.php");

require_once("../class/class.student.php");
$auth_std = new STUDENT();

$stdID = $_SESSION['std_session'];

$stmt = $auth_std->runQuery("SELECT * FROM student WHERE stdID=:stdID");
$stmt->execute(array(":stdID" => $stdID));

$stdRow = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name=”viewport” content=”width=device-width, maximum-scale=1, minimum-scale=0.5″ />    
    <meta name="google-site-verification" content="">
    <title>ระบบกิจกรรมนักศึกษา| ข้อมูลส่วนตัว</title>
    <!-- GLOBAL MAINLY STYLES-->
    <link href="../../assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../../assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
    <link href="../../assets/vendors/themify-icons/css/themify-icons.css" rel="stylesheet" />
    <!-- PLUGINS STYLES-->
    <link href="../../assets/vendors/DataTables/datatables.min.css" rel="stylesheet" />
    <link href="../../assets/vendors/jvectormap/jquery-jvectormap-2.0.3.css" rel="stylesheet" />
    <!-- THEME STYLES-->
    <link href="../../assets/css/main.min.css" rel="stylesheet" />
    <link href="../../assets/css/white.css" rel="stylesheet" />
    <style>
    body.fixed-navbar .header {
      top: unset;
    }
  </style>

    <!-- PAGE LEVEL STYLES-->
</head>

<body class="fixed-navbar">
    <div class="page-wrapper">
        <!-- START HEADER-->
        <!-- START HEADER-->
        <?php
        include '../header.php';
        ?>
        <!-- END HEADER-->

        <!-- START SIDEBAR-->
        <ul class="side-menu metismenu">
        <li>
                <a href="../Mactregister/actregisterpage.php" aria-hidden="true"><i class="sidebar-item-icon fa fa-list-alt"></i>
                    <span class="nav-label">ลงทะเบียนกิจกรรม</span>
                </a>
            </li>
            <li>
            <a href="../Mactregistered/actregisteredpage.php" aria-hidden="true"><i class="sidebar-item-icon fa fa-tasks"></i>
                    <span class="nav-label">กิจกรรมที่ได้ลงทะเบียน</span>
                </a>
            </li>
            <li>
                <a href="../Mactparticipant/actparticipantpage.php" aria-hidden="true"><i class="sidebar-item-icon fa fa-check-square"></i>
                    <span class="nav-label">การเข้าร่วมกิจกรรม</span>
                </a>
            </li>
            <li >
                    <a href="../Mcontact/contactpage.php" aria-hidden="true"><i class="sidebar-item-icon fa fa-address-book"></i>
                        <span class="nav-label">ติดต่อ</span>
                    </a>
            </li>
        </ul>
    </div>
    </nav>
    <!-- END HEADER-->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <!-- Main content -->
        <div class="page-content fade-in-up">
            <div class="row">
                <div class="col-12">
                    <iframe height="1084px" width="100%" name="iii" src="profile.php" style="border:none"> </iframe>

                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <footer class="page-footer">
        <div class="font-13">2020 © <b><a href="../me.php">TanenoHato</a></b> - IT 58 Fatoni University.</div>
            <div class="to-top"><i class="fa fa-angle-double-up"></i></div>
        </footer>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    </div>
    <!-- ./wrapper -->


    <!-- END THEME CONFIG PANEL-->
    <!-- BEGIN PAGA BACKDROPS-->
    <!-- END PAGA BACKDROPS-->
    <!-- CORE PLUGINS-->
    <script src="../../assets/vendors/jquery/dist/jquery.min.js" type="text/javascript"></script>
    <script src="../../assets/vendors/popper.js/dist/umd/popper.min.js" type="text/javascript"></script>
    <script src="../../assets/vendors/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="../../assets/vendors/metisMenu/dist/metisMenu.min.js" type="text/javascript"></script>
    <script src="../../assets/vendors/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <!-- PAGE LEVEL PLUGINS-->
    <script src="../../assets/vendors/chart.js/dist/Chart.min.js" type="text/javascript"></script>
    <script src="../../assets/vendors/jvectormap/jquery-jvectormap-2.0.3.min.js" type="text/javascript"></script>
    <script src="../../assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
    <script src="../../assets/vendors/jvectormap/jquery-jvectormap-us-aea-en.js" type="text/javascript"></script>
    <script src="../../assets/vendors/DataTables/datatables.min.js" type="text/javascript"></script>
    <!-- CORE SCRIPTS-->
    <script src="../../assets/js/app.min.js" type="text/javascript"></script>
    <!-- PAGE LEVEL SCRIPTS-->
    <script src="../../assets/js/scripts/dashboard_1_demo.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(function() {
            $('#tbhome1').DataTable({
                pageLength: 10,
                //"ajax": './assets/demo/data/table_data.json',
                /*"columns": [
                    { "data": "name" },
                    { "data": "office" },
                    { "data": "extn" },
                    { "data": "start_date" },
                    { "data": "salary" }
                ]*/
            });
            $('#tbhome2').DataTable({
                pageLength: 10,
                //"ajax": './assets/demo/data/table_data.json',
                /*"columns": [
                    { "data": "name" },
                    { "data": "office" },
                    { "data": "extn" },
                    { "data": "start_date" },
                    { "data": "salary" }
                ]*/
            });
        })
    </script>
</body>

</html>