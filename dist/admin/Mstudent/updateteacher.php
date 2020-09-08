<?php
session_start();
if (!isset($_SESSION['orgzerName']) && ($_SESSION['orgzerID'])) {
    header('location: ../../');
    echo "กรุณาเข้าสู่ระบบ!";
} else {
}
include '../../db/dbcon.php';
$orgzerAddby = $_SESSION['orgzerID'];
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
    $stmt_update = $DB_con->prepare('SELECT mainorg.*, teacher.*, faculty.* FROM teacher
    JOIN faculty ON faculty.faculty = teacher.teacherfct
    JOIN mainorg ON mainorg.mainorgNo = faculty.faculty
    WHERE teacher.teacherNo = :teacherNo');
    $stmt_update->execute(array(':teacherNo' => $id));
    $update_row = $stmt_update->fetch(PDO::FETCH_ASSOC);
    extract($update_row);
} else {
    header("Location: teacher.php");
}
if (isset($_POST['btupdateteacher'])) {
    $teacherNo = $_POST['teacherNo']; 
    $teacher = $_POST['teacher']; // user name
    $teacherfct = $_POST['teacherfct'];
    $teacherAddby = $_POST['teacherAddby'];
    // if no error occured, continue ....
    if (!isset($errMSG)) {
        $stmt = $DB_con->prepare('UPDATE teacher
                                    SET 
                                    teacherNo=:teacherNo,
                                    teacher=:teacher,
                                    teacherfct=:teacherfct,
                                    teacherAddby=:teacherAddby
                                    WHERE teacherNo=:teacherNo');
        $stmt->bindParam(':teacherNo', $teacherNo);
        $stmt->bindParam(':teacher', $teacher);
        $stmt->bindParam(':teacherfct', $teacherfct);
        $stmt->bindParam(':teacherAddby', $teacherAddby);
        if ($stmt->execute()) {
?>
            <script>
                alert('ทำการแก้ไขเรียบร้อย ...');
                window.location.href = 'teacher.php';
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
    <title>ระบบกิจกรรมนักศึกษา| แก้ไขรายชื่ออาจารย์</title>
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
    <div class="page-content fade-in-up" style="padding:20px;padding-top:0px">
        <div class="page-heading">
            <h1 class="page-title">จัดการรายชื่ออาจารย์</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                </li>
                <li class="breadcrumb-item"><a href="teacher.php">จัดการรายชื่ออาจารย์</a></li>
                <li class="breadcrumb-item">แก้ไขรายชื่ออาจารย์</li>
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
                    <h5>แก้ไขรายชื่ออาจารย์</h5>
                </div>
            </div>
            <div class="ibox-body">
                <form class="form-horizontal" id="form-sample-1" method="post" novalidate="novalidate" style="height:150px; width:100%">
                    <div class="form-group row">
                        <label class="col-sm-1 col-form-label">ชื่ออาจารย์</label>
                        <div class="col-sm-5">
                            <input class="form-control" type="text" name="teacher" value="<?php echo $teacher; ?>" required />
                        </div>
                        <label class="col-sm-1 col-form-label">คณะ</label>
                        <div class="col-sm-5">
                            <select class="form-control select2_demo_1" style="width: 100%;" name="teacherfct" required>
                                <option value="<?php echo $teacherfct ?>"> <?php echo $mainorg ?></option>
                                <?php
                                $sql = "SELECT orgzerSec FROM organizer WHERE orgzerID = '$orgzerAddby'";
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
                                <option disabled="disabled">--คณะ--</option>
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
                                WHERE organizer.orgzerID='$orgzerAddby' ";
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
                    <input class="form-control" type="hidden" name="teacherNo" value="<?php echo $teacherNo; ?>" required />

                    <div class="form-group row">
                        <div class="col-sm-12 text-center">
                            <button class="btn btn-warning" type="submit" name="btupdateteacher">แก้ไข</button>
                            <a href="teacher.php"><button class="btn btn-danger" type="button">ยกเลิก</button></a>
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