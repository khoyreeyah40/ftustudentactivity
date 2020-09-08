<?php
session_start();
if (!isset($_SESSION['orgzerName']) && ($_SESSION['orgzerID'])) {
    header('location: ../../');
    echo "กรุณาเข้าสู่ระบบ!";
} else {
}
include '../../db/dbcon.php';
$updateby = $_SESSION['orgzerID'];
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
if (isset($_GET['update_id']) && !empty($_GET['update_id'])) {
    $id = $_GET['update_id'];
    $stmt_update = $DB_con->prepare('SELECT activity.*, mainorg.*,actsem.*, organization.*, acttype.* FROM activity
        JOIN mainorg ON activity.actMainorg = mainorg.mainorgNo
        JOIN organization ON activity.actOrgtion = organization.orgtionNo
        JOIN acttype ON activity.actType = acttype.acttypeNo
        JOIN actsem ON activity.actSem = actsem.actsemNo
        WHERE activity.actID=:actID');
    $stmt_update->execute(array(':actID' => $id));
    $update_row = $stmt_update->fetch(PDO::FETCH_ASSOC);
    extract($update_row);
} else {
    header("Location: actall.php");
}
if (isset($_POST['btupdateactall'])) {
    $actID = $_POST['actID'];
    $actYear = $_POST['actYear'];
    $actName = $_POST['actName']; // user name
    $actSem = $_POST['actSem'];
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
    $actFile = $_POST['actFile'];
    $imgFile = $_FILES['actFile']['name'];
    $tmp_dir = $_FILES['actFile']['tmp_name'];
    $imgSize = $_FILES['actFile']['size'];

    if (empty($actName)) {
        $errMSG = "กรุณากรอกรายละเอียดให้ครบถ้วน";
    } 
    else if($imgFile){
        $upload_dir = '../file/'; // upload directory
        $imgExt = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION)); // get image extension
        // valid image extensions
        $valid_extensions = array('pdf', 'docx', 'xlsx', 'pptx'); // valid extensions
        // rename uploading image
        $actFile = "act" . "/" . rand(1000, 1000000) . "." . $imgExt;

        // allow valid image file formats
        if (in_array($imgExt, $valid_extensions)) {
            // Check file size '5MB'
            unlink($upload_dir.$update_row['actFile']);
            move_uploaded_file($tmp_dir, $upload_dir . $actFile);
        } else {
            $errMSG = "อนุญาตไฟล์ประเภท PDF, DOCX, XLSX & PPTX เท่านั้น";
        }
    }else
      {
        // if no image selected the old image remain as it is.
        $actFile = $update_row['actFile']; // old image from database
      }
    if (!isset($errMSG)) {
        $stmt = $DB_con->prepare('UPDATE activity
                                    SET actID=:actID,
                                    actYear=:actYear,
                                    actName=:actName,
                                    actSem=:actSem,
                                    actSec=:actSec,
                                    actMainorg=:actMainorg,
                                    actOrgtion=:actOrgtion,
                                    actType=:actType,
                                    actGroup=:actGroup,
                                    actReason=:actReason,
                                    actPurpose=:actPurpose,
                                    actStyle=:actStyle,
                                    actTimeb=:actTimeb,
                                    actTimee=:actTimee,
                                    actDateb=:actDateb,
                                    actDatee=:actDatee,
                                    actLocate=:actLocate,
                                    actPay=:actPay,
                                    actNote=:actNote,
                                    actAssesslink=:actAssesslink,
                                    actAddby=:actAddby,
                                    actFile=:actFile
                                    WHERE actID=:actID');
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
?>
            <script>
                alert('ทำการแก้ไขเรียบร้อย ...');
                window.location.href = 'actall.php';
            </script>
<?php
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
    <title>ระบบกิจกรรมนักศึกษา| เพิ่มกิจกรรม</title>
    <!-- GLOBAL MAINLY STYLES-->
    <link href="../../assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../../assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
    <link href="../../assets/vendors/themify-icons/css/themify-icons.css" rel="stylesheet" />
    <!-- PLUGINS STYLES-->
    <link href="../../assets/vendors/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css" rel="stylesheet" />
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
    function getmainorg(val) {
      $.ajax({
        type: "POST",
        url: "selectmainorg.php",
        data: 'secName=' + val,
        success: function(data) {
          $("#orgzermainorg").html(data);
        }
      });
    }
  </script>
  <script>
    function getorgtion(val) {
      $.ajax({
        type: "POST",
        url: "selectorgtion.php",
        data: 'mainorgNo=' + val,
        success: function(data) {
          $("#orgzerorgtion").html(data);
        }
      });
    }
  </script>
</head>

<body class="fixed-navbar">
    <div class="page-content fade-in-up" style="padding:20px;padding-top:0px">
        <div class="page-heading">
            <h1 class="page-title">เพิ่มกิจกรรม</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                </li>
                <li class="breadcrumb-item"><a href="actall.php">เพิ่มกิจกรรม</a></li>
                <li class="breadcrumb-item">แก้ไขข้อมูลกิจกรรม</li>
            </ol>
        </div>
        <br>
        <br>
        <?php
        if (isset($errMSG)) {
        ?>
            <div class="alert alert-danger">
                <span class="fa fa-info-sign"></span> &nbsp; <?php echo $errMSG; ?>
            </div>
        <?php
        }
        ?>
        <div class="ibox" style="box-shadow: 0 5px 4px rgba(0,0,0,.1);">
      <div class="ibox-head" style="background-color:#d1cbaf;">
        <div class="ibox-title" style="color:#484848;">
                    <h5>แก้ไขข้อมูลกิจกรรม</h5>
                </div>
            </div>
            <div class="ibox-body">
                <form class="form-horizontal" enctype="multipart/form-data" id="form-sample-1" method="post" novalidate="novalidate">
                    <div class="form-group row">
                        <label class="col-sm-1 col-form-label">ปีการศึกษา</label>
                        <div class="col-sm-5">
                            <select class="form-control" style="width: 100%;" name="actYear" required />
                            <option value="<?php echo $actYear; ?>"><?php echo $actYear; ?></option>
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
                            <option value="<?php echo $actSem; ?>"><?php echo $actsem; ?></option>
                            <option disabled="disabled">--ภาคเรียน--</option>
                            <?php
                                $sql = "SELECT * FROM actsem WHERE actsemStatus='ดำเนินกิจกรรม'";
                                $result = $conn->query($sql);
                                ?>
                                <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $actsem = $row["actsem"];
                                ?>
                                        <option value="<?php echo $actsem ?>"> ภาคเรียนที่ <?php echo $actsem ?></option>
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
                            <option value="<?php echo $actGroup; ?>"><?php echo $actGroup; ?></option>
                            <option disabled="disabled">--กลุ่ม--</option>
                            <option value="รวม">รวม</option>
                            <option value="ชาย">ชาย</option>
                            <option value="หญิง">หญิง</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-1 col-form-label">ระดับ</label>
                        <div class="col-sm-5">
                        <select class="form-control select2_demo_1" style="width: 100%;" name="actSec" id="orgzersec" onChange="getmainorg(this.value);">
                        <option value="<?php echo $actSec; ?>"><?php echo $actSec; ?></option>
                            <option  disabled="disabled">--กรุณาเลือกระดับ--</option>

                            <?php
                            $sql = "SELECT orgzerSec FROM organizer WHERE orgzerID = '$updateby'";
                            $result = mysqli_query($conn, $sql);
                            mysqli_num_rows($result);
                            // output data of each row
                            $row = mysqli_fetch_assoc($result);
                            ?>
                            <?php
                            if ($row["orgzerSec"] == "Admin") {
                                $sql = "SELECT * FROM section";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $secName = $row["secName"];
                                ?>
                                    <option value="<?php echo $secName?>"> <?php echo $secName?></option>
                            <?php
                                }
                                } else {
                                echo "something";
                                }
                            }
                            if (($row["orgzerSec"] == "คณะ") || ($row["orgzerSec"] == "มหาวิทยาลัย")) {
                                $sec = $row["orgzerSec"];
                                $sql = "SELECT * FROM section WHERE secName = '$sec'";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $secName = $row["secName"];
                                ?>
                                    <option value="<?php echo $secName?>"> <?php echo $secName?></option>
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
                            <select class="form-control select2_demo_1" style="width: 100%;" name="actMainorg" id="orgzermainorg" onChange="getorgtion(this.value);">
                                <option value="<?php echo $actMainorg; ?>"><?php echo $mainorg; ?></option>
                                <option disabled="disabled">--กรุณาเลือกสังกัด--</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-1 col-form-label">องค์กร</label>
                        <div class="col-sm-5">
                            <select class="form-control select2_demo_1" style="width: 100%;" name="actOrgtion" id="orgzerorgtion" required>
                                <option value="<?php echo $actOrgtion; ?>"><?php echo $organization; ?></option>
                                <option  disabled="disabled">--กรุณาเลือกองค์กร--</option>
                            </select>
                        </div>
                        <label class="col-sm-1 col-form-label">หมวดหมู่</label>
                        <div class="col-sm-5">
                            <select class="form-control select2_demo_1" style="width: 100%;" name="actType" required />
                            <option value="<?php echo $actType; ?>"><?php echo $acttypeName; ?></option>
                            <option disabled="disabled">--หมวดหมู่--</option>
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
                            <textarea class="form-control" rows="2" type="text" name="actReason" value="<?php echo $actReason; ?>" required><?php echo $actReason; ?></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-12 col-form-label">วัตถุประสงค์โครงการ</label>
                        <div class="col-sm-12">
                            <textarea class="form-control" rows="2" type="text" name="actPurpose" value="<?php echo $actPurpose; ?>" required><?php echo $actPurpose; ?></textarea>
                        </div>
                        <label class="col-sm-12 col-form-label">รูปแบบหรือลักษณะการดำเนินการ</label>
                        <div class="col-sm-12">
                            <textarea class="form-control" rows="2" type="text" name="actStyle" value="<?php echo $actStyle; ?>" required><?php echo $actStyle; ?></textarea>
                        </div>
                    </div>
                    <div class="form-group row" id="date_5">
                    <label class="col-sm-1 col-form-label">เวลา</label>
                        <div class="col-sm-5 input-group " >
                            <input class="input-sm form-control" type="time" name="actTimeb"  value="<?php echo $actTimeb; ?>" required />
                            <span class="input-group-addon p-l-10 p-r-10">ถึง</span>
                            <input class="input-sm form-control" type="time" name="actTimee" value="<?php echo $actTimee; ?>" required />
                        </div>
                        <label class="col-sm-1 col-form-label">วันที่</label>
                        <div class="col-sm-5 input-group" >
                            <input class="input-sm form-control" type="date" name="actDateb" min="2000-01-01"value="<?php echo $actDateb; ?>" required />
                            <span class="input-group-addon p-l-10 p-r-10">ถึง</span>
                            <input class="input-sm form-control" type="date" name="actDatee" min="2000-01-01" value="<?php echo $actDatee; ?>" required />
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
                        <a href="../file/<?php echo $actFile; ?>" target ="_blank"><?php echo $actFile; ?></a>
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
                            <input class="form-control" type="hidden" name="actID" value="<?php echo $actID; ?>" readonly />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-12 col-form-label">หมายเหตุ</label>
                        <div class="col-sm-12">
                        <textarea class="form-control" rows="2" type="text" name="actNote" value="<?php echo $actNote; ?>"><?php echo $actNote; ?></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12 text-center">
                            <button class="btn btn-warning" type="submit" name="btupdateactall">แก้ไข</button>
                            <a href="actall.php"><button class="btn btn-danger" type="button">ยกเลิก</button></a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

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
    <script src="../../assets/vendors/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
    <script src="../../assets/vendors/DataTables/datatables.min.js" type="text/javascript"></script>
    <!-- CORE SCRIPTS-->
    <script src="../../assets/js/app.min.js" type="text/javascript"></script>
    <!-- PAGE LEVEL SCRIPTS-->
    <script src="../../assets/js/scripts/form-plugins.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(function() {
            $('#tborganizer').DataTable({
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