<?php
session_start();
if (!isset($_SESSION['orgzerName']) && ($_SESSION['orgzerID'])) {
  header('location: ../../');
  echo "กรุณาเข้าสู่ระบบ!";
} else {
}
include '../../db/dbcon.php';
$actfinishedAddby = $_SESSION['orgzerID'];
?>
<?php
require_once '../../db/dbconfig.php';
if (isset($_GET['actfinished_id'])) {

  $stmt_replyyes = $DBcon->prepare('UPDATE activity 
                                 SET actStatus="ปลดล๊อก"
                                  WHERE actNo=:actno');
  $stmt_replyyes->bindParam(':actno', $_GET['actfinished_id']);
  $stmt_replyyes->execute();

  header("Location: actfinished.php");
}
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
  <title>ระบบกิจกรรมนักศึกษา| กิจกรรมที่เสร็จสิ้น</title>
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
      <h1 class="page-title">จัดการกิจกรรมของฉัน</h1>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
        </li>
        <li class="breadcrumb-item"><a href="act.php">จัดการกิจกรรมของฉัน</a> </li>
        <li class="breadcrumb-item">ตารางกิจกรรมที่เสร็จสิ้น</li>
      </ol>
    </div>
    <br>
    <a href="act.php"><button class="btn btn-info"  type="button"> <span class="fa fa-pencil"></span> &nbsp; จัดการกิจกรรมของฉัน</button></a>
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
    <br>
    <div class="row">
      <div class="col-12">
      <div class="card"style="border-width:0px;border-bottom-width:4px;border-right-width:4px;">
          <div class="card-header"style="background-color:#d1cbaf">
            <h5 style="color:#2c2c2c">กิจกรรมที่เสร็จสิ้น</h5>
          </div>
          <!-- /.card-header -->
          <div class="card-body text-nowrap">
            <table id="tbactfinished" class="table table-hover-sm table-striped text-center" cellspacing="0" width="100%">
              <thead>
                <tr style="color:#528124;">
                  <th>ช่วงเวลา</th>
                  <th>รหัสกิจกรรม</th>
                  <th>ชื่อกิจกรรม</th>
                  <th>หมวดหมู่</th>
                  <th>สังกัด</th>
                  <th>องค์กร</th>
                  <th>ปลดล๊อก</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $sql = "SELECT orgzerSec,orgzerOrgtion FROM organizer WHERE orgzerID = '$actfinishedAddby'";
                $result = mysqli_query($conn, $sql);
                mysqli_num_rows($result);
                // output data of each row
                $row = mysqli_fetch_assoc($result);
                ?>
                <?php
                if ($row["orgzerSec"] == "Admin") {
                  require_once '../../db/dbconfig.php';
                  $stmt = $DBcon->prepare("SELECT activity.*, acttype.*, mainorg.*, organization.*, actsem.*  FROM activity
                                            JOIN acttype ON activity.actType = acttype.acttypeNo
                                            JOIN mainorg ON activity.actMainorg = mainorg.mainorgNo
                                            JOIN organization ON activity.actOrgtion = organization.orgtionNo
                                            JOIN actsem ON actsem.actsemNo = activity.actSem
                                            WHERE activity.actStatus='เสร็จสิ้นกิจกรรม' 
                                            ORDER BY activity.actDateb DESC
                                              ");
                  $stmt->execute();
                  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                ?>
                    <tr>
                      <td><?php echo $row['actsem']; ?>/<?php echo $row['actYear']; ?></td>
                      <td><a href="" data-toggle="modal" data-target="#modalmoreinfo" data-id="<?php echo $row['actID']; ?>" id="moreinfo"><?php echo $row['actID']; ?></a></td>
                      <td><?php echo $row['actName']; ?></td>
                      <td><?php echo $row['acttypeName']; ?></td>
                      <td><?php echo $row['mainorg']; ?></td>
                      <td><?php echo $row['organization']; ?></td>
                      <td>
                        <a class="btn btn-sm btn-danger" href="?actfinished_id=<?php echo $row['actNo']; ?>" title="ปลดล็อคกิจกรรมนี้" onclick="return confirm('ต้องการปลดล็อคกิจกรรมนี้ ?')"><span class="fa fa-edit"></span> ปลดล็อค</a>
                      </td>
                    </tr>
                  <?php
                  }
                }
                if (($row["orgzerSec"] == "คณะ") || ($row["orgzerSec"] == "มหาวิทยาลัย")) {
                  $org = $row["orgzerOrgtion"];
                  require_once '../../db/dbconfig.php';
                  $stmt = $DBcon->prepare("SELECT activity.*, acttype.*, mainorg.*, organization.*,actsem.*  FROM activity
                                            JOIN acttype ON activity.actType = acttype.acttypeNo
                                            JOIN mainorg ON activity.actMainorg = mainorg.mainorgNo
                                            JOIN organization ON activity.actOrgtion = organization.orgtionNo
                                            JOIN actsem ON actsem.actsemNo = activity.actSem
                                            WHERE activity.actStatus='เสร็จสิ้นกิจกรรม' && activity.actOrgtion='$org' 
                                            ORDER BY activity.actDateb DESC
                                              ");
                  $stmt->execute();
                  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                ?>
                    <tr>
                      <td><?php echo $row['actsem']; ?>/<?php echo $row['actYear']; ?></td>
                      <td><a href="" data-toggle="modal" data-target="#modalmoreinfo" data-id="<?php echo $row['actID']; ?>" id="moreinfo"><?php echo $row['actID']; ?></a></td>
                      <td><?php echo $row['actName']; ?></td>
                      <td><?php echo $row['acttypeName']; ?></td>
                      <td><?php echo $row['mainorg']; ?></td>
                      <td><?php echo $row['organization']; ?></td>
                      <td>
                        <a class="btn btn-sm btn-danger" href="?actfinished_id=<?php echo $row['actNo']; ?>" title="ปลดล็อคกิจกรรมนี้" onclick="return confirm('ต้องการปลดล็อคกิจกรรมนี้ ?')"><span class="fa fa-edit"></span> ปลดล็อค</a>
                      </td>
                    </tr>
                  <?php
                  }
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

        var actid = $(this).data('id'); // it will get id of clicked row

        $('#dynamic-content').html(''); // leave it blank before ajax call
        $('#modal-loader').show(); // load ajax loader

        $.ajax({
            url: 'moreactinfo.php',
            type: 'POST',
            data: 'id=' + actid,
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