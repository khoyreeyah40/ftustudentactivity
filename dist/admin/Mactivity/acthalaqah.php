<?php
session_start();
if (!isset($_SESSION['orgzerName']) && ($_SESSION['orgzerID'])) {
  header('location: ../../');
  echo "กรุณาเข้าสู่ระบบ!";
} else {
}
include '../../db/dbcon.php';
$actAddby = $_SESSION['orgzerID'];
?>

<?php
require_once '../../db/dbconfig.php';
if (isset($_GET['delete_id'])) {
  // it will delete an actual record from db
  $stmt_delete = $DBcon->prepare('DELETE FROM activity WHERE actNo =:actno');
  $stmt_delete->bindParam(':actno', $_GET['delete_id']);
  $stmt_delete->execute();

  header("Location: actfinished.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width initial-scale=1.0">
  <title>ระบบกิจกรรมนักศึกษา| กลุ่มฮาลาเกาะห์</title>
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

<body class="fixed-navbar" style="background-color:#f3e9d2;">

  <!-- Main content -->

  <div class="page-content fade-in-up" style="padding:20px;padding-top:0px">
    <div class="page-heading">
      <h1 class="page-title">กลุ่มฮาลาเกาะห์</h1>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
        </li>
        <li class="breadcrumb-item"><a href="actreq.php">กลุ่มฮาลาเกาะห์</a></li>
      </ol>
    </div>
    <br>

    <a class="btn btn-info" href="acthalaqahadvisor.php" type="button"> <span class="fa fa-pencil"></span> &nbsp; เพิ่มที่ปรึกษาฮาลาเกาะห์</a>

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

    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header" style="background-color:#2a9d8f">
            <h5 style="color:white">กิจกรรมที่เสร็จสิ้น</h5>
          </div>
          <!-- /.card-header -->
          <div class="card-body text-nowrap">
            <table id="tbactfinished" class="table table-hover-sm table-striped text-center" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th>ปีการศึกษา</th>
                  <th>ชื่อกิจกรรม</th>
                  <th>สังกัด</th>
                  <th>องค์กร</th>
                  <th>เพิ่มเติม</th>
                  <th>สถานะ</th>
                  <th>แก้ไข</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $sql = "SELECT orgzerSec,orgzerOrgtion FROM organizer WHERE orgzerID = '$actAddby'";
                $result = mysqli_query($conn, $sql);
                mysqli_num_rows($result);
                // output data of each row
                $row = mysqli_fetch_assoc($result);
                ?>
                <?php
                if ($row["orgzerSec"] == "Admin") {
                  require_once '../../db/dbconfig.php';
                  $stmt = $DBcon->prepare("SELECT * FROM activity ORDER BY actNo DESC");
                  $stmt->execute();
                  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                ?>
                    <tr>
                      <td><?php echo $row['actYear']; ?></td>
                      <td><?php echo $row['actName']; ?></td>
                      <td><?php echo $row['actMainorg']; ?></td>
                      <td><?php echo $row['actOrgtion']; ?></td>
                      <td>
                        <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modalmoreinfo" data-id="<?php echo $row['actNo']; ?>" id="moreinfo"><i class="fa fa-eye-open"></i> เพิ่มเติม</button>
                      </td>
                      <td><?php echo $row['actStatus']; ?></td>
                      <td>
                        <a class="btn btn-sm btn-warning" href="updateinfo.php?update_id=<?php echo $row['actNo']; ?>" title="click for edit" onclick="return confirm('sure to edit ?')"><span class="fa fa-edit"></span> แก้ไข</a>
                      </td>
                    </tr>
                  <?php
                  }
                }
                if ($row["orgzerSec"] == "คณะ" || "มหาวิทยาลัย") {
                  $org = $row["orgzerOrgtion"];
                  require_once '../../db/dbconfig.php';
                  $stmt = $DBcon->prepare("SELECT * FROM activity WHERE actOrgtion='$org' ORDER BY actNo DESC");
                  $stmt->execute();
                  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                  ?>
                    <tr>
                      <td><?php echo $row['actYear']; ?></td>
                      <td><?php echo $row['actName']; ?></td>
                      <td><?php echo $row['actMainorg']; ?></td>
                      <td><?php echo $row['actOrgtion']; ?></td>
                      <td>
                        <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modalmoreinfo" data-id="<?php echo $row['actNo']; ?>" id="moreinfo"><i class="fa fa-eye-open"></i> เพิ่มเติม</button>
                      </td>
                      <td><?php echo $row['actStatus']; ?></td>
                      <td>
                        <a class="btn btn-sm btn-warning" href="updateinfo.php?update_id=<?php echo $row['actNo']; ?>" title="click for edit" onclick="return confirm('sure to edit ?')"><span class="fa fa-edit"></span> แก้ไข</a>
                      </td>
                    </tr>
                <?php
                  }
                }
                ?>
              </tbody>
            </table>
            <div class="modal fade" id="modalmoreinfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content ">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">ข้อมูลเพิ่มเติม</h5>
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
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
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
      $('#tbactfinished').DataTable({
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