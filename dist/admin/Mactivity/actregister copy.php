<?php
session_start();
if (!isset($_SESSION['orgzerName']) && ($_SESSION['orgzerID'])) {
  header('location: ../../welcome/home.php');
  echo "กรุณาเข้าสู่ระบบ!";
} else {
}
include '../../db/dbcon.php';
$actregAddby = $_SESSION['orgzerID'];
?>
<?php

error_reporting(~E_NOTICE);
$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = '';
$DB_NAME = 'dbmyproject';

try {
    $DB_con = new PDO("mysql:host={$DB_HOST};dbname={$DB_NAME}", $DB_USER, $DB_PASS);
    $DB_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $e->getMessage();
}
if (isset($_GET['act_id']) && !empty($_GET['act_id'])) {
    $id = $_GET['act_id'];
    $stmt_actreg = $DB_con->prepare('SELECT activity.*,student.*,actregister.*
    FROM actregister
    JOIN activity ON activity.actID = actregister.actregactID
    JOIN student ON student.stdID = actregister.actregstdID
    WHERE activity.actID=:actID');
    $stmt_actreg->execute(array(':actID' => $id));
    $actreg_row = $stmt_actreg->fetch(PDO::FETCH_ASSOC);
    extract($actreg_row);
} else {
    header("Location: actregister.php");
}
if (isset($_POST['btactreg'])) {
    $actregNo = $_POST['actregNo'];
    $actregactID = $_POST['actregactID'];
    $actregactName = $_POST['actregactName'];
    $actregstdID = $_POST['actregstdID'];
    $actregAddby = $_POST['actregAddby'];


    if (empty($actregstdID)) {
        $errMSG = "กรุณากรอกรายละเอียดให้ครบถ้วน";
    }
    //check username
    if ($actregstdID = "") {
        include '../../db/dbcon.php';

        $cesql = "SELECT * FROM actregister WHERE actregstdID='$actregstdID' && actregactID='$actregactID'";
        $checkexist = mysqli_query($conn, $cesql);
        if (mysqli_num_rows($checkexist)) {


            $errMSG = "กรุณาลงทะเบียนกิจกรรมก่อน";
        }
    }

    // if no error occured, continue ....
    if (!isset($errMSG)) {
        $stmt = $DB_con->prepare('UPDATE actregister
                                    SET 
                                    actregStatus="เข้าร่วม",
                                    actregAddby=:actregAddby
                                    WHERE actregNo=:actregNo');
        $stmt->bindParam(':actregNo', $actregNo);
        $stmt->bindParam(':actregactID', $actregactID);
        $stmt->bindParam(':actregactName', $actregactName);
        $stmt->bindParam(':actregstdID', $actregstdID);
        $stmt->bindParam(':actregAddby', $actregAddby);
        if ($stmt->execute()) {
            $successMSG = "ทำการยืนยันการเข้าร่วมสำเร็จ";
            header("refresh:2;actregister.php");
        } else {
            $errMSG = "พบข้อผิดพลาด";
        }
    }
}
?>
<?php
require_once '../../db/dbconfig.php';
if (isset($_GET['delete_id'])) {
  $stmt_select = $DBcon->prepare('SELECT stdImage FROM student WHERE stdID =:stdID');
  $stmt_select->execute(array(':stdID' => $_GET['delete_id']));
  $stdImageRow = $stmt_select->fetch(PDO::FETCH_ASSOC);

  unlink("../../assets/img/profile/" . $stdImageRow['stdImage']);

  // it will delete an actual record from db
  $stmt_delete = $DBcon->prepare('DELETE FROM student WHERE stdID =:stdID');
  $stmt_delete->bindParam(':stdID', $_GET['delete_id']);
  $stmt_delete->execute();

  header("Location: actregister.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width initial-scale=1.0">
  <title>ระบบกิจกรรมนักศึกษา| เช็คชื่อ</title>
  <!-- GLOBAL MAINLY STYLES-->
  <link href="../../assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="../../assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
  <link href="../../assets/vendors/themify-icons/css/themify-icons.css" rel="stylesheet" />
  <!-- PLUGINS STYLES-->
  <link href="../../assets/vendors/select2/dist/css/select2.min.css" rel="stylesheet" />
  <link href="../../assets/vendors/DataTables/datatables.min.css" rel="stylesheet" />
  <link href="../../assets/vendors/jvectormap/jquery-jvectormap-2.0.3.css" rel="stylesheet" />
  <!-- THEME STYLES-->
  <link href="../../assets/css/main.min.css" rel="stylesheet" />
  <!-- PAGE LEVEL STYLES-->
  <style>
    .breadcrumb-item {
      font-size: 16px;
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

<body class="fixed-navbar" >

  <!-- Main content -->

  <div class="page-content fade-in-up" style="padding:20px;padding-top:0px">
    <div class="page-heading">
      <h1 class="page-title">เช็คชื่อ</h1>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
        </li>
        <li class="breadcrumb-item"><a href="act.php">จัดการกิจกรรมของฉัน</a> </li>
        <li class="breadcrumb-item">เช็คชื่อ</li>
      </ol>
    </div>
    <br>
    <?php
    if (isset($errMSG)) {
    ?>
      <div class="alert alert-danger alert-bordered">
        <span class="fa fa-info-sign"></span> <strong><?php echo $errMSG; ?></strong>
      </div>
    <?php
    } else if (isset($successMSG)) {
    ?>
      <div class="alert alert-success alert-bordered">
        <strong><span class="fa fa-info-sign"></span> <?php echo $successMSG; ?> </strong>
      </div>
    <?php
    }
    ?>
    <div class="row justify-content-center">
      <div class="col-sm-10 ">
        <div class="ibox">
          <div class="ibox-body">
            <form > 
              <div class="form-group row">
                <label class="col-sm-1 col-form-label">รหัสกิจกรรม</label>
                <div class="col-sm-11">
                    <input class="form-control" type="text" name="actregactID" value="<?php echo $actID; ?>" readonly />
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-1 col-form-label">ชื่อกิจกรรม</label>
                <div class="col-sm-11">
                    <input class="form-control" type="text" name="actregactName value="<?php echo $actName; ?>" readonly />
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-1 col-form-label">รหัสนักศึกษา</label>
                <div class="col-sm-11">
                    <input class="form-control" type="text" name="actregStdID" value="<?php echo $actregStdID; ?>" require />
                </div>
              </div>
              <br>
              <div class="form-group ">
              <div class="col-sm-12 text-center">
              <button class="btn btn-info" type="submit" name="btactreg">เข้าร่วม</button>
              </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <br>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header" style="background-color:#2a9d8f">
            <h5 style="color:white">ตารางรายชื่อผู้ลงทะเบียน</h5>
          </div>
          <!-- /.card-header -->
          <div class="card-body text-nowrap">
            <table id="tbactregis" class="table table-hover-sm table-striped text-center" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th>รหัสนักศึกาา</th>
                  <th>ชื่อ-สกุล</th>
                  <th>สาขา</th>
                  <th>กลุ่ม</th>
                  <th>ยืนยันเข้าร่วม</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $sql = "SELECT orgzerSec,orgzerMainorg FROM organizer WHERE orgzerID = '$actregAddby'";
                $result = mysqli_query($conn, $sql);
                mysqli_num_rows($result);
                // output data of each row
                $row = mysqli_fetch_assoc($result);
                ?>
                <?php
                if ($row["orgzerSec"] == "Admin") {
                  require_once '../../db/dbconfig.php';
                  $stmt = $DBcon->prepare("SELECT student.*, department.* FROM student 
                                            JOIN department ON student.stdDpm = department.dpmNo
                                            ORDER BY stdID DESC");
                  $stmt->execute();
                  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                ?>
                    <tr>
                      <td><?php echo $row['stdID']; ?></td>
                      <td><?php echo $row['stdName']; ?></td>
                      <td><?php echo $row['department']; ?></td>
                      <td><?php echo $row['stdGroup']; ?></td>
                      <td><?php echo $row['stdStatus']; ?></td>
                      <td>
                        <?php 
                          if ($row['stdactSta'] == 'ดำเนินกิจกรรม') {
                          ?>
                          <a class="btn btn-sm btn-danger" href="?actfinished_id=<?php echo $row['actNo']; ?>" title="ปิดการลงทะเบียนกิจกรรมนี้" onclick="return confirm('ต้องการปิดการลงทะเบียนกิจกรรมนี้ ?')"><span class="fa fa-edit"></span> ปิดการลงทะเบียน</a>
                        <?php
                          } else if ($row['actStatus'] == 'ปิดการลงทะเบียน') {
                        ?>
                          <a class="btn btn-sm btn-success" href="?actagain_id=<?php echo $row['actNo']; ?>" title="ดำเนินกิจกรรมนี้อีกครั้ง" onclick="return confirm('ต้องการดำเนินกิจกรรมนี้ ?')"><span class="fa fa-edit"></span> ดำเนินกิจกรรม</a>
                        <?php
                          }
                        ?>
                      </td>
                    </tr>
                  <?php
                  }
                }
                if ($row["orgzerSec"] == "คณะ") {
                  $org = $row['orgzerMainorg'];
                  require_once '../../db/dbconfig.php';
                  $stmt = $DBcon->prepare("SELECT student.*, department.* FROM student 
                                            JOIN department ON student.stdDpm = department.dpmNo
                                            WHERE student.stdFct = '$org'
                                            ORDER BY stdID DESC");
                  $stmt->execute();
                  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                ?>
                    <tr>
                      <td><?php echo $row['stdYear']; ?></td>
                      <td><?php echo $row['stdID']; ?></td>
                      <td><?php echo $row['stdName']; ?></td>
                      <td><?php echo $row['department']; ?></td>
                      <td><?php echo $row['stdGroup']; ?></td>
                      <td><?php echo $row['stdStatus']; ?></td>
                      <td>
                        <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modalmoreinfo" data-id="<?php echo $row['stdID']; ?>" id="moreinfo"><i class="fa fa-eye-open"></i> ตรวจสอบการเข้าร่วม</button>
                      </td>
                    </tr>
                  <?php
                  }
                }
                ?>
              </tbody>
            </table>
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
          </div>
          <!-- /.card-body -->
        </div>
      </div>
    </div>
  </div>

  <!-- BEGIN PAGA BACKDROPS-->
  <!-- END PAGA BACKDROPS-->
  <!-- CORE PLUGINS-->
  <script src="../../assets/vendors/jquery/dist/jquery.min.js" type="text/javascript"></script>
  <script src="../../assets/vendors/popper.js/dist/umd/popper.min.js" type="text/javascript"></script>
  <script src="../../assets/vendors/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>
  <script src="../../assets/vendors/metisMenu/dist/metisMenu.min.js" type="text/javascript"></script>
  <script src="../../assets/vendors/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
  <!-- PAGE LEVEL PLUGINS-->
  <script src=".../../assets/vendors/select2/dist/js/select2.full.min.js" type="text/javascript"></script>
  <script src="../../assets/vendors/jquery.maskedinput/dist/jquery.maskedinput.min.js" type="text/javascript"></script>
  <script src="../../assets/vendors/jquery-validation/dist/jquery.validate.min.js" type="text/javascript"></script>
  <script src="../../assets/vendors/DataTables/datatables.min.js" type="text/javascript"></script>
  <!-- CORE SCRIPTS-->
  <script src="../../assets/js/app.min.js" type="text/javascript"></script>
  <!-- PAGE LEVEL SCRIPTS-->
  <script src="../../assets/js/scripts/form-plugins.js" type="text/javascript"></script>
  <script type="text/javascript">
    $(function() {
      $('#tbactcheck').DataTable({
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
    })
    $('#ex-phone').mask('(999) 999-9999');
    $("#form-sample-1").validate({
      rules: {
        name: {
          minlength: 2,
          required: !0
        },
        email: {
          required: !0,
          email: !0
        },
        url: {
          required: !0,
          url: !0
        },
        number: {
          required: !0,
          number: !0
        },
        min: {
          required: !0,
          minlength: 3
        },
        max: {
          required: !0,
          maxlength: 4
        },
        password: {
          required: !0
        },
        password_confirmation: {
          required: !0,
          equalTo: "#password"
        }
      },
      errorClass: "help-block error",
      highlight: function(e) {
        $(e).closest(".form-group.row").addClass("has-error")
      },
      unhighlight: function(e) {
        $(e).closest(".form-group.row").removeClass("has-error")
      },
    });
  </script>
  <script>
    /* View Function*/
    $(document).ready(function() {

      $(document).on('click', '#moreinfo', function(e) {

        e.preventDefault();

        var stdid = $(this).data('id'); // it will get id of clicked row

        $('#dynamic-content').html(''); // leave it blank before ajax call
        $('#modal-loader').show(); // load ajax loader

        $.ajax({
            url: 'studentallmoreinfo.php',
            type: 'POST',
            data: 'id=' + stdid,
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