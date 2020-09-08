<?php
session_start();
if (!isset($_SESSION['orgzerName']) && ($_SESSION['orgzerID'])) {
    header('location: ../../welcome/home.php');
    echo "กรุณาเข้าสู่ระบบ!";
} else {
}
include '../../db/dbcon.php';
$finishactby = $_SESSION['orgzerID'];
?>
<?php
error_reporting(~E_NOTICE); // avoid notice
require_once 'dbconfig.php';

if (isset($_POST['btaddactyear'])) {
    $actyear = $_POST['actyear'];


    if (empty($actyear)) {
        $errMSG = "กรุณากรอกรายละเอียดให้ครบถ้วน";
    }
    //check username
    if ($actyear != "") {
        include '../../db/dbcon.php';

        $cesql = "SELECT * FROM actyear WHERE actyear='$actyear'";
        $checkexist = mysqli_query($conn, $cesql);
        if (mysqli_num_rows($checkexist)) {


            $errMSG = "ปีการศึกษานี้ได้ถูกเพิ่มแล้ว";
        }
    }

    // if no error occured, continue ....
    if (!isset($errMSG)) {
        $stmt = $DB_con->prepare('INSERT INTO actyear(actyear,actyearStatus) VALUES
                                                        (:actyear,"ดำเนินกิจกรรม")');
        $stmt->bindParam(':actyear', $actyear);
        if ($stmt->execute()) {
            include '../../db/dbcon.php';
            $sql = "SELECT actyear FROM actyear WHERE actyearStatus = 'ดำเนินกิจกรรม'";
            $result = mysqli_query($conn, $sql);
            mysqli_num_rows($result);
            // output data of each row
            $row = mysqli_fetch_assoc($result);
            $year = $row["actyear"];
            $stmt = $DB_con->prepare('INSERT INTO actsem(actsemyear,actsem,actsemStatus) VALUES
                                                        (:actsemyear,"1","ดำเนินกิจกรรม")');
            $stmt->bindParam(':actsemyear', $year);
            if ($stmt->execute()) {
                $successMSG = "ทำการเพิ่มสำเร็จ";
                header("refresh:2;actyear.php");
            } else {
                $errMSG = "พบข้อผิดพลาด";
            }
        }
    }
}
?>
<?php
require_once '../../db/dbconfig.php';
if (isset($_GET['actsem_id'])) {

    $stmt_actsem = $DB_con->prepare('UPDATE actsem 
                                 SET actsemStatus="สำเร็จกิจกรรมแล้ว"
                                  WHERE actsemNo=:actsemno');
    $stmt_actsem->bindParam(':actsemno', $_GET['actsem_id']);
    if ($stmt_actsem->execute()) {
        include '../../db/dbcon.php';
        $sql = "SELECT actyear FROM actyear WHERE actyearStatus = 'ดำเนินกิจกรรม'";
        $result = mysqli_query($conn, $sql);
        mysqli_num_rows($result);
        // output data of each row
        $row = mysqli_fetch_assoc($result);
        $year = $row["actyear"];
        $stmt = $DB_con->prepare('INSERT INTO actsem(actsemyear,actsem,actsemStatus) VALUES
                                                  (:actsemyear,"2","ดำเนินกิจกรรม")');
        $stmt->bindParam(':actsemyear', $year);
        if ($stmt->execute()) {
            $successMSG = "ทำการเพิ่มสำเร็จ";
            header("refresh:2;actyear.php");
        } else {
            $errMSG = "พบข้อผิดพลาด";
        }
    }
}
?>
<?php
require_once '../../db/dbconfig.php';
if (isset($_GET['actsem2_id'])) {

    $stmt_actsem = $DB_con->prepare('UPDATE actsem 
                                 SET actsemStatus="สำเร็จกิจกรรมแล้ว"
                                  WHERE actsemNo=:actsemno');
    $stmt_actsem->bindParam(':actsemno', $_GET['actsem2_id']);
    if ($stmt_actsem->execute()) {
        include '../../db/dbcon.php';
            $sql = "SELECT actyear FROM actyear WHERE actyearStatus = 'ดำเนินกิจกรรม'";
            $result = mysqli_query($conn, $sql);
            mysqli_num_rows($result);
            // output data of each row
            $row = mysqli_fetch_assoc($result);
            $year = $row["actyear"];
            $sql = "SELECT * FROM activity WHERE actYear = '$year'";
            $result = mysqli_query($conn, $sql);
            mysqli_num_rows($result);
            // output data of each row
            $row = mysqli_fetch_assoc($result);
            $stmt = $DB_con->prepare('UPDATE activity
                                    SET actStatus="เสร็จสิ้นกิจกรรม"
                                    WHERE actYear=:actYear');
            $stmt->bindParam(':actYear', $year);
            if ($stmt->execute()) {
            include '../../db/dbcon.php';
            $sql = "SELECT * FROM actyear  WHERE actyearStatus = 'ดำเนินกิจกรรม'";
            $result = mysqli_query($conn, $sql);
            mysqli_num_rows($result);
            // output data of each row
            $row = mysqli_fetch_assoc($result);
            $year = $row["actyear"];
            $stmt = $DB_con->prepare('UPDATE actyear
                                    SET actyearStatus="สำเร็จกิจกรรมแล้ว"
                                    WHERE actyear=:actyear');
            $stmt->bindParam(':actyear', $year);
            if ($stmt->execute()) {
                
                $successMSG = "ทำการเพิ่มสำเร็จ";
                header("refresh:2;actyear.php");
            } else {
                $errMSG = "พบข้อผิดพลาด";
            }
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
    <title>ระบบกิจกรรมนักศึกษา| จัดการช่วงเวลากิจกรรม</title>
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
            <h1 class="page-title">จัดการช่วงเวลากิจกรรม</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                </li>
                <li class="breadcrumb-item"><a href="actall.php">จัดการกิจกรรม</a> </li>
                <li class="breadcrumb-item">จัดการช่วงเวลากิจกรรม</li>
            </ol>
        </div>
        <br>
    <?php
    $sql = "SELECT orgzerSec FROM organizer WHERE orgzerID = '$finishactby'";
    $result = mysqli_query($conn, $sql);
    mysqli_num_rows($result);
    // output data of each row
    $row = mysqli_fetch_assoc($result);
    ?>
    <?php
    if ($row["orgzerSec"] == "Admin") {
    ?>
      <a href="acttype.php"><button class="btn btn-info"  type="button"> <span class="fa fa-pencil"></span> &nbsp; จัดการหมวดหมู่</button></a>&nbsp;&nbsp;
        <a href="actall.php"><button class="btn btn-info"  type="button"> <span class="fa fa-pencil"></span> &nbsp; จัดการกิจกรรม</button></a>
    <br>
    <br>
    <?php
    } else if ($row["orgzerSec"] == "มหาวิทยาลัย") {
      ?>
        <a href="actall.php"><button class="btn btn-info"  type="button"> <span class="fa fa-pencil"></span> &nbsp; จัดการกิจกรรม</button></a>
      <br>
      <br>
      <?php
      }
    ?>
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
            <div class="col-sm-5 ">
                <div class="ibox">
                    <div class="ibox-body">
                        <form method="post">
                            <div class="form-group row" style="margin-bottom: 0rem;">
                                <div class="col-sm-8">
                                    <select class="form-control select2_demo_1" style="width: 100%;" name="actyear">
                                        <option selected="selected" disabled="disabled">--ปีการศึกษา--</option>
                                        <?php
                                        function DateThai($strDate)
                                        {
                                            $strYear = date("Y", strtotime($strDate)) + 544;
                                            return "$strYear";
                                        }
                                        $strDate = date("Y");
                                        for ($i = 2560; $i < DateThai($strDate); $i++) {
                                            echo "<option>$i</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-sm-1 text-center">
                                    <button class="btn btn-info" type="submit" name="btaddactyear">เพิ่ม</button>
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
            <h5 style="color:#2c2c2c">ตารางการจัดการช่วงเวลากิจกรรม</h5>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body text-nowrap">
                        <table id="tbactyear" class="table table-hover-sm table-striped text-center" cellspacing="0" width="100%">
                            <thead>
                                <tr style="color:#528124;">
                                    <th>ภาคเรียน/ปีการศึกษา</th>
                                    <th>สถานะ</th>
                                    <th>สำเร็จกิจกรรม</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                require_once '../../db/dbconfig.php';
                                $stmt = $DBcon->prepare("SELECT *  FROM actsem WHERE actsemStatus ='ดำเนินกิจกรรม'");
                                $stmt->execute();
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                    <tr>
                                        <td><?php echo $row['actsem']; ?> / <?php echo $row['actsemyear']; ?></td>
                                        <td><?php echo $row['actsemStatus']; ?></td>
                                        <td>
                                            <?php
                                            if ($row['actsemStatus'] == 'ดำเนินกิจกรรม' && $row['actsem'] == '1') {
                                            ?>
                                                <a class="btn btn-sm btn-danger" href="?actsem_id=<?php echo $row['actsemNo']; ?>" title="สำเร็จกิจกรรมนี้" onclick="return confirm('ต้องการสำเร็จกิจกรรมนี้ ?')"><span class="fa fa-check"></span> สำเร็จกิจกรรม</a>
                                            <?php
                                            } else if ($row['actsemStatus'] == 'ดำเนินกิจกรรม' && $row['actsem'] == '2') {
                                            ?>
                                                <a class="btn btn-sm btn-danger" href="?actsem2_id=<?php echo $row['actsemNo']; ?>" title="สำเร็จกิจกรรมนี้" onclick="return confirm('ต้องการสำเร็จกิจกรรมนี้ ?')"><span class="fa fa-check"></span> สำเร็จกิจกรรม</a>
                                            <?php
                                            } else  if ($row['actsemStatus'] == 'สำเร็จกิจกรรมแล้ว') {
                                                echo $row['actsemStatus'];
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php
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
            $('#tbactyear').DataTable({
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