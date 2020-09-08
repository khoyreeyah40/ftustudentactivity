<?php
session_start();
if (!isset($_SESSION['orgzerName']) && ($_SESSION['orgzerID'])) {
  header('location: ../../');
  echo "กรุณาเข้าสู่ระบบ!";
} else {
}
include '../../db/dbcon.php';
$studentAddby = $_SESSION['orgzerID'];
?>
<?php


error_reporting(~E_NOTICE); // avoid notice
require_once '../../db/dbconfig.php';

if (isset($_POST['btsearch'])) {
    $stdFct = $_POST['stdFct'];
    $stdDpm = $_POST['stdDpm'];
    $stdYear = $_POST['stdYear'];
    $stdGroup = $_POST['stdGroup'];
    if (empty($stdFct)) {
      $errMSG = "กรุณากรอกรายละเอียดให้ครบถ้วน";
    }else if (empty($stdDpm)) {
      $errMSG = "กรุณากรอกรายละเอียดให้ครบถ้วน";
    }else if (empty($stdYear)) {
      $errMSG = "กรุณากรอกรายละเอียดให้ครบถ้วน";
    }else if (empty($stdGroup)) {
      $errMSG = "กรุณากรอกรายละเอียดให้ครบถ้วน";
    }
    $_SESSION['stdFct'] = $stdFct;
    $_SESSION['stdDpm'] = $stdDpm;
    $_SESSION['stdYear'] = $stdYear;
    $_SESSION['stdGroup'] = $stdGroup;
    ?>
                                  <script type="text/javascript">
                                    window.location = "actcheck.php";
                                  </script>
                                <?php
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width initial-scale=1.0">
  <title>ระบบกิจกรรมนักศึกษา| ตรวจสอบการเข้าร่วมกิจกรรม</title>
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
  </script>
</head>

<body class="fixed-navbar">

  <!-- Main content -->

  <div class="page-content fade-in-up" style="padding:20px;padding-top:0px">
    <div class="page-heading">
      <h1 class="page-title">ตรวจสอบการเข้าร่วมกิจกรรม</h1>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
        </li>
        <li class="breadcrumb-item">ค้นหาตารางการเข้าร่วมกิจกรรม</li>
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
    <br>
    <div class="row justify-content-center">
      <div class="col-sm-10 ">
        <div class="ibox">
          <div class="ibox-body">
          <form class="form-horizontal" id="form-sample-1" method="post" novalidate="novalidate">
              <div class="form-group row">
                <div class="col-sm-6">
                  <select class="form-control select2_demo_1" style="width: 100%;" name="stdFct" id="stdFct" onChange="getdpm(this.value);" required>
                    <?php
                    $sql = "SELECT orgzerSec FROM organizer WHERE orgzerID = '$studentAddby'";
                    $result = mysqli_query($conn, $sql);
                    mysqli_num_rows($result);
                    // output data of each row
                    $row = mysqli_fetch_assoc($result);
                    ?>
                    <?php
                    if (($row["orgzerSec"] == "Admin")||($row["orgzerSec"] == "มหาวิทยาลัย")) {
                      $sql = "SELECT mainorg.*, faculty.* FROM faculty
                            JOIN mainorg ON faculty.faculty = mainorg.mainorgNo 
                            ORDER BY faculty.faculty DESC";
                      $result = $conn->query($sql);
                    ?>
                      <option selected="selected" disabled="disabled">--กรุณาเลือกคณะ--</option>
                      <?php
                      if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                          $faculty = $row["faculty"];
                          $mainorglist = $row["mainorg"];
                      ?>
                          <option value="<?php echo $faculty ?>"> <?php echo $mainorglist ?></option>
                      <?php
                        }
                      } else {
                        echo "something";
                      }
                    }
                    if ($row["orgzerSec"] == "คณะ") {
                      $main = $row["orgzerMainorg"];
                      $sql = "SELECT mainorg.*, organizer.*, faculty.* FROM organizer
                    JOIN mainorg ON organizer.orgzerMainorg = mainorg.mainorgNo
                    JOIN faculty ON mainorg.mainorgNo = faculty.faculty
                    WHERE organizer.orgzerID='$studentAddby' ";
                      $result = $conn->query($sql);
                      ?>
                      <option selected="selected" disabled="disabled">--กรุณาเลือกคณะ--</option required>
                      <?php
                      if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                          $faculty = $row["faculty"];
                          $mainorglist = $row["mainorg"];
                      ?>
                          <option value="<?php echo $faculty ?>"> <?php echo $mainorglist ?></option>
                    <?php
                        }
                      } else {
                        echo "something";
                      }
                    }
                    
                    ?>
                  </select>
                </div>
                <div class="col-sm-6">
                  <select class="form-control select2_demo_1" style="width: 100%;" name="stdDpm" id="stddpm" required>
                    <option selected="selected" disabled="disabled">--กรุณาเลือกสาขา--</option>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-6">
                  <select class="form-control select2_demo_1" style="width: 100%;" name="stdYear" required>
                    <option selected="selected" disabled="disabled">--กรุณาเลือกปีการศึกษา--</option>
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
                <div class="col-sm-6">
                  <select class="form-control select2_demo_1" style="width: 100%;" name="stdGroup" required>
                    <option selected="selected" disabled="disabled">--กรุณาเลือกกลุ่ม--</option>
                    <option value="ชาย">ชาย</option>
                    <option value="หญิง">หญิง</option>
                  </select>
                </div>
              </div>
              <br>
              <div class="form-group ">
                <div class="col-sm-12 text-center">
                <button class="btn btn-primary" name="btsearch">ค้นหา</button>
                </div>
              </div>
            </form>
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
    $(function() {
      $('#tbstudentall').DataTable({
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

        var stdid = $(this).data('id'); // it will get id of clicked row

        $('#dynamic-content').html(''); // leave it blank before ajax call
        $('#modal-loader').show(); // load ajax loader

        $.ajax({
            url: 'morestdinfo.php',
            type: 'POST',
            data: 'id=' + stdid,
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