<?php
include("../../db/dbconfig.php");
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width initial-scale=1.0">
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
    <!-- PAGE LEVEL STYLES-->
</head>

<body class="fixed-navbar">
    <!-- START HEADER-->
    <!-- END HEADER-->
    <!-- Content Wrapper. Contains page content -->
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <div class="page-content fade-in-up mt-0 pt-0">
        <div class="row">
            <div class="col-12 mb-0 pb-0">

                <br>
                <div class="card">
                    <div class="card-body">
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
                                $stmt = $DBcon->prepare("SELECT *FROM publucize where publucize.status='1' order by id DESC limit 4   ");

                                $stmt->execute();
                                $num = 0;

                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                                    $num++;

                                ?>
                                    <div class="item <?php if ($num == "1") {
                                                            echo "active";
                                                        } else {
                                                        }
                                                        ?>">
                                        <img src="../../welcome/<?php echo $row['title']; ?>" alt="">
                                        <div class="carousel-caption">
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
                <!-- /.card -->
                <br>
                <div class="card">
                    <div class="card-header">
                        <h2>ตารางกิจกรรม</h2>&nbsp;&nbsp;&nbsp;ปีการศึกษา&nbsp;
                        <select name="year" id="year" style="width:80px;">
                            <option value="">ทั้งหมด</option>
                            <option value="2564">2564</option>
                            <option value="2563">2563</option>
                            <option value="2562">2562</option>
                            <option value="2561">2561</option>
                            <option value="2560">2560</option>
                            <option value="2559">2559</option>
                            <option value="2558">2558</option>
                            <option value="2557">2557</option>
                            <option value="2556">2556</option>
                            <option value="2555">2555</option>
                        </select>
                        &nbsp;&nbsp;&nbsp;ภาคการศึกษา&nbsp;
                        <select name="term" id="term" style="width:60px;">
                            <option value="">ทั้งหมด</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                        </select>
                        &nbsp;&nbsp;&nbsp;กลุ่ม&nbsp;
                        <select name="term" id="term" style="width:60px;">
                            <option value="">ทั้งหมด</option>
                            <option value="1">ชาย(01)</option>
                            <option value="2">หญิง(02)</option>
                        </select>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body  pad table-responsive">
                        <table id="tbhome1" class="table table-bordered table-striped text-center">
                            <thead>
                                <tr>
                                    <th>ชื่อกิจกรรม</th>
                                    <th>วัน/เวลา</th>
                                    <th>กลุ่ม</th>
                                    <th>หมวดกิจกรรม</th>
                                    <th>รับ</th>
                                    <th>สมัคร</th>
                                    <th>สถานะ</th>
                                    <th>เพิ่มเติม</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalhome0">
                                            เพิ่มเติม
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="modal fade" id="modalhome0" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content ">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">รายละเอียดกิจกรรม</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div id="modal-loader" style="text-align: center; display: none;">
                                            <img src="ajax-loader.gif">
                                        </div>
                                        <!-- content will be load here -->
                                        <div id="dynamic-content">
                                            <div class="card-body">
                                                <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" id="custom-content-below-home-tab" data-toggle="pill" href="#custom-content-below-home" role="tab" aria-controls="custom-content-below-home" aria-selected="true">รายละเอียด</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="custom-content-below-profile-tab" data-toggle="pill" href="#custom-content-below-profile" role="tab" aria-controls="custom-content-below-profile" aria-selected="false">รายชื่อผู้ลงทะเบียน</a>
                                                    </li>
                                                </ul>
                                                <div class="tab-content" id="custom-content-below-tabContent">
                                                    <div class="tab-pane fade show active" id="custom-content-below-home" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
                                                        <div class="row mt-2">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>ปีการศึกษา</label>
                                                                    <input type="text" class="form-control" disabled>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>ภาคเรียน</label>
                                                                    <input type="text" class="form-control" disabled>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>ชื่อกิจกรรม</label>
                                                                    <input type="text" class="form-control" disabled>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>วัน/เวลาจัดกิจกรรม</label>
                                                                    <input type="text" class="form-control" disabled>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>สถานที่</label>
                                                                    <input type="text" class="form-control" disabled>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>กลุ่ม</label>
                                                                    <input type="text" class="form-control" disabled>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>จำนวนรับ</label>
                                                                    <input type="text" class="form-control" disabled>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>หมวดกิจกรรม</label>
                                                                    <input type="text" class="form-control" disabled>
                                                                </div>
                                                            </div>
                                                            <!-- /.col -->
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>จัดทำโดย</label>
                                                                    <input type="text" class="form-control" disabled>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>ค่าธรรมเนียมเข้าร่วม</label>
                                                                    <input type="text" class="form-control" disabled>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="inputDescription">วัตถุประสงค์</label>
                                                                    <textarea id="inputDescription" class="form-control" rows="1" disabled></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="inputDescription">หมายเหตุ</label>
                                                                    <textarea id="inputDescription" class="form-control" rows="1" disabled></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="custom-content-below-profile" role="tabpanel" aria-labelledby="custom-content-below-profile-tab">
                                                        <div class="card-body pad table-responsive">
                                                            <table id="tbhome2" class="table table-bordered table-striped text-center">
                                                                <thead>
                                                                    <tr>
                                                                        <th>ลำดับ</th>
                                                                        <th>รหัสนักศึกษา</th>
                                                                        <th>ชื่อนักศึกษา</th>
                                                                        <th>สาขา</th>
                                                                        <th>คณะ</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                                        <button type="button" class="btn btn-primary">สมัครเข้าร่วม</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.content -->
    <!-- /.content-wrapper -->
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