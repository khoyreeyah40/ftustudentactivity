<?php
session_start();
if (!isset($_SESSION['orgzerName']) && ($_SESSION['orgzerID'])) {
    header('location: ../../');
    echo "กรุณาเข้าสู่ระบบ!";
} else {
}
include '../../db/dbcon.php';
$halaqahtcUpdateby = $_SESSION['orgzerID'];
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
    $stmt_update = $DB_con->prepare('SELECT halaqahtc.*, organizer.*, mainorg.*, actyear.* FROM halaqahtc 
    JOIN organizer ON organizer.orgzerID = halaqahtc.halaqahtcID
    JOIN mainorg ON mainorg.mainorgNo = halaqahtc.halaqahtcMainorg
    JOIN actyear ON actyear.actyear = halaqahtc.halaqahtcYear 
                                WHERE halaqahtcNo = :halaqahtcNo ');
    $stmt_update->execute(array(':halaqahtcNo' => $id));
    $update_row = $stmt_update->fetch(PDO::FETCH_ASSOC);
    extract($update_row);
} else {
    header("Location: halaqahtc.php");
}
if (isset($_POST['btupdatehalaqahtc'])) {
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
        $stmt = $DB_con->prepare('UPDATE halaqahtc
                                    SET 
                                    halaqahtcNo=:halaqahtcNo,
                                    halaqahtcYear=:halaqahtcYear,
                                    halaqahtcID=:halaqahtcID,
                                    halaqahtcMainorg=:halaqahtcMainorg
                                    WHERE halaqahtcNo=:halaqahtcNo');
        $stmt->bindParam(':halaqahtcNo', $halaqahtcNo);
        $stmt->bindParam(':halaqahtcYear', $halaqahtcYear);
        $stmt->bindParam(':halaqahtcID', $halaqahtcID);
        $stmt->bindParam(':halaqahtcMainorg', $halaqahtcMainorg);
        if ($stmt->execute()) {
?>
            <script>
                alert('ทำการแก้ไขเรียบร้อย ...');
                window.location.href = 'halaqahtc.php';
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
    <title>ระบบกิจกรรมนักศึกษา| แก้ไขข้อมูลที่ปรึกษากลุ่มศึกษาอัลกุรอ่าน</title>
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
            <h1 class="page-title">จัดการที่ปรึกษากลุ่มศึกษาอัลกุรอ่าน</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                </li>
                <li class="breadcrumb-item"><a href="../Mhalaqah/halaqahtc.php">จัดการที่ปรึกษากลุ่มศึกษาอัลกุรอ่าน</a></li>
                <li class="breadcrumb-item">แก้ไขข้อมูลที่ปรึกษากลุ่มศึกษาอัลกุรอ่าน</li>
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
                    <h5>แก้ไขข้อมูลที่ปรึกษากลุ่มอัลกุรอ่าน</h5>
                </div>
            </div>
            <div class="ibox-body">
                <form method="post">
                    <div class="form-group row" >
                        <div class="col-sm-2">
                            <select class="form-control select2_demo_1" style="width: 100%;" name="halaqahtcYear">
                            <option value="<?php echo $halaqahtcYear ?>"> <?php echo $halaqahtcYear ?></option>
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
                            <option value="<?php echo $halaqahtcID ?>"> <?php echo $orgzerID ?>: <?php echo $orgzerName ?></option>
                            <option  disabled="disabled">--ที่ปรึกษากลุ่มศึกษาอัลกุรอ่าน--</option>  
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
                                    WHERE usertype.userType= 'ที่ปรึกษากลุ่มศึกษาอัลกุรอ่าน'";
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
                                if ($row["orgzerSec"] == "คณะ") {
                                    $m = $row["orgzerMainorg"];
                                    $sql = "SELECT usertype.*, organizer.* FROM organizer 
                                    JOIN usertype ON usertype.usertypeID = organizer.orgzeruserType
                                    WHERE usertype.userType= 'ที่ปรึกษากลุ่มศึกษาอัลกุรอ่าน' && organizer.orgzerMainorg = '$m' ";
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
                                    WHERE usertype.userType= 'ที่ปรึกษากลุ่มศึกษาอัลกุรอ่าน' && organizer.orgzerSec = '$sec' ";
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
                            <option value="<?php echo $halaqahtcMainorg ?>"> <?php echo $mainorg ?></option>
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
                                <option disabled="disabled">--สังกัด--</option>
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
                                <option disabled="disabled">--สังกัด--</option>
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
                            <input class="form-control" type="hidden" name="halaqahtcNo" value="<?php echo $halaqahtcNo; ?>" readonly />
                        
                            <input class="form-control" type="hidden" name="halaqahtcAddby" value="<?php echo $halaqahtcAddby; ?>" readonly />
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12 text-center">
                            <button class="btn btn-warning" type="submit" name="btupdatehalaqahtc">แก้ไข</button>
                            <a href="halaqahtc.php"><button class="btn btn-danger" type="button">ยกเลิก</button></a>
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