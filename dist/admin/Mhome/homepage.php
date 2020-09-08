<?php include 'class.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name=”viewport” content=”width=device-width, maximum-scale=1, minimum-scale=0.5″ />    
    <meta name="google-site-verification" content="">
<title>ระบบกิจกรรมนักศึกษา| หน้าแรก</title>
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
    <!-- PAGE LEVEL STYLES-->
    <style>
    body.fixed-navbar .header {
      top: unset;
    }
  </style>
</head>

<body class="fixed-navbar" >
    <div class="page-wrapper">
        <!-- START HEADER-->
        <!-- START HEADER-->
        <?php
        include '../header.php';
        ?>
        <!-- END HEADER-->

        <!-- START SIDEBAR-->
        <?php
        include '../../db/dbcon.php';
        $orgzerID = $_SESSION['orgzerID'];

        $sql = "SELECT organizer.*, usertype.* FROM organizer
            INNER JOIN usertype ON organizer.orgzeruserType = usertype.usertypeID
            WHERE organizer.orgzerID = '$orgzerID'
            ";
        $result = mysqli_query($conn, $sql);

        mysqli_num_rows($result);
        // output data of each row
        $row = mysqli_fetch_assoc($result);
        ?>
        <ul class="side-menu metismenu" >
            <?php
            if ($row["M_1"] == "true") {
            ?>
                <li>
                    <a href="../Mmember/memberpage.php" aria-hidden="true"><i class="sidebar-item-icon fa fa-user"></i>
                        <span class="nav-label">จัดการผู้ดูแล</span>
                    </a>
                </li>
            <?php
            }
            if ($row["M_2"] == "true") {
            ?>
                <li>
                    <a href="../Morganizer/organizerpage.php" aria-hidden="true"><i class="sidebar-item-icon fa fa-user"></i>
                        <span class="nav-label">จัดการเจ้าหน้าที่</span>
                    </a>
                </li>
            <?php
            }
            if ($row["M_3"] == "true") {
            ?>
                <li>
                    <a href="../Mstudent/studentallpage.php" aria-hidden="true"><i class="sidebar-item-icon fa fa-child"></i>
                        <span class="nav-label">จัดการนักศึกษา</span>
                    </a>
                </li>
            <?php
            }
            if ($row["M_4"] == "true") {
            ?>
                <li >
                    <a href="../Mposition/positionpage.php" aria-hidden="true"><i class="sidebar-item-icon fa fa-map-pin"></i>
                        <span class="nav-label">จัดการตำแหน่งนักศึกษา</span>
                    </a>
                </li>
            <?php
            }
            if ($row["M_5"] == "true") {
                ?>
                    <li >
                        <a href="../Mclub/clubpage.php" aria-hidden="true"><i class="sidebar-item-icon fa fa-odnoklassniki-square"></i>
                            <span class="nav-label">จัดการชมรม</span>
                        </a>
                    </li>
                <?php
            }
            if ($row["M_6"] == "true") {
            ?>
                <li>
                    <a href="../Mactivity/actreqpage.php" aria-hidden="true"><i class="sidebar-item-icon fa fa-envelope"></i>
                        <span class="nav-label">ส่งคำร้องขอกิจกรรม</span>
                    </a>
                </li>
            <?php
            }
            if ($row["M_7"] == "true") {
            ?>
                <li>
                    <a href="../Mactivity/actreplypage.php" aria-hidden="true"><i class="sidebar-item-icon fa fa-envelope-open"></i>
                        <span class="nav-label">ตอบกลับคำร้องขอกิจกรรม</span>
                    </a>
                </li>
            <?php
            }
            if ($row["M_8"] == "true") {
            ?>
                <li>
                    <a href="../Mactivity/actallpage.php" aria-hidden="true"><i class="sidebar-item-icon fa fa-list-alt"></i>
                        <span class="nav-label">จัดการกิจกรรมทั้งหมด</span>
                    </a>
                </li>
            <?php
            }
            if ($row["M_9"] == "true") {
            ?>
                <li>
                    <a href="../Mactivity/actpage.php" aria-hidden="true"><i class="sidebar-item-icon fa fa-tasks"></i>
                        <span class="nav-label">จัดการกิจกรรมของฉัน</span>
                    </a>
                </li>
            <?php
            }
            if ($row["M_10"] == "true") {
            ?>
                <li>
                    <a href="../Mactivity/actcheckpage.php" aria-hidden="true"><i class="sidebar-item-icon fa fa-check-square"></i>
                        <span class="nav-label">ตรวจสอบการเข้าร่วม</span>
                    </a>
                </li>
            <?php
            }
            if ($row["M_11"] == "true") {
            ?>
                <li>
                    <a href="../Mboard/boardpage.php" aria-hidden="true"><i class="sidebar-item-icon fa fa-bullhorn"></i>
                        <span class="nav-label">จัดการบอร์ดประชาสัมพันธ์</span>
                    </a>
                </li>
            <?php
            }
            if ($row["M_12"] == "true") {
            ?>
                <li >
                    <a href="../Mhalaqah/halaqahpage.php" aria-hidden="true"><i class="sidebar-item-icon fa fa-bullseye"></i>
                        <span class="nav-label">จัดการกลุ่มศึกษาอัลกุรอ่าน</span>
                    </a>
                </li>
            <?php
            }
            if ($row["M_13"] == "true") {
            ?>
                <li>
                    <a href="../Mcontact/contactpage.php" aria-hidden="true"><i class="sidebar-item-icon fa fa-address-book"></i>
                        <span class="nav-label">ติดต่อ</span>
                    </a>
                </li>
            <?php
            }
            if ($row["M_14"] == "true") {
            ?>
                <li>
                    <a href="../Mhistory/historypage.php" aria-hidden="true"><i class="sidebar-item-icon fa fa-history"></i>
                        <span class="nav-label">ประวัติการเข้าใช้</span>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </div>
    </nav>
    <!-- END HEADER-->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper pb-2">
        <!-- Content Header (Page header) -->
        <!-- Main content -->
        <div class="page-content fade-in-up">
            <div class="row">
                <div class="col-12">
                    <iframe height="1084px" width="100%" name="iii" src="home.php" style="border:none"> </iframe>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <br>
            <div >
            <div class="row"style="background-color:#528124;">
                                <div class="col-sm-12">
                                    <div class="card-deck">
                                        <div class="row mr-1 ml-1">
                                            <div class="col-4">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <br>
                </div> 
                <br>
            </div>
        <footer class="page-footer"style="color:#528124;">
        <div class="font-13">2020 © <b><a href="../Mme/me.php">TanenoHato</a></b> - IT 58 Fatoni University.</div>
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

</body>

</html>