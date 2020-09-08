<?php
session_start();
if (!isset($_SESSION['orgzerName']) && ($_SESSION['orgzerID'])) {
  header('location: ../../');
  echo "กรุณาเข้าสู่ระบบ!";
} else {
}
include '../../db/dbcon.php';
$fileAddby = $_SESSION['orgzerID'];
?>
<?php


error_reporting(~E_NOTICE); // avoid notice
require_once '../../db/dbconfig.php';

if (isset($_POST['btaddfile'])) {
  $fileName = $_POST['fileName'];
  $fileStatus = $_POST['fileStatus'];
  $fileAddby = $_POST['fileAddby'];
  $imgFile = $_FILES['file']['name'];
  $tmp_dir = $_FILES['file']['tmp_name'];
  $imgSize = $_FILES['file']['size'];

  if (empty($fileName)) {
    $errMSG = "กรุณาป้อนข้อมูลให้ครบ";
  } else if (empty($imgFile)) {
    $errMSG = "กรุณาแนบไฟล์กิจกรรม";
  } else {
    $upload_dir = '../file/'; // upload directory
    $imgExt = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION)); // get image extension
    // valid image extensions
    $valid_extensions = array('pdf', 'docx', 'xlsx', 'pptx'); // valid extensions
    // rename uploading image
    $file = "announce" . "/" . rand(1000, 1000000) . "." . $imgExt;

    // allow valid image file formats
    if (in_array($imgExt, $valid_extensions)) {
      // Check file size '5MB'
      move_uploaded_file($tmp_dir, $upload_dir . $file);
    } else {
      $errMSG = "อนุญาตไฟล์ประเภท PDF, DOCX, XLSX & PPTX เท่านั้น";
    }
  }


  //check username



  // if no error occured, continue ....
  if (!isset($errMSG)) {
    $stmt = $DBcon->prepare("INSERT INTO file(fileName,fileStatus, fileDoc, fileAddby) VALUES
                                                (:fileName, 'แสดง',:fileDoc, :fileAddby)");
    $stmt->bindParam(':fileName', $fileName);
    $stmt->bindParam(':fileAddby', $fileAddby);
    $stmt->bindParam(':fileDoc', $file);
    if ($stmt->execute()) {
      $successMSG = "ทำการเพิ่มสำเร็จ";
      header("refresh:2;file.php");
    } else {
      $errMSG = "error while inserting....";
    }
  }
}
?>


<?php
require_once 'dbconfig.php';
if (isset($_GET['delete_id'])) {
  $stmt_select = $DBcon->prepare('SELECT newsImage FROM news WHERE newsNo =:newsNo');
  $stmt_select->execute(array(':newsNo' => $_GET['delete_id']));
  $newsRow = $stmt_select->fetch(PDO::FETCH_ASSOC);

  unlink("../../assets/img/" . $newsRow['newsImage']);

  // it will delete an actual record from db
  $stmt_delete = $DBcon->prepare('DELETE FROM news WHERE newsNo =:newsNo');
  $stmt_delete->bindParam(':newsNo', $_GET['delete_id']);
  $stmt_delete->execute();

  header("Location: news.php");
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

  <!-- Main content -->

  <div class="page-content fade-in-up" style="padding:20px;padding-top:0px">
    <div class="page-heading">
      <h1 class="page-title">จัดการเอกสาร</h1>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
        </li>
        <li class="breadcrumb-item"><a href="board.php">จัดการบอร์ดประชาสัมพันธ์</a></li>
        <li class="breadcrumb-item">จัดการเอกสาร</li>
      </ol>
    </div>
    <br>
    <a href="news.php"><button class="btn btn-info" type="button"> <span class="fa fa-news"></span> &nbsp; จัดการข่าวประชาสัมพันธ์</button></a>&nbsp;&nbsp;&nbsp;
    <a href="board.php"><button class="btn btn-info"  type="button"> <span class="fa fa-news"></span> &nbsp; จัดการบอร์ดประชาสัมพันธ์</button></a>
    <br>
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
          <h5>เพิ่มเอกสาร</h5>
        </div>
        <div class="ibox-tools">
          <a class="ibox-collapse" style="color:#484848;"><i class="fa fa-minus"></i></a>
        </div>
      </div>
      <div class="ibox-body">
        <form class="form-horizontal" enctype="multipart/form-data" id="form-sample-1" method="post" novalidate="novalidate">
          <div class="form-group row">
            <label class="col-sm-1 col-form-label">หัวข้อเอกสาร</label>
            <div class="col-sm-5">
              <input class="form-control" type="text" name="fileName" value="<?php echo $fileName; ?>" required />
            </div>
            <label class="col-sm-1 col-form-label">อัพโหลดไฟล์</label>
            <div class="col-sm-5">
              <input class="input-group" type="file" name="file" accept="file/*" />
            </div>
          </div>
          <div class="form-group row">
            <div class="col-sm-5">
              <input class="form-control" type="hidden" name="fileAddby" value="<?php echo $fileAddby; ?>" readonly />
            </div>
          </div>
          <div class="form-group row">
            <div class="col-sm-12 text-center">
              <button class="btn btn-info" type="submit" name="btaddfile">เพิ่ม</button>
              <a href="file.php"><button class="btn btn-danger" type="button" data-dismiss="ibox">ยกเลิก</button></a>
            </div>
          </div>
        </form>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="card"style="border-width:0px;border-bottom-width:4px;border-right-width:4px;">
          <div class="card-header"style="background-color:#d1cbaf">
            <h5 style="color:#2c2c2c">ตารางเอกสาร</h5>
          </div>
          <!-- /.card-header -->
          <div class="card-body text-nowrap">
            <table id="tbfile" class="table table-hover-sm table-striped text-center" cellspacing="0" width="100%">
              <thead>
                <tr style="color:#528124;">
                  <th>วันที่เพิ่ม</th>
                  <th>หัวข้อเอกสาร</th>
                  <th>สถานะ</th>
                  <th>เพิ่มโดย</th>
                  <th>แก้ไข</th>
                  <th>ลบ</th>
                </tr>
              </thead>
              <tbody>
                <?php
                require_once '../../db/dbconfig.php';
                $stmt = $DBcon->prepare("SELECT * FROM file ORDER BY fileNo DESC");
                $stmt->execute();
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                ?>
                  <tr>
                    <td><?php echo $row['createat']; ?></td>
                    <td><?php echo $row['fileName']; ?></td>
                    <td><?php echo $row['fileStatus']; ?></td>
                    <td><?php echo $row['fileAddby']; ?></td>
                    <td>
                      <a class="btn btn-sm btn-warning" href="updatefile.php?update_id=<?php echo $row['fileNo']; ?>" title="แก้ไขรายละเอียดเอกสาร" onclick="return confirm('ต้องการแก้ไขรายละเอียดเอกสาร ?')"><span class="fa fa-edit"></span> แก้ไข</a>
                    </td>
                    <td>
                      <a class="btn btn-sm  btn-danger" href="?delete_id=<?php echo $row['fileNo']; ?>" title="ลบเอกสาร" onclick="return confirm('ต้องการเอกสาร ?')"> <i class="fa fa-trash"></i> ลบ</a>
                    </td>
                  </tr>
                <?php
                }
                ?>
              </tbody>
            </table>
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
  <script src=".../../assets/vendors/select2/dist/js/select2.full.min.js" type="text/javascript"></script>
  <script src="../../assets/vendors/jquery.maskedinput/dist/jquery.maskedinput.min.js" type="text/javascript"></script>
  <script src="../../assets/vendors/jquery-validation/dist/jquery.validate.min.js" type="text/javascript"></script>
  <script src="../../assets/vendors/DataTables/datatables.min.js" type="text/javascript"></script>
  <!-- CORE SCRIPTS-->
  <script src="../../assets/js/app.min.js" type="text/javascript"></script>
  <!-- PAGE LEVEL SCRIPTS-->
  <script src="../../assets/js/scripts/form-plugins.js" type="text/javascript"></script>
  <script type="text/javascript">
    $(function() {
      $('#tbfile').DataTable({
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

        var newsno = $(this).data('id'); // it will get id of clicked row

        $('#dynamic-content').html(''); // leave it blank before ajax call
        $('#modal-loader').show(); // load ajax loader

        $.ajax({
            url: 'morenewsinfo.php',
            type: 'POST',
            data: 'id=' + newsno,
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