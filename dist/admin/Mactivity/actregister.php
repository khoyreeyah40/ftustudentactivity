<?php
session_start();
if (!isset($_SESSION['orgzerName']) && ($_SESSION['orgzerID'])) {
  header('location: ../../welcome/home.php');
  echo "กรุณาเข้าสู่ระบบ!";
} else {
}
include '../../db/dbcon.php';
$actregAddby = $_SESSION['orgzerID'];
?>

<?php
$id = $_GET['act_id'];

require_once '../../db/dbconfig.php';
if (isset($_GET['actregno1'])&&($_GET['id'])){
  $id=$_GET['id'];
  $stmt_actreg = $DBcon->prepare('UPDATE actregister 
                                 SET actregStatus="ยืนยันเรียบร้อย",
                                 actregAddby= :actregAddby
                                  WHERE actregNo=:actregno');
  $stmt_actreg->bindParam(':actregAddby', $actregAddby);
  $stmt_actreg->bindParam(':actregno', $_GET['actregno1']);
  $stmt_actreg->execute();
  header("Location: actregister.php?act_id=$id");
}
else
if (isset($_GET['actregno2'])&&($_GET['id'])) {
  $id=$_GET['id'];
  $stmt_actreg1 = $DBcon->prepare('UPDATE actregister 
                                 SET actregStatus="รอยืนยันการเข้าร่วม",
                                 actregAddby= :actregAddby
                                  WHERE actregNo=:actregno');
  $stmt_actreg1->bindParam(':actregAddby', $actregAddby);
  $stmt_actreg1->bindParam(':actregno', $_GET['actregno2']);
  $stmt_actreg1->execute();

  header("Location: actregister.php?act_id=$id");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width initial-scale=1.0">
  <title>ระบบกิจกรรมนักศึกษา| เช็คชื่อ</title>
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
      <h1 class="page-title">เช็คชื่อ</h1>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
        </li>
        <li class="breadcrumb-item"><a href="act.php">จัดการกิจกรรมของฉัน</a> </li>
        <li class="breadcrumb-item">เช็คชื่อ</li>
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
    
    <div class="row">
      <div class="col-12">
      <div class="card"style="border-width:0px;border-bottom-width:4px;border-right-width:4px;">
          <div class="card-header"style="background-color:#d1cbaf">
            <h5 style="color:#2c2c2c">ตารางรายชื่อผู้ลงทะเบียน</h5>
          </div>
          <!-- /.card-header -->
          <div class="card-body text-nowrap">
            <table id="tbactregis" class="table table-hover-sm table-striped text-center" cellspacing="0" width="100%">
              <thead>
                <tr style="color:#528124;">
                  <th>รหัสนักศึกษา</th>
                  <th>ชื่อ-สกุล</th>
                  <th>สาขา</th>
                  <th>กลุ่ม</th>
                  <th>สถานะ</th>
                  <th>ยืนยันเข้าร่วม</th>
                </tr>
              </thead>
              <tbody>
                <?php
                require_once '../../db/dbconfig.php';
                $stmt = $DBcon->prepare("SELECT activity.*, actregister.*, student.*, department.*  FROM actregister
                                        JOIN activity ON activity.actID = actregister.actregactID
                                        JOIN student ON student.stdID = actregister.actregstdID
                                        JOIN department ON department.dpmNo = student.stdDpm
                                        WHERE activity.actID='$id'
                                        ORDER BY actregister.actregNo DESC
                                          ");
                $stmt->execute();
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                ?>
                  <tr>
                    <td><?php echo $row['actregstdID']; ?></td>
                    <td><a href="" data-toggle="modal" data-target="#modalstdmoreinfo" data-id="<?php echo $row['stdID']; ?>" id="stdmoreinfo"><?php echo $row['stdName']; ?></a></td>
                    <td><?php echo $row['department']; ?></td>
                    <td><?php echo $row['stdGroup']; ?></td>
                    <td><?php echo $row['actregStatus']; ?></td>
                    <td>
                      <?php
                      if ($row['actregStatus'] == 'รอยืนยันการเข้าร่วม') {
                      ?>
                      <a class="btn btn-fix btn-sm btn-info" href="?actregno1=<?php echo $row['actregNo']; ?>&& id=<?php echo $row['actregactID']; ?> " title="ยืนยันการเข้าร่วมกิจกรรม" onclick="return confirm('ยืนยันการเข้าร่วมกิจกรรม ?')">ยืนยันการเข้าร่วมกิจกรรม</a>
                      <?php
                      } else if ($row['actregStatus'] == 'ยืนยันเรียบร้อย') {
                      ?>
                      <a class="btn btn-fix btn-sm btn-danger" href="?actregno2=<?php echo $row['actregNo']; ?>&& id=<?php echo $row['actregactID']; ?> " title="ยกเลิกการเข้าร่วมกิจกรรม" onclick="return confirm('ยกเลิกการเข้าร่วมกิจกรรม ?')">ยกเลิกการเข้าร่วมกิจกรรม</a>
                      <?php
                      }
                      ?>
                    </td>
                  </tr>
                <?php
                }
                ?>
              </tbody>
            </table>
          </div>
          <div class="modal fade" id="modalstdmoreinfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
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
      $('#tbactregis').DataTable({
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

      $(document).on('click', '#stdmoreinfo', function(e) {

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