<?php
session_start();
if (!isset($_SESSION['orgzerName']) && ($_SESSION['orgzerID'])) {
  header('location: ../../');
  echo "กรุณาเข้าสู่ระบบ!";
} else {
}
include '../../db/dbcon.php';
$actAddby = $_SESSION['orgzerID'];
?>
<?php
require_once '../../db/dbconfig.php';
if (isset($_GET['actfinished_id'])) {

  $stmt_finished = $DBcon->prepare('UPDATE activity 
                                 SET actStatus="ปิดการลงทะเบียน"
                                  WHERE actNo=:actno');
  $stmt_finished->bindParam(':actno', $_GET['actfinished_id']);
  $stmt_finished->execute();

  header("Location: act.php");
}
?>
<?php
require_once '../../db/dbconfig.php';
if (isset($_GET['actagain_id'])) {

  $stmt_again = $DBcon->prepare('UPDATE activity 
                                 SET actStatus="ดำเนินกิจกรรม"
                                  WHERE actNo=:actno');
  $stmt_again->bindParam(':actno', $_GET['actagain_id']);
  $stmt_again->execute();

  header("Location: act.php");
}
?>
<?php
require_once '../../db/dbconfig.php';
if (isset($_GET['actagain1_id'])) {

  $stmt_again1 = $DBcon->prepare('UPDATE activity 
                                 SET actStatus="เสร็จสิ้นกิจกรรม"
                                  WHERE actNo=:actno');
  $stmt_again1->bindParam(':actno', $_GET['actagain1_id']);
  $stmt_again1->execute();

  header("Location: act.php");
}
?>
<?php
require_once '../../db/dbconfig.php';
if (isset($_GET['delete_id'])) {
  // it will delete an actual record from db
  if (!isset($errMSG)) {  
  $stmt_delete = $DBcon->prepare('DELETE FROM activity WHERE actNo =:actno');
  $stmt_delete->bindParam(':actno', $_GET['delete_id']);
  $stmt_delete->execute();

  header("Location: act.php");
}
    else {
        $errMSG = "ไม่สามารถลบได้";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width initial-scale=1.0">
  <title>ระบบกิจกรรมนักศึกษา| จัดการกิจกรรม</title>
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
</head>

<body class="fixed-navbar">

  <!-- Main content -->

  <div class="page-content fade-in-up" style="padding:20px;padding-top:0px">
    <div class="page-heading">
      <h1 class="page-title">จัดการกิจกรรมของฉัน</h1>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
        </li>
        <li class="breadcrumb-item"><a href="act.php">จัดการกิจกรรมของฉัน</a> </li>
      </ol>
    </div>
    <br>
    <a href="actfinished.php"><button class="btn btn-info"  type="button"> <span class="fa fa-pencil"></span> &nbsp; ตารางกิจกรรมที่เสร็จสิ้น</button></a>
    <br>
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

    <div class="row">
      <div class="col-12">
      <div class="card"style="border-width:0px;border-bottom-width:4px;border-right-width:4px;">
          <div class="card-header"style="background-color:#d1cbaf">
            <h5 style="color:#2c2c2c">กิจกรรมที่กำลังดำเนิน</h5>
          </div>
          <!-- /.card-header -->
          <div class="card-body text-nowrap">
            <table id="tbact" class="table table-hover-sm table-striped text-center" cellspacing="0" width="100%">
              <thead>
                <tr style="color:#528124;">
                  <th>รหัสกิจกรรม</th>
                  <th>ชื่อกิจกรรม</th>
                  <th>เวลา</th>
                  <th>วันที่</th>
                  <th>สถานที่</th>
                  <th>เช็คชื่อ</th>
                  <th>สถานะ</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $sql = "SELECT orgzerSec,orgzerOrgtion FROM organizer WHERE orgzerID = '$actAddby'";
                $result = mysqli_query($conn, $sql);
                mysqli_num_rows($result);
                // output data of each row
                $row = mysqli_fetch_assoc($result);
                ?>
                <?php
                if ($row["orgzerSec"] == "Admin") {
                  require_once '../../db/dbconfig.php';
                  $stmt = $DBcon->prepare("SELECT activity.*, acttype.*  FROM activity
                                            JOIN acttype ON activity.actType = acttype.acttypeNo
                                            WHERE activity.actStatus='ดำเนินกิจกรรม' || activity.actStatus='ปิดการลงทะเบียน' || activity.actStatus='ปลดล๊อก'
                                            ORDER BY activity.actDateb DESC
                                              ");
                  $stmt->execute();
                  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                ?>
                    <tr>
                    <td><a href="" data-toggle="modal" data-target="#modalmoreinfo" data-id="<?php echo $row['actID']; ?>" id="moreinfo"><?php echo $row['actID']; ?></a></td>
                      <td><?php echo $row['actName']; ?></td>
                      <td><?php echo $row['actTimeb']; ?> ถึง <?php echo $row['actTimee']; ?></td>
                      <td><?php echo $row['actDateb']; ?> ถึง <?php echo $row['actDatee']; ?></td>
                      <td><?php echo $row['actLocate']; ?></td>
                      <td>
                        <a class="btn btn-sm btn-warning" href="actregister.php?act_id=<?php echo $row['actID']; ?>"><span class="fa fa-edit"></span> เช็คชื่อ</a>
                      </td>
                      <td>
                        <?php 
                          if ($row['actStatus'] == 'ดำเนินกิจกรรม') {
                          ?>
                          <a class="btn btn-sm btn-danger" href="?actfinished_id=<?php echo $row['actNo']; ?>" title="ปิดการลงทะเบียนกิจกรรมนี้" onclick="return confirm('ต้องการปิดการลงทะเบียนกิจกรรมนี้ ?')"><span class="fa fa-edit"></span> ปิดการลงทะเบียน</a>
                        <?php
                          } else if ($row['actStatus'] == 'ปิดการลงทะเบียน') {
                        ?>
                          <a class="btn btn-sm btn-success" href="?actagain_id=<?php echo $row['actNo']; ?>" title="ดำเนินกิจกรรมนี้อีกครั้ง" onclick="return confirm('ต้องการดำเนินกิจกรรมนี้ ?')"><span class="fa fa-edit"></span> ดำเนินกิจกรรม</a>
                        <?php
                          } else if ($row['actStatus'] == 'ปลดล๊อก') {
                        ?>
                          <a class="btn btn-sm btn-danger" href="?actagain1_id=<?php echo $row['actNo']; ?>" title="ปิกการปลดล๊อก" onclick="return confirm('ต้องการปิดการปลดล๊อก?')"><span class="fa fa-edit"></span> ปิดการปลดล๊อกกิจกรรม</a>
                        <?php
                          }
                        ?>
                      </td>
                    </tr>
                  <?php
                  }
                }
                if (($row["orgzerSec"] == "คณะ") || ($row["orgzerSec"] == "มหาวิทยาลัย")) {
                  $org = $row["orgzerOrgtion"];
                  require_once '../../db/dbconfig.php';
                  $stmt = $DBcon->prepare("SELECT activity.*, acttype.*  FROM activity
                                            JOIN acttype ON activity.actType = acttype.acttypeNo
                                            WHERE (activity.actStatus='ดำเนินกิจกรรม' || activity.actStatus='ปลดล๊อก'||activity.actStatus='ปิดการลงทะเบียน')&& activity.actOrgtion='$org' 
                                            ORDER BY activity.actDateb DESC
                                              ");
                  $stmt->execute();
                  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                  ?>
                    <tr>
                    <td><a href="" data-toggle="modal" data-target="#modalmoreinfo" data-id="<?php echo $row['actID']; ?>" id="moreinfo"><?php echo $row['actID']; ?></a></td>
                      <td><?php echo $row['actName']; ?></td>
                      <td><?php echo $row['actTimeb']; ?> ถึง <?php echo $row['actTimee']; ?></td>
                      <td><?php echo $row['actDateb']; ?> ถึง <?php echo $row['actDatee']; ?></td>
                      <td><?php echo $row['actLocate']; ?></td>
                      <td>
                        <a class="btn btn-sm btn-warning" href="actregister.php?act_id=<?php echo $row['actID']; ?>"><span class="fa fa-edit"></span> เช็คชื่อ</a>
                      </td>
                      <td>
                        <?php 
                          if ($row['actStatus'] == 'ดำเนินกิจกรรม') {
                          ?>
                          <a class="btn btn-sm btn-danger" href="?actfinished_id=<?php echo $row['actNo']; ?>" title="ปิดการลงทะเบียนกิจกรรมนี้" onclick="return confirm('ต้องการปิดการลงทะเบียนกิจกรรมนี้ ?')"><span class="fa fa-edit"></span> ปิดการลงทะเบียน</a>
                        <?php
                          } else if ($row['actStatus'] == 'ปิดการลงทะเบียน') {
                        ?>
                          <a class="btn btn-sm btn-success" href="?actagain_id=<?php echo $row['actNo']; ?>" title="ดำเนินกิจกรรมนี้อีกครั้ง" onclick="return confirm('ต้องการดำเนินกิจกรรมนี้ ?')"><span class="fa fa-edit"></span> ดำเนินกิจกรรม</a>
                        <?php
                          } else if ($row['actStatus'] == 'ปลดล๊อก') {
                        ?>
                          <a class="btn btn-sm btn-danger" href="?actagain1_id=<?php echo $row['actNo']; ?>" title="ปิดการปลดล๊อก" onclick="return confirm('ต้องการปิดการปลดล๊อก?')"><span class="fa fa-edit"></span> ปิดการปลดล๊อกกิจกรรม</a>
                        <?php
                          }
                        ?>
                      </td>
                    </tr>
                <?php
                  }
                }
                ?>
              </tbody>
            </table>
          </div>
          <div class="modal fade" id="modalmoreinfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content ">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle" style="color:#528124;">รายละเอียดเพิ่มเติม</h5>
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
  <script src="../../assets/vendors/select2/dist/js/select2.full.min.js" type="text/javascript"></script>
  <script src="../../assets/vendors/jquery.maskedinput/dist/jquery.maskedinput.min.js" type="text/javascript"></script>
  <script src="../../assets/vendors/jquery-validation/dist/jquery.validate.min.js" type="text/javascript"></script>
  <script src="../../assets/vendors/DataTables/datatables.min.js" type="text/javascript"></script>
  <!-- CORE SCRIPTS-->
  <script src="../../assets/js/app.min.js" type="text/javascript"></script>
  <!-- PAGE LEVEL SCRIPTS-->
  <script src="../../assets/js/scripts/form-plugins.js" type="text/javascript"></script>
  <script type="text/javascript">
    $(function() {
      $('#tbact').DataTable({
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

        var actid = $(this).data('id'); // it will get id of clicked row

        $('#dynamic-content').html(''); // leave it blank before ajax call
        $('#modal-loader').show(); // load ajax loader

        $.ajax({
            url: 'moreactinfo.php',
            type: 'POST',
            data: 'id=' + actid,
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