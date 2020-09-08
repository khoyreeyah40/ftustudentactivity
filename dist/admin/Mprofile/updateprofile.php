<?php
session_start();
if (!isset($_SESSION['orgzerName']) && ($_SESSION['orgzerID'])) {
    header('location: ../../');
    echo "กรุณาเข้าสู่ระบบ!";
} else {
}
include '../../db/dbcon.php';
$profileID = $_SESSION['orgzerID'];
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
    $stmt_update = $DB_con->prepare('SELECT organizer.*, mainorg.*,organization.*, usertype.* FROM organizer
                                    JOIN usertype ON organizer.orgzeruserType = usertype.usertypeID 
                                    JOIN mainorg ON organizer.orgzerMainorg = mainorg.mainorgNo 
                                    JOIN organization ON organizer.orgzerOrgtion = organization.orgtionNo 
                                    WHERE orgzerID=:orgzerID ');
    $stmt_update->execute(array(':orgzerID' => $id));
    $update_row = $stmt_update->fetch(PDO::FETCH_ASSOC);
    extract($update_row);
} else {
    header("Location: profile.php");
}
if (isset($_POST['btupdateprofile'])) {
    $orgzerID = $_POST['orgzerID'];
    $orgzerName = $_POST['orgzerName'];
    $orgzerPhone = $_POST['orgzerPhone'];
    $orgzerEmail = $_POST['orgzerEmail'];
    $orgzerFb = $_POST['orgzerFb'];
    $orgzerPassword = $_POST['orgzerPassword'];
    $Image = $_POST['Image'];
    $imgFile = $_FILES['Image']['name'];
    $tmp_dir = $_FILES['Image']['tmp_name'];
    $imgSize = $_FILES['Image']['size'];
    if($imgFile){
        $upload_dir = '../../assets/img/'; // upload directory
        $imgExt = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION)); // get image extension
        // valid image extensions
        $valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
        // rename uploading image
        $Image = "profile" . "/" . rand(1000, 1000000) . "." . $imgExt;
        // allow valid image file formats
        if (in_array($imgExt, $valid_extensions)) {
          // Check file size '5MB'
          if ($imgSize < 5000000) {
            unlink($upload_dir.$update_row['orgzerImage']);
            move_uploaded_file($tmp_dir, $upload_dir . $Image);
          } else {
            $errMSG = "ขนาดไฟล์รูปน้อยกว่า 5MB";
          }
        } else {
          $errMSG = "อนุญาตไฟล์ประเภท JPG, JPEG, PNG & GIF เท่านั้น";
        }
      }else
      {
        // if no image selected the old image remain as it is.
        $Image = $update_row['orgzerImage']; // old image from database
      }
    //check username
    // if no error occured, continue ....
    if (!isset($errMSG)) {
        $stmt = $DB_con->prepare('UPDATE organizer
                                SET orgzerID=:orgzerID,
                                orgzerName=:orgzerName,
                                orgzerPhone=:orgzerPhone,
                                orgzerEmail=:orgzerEmail,
                                orgzerFb=:orgzerFb,
                                orgzerPassword=:orgzerPassword,
                                orgzerImage=:orgzerImage
                                WHERE orgzerID=:orgzerID');
$stmt->bindParam(':orgzerID', $orgzerID);
$stmt->bindParam(':orgzerName', $orgzerName);
$stmt->bindParam(':orgzerPhone', $orgzerPhone);
$stmt->bindParam(':orgzerEmail', $orgzerEmail);
$stmt->bindParam(':orgzerFb', $orgzerFb);
$stmt->bindParam(':orgzerPassword', $orgzerPassword);
$stmt->bindParam(':orgzerImage', $Image);
        if ($stmt->execute()) {
?>
            <script>
                alert('ทำการแก้ไขเรียบร้อย ...');
                window.location.href = 'profile.php';
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
    <title>ระบบกิจกรรมนักศึกษา| ข้อมูลส่วนตัว</title>
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
            <h1 class="page-title">ข้อมูลส่วนตัว</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                </li>
                <li class="breadcrumb-item">ข้อมูลส่วนตัว</li>
            </ol>
        </div>
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
        <form method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="col-lg-3 col-md-4">
                <div class="ibox">
                    <div class="ibox-body text-center">
                        <div class="m-t-20">
                        <p><img src="../../assets/img/<?php echo $orgzerImage; ?>" height="150" width="150" /></p>
                        <input class="input-group" type="file" name="Image" accept="image/*" />                        
                        </div>
                        <h6 class="font-strong m-b-10 m-t-10"><?php echo $orgzerName; ?></h6>
                        <div class="m-b-20 text-muted"><?php echo $userType; ?></div>
                        <button class="btn btn-warning" type="submit" name="btupdateprofile">แก้ไข</button>
                        <a href="profile.php"><button class="btn btn-danger" type="button">ยกเลิก</button></a>                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-md-8">
                <div class="ibox">
                    <div class="ibox-body">
                        <div class="row justify-content-center">
                            <h1 class="m-t-10 m-b-10 font-strong">ข้อมูลส่วนตัว</h1>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-10">
                                <ul class="list-group list-group-full list-group-divider">
                                    <li class="list-group-item">รหัสผู้ใช้
                                        <a href="javascript:;"><span class="pull-right "><?php echo $orgzerID; ?></span></a>
                                        <input class="form-control" type="hidden" name="orgzerID" value="<?php echo $orgzerID; ?>" required />
                                    </li>
                                    <li class="list-group-item">ชื่อ-สกุล
                                        <span class="pull-right ">                            
                                            <input class="form-control" type="text" name="orgzerName" value="<?php echo $orgzerName; ?>" required />
                                        </span>
                                    </li>
                                    <li class="list-group-item">สถานะ
                                        <a href="javascript:;"><span class="pull-right "><?php echo $userType; ?></span></a>
                                    </li>
                                    <li class="list-group-item">กลุ่ม
                                        <a href="javascript:;"><span class="pull-right "><?php echo $orgzerGroup; ?></span></a>
                                    </li>
                                    <li class="list-group-item">ระดับ
                                        <a href="javascript:;"><span class="pull-right "><?php echo $orgzerSec; ?></span></a>
                                    </li>
                                    <li class="list-group-item">สังกัด
                                        <a href="javascript:;"><span class="pull-right "><?php echo $mainorg; ?></span></a>
                                    </li>
                                    <li class="list-group-item">องค์กร
                                        <a href="javascript:;"><span class="pull-right "><?php echo $organization; ?></span></a>
                                    </li>
                                    <li class="list-group-item">หมายเลขโทรศัพท์
                                        <span class="pull-right ">                            
                                            <input class="form-control" type="text" id="ex-phone" name="orgzerPhone" value="<?php echo $orgzerPhone; ?>" required />
                                        </span>                                    
                                    </li>
                                    <li class="list-group-item">Email
                                        <span class="pull-right ">                            
                                            <input class="form-control" type="text" name="orgzerEmail" value="<?php echo $orgzerEmail; ?>" required />
                                        </span>                                    
                                    </li>
                                    <li class="list-group-item">Facebook
                                        <span class="pull-right ">                            
                                            <input class="form-control" type="text" name="orgzerFb" value="<?php echo $orgzerFb; ?>" required />
                                        </span>                                   
                                    </li>
                                    <li class="list-group-item">Password
                                        <span class="pull-right ">                            
                                            <input class="form-control" type="text" name="orgzerPassword" value="<?php echo $orgzerPassword; ?>" required />
                                        </span>                                    
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </form>
        <style>
            .profile-social a {
                font-size: 16px;
                margin: 0 10px;
                color: #999;
            }

            .profile-social a:hover {
                color: #485b6f;
            }

            .profile-stat-count {
                font-size: 22px
            }
        </style>
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
            $('#tbboard').DataTable({
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

                var orgzerid = $(this).data('id'); // it will get id of clicked row

                $('#dynamic-content').html(''); // leave it blank before ajax call
                $('#modal-loader').show(); // load ajax loader

                $.ajax({
                        url: 'moreinfo.php',
                        type: 'POST',
                        data: 'id=' + orgzerid,
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