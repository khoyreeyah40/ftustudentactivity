<?php
session_start();
if (!isset($_SESSION['orgzerName']) && ($_SESSION['orgzerID'])) {
    header('location: ../../');
    echo "กรุณาเข้าสู่ระบบ!";
} else {
}
include '../../db/dbcon.php';
$halaqahAddby = $_SESSION['orgzerID'];
?>
<?php
$halaqah_id = $_GET['halaqah_id'];
require_once 'dbconfig.php';

if (isset($_POST['btaddhalaqahchecklist'])) {
  $halaqahID = $_POST['halaqahID'];
  $halaqahchecklistdate = $_POST['halaqahchecklistdate'];


  if (empty($halaqahchecklistdate)) {
    $errMSG = "กรุณากรอกรายละเอียดให้ครบถ้วน";
  }
  //check username
  if ($halaqahID && $halaqahchecklistdate != "") {
    include '../../db/dbcon.php';

    $cesql = "SELECT * FROM halaqahchecklist WHERE halaqahchecklistdate='$halaqahchecklistdate' && halaqahID='$halaqahID'";
    $checkexist = mysqli_query($conn, $cesql);
    if (mysqli_num_rows($checkexist)) {


      $errMSG = "วันที่นี้ได้ถูกเพิ่มในกลุ่มนี้แล้ว";
    }
  }

  // if no error occured, continue ....
  if (!isset($errMSG)) {
    $stmt = $DB_con->prepare('INSERT INTO halaqahchecklist(halaqahID,halaqahchecklistdate) VALUES
                                                        (:halaqahID, :halaqahchecklistdate)');
    $stmt->bindParam(':halaqahID', $halaqahID);
    $stmt->bindParam(':halaqahchecklistdate', $halaqahchecklistdate);
    if ($stmt->execute()) {
      $successMSG = "ทำการเพิ่มสำเร็จ";
      header("refresh:2;halaqahchecklist.php?halaqah_id=$halaqahID");
    } else {
      $errMSG = "พบข้อผิดพลาด";
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width initial-scale=1.0">
  <title>ระบบกิจกรรมนักศึกษา| จัดการกลุ่มศึกษาอัลกุรอ่าน:เช็คชื่อ</title>
  <!-- GLOBAL MAINLY STYLES-->
  <link href="../../assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="../../assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
  <link href="../../assets/vendors/themify-icons/css/themify-icons.css" rel="stylesheet" />
  <!-- PLUGINS STYLES-->
  <link href="../../assets/vendors/select2/dist/css/select2.min.css" rel="stylesheet" />
  <link href="../../assets/vendors/DataTables/datatables.min.css" rel="stylesheet" />
  <link href="../../assets/vendors/jvectormap/jquery-jvectormap-2.0.3.css" rel="stylesheet" />
  <link href="../../assets/vendors/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css" rel="stylesheet" />
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
      <h1 class="page-title">จัดการกลุ่มศึกษาอัลกุรอ่าน: เช็คชื่อ</h1>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
        </li>
        <li class="breadcrumb-item"><a href="halaqah.php">จัดการกลุ่มศึกษาอัลกุรอ่าน</a></li>
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
      <div class="col-sm-8 ">
        <div class="ibox">
          <div class="ibox-body">
            <form method="post">
              <div class="form-group row" style="margin-bottom: 0rem;">
                <div class="col-sm-2">
                <input class="form-control" type="text" name="halaqahID" value="<?php echo $halaqah_id; ?>" readonly />
                </div>
                <div class="col-sm-7 form-group" style="margin-bottom: 0rem;" id="date_1">
                                    <div class="input-group date">
                                        <span class="input-group-addon bg-white"><i class="fa fa-calendar"></i></span>
                                        <input class="form-control" type="text" name="halaqahchecklistdate" placeholder="ดด/วว/ปป" autocomplete="off" require>
                                    </div>
                                </div>
                <div class="col-sm-1 text-center">
                  <button class="btn btn-info" type="submit" name="btaddhalaqahchecklist">เพิ่มรอบกการเช็คชื่อ</button>
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
            <h5 style="color:white">ตารางรอบการเช็คชื่อ</h5>
          </div>
          <!-- /.card-header -->
          <div class="card-body text-nowrap">
            <table id="tbhalaqahstd" class="table table-hover-sm table-striped text-center" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th>วันที่</th>
                  <th>เช็คชื่อ</th>
                  <th>มา</th>
                  <th>ไม่มา</th>
                </tr>
              </thead>
              <tbody>
                <?php
                require_once '../../db/dbconfig.php';
                $stmt = $DBcon->prepare("SELECT * FROM halaqahchecklist
                                        WHERE halaqahID = '$halaqah_id'
                                        ORDER BY createat  DESC");
                                        $stmt->execute();
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
              ?>
                  <tr>
                    <td><?php echo $row['halaqahchecklistdate']; ?></td>
                    <td>
                    <a href="halaqahcheck.php?checklisthalaqah_id=<?php echo $row['halaqahID']; ?> && checklist_id=<?php echo $row['halaqahchecklistNo']; ?> && checklistdate_id=<?php echo $row['halaqahchecklistdate']; ?>"><button class="btn btn-success btn-sm m-r-5" data-toggle="tooltip" ><i class="fa fa-check font-30"></i>เช็คชื่อ</button></a>
                    </td>
                <?php
                }
                ?>
                <?php
                require_once '../../db/dbconfig.php';
                $sql = "SELECT * FROM halaqahcheck WHERE halaqahcheckNo && halaqahcheckStatus = 'เข้าร่วม'";
              $result = mysqli_query($conn, $sql);
              $row=mysqli_num_rows($result);
              // output data of each row
              ?>
                    <td><?php echo $row?></td>
                    <?php
                require_once '../../db/dbconfig.php';
                $sql = "SELECT * FROM halaqahcheck WHERE halaqahcheckNo && halaqahcheckStatus = 'ไม่เข้าร่วม'";
              $result = mysqli_query($conn, $sql);
              $row=mysqli_num_rows($result);
              // output data of each row
              ?>
                    <td><?php echo $row?></td>
                  </tr>
                
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
  <script src="../../assets/vendors/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
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