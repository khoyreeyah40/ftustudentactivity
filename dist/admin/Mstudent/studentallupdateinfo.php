<?php
session_start();
if (!isset($_SESSION['orgzerName']) && ($_SESSION['orgzerID'])) {
    header('location: ../../');
    echo "กรุณาเข้าสู่ระบบ!";
} else {
}
include '../../db/dbcon.php';
$stdAddby = $_SESSION['orgzerID'];
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
    $stmt_update = $DB_con->prepare('SELECT student.*, department.*,faculty.*,mainorg.*, teacher.* FROM student 
    JOIN department ON department.dpmNo = student.stdDpm
    JOIN faculty ON faculty.faculty = student.stdFct
    JOIN mainorg ON mainorg.mainorgNo = faculty.faculty
    JOIN teacher ON teacher.teacherNo = student.stdTC
    WHERE stdID=:stdid');
    $stmt_update->execute(array(':stdid' => $id));
    $update_row = $stmt_update->fetch(PDO::FETCH_ASSOC);
    extract($update_row);
} else {
    header("Location: studentall.php");
}
if (isset($_POST['btupdatestudentall'])) {
    $stdYear = $_POST['stdYear'];
    $stdID = $_POST['stdID'];
    $stdName = $_POST['stdName']; // user name
    $stdFct = $_POST['stdFct'];
    $stdDpm = $_POST['stdDpm'];
    $stdTc = $_POST['stdTc'];
    $stdGroup = $_POST['stdGroup'];
    $stdPhone = $_POST['stdPhone'];
    $stdEmail = $_POST['stdEmail'];
    $stdFb = $_POST['stdFb'];
    $stdPassword = $_POST['stdPassword'];
    // if no error occured, continue ....
    if (!isset($errMSG)) {
        $stmt = $DB_con->prepare('UPDATE student
                                    SET 
                                    stdYear=:stdYear,
                                    stdID=:stdID,
                                    stdName=:stdName,
                                    stdFct=:stdFct,
                                    stdDpm=:stdDpm,
                                    stdTc=:stdTc,
                                    stdGroup=:stdGroup,
                                    stdPhone=:stdPhone,
                                    stdEmail=:stdEmail,
                                    stdFb=:stdFb,
                                    stdPassword=:stdPassword
                                    WHERE stdID=:stdID');
        $stmt->bindParam(':stdYear', $stdYear);
        $stmt->bindParam(':stdID', $stdID);
        $stmt->bindParam(':stdName', $stdName);
        $stmt->bindParam(':stdFct', $stdFct);
        $stmt->bindParam(':stdDpm', $stdDpm);
        $stmt->bindParam(':stdTc', $stdTc);
        $stmt->bindParam(':stdGroup', $stdGroup);
        $stmt->bindParam(':stdPhone', $stdPhone);
        $stmt->bindParam(':stdEmail', $stdEmail);
        $stmt->bindParam(':stdFb', $stdFb);
        $stmt->bindParam(':stdPassword', $stdPassword);
        if ($stmt->execute()) {
?>
            <script>
                alert('ทำการแก้ไขเรียบร้อย ...');
                window.location.href = 'studentall.php';
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
    <title>ระบบกิจกรรมนักศึกษา| จัดการนักศึกษาทั้งหมด</title>
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
        data: 'faculty=' + val,
        success: function(data) {
          $("#orgzerdpm").html(data);
        }
      });
    }
  </script>
  <script>
    function gettc(val) {
      $.ajax({
        type: "POST",
        url: "stdtc.php",
        data: 'faculty=' + val,
        success: function(data) {
          $("#orgzertc").html(data);
        }
      });
    }
  </script>
</head>

<body class="fixed-navbar" >
    <div class="page-content fade-in-up" style="padding:20px;padding-top:0px">
        <div class="page-heading">
            <h1 class="page-title">จัดการรายชื่อนักศึกษา</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                </li>
                <li class="breadcrumb-item"><a href="studentall.php">จัดการรายชื่อนักศึกษา</a></li>
                <li class="breadcrumb-item">แก้ไขข้อมูลนักศึกษา</li>
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
                    <h5>แก้ไขข้อมูลนักศึกษา</h5>
                </div>
            </div>
            <div class="ibox-body">
                <form class="form-horizontal" id="form-sample-1" method="post" enctype="multipart/form-data"novalidate="novalidate" style="height:500px; width:100%">

                    <div class="form-group row">
                        <label class="col-sm-1 col-form-label">ปีที่เข้าศึกษา</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="stdYear" value="<?php echo $stdYear; ?>" require>
                        </div>
                        <label class="col-sm-1 col-form-label">รหัสนักศึกษา</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="stdID" value="<?php echo $stdID; ?>" require>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-1 col-form-label">ชื่อ-สกุล</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control " name="stdName" value="<?php echo $stdName; ?>" require>
                        </div>
                        <label class="col-sm-1 col-form-label">กลุ่ม</label>
                        <div class="col-sm-5">
                            <select class="form-control select2_demo_1" style="width: 100%;" name="stdGroup" required>
                                <option value="<?php echo $stdGroup ?>"> <?php echo $stdGroup ?></option>
                                <option value="ชาย">ชาย</option>
                                <option value="หญิง">หญิง</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-1 col-form-label">คณะ</label>
                        <div class="col-sm-5">
                            <select class="form-control select2_demo_1" style="width: 100%;" name="orgzerFct" id="orgzerfct" onChange="getdpm(this.value);gettc(this.value);">
                                <option value="<?php echo $stdFct ?>"> <?php echo $mainorg; ?></option>
                                <?php
                                $sql = "SELECT orgzerSec, orgzerMainorg FROM organizer WHERE orgzerID = '$stdAddby'";
                                $result = mysqli_query($conn, $sql);
                                mysqli_num_rows($result);
                                // output data of each row
                                $row = mysqli_fetch_assoc($result);
                                ?>
                                <?php
                                if ($row["orgzerSec"] == "Admin") {
                                    $sql = "SELECT mainorg.*, faculty.* FROM faculty
                                    JOIN mainorg ON mainorg.mainorgNo = faculty.faculty
                                    ";
                                    $result = $conn->query($sql);
                                ?>
                                    <option  disabled="disabled">--คณะ--</option>
                                    <?php
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            $faculty = $row["faculty"];
                                            $mainorg = $row["mainorg"];
                                    ?>
                                            <option value="<?php echo $faculty ?>"> <?php echo $mainorg ?></option>
                                        <?php
                                        }
                                    } else {
                                        echo "something";
                                    }
                                }
                                if ($row["orgzerSec"] == "คณะ") {
                                    $main=$row["orgzerMainorg"];
                                    $sql = "SELECT mainorg.*, faculty.* FROM faculty
                                    JOIN mainorg ON mainorg.mainorgNo = faculty.faculty
                                    WHERE mainorg.mainorgNo ='$main'
                                    ";
                                    $result = $conn->query($sql);
                                ?>
                                    <option  disabled="disabled">--คณะ--</option>
                                    <?php
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            $faculty = $row["faculty"];
                                            $mainorg = $row["mainorg"];
                                    ?>
                                            <option value="<?php echo $faculty ?>"> <?php echo $mainorg ?></option>
                                        <?php
                                        }
                                    } else {
                                        echo "something";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <label class="col-sm-1 col-form-label">สาขา</label>
                        <div class="col-sm-5">
                        <select class="form-control select2_demo_1" style="width: 100%;" name="orgzerDpm" id="orgzerdpm">
                            <option selected="selected" disabled="disabled">--กรุณาเลือกสาขา--</option>
                        </select>
                        </div>
                    </div>
                    <div class="form-group row">
                    <label class="col-sm-1 col-form-label">อาจารย์ที่ปรึกษา</label>
                        <div class="col-sm-5">
                        <select class="form-control select2_demo_1" style="width: 100%;" name="orgzerTc" id="orgzertc">
                            <option selected="selected" disabled="disabled">--กรุณาเลือกอาจารย์ที่ปรึกษา--</option>
                        </select>
                        </div>
                        <label class="col-sm-1 col-form-label">หมายเลขโทรศัพท์</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" id="ex-phone" name="stdPhone" value="<?php echo $stdPhone; ?>" require>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-1 col-form-label">E-mail</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="stdEmail" value="<?php echo $stdEmail; ?>" require>
                        </div>
                        <label class="col-sm-1 col-form-label">Facebook</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="stdFb" value="<?php echo $stdFb; ?>" require>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-1 col-form-label">รหัสผ่าน</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="stdPassword" value="<?php echo $stdPassword; ?>" require>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12 text-center">
                            <button class="btn btn-warning" type="submit" name="btupdatestudentall">แก้ไข</button>
                            <a href="studentall.php"><button class="btn btn-danger" type="button">ยกเลิก</button></a>
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
    <script src="../../assets/vendors/DataTables/datatables.min.js" type="text/javascript"></script>
    <!-- CORE SCRIPTS-->
    <script src="../../assets/js/app.min.js" type="text/javascript"></script>
    <!-- PAGE LEVEL SCRIPTS-->
    <script src="../../assets/js/scripts/form-plugins.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(function() {
            $('#tbstudentall').DataTable({
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