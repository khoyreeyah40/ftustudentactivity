<?php
include("../db/dbconfig.php");
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name=”viewport” content=”width=device-width, maximum-scale=1, minimum-scale=0.5″ />    
    <meta name="google-site-verification" content="">
    <!-- GLOBAL MAINLY STYLES-->
    <link href="../assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
    <link href="../assets/vendors/themify-icons/css/themify-icons.css" rel="stylesheet" />
    <!-- PLUGINS STYLES-->
    <link href="../assets/vendors/fullcalendar/dist/fullcalendar.min.css" rel="stylesheet" />
    <link href="../assets/vendors/fullcalendar/dist/fullcalendar.print.min.css" rel="stylesheet" media="print" />
    <link href="../assets/vendors/DataTables/datatables.min.css" rel="stylesheet" />
    <link href="../assets/vendors/jvectormap/jquery-jvectormap-2.0.3.css" rel="stylesheet" />
    <!-- THEME STYLES-->
    <link href="assets/css/main.min.css" rel="stylesheet" />
    <!-- PAGE LEVEL STYLES-->
    <style>
        .sidebar-mini {
            margin-left: 0px;
        }

        .content-wrapper {
            margin-left: 0px;
        }

        .carousel-inner>.item>img,
        .carousel-inner>.item>a>img {
            width: 100%;
            margin: auto;
            height: 400px;

        }

        .col-sm-3 {
            margin: 0px 0px;
            padding: 0px 0px;
        }
        body.fixed-navbar .header {
            top: unset;
        }
    </style>
</head>

<body class="fixed-navbar" style="min-height: 100%;top: 100px;">
    
    <div class="page-wrapper">
        <!-- START HEADER-->
        <header class="header">
            <div class="flexbox flex-1" style="background-color:#528124;color:#FFFFFF;">
                <!-- START TOP-RIGHT TOOLBAR-->
                <ul class="nav navbar-toolbar">
                    <li>
                        <div><a href="http://www.ftu.ac.th/2019/index.php/th/"><img src="../assets/img/head-ftu.png" width="140" height="40"/></a></div></li>
                    <li>
                    <h4 style="padding-left: 10px;"><a href="home.php"style="color:#FFFFFF;">ระบบกิจกรรมนักศึกษามหาวิทยาลัยฟาฏอนี</a></h4>
                    </li>
                </ul>
                <ul class="nav navbar-toolbar ml-auto">
                <li class="dropdown dropdown-user">
                <div class="language">
                    <div class="google">
                        <div id="google_translate_element"><div class="skiptranslate goog-te-gadget" dir="ltr" ><div id=":0.targetLanguage" class="goog-te-gadget-simple" style="white-space: nowrap;"><img src="https://www.google.com/images/cleardot.gif" class="goog-te-gadget-icon" alt="" style="background-image: url(&quot;https://translate.googleapis.com/translate_static/img/te_ctrl3.gif&quot;); background-position: -65px 0px;"><span style="vertical-align: middle;"><a aria-haspopup="true" class="goog-te-menu-value" href="javascript:void(0)"><span>เลือกภาษา</span><img src="https://www.google.com/images/cleardot.gif" alt="" width="1" height="1"><span style="border-left: 1px solid rgb(187, 187, 187);">​</span><img src="https://www.google.com/images/cleardot.gif" alt="" width="1" height="1"><span aria-hidden="true" style="color: rgb(118, 118, 118);">▼</span></a></span></div></div></div>
                        <script type="text/javascript">
                            function googleTranslateElementInit() {
                                new google.translate.TranslateElement({pageLanguage: 'th', includedLanguages: 'zh-CN,de,id,km,lo,ms,my,th,tl,vi,th,en', layout: google.translate.TranslateElement.InlineLayout.SIMPLE, multilanguagePage: true}, 'google_translate_element');
                            }
                        </script>
                        <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
                    </div>
                </div>
                    </li>
                <li class="dropdown dropdown-user">
                <a class="nav-link dropdown-toggle link" href="contact.php" style="font-size: 16px;color:#FFFFFF;">ติดต่อ</a>
                    </li>
                    <li class="dropdown dropdown-user">
                        <a class="nav-link dropdown-toggle link" data-toggle="dropdown" style="font-size: 16px;color:#FFFFFF;">
                            <span></span>เข้าสู่ระบบ<i class="fa fa-angle-down m-l-5"></i></a>
                        <ul class="dropdown-menu dropdown-menu-right" >
                            <a class="dropdown-item" href="../admin/Mlogin/login.php"style="color:#528124;"><i class="fa fa-user"></i>เจ้าหน้าที่</a>
                            <li class="dropdown-divider"></li>
                            <a class="dropdown-item" href="../student/Mlogin/login.php"style="color:#528124;"><i class="fa fa-child"></i>นักศึกษา</a>
                        </ul>
                    </li>
                </ul>
                <!-- END TOP-RIGHT TOOLBAR-->
            </div>
        </header>
        <!-- END HEADER-->
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper pb-2" style="background-color:#f4f4fc;">
            <!-- Content Header (Page header) -->
            <!-- Main content -->
            <div class="page-content fade-in-up">
                <div class="row">
                    <div class="col-12 mb-2">
                        <div class="card"style="border-width:0px;border-top-width:4px;color:#FFFFFF;">
                            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                                <ol class="carousel-indicators">
                                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                                    <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
                                    <li data-target="#carouselExampleIndicators" data-slide-to="4"></li>
                                </ol>
                                <div class="carousel-inner" role="listbox">
                                    <?php
                                    require_once '../db/dbconfig.php';
                                    $stmt = $DBcon->prepare("SELECT *FROM board where boardStatus='แสดง' order by boardNo DESC limit 4   ");

                                    $stmt->execute();
                                    $num = 0;

                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                                        $num++;

                                    ?>
                                        <div class="carousel-item  <?php if ($num == "1") {
                                                                        echo "active";
                                                                    } else {
                                                                    }
                                                                    ?>">
                                            <?php if($row['boardLink']!=null){ ?>
                                    <a href="<?php echo $row['boardLink']; ?>" target="_blank"><img src="../assets/img/<?php echo $row['board']; ?>" class="d-block w-100" alt="" style="height: 450px;width:100%;"></a>
                                    <?php }else{ ?>
                                    <img src="../assets/img/<?php echo $row['board']; ?>" class="d-block w-100" alt="" style="height: 450px;width:100%;">
                                    <?php } ?><div class="carousel-caption"style="color:#528124;">
                                        <br>
                                        <?php echo $row['boardDiscribe']; ?>
                                    </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card -->
                <br>
                <div class="row ml-1 mr-1">
                    <div class="col-8" >
                        <nav class="navbar navbar-light justify-content-between mb-0 pb-0 pr-0 pl-0  ">
                            <a class="navbar-brand">
                                <h3 style="color:#417d19;">ข่าวประชาสัมพันธ์</h3>
                            </a>
                            <a class="ml-auto" href="newsall.php" >ดูทั้งหมด>>></a>
                        </nav>
                        <b><hr style="margin-top: 0rem;border-color:#528124;border-width: 2px;"></b>
                        <div class="card" style="padding:0px 17.5px;border-width:0px;border-top-width:4px;">
                            <div class="row" >
                                <div class="col-sm-12" >
                                    <div class="card-deck">
                                        <?php
                                        $stmt = $DBcon->prepare("SELECT *  FROM news  where news.newsStatus='แสดง' ORDER BY newsNo DESC limit 0,8 ");
                                        $stmt->execute();
                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                            $newsStatus  = $row["newsStatus"];
                                            $newsImage   = $row['newsImage'];
                                            $newsTitle      = $row["newsTitle"];
                                        ?>

                                            <div class="col-sm-3 mt-4">
                                                <div class="card m-2">
                                                    <a type="button" data-toggle="modal" data-target="#modalnewsinfo" data-id="<?php echo $row['newsNo']; ?>" id="newsinfo"><img class="card-img-top p-2" src="../assets/img/<?php echo $row['newsImage']; ?>" style="height: 100%;width:100%;background-color:#ebf2e6;" /></a>
                                                    <div class="card-body"style="background-color:#528124;color:#FFFFFF;">
                                                        <div><?php echo $newsTitle ?></div>
                                                    </div>
                                                    <div class="modal fade" id="modalnewsinfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg" role="document">
                                                            <div class="modal-content ">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLongTitle"style="color:#417d19;">รายละเอียดเพิ่มเติม</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div id="modal-loader" style="text-align: center; display: none;">
                                                                        <img src="ajax-loader.gif">
                                                                    </div>
                                                                    <div id="dynamic-content">

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <br>
                        </div>
                        <!-- /.card-header -->
                        <!-- /.card-body -->
                        <!-- /.card -->
                    </div>
                    <div class="col-4">
                        <nav class="navbar navbar-light justify-content-between mb-0 pb-0 pr-0 pl-0  ">
                            <a class="navbar-brand">
                                <h3 style="color:#528124;">เอกสาร</h3>
                            </a>
                            <a class="ml-auto" href="fileall.php">ดูทั้งหมด>>></a>
                        </nav>
                        <b><hr style="margin-top: 0rem;border-color:#528124;border-width: 2px;"></b>
                        <div class="card" style="border-width:0px;border-top-width:4px;">
                            <br>
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table table-hover table-striped ">
                                        <tbody>
                                            <?php
                                            require_once '../db/dbconfig.php';
                                            $stmt = $DBcon->prepare("SELECT * FROM file WHERE fileStatus='แสดง' ORDER BY fileNo DESC");
                                            $stmt->execute();
                                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                            ?>
                                                <tr>
                                                    <td style="font-size:14px;"><a href="../admin/file/<?php echo $row['fileDoc']; ?>"><span class="fa fa-edit"></span>&nbsp; <?php echo $row['fileName']; ?></a></td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <br>
                        </div>
                        <!-- /.card-body -->
                        <!-- /.card -->
                    </div>
                </div>
                <!-- /.col -->

                <br>
                <div class="row ml-1 mr-1">
                    <div class="col-12">
                        <nav class="navbar navbar-light justify-content-between mb-0 pb-0 pr-0 pl-0  ">
                            <a class="navbar-brand">
                                <h3 style="color:#528124;">ตารางกิจกรรม</h3>
                            </a>
                            <a class="ml-auto" href="actall.php">ดูทั้งหมด>>></a>
                        </nav>
                        <b><hr style="margin-top: 0rem;border-color:#528124;border-width: 2px;"></b>
                        <div class="card"style="border-width:0px;border-top-width:4px;">
                            <!-- /.card-header -->
                            <div class="card-body text-nowrap">
                                <table id="tbhome" class="table table-hover-sm table-striped text-center" cellspacing="0" width="100%">
                                    <thead>
                                        <tr style="color:#417d19;">
                                            <th>ชื่อกิจกรรม</th>
                                            <th>เวลา</th>
                                            <th>วันที่</th>
                                            <th>กลุ่ม</th>
                                            <th>สังกัด</th>
                                            <th>องค์กร</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        require_once '../db/dbconfig.php';
                                        $stmt = $DBcon->prepare("SELECT activity.*,mainorg.*,organization.* FROM activity 
                                        JOIN mainorg ON mainorg.mainorgNo = activity.actMainorg
                                        JOIN organization ON organization.orgtionNo = activity.actOrgtion
                                        WHERE activity.actStatus='ดำเนินกิจกรรม'||activity.actStatus='ปลดล๊อก' ORDER BY activity.actStatus='actDateb' DESC");
                                        $stmt->execute();
                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        ?>
                                            <tr>
                                                <td><a href="" data-toggle="modal" data-target="#modalmoreactinfo" data-id="<?php echo $row['actID']; ?>" id="moreactinfo"><?php echo $row['actName']; ?></a></td>
                                                <td><?php echo $row['actTimeb']; ?>-<?php echo $row['actTimee']; ?></td>
                                                <td><?php echo $row['actDateb']; ?>-<?php echo $row['actDatee']; ?></td>
                                                <td><?php echo $row['actGroup']; ?></td>
                                                <td><?php echo $row['mainorg']; ?></td>
                                                <td><?php echo $row['organization']; ?></td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="modal fade" id="modalmoreactinfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content ">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle"style="color:#528124;">รายละเอียดเพิ่มเติม</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div id="modal-loader1" style="text-align: center; display: none;">
                                                <img src="ajax-loader.gif">
                                            </div>
                                            <div id="dynamic-content1">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <!-- /.card -->
                        </div>
                    </div>
                </div>
                <!-- /.col -->
                <!-- /.row -->
                
            </div>
            <!-- /.content -->
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
                
                <div class="font-13">2020 © <b><a href="me.php">TanenoHato</a></b> - IT 58 Fatoni University.</div>
                <div class="to-top"><i class="fa fa-angle-double-up"></i></div>
            </footer>
        </div>
        <!-- /.content-wrapper -->

    </div>
    <!-- ./wrapper -->


    <!-- END THEME CONFIG PANEL-->
    <!-- BEGIN PAGA BACKDROPS-->
    <div class="sidenav-backdrop backdrop"></div>
    <div class="preloader-backdrop">
        <div class="page-preloader">Loading</div>
    </div>
    <!-- END PAGA BACKDROPS-->
    <!-- CORE PLUGINS-->
    <script src="../assets/vendors/jquery/dist/jquery.min.js" type="text/javascript"></script>
    <script src="../assets/vendors/popper.js/dist/umd/popper.min.js" type="text/javascript"></script>
    <script src="../assets/vendors/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="../assets/vendors/metisMenu/dist/metisMenu.min.js" type="text/javascript"></script>
    <script src="../assets/vendors/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <!-- PAGE LEVEL PLUGINS-->
    <script src="../assets/vendors/chart.js/dist/Chart.min.js" type="text/javascript"></script>
    <script src="../assets/vendors/jvectormap/jquery-jvectormap-2.0.3.min.js" type="text/javascript"></script>
    <script src="../assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
    <script src="../assets/vendors/jvectormap/jquery-jvectormap-us-aea-en.js" type="text/javascript"></script>
    <script src="../assets/vendors/DataTables/datatables.min.js" type="text/javascript"></script>
    <script src="../assets/vendors/moment/min/moment.min.js" type="text/javascript"></script>
    <script src="../assets/vendors/fullcalendar/dist/fullcalendar.min.js" type="text/javascript"></script>
    <script src="../assets/vendors/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
    <!-- CORE SCRIPTS-->
    <script src="../assets/js/app.min.js" type="text/javascript"></script>
    <!-- PAGE LEVEL SCRIPTS-->
    <script src="../assets/js/scripts/dashboard_1_demo.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(function() {
            $('#tbhome').DataTable({
                pageLength: 10,
                "scrollX": true
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
    <script>
        /* View Function*/
        $(document).ready(function() {

            $(document).on('click', '#moreactinfo', function(e) {

                e.preventDefault();

                var actid = $(this).data('id'); // it will get id of clicked row

                $('#dynamic-content1').html(''); // leave it blank before ajax call
                $('#modal-loader1').show(); // load ajax loader

                $.ajax({
                        url: 'moreactinfo.php',
                        type: 'POST',
                        data: 'id=' + actid,
                        dataType: 'html'
                    })
                    .done(function(data) {
                        console.log(data);
                        $('#dynamic-content1').html('');
                        $('#dynamic-content1').html(data); // load response 
                        $('#modal-loader1').hide(); // hide ajax loader 
                    })
                    .fail(function() {
                        $('#dynamic-content1').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
                        $('#modal-loader1').hide();
                    });

            });

        });
    </script>
    <script>
        /* View Function*/
        $(document).ready(function() {

            $(document).on('click', '#newsinfo', function(e) {

                e.preventDefault();

                var newsno = $(this).data('id'); // it will get id of clicked row

                $('#dynamic-content').html(''); // leave it blank before ajax call
                $('#modal-loader').show(); // load ajax loader

                $.ajax({
                        url: 'morenewsinfo.php',
                        type: 'POST',
                        data: 'id=' + newsno,
                        dataType: 'html'
                    })
                    .done(function(data) {
                        console.log(data);
                        $('#dynamic-content').html('');
                        $('#dynamic-content').html(data); // load response 
                        $('#modal-loader').hide(); // hide ajax loader 
                    })
                    .fail(function() {
                        $('#dynamic-content').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
                        $('#modal-loader').hide();
                    });

            });

        });
    </script>
</body>

</html>