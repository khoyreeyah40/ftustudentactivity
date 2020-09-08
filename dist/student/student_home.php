<?php
session_start();
if (!isset($_SESSION['stdName']) && ($_SESSION['stdID'])) {
    header('location: ../welcome/home.php');
    echo "กรุณาเข้าสู่ระบบ!";
} else {
}
include '../db/dbcon.php';
$stdID = $_SESSION['stdID'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width initial-scale=1.0">
    <title>ระบบกิจกรรมนักศึกษา| หน้าแรก</title>
    <!-- GLOBAL MAINLY STYLES-->
    <link href="../assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
    <link href="../assets/vendors/themify-icons/css/themify-icons.css" rel="stylesheet" />
    <!-- PLUGINS STYLES-->
    <link href="../assets/vendors/DataTables/datatables.min.css" rel="stylesheet" />
    <link href="../assets/vendors/jvectormap/jquery-jvectormap-2.0.3.css" rel="stylesheet" />
    <!-- THEME STYLES-->
    <link href="../assets/css/main.min.css" rel="stylesheet" />
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
    </style>
    <script>
  function getdpm(val) {
  	$.ajax({
  	type: "POST",
  	url: "stddpm.php",
  	data:'faculty='+val,
  	success: function(data){
  		$("#stddpm").html(data);
  	}
  	});
  }
  </script>
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
                                require_once '../db/dbconfig.php';
                                $stmt = $DBcon->prepare("SELECT * FROM board where boardStatus='แสดง' order by boardNo DESC limit 4   ");

                                $stmt->execute();
                                $num = 0;

                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                                    $num++;

                                ?>
                                    <div class="carousel-item <?php if ($num == "1") {
                                                                    echo "active";
                                                                } else {
                                                                }
                                                                ?>">
                                        <img src="../assets/img/<?php echo $row['board']; ?>" class="d-block w-100" alt="" style="height: 450px;width:100%;">
                                        <div class="carousel-caption">
                                            <h3><?php echo $row['boardName']; ?></h3>
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
                <!-- /.card -->
                <br>
                <div class="row justify-content-center">
                    <div class="col-sm-10 ">
                        <div class="ibox">
                            <div class="ibox-body">
                                <form>
                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                            <select class="form-control select2_demo_1" style="width: 100%;" name="stdfct" id="stdFct" onChange="getdpm(this.value);" required>
                                                <?php
                                                    $sql = "SELECT mainorg.*, faculty.* FROM faculty
                                                    JOIN mainorg ON faculty.faculty = mainorg.mainorgNo ORDER BY faculty DESC";
                                                    $result = $conn->query($sql);
                                                ?>
                                                    <option selected="selected" disabled="disabled">--คณะ--</option>
                                                    <?php
                                                    if ($result->num_rows > 0) {
                                                        while ($row = $result->fetch_assoc()) {
                                                            $faculty = $row["faculty"];
                                                            $mainorglist = $row["mainorg"];
                                                    ?>
                                                            <option value="<?php echo $faculty ?>"> <?php echo $mainorglist ?></option>
                                                    <?php
                                                        }
                                                    } else {
                                                        echo "something";
                                                    }
                                                    ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-6">
                                            <select class="form-control select2_demo_1" style="width: 100%;" name="stdDpm" id="stddpm" required>
                                                <option selected="selected" disabled="disabled">--สาขา--</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                            <select class="form-control select2_demo_1" style="width: 100%;" name="stdYear" required>
                                                <option selected="selected" disabled="disabled">--ปีการศึกษา--</option>
                                                <?php
                                                function DateThai($strDate)
                                                {
                                                    $strYear = date("Y", strtotime($strDate)) + 544;
                                                    return "$strYear";
                                                }
                                                $strDate = date("Y");
                                                for ($i = 2563; $i < DateThai($strDate); $i++) {
                                                    echo "<option>$i</option>";
                                                }

                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-6">
                                            <select class="form-control select2_demo_1" style="width: 100%;" name="stdGroup" required>
                                                <option selected="selected" disabled="disabled">--กลุ่ม--</option>
                                                <option value="ทั้งหมด">ทั้งหมด</option>
                                                <option value="ชาย">ชาย</option>
                                                <option value="หญิง">หญิง</option>
                                            </select>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-group ">
                                        <div class="col-sm-12 text-center">
                                            <button class="btn btn-primary" onChange="search(this.value);">ค้นหา</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="card">
                    <div class="card-header" style="background-color:#2a9d8f">
                        <h2>ตารางกิจกรรมที่กำลังดำเนิน</h2>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body text-nowrap">
                        <table id="tbhome" class="table table-bordered table-striped text-center">
                            <thead>
                                <tr>
                                    <th>ปีการศึกษา</th>
                                    <th>ชื่อกิจกรรม</th>
                                    <th>เวลา</th>
                                    <th>วันที่</th>
                                    <th>หมวดหมู่</th>
                                    <th>องค์กร</th>
                                    <th>รายละเอียดเพิ่มเติม</th>
                                    <th>ลงทะเบียน</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                require_once '../db/dbconfig.php';
                                $stmt = $DBcon->prepare("SELECT activity.*, organization.*, acttype.* FROM activity 
                                JOIN organization ON activity.actOrgtion = organization.orgtionNo
                                JOIN acttype ON activity.actType = acttype.acttypeNo
                                WHERE activity.actStatus='ดำเนินกิจกรรม' ORDER BY actNo DESC");
                                $stmt->execute();
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                    <tr>
                                        <td><?php echo $row['actYear']; ?></td>
                                        <td><?php echo $row['actName']; ?></td>
                                        <td><?php echo $row['actTimeb']; ?>-<?php echo $row['actTimee']; ?></td>
                                        <td><?php echo $row['actDateb']; ?>-<?php echo $row['actDatee']; ?></td>
                                        <td><?php echo $row['acttypeName']; ?></td>
                                        <td><?php echo $row['organization']; ?></td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modalmoreinfo" data-id="<?php echo $row['actNo']; ?>" id="moreinfo"><i class="fa fa-eye-open"></i> รายละเอียดเพิ่มเติม</button>
                                        </td>
                                        <td>
                                            <?php
                                            if ($row['actStatus'] == 'ดำเนินกิจกรรม') {
                                            ?>
                                                <a class="btn btn-sm btn-primary" href="?actreg_id=<?php echo $row['actNo']; ?>" title="ลงทะเบียนกิจกรรมนี้" onclick="return confirm('ต้องการลงทะเบียนกิจกรรมนี้ ?')"><span class="fa fa-edit"></span> ลงทะเบียน</a>
                                            <?php
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <div class="modal fade" id="modalmoreinfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content ">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">รายละเอียดเพิ่มเติม</h5>
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
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                                    </div>
                                </div>
                            </div>
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

            $(document).on('click', '#moreinfo', function(e) {

                e.preventDefault();

                var orgzerid = $(this).data('id'); // it will get id of clicked row

                $('#dynamic-content').html(''); // leave it blank before ajax call
                $('#modal-loader').show(); // load ajax loader

                $.ajax({
                        url: 'moreinfo.php',
                        type: 'POST',
                        data: 'id=' + orgzerid,
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