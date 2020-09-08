<?php
require_once("../class/session.php");

require_once("../class/class.student.php");
$auth_std = new STUDENT();

$stdID = $_SESSION['std_session'];

$stmt = $auth_std->runQuery("SELECT student.*,department.*, teacher.*, faculty.*, mainorg.* FROM student 
JOIN department ON department.dpmNo = student.stdDpm
JOIN teacher ON teacher.teacherNo = student.stdTc
JOIN faculty ON faculty.faculty = student.stdFct
JOIN mainorg ON mainorg.mainorgNo = faculty.faculty
WHERE stdID=:stdID");
$stmt->execute(array(":stdID" => $stdID));

$stdRow = $stmt->fetch(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name=”viewport” content=”width=device-width, maximum-scale=1, minimum-scale=0.5″ />
  <meta name="google-site-verification" content="">

  <title>ระบบกิจกรรมนักศึกษา| เกี่ยวกับผู้พัฒนา</title>
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

    body.fixed-navbar .header {
      top: unset;
    }

    .sidebar-mini {
      margin-left: 0px;
    }

    .content-wrapper {
      margin-left: 0px;
    }
  </style>
</head>

<body class="fixed-navbar">

  <!-- Main content -->
  <div class="content-wrapper pb-2" style="background-color:#f4f4fc;">
    <div class="page-content fade-in-up" style="padding:20px;padding-top:0px">
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
      <div class="row ml-1 mr-1 justify-content-center">
        <div class="col-8">
          <div class="card" style="border-width:0px;border-top-width:4px;height:200px;">
            <div class="row justify-content-center">
              <div class="col-sm-12">
                <div class="card-body"style="text-align:center;">
                  <h1>Hi</h1>
                  <h3>I am <b style="color:#528124;">KHOYR</b> Khoyreeyah Tan-e-no</h3>
                  <h4>IT student of Fatoni University, This is my Final project</h4>
                  <h4 style="color:#528124;">ENJOY IT:)</h4>
                </div>
              </div>
            </div>
            <br>
          </div>
          <!-- /.card-header -->
          <!-- /.card-body -->
          <!-- /.card -->
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

      $(document).on('click', '#newsinfo', function(e) {

        e.preventDefault();

        var newsNo = $(this).data('id'); // it will get id of clicked row

        $('#dynamic-content').html(''); // leave it blank before ajax call
        $('#modal-loader').show(); // load ajax loader

        $.ajax({
            url: 'morenewsinfo.php',
            type: 'POST',
            data: 'id=' + newsNo,
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