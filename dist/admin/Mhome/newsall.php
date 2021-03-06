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
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width initial-scale=1.0">
  <title>ระบบกิจกรรมนักศึกษา| ข่าวประชาสัมพันธ์</title>
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
      <h1 class="page-title"style="color:#528124;">ข่าวประชาสัมพันธ์ทั้งหมด</h1>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
        </li>
        <li class="breadcrumb-item"><a href="home.php">หน้าแรก</a></li>
        <li class="breadcrumb-item">ข่าวประชาสัมพันธ์ทั้งหมด</li>
      </ol>
    </div>
    <br>
    <b><hr style="margin-top: 0rem;border-color:#528124;border-width: 2px;"></b>

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
    <div class="row ml-1 mr-1">
            <div class="col-12">
            <nav class="navbar navbar-light justify-content-between mb-0 pb-0 pr-0 pl-0  ">
                </nav>
                <div class="card"style="border-width:0px;border-top-width:4px;">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card-deck">
                                <?php
                                require_once '../../db/dbconfig.php';
                                $stmt = $DBcon->prepare("SELECT *  FROM news  ORDER BY newsNo DESC");
                                $stmt->execute();
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    $newsStatus  = $row["newsStatus"];
                                    $newsImage   = $row['newsImage'];
                                    $newsTitle      = $row["newsTitle"];
                                ?>

                                    <div class="col-sm-3 mt-4">
                                        <div class="card m-2">
                                            <a type="button" data-toggle="modal" data-target="#modalnewsinfo" data-id="<?php echo $row['newsNo']; ?>" id="newsinfo"><img class="card-img-top p-2" src="../../assets/img/<?php echo $row['newsImage']; ?>" style="height: 100%;width:100%;background-color:#ebf2e6;" /></a>
                                            <div class="card-body"style="background-color:#528124;color:#FFFFFF;">
                                                <div><?php echo $newsTitle ?></div>
                                            </div>
                                            <div class="modal fade" id="modalnewsinfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content ">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLongTitle"style="color:#417d19;">รายละเอียดเพิ่มเติม</h5>
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
                                    </div>
                                <?php } ?>
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