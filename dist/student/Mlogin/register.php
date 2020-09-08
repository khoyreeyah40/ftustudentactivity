<?php include '../../db/dbcon.php'; ?>
<?php
error_reporting(~E_NOTICE); // avoid notice
require_once 'dbconfig.php';

if (isset($_POST['btaddstd'])) {
    $stdYear = $_POST['stdYear'];
    $stdID = $_POST['stdID'];
    $stdName = $_POST['stdName'];
    $stdStatus = $_POST['stdStatus'];
    $stdGroup = $_POST['stdGroup'];
    $stdFct = $_POST['stdFct'];
    $stdDpm = $_POST['stdDpm'];
    $stdTc = $_POST['stdTc'];
    $stdPhone = $_POST['stdPhone'];
    $stdEmail = $_POST['stdEmail'];
    $stdFb = $_POST['stdFb'];
    $stdPassword = $_POST['stdPassword'];
    $imgFile = $_FILES['Image']['name'];
    $tmp_dir = $_FILES['Image']['tmp_name'];
    $imgSize = $_FILES['Image']['size'];

    if (empty($stdName)) {
        $errMSG = "กรุณากรอกรายละเอียดให้ครบถ้วน";
    } 
    else if (empty($imgFile)) {
        $Image = "default.png";
    } else {
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
            move_uploaded_file($tmp_dir, $upload_dir . $Image);
          } else {
            $errMSG = "ขนาดไฟล์รูปน้อยกว่า 5MB";
          }
        } else {
          $errMSG = "อนุญาตไฟล์ประเภท JPG, JPEG, PNG & GIF เท่านั้น";
        }
      }
    //check username
  if ($stdID != "") {
    include '../../db/dbcon.php';

    $cesql = "SELECT * FROM student WHERE stdID='$stdID'";
    $checkexist = mysqli_query($conn, $cesql);
    if (mysqli_num_rows($checkexist)) {


      $errMSG = "รายชื่อนี้ได้ถูกเพิ่มแล้ว";
    }
  }

    // if no error occured, continue ....
    if (!isset($errMSG)) {
        $stmt = $DB_con->prepare('INSERT INTO student(stdYear,stdID,stdName,stdStatus,stdFct,stdDpm,stdTc,stdGroup,stdPhone,stdEmail,stdFb,stdPassword,stdImage) VALUES
                                                        (:stdYear,:stdID,:stdName,:stdStatus,:stdFct,:stdDpm,:stdTc,:stdGroup,:stdPhone,:stdEmail,:stdFb,:stdPassword,:stdImage)');
        $stmt->bindParam(':stdYear', $stdYear);
        $stmt->bindParam(':stdID', $stdID);
        $stmt->bindParam(':stdName', $stdName);
        $stmt->bindParam(':stdStatus', $stdStatus);
        $stmt->bindParam(':stdFct', $stdFct);
        $stmt->bindParam(':stdDpm', $stdDpm);
        $stmt->bindParam(':stdTc', $stdTc);
        $stmt->bindParam(':stdGroup', $stdGroup);
        $stmt->bindParam(':stdPhone', $stdPhone);
        $stmt->bindParam(':stdEmail', $stdEmail);
        $stmt->bindParam(':stdFb', $stdFb);
        $stmt->bindParam(':stdPassword', $stdPassword);
        $stmt->bindParam(':stdImage', $Image);
        if ($stmt->execute()) {
            $successMSG = "ทำการลงทะเบียนสำเร็จ";
      header("Location:login.php");
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
  <meta name=”viewport” content=”width=device-width, maximum-scale=1, minimum-scale=0.5″ />    
  <title>ระบบกิจกรรมนักศึกษา| ลงทะเบียนเข้าใช้: สำหรับนักศึกษา</title>
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
    .sidebar-mini {
            margin-left: 0px;
        }

        .content-wrapper {
            margin-left: 0px;
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
<div class="page-wrapper">
  <!-- Main content -->
          <header class="header">
            <div class="flexbox flex-1" style="background-color:#528124;color:#FFFFFF;">
                <!-- START TOP-RIGHT TOOLBAR-->
                <ul class="nav navbar-toolbar">
                    <li>
                        <div><a href="http://www.ftu.ac.th/2019/index.php/th/"><img src="../../assets/img/head-ftu.png" width="140" height="40"/></a></div></li>
                    <li>
                        <h4 style="padding-left: 10px;">ระบบกิจกรรมนักศึกษามหาวิทยาลัยฟาฏอนี</h4>
                    </li>
                </ul>
                <ul class="nav navbar-toolbar ml-auto">
                <li class="dropdown dropdown-user">
                <div class="language">
                    <div class="google">
                        <div id="google_translate_element"><div class="skiptranslate goog-te-gadget" dir="ltr" ><div id=":0.targetLanguage" class="goog-te-gadget-simple" style="white-space: nowrap;"><img src="https://www.google.com/images/cleardot.gif" class="goog-te-gadget-icon" alt="" style="background-image: url(&quot;https://translate.googleapis.com/translate_static/img/te_ctrl3.gif&quot;); background-position: -65px 0px;"><span style="vertical-align: middle;"><a aria-haspopup="true" class="goog-te-menu-value" href="javascript:void(0)"><span>เลือกภาษา</span><img src="https://www.google.com/images/cleardot.gif" alt="" width="1" height="1"><span style="border-left: 1px solid rgb(187, 187, 187);">​</span><img src="https://www.google.com/images/cleardot.gif" alt="" width="1" height="1"><span aria-hidden="true" style="color: rgb(118, 118, 118);">▼</span></a></span></div></div></div>
                        <script type="text/javascript">
                            function googleTranslateElementInit() {
                                new google.translate.TranslateElement({pageLanguage: 'th', includedLanguages: 'zh-CN,de,id,km,lo,ms,my,th,tl,vi,th,en', layout: google.translate.TranslateElement.InlineLayout.SIMPLE, multilanguagePage: true}, 'google_translate_element');
                            }
                        </script>
                        <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
                    </div>
                </div>
                    </li>
                <li class="dropdown dropdown-user">
                <a class="nav-link dropdown-toggle link" href="contact.php" style="font-size: 16px;color:#FFFFFF;">ติดต่อ</a>
                    </li>
                </ul>
                <!-- END TOP-RIGHT TOOLBAR-->
            </div>
        </header>
        <div class="content-wrapper pb-2" style="background-color:#f4f4fc;">
  <div class="page-content fade-in-up" style="padding:20px;padding-top:0px">
    <div class="page-heading" style=" font-size: 36px;text-align: center;margin: 20px 0;">
       <div><p><img src="../../assets/img/head-ftu.png" /></p></div>
    <a href="../../welcome/home.php"style="color:#528124;">
               ระบบกิจกรรมนักศึกษา
    </a>
    </div>
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
    <div class="row ml-1 mr-1 justify-content-center">
      <div class="col-8 ">
        <div class="card " style="border-width:0px;border-top-width:4px;margin: 20px;">
          <div class="row justify-content-center">
            <div class="col-sm-8 ">
            <form  method="post" enctype="multipart/form-data">
                  <h1 style="text-align: center;margin: 20px 0;">ลงทะเบียนเข้าใช้</h1>
                  <div class="row">
                      <div class="col-sm-6">
                          <div class="form-group">
                              <select class="form-control select2_demo_1" style="width: 100%;" name="stdYear" required />
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
                      </div>
                      <div class="col-sm-6">
                          <div class="form-group">
                              <input class="form-control" type="text" name="stdID" placeholder="รหัสประจำตัวนักศึกษา" require />
                          </div>
                      </div>
                  </div>
                          <input class="form-control" type="hidden" name="stdStatus" value="กำลังศึกษา" require />
                  <div class="form-group">
                      <input class="form-control" type="text" name="stdName" placeholder="ชื่อ-สกุล" require />
                  </div>
                  <div class="form-group">
                  <select class="form-control select2_demo_1" style="width: 100%;" name="stdFct" id="stdFct" onChange="getdpm(this.value);gettc(this.value);" required>
                                                  <option selected="selected" disabled="disabled">--คณะ--</option>
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
                  </div>
                  <div class="form-group">
                  <select class="form-control select2_demo_1" style="width: 100%;" name="stdDpm" id="stddpm" required/>
                                                  <option  selected="selected"disabled="disabled">--สาขา--</option>
                                              </select>  
                  </div>
                  <div class="form-group">
                      <select class="form-control select2_demo_1" style="width: 100%;" name="stdTc" id="stdtc"  required />
                      <option selected="selected" disabled="disabled">--อาจารย์ที่ปรึกษา--</option>
                      
                      </select>
                  </div>
                  <div class="form-group">
                      <select class="form-control select2_demo_1" style="width: 100%;" name="stdGroup" required />
                      <option selected="selected" disabled="disabled">--เพศ--</option>
                      <option value="ชาย">ชาย</option>
                      <option value="หญิง">หญิง</option>
                      </select>
                  </div>
                  <div class="form-group">
                      <input class="form-control" id="ex-phone" type="text" name="stdPhone" placeholder="หมายเลขโทรศัพท์" required />
                  </div>
                  <div class="form-group">
                      <input class="form-control" type="text" name="stdEmail" placeholder="email@email.com" required />
                  </div>
                  <div class="form-group">
                      <input class="form-control" type="text" name="stdFb" placeholder="Facebook" require />
                  </div>
                  <div class="form-group">
                      <input class="input-group" type="file" name="Image" accept="image/*" />                        
                  </div>
                  <div class="form-group">
                      <input class="form-control" id="password" type="password" name="stdPassword" placeholder="รหัสผ่าน">
                  </div>
                  <div class="form-group">
                      <input class="form-control" type="password" name="password_confirmation" placeholder="ยืนยันรหัสผ่าน">
                  </div>
                  <div class="form-group">
                      <button class="btn btn-info btn-block" type="submit" name="btaddstd">ลงทะเบียน</button>
                  </div>
                  <div class="text-center">ลงทะเบียนแล้ว?
                      <a class="color-blue" href="login.php">ลงชื่อเข้าใช้</a>
                  </div>
                  <br>
                </form>
            </div>
          </div>
        </div>
        <!-- /.card-header -->
        <!-- /.card-body -->
        <!-- /.card -->
      </div>
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