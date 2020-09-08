<?php
session_start();
if (!isset($_SESSION['orgzerName']) && ($_SESSION['orgzerID'])) {
    header('location: ../../');
    echo "กรุณาเข้าสู่ระบบ!";
} else {
}
include '../../db/dbcon.php';
$pstUpdateby = $_SESSION['orgzerID'];
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
    $stmt_update = $DB_con->prepare('SELECT pst.*, organization.*, mainorg.*, student.* FROM pst 
                                JOIN organization ON organization.orgtionNo = pst.pstOrgtion
                                JOIN mainorg ON mainorg.mainorgNo = pst.pstMainorg
                                JOIN student ON student.stdID = pst.pststdID
                                WHERE pstNo = :pstNo ');
    $stmt_update->execute(array(':pstNo' => $id));
    $update_row = $stmt_update->fetch(PDO::FETCH_ASSOC);
    extract($update_row);
} else {
    header("Location: position.php");
}
if (isset($_POST['btupdateposition'])) {
    $pstYear = $_POST['pstYear'];
    $pststdID = $_POST['pststdID'];
    $pst = $_POST['pst'];
    $pstOrgtion = $_POST['pstOrgtion'];
    $pstMainorg = $_POST['pstMainorg'];
    $pstAddby = $_POST['pstAddby'];

    if (empty($pst)) {
        $errMSG = "กรุณากรอกรายละเอียดให้ครบถ้วน";
    }
    //check username
    if ($pst && $pststdID && $pstYear && $pstOrgtion && $pstMainorg != "") {
        include '../../db/dbcon.php';

        $cesql = "SELECT * FROM pst WHERE pst='$pst' && pststdID='$pststdID' && pstYear='$pstYear' && pstOrgtion='$pstOrgtion' && pstMainorg='$pstMainorg'";
        $checkexist = mysqli_query($conn, $cesql);
        if (mysqli_num_rows($checkexist)) {


            $errMSG = "รายชื่อนี้ได้ถูกเพิ่มแล้ว";
        }
    }
    // if no error occured, continue ....
    if (!isset($errMSG)) {
        $stmt = $DB_con->prepare('UPDATE pst
                                    SET 
                                    pstNo=:pstNo,
                                    pstYear=:pstYear,
                                    pststdID=:pststdID,
                                    pst=:pst,
                                    pstOrgtion=:pstOrgtion,
                                    pstAddby=:pstAddby,
                                    pstMainorg=:pstMainorg
                                    WHERE pstNo=:pstNo');
        $stmt->bindParam(':pstNo', $pstNo);
        $stmt->bindParam(':pstYear', $pstYear);
        $stmt->bindParam(':pststdID', $pststdID);
        $stmt->bindParam(':pst', $pst);
        $stmt->bindParam(':pstOrgtion', $pstOrgtion);
        $stmt->bindParam(':pstMainorg', $pstMainorg);
        $stmt->bindParam(':pstAddby', $pstAddby);
        if ($stmt->execute()) {
?>
            <script>
                alert('ทำการแก้ไขเรียบร้อย ...');
                window.location.href = 'position.php';
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
    <title>ระบบกิจกรรมนักศึกษา| แก้ไขข้อมูลตำแหน่งนักศึกษา</title>
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
        function getorgtion(val) {
            $.ajax({
                type: "POST",
                url: "orgtion.php",
                data: 'mainorgNo=' + val,
                success: function(data) {
                    $("#orgtion").html(data);
                }
            });
        }
    </script>
</head>

<body class="fixed-navbar" >
    <div class="page-content fade-in-up" style="padding:20px;padding-top:0px">
        <div class="page-heading">
            <h1 class="page-title">จัดการตำแหน่งนักศึกษา</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                </li>
                <li class="breadcrumb-item"><a href="position.php">จัดการตำแหน่งนักศึกษา</a></li>
                <li class="breadcrumb-item">แก้ไขข้อมูลตำแหน่งนักศึกษา</li>
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
                    <h5>แก้ไขข้อมูลตำแหน่งนักศึกษา</h5>
                </div>
            </div>
            <div class="ibox-body">
                <form class="form-horizontal" id="form-sample-1" enctype="multipart/form-data" method="post" novalidate="novalidate">
                    <div class="form-group row">
                        <label class="col-sm-1 col-form-label">ปีการศึกษา</label>
                        <div class="col-sm-2">
                            <select class="form-control" style="width: 100%;" name="pstYear" required />
                            <option value="<?php echo $pstYear ?>"> <?php echo $pstYear ?></option>
                            <option  disabled="disabled">--ปีการศึกษา--</option>
                            <?php
                                $sql = "SELECT * FROM actyear";
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
                        <label class="col-sm-1 col-form-label">รหัสนักศึกษา</label>
                        <div class="col-sm-3">
                            <select class="form-control select2_demo_1" style="width: 100%;" name="pststdID" required>
                            <option value="<?php echo $pststdID ?>"> <?php echo $pststdID ?>: <?php echo $stdName ?></option>
                            <?php
                                $sql = "SELECT * FROM student";
                                $result = $conn->query($sql);
                                ?>
                                <option disabled="disabled">--รหัสนักศึกษา--</option>
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
                                ?>
                            </select>
                        </div>
                        <label class="col-sm-1 col-form-label">ตำแหน่ง</label>
                        <div class="col-sm-4">
                            <input class="form-control" type="text" name="pst" value="<?php echo $pst; ?>" require />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-1 col-form-label">สังกัด</label>
                        <div class="col-sm-5">
                            <select class="form-control select2_demo_1" style="width: 100%;" name="pstMainorg" id="pstMainorg" onChange="getorgtion(this.value);">
                            <option value="<?php echo $pstMainorg ?>"> <?php echo $mainorg ?></option>
                            <?php
                                $sql = "SELECT orgzerSec FROM organizer WHERE orgzerID = '$pstAddby'";
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
                                              WHERE organizer.orgzerID = '$pstAddby'
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
                                    $sql = "SELECT * FROM mainorg
                                              WHERE mainorgSec = '$sec'
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
                                ?>
                            </select>
                        </div>
                        <label class="col-sm-1 col-form-label">องค์กร</label>
                        <div class="col-sm-5">
                            <select class="form-control select2_demo_1" style="width: 100%;" name="pstOrgtion" id="orgtion" required>
                                <option value="<?php echo $pstOrgtion ?>"> <?php echo $organization ?></option>
                                <option disabled="disabled">--องค์กร--</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-5">
                            <input class="form-control" type="hidden" name="pstNo" value="<?php echo $pstNo; ?>" readonly />
                        </div>
                        <div class="col-sm-5">
                            <input class="form-control" type="hidden" name="pstAddby" value="<?php echo $pstAddby; ?>" readonly />
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12 text-center">
                            <button class="btn btn-warning" type="submit" name="btupdateposition">แก้ไข</button>
                            <a href="position.php"><button class="btn btn-danger" type="button" data-dismiss="ibox">ยกเลิก</button></a>
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