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
require_once '../../db/dbconfig.php';
if (isset($_GET['delete_id'])) {
  $stmt_select = $DBcon->prepare('SELECT stdImage FROM student WHERE stdID =:stdID');
  $stmt_select->execute(array(':stdID' => $_GET['delete_id']));
  $stdImageRow = $stmt_select->fetch(PDO::FETCH_ASSOC);

  unlink("../../assets/img/profile/" . $stdImageRow['stdImage']);

  // it will delete an actual record from db
  $stmt_delete = $DBcon->prepare('DELETE FROM student WHERE stdID =:stdID');
  $stmt_delete->bindParam(':stdID', $_GET['delete_id']);
  $stmt_delete->execute();

  header("Location: studentall.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width initial-scale=1.0">
  <title>ระบบกิจกรรมนักศึกษา| จัดการรายชื่อนักศึกษา</title>
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

  <div class="page-content fade-in-up">
    <div class="page-heading">
      <h1 class="page-title">จัดการรายชื่อนักศึกษา</h1>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
        </li>
        <li class="breadcrumb-item">จัดการรายชื่อนักศึกษา</li>
      </ol>
    </div>
    <br>
    <?php
    $sql = "SELECT orgzerSec FROM organizer WHERE orgzerID = '$studentAddby'";
    $result = mysqli_query($conn, $sql);
    mysqli_num_rows($result);
    // output data of each row
    $row = mysqli_fetch_assoc($result);
    ?>
    <?php
    if ($row["orgzerSec"] == "Admin") {
    ?>
      <a href="department.php"><button class="btn btn-info"  type="button"> <span class="fa fa-pencil"></span> &nbsp; จัดการสาขา</button></a>&nbsp;&nbsp;
      <a href="teacher.php"><button class="btn btn-info"  type="button"> <span class="fa fa-pencil"></span> &nbsp; จัดการรายชื่ออาจารย์</button></a>&nbsp;&nbsp;
      <a href="faculty.php"><button class="btn btn-info"  type="button"> <span class="fa fa-pencil"></span> &nbsp; จัดการคณะ</button></a>
      <br>

    <?php
    }
    if ($row["orgzerSec"] == "คณะ") {
    ?>
      <a href="department.php"><button class="btn btn-info"  type="button"> <span class="fa fa-pencil"></span> &nbsp; จัดการสาขา</button></a>&nbsp;&nbsp;
      <a href="teacher.php"><button class="btn btn-info"  type="button"> <span class="fa fa-pencil"></span> &nbsp; จัดการรายชื่ออาจารย์</button></a>&nbsp;&nbsp;
      <br>

    <?php
    }
    ?>
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
    <div class="row justify-content-center">
      <div class="col-sm-10 ">
        <div class="ibox">
          <div class="ibox-body">
            <form>
              <div class="form-group row">
                <div class="col-sm-6">
                  <select class="form-control select2_demo_1" style="width: 100%;" name="stdfct" id="stdFct" onChange="getdpm(this.value);" required>
                    <?php
                    $sql = "SELECT orgzerSec FROM organizer WHERE orgzerID = '$studentAddby'";
                    $result = mysqli_query($conn, $sql);
                    mysqli_num_rows($result);
                    // output data of each row
                    $row = mysqli_fetch_assoc($result);
                    ?>
                    <?php
                    if ($row["orgzerSec"] == "Admin") {
                      $sql = "SELECT mainorg.*, faculty.* FROM faculty
                            JOIN mainorg ON faculty.faculty = mainorg.mainorgNo ORDER BY faculty DESC";
                      $result = $conn->query($sql);
                    ?>
                      <option selected="selected" disabled="disabled">--คณะ--</option>
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
                      <option selected="selected" disabled="disabled">--คณะ--</option>
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
                    <option selected="selected" disabled="disabled">--สาขา--</option>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-6">
                  <select class="form-control select2_demo_1" style="width: 100%;" name="stdYear" required>
                    <option selected="selected" disabled="disabled">--ปีการศึกษา--</option>
                    <?php
                    function DateThai($strDate)
                    {
                      $strYear = date("Y", strtotime($strDate)) + 544;
                      return "$strYear";
                    }
                    $strDate = date("Y");
                    for ($i = 2563; $i < DateThai($strDate); $i++) {
                      echo "<option>$i</option>";
                    }

                    ?>
                  </select>
                </div>
                <div class="col-sm-6">
                  <select class="form-control select2_demo_1" style="width: 100%;" name="stdGroup" required>
                    <option selected="selected" disabled="disabled">--กลุ่ม--</option>
                    <option value="ทั้งหมด">ทั้งหมด</option>
                    <option value="ชาย">ชาย</option>
                    <option value="หญิง">หญิง</option>
                  </select>
                </div>
              </div>
              <br>
              <div class="form-group ">
                <div class="col-sm-12 text-center">
                  <button class="btn btn-primary" onChange="search(this.value);">ค้นหา</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <br>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header" style="background-color:#2a9d8f">
            <h5 style="color:white">ตารางรายชื่อนักศึกษา</h5>
          </div>
          <!-- /.card-header -->
          <div class="card-body text-nowrap">
            <table id="tbstudentall" class="table table-hover-sm table-striped text-center" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th>ประจำปีการศึกษา</th>
                  <th>รหัสนักศึกษา</th>
                  <th>ชื่อ-สกุล</th>
                  <th>สาขา</th>
                  <th>กลุ่ม</th>
                  <th>Email</th>
                  <th>รหัสผ่าน</th>
                  <th>แก้ไข</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $sql = "SELECT orgzerSec,orgzerMainorg FROM organizer WHERE orgzerID = '$studentAddby'";
                $result = mysqli_query($conn, $sql);
                mysqli_num_rows($result);
                // output data of each row
                $row = mysqli_fetch_assoc($result);
                ?>
                <?php
                if ($row["orgzerSec"] == "Admin") {
                  require_once '../../db/dbconfig.php';
                  $stmt = $DBcon->prepare("SELECT student.*,department.* FROM student 
                  JOIN department ON department.dpmNo =student.stdDpm
                  ORDER BY student.stdID DESC");
                  $stmt->execute();
                  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                ?>
                    <tr>
                      <td><?php echo $row['stdYear']; ?></td>
                      <td><a href="" data-toggle="modal" data-target="#modalmoreinfo" data-id="<?php echo $row['stdID']; ?>" id="moreinfo"><?php echo $row['stdID']; ?></a></td>
                      <td><?php echo $row['stdName']; ?></td>
                      <td><?php echo $row['department']; ?></td>
                      <td><?php echo $row['stdGroup']; ?></td>
                      <td><?php echo $row['stdEmail']; ?></td>
                      <td><?php echo $row['stdPassword']; ?></td>
                      <td>
                        <a href="studentallupdateinfo.php?update_id=<?php echo $row['stdID']; ?>" title="แก้ไขรายชื่อนักศึกษา" onclick="return confirm('ต้องการแก้ไขรายชื่อนักศึกษา ?')"><button class="btn btn-warning btn-sm m-r-5" data-toggle="tooltip" ><i class="fa fa-pencil font-30"></i></button></a>
                      </td>
                    </tr>
                  <?php
                  }
                }
                if ($row["orgzerSec"] == "คณะ") {
                  $org = $row['orgzerMainorg'];
                  require_once '../../db/dbconfig.php';
                  $stmt = $DBcon->prepare("SELECT student.*,department.* FROM student 
                  JOIN department ON department.dpmNo = student.stdDpm
                  WHERE student.stdFct = '$org' ORDER BY student.stdID DESC");
                  $stmt->execute();
                  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                  ?>
                    <tr>
                      <td><?php echo $row['stdYear']; ?></td>
                      <td><a href="" data-toggle="modal" data-target="#modalmoreinfo" data-id="<?php echo $row['stdID']; ?>" id="moreinfo"><?php echo $row['stdID']; ?></a></td>
                      <td><?php echo $row['stdName']; ?></td>
                      <td><?php echo $row['department']; ?></td>
                      <td><?php echo $row['stdGroup']; ?></td>
                      <td><?php echo $row['stdEmail']; ?></td>
                      <td><?php echo $row['stdPassword']; ?></td>
                      <td>
                        <a href="studentallupdateinfo.php?update_id=<?php echo $row['stdID']; ?>" title="แก้ไขรายชื่อนักศึกษา" onclick="return confirm('ต้องการแก้ไขรายชื่อนักศึกษา ?')"><button class="btn btn-warning btn-sm m-r-5" data-toggle="tooltip" ><i class="fa fa-pencil font-30"></i></button></a>
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
                  <h5 class="modal-title" id="exampleModalLongTitle">รายละเอียดเพิ่มเติม</h5>
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