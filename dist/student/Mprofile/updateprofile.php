<?php
session_start();
if (!isset($_SESSION['stdName']) && ($_SESSION['stdID'])) {
    header('location: ../../welcome/home.php');
    echo "กรุณาเข้าสู่ระบบ!";
} else {
}
include '../../db/dbcon.php';
$profileID = $_SESSION['stdID'];
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
    $stmt_update = $DB_con->prepare('SELECT student.*,department.*, teacher.*, faculty.*, mainorg.* FROM student 
                                    JOIN department ON department.dpmNo = student.stdDpm
                                    JOIN teacher ON teacher.teacherNo = student.stdTc
                                    JOIN faculty ON faculty.faculty = student.stdFct
                                    JOIN mainorg ON mainorg.mainorgNo = faculty.faculty
                                    WHERE stdID=:stdID ');
    $stmt_update->execute(array(':stdID' => $id));
    $update_row = $stmt_update->fetch(PDO::FETCH_ASSOC);
    extract($update_row);
} else {
    header("Location: profile.php");
}
if (isset($_POST['btupdateprofile'])) {
    $stdYear = $_POST['stdYear'];
    $stdID = $_POST['stdID'];
    $stdName = $_POST['stdName'];
    $stdStatus = $_POST['stdStatus'];
    $stdFct = $_POST['stdFct'];
    $stdDpm = $_POST['stdDpm'];
    $stdTc = $_POST['stdTc'];
    $stdPhone = $_POST['stdPhone'];
    $stdEmail = $_POST['stdEmail'];
    $stdFb = $_POST['stdFb'];
    $stdPassword = $_POST['stdPassword'];
    $Image = $_POST['Image'];
    $imgFile = $_FILES['Image']['name'];
    $tmp_dir = $_FILES['Image']['tmp_name'];
    $imgSize = $_FILES['Image']['size'];
    if ($stdID != "") {
        include '../../db/dbcon.php';
    
        $cesql = "SELECT * FROM student WHERE stdID='$stdID' && stdID!='$profileID'";
        $checkexist = mysqli_query($conn, $cesql);
        if (mysqli_num_rows($checkexist)) {
    
    
          $errMSG = "รหัสนักศึกษานี้ได้ถูกเพิ่มแล้ว";
        }
      }
    if($imgFile){
        $upload_dir = '../../assets/img/'; // upload directory
        $imgExt = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION)); // get image extension
        // valid image extensions
        $valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
        // rename uploading image
        $Image = "stdprofile" . "/" . rand(1000, 1000000) . "." . $imgExt;
        // allow valid image file formats
        if (in_array($imgExt, $valid_extensions)) {
          // Check file size '5MB'
          if ($imgSize < 5000000) {
            unlink($upload_dir.$update_row['stdImage']);
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
        $Image = $update_row['stdImage']; // old image from database
      }
    //check username
    // if no error occured, continue ....
    if (!isset($errMSG)) {
        $stmt = $DB_con->prepare('UPDATE student
                                SET stdID=:stdID,
                                stdName=:stdName,
                                stdStatus=:stdStatus,
                                stdFct=:stdFct,
                                stdDpm=:stdDpm,
                                stdTc=:stdTc,
                                stdPhone=:stdPhone,
                                stdEmail=:stdEmail,
                                stdFb=:stdFb,
                                stdPassword=:stdPassword,
                                stdImage=:stdImage
                                WHERE stdID=:stdID');
$stmt->bindParam(':stdID', $stdID);
$stmt->bindParam(':stdName', $stdName);
$stmt->bindParam(':stdStatus', $stdStatus);
$stmt->bindParam(':stdFct', $stdFct);
$stmt->bindParam(':stdDpm', $stdDpm);
$stmt->bindParam(':stdTc', $stdTc);
$stmt->bindParam(':stdPhone', $stdPhone);
$stmt->bindParam(':stdEmail', $stdEmail);
$stmt->bindParam(':stdFb', $stdFb);
$stmt->bindParam(':stdPassword', $stdPassword);
$stmt->bindParam(':stdImage', $Image);
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
     <script>
    function getdpm(val) {
      $.ajax({
        type: "POST",
        url: "stddpm.php",
        data: 'faculty=' + val,
        success: function(data) {
          $("#stddpm").html(data);
        }
      });
    }
    function gettc(val) {
      $.ajax({
        type: "POST",
        url: "stdtc.php",
        data: 'faculty=' + val,
        success: function(data) {
          $("#stdtc").html(data);
        }
      });
    }
  </script>
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
                        <p><img src="../../assets/img/<?php echo $stdImage; ?>" height="150" width="150" /></p>
                        <input class="input-group" type="file" name="Image" accept="image/*" />                        
                        </div>
                        <h6 class="font-strong m-b-10 m-t-10"><?php echo $stdName; ?></h6>
                        <div class="m-b-20 text-muted"><?php echo $stdStatus; ?></div>
                        <button class="btn btn-warning" type="submit" name="btupdateprofile">แก้ไข</button>
                        <a href="profile.php"><button class="btn btn-danger" type="button">ยกเลิก</button></a>                    
                    </div>
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
                                <li class="list-group-item">ปีที่เข้าศึกษา
                                        <span class="pull-right ">                            
                                            <select class="form-control select2_demo_1" style="width: 100%;" name="stdYear" required/>
                                                <option value="<?php echo $stdYear ?>"> <?php echo $stdYear ?></option>
                                                <option  disabled="disabled">--ปีการศึกษา--</option>
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
                                        </span>
                                    </li>
                                    <li class="list-group-item">รหัสนักศึกษา
                                    <span class="pull-right ">                            
                                            <input class="form-control" type="text" name="stdID" value="<?php echo $stdID; ?>" required />
                                        </span>
                                    </li>
                                    <li class="list-group-item">ชื่อ-สกุล
                                        <span class="pull-right ">                            
                                            <input class="form-control" type="text" name="stdName" value="<?php echo $stdName; ?>" required />
                                        </span>
                                    </li>
                                    <li class="list-group-item">สถานะ
                                        <span class="pull-right ">                            
                                        <select class="form-control select2_demo_1" style="width: 100%;" name="stdStatus" required/>
                                            <option value="<?php echo $stdStatus ?>"> <?php echo $stdStatus ?></option>
                                            <option disabled="disabled">--สถานะ--</option>
                                            <option value="กำลังศึกษา"> กำลังศึกษา</option>
                                            <option value="จบการศึกษา"> จบการศึกษา</option>
                                            </select>                                         
                                        </span>                                    
                                    </li>
                                    <li class="list-group-item">กลุ่ม
                                        <span class="pull-right ">                            
                                            <select class="form-control select2_demo_1" style="width: 100%;" name="stdGroup" required/>
                                            <option value="<?php echo $stdGroup ?>"> <?php echo $stdGroup ?></option>
                                            <option disabled="disabled">--กลุ่ม--</option>
                                            <option value="ชาย"> ชาย</option>
                                            <option value="หญิง"> หญิง</option>
                                            </select>                                          
                                        </span>
                                    </li>
                                    <li class="list-group-item">คณะ
                                        <span class="pull-right ">                            
                                        <select class="form-control select2_demo_1" style="width: 100%;" name="stdFct" id="stdFct" onChange="getdpm(this.value);gettc(this.value);" required>
                                            <option value="<?php echo $stdFct ?>"> <?php echo $mainorg ?></option>
                                            <option disabled="disabled">--คณะ--</option>
                                            <?php
                                            $sql = "SELECT faculty.*,mainorg.* FROM mainorg
                                            JOIN faculty ON mainorg.mainorgNo = faculty.faculty
                                            WHERE mainorg.mainorgSec ='คณะ'
                                            ";
                                            $result = $conn->query($sql);
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    $fctNo =$row["mainorgNo"];
                                                    $fctlist = $row["mainorg"];
                                            ?>
                                                    <option value="<?php echo $fctNo ?>"> <?php echo $fctlist ?></option>
                                            <?php
                                                }
                                            } else {
                                                echo "something";
                                            }
                                            ?>
                                            </select>                                        
                                        </span>                                    
                                    </li>
                                    <li class="list-group-item">สาขา
                                        <span class="pull-right ">                            
                                        <select class="form-control select2_demo_1" style="width: 100%;" name="stdDpm" id="stddpm" required>
                                        <option value="<?php echo $stdDpm ?>"> <?php echo $department ?>
                                            <option  disabled="disabled">--สาขา--</option>
                                        </select>  
                                    </span>                                    
                                    </li>
                                    <li class="list-group-item">อาจารย์ที่ปรึกษา
                                        <span class="pull-right ">                            
                                        <select class="form-control select2_demo_1" style="width: 100%;" name="stdTc" id="stdtc" required/>
                                            <option value="<?php echo $stdTc ?>"> <?php echo $teacher ?></option>
                                            <option disabled="disabled">--อาจารย์ที่ปรึกษา--</option>
                                            </select>                                          
                                        </span>                                   
                                    </li>
                                    <li class="list-group-item">หมายเลขโทรศัพท์
                                        <span class="pull-right ">                            
                                            <input class="form-control" type="text" id="ex-phone" name="stdPhone" value="<?php echo $stdPhone; ?>" required />
                                        </span>                                    
                                    </li>
                                    <li class="list-group-item">Email
                                        <span class="pull-right ">                            
                                            <input class="form-control" type="text" name="stdEmail" value="<?php echo $stdEmail; ?>" required />
                                        </span>                                    
                                    </li>
                                    <li class="list-group-item">Facebook
                                        <span class="pull-right ">                            
                                            <input class="form-control" type="text" name="stdFb" value="<?php echo $stdFb; ?>" required />
                                        </span> 
                                    </li>
                                    <li class="list-group-item">Password
                                        <span class="pull-right ">                            
                                            <input class="form-control" type="text" name="stdPassword" value="<?php echo $stdPassword; ?>" required />
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