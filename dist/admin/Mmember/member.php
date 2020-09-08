<?php
session_start();
if (!isset($_SESSION['orgzerName']) && ($_SESSION['orgzerID'])) {
  header('location: ../../');
  echo "กรุณาเข้าสู่ระบบ!";
} else {
}
include '../../db/dbcon.php';
$orgzerby = $_SESSION['orgzerID'];
?>
<?php
error_reporting(~E_NOTICE); // avoid notice
require_once '../dbconfig.php';

if (isset($_POST['btaddorgzer'])) {
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
  $imgFile = $_FILES['Image']['name'];
  $tmp_dir = $_FILES['Image']['tmp_name'];
  $imgSize = $_FILES['Image']['size'];

  if (empty($orgzerName)) {
    $errMSG = "กรุณากรอกรายละเอียดให้ครบถ้วน";
  } else if (empty($imgFile)) {
    $errMSG = "กรุณาเพิ่มรูปภาพ";
  } else {
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
        move_uploaded_file($tmp_dir, $upload_dir . $Image);
      } else {
        $errMSG = "ขนาดไฟล์รูปน้อยกว่า 5MB";
      }
    } else {
      $errMSG = "อนุญาตไฟล์ประเภท JPG, JPEG, PNG & GIF เท่านั้น";
    }
  }

  // if no error occured, continue ....
  if (!isset($errMSG)) {
    $stmt = $DB_con->prepare('INSERT INTO organizer(orgzerID,orgzerName,orgzeruserType,orgzerGroup,orgzerSec,orgzerOrgtion,orgzerMainorg,orgzerPhone,orgzerEmail,orgzerFb,orgzerPassword,orgzerAddby, orgzerImage) VALUES
                                                        (:orgzerID,:orgzerName, :orgzeruserType,:orgzerGroup,:orgzerSec,:orgzerOrgtion,:orgzerMainorg,:orgzerPhone,:orgzerEmail,:orgzerFb,:orgzerPassword,:orgzerAddby,:orgzerImage)');
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
      $sql = " SELECT orgzerNo FROM organizer ORDER BY orgzerNo DESC limit 1";
      $result = mysqli_query($conn, $sql);
      $row = mysqli_fetch_array($result);
      $no = $row["orgzerNo"];
      $orgzerID = str_pad($no, 5, "0", STR_PAD_LEFT);
      $orgzerIDlist = "ORG" . $orgzerID;

      $sql = "UPDATE organizer SET orgzerID='$orgzerIDlist' WHERE orgzerNo='$no' ";
      if ($conn->query($sql) === TRUE) {
        $successMSG = "ทำการเพิ่มสำเร็จ";
        header("refresh:2;member.php");
      } else {
        $errMSG = "พบข้อผิดพลาด";
      }
    }
  }
}
?>

<?php
require_once '../../db/dbconfig.php';
if (isset($_GET['delete_id'])) {
  $id=$_GET['delete_id'];
  // it will delete an actual record from db
  $sql = "DELETE FROM organizer WHERE orgzerID ='$id'";
	if (mysqli_query($conn, $sql)) {
              $sql = "SELECT orgzerImage FROM organizer WHERE orgzerID = '$id'";
              $result = mysqli_query($conn, $sql);
              mysqli_num_rows($result);
              // output data of each row
              $row = mysqli_fetch_assoc($result);
              unlink("../../assets/img/profile/" . $row['orgzerImage']);
    $successMSG = "ทำการลบสำเร็จ";
    header("Location: member.php");
	} else {
		$errMSG = "ไม่สามารถทำการลบได้เนื่องข้อมูลถูกนำไปใช้แล้ว";
	}
	
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width initial-scale=1.0">
  <title>ระบบกิจกรรมนักศึกษา| จัดการผู้ดูแลระบบ</title>
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
      <h1 class="page-title">จัดการผู้ดูแลระบบ</h1>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
        </li>
        <li class="breadcrumb-item">จัดการผู้ดูแลระบบ</li>
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
    <div class="ibox" style="box-shadow: 0 5px 4px rgba(0,0,0,.1);">
      <div class="ibox-head" style="background-color:#d1cbaf;">
        <div class="ibox-title" style="color:#484848;">
          <h5>เพิ่มผู้ดูแลระบบ</h5>
        </div>
        <div class="ibox-tools">
          <a class="ibox-collapse" style="color:#484848;"><i class="fa fa-minus"></i></a>
        </div>
      </div>
      <div class="ibox-body">
        <form class="form-horizontal" enctype="multipart/form-data" id="form-sample-1" method="post" novalidate="novalidate">
          <div class="form-group row">
            <label class="col-sm-1 col-form-label">ชื่อ-สกุล</label>
            <div class="col-sm-5">
              <input class="form-control" type="text" name="orgzerName" value="<?php echo $orgzerName; ?>" required />
            </div>
            <label class="col-sm-1 col-form-label">สถานะ</label>
            <div class="col-sm-5">
              <select class="form-control" style="width: 100%;" name="orgzeruserType" readonly />

              <?php
              $sql =  "SELECT usertype.*, organizer.* FROM organizer
                                      JOIN usertype ON organizer.orgzeruserType = usertype.usertypeID 
                                      WHERE organizer.orgzerID='$orgzerby' ";
              $result = $conn->query($sql);

              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  $userTypeNo = $row["usertypeID"];
                  $userTypelist = $row["userType"];
              ?>
                  <option value="<?php echo $userTypeNo ?>"> <?php echo $userTypelist ?></option>
              <?php
                }
              } else {
                echo "something";
              }
              ?>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-1 col-form-label">กลุ่ม</label>
            <div class="col-sm-5">
              <select class="form-control" style="width: 100%;" name="orgzerGroup" readonly />
              <?php
              $sql = "SELECT orgzerGroup FROM organizer WHERE orgzerID = '$orgzerby'";
              $result = $conn->query($sql);

              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  $orgzerGrouplist = $row["orgzerGroup"];
              ?>
                  <option value="<?php echo $orgzerGrouplist ?>"> <?php echo $orgzerGrouplist ?></option>
              <?php
                }
              } else {
                echo "something";
              }
              ?>
              </select>
            </div>
            <label class="col-sm-1 col-form-label">ระดับ</label>
            <div class="col-sm-5">
              <select class="form-control" style="width: 100%;" name="orgzerSec" readonly />
              <?php
              $sql = "SELECT orgzerSec FROM organizer WHERE orgzerID = '$orgzerby'";
              $result = $conn->query($sql);

              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  $orgzerSeclist = $row["orgzerSec"];
              ?>
                  <option value="<?php echo $orgzerSeclist ?>"> <?php echo $orgzerSeclist ?></option>
              <?php
                }
              } else {
                echo "something";
              }
              ?>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-1 col-form-label">สังกัด</label>
            <div class="col-sm-5">
              <select class="form-control" style="width: 100%;" name="orgzerMainorg" readonly />

              <?php
              $sql =  "SELECT mainorg.*, organizer.* FROM organizer
                                          JOIN mainorg ON organizer.orgzerMainorg = mainorg.mainorgNo
                                          WHERE organizer.orgzerID='$orgzerby' ";
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
              ?>
              </select>
            </div>
            <label class="col-sm-1 col-form-label">องค์กร</label>
            <div class="col-sm-5">
              <select class="form-control" style="width: 100%;" name="orgzerOrgtion" readonly />
              <?php
              $sql =  "SELECT organization.*, organizer.* FROM organizer
                                            JOIN organization ON organizer.orgzerOrgtion = organization.orgtionNo
                                            WHERE organizer.orgzerID='$orgzerby' ";
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
              ?>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-1 col-form-label">หมายเลขโทรศัพท์</label>
            <div class="col-sm-5">
              <input class="form-control" id="ex-phone" type="text" name="orgzerPhone" value="<?php echo $orgzerPhone; ?>" required />
            </div>
            <label class="col-sm-1 col-form-label">E-mail</label>
            <div class="col-sm-5">
              <input class="form-control" type="text" name="orgzerEmail" value="<?php echo $orgzerEmail; ?>" required />
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-1 col-form-label">Facebook</label>
            <div class="col-sm-5">
              <input class="form-control" type="text" name="orgzerFb" value="<?php echo $orgzerFb; ?>" required />
            </div>
            <label class="col-sm-1 col-form-label">รหัสผ่าน</label>
            <div class="col-sm-5">
              <input class="form-control" id="password" type="password" name="orgzerPassword" placeholder="password" value="<?php echo $orgzerPassword; ?>" required />
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-1 col-form-label">รูปประจำตัว</label>
            <div class="col-sm-5">
              <input class="input-group" type="file" name="Image" accept="image/*" />
            </div>
            <label class="col-sm-1 col-form-label">เพิ่มโดย</label>
            <div class="col-sm-5">
              <input class="form-control" type="text" name="orgzerAddby" value="<?php echo $orgzerby; ?>" readonly />
            </div>
            <div class="col-sm-5">
              <input class="form-control" type="hidden" name="orgzerID" value="ID" readonly />
            </div>
          </div>
          <div class="form-group row">
            <div class="col-sm-12 text-center">
              <button class="btn btn-info" type="submit" name="btaddorgzer">เพิ่ม</button>
              <a href="member.php"><button class="btn btn-danger" type="button" data-dismiss="ibox">ยกเลิก</button></a>
            </div>
          </div>
        </form>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="card"style="border-width:0px;border-bottom-width:4px;border-right-width:4px;">
          <div class="card-header"style="background-color:#d1cbaf;">
            <h5 style="color:#2c2c2c;">ตารางผู้จัดกิจกรรม</h5>
          </div>
          <!-- /.card-header -->
          <div class="card-body text-nowrap">
            <table id="tborganizer" class="table table-hover-sm table-striped text-center" cellspacing="0" width="100%">
              <thead>
                <tr style="color:#528124;">
                  <th>รหัสผู้ใช้</th>
                  <th>ชื่อ-สกุล</th>
                  <th>หมายเลขโทรศัพท์</th>
                  <th>รหัสผ่าน</th>
                  <th>เพิ่มโดย</th>
                  <th>แก้ไข/ลบ</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $sql = "SELECT orgzerGroup,orgzerOrgtion,orgzerMainorg FROM organizer WHERE orgzerID = '$orgzerby'";
                $result = mysqli_query($conn, $sql);
                mysqli_num_rows($result);
                // output data of each row
                $row = mysqli_fetch_assoc($result);
                $group = $row["orgzerGroup"];
                $orgtion = $row["orgzerOrgtion"];
                $mainorg = $row["orgzerMainorg"];
                require_once '../../db/dbconfig.php';
                $stmt = $DBcon->prepare("SELECT organizer.*, usertype.*, mainorg.*, organization.* 
                                            FROM organizer
                                            JOIN usertype ON organizer.orgzeruserType = usertype.usertypeID
                                            JOIN mainorg ON organizer.orgzerMainorg = mainorg.mainorgNo
                                            JOIN organization ON organizer.orgzerOrgtion = organization.orgtionNo 
                                            WHERE orgzerGroup='$group' && orgzerOrgtion='$orgtion' && orgzerMainorg='$mainorg' && orgzerID !='$orgzerby' 
                                            ORDER BY orgzerID DESC");
                $stmt->execute();
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                ?>
                  <tr>
                    <td><a href=""  data-toggle="modal" data-target="#modalmoreinfo" data-id="<?php echo $row['orgzerID']; ?>" id="moreinfo"><?php echo $row['orgzerID']; ?></a></td>
                    <td><?php echo $row['orgzerName']; ?></td>
                    <td><?php echo $row['orgzerPhone']; ?></td>
                    <td><?php echo $row['orgzerPassword']; ?></td>
                    <td><?php echo $row['orgzerAddby']; ?></td>
                    <td>
                      <a href="updateinfo.php?update_id=<?php echo $row['orgzerID']; ?>" title="แก้ไขข้อมูล" onclick="return confirm('ต้องการแก้ไขข้อมูล ?')"><button class="btn btn-warning btn-sm m-r-5" data-toggle="tooltip"><i class="fa fa-pencil font-30"></i></button></a>
                      <a href="?delete_id=<?php echo $row['orgzerID']; ?>" title="ลบสมาชิก" onclick="return confirm('ต้องการลบสมาชิก ?')"><button class="btn btn-danger btn-sm" data-toggle="tooltip"><i class="fa fa-trash font-30"></i></button></a>
                    </td>
                  </tr>
                <?php
                }
                ?>
              </tbody>
            </table>
          </div>
          <div class="modal fade" id="modalmoreinfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content ">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle" style="color:#528124;">รายละเอียดเพิ่มเติม</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div id="modal-loader" style="text-align: center; display: none;">
                      <img src="ajax-loader.gif">
                    </div>
                    <div id="dynamic-content">

                    </div>
                  </div>
                </div>
              </div>
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
      $('#tborganizer').DataTable({
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