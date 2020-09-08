<?php
session_start();
if (!isset($_SESSION['orgzerName']) && ($_SESSION['orgzerID'])) {
  header('location: ../../');
  echo "กรุณาเข้าสู่ระบบ!";
} else {
}
include '../../db/dbcon.php';
$teacherAddby = $_SESSION['orgzerID'];
?>
<?php
error_reporting(~E_NOTICE); // avoid notice
require_once 'dbconfig.php';

if (isset($_POST['btaddteacher'])) {
  $teacher = $_POST['teacher']; // user name
  $teacherfct = $_POST['teacherfct'];
  $teacherAddby = $_POST['teacherAddby'];


  if (empty($teacher)) {
    $errMSG = "กรุณากรอกรายละเอียดให้ครบถ้วน";
  }
  //check username
  if ($teacher != "" && $teacherfct != "") {
    include '../../db/dbcon.php';

    $cesql = "SELECT teacher FROM teacher WHERE teacher='$teacher' && teacherfct='$teacherfct'";
    $checkexist = mysqli_query($conn, $cesql);
    if (mysqli_num_rows($checkexist)) {


      $errMSG = "รายชื่อนี้ได้ถูกเพิ่มแล้ว";
    }
  }

  // if no error occured, continue ....
  if (!isset($errMSG)) {
    $stmt = $DB_con->prepare('INSERT INTO teacher(teacher,teacherfct,teacherAddby) VALUES
                                                        (:teacher,:teacherfct,:teacherAddby)');

    $stmt->bindParam(':teacher', $teacher);
    $stmt->bindParam(':teacherfct', $teacherfct);
    $stmt->bindParam(':teacherAddby', $teacherAddby);
    if ($stmt->execute()) {
      $successMSG = "ทำการเพิ่มสำเร็จ";
      header("refresh:2;teacher.php");
    } else {
      $errMSG = "พบข้อผิดพลาด";
    }
  }
}
?>
<?php
require_once '../../db/dbconfig.php';
if (isset($_GET['delete_id'])) {
  $id=$_GET['delete_id'];
  // it will delete an actual record from db
  $sql = "DELETE FROM teacher WHERE teacherNo ='$id'";
	if (mysqli_query($conn, $sql)) {
    $successMSG = "ทำการลบสำเร็จ";
    header("Location: teacher.php");
	} else {
		$errMSG = "ไม่สามารถทำการลบได้เนื่องข้อมูลถูกนำไปใช้แล้ว";
	}
	
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width initial-scale=1.0">
  <title>ระบบกิจกรรมนักศึกษา| จัดการรายชื่ออาจารย์</title>
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
      <h1 class="page-title">จัดการรายชื่ออาจารย์</h1>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
        </li>
        <li class="breadcrumb-item"><a href="studentall.php">จัดการรายชื่อนักศึกษา</a></li>
        <li class="breadcrumb-item">จัดการรายชื่ออาจารย์</li>
      </ol>
    </div>
    <br>
    <?php
    $sql = "SELECT orgzerSec FROM organizer WHERE orgzerID = '$teacherAddby'";
    $result = mysqli_query($conn, $sql);
    mysqli_num_rows($result);
    // output data of each row
    $row = mysqli_fetch_assoc($result);
    ?>
    <?php
    if ($row["orgzerSec"] == "Admin") {
    ?>
      <a href="studentallsearch.php"><button class="btn btn-info"  type="button"> <span class="fa fa-pencil"></span> &nbsp; จัดการนักศึกษา</button></a>&nbsp;&nbsp;
      <a href="department.php"><button class="btn btn-info"  type="button"> <span class="fa fa-pencil"></span> &nbsp; จัดการสาขา</button></a>&nbsp;&nbsp;
      <a href="faculty.php"><button class="btn btn-info"  type="button"> <span class="fa fa-pencil"></span> &nbsp; จัดการคณะ</button></a>
      <br>
    <?php
    }
    if ($row["orgzerSec"] == "คณะ") {
    ?>
      <a href="studentallsearch.php"><button class="btn btn-info"  type="button"> <span class="fa fa-pencil"></span> &nbsp; จัดการนักศึกษา</button></a>&nbsp;&nbsp;
      <a href="department.php"><button class="btn btn-info"  type="button"> <span class="fa fa-pencil"></span> &nbsp; จัดการสาขา</button></a>&nbsp;&nbsp;
      <br>
    <?php
    }
    ?>
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
    <div class="ibox" style="box-shadow: 0 5px 4px rgba(0,0,0,.1);">
      <div class="ibox-head" style="background-color:#d1cbaf;">
        <div class="ibox-title" style="color:#484848;">
          <h5>เพิ่มรายชื่ออาจารย์</h5>
        </div>
        <div class="ibox-tools">
          <a class="ibox-collapse" style="color:#484848;"><i class="fa fa-minus"></i></a>
        </div>
      </div>
      <div class="ibox-body">
        <form class="form-horizontal" id="form-sample-1" method="post" novalidate="novalidate">
          <div class="form-group row">

            <label class="col-sm-1 col-form-label">ชื่ออาจารย์</label>
            <div class="col-sm-5">
              <input class="form-control" type="text" name="teacher" value="<?php echo $teacher; ?>" required />
            </div>
            <label class="col-sm-1 col-form-label">คณะ</label>
            <div class="col-sm-5">
              <select class="form-control select2_demo_1" style="width: 100%;" name="teacherfct" required>
                <?php
                $sql = "SELECT orgzerSec FROM organizer WHERE orgzerID = '$teacherAddby'";
                $result = mysqli_query($conn, $sql);
                mysqli_num_rows($result);
                // output data of each row
                $row = mysqli_fetch_assoc($result);
                ?>
                <?php
                if ($row["orgzerSec"] == "Admin") {
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
                }
                if ($row["orgzerSec"] == "คณะ") {
                  $main = $row["orgzerMainorg"];
                  $sql = "SELECT mainorg.*, organizer.*, faculty.* FROM organizer
                  JOIN mainorg ON organizer.orgzerMainorg = mainorg.mainorgNo
                  JOIN faculty ON mainorg.mainorgNo = faculty.faculty
                  WHERE organizer.orgzerID='$teacherAddby' ";
                  $result = $conn->query($sql);
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
                }
                ?>
              </select>
            </div>
          </div>
          <input class="form-control" type="hidden" name="teacherAddby" value="<?php echo $teacherAddby; ?>" readonly />
          <div class="form-group row">
            <div class="col-sm-12 text-center">
              <button class="btn btn-info" type="submit" name="btaddteacher">เพิ่ม</button>
              <a href="teacher.php"><button class="btn btn-danger" type="button" data-dismiss="ibox">ยกเลิก</button></a>
            </div>
          </div>
        </form>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
      <div class="card"style="border-width:0px;border-bottom-width:4px;border-right-width:4px;">
          <div class="card-header"style="background-color:#d1cbaf">
            <h5 style="color:#2c2c2c">ตารางรายชื่ออาจารย์</h5>
          </div>
          <!-- /.card-header -->
          <div class="card-body text-nowrap">
            <table id="tbteacher" class="table table-hover-sm table-striped text-center" cellspacing="0" width="100%">
              <thead>
              <tr style="color:#528124;">
                  <th>ชื่ออาจารย์</th>
                  <th>คณะ</th>
                  <th>เพิ่มโดย</th>
                  <th>แก้ไข/ลบ</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $sql = "SELECT orgzerSec,orgzerMainorg FROM organizer WHERE orgzerID = '$teacherAddby'";
                $result = mysqli_query($conn, $sql);
                mysqli_num_rows($result);
                // output data of each row
                $row = mysqli_fetch_assoc($result);
                ?>
                <?php
                if ($row["orgzerSec"] == "Admin") {
                  require_once '../../db/dbconfig.php';
                  $stmt = $DBcon->prepare("SELECT mainorg.*, teacher.*, faculty.* FROM teacher
                  JOIN faculty ON faculty.faculty = teacher.teacherfct
                  JOIN mainorg ON mainorg.mainorgNo = faculty.faculty
                  ORDER BY teacherNo DESC");
                  $stmt->execute();
                  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                ?>
                    <tr>
                      <td><?php echo $row['teacher']; ?></td>
                      <td><?php echo $row['mainorg']; ?></td>
                      <td><?php echo $row['teacherAddby']; ?></td>
                      <td>
                        <a href="updateteacher.php?update_id=<?php echo $row['teacherNo']; ?>" title="แก้ไขรายชื่ออาจารย์" onclick="return confirm('ต้องการแก้ไขรายชื่ออาจารย์ ?')"><button class="btn btn-warning btn-sm m-r-5" data-toggle="tooltip" ><i class="fa fa-pencil font-30"></i></button></a>
                        <a href="?delete_id=<?php echo $row['teacherNo']; ?>" title="ลบ" onclick="return confirm('ต้องการลบ ?')"><button class="btn btn-danger btn-sm" data-toggle="tooltip"><i class="fa fa-trash font-30"></i></button></a>
                      </td>
                    </tr>
                  <?php
                  }
                }
                if ($row["orgzerSec"] == "คณะ") {
                  require_once '../../db/dbconfig.php';
                  $stmt = $DBcon->prepare("SELECT mainorg.*, teacher.*, faculty.*, organizer.* FROM teacher
                  JOIN faculty ON faculty.faculty = teacher.teacherfct
                  JOIN mainorg ON mainorg.mainorgNo = faculty.faculty
                  JOIN organizer ON organizer.orgzerMainorg = mainorg.mainorgNo
                  WHERE organizer.orgzerID='$teacherAddby'
                  ORDER BY teacherNo DESC");
                  $stmt->execute();
                  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                  ?>
                    <tr>
                      <td><?php echo $row['teacher']; ?></td>
                      <td><?php echo $row['mainorg']; ?></td>
                      <td><?php echo $row['teacherAddby']; ?></td>
                      <td>
                        <a href="updateteacher.php?update_id=<?php echo $row['teacherNo']; ?>" title="แก้ไขรายชื่ออาจารย์" onclick="return confirm('ต้องการแก้ไขรายชื่ออาจารย์ ?')"><button class="btn btn-warning btn-sm m-r-5" data-toggle="tooltip" ><i class="fa fa-pencil font-30"></i></button></a>
                        <a href="?delete_id=<?php echo $row['teacherNo']; ?>" title="ลบ" onclick="return confirm('ต้องการลบ ?')"><button class="btn btn-danger btn-sm" data-toggle="tooltip"><i class="fa fa-trash font-30"></i></button></a>
                      </td>
                    </tr>
                <?php
                  }
                }
                ?>
              </tbody>
            </table>
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
      $('#tbteacher').DataTable({
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
</body>

</html>