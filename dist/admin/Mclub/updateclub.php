<?php
session_start();
if (!isset($_SESSION['orgzerName']) && ($_SESSION['orgzerID'])) {
    header('location: ../../');
    echo "กรุณาเข้าสู่ระบบ!";
} else {
}
include '../../db/dbcon.php';
$clubUpdateby = $_SESSION['orgzerID'];
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
    $stmt_update = $DB_con->prepare('SELECT club.*, organization.*, mainorg.*, student.* FROM club 
                                JOIN organization ON organization.orgtionNo = club.clubOrgtion
                                JOIN mainorg ON mainorg.mainorgNo = club.clubMainorg
                                JOIN student ON student.stdID = club.clubstdID
                                WHERE clubNo = :clubNo ');
    $stmt_update->execute(array(':clubNo' => $id));
    $update_row = $stmt_update->fetch(PDO::FETCH_ASSOC);
    extract($update_row);
} else {
    header("Location: club.php");
}
if (isset($_POST['btupdateclub'])) {
    $clubYear = $_POST['clubYear'];
    $clubstdID = $_POST['clubstdID'];
    $clubPst = $_POST['clubPst'];
    $clubOrgtion = $_POST['clubOrgtion'];
    $clubMainorg = $_POST['clubMainorg'];
    $clubAddby = $_POST['clubAddby'];

    if (empty($clubPst)) {
        $errMSG = "กรุณากรอกรายละเอียดให้ครบถ้วน";
    }
    //check username
    if ($clubPst != "" && $clubstdID != "" && $clubYear != "" && $clubOrgtion != "" && $clubMainorg != "") {
        include '../../db/dbcon.php';

        $cesql = "SELECT * FROM club WHERE clubPst='$clubPst' && clubstdID='$clubstdID' && clubYear='$clubYear' && clubOrgtion='$clubOrgtion' && clubMainorg='$clubMainorg'";
        $checkexist = mysqli_query($conn, $cesql);
        if (mysqli_num_rows($checkexist)) {


            $errMSG = "รายชื่อนี้ได้ถูกเพิ่มแล้ว";
        }
    }
    // if no error occured, continue ....
    if (!isset($errMSG)) {
        $stmt = $DB_con->prepare('UPDATE club
                                    SET 
                                    clubNo=:clubNo,
                                    clubYear=:clubYear,
                                    clubstdID=:clubstdID,
                                    clubPst=:clubPst,
                                    clubOrgtion=:clubOrgtion,
                                    clubAddby=:clubAddby,
                                    clubMainorg=:clubMainorg
                                    WHERE clubNo=:clubNo');
        $stmt->bindParam(':clubNo', $clubNo);
        $stmt->bindParam(':clubYear', $clubYear);
        $stmt->bindParam(':clubstdID', $clubstdID);
        $stmt->bindParam(':clubPst', $clubPst);
        $stmt->bindParam(':clubOrgtion', $clubOrgtion);
        $stmt->bindParam(':clubMainorg', $clubMainorg);
        $stmt->bindParam(':clubAddby', $clubAddby);
        if ($stmt->execute()) {
?>
            <script>
                alert('ทำการแก้ไขเรียบร้อย ...');
                window.location.href = 'club.php';
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
    <title>ระบบกิจกรรมนักศึกษา| แก้ไขข้อมูลสมาชิกชมรม</title>
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
        function getname(val) {
            $.ajax({
                type: "POST",
                url: "stdname.php",
                data: 'stdID=' + val,
                success: function(data) {
                    $("#stdname").html(data);
                }
            });
        }
    </script>
</head>

<body class="fixed-navbar" >
    <div class="page-content fade-in-up" style="padding:20px;padding-top:0px">
        <div class="page-heading">
            <h1 class="page-title">จัดการชมรม</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                </li>
                <li class="breadcrumb-item"><a href="club.php">จัดการชมรม</a></li>
                <li class="breadcrumb-item">แก้ไขข้อมูลสมาชิกชมรม</li>
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
                    <h5>แก้ไขข้อมูลสมาชิกชมรม</h5>
                </div>
            </div>
            <div class="ibox-body">
                <form class="form-horizontal" id="form-sample-1" enctype="multipart/form-data" method="post" novalidate="novalidate">
                    <div class="form-group row">
                        <label class="col-sm-1 col-form-label">ปีการศึกษา</label>
                        <div class="col-sm-2">
                            <select class="form-control" style="width: 100%;" name="clubYear" required />
                            <option value="<?php echo $clubYear ?>"> <?php echo $clubYear ?></option>
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
                            <select class="form-control select2_demo_1" style="width: 100%;" name="clubstdID" id="clubstdID" onChange="getname(this.value);" required>
                            <option value="<?php echo $clubstdID ?>"> <?php echo $clubstdID ?>: <?php echo $stdName ?></option>
                            <?php
                                $sql = "SELECT * FROM student WHERE stdStatus = 'กำลังศึกษา'";
                                $result = $conn->query($sql);
                                ?>
                                <option  disabled="disabled">--รหัสนักศึกษา--</option>
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
                            <input class="form-control" type="text" name="clubPst" value="<?php echo $clubPst; ?>" require />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-1 col-form-label">สังกัด</label>
                        <div class="col-sm-5">
                            <select class="form-control select2_demo_1" style="width: 100%;" name="clubMainorg" >
                            <option value="<?php echo $clubMainorg ?>"> <?php echo $mainorg ?></option>
                            <?php
                                $sql = "SELECT orgzerSec FROM organizer WHERE orgzerID = '$clubAddby'";
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
                                if ($row["orgzerSec"] == "คณะ" || $row["orgzerSec"] == "มหาวิทยาลัย") {
                                    $sql = "SELECT organizer.*, mainorg.* FROM organizer
                                              JOIN mainorg ON organizer.orgzerMainorg = mainorg.mainorgNo
                                              WHERE organizer.orgzerID = '$clubAddby'
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
                            <select class="form-control select2_demo_1" style="width: 100%;" name="clubOrgtion" required>
                                <option value="<?php echo $clubOrgtion ?>"> <?php echo $organization ?></option>
                                <?php
                                $sql = "SELECT orgzerSec, orgzerOrgtion FROM organizer WHERE orgzerID = '$clubAddby'";
                                $result = mysqli_query($conn, $sql);
                                mysqli_num_rows($result);
                                // output data of each row
                                $row = mysqli_fetch_assoc($result);
                                ?>
                                <?php
                                if ($row["orgzerSec"] == "Admin") {
                                    $sql = "SELECT orgtionNo, organization FROM organization";
                                    $result = $conn->query($sql);
                                ?>
                                <option selected="selected" disabled="disabled">--องค์กร--</option>
                                    <?php
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
                                if ($row["orgzerSec"] == "คณะ" || $row["orgzerSec"] == "มหาวิทยาลัย") {
                                    $org=$row["orgzerOrgtion"];
                                    $sql = "SELECT * FROM organization
                                              WHERE orgtionNo = '$org'
                                              ";
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
                                ?>
                            </select>
                        </div>
                    </div>                            
                    <input class="form-control" type="hidden" name="clubNo" value="<?php echo $clubNo; ?>" readonly />
                    <input class="form-control" type="hidden" name="clubAddby" value="<?php echo $clubAddby; ?>" readonly />

                    <div class="form-group row">
                        <div class="col-sm-12 text-center">
                            <button class="btn btn-warning" type="submit" name="btupdateclub">แก้ไข</button>
                            <a href="club.php"><button class="btn btn-danger" type="button" data-dismiss="ibox">ยกเลิก</button></a>
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