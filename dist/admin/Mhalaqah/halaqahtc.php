<?php
session_start();
if (!isset($_SESSION['orgzerName']) && ($_SESSION['orgzerID'])) {
  header('location: ../../welcome/home.php');
  echo "กรุณาเข้าสู่ระบบ!";
} else {
}
include '../../db/dbcon.php';
$halaqahtcAddby = $_SESSION['orgzerID'];
?>
<?php
error_reporting(~E_NOTICE); // avoid notice
require_once 'dbconfig.php';

if (isset($_POST['btaddhalaqahtc'])) {
  $halaqahtcYear = $_POST['halaqahtcYear'];
  $halaqahtcID = $_POST['halaqahtcID'];
  $halaqahtcMainorg = $_POST['halaqahtcMainorg'];


  if (empty($halaqahtcYear)) {
    $errMSG = "กรุณากรอกรายละเอียดให้ครบถ้วน";
  }
  //check username
  if ($halaqahtcYear != "" && $halaqahtcID != "" && $halaqahtcMainorg != "") {
    include '../../db/dbcon.php';

    $cesql = "SELECT * FROM halaqahtc WHERE halaqahtcYear='$halaqahtcYear' && halaqahtcID='$halaqahtcID' && halaqahtcMainorg='$halaqahtcMainorg'";
    $checkexist = mysqli_query($conn, $cesql);
    if (mysqli_num_rows($checkexist)) {


      $errMSG = "รายชื่อนี้ได้ถูกเพิ่มในปีการศึกษานี้แล้ว";
    }
  }

  // if no error occured, continue ....
  if (!isset($errMSG)) {
    $stmt = $DB_con->prepare('INSERT INTO halaqahtc(halaqahtcYear,halaqahtcID, halaqahtcMainorg, halaqahtcAddby) VALUES
                                                        (:halaqahtcYear, :halaqahtcID, :halaqahtcMainorg,:halaqahtcAddby)');
    $stmt->bindParam(':halaqahtcYear', $halaqahtcYear);
    $stmt->bindParam(':halaqahtcID', $halaqahtcID);
    $stmt->bindParam(':halaqahtcMainorg', $halaqahtcMainorg);
    $stmt->bindParam(':halaqahtcAddby', $halaqahtcAddby);
    if ($stmt->execute()) {
      $successMSG = "ทำการเพิ่มสำเร็จ";
      header("refresh:2;halaqahtc.php");
    } else {
      $errMSG = "พบข้อผิดพลาด";
    }
  }
}
?>
<?php
require_once '../../db/dbconfig.php';
if (isset($_GET['halaqahtc_id'])) {

  $stmt_halaqahtc = $DBcon->prepare('UPDATE halaqahtc 
                                 SET halaqahtcStatus="สำเร็จกิจกรรมแล้ว"
                                  WHERE halaqahtcNo=:halaqahtcno');
  $stmt_halaqahtc->bindParam(':halaqahtcno', $_GET['halaqahtc_id']);
  $stmt_halaqahtc->execute();

  header("Location: halaqahtc.php");
}
?>
<?php
require_once '../../db/dbconfig.php';
if (isset($_GET['delete_id'])) {
  $id=$_GET['delete_id'];
  // it will delete an actual record from db
  $sql = "DELETE FROM halaqahtc WHERE halaqahtcNo ='$id'";
	if (mysqli_query($conn, $sql)) {
    $successMSG = "ทำการลบสำเร็จ";
    header("Location: halaqahtc.php");
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
  <title>ระบบกิจกรรมนักศึกษา| ที่ปรึกษากลุ่มศึกษาอัลกุรอ่าน</title>
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
      <h1 class="page-title">จัดการที่ปรึกษากลุ่มศึกษาอัลกุรอ่าน</h1>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
        </li>
        <li class="breadcrumb-item"><a href="../Morganizer/organizer.php">จัดการเจ้าหน้าที่</a> </li>
        <li class="breadcrumb-item">จัดการที่ปรึกษากลุ่มศึกษาอัลกุรอ่าน</li>
      </ol>
    </div>
    <br>
    <?php
    $sql = "SELECT orgzerSec FROM organizer WHERE orgzerID = '$halaqahtcAddby'";
    $result = mysqli_query($conn, $sql);
    mysqli_num_rows($result);
    // output data of each row
    $row = mysqli_fetch_assoc($result);
    ?>
    <?php
    if ($row["orgzerSec"] == "Admin") {
    ?>
     <a href="../Morganizer/organizer.php"><button class="btn btn-info"  type="button"> <span class="fa fa-pencil"></span> &nbsp; จัดการเจ้าหน้าที่</button></a>&nbsp;&nbsp;
    <a href="../Morganizer/usertype.php"><button class="btn btn-info"  type="button"> <span class="fa fa-pencil"></span> &nbsp; จัดการประเภทผู้ใช้</button></a>&nbsp;&nbsp;
    <a href="../Morganizer/organization.php"><button class="btn btn-info" type="button"> <span class="fa fa-pencil"></span> &nbsp; เพิ่มรายชื่อองค์กร</button></a>&nbsp;&nbsp;
    <a href="../Morganizer/mainorg.php"><button class="btn btn-info" type="button"> <span class="fa fa-pencil"></span> &nbsp; เพิ่มรายชื่อสังกัด</button></a>
    
    <?php
    }
    if (($row["orgzerSec"] == "คณะ") || ($row["orgzerSec"] == "มหาวิทยาลัย")) {
    ?>
    <a href="../Morganizer/organizer.php"><button class="btn btn-info"  type="button"> <span class="fa fa-pencil"></span> &nbsp; จัดการเจ้าหน้าที่</button></a>&nbsp;&nbsp;
    <a href="../Morganizer/organization.php"><button class="btn btn-info" type="button"> <span class="fa fa-pencil"></span> &nbsp; เพิ่มรายชื่อองค์กร</button></a>&nbsp;&nbsp;
    <?php
    }
    ?>
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
    <div class="row justify-content-center">
      <div class="col-sm-12 ">
        <div class="ibox">
          <div class="ibox-body">
            <form method="post">
              <div class="form-group row" style="margin-bottom: 0rem;">
                <div class="col-sm-2">
                  <select class="form-control select2_demo_1" style="width: 100%;" name="halaqahtcYear">
                    <?php $sql = "SELECT * FROM actyear WHERE actyearStatus = 'ดำเนินกิจกรรม'";
                      $result = $conn->query($sql);
                    ?>
                      <?php
                      if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                          $actyear = $row["actyear"];
                      ?>
                          <option value="<?php echo $actyear ?>"> <?php echo $actyear ?></option>
                        <?php
                        }
                      } else {
                        echo "something";
                      }
                      ?>
                  </select>
                </div>
                <div class="col-sm-5">
                  <select class="form-control select2_demo_1" style="width: 100%;" name="halaqahtcID" required>
                    <option selected="selected" disabled="disabled">--ที่ปรึกษากลุ่มศึกษาอัลกุรอ่าน--</option>
                    <?php
                    $sql = "SELECT orgzerSec,orgzerMainorg FROM organizer WHERE orgzerID = '$halaqahtcAddby'";
                    $result = mysqli_query($conn, $sql);
                    mysqli_num_rows($result);
                    // output data of each row
                    $row = mysqli_fetch_assoc($result);
                    ?>
                    <?php
                    if ($row["orgzerSec"] == "Admin") {
                      $sql = "SELECT usertype.*, organizer.* FROM organizer 
                    JOIN usertype ON usertype.usertypeID = organizer.orgzeruserType
                    WHERE usertype.userType= 'ที่ปรึกษากลุ่มศึกษาอัลกุรอ่าน'
                    ORDER BY organizer.orgzerID  DESC";
                      $result = $conn->query($sql);
                    ?>
                      <?php
                      if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                          $orgzerID = $row["orgzerID"];
                          $orgzerName = $row["orgzerName"];
                      ?>
                          <option value="<?php echo $orgzerID ?>"> <?php echo $orgzerID ?>: <?php echo $orgzerName ?></option>
                      <?php
                        }
                      } else {
                        echo "something";
                      }
                    }
                    if ($row["orgzerSec"] == "คณะ" ) {
                      $mainorg = $row["orgzerMainorg"];
                      $sql = "SELECT usertype.*, organizer.* FROM organizer 
                    JOIN usertype ON usertype.usertypeID = organizer.orgzeruserType
                    WHERE usertype.userType= 'ที่ปรึกษากลุ่มศึกษาอัลกุรอ่าน' && organizer.orgzerMainorg = '$mainorg' 
                    ORDER BY organizer.orgzerID  DESC";
                      $result = $conn->query($sql);
                      ?>
                      <?php
                      if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                          $orgzerID = $row["orgzerID"];
                          $orgzerName = $row["orgzerName"];
                      ?>
                          <option value="<?php echo $orgzerID ?>"> <?php echo $orgzerID ?>: <?php echo $orgzerName ?></option>
                    <?php
                        }
                      } else {
                        echo "something";
                      }
                    }
                    if ($row["orgzerSec"] == "มหาวิทยาลัย") {
                      $sec = $row["orgzerSec"];
                      $sql = "SELECT usertype.*, organizer.* FROM organizer 
                    JOIN usertype ON usertype.usertypeID = organizer.orgzeruserType
                    WHERE usertype.userType= 'ที่ปรึกษากลุ่มศึกษาอัลกุรอ่าน' && organizer.orgzerSec = '$sec' 
                    ORDER BY organizer.orgzerID  DESC";
                      $result = $conn->query($sql);
                      ?>
                      <?php
                      if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                          $orgzerID = $row["orgzerID"];
                          $orgzerName = $row["orgzerName"];
                      ?>
                          <option value="<?php echo $orgzerID ?>"> <?php echo $orgzerID ?>: <?php echo $orgzerName ?></option>
                    <?php
                        }
                      } else {
                        echo "something";
                      }
                    }
                    ?>
                  </select>
                </div>
                <div class="col-sm-4">
                  <select class="form-control select2_demo_1" style="width: 100%;" name="halaqahtcMainorg">

                    <?php
                    $sql = "SELECT orgzerSec FROM organizer WHERE orgzerID = '$halaqahtcAddby'";
                    $result = mysqli_query($conn, $sql);
                    mysqli_num_rows($result);
                    // output data of each row
                    $row = mysqli_fetch_assoc($result);
                    ?>
                    <?php
                    if ($row["orgzerSec"] == "Admin") {
                      $sql = "SELECT mainorgNo, mainorg FROM mainorg";
                      $result = $conn->query($sql);
                    ?>
                      <option selected="selected" disabled="disabled">--สังกัด--</option>
                      <?php
                      if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                          $mainorgNo = $row["mainorgNo"];
                          $mainorglist = $row["mainorg"];
                      ?>
                          <option value="<?php echo $mainorgNo ?>"> <?php echo $mainorglist ?></option>
                        <?php
                        }
                      } else {
                        echo "something";
                      }
                    }
                    if ($row["orgzerSec"] == "คณะ") {
                      $sql = "SELECT organizer.*, mainorg.* FROM organizer
                                              JOIN mainorg ON organizer.orgzerMainorg = mainorg.mainorgNo
                                              WHERE organizer.orgzerID = '$halaqahtcAddby'
                                              ";
                      $result = $conn->query($sql);

                      if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                          $mainorgNo = $row["mainorgNo"];
                          $mainorglist = $row["mainorg"];
                        ?>
                          <option value="<?php echo $mainorgNo ?>"> <?php echo $mainorglist ?></option>
                    <?php
                        }
                      } else {
                        echo "something";
                      }
                    }
                    if ($row["orgzerSec"] == "มหาวิทยาลัย") {
                      $sec = $row["orgzerSec"];
                      $sql = "SELECT * FROM mainorg WHERE mainorgSec = '$sec'";
                      $result = $conn->query($sql);
                  ?>
                  <option selected="selected" disabled="disabled">--สังกัด--</option>
                      <?php
                      if ($result->num_rows > 0) {
                          while ($row = $result->fetch_assoc()) {
                              $mainorgNo = $row["mainorgNo"];
                              $mainorglist = $row["mainorg"];
                      ?>
                              <option value="<?php echo $mainorgNo ?>"> <?php echo $mainorglist ?></option>
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
                  <button class="btn btn-info" type="submit" name="btaddhalaqahtc">เพิ่ม</button>
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
            <h5 style="color:#2c2c2c">ตารางรายชื่อที่ปรึกษากลุ่มศึกษาอัลกุรอ่าน</h5>
          </div>
          <!-- /.card-header -->
          <div class="card-body text-nowrap">
            <table id="tbhalaqahtc" class="table table-hover-sm table-striped text-center" cellspacing="0" width="100%">
              <thead>
                <tr style="color:#528124;">
                  <th>รหัสกลุ่ม</th>
                  <th>ปีการศึกษา</th>
                  <th>ชื่อที่ปรึกษา</th>
                  <th>องค์กร/คณะ</th>
                  <th>รายชื่อนักศึกษา</th>
                  <th>สถานะ</th>
                  <th>แก้ไข/ลบ</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $sql = "SELECT orgzerSec,orgzerMainorg FROM organizer WHERE orgzerID = '$halaqahtcAddby'";
                $result = mysqli_query($conn, $sql);
                mysqli_num_rows($result);
                // output data of each row
                $row = mysqli_fetch_assoc($result);
                ?>
                <?php
                if ($row["orgzerSec"] == "Admin") {
                  require_once '../../db/dbconfig.php';
                  $stmt = $DBcon->prepare("SELECT halaqahtc.*, organizer.*, mainorg.*, actyear.* FROM halaqahtc 
                                          JOIN organizer ON organizer.orgzerID = halaqahtc.halaqahtcID
                                          JOIN mainorg ON mainorg.mainorgNo = halaqahtc.halaqahtcMainorg
                                          JOIN actyear ON actyear.actyear = halaqahtc.halaqahtcYear 
                                          ORDER BY halaqahtc.createat  DESC");
                                          $stmt->execute();
                  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                ?>
                    <tr>
                      <td><?php echo $row['halaqahtcNo']; ?></td>
                      <td><?php echo $row['halaqahtcYear']; ?></td>
                      <td><?php echo $row['orgzerID']; ?>: <?php echo $row['orgzerName']; ?></td>
                      <td><?php echo $row['mainorg']; ?></td>
                      <td>
                      <a href="halaqahaddstd.php?halaqah_id=<?php echo $row['halaqahtcNo']; ?>"><button class="btn btn-info btn-sm m-r-5" data-toggle="tooltip" ><i class="fa fa-child font-30"></i>รายชื่อนักศึกษา</button></a>
                      </td>
                      <td><?php echo $row['actyearStatus']; ?></td>
                      <td>
                      <a href="updatehalaqahtc.php?update_id=<?php echo $row['halaqahtcNo']; ?>" title="แก้ไขข้อมูล" onclick="return confirm('ต้องการแก้ไขข้อมูล ?')"><button class="btn btn-warning btn-sm m-r-5" data-toggle="tooltip" ><i class="fa fa-pencil font-30"></i></button></a>
                      <a href="?delete_id=<?php echo $row['halaqahtcNo']; ?>" title="ลบ" onclick="return confirm('ต้องการลบ ?')"><button class="btn btn-danger btn-sm" data-toggle="tooltip"><i class="fa fa-trash font-30"></i></button></a>
                      </td>
                    </tr>
                  <?php
                  }
                }
                if ($row["orgzerSec"] == "คณะ") {
                  $main = $row["orgzerMainorg"];
                  require_once '../../db/dbconfig.php';
                  $stmt = $DBcon->prepare("SELECT halaqahtc.*, organizer.*, mainorg.*, actyear.* FROM halaqahtc 
                                          JOIN organizer ON organizer.orgzerID = halaqahtc.halaqahtcID
                                          JOIN mainorg ON mainorg.mainorgNo = halaqahtc.halaqahtcMainorg
                                          JOIN actyear ON actyear.actyear = halaqahtc.halaqahtcYear 
                                          WHERE halaqahtc.halaqahtcMainorg = '$main'
                                          ORDER BY halaqahtc.createat  DESC");
                                          $stmt->execute();
                  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                ?>
                    <tr>
                      <td><?php echo $row['halaqahtcNo']; ?></td>
                      <td><?php echo $row['halaqahtcYear']; ?></td>
                      <td><?php echo $row['orgzerID']; ?>: <?php echo $row['orgzerName']; ?></td>
                      <td><?php echo $row['mainorg']; ?></td>
                      <td>
                      <a href="halaqahaddstd.php?halaqah_id=<?php echo $row['halaqahtcNo']; ?>"><button class="btn btn-info btn-sm m-r-5" data-toggle="tooltip" ><i class="fa fa-child font-30"></i>รายชื่อนักศึกษา</button></a>
                      </td>
                      <td><?php echo $row['actyearStatus']; ?></td>
                      <td>
                      <a href="updatehalaqahtc.php?update_id=<?php echo $row['halaqahtcNo']; ?>" title="แก้ไขข้อมูล" onclick="return confirm('ต้องการแก้ไขข้อมูล ?')"><button class="btn btn-warning btn-sm m-r-5" data-toggle="tooltip" ><i class="fa fa-pencil font-30"></i></button></a>
                      <a href="?delete_id=<?php echo $row['halaqahtcNo']; ?>" title="ลบ" onclick="return confirm('ต้องการลบ ?')"><button class="btn btn-danger btn-sm" data-toggle="tooltip"><i class="fa fa-trash font-30"></i></button></a>
                      </td>
                    </tr>
                  <?php
                  }
                }if ($row["orgzerSec"] == "มหาวิทยาลัย") {
                  $sec = $row["orgzerSec"];
                  require_once '../../db/dbconfig.php';
                  $stmt = $DBcon->prepare("SELECT halaqahtc.*, organizer.*, mainorg.*, actyear.* FROM halaqahtc 
                                          JOIN organizer ON organizer.orgzerID = halaqahtc.halaqahtcID
                                          JOIN mainorg ON mainorg.mainorgNo = halaqahtc.halaqahtcMainorg
                                          JOIN actyear ON actyear.actyear = halaqahtc.halaqahtcYear 
                                          WHERE organizer.orgzerSec = '$sec'
                                          ORDER BY halaqahtc.createat  DESC");
                                          $stmt->execute();
                  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                ?>
                    <tr>
                      <td><?php echo $row['halaqahtcNo']; ?></td>
                      <td><?php echo $row['halaqahtcYear']; ?></td>
                      <td><?php echo $row['orgzerID']; ?>: <?php echo $row['orgzerName']; ?></td>
                      <td><?php echo $row['mainorg']; ?></td>
                      <td>
                      <a href="halaqahaddstd.php?halaqah_id=<?php echo $row['halaqahtcNo']; ?>"><button class="btn btn-info btn-sm m-r-5" data-toggle="tooltip" ><i class="fa fa-child font-30"></i>รายชื่อนักศึกษา</button></a>
                      </td>
                      <td><?php echo $row['actyearStatus']; ?></td>
                      <td>
                        <a href="updatehalaqahtc.php?update_id=<?php echo $row['halaqahtcNo']; ?>" title="แก้ไขข้อมูล" onclick="return confirm('ต้องการแก้ไขข้อมูล ?')"><button class="btn btn-warning btn-sm m-r-5" data-toggle="tooltip" ><i class="fa fa-pencil font-30"></i></button></a>
                        <a href="?delete_id=<?php echo $row['halaqahtcNo']; ?>" title="ลบ" onclick="return confirm('ต้องการลบ ?')"><button class="btn btn-danger btn-sm" data-toggle="tooltip"><i class="fa fa-trash font-30"></i></button></a>
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
      $('#tbhalaqahtc').DataTable({
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