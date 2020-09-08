<?php
require_once("../class/session.php");

require_once("../class/class.organizer.php");
$auth_orgzer = new ORGANIZER();

$orgzerID = $_SESSION['orgzer_session'];

$stmt = $auth_orgzer->runQuery("SELECT organizer.*, mainorg.*,organization.*, usertype.* FROM organizer
    JOIN usertype ON organizer.orgzeruserType = usertype.usertypeID 
    JOIN mainorg ON organizer.orgzerMainorg = mainorg.mainorgNo 
    JOIN organization ON organizer.orgzerOrgtion = organization.orgtionNo 
    WHERE orgzerID=:orgzerID");
$stmt->execute(array(":orgzerID" => $orgzerID));

$orgzerRow = $stmt->fetch(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width initial-scale=1.0">
    <title>ระบบกิจกรรมนักศึกษา| ข้อมูลส่วนตัว</title>
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
            <h1 class="page-title">ข้อมูลส่วนตัว</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                </li>
                <li class="breadcrumb-item">ข้อมูลส่วนตัว</li>
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
            <div class="col-lg-3 col-md-4">
                <div class="ibox">
                    <div class="ibox-body text-center">
                        <div class="m-t-20">
                            <img class="img-circle" src="../../assets/img/<?php echo $orgzerRow['orgzerImage']; ?>" />
                        </div>
                        <h6 class="font-strong m-b-10 m-t-10"><?php echo $orgzerRow['orgzerName']; ?></h6>
                        <div class="m-b-20 text-muted"><?php echo $orgzerRow['userType']; ?></div>
                        <a href="updateprofile.php?update_id=<?php echo $orgzerRow['orgzerID']; ?>" title="แก้ไขข้อมูลส่วนตัว" onclick="return confirm('ต้องการแก้ไขข้อมูลส่วนตัว ?')"><button class="btn btn-warning btn-sm m-r-5 btn-fix" data-toggle="tooltip" ><i class="fa fa-pencil font-30"></i> แก้ไขข้อมูลส่วนตัว</button></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-md-8">
                <div class="ibox">
                    <div class="ibox-body">
                        <div class="row justify-content-center">
                            <h1 class="m-t-10 m-b-10 font-strong">ข้อมูลส่วนตัว</h1>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-10">
                                <ul class="list-group list-group-full list-group-divider">
                                    <li class="list-group-item">รหัสผู้ใช้
                                        <a href="javascript:;"><span class="pull-right "><?php echo $orgzerRow['orgzerID']; ?></span></a>
                                    </li>
                                    <li class="list-group-item">ชื่อ-สกุล
                                        <a href="javascript:;"><span class="pull-right "><?php echo $orgzerRow['orgzerName']; ?></span></a>
                                    </li>
                                    <li class="list-group-item">สถานะ
                                        <a href="javascript:;"><span class="pull-right "><?php echo $orgzerRow['userType']; ?></span></a>
                                    </li>
                                    <li class="list-group-item">กลุ่ม
                                        <a href="javascript:;"><span class="pull-right "><?php echo $orgzerRow['orgzerGroup']; ?></span></a>
                                    </li>
                                    <li class="list-group-item">ระดับ
                                        <a href="javascript:;"><span class="pull-right "><?php echo $orgzerRow['orgzerSec']; ?></span></a>
                                    </li>
                                    <li class="list-group-item">สังกัด
                                        <a href="javascript:;"><span class="pull-right "><?php echo $orgzerRow['mainorg']; ?></span></a>
                                    </li>
                                    <li class="list-group-item">องค์กร
                                        <a href="javascript:;"><span class="pull-right "><?php echo $orgzerRow['organization']; ?></span></a>
                                    </li>
                                    <li class="list-group-item">หมายเลขโทรศัพท์
                                        <a href="javascript:;"><span class="pull-right "><?php echo $orgzerRow['orgzerPhone']; ?></span></a>
                                    </li>
                                    <li class="list-group-item">Email
                                        <a href="javascript:;"><span class="pull-right "><?php echo $orgzerRow['orgzerEmail']; ?></span></a>
                                    </li>
                                    <li class="list-group-item">Facebook
                                        <a href="javascript:;"><span class="pull-right "><?php echo $orgzerRow['orgzerFb']; ?></span></a>
                                    </li>
                                    <li class="list-group-item">Password
                                        <a href="javascript:;"><span class="pull-right "><?php echo $orgzerRow['orgzerPassword']; ?></span></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <style>
            .profile-social a {
                font-size: 16px;
                margin: 0 10px;
                color: #999;
            }

            .profile-social a:hover {
                color: #485b6f;
            }

            .profile-stat-count {
                font-size: 22px
            }
        </style>
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
            $('#tbboard').DataTable({
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

                var orgzerid = $(this).data('id'); // it will get id of clicked row

                $('#dynamic-content').html(''); // leave it blank before ajax call
                $('#modal-loader').show(); // load ajax loader

                $.ajax({
                        url: 'moreinfo.php',
                        type: 'POST',
                        data: 'id=' + orgzerid,
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