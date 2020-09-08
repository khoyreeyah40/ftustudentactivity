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
error_reporting(~E_NOTICE); // avoid notice
require_once '../file/dbconfig.php';

if (isset($_POST['btaddactreq'])) {
  $actID = $_POST['actID'];
  $actYear = $_POST['actYear'];
  $actSem = $_POST['actSem'];
  $actName = $_POST['actName']; // user name
  $actSec = $_POST['actSec'];
  $actMainorg = $_POST['actMainorg'];
  $actOrgtion = $_POST['actOrgtion'];
  $actType = $_POST['actType'];
  $actGroup = $_POST['actGroup'];
  $actReason = $_POST['actReason'];
  $actPurpose = $_POST['actPurpose'];
  $actStyle = $_POST['actStyle'];
  $actTimeb = $_POST['actTimeb'];
  $actTimee = $_POST['actTimee'];
  $actDateb = $_POST['actDateb'];
  $actDatee = $_POST['actDatee'];
  $actLocate = $_POST['actLocate'];
  $actPay = $_POST['actPay'];
  $actNote = $_POST['actNote'];
  $actAssesslink = $_POST['actAssesslink'];
  $actAddby = $_POST['actAddby'];
  $imgFile = $_FILES['actFile']['name'];
  $tmp_dir = $_FILES['actFile']['tmp_name'];
  $imgSize = $_FILES['actFile']['size'];

  if (empty($actName)) {
    $errMSG = "กรุณากรอกรายละเอียดให้ครบถ้วน";
  } else if (empty($imgFile)) {
    $errMSG = "กรุณาแนบไฟล์กิจกรรม";
  } else {
    $upload_dir = '../file/'; // upload directory
    $imgExt = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION)); // get image extension
    // valid image extensions
    $valid_extensions = array('pdf', 'docx', 'xlsx', 'pptx'); // valid extensions
    // rename uploading image
    $actFile = "act" . "/" . rand(1000, 1000000) . "." . $imgExt;

    // allow valid image file formats
    if (in_array($imgExt, $valid_extensions)) {
      // Check file size '5MB'
      move_uploaded_file($tmp_dir, $upload_dir . $actFile);
    } else {
      $errMSG = "อนุญาตไฟล์ประเภท PDF, DOCX, XLSX & PPTX เท่านั้น";
    }
  }

  // if no error occured, continue ....
  if (!isset($errMSG)) {
    $stmt = $DB_con->prepare('INSERT INTO activity(actID, actYear,actSem,actStatus,actName,actSec,actMainorg,actOrgtion,actType,actGroup,actReason,actPurpose,actStyle,actTimeb,actTimee,actDateb,actDatee,actLocate,actPay,actAddby,actAssesslink,actNote, actFile) VALUES
                                                        (:actID, :actYear, :actSem,"รอการอนุมัติ",:actName,:actSec,:actMainorg,:actOrgtion,:actType,:actGroup,:actReason,:actPurpose,:actStyle,:actTimeb,:actTimee,:actDateb,:actDatee,:actLocate,:actPay,:actAddby,:actAssesslink,:actNote, :actFile)');

    $stmt->bindParam(':actID', $actID);
    $stmt->bindParam(':actYear', $actYear);
    $stmt->bindParam(':actSem', $actSem);
    $stmt->bindParam(':actName', $actName);
    $stmt->bindParam(':actSec', $actSec);
    $stmt->bindParam(':actMainorg', $actMainorg);
    $stmt->bindParam(':actOrgtion', $actOrgtion);
    $stmt->bindParam(':actType', $actType);
    $stmt->bindParam(':actGroup', $actGroup);
    $stmt->bindParam(':actReason', $actReason);
    $stmt->bindParam(':actPurpose', $actPurpose);
    $stmt->bindParam(':actStyle', $actStyle);
    $stmt->bindParam(':actTimeb', $actTimeb);
    $stmt->bindParam(':actTimee', $actTimee);
    $stmt->bindParam(':actDateb', $actDateb);
    $stmt->bindParam(':actDatee', $actDatee);
    $stmt->bindParam(':actLocate', $actLocate);
    $stmt->bindParam(':actPay', $actPay);
    $stmt->bindParam(':actAssesslink', $actAssesslink);
    $stmt->bindParam(':actNote', $actNote);
    $stmt->bindParam(':actAddby', $actAddby);
    $stmt->bindParam(':actFile', $actFile);
    if ($stmt->execute()) {
      $sql = " SELECT actNo FROM activity ORDER BY actNo DESC limit 1";
      $result = mysqli_query($conn, $sql);
      $row = mysqli_fetch_array($result);
      $no = $row["actNo"];
      $actID = str_pad($no, 5, "0", STR_PAD_LEFT);
      $actIDlist = "ORG" . $actID;

      $sql = "UPDATE activity SET actID='$actIDlist' WHERE actNo='$no' ";
      if ($conn->query($sql) === TRUE) {
        $successMSG = "ทำการเพิ่มสำเร็จ";
        header("refresh:2;actreq.php");
      } else {
        $errMSG = "พบข้อผิดพลาด";
      }
    }
  }
}
?>


<?php
require_once '../../db/dbconfig.php';
if (isset($_GET['delete_id'])) {
  $stmt_select = $DBcon->prepare('SELECT actFile FROM activity WHERE actNo =:actNo');
  $stmt_select->execute(array(':actNo' => $_GET['delete_id']));
  $actFileRow = $stmt_select->fetch(PDO::FETCH_ASSOC);

  unlink("../../assets/img/profile/" . $actFileRow['actFile']);

  // it will delete an actual record from db
  $stmt_delete = $DBcon->prepare('DELETE FROM activity WHERE actNo =:actNo');
  $stmt_delete->bindParam(':actNo', $_GET['delete_id']);
  $stmt_delete->execute();

  header("Location: actreq.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width initial-scale=1.0">
  <title>ระบบกิจกรรมนักศึกษา| ส่งคำร้องขอกิจกรรม</title>
  <!-- GLOBAL MAINLY STYLES-->
  <link href="../../assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="../../assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
  <link href="../../assets/vendors/themify-icons/css/themify-icons.css" rel="stylesheet" />
  <!-- PLUGINS STYLES-->
  <link href="../../assets/vendors/select2/dist/css/select2.min.css" rel="stylesheet" />
  <link href="../../assets/vendors/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css" rel="stylesheet" />
  <link href="../../assets/vendors/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" />
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
      <h1 class="page-title">ส่งคำร้องขอกิจกรรม</h1>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
        </li>
        <li class="breadcrumb-item">ส่งคำร้องขอกิจกรรม</li>
      </ol>
    </div>
    <br>
    <a href="actreqdone.php"><button class="btn btn-info"  type="button"> <span class="fa fa-pencil"></span> &nbsp; การอนุมัติกิจกรรม</button></a>
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
    <div class="ibox" style="box-shadow: 0 5px 4px rgba(0,0,0,.1);">
      <div class="ibox-head" style="background-color:#d1cbaf;">
        <div class="ibox-title" style="color:#484848;">
          <h5>เพิ่มคำร้องขอกิจกรรม</h5>
        </div>
        <div class="ibox-tools">
          <a class="ibox-collapse" style="color:#484848;"><i class="fa fa-minus"></i></a>
        </div>
      </div>
      <div class="ibox-body">
        <form class="form-horizontal" enctype="multipart/form-data" id="form-sample-1" method="post" novalidate="novalidate">
          <div class="form-group row">
            <label class="col-sm-1 col-form-label">ปีการศึกษา</label>
            <div class="col-sm-5">
              <select class="form-control" style="width: 100%;" name="actYear" required />
                              <?php
                                $sql = "SELECT * FROM actyear WHERE actyearStatus='ดำเนินกิจกรรม'";
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
            <label class="col-sm-1 col-form-label">ภาคเรียน</label>
            <div class="col-sm-5">
              <select class="form-control select2_demo_1" style="width: 100%;" name="actSem" required />
              <?php
                                $sql = "SELECT * FROM actsem WHERE actsemStatus='ดำเนินกิจกรรม'";
                                $result = $conn->query($sql);
                                ?>
                                <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                      $actsemNo = $row["actsemNo"];  
                                      $actsem = $row["actsem"];
                                ?>
                                        <option value="<?php echo $actsemNo ?>"> ภาคเรียนที่ <?php echo $actsem ?></option>
                                <?php
                                    }
                                } else {
                                    echo "something";
                                }
                                ?>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-1 col-form-label">ชื่อกิจกรรม</label>
            <div class="col-sm-5">
              <input class="form-control" type="text" name="actName" value="<?php echo $actName; ?>" required />
            </div>
            <label class="col-sm-1 col-form-label">กลุ่ม</label>
            <div class="col-sm-5">
              <select class="form-control select2_demo_1" style="width: 100%;" name="actGroup" required />
              <option selected="selected" disabled="disabled">--กลุ่ม--</option>
              <option value="รวม">รวม</option>
              <option value="ชาย">ชาย</option>
              <option value="หญิง">หญิง</option>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-1 col-form-label">ระดับ</label>
            <div class="col-sm-5">
              <select class="form-control select2_demo_1" style="width: 100%;" name="actSec" required />
              <?php
              $sql = "SELECT orgzerSec FROM organizer WHERE orgzerID = '$actAddby'";
              $result = mysqli_query($conn, $sql);
              mysqli_num_rows($result);
              // output data of each row
              $row = mysqli_fetch_assoc($result);
              ?>
              <?php
              if ($row["orgzerSec"] == "Admin") {
              ?>
                <option selected="selected" disabled="disabled">--ระดับ--</option>
                <option value="มหาวิทยาลัย">มหาวิทยาลัย</option>
                <option value="คณะ">คณะ</option>
                <?php
              }
              if (($row["orgzerSec"] == "คณะ") || ($row["orgzerSec"] == "มหาวิทยาลัย")) {
                $sql = "SELECT orgzerSec FROM organizer WHERE orgzerID = '$actAddby'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                  while ($row = $result->fetch_assoc()) {
                    $orgzerSeclist = $row["orgzerSec"];
                ?>
                    <option value="<?php echo $orgzerSeclist ?>"> <?php echo $orgzerSeclist ?></option>
              <?php
                  }
                } else {
                  echo "something";
                }
              }
              ?>
              </select>
            </div>
            <label class="col-sm-1 col-form-label">สังกัด</label>
            <div class="col-sm-5">
              <select class="form-control select2_demo_1" style="width: 100%;" name="actMainorg">
                <?php
                $sql = "SELECT orgzerSec FROM organizer WHERE orgzerID = '$actAddby'";
                $result = mysqli_query($conn, $sql);
                mysqli_num_rows($result);
                // output data of each row
                $row = mysqli_fetch_assoc($result);
                ?>
                <?php
                if ($row["orgzerSec"] == "Admin") {
                  $sql = "SELECT mainorgNo,mainorg FROM mainorg";
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
                if (($row["orgzerSec"] == "คณะ")||($row["orgzerSec"] == "มหาวิทยาลัย")) {
                  $sql =  "SELECT mainorg.*, organizer.* FROM organizer
                           JOIN mainorg ON organizer.orgzerMainorg = mainorg.mainorgNo
                           WHERE organizer.orgzerID='$actAddby' ";
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
                ?>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-1 col-form-label">องค์กร</label>
            <div class="col-sm-5">
              <select class="form-control select2_demo_1" style="width: 100%;" name="actOrgtion" required />
              <?php
              $sql = "SELECT orgzerSec,orgzerOrgtion FROM organizer WHERE orgzerID = '$actAddby'";
              $result = mysqli_query($conn, $sql);
              mysqli_num_rows($result);
              // output data of each row
              $row = mysqli_fetch_assoc($result);
              ?>
              <?php
              if ($row["orgzerSec"] == "Admin") { ?>
                <option selected="selected" disabled="disabled">--องค์กร--</option>
                <?php
                $sql = "SELECT * FROM organization";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                  while ($row = $result->fetch_assoc()) {
                    $orgtionNo = $row["orgtionNo"];
                    $organizationlist = $row["organization"];
                ?>
                    <option value="<?php echo $orgtionNo ?>"> <?php echo $organizationlist ?></option>
                  <?php
                  }
                } else {
                  echo "something";
                }
              }
              if (($row["orgzerSec"] == "มหาวิทยาลัย") || ($row["orgzerSec"] == "คณะ")) {
                $sql = "SELECT organization.*, organizer.* FROM organizer
                                              JOIN organization ON organization.orgtionNo = organizer.orgzerOrgtion
                                              WHERE organizer.orgzerID = '$actAddby'
                                              ";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                  while ($row = $result->fetch_assoc()) {
                    $orgtionNo = $row["orgtionNo"];
                    $orgtionlist = $row["organization"];
                  ?>
                    <option value="<?php echo $orgtionNo ?>"> <?php echo $orgtionlist ?></option>
              <?php
                  }
                } else {
                  echo "something";
                }
              }
              ?>
              </select>
            </div>
            <label class="col-sm-1 col-form-label">หมวดหมู่</label>
            <div class="col-sm-5">
              <select class="form-control select2_demo_1" style="width: 100%;" name="actType" required />
              <option selected="selected" disabled="disabled">--หมวดหมู่--</option>
              <?php
              $sql = "SELECT acttypeNo, acttypeName FROM acttype";
              $result = $conn->query($sql);

              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  $acttypeNo = $row["acttypeNo"];
                  $acttypelist = $row["acttypeName"];
              ?>
                  <option value="<?php echo $acttypeNo ?>"> <?php echo $acttypelist ?></option>
              <?php
                }
              } else {
                echo "something";
              }
              ?>
              </select>
            </div>
            <label class="col-sm-12 col-form-label">หลักการและเหตุผล</label>
            <div class="col-sm-12">
              <textarea class="form-control" rows="2" type="text" name="actReason" value="<?php echo $actReason; ?>" required></textarea>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-12 col-form-label">วัตถุประสงค์โครงการ</label>
            <div class="col-sm-12">
              <textarea class="form-control" rows="2" type="text" name="actPurpose" value="<?php echo $actPurpose; ?>" required></textarea>
            </div>
            <label class="col-sm-12 col-form-label">รูปแบบหรือลักษณะการดำเนินการ</label>
            <div class="col-sm-12">
              <textarea class="form-control" rows="2" type="text" name="actStyle" value="<?php echo $actStyle; ?>" required></textarea>
            </div>
          </div>
          <div class="form-group row" id="date_5">
            <label class="col-sm-1 col-form-label">เวลา</label>
            <div class="col-sm-5 input-group ">
              <input class="input-sm form-control" type="time" name="actTimeb" value="<?php echo $actTimeb; ?>" required />
              <span class="input-group-addon p-l-10 p-r-10">ถึง</span>
              <input class="input-sm form-control" type="time" name="actTimee" value="<?php echo $actTimee; ?>" required />
            </div>
            <label class="col-sm-1 col-form-label">วันที่</label>
            <div class="col-sm-5  input-group">
              <input class="input-sm form-control" type="date" name="actDateb" min="2000-01-01"value="<?php echo $actDateb; ?>" required />
              <span class="input-group-addon p-l-10 p-r-10">ถึง</span>
              <input class="input-sm form-control" type="date" name="actDatee" min="2000-01-01"value="<?php echo $actDatee; ?>" required />
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-1 col-form-label">สถานที่</label>
            <div class="col-sm-5">
              <input class="form-control" type="text" name="actLocate" value="<?php echo $actLocate; ?>" required />
            </div>
            <label class="col-sm-1 col-form-label">ค่าลงทะเบียน</label>
            <div class="col-sm-5">
              <input class="form-control" type="text" name="actPay" value="<?php echo $actPay; ?>" required />
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-1 col-form-label">ไฟล์ใบโครงการ</label>
            <div class="col-sm-5">
            <input class="input-group" type="file" name="actFile" accept="file/*" />
            </div>
            <label class="col-sm-1 col-form-label">ลิ้งค์ใบประเมิน</label>
            <div class="col-sm-5">
              <input class="form-control" type="text" name="actAssesslink" value="<?php echo $actAssesslink; ?>" required />
            </div>
            <div class="col-sm-5">
              <input class="form-control" type="hidden" name="actAddby" value="<?php echo $actAddby; ?>" readonly />
            </div>
            <div class="col-sm-5">
              <input class="form-control" type="hidden" name="actID" value="ID" readonly />
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-12 col-form-label">หมายเหตุ</label>
            <div class="col-sm-12">
              <textarea class="form-control" rows="2" type="text" name="actNote" value="<?php echo $actNote; ?>"></textarea>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-sm-12 text-center">
              <button class="btn btn-info" type="submit" name="btaddactreq">เพิ่ม</button>
              <a href="actreq.php"><button class="btn btn-danger" type="button" data-dismiss="ibox">ยกเลิก</button></a>
            </div>
          </div>
        </form>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
      <div class="card"style="border-width:0px;border-bottom-width:4px;border-right-width:4px;">
          <div class="card-header"style="background-color:#d1cbaf">
            <h5 style="color:#2c2c2c">ตารางการส่งคำร้องขอกิจกรรม</h5>
          </div>
          <!-- /.card-header -->
          <div class="card-body text-nowrap">
            <table id="tbactreq" class="table table-hover-sm table-striped text-center" cellspacing="0" width="100%">
              <thead>
                <tr style="color:#528124;">
                  <th>วันที่ส่งคำร้อง</th>
                  <th>รหัสกิจกรรม</th>
                  <th>ชื่อกิจกรรม</th>
                  <th>สถานะ</th>
                  <th>เพิ่มโดย</th>
                  <th>แก้ไข/ลบ</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $sql = "SELECT orgzerSec,orgzerOrgtion,orgzerMainorg FROM organizer WHERE orgzerID = '$actAddby'";
                $result = mysqli_query($conn, $sql);
                mysqli_num_rows($result);
                // output data of each row
                $row = mysqli_fetch_assoc($result);
                ?>
                <?php
                if ($row["orgzerSec"] == "Admin") {
                  require_once '../../db/dbconfig.php';
                  $stmt = $DBcon->prepare("SELECT * FROM activity WHERE actStatus='รอการอนุมัติ' 
                  ORDER BY actDateb DESC");
                  $stmt->execute();
                  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                ?>
                    <tr>
                      <td><?php echo $row['createat']; ?></td>
                      <td><a href="" data-toggle="modal" data-target="#modalmoreinfo" data-id="<?php echo $row['actID']; ?>" id="moreinfo"><?php echo $row['actID']; ?></a></td>
                      <td><?php echo $row['actName']; ?></td>
                      <td class="text-warning"><?php echo $row['actStatus']; ?></td>
                      <td><?php echo $row['actAddby']; ?></td>
                      <td>
                        <a href="updateinforeq.php?update_id=<?php echo $row['actID']; ?>" title="แก้ไขกิจกรรม" onclick="return confirm('ต้องการแก้ไขกิจกรรม ?')"><button class="btn btn-warning btn-sm m-r-5" data-toggle="tooltip"><i class="fa fa-pencil font-30"></i></button></a>
                        <a href="?delete_id=<?php echo $row['actID']; ?>" title="ลบกิจกรรม" onclick="return confirm('ต้องการลบกิจกรรม ?')"><button class="btn btn-danger btn-sm" data-toggle="tooltip"><i class="fa fa-trash font-30"></i></button></a>
                      </td>
                    </tr>
                  <?php
                  }
                }
                if (($row["orgzerSec"] == "คณะ")||($row["orgzerSec"] == "มหาวิทยาลัย")) {
                  $org = $row["orgzerOrgtion"];
                  $mainorg = $row["orgzerMainorg"];
                  require_once '../../db/dbconfig.php';
                  $stmt = $DBcon->prepare("SELECT * FROM activity  WHERE actStatus='รอการอนุมัติ' && actMainorg='$mainorg' && actOrgtion='$org' 
                  ORDER BY actDateb DESC");
                  $stmt->execute();
                  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                  ?>
                    <tr>
                      <td><?php echo $row['createat']; ?></td>
                      <td><a href="" data-toggle="modal" data-target="#modalmoreinfo" data-id="<?php echo $row['actID']; ?>" id="moreinfo"><?php echo $row['actID']; ?></a></td>
                      <td><?php echo $row['actName']; ?></td>
                      <td class="text-warning"><?php echo $row['actStatus']; ?></td>
                      <td><?php echo $row['actAddby']; ?></td>
                      <td>
                        <a href="updateinforeq.php?update_id=<?php echo $row['actID']; ?>" title="แก้ไขกิจกรรม" onclick="return confirm('ต้องการแก้ไขกิจกรรม ?')"><button class="btn btn-warning btn-sm m-r-5" data-toggle="tooltip"><i class="fa fa-pencil font-30"></i></button></a>
                        <a href="?delete_id=<?php echo $row['actID']; ?>" title="ลบกิจกรรม" onclick="return confirm('ต้องการลบกิจกรรม ?')"><button class="btn btn-danger btn-sm" data-toggle="tooltip"><i class="fa fa-trash font-30"></i></button></a>
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
  <script src="../../assets/vendors/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
  <script src="../../assets/vendors/bootstrap-timepicker/js/bootstrap-timepicker.min.js" type="text/javascript"></script>
  <!-- CORE SCRIPTS-->
  <script src="../../assets/js/app.min.js" type="text/javascript"></script>
  <!-- PAGE LEVEL SCRIPTS-->
  <script src="../../assets/js/scripts/form-plugins.js" type="text/javascript"></script>
  <script type="text/javascript">
    $(function() {
      $('#tbactreq').DataTable({
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