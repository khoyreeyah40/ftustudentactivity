<?php
session_start();
if (!isset($_SESSION['orgzerName']) && ($_SESSION['orgzerID'])) {
    header('location: ../../');
    echo "กรุณาเข้าสู่ระบบ!";
} else {
}
include '../../db/dbcon.php';
$newsAddby = $_SESSION['orgzerID'];
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
    $stmt_update = $DB_con->prepare('SELECT * FROM news WHERE newsNo=:newsNo');
    $stmt_update->execute(array(':newsNo' => $id));
    $update_row = $stmt_update->fetch(PDO::FETCH_ASSOC);
    extract($update_row);
} else {
    header("Location: news.php");
}
if (isset($_POST['btupdatenews'])) {
    $newsTitle = $_POST['newsTitle'];
    $newsStatus = $_POST['newsStatus'];
    $newsDescribe = $_POST['newsDescribe'];
    $newsAddby = $_POST['newsAddby'];
    $Image = $_POST['Image'];
    $imgFile = $_FILES['Image']['name'];
    $tmp_dir = $_FILES['Image']['tmp_name'];
    $imgSize = $_FILES['Image']['size'];
  
    if (empty($newsTitle)) {
      $errMSG = "กรุณาป้อนข้อมูลให้ครบ";
    } else if($imgFile) {
      $upload_dir = '../../assets/img/'; // upload directory
  
      $imgExt = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION)); // get image extension
  
      // valid image extensions
      $valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
  
      // rename uploading image
      $Image = "news" . "/" . rand(1000, 1000000) . "." . $imgExt;
  
      // allow valid image file formats
      if (in_array($imgExt, $valid_extensions)) {
        // Check file size '5MB'
        unlink($upload_dir.$update_row['newsImage']);
          move_uploaded_file($tmp_dir, $upload_dir . $Image);
        
      } else {
        $errMSG = "กรุณาอัพโหลดไฟล์ภาพเป็น JPG, JPEG, PNG & GIF เท่านั้น";
      }
    }else
    {
      // if no image selected the old image remain as it is.
      $Image = $update_row['newsImage']; // old image from database
    }
    // if no error occured, continue ....
    if (!isset($errMSG)) {
        $stmt = $DB_con->prepare('UPDATE news
                                    SET 
                                    newsNo=:newsNo,
                                    newsTitle=:newsTitle,
                                    newsDescribe=:newsDescribe,
                                    newsStatus=:newsStatus,
                                    newsImage=:newsImage,
                                    newsAddby=:newsAddby
                                    WHERE newsNo=:newsNo');
        $stmt->bindParam(':newsNo', $newsNo);
        $stmt->bindParam(':newsTitle', $newsTitle);
        $stmt->bindParam(':newsImage', $Image);
        $stmt->bindParam(':newsStatus', $newsStatus);
        $stmt->bindParam(':newsDescribe', $newsDescribe);
        $stmt->bindParam(':newsAddby', $newsAddby);
        if ($stmt->execute()) {
?>
            <script>
                alert('ทำการแก้ไขเรียบร้อย ...');
                window.location.href = 'news.php';
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
    <title>ระบบกิจกรรมนักศึกษา| แก้ไขข้อมูลข่าวประชาสัมพันธ์</title>
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
            <h1 class="page-title">จัดการข่าวประชาสัมพันธ์</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                </li>
                <li class="breadcrumb-item"><a href="news.php">จัดการข่าวประชาสัมพันธ์</a></li>
                <li class="breadcrumb-item">แก้ไขข้อมูลข่าวประชาสัมพันธ์</li>
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
                    <h5>แก้ไขข้อมูลข่าวประชาสัมพันธ์</h5>
                </div>
            </div>
            <div class="ibox-body">
                <form class="form-horizontal" enctype="multipart/form-data" id="form-sample-1" method="post" novalidate="novalidate" style="height:500px; width:100%">
                    <div class="form-group row">
                        <label class="col-sm-1 col-form-label">หัวข้อ</label>
                        <div class="col-sm-5">
                            <input class="form-control" type="text" name="newsTitle" value="<?php echo $newsTitle; ?>" required />
                        </div>
                        <label class="col-sm-1 col-form-label">สถานะ</label>
                        <div class="col-sm-5">
                            <select class="form-control" style="width: 100%;" name="newsStatus">
                                <option value="<?php echo $newsStatus ?>"> <?php echo $newsStatus ?></option>
                                <option value="แสดง">แสดง</option>
                                <option value="ซ่อน">ซ่อน</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row"> 
                        <label class="col-sm-1 col-form-label">คำอธิบาย</label>
                        <div class="col-sm-11">
                            <textarea class="form-control" rows="2" type="text" name="newsDescribe" value="<?php echo $newsDescribe; ?>" required><?php echo $newsDescribe; ?></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-1 col-form-label">อัพโหลดรูปภาพ</label>
                        <div class="col-sm-5">
                        <p><img src="../../assets/img/<?php echo $newsImage; ?>" height="150" width="150" /></p>
                        <input class="input-group" type="file" name="Image" accept="image/*" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-5">
                            <input class="form-control" type="hidden" name="newsAddby" value="<?php echo $newsAddby; ?>" readonly />
                        </div>
                        <div class="col-sm-5">
                            <input class="form-control" type="hidden" name="newsNo" value="<?php echo $newsNo; ?>" required />
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12 text-center">
                            <button class="btn btn-warning" type="submit" name="btupdatenews">แก้ไข</button>
                            <a href="news.php"><button class="btn btn-danger" type="button">ยกเลิก</button></a>
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
    <script src=".../../assets/vendors/select2/dist/js/select2.full.min.js" type="text/javascript"></script>
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