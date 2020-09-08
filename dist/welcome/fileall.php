
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name=”viewport” content=”width=device-width, maximum-scale=1, minimum-scale=0.5″ />    
  <meta name="google-site-verification" content="">

  <title>ระบบกิจกรรมนักศึกษา| เอกสาร</title>
  <!-- GLOBAL MAINLY STYLES-->
  <link href="../assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="../assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
  <link href="../assets/vendors/themify-icons/css/themify-icons.css" rel="stylesheet" />
  <!-- PLUGINS STYLES-->
  <link href="../assets/vendors/select2/dist/css/select2.min.css" rel="stylesheet" />
  <link href="../assets/vendors/DataTables/datatables.min.css" rel="stylesheet" />
  <link href="../assets/vendors/jvectormap/jquery-jvectormap-2.0.3.css" rel="stylesheet" />
  <!-- THEME STYLES-->
  <link href="../assets/css/main.min.css" rel="stylesheet" />
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
  <header class="header">
    <div class="flexbox flex-1" style="background-color:#528124;color:#FFFFFF;">
      <!-- START TOP-RIGHT TOOLBAR-->
      <ul class="nav navbar-toolbar">
      <li>
                        <div><a href="http://www.ftu.ac.th/2019/index.php/th/"><img src="../assets/img/head-ftu.png" width="140" height="40"/></a></div></li>
                    <li>
        <li>
        <h4 style="padding-left: 10px;"><a href="home.php"style="color:#FFFFFF;">ระบบกิจกรรมนักศึกษามหาวิทยาลัยฟาฏอนี</a></h4>
        </li>
      </ul>
      <ul class="nav navbar-toolbar ml-auto">
        <li class="dropdown dropdown-user">
          <div class="language">
            <div class="google">
              <div id="google_translate_element">
                <div class="skiptranslate goog-te-gadget" dir="ltr" >
                  <div id=":0.targetLanguage" class="goog-te-gadget-simple" style="white-space: nowrap;"><img src="https://www.google.com/images/cleardot.gif" class="goog-te-gadget-icon" alt="" style="background-image: url(&quot;https://translate.googleapis.com/translate_static/img/te_ctrl3.gif&quot;); background-position: -65px 0px;"><span style="vertical-align: middle;"><a aria-haspopup="true" class="goog-te-menu-value" href="javascript:void(0)"><span>เลือกภาษา</span><img src="https://www.google.com/images/cleardot.gif" alt="" width="1" height="1"><span style="border-left: 1px solid rgb(187, 187, 187);">​</span><img src="https://www.google.com/images/cleardot.gif" alt="" width="1" height="1"><span aria-hidden="true" style="color: rgb(118, 118, 118);">▼</span></a></span></div>
                </div>
              </div>
              <script type="text/javascript">
                function googleTranslateElementInit() {
                  new google.translate.TranslateElement({
                    pageLanguage: 'th',
                    includedLanguages: 'zh-CN,de,id,km,lo,ms,my,th,tl,vi,th,en',
                    layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
                    multilanguagePage: true
                  }, 'google_translate_element');
                }
              </script>
              <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
            </div>
          </div>
        </li>
        <li class="dropdown dropdown-user">
          <a class="nav-link dropdown-toggle link" href="contact.php" style="font-size: 16px;color:#FFFFFF;">ติดต่อ</a>
        </li>
        <li class="dropdown dropdown-user">
          <a class="nav-link dropdown-toggle link" data-toggle="dropdown" style="font-size: 16px;color:#FFFFFF;">
            <span></span>เข้าสู่ระบบ<i class="fa fa-angle-down m-l-5"></i></a>
          <ul class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="../admin/Mlogin/login.php" style="color:#528124;"><i class="fa fa-user"></i>เจ้าหน้าที่</a>
            <li class="dropdown-divider"></li>
            <a class="dropdown-item" href="../student/Mlogin/login.php" style="color:#528124;"><i class="fa fa-child"></i>นักศึกษา</a>
          </ul>
        </li>
      </ul>
      <!-- END TOP-RIGHT TOOLBAR-->
    </div>
  </header>
  <div class="content-wrapper pb-2" style="background-color:#f4f4fc;">
  <div class="page-content fade-in-up" style="padding:20px;padding-top:0px">
    <div class="page-heading">
      <h1 class="page-title"style="color:#528124;">ไฟล์เอกสารทั้งหมด</h1>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
        </li>
        <li class="breadcrumb-item"><a href="home.php">หน้าแรก</a></li>
        <li class="breadcrumb-item">ไฟล์เอกสารทั้งหมด</li>
      </ol>
    </div>
    <br>
    <b><hr style="margin-top: 0rem;border-color:#528124;border-width: 2px;"></b>

    <div class="row ml-1 mr-1">
      <div class="col-12">
        <div class="card">
          <br>
          <div class="row">
            <div class="col-sm-12">
              <table class="table table-hover table-striped ">
                <tbody>
                  <?php
                  require_once '../db/dbconfig.php';
                  $stmt = $DBcon->prepare("SELECT * FROM file ORDER BY fileNo DESC");
                  $stmt->execute();
                  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                  ?>
                    <tr>
                      <td style="font-size:14px;"><a href="../admin/file/<?php echo $row['fileDoc']; ?>"><span class="fa fa-edit"></span>&nbsp; <?php echo $row['fileName']; ?></a></td>
                    </tr>
                  <?php
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
          <br>
        </div>
        <!-- /.card-body -->
        <!-- /.card -->
      </div>
    </div>
  </div>
  </div>

  <!-- BEGIN PAGA BACKDROPS-->
  <!-- END PAGA BACKDROPS-->
  <!-- CORE PLUGINS-->
  <script src="../assets/vendors/jquery/dist/jquery.min.js" type="text/javascript"></script>
  <script src="../assets/vendors/popper.js/dist/umd/popper.min.js" type="text/javascript"></script>
  <script src="../assets/vendors/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>
  <script src="../assets/vendors/metisMenu/dist/metisMenu.min.js" type="text/javascript"></script>
  <script src="../assets/vendors/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
  <!-- PAGE LEVEL PLUGINS-->
  <script src="../assets/vendors/select2/dist/js/select2.full.min.js" type="text/javascript"></script>
  <script src="../assets/vendors/jquery.maskedinput/dist/jquery.maskedinput.min.js" type="text/javascript"></script>
  <script src="../assets/vendors/jquery-validation/dist/jquery.validate.min.js" type="text/javascript"></script>
  <script src="../assets/vendors/DataTables/datatables.min.js" type="text/javascript"></script>
  <!-- CORE SCRIPTS-->
  <script src="../assets/js/app.min.js" type="text/javascript"></script>
  <!-- PAGE LEVEL SCRIPTS-->
  <script src="../assets/js/scripts/form-plugins.js" type="text/javascript"></script>
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