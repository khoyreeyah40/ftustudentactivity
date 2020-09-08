<?php
session_start();
if (!isset($_SESSION['orgzerName']) && ($_SESSION['orgzerID'])) {
  header('location: ../../');
  echo "กรุณาเข้าสู่ระบบ!";
} else {
}
include '../../db/dbcon.php';
$halaqahcheckAddby = $_SESSION['orgzerID'];
?>
<?php
$checklisthalaqah_id = $_GET['checklisthalaqah_id'];
$checklist_id = $_GET['checklist_id'];
$checklistdate_id = $_GET['checklistdate_id'];
require_once 'dbconfig.php';
if (isset($_POST['btaddstd'])) {
  $checklistdateID = $_POST['checklistdateID'];
  $checklistID = $_POST['checklistID'];
  $checklisthalaqahID = $_POST['checklisthalaqahID'];
  $sql = " SELECT * FROM halaqahstd WHERE halaqahID ='$checklisthalaqahID' ORDER BY halaqahstdNo DESC";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_array($result);
  $halaqahstdID = $row["halaqahstdNo"];
  if ($halaqahstdID != "" && $checklist_id != "") {
    include '../../db/dbcon.php';
    $cesql = "SELECT * FROM halaqahcheck WHERE halaqahchecklistID='$checklist_id' && halaqahcheckstdID='$halaqahstdID'";
    $checkexist = mysqli_query($conn, $cesql);
    if (mysqli_num_rows($checkexist)) {


      $errMSG = "คุณได้ดึงรายชื่อนักศึกษาครบแล้ว";
    }
  }
  // if no error occured, continue ....
  if (!isset($errMSG)) {
    $stmt = $DB_con->prepare('INSERT INTO halaqahcheck(halaqahchecklistID,halaqahcheckstdID, halaqahcheckStatus) VALUES
                                                        (:halaqahchecklistID, :halaqahcheckstdID, "")');
    $stmt->bindParam(':halaqahchecklistID', $checklist_id);
    $stmt->bindParam(':halaqahcheckstdID', $halaqahstdID);
    if ($stmt->execute()) {
      $successMSG = "ทำการเพิ่มสำเร็จ";
      header("refresh:2;halaqahcheck.php?checklistdate_id=$checklistdateID && checklist_id=$checklistID && checklisthalaqah_id=$checklisthalaqahID");
    } else {
      $errMSG = "พบข้อผิดพลาด";
    }
  }
}
require_once '../../db/dbconfig.php';
if (isset($_GET['replyyes_id'])&&($_GET['checklisthalaqah_id'])&&($_GET['checklistdate_id'])&&($_GET['checklist_id'])) {
  $checklistdateID = $_GET['checklistdate_id'];
  $checklistID = $_GET['checklist_id'];
  $checklisthalaqahID = $_GET['checklisthalaqah_id'];
  $stmt_replyyes = $DBcon->prepare('UPDATE halaqahcheck
                                 SET halaqahcheckStatus="เข้าร่วม"
                                  WHERE halaqahcheckNo=:halaqahcheckno');
  $stmt_replyyes->bindParam(':halaqahcheckno', $_GET['replyyes_id']);
  $stmt_replyyes->execute();

  header("refresh:2;halaqahcheck.php?checklistdate_id=$checklistdateID && checklist_id=$checklistID && checklisthalaqah_id=$checklisthalaqahID");
}
?>
<?php
require_once '../../db/dbconfig.php';
if (isset($_GET['replyno_id'])&&($_GET['checklisthalaqah_id'])&&($_GET['checklistdate_id'])&&($_GET['checklist_id'])) {
  $checklistdateID = $_GET['checklistdate_id'];
  $checklistID = $_GET['checklist_id'];
  $checklisthalaqahID = $_GET['checklisthalaqah_id'];
  $stmt_replyno = $DBcon->prepare('UPDATE halaqahcheck
                                 SET halaqahcheckStatus="ไม่เข้าร่วม"
                                  WHERE halaqahcheckNo=:halaqahcheckno');
  $stmt_replyno->bindParam(':halaqahcheckno', $_GET['replyno_id']);
  $stmt_replyno->execute();

  header("refresh:2;halaqahcheck.php?checklistdate_id=$checklistdateID && checklist_id=$checklistID && checklisthalaqah_id=$checklisthalaqahID");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width initial-scale=1.0">
  <title>ระบบกิจกรรมนักศึกษา| จัดการกลุ่มศึกษาอัลกุรอ่าน:รายชื่อนักศึกษา</title>
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
      <h1 class="page-title">จัดการกลุ่มศึกษาอัลกุรอ่าน: รายชื่อนักศึกษา</h1>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
        </li>
        <li class="breadcrumb-item"><a href="halaqah.php">จัดการกลุ่มศึกษาอัลกุรอ่าน</a></li>
        <li class="breadcrumb-item">รายชื่อนักศึกษา</li>
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
      <div class="col-sm-7 ">
        <div class="ibox">
          <div class="ibox-body">
            <form method="post">
              <div class="form-group row" style="margin-bottom: 0rem;">
                <label class="col-sm-3 col-form-label">รอบวันที่: </label>
                <div class="col-sm-5">
                  <input class="form-control" type="text" name="checklistdateID" value="<?php echo $checklistdate_id; ?>" readonly />
                </div>
                <input class="form-control" type="hidden" name="checklistID" value="<?php echo $checklist_id; ?>" readonly />
                <input class="form-control" type="hidden" name="checklisthalaqahID" value="<?php echo $checklisthalaqah_id; ?>" readonly />
                <div class="col-sm-2 text-center">
                  <button class="btn btn-info" type="submit" name="btaddstd">ดึงรายชื่อนักศึกษา</button>
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
            <h5 style="color:white">ตารางรายชื่อนักศึกษา</h5>
          </div>
          <!-- /.card-header -->
          <div class="card-body text-nowrap">
            <table id="tbhalaqahstd" class="table table-hover-sm table-striped text-center" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th>รหัสนักศึกษา</th>
                  <th>ชื่อนักศึกษา</th>
                  <th>สถานะ</th>
                </tr>
              </thead>
              <tbody>
                <?php
                require_once '../../db/dbconfig.php';
                $stmt = $DBcon->prepare("SELECT halaqahcheck.*, halaqahstd.*, student.*,  halaqahchecklist.* FROM halaqahcheck
                                        JOIN halaqahstd ON halaqahstd.halaqahstdNo = halaqahcheck.halaqahcheckstdID
                                        JOIN student ON halaqahstd.halaqahstdID = student.stdID
                                        JOIN halaqahchecklist ON halaqahchecklist.halaqahchecklistNo = halaqahcheck.halaqahchecklistID
                                        WHERE halaqahcheck.halaqahchecklistID = '$checklist_id'
                                        ORDER BY halaqahstd.createat  DESC");
                $stmt->execute();
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                ?>
                  <tr>
                    <td><?php echo $row['halaqahstdID']; ?></td>
                    <td><?php echo $row['stdName']; ?></td>
                    <td><?php echo $row['halaqahcheckStatus']; ?></td>
                    <td>
                        <a class="btn btn-sm btn-primary" href="?replyyes_id=<?php echo $row['halaqahcheckNo']; ?>&& checklisthalaqah_id=<?php echo $row['halaqahID']; ?> && checklist_id=<?php echo $row['halaqahchecklistNo']; ?> && checklistdate_id=<?php echo $row['halaqahchecklistdate']; ?>"><span class="fa fa-check"></span> เข้าร่วม</a>
                        <a class="btn btn-sm btn-danger" href="?replyno_id=<?php echo $row['halaqahcheckNo']; ?>&& checklisthalaqah_id=<?php echo $row['halaqahID']; ?> && checklist_id=<?php echo $row['halaqahchecklistNo']; ?> && checklistdate_id=<?php echo $row['halaqahchecklistdate']; ?>"><span class="fa fa-times"></span> ไม่เข้าร่วม</a>
                    </td>
                    
                  </tr>
                <?php
                }
                ?>
              </tbody>
            </table>
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
      $('#tbhalaqahstd').DataTable({
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

        var actno = $(this).data('id'); // it will get id of clicked row

        $('#dynamic-content').html(''); // leave it blank before ajax call
        $('#modal-loader').show(); // load ajax loader

        $.ajax({
            url: 'moreinfo.php',
            type: 'POST',
            data: 'id=' + actno,
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