
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name=”viewport” content=”width=device-width, maximum-scale=1, minimum-scale=0.5″ />    
  <meta name="google-site-verification" content="">
  <title>ระบบกิจกรรมนักศึกษา| ข่าวประชาสัมพันธ์</title>
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
    .ibox {
            position: relative;
            margin-bottom: 25px;
            background-color: #fff;
            -webkit-box-shadow: 1px 1px 1px 1px rgba(1,1,1,.1);
            box-shadow: 1px 1px 1px 1px rgba(1,1,1,.1);
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
      <h1 class="page-title"style="color:#528124;">ติดต่อ</h1>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
        </li>
        <li class="breadcrumb-item"><a href="home.php">หน้าแรก</a></li>
        <li class="breadcrumb-item">ติดต่อ</li>
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
        <br>
        <div class="ibox">
    <div class="ibox-body"style="background-color:#FFFFFF; font-size:15px;">
    <span class="fa fa-home"style="color:#528124; font-size:18px;"> :</span>  สำนักพัฒนาศักยภาพนักศึกษา มหาวิทยาลัยฟาฏอนี ชั้น2 ณ อาคารเฉลิมพระเกียรติ มหาวิทยาลัยฟาฏอนี 135/8 ม.3 ต.เขาตูม อ.ยะรัง จ.ปัตตานี 94106
    <br><span class="fa fa-globe"style="color:#528124; font-size:18px;"> :</span> <a href="http://www.ftu.ac.th/2019/index.php/th/"> มหาวิทยาลัยฟาฏอนี</a>
  <br><span class="fa fa-facebook"style="color:#528124; font-size:18px;"> :</span> <a href="https://web.facebook.com/StudentAffairsFTU/"> สำนักพัฒนาศักยภาพนักศึกษา</a>
    <br><span class="fa fa-facebook"style="color:#528124; font-size:18px;"> :</span> <a href="https://web.facebook.com/StudentUnionOfFTU/"> องค์การบริหารนักศึกษาหญิง</a>
    <br><span class="fa fa-facebook"style="color:#528124; font-size:18px;"> :</span> <a href="https://web.facebook.com/StudentunionFTU/"> องค์การบริการนักศึกษาชาย</a>
    <br><span class="fa fa-phone"style="color:#528124; font-size:18px;"> :</span>  081-678-5532, 0-7341-8613
    </div>
        </div>
        <div class="row">
      <div class="col-12">
      <div class="card"style="border-width:0px;border-bottom-width:4px;border-right-width:4px;">
          <div class="card-header"style="background-color:#d1cbaf">
            <h5 style="color:#2c2c2c">ตารางรายชื่อเจ้าหน้าที่</h5>
          </div>
          <!-- /.card-header -->
          <div class="card-body text-nowrap">
            <table id="tbcontact" class="table table-hover-sm table-striped text-center" cellspacing="0" width="100%">
              <thead>
                <tr style="color:#528124;">
                  <th>ชื่อ-สกุล</th>
                  <th>กลุ่ม</th>
                  <th>สังกัด</th>
                  <th>องค์กร</th>
                  <th>หมายเลขโทรศัพท์</th>
                </tr>
              </thead>
              <tbody>
                <?php
                require_once '../db/dbconfig.php';
                $stmt = $DBcon->prepare("SELECT organizer.*, mainorg.*,organization.*, usertype.* FROM organizer
                                          JOIN usertype ON organizer.orgzeruserType = usertype.usertypeID 
                                          JOIN mainorg ON organizer.orgzerMainorg = mainorg.mainorgNo 
                                          JOIN organization ON organizer.orgzerOrgtion = organization.orgtionNo  ORDER BY orgzerID DESC");
                $stmt->execute();
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                ?>
                  <tr>
                    <td><a href="javascript:;"><?php echo $row['orgzerName']; ?></a></td>
                    <td><?php echo $row['orgzerGroup']; ?></td>
                    <td><?php echo $row['mainorg']; ?></td>
                    <td><?php echo $row['organization']; ?></td>
                    <td><?php echo $row['orgzerPhone']; ?></td>
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