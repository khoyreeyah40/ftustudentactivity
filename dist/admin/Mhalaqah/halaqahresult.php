<?php
session_start();
if (!isset($_SESSION['orgzerName']) && ($_SESSION['orgzerID'])) {
  header('location: ../../');
  echo "กรุณาเข้าสู่ระบบ!";
} else {
}
include '../../db/dbcon.php';
$halaqahresultAddby = $_SESSION['orgzerID'];
?>
<?php
$halaqah_id = $_GET['halaqah_id'];

require_once '../../db/dbconfig.php';
if (isset($_GET['replyyes_id'])&&($_GET['halaqah_id'])) {
  $halaqahID = $_GET['halaqah_id'];
  $stmt_replyyes = $DBcon->prepare('UPDATE halaqahstd
                                  SET halaqahstdsem1Status="ผ่าน"
                                  WHERE halaqahstdID=:halaqahstdID && halaqahID=:halaqahID');
  $stmt_replyyes->bindParam(':halaqahstdID', $_GET['replyyes_id']);
  $stmt_replyyes->bindParam(':halaqahID', $halaqahID);
  $stmt_replyyes->execute();

  header("refresh:2;halaqahresult.php?halaqah_id=$halaqahID");
}
require_once '../../db/dbconfig.php';
if (isset($_GET['replyno_id'])&&($_GET['halaqah_id'])) {
  $halaqahID = $_GET['halaqah_id'];
  $stmt_replyno = $DBcon->prepare('UPDATE halaqahstd
                                  SET halaqahstdsem1Status="ไม่ผ่าน"
                                  WHERE halaqahstdID=:halaqahstdID && halaqahID=:halaqahID');
$stmt_replyno->bindParam(':halaqahstdID', $_GET['replyno_id']);
$stmt_replyno->bindParam(':halaqahID', $_GET['halaqah_id']);
$stmt_replyno->execute();

  header("refresh:2;halaqahresult.php?halaqah_id=$halaqahID");
}
require_once '../../db/dbconfig.php';
if (isset($_GET['replyyes1_id'])&&($_GET['halaqah_id'])) {
  $halaqahID = $_GET['halaqah_id'];
  $stmt_replyyes1 = $DBcon->prepare('UPDATE halaqahstd
                                  SET halaqahstdsem2Status="ผ่าน"
                                  WHERE halaqahstdID=:halaqahstdID && halaqahID=:halaqahID');
  $stmt_replyyes1->bindParam(':halaqahstdID', $_GET['replyyes1_id']);
  $stmt_replyyes1->bindParam(':halaqahID', $halaqahID);
  $stmt_replyyes1->execute();

  header("refresh:2;halaqahresult.php?halaqah_id=$halaqahID");
}
require_once '../../db/dbconfig.php';
if (isset($_GET['replyno1_id'])&&($_GET['halaqah_id'])) {
  $halaqahID = $_GET['halaqah_id'];
  $stmt_replyno1 = $DBcon->prepare('UPDATE halaqahstd
                                  SET halaqahstdsem2Status="ไม่ผ่าน"
                                  WHERE halaqahstdID=:halaqahstdID && halaqahID=:halaqahID');
$stmt_replyno1->bindParam(':halaqahstdID', $_GET['replyno1_id']);
$stmt_replyno1->bindParam(':halaqahID', $_GET['halaqah_id']);
$stmt_replyno1->execute();

  header("refresh:2;halaqahresult.php?halaqah_id=$halaqahID");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width initial-scale=1.0">
  <title>ระบบกิจกรรมนักศึกษา| จัดการกลุ่มศึกษาอัลกุรอ่าน: ผลการประเมิน</title>
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
      <h1 class="page-title">จัดการกลุ่มศึกษาอัลกุรอ่าน: การประเมิน</h1>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
        </li>
        <li class="breadcrumb-item"><a href="halaqah.php">จัดการกลุ่มศึกษาอัลกุรอ่าน</a></li>
        <li class="breadcrumb-item">การประเมิน</li>
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
    <div class="row">
      <div class="col-12">
      <div class="card"style="border-width:0px;border-bottom-width:4px;border-right-width:4px;">
          <div class="card-header"style="background-color:#d1cbaf">
            <h5 style="color:#2c2c2c">ตารางการประเมินนักศึกษา</h5>
          </div>
          <!-- /.card-header -->
          <div class="card-body text-nowrap">
            <table id="tbhalaqahstd" class="table table-hover-sm table-striped text-center" cellspacing="0" width="100%">
              <thead>
                <tr style="color:#528124;">
                  <th align="center"rowspan="2">รหัสนักศึกษา</th>
                  <th rowspan="2">ชื่อนักศึกษา</th>
                  <th align="center" colspan="4">ผลการประเมิน</th>
                </tr>
                <tr>
                  <th>ภาคเรียนที่1</th>
                  <th>การประเมิน</th>
                  <th>ภาคเรียน2</th>
                  <th>การประเมิน</th>
                </tr>
              </thead>
              <tbody>
                <?php
                require_once '../../db/dbconfig.php';
                $stmt = $DBcon->prepare("SELECT halaqahstd.*, student.* FROM halaqahstd
                                        JOIN student ON halaqahstd.halaqahstdID = student.stdID
                                        WHERE halaqahstd.halaqahID = '$halaqah_id'
                                        ORDER BY halaqahstd.createat  DESC");
                $stmt->execute();
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                ?>
                  <tr>
                    <td><?php echo $row['halaqahstdID']; ?></td>
                    <td><?php echo $row['stdName']; ?></td>
                    <?php if($row['halaqahstdsem1Status']== 'ผ่าน'){ ?>
                      <td class="text-success"><?php echo $row['halaqahstdsem1Status']; ?></td>
                    <?php }else if($row['halaqahstdsem1Status']== 'ไม่ผ่าน'){?>
                      <td class="text-danger"><?php echo $row['halaqahstdsem1Status']; ?></td>
                    <?php }else{?>
                      <td><?php echo $row['halaqahstdsem1Status']; ?></td>
                      <?php } ?>
                    <td>
                        <a class="btn btn-sm btn-success" href="?replyyes_id=<?php echo $row['halaqahstdID']; ?>&& halaqah_id=<?php echo $row['halaqahID']; ?>"><span class="fa fa-check"></span> ผ่าน</a>
                        <a class="btn btn-sm btn-danger" href="?replyno_id=<?php echo $row['halaqahstdID']; ?>&& halaqah_id=<?php echo $row['halaqahID']; ?>"><span class="fa fa-times"></span> ไม่ผ่าน</a>
                    </td>
                    <?php if($row['halaqahstdsem2Status']== 'ผ่าน'){ ?>
                      <td class="text-success"><?php echo $row['halaqahstdsem2Status']; ?></td>
                    <?php }else if($row['halaqahstdsem2Status']== 'ไม่ผ่าน'){?>
                      <td class="text-danger"><?php echo $row['halaqahstdsem2Status']; ?></td>
                    <?php }else{?>
                      <td><?php echo $row['halaqahstdsem2Status']; ?></td>
                      <?php } ?>
                    <td>
                        <a class="btn btn-sm btn-success" href="?replyyes1_id=<?php echo $row['halaqahstdID']; ?>&& halaqah_id=<?php echo $row['halaqahID']; ?>"><span class="fa fa-check"></span> ผ่าน</a>
                        <a class="btn btn-sm btn-danger" href="?replyno1_id=<?php echo $row['halaqahstdID']; ?>&& halaqah_id=<?php echo $row['halaqahID']; ?>"><span class="fa fa-times"></span> ไม่ผ่าน</a>
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
      $('#tbhalaqahstd').DataTable({
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