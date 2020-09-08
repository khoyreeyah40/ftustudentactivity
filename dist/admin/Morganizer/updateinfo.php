<?php
session_start();
if (!isset($_SESSION['orgzerName']) && ($_SESSION['orgzerID'])) {
    header('location: ../../');
    echo "กรุณาเข้าสู่ระบบ!";
} else {
}
include '../../db/dbcon.php';
$orgzereditby = $_SESSION['orgzerID'];
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
    $stmt_update = $DB_con->prepare('SELECT organizer.*, usertype.*, mainorg.*, organization.* FROM organizer
        JOIN usertype ON organizer.orgzeruserType = usertype.usertypeID
        JOIN mainorg ON organizer.orgzerMainorg = mainorg.mainorgNo
        JOIN organization ON organizer.orgzerOrgtion = organization.orgtionNo
        WHERE organizer.orgzerID = :orgzerid');
    $stmt_update->execute(array(':orgzerid' => $id));
    $update_row = $stmt_update->fetch(PDO::FETCH_ASSOC);
    extract($update_row);
} else {
    header("Location: organizer.php");
}
if (isset($_POST['btupdateorgzer'])) {
    $orgzerID = $_POST['orgzerID'];
    $orgzerName = $_POST['orgzerName']; // user name
    $orgzeruserType = $_POST['orgzeruserType'];
    $orgzerGroup = $_POST['orgzerGroup'];
    $orgzerSec = $_POST['orgzerSec'];
    $orgzerOrgtion = $_POST['orgzerOrgtion'];
    $orgzerMainorg = $_POST['orgzerMainorg'];
    $orgzerPhone = $_POST['orgzerPhone'];
    $orgzerEmail = $_POST['orgzerEmail'];
    $orgzerFb = $_POST['orgzerFb'];
    $orgzerPassword = $_POST['orgzerPassword'];
    $orgzerAddby = $_POST['orgzerAddby'];
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
    // if no error occured, continue ....
    if (!isset($errMSG)) {
        $stmt = $DB_con->prepare('UPDATE organizer
                                    SET orgzerID=:orgzerID,
                                    orgzerName=:orgzerName,
                                    orgzeruserType=:orgzeruserType,
                                    orgzerGroup=:orgzerGroup,
                                    orgzerSec=:orgzerSec,
                                    orgzerOrgtion=:orgzerOrgtion,
                                    orgzerMainorg=:orgzerMainorg,
                                    orgzerPhone=:orgzerPhone,
                                    orgzerEmail=:orgzerEmail,
                                    orgzerFb=:orgzerFb,
                                    orgzerPassword=:orgzerPassword,
                                    orgzerAddby=:orgzerAddby,
                                    orgzerImage=:orgzerImage
                                    WHERE orgzerID=:orgzerID');
        $stmt->bindParam(':orgzerID', $orgzerID);
        $stmt->bindParam(':orgzerName', $orgzerName);
        $stmt->bindParam(':orgzeruserType', $orgzeruserType);
        $stmt->bindParam(':orgzerGroup', $orgzerGroup);
        $stmt->bindParam(':orgzerSec', $orgzerSec);
        $stmt->bindParam(':orgzerOrgtion', $orgzerOrgtion);
        $stmt->bindParam(':orgzerMainorg', $orgzerMainorg);
        $stmt->bindParam(':orgzerPhone', $orgzerPhone);
        $stmt->bindParam(':orgzerEmail', $orgzerEmail);
        $stmt->bindParam(':orgzerFb', $orgzerFb);
        $stmt->bindParam(':orgzerPassword', $orgzerPassword);
        $stmt->bindParam(':orgzerAddby', $orgzerAddby);
        $stmt->bindParam(':orgzerImage', $Image);
        if ($stmt->execute()) {
?>
            <script>
                alert('ทำการแก้ไขเรียบร้อย ...');
                window.location.href = 'organizer.php';
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
    <title>ระบบกิจกรรมนักศึกษา| จัดการเจ้าหน้าที่</title>
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
    function getmainorg(val) {
      $.ajax({
        type: "POST",
        url: "selectmainorg.php",
        data: 'secName=' + val,
        success: function(data) {
          $("#orgzermainorg").html(data);
        }
      });
    }
  </script>
  <script>
    function getorgtion(val) {
      $.ajax({
        type: "POST",
        url: "selectorgtion.php",
        data: 'mainorgNo=' + val,
        success: function(data) {
          $("#orgzerorgtion").html(data);
        }
      });
    }
  </script>
</head>

<body class="fixed-navbar">
    <div class="page-content fade-in-up" style="padding:20px;padding-top:0px">
        <div class="page-heading">
            <h1 class="page-title">จัดการเจ้าหน้าที่</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                </li>
                <li class="breadcrumb-item"><a href="organizer.php">จัดการเจ้าหน้าที่</a></li>
                <li class="breadcrumb-item">แก้ไขข้อมูลเจ้าหน้าที่</li>
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
                    <h5>แก้ไขข้อมูลเจ้าหน้าที่</h5>
                </div>
            </div>
            <div class="ibox-body">
                <form class="form-horizontal" enctype="multipart/form-data" id="form-sample-1" method="post" novalidate="novalidate" style="height:600px; width:100%">

                    <div class="form-group row">
                        <label class="col-sm-1 col-form-label">รหัสผู้ใช้</label>
                        <div class="col-sm-5">
                            <input class="form-control" type="text" name="orgzerID" value="<?php echo $orgzerID; ?>" readonly />
                        </div>
                        <label class="col-sm-1 col-form-label">ชื่อ-สกุล</label>
                        <div class="col-sm-5">
                            <input class="form-control" type="text" name="orgzerName" value="<?php echo $orgzerName; ?>" required />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-1 col-form-label">สถานะ</label>
                        <div class="col-sm-5">
                            <select class="form-control select2_demo_1" style="width: 100%;" name="orgzeruserType">
                                <option value="<?php echo $usertypeID ?>"> <?php echo $userType ?></option>
                                <?php
                                $sql = "SELECT orgzerSec FROM organizer WHERE orgzerID = '$orgzereditby'";
                                $result = mysqli_query($conn, $sql);
                                mysqli_num_rows($result);
                                // output data of each row
                                $row = mysqli_fetch_assoc($result);
                                ?><option disabled="disabled">--สถานะ--</option>
                                <?php
                                if ($row["orgzerSec"] == "Admin") {
                                    $sql = "SELECT * FROM usertype ";
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            $userTypeNo = $row["usertypeID"];
                                            $userTypelist = $row["userType"];
                                            $userTypeSec = $row["usertypeSec"];
                                ?>
                                            <option value="<?php echo $userTypeNo ?>"> <?php echo $userTypelist ?>(<?php echo $userTypeSec ?>)</option>
                                        <?php
                                        }
                                    } else {
                                        echo "something";
                                    }
                                }
                                if (($row["orgzerSec"] == "มหาวิทยาลัย") || ($row["orgzerSec"] == "คณะ")) {
                                    $sec = $row["orgzerSec"];
                                    $sql =  "SELECT * FROM usertype WHERE usertypeSec='$sec' ";
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            $userTypeNo = $row["usertypeID"];
                                            $userTypelist = $row["userType"];
                                            $userTypeSec = $row["usertypeSec"];
                                        ?>
                                            <option value="<?php echo $userTypeNo ?>"> <?php echo $userTypelist ?></option>
                                <?php
                                        }
                                    } else {
                                        echo "something";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <label class="col-sm-1 col-form-label">กลุ่ม</label>
                        <div class="col-sm-5">
                            <select class="form-control select2_demo_1" style="width: 100%;" name="orgzerGroup" required>
                                <option value="<?php echo $orgzerGroup ?>"> <?php echo $orgzerGroup ?></option>
                                <option value="ชาย">ชาย</option>
                                <option value="หญิง">หญิง</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-1 col-form-label">ระดับ</label>
                        <div class="col-sm-5">
                            <select class="form-control select2_demo_1" style="width: 100%;" name="orgzerSec" id="orgzersec" onChange="getmainorg(this.value);">
                                <option value="<?php echo $orgzerSec ?>"> <?php echo $orgzerSec ?></option>
                                <?php
                                $sql = "SELECT orgzerSec FROM organizer WHERE orgzerID = '$orgzereditby'";
                                $result = mysqli_query($conn, $sql);
                                mysqli_num_rows($result);
                                // output data of each row
                                $row = mysqli_fetch_assoc($result);
                                ?>
                                <?php
                                if ($row["orgzerSec"] == "Admin") {
                                    $sql = "SELECT * FROM section";
                                    $result = $conn->query($sql);
                    
                                    if ($result->num_rows > 0) {
                                      while ($row = $result->fetch_assoc()) {
                                        $secName = $row["secName"];
                                    ?>
                                        <option value="<?php echo $secName?>"> <?php echo $secName?></option>
                                  <?php
                                      }
                                    } else {
                                      echo "something";
                                    }
                                  }
                                  if (($row["orgzerSec"] == "คณะ") || ($row["orgzerSec"] == "มหาวิทยาลัย")) {
                                    $sec = $row["orgzerSec"];
                                    $sql = "SELECT * FROM section WHERE secName = '$sec'";
                                    $result = $conn->query($sql);
                    
                                    if ($result->num_rows > 0) {
                                      while ($row = $result->fetch_assoc()) {
                                        $secName = $row["secName"];
                                    ?>
                                        <option value="<?php echo $secName?>"> <?php echo $secName?></option>
                                  <?php
                                      }
                                    } else {
                                      echo "something";
                                    }
                                  }
                                ?>
                            </select>
                        </div>
                        <label class="col-sm-1 col-form-label">สังกัด</label>
                        <div class="col-sm-5">
                        <select class="form-control select2_demo_1" style="width: 100%;" name="orgzerMainorg" id="orgzermainorg" onChange="getorgtion(this.value);">
                                <option value="<?php echo $mainorgNo ?>"> <?php echo $mainorg ?></option>
                                    <option disabled="disabled">--สังกัด--</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-1 col-form-label">องค์กร</label>
                        <div class="col-sm-5">
                            <select class="form-control select2_demo_1" style="width: 100%;" name="orgzerOrgtion" id="orgzerorgtion" required>
                                <option value="<?php echo $orgtionNo ?>"> <?php echo $organization ?></option>
                                <option selected="selected" disabled="disabled">--กรุณาเลือกองค์กร--</option>
                            </select>
                        </div>
                        <label class="col-sm-1 col-form-label">เบอร์โทร</label>
                        <div class="col-sm-5">
                            <input class="form-control" id="ex-phone" type="text" name="orgzerPhone" value="<?php echo $orgzerPhone; ?>" required />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-1 col-form-label">E-mail</label>
                        <div class="col-sm-5">
                            <input class="form-control" type="text" name="orgzerEmail" value="<?php echo $orgzerEmail; ?>" required />
                        </div>
                        <label class="col-sm-1 col-form-label">Facebook</label>
                        <div class="col-sm-5">
                            <input class="form-control" type="text" name="orgzerFb" value="<?php echo $orgzerFb; ?>" required />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-1 col-form-label">รหัสผ่าน</label>
                        <div class="col-sm-5">
                            <input class="form-control" id="password" type="password" name="orgzerPassword" placeholder="password" value="<?php echo $orgzerPassword; ?>" required />
                        </div>
                        <input class="form-control" type="hidden" name="orgzerAddby" value="<?php echo $orgzerAddby; ?>" readonly />
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-1 col-form-label">รูปประจำตัว</label>
                        <div class="col-sm-5">
                        <p><img src="../../assets/img/<?php echo $orgzerImage; ?>" height="150" width="150" /></p>
                        <input class="input-group" type="file" name="Image" accept="image/*" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12 text-center">
                            <button class="btn btn-warning" type="submit" name="btupdateorgzer">แก้ไข</button>
                            <a href="organizer.php"><button class="btn btn-danger" type="button">ยกเลิก</button></a>
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