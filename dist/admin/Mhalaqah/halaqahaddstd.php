<?php
session_start();
if (!isset($_SESSION['orgzerName']) && ($_SESSION['orgzerID'])) {
    header('location: ../../');
    echo "กรุณาเข้าสู่ระบบ!";
} else {
}
include '../../db/dbcon.php';
$halaqahstdAddby = $_SESSION['orgzerID'];
?>
<?php
$halaqah_id = $_GET['halaqah_id'];
require_once 'dbconfig.php';

if (isset($_POST['btaddhalaqahstd'])) {
  $halaqahID = $_POST['halaqahID'];
  $halaqahstdID = $_POST['halaqahstdID'];


  if (empty($halaqahstdID)) {
    $errMSG = "กรุณากรอกรายละเอียดให้ครบถ้วน";
  }
  //check username
  if (($halaqahID != "") && ($halaqahstdID != "")) {
    include '../../db/dbcon.php';

    $cesql = "SELECT * FROM halaqahstd WHERE halaqahstdID='$halaqahstdID' && halaqahID='$halaqahID'";
    $checkexist = mysqli_query($conn, $cesql);
    if (mysqli_num_rows($checkexist)) {


      $errMSG = "รายชื่อนี้ได้ถูกเพิ่มในปีการศึกษานี้แล้ว";
    }
  }

  // if no error occured, continue ....
  if (!isset($errMSG)) {
    $stmt = $DB_con->prepare('INSERT INTO halaqahstd(halaqahID,halaqahstdID, halaqahstdsem1Status, halaqahstdsem2Status) VALUES
                                                        (:halaqahID, :halaqahstdID, "","" )');
    $stmt->bindParam(':halaqahID', $halaqahID);
    $stmt->bindParam(':halaqahstdID', $halaqahstdID);
    if ($stmt->execute()) {
      $successMSG = "ทำการเพิ่มสำเร็จ";
      header("refresh:2;halaqahaddstd.php?halaqah_id=$halaqahID");
    } else {
      $errMSG = "พบข้อผิดพลาด";
    }
  }
}
?>
<?php
require_once '../../db/dbconfig.php';
if (isset($_GET['delete_id'])&&($_GET['halaqah_id'])) {
$halaqah_id = $_GET['halaqah_id'];
  // it will delete an actual record from db
  $stmt_delete = $DBcon->prepare('DELETE FROM halaqahstd WHERE halaqahstdID =:halaqahstdID');
  $stmt_delete->bindParam(':halaqahstdID', $_GET['delete_id']);
  $stmt_delete->execute();

  header("refresh:2;halaqahaddstd.php?halaqah_id=$halaqah_id");
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
        <li class="breadcrumb-item"><a href="halaqahtc.php">จัดการที่ปรึกษากลุ่มศึกษาอัลกุรอ่าน</a></li>
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
      <div class="col-sm-8 ">
        <div class="ibox">
          <div class="ibox-body">
            <form method="post">
              <div class="form-group row" style="margin-bottom: 0rem;">
                <div class="col-sm-2">
                <input class="form-control" type="text" name="halaqahID" value="<?php echo $halaqah_id; ?>" readonly />
                </div>
                <div class="col-sm-8">
                  <select class="form-control select2_demo_1" style="width: 100%;" name="halaqahstdID" required>
                    <option selected="selected" disabled="disabled">--กรุณาป้อนรหัสนักศึกษา--</option>
                    <?php
                    $sql = "SELECT orgzerSec,orgzerMainorg FROM organizer WHERE orgzerID = '$halaqahstdAddby' ";
                    $result = mysqli_query($conn, $sql);
                    mysqli_num_rows($result);
                    // output data of each row
                    $row = mysqli_fetch_assoc($result);
                    ?>
                    <?php
                    if (($row["orgzerSec"] == "Admin") || ($row["orgzerSec"] == "มหาวิทยาลัย" )) {
                      $sql = "SELECT * FROM student
                      WHERE stdStatus= 'กำลังศึกษา'
                      ORDER BY stdID  DESC ";
                      $result = $conn->query($sql);
                    ?>
                      <?php
                      if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                          $stdID = $row["stdID"];
                          $stdName = $row["stdName"];
                      ?>
                          <option value="<?php echo $stdID ?>"> <?php echo $stdID ?>: <?php echo $stdName ?></option>
                      <?php
                        }
                      } else {
                        echo "something";
                      }
                    }
                    if ($row["orgzerSec"] == "คณะ" ) {
                      $mainorg = $row["orgzerMainorg"];
                      $sql = "SELECT * FROM student
                      WHERE stdStatus= 'กำลังศึกษา' && stdFct ='$mainorg'
                      ORDER BY stdID  DESC";
                      $result = $conn->query($sql);
                    ?>
                      <?php
                      if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                          $stdID = $row["stdID"];
                          $stdName = $row["stdName"];
                      ?>
                          <option value="<?php echo $stdID ?>"> <?php echo $stdID ?>: <?php echo $stdName ?></option>
                      <?php
                        }
                      } else {
                        echo "something";
                      }
                    }
                    ?>
                  </select>
                </div>
                <div class="col-sm-1 text-center">
                  <button class="btn btn-info" type="submit" name="btaddhalaqahstd">เพิ่ม</button>
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
      <div class="card"style="border-width:0px;border-bottom-width:4px;border-right-width:4px;">
          <div class="card-header"style="background-color:#d1cbaf">
            <h5 style="color:#2c2c2c">ตารางรายชื่อนักศึกษา</h5>
          </div>
          <!-- /.card-header -->
          <div class="card-body text-nowrap">
            <table id="tbhalaqahstd" class="table table-hover-sm table-striped text-center" cellspacing="0" width="100%">
              <thead>
                <tr style="color:#528124;">
                  <th>รหัสนักศึกษา</th>
                  <th>ชื่อนักศึกษา</th>
                  <th>สาขา</th>
                  <th>ลบ</th>
                </tr>
              </thead>
              <tbody>
                <?php
                require_once '../../db/dbconfig.php';
                $stmt = $DBcon->prepare("SELECT halaqahstd.*,halaqahtc.*, student.*, department.* FROM halaqahstd
                                        JOIN student ON student.stdID = halaqahstd.halaqahstdID
                                        JOIN halaqahtc ON halaqahtc.halaqahtcNo = halaqahstd.halaqahID
                                        JOIN department ON department.dpmNo = student.stdDpm
                                        WHERE halaqahstd.halaqahID = '$halaqah_id'
                                        ORDER BY halaqahstd.createat  DESC");
                                        $stmt->execute();
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
              ?>
                  <tr>
                    <td><a href="" data-toggle="modal" data-target="#modalmoreinfo" data-id="<?php echo $row['stdID']; ?>" id="moreinfo"><?php echo $row['stdID']; ?></a></td>
                    <td><?php echo $row['stdName']; ?></td>
                    <td><?php echo $row['department']; ?></td>
                    <td>
                      <a class="btn btn-sm  btn-danger" href="?delete_id=<?php echo $row['halaqahstdID']; ?>&&halaqah_id=<?php echo $row['halaqahID']; ?>" title="ลบรายชื่อ" onclick="return confirm('ต้องการลบรายชื่อนี้ ?')"> <i class="fa fa-trash"></i> ลบ</a>
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

        var stdid = $(this).data('id'); // it will get id of clicked row

        $('#dynamic-content').html(''); // leave it blank before ajax call
        $('#modal-loader').show(); // load ajax loader

        $.ajax({
            url: 'morestdinfo.php',
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