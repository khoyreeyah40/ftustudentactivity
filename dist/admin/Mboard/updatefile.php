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
    $stmt_update = $DB_con->prepare('SELECT * FROM file  WHERE fileNo=:fileNo');
    $stmt_update->execute(array(':fileNo' => $id));
    $update_row = $stmt_update->fetch(PDO::FETCH_ASSOC);
    extract($update_row);
} else {
    header("Location: file.php");
}
if (isset($_POST['btupdatefile'])) {
    $fileName = $_POST['fileName'];
  $fileStatus = $_POST['fileStatus'];
  $fileAddby = $_POST['fileAddby'];
  $file = $_POST['file'];
  $imgFile = $_FILES['file']['name'];
  $tmp_dir = $_FILES['file']['tmp_name'];
  $imgSize = $_FILES['file']['size'];

  if (empty($fileName)) {
    $errMSG = "กรุณาป้อนข้อมูลให้ครบ";
  } else if($imgFile){
    $upload_dir = '../file/'; // upload directory
    $imgExt = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION)); // get image extension
    // valid image extensions
    $valid_extensions = array('pdf', 'docx', 'xlsx', 'pptx'); // valid extensions
    // rename uploading image
    $file = "announce" . "/" . rand(1000, 1000000) . "." . $imgExt;

    // allow valid image file formats
    if (in_array($imgExt, $valid_extensions)) {
      // Check file size '5MB'
      unlink($upload_dir.$update_row['fileDoc']);
      move_uploaded_file($tmp_dir, $upload_dir . $file);
    } else {
      $errMSG = "อนุญาตไฟล์ประเภท PDF, DOCX, XLSX & PPTX เท่านั้น";
    }
  }else
  {
    // if no image selected the old image remain as it is.
    $file = $update_row['fileDoc']; // old image from database
  }
    // if no error occured, continue ....
    if (!isset($errMSG)) {
        $stmt = $DB_con->prepare('UPDATE file
                                    SET fileNo=:fileNo,
                                    fileName=:fileName,
                                    fileDoc=:fileDoc,
                                    fileStatus=:fileStatus,
                                    fileAddby=:fileAddby
                                    WHERE fileNo=:fileNo');
        $stmt->bindParam(':fileNo', $fileNo);
        $stmt->bindParam(':fileName', $fileName);
        $stmt->bindParam(':fileDoc', $file);
        $stmt->bindParam(':fileStatus', $fileStatus);
        $stmt->bindParam(':fileAddby', $fileAddby);
        if ($stmt->execute()) {
?>
            <script>
                alert('ทำการแก้ไขเรียบร้อย ...');
                window.location.href = 'file.php';
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
    <title>ระบบกิจกรรมนักศึกษา| จัดการเอกสาร</title>
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

<body class="fixed-navbar" >
    <div class="page-content fade-in-up" style="padding:20px;padding-top:0px">
        <div class="page-heading">
            <h1 class="page-title">จัดการแก้ไขเอกสาร</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                </li>
                <li class="breadcrumb-item"><a href="board.php">จัดการบอร์ดประชาสัมพันธ์</a></li>
                <li class="breadcrumb-item">แก้ไขเอกสาร</li>
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
                    <h5>แก้ไขเอกสาร</h5>
                </div>
            </div>
            <div class="ibox-body">
                <form class="form-horizontal" enctype="multipart/form-data" id="form-sample-1" method="post" novalidate="novalidate" style="height:500px; width:100%">

                    <div class="form-group row">
                        <label class="col-sm-1 col-form-label">หัวข้อเอกสาร</label>
                        <div class="col-sm-5">
                            <input class="form-control" type="text" name="fileName" value="<?php echo $fileName; ?>" required />
                        </div>
                        <label class="col-sm-1 col-form-label">สถานะ</label>
                        <div class="col-sm-5">
                            <select class="form-control" style="width: 100%;" name="fileStatus">
                                <option value="<?php echo $fileStatus ?>"> <?php echo $fileStatus ?></option>
                                <option value="แสดง">แสดง</option>
                                <option value="ซ่อน">ซ่อน</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-1 col-form-label">ไฟล์</label>
                        <div class="col-sm-5">
                            <a href="../file/<?php echo $fileDoc; ?>"><?php echo $fileDoc; ?></a>
                            <input class="input-group" type="file" name="file" accept="file/*" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-5">
                            <input class="form-control" type="hidden" name="fileAddby" value="<?php echo $fileAddby; ?>" readonly />
                        </div>
                        <div class="col-sm-5">
                            <input class="form-control" type="hidden" name="fileNo" value="<?php echo $fileNo; ?>" readonly />
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12 text-center">
                            <button class="btn btn-warning" type="submit" name="btupdatefile">แก้ไข</button>
                            <a href="file.php"><button class="btn btn-danger" type="button">ยกเลิก</button></a>
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
            $('#tborganizer').DataTable({
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