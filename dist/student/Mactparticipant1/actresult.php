<?php
session_start();
if (!isset($_SESSION['stdName']) && ($_SESSION['stdID'])) {
    header('location: ../../');
    echo "กรุณาเข้าสู่ระบบ!";
} else {
}
include '../../db/dbcon.php';
$stdID = $_SESSION['stdID'];
?>

<?php
require_once '../../db/dbconfig.php';
if (isset($_GET['delete_id'])) {
    // it will delete an actual record from db
    $stmt_delete = $DBcon->prepare('DELETE FROM activity WHERE actNo =:actno');
    $stmt_delete->bindParam(':actno', $_GET['delete_id']);
    $stmt_delete->execute();

    header("Location: act.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width initial-scale=1.0">
    <title>ระบบกิจกรรมนักศึกษา| สถานะกิจกรรม</title>
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
            <h1 class="page-title">สถานะกิจกรรม</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                </li>
                <li class="breadcrumb-item">สถานะกิจกรรม</li>
            </ol>
        </div>
        <br>

        <div class="row">
            <div class="col-12">
                <div class="ibox">
                    <div class="ibox-body">
                        <ul class="nav nav-tabs tabs-line">
                            <li class="nav-item">
                                <a class="nav-link active" href="#tab-1" data-toggle="tab">ชั้นปีที่1</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#tab-2" data-toggle="tab"> ชั้นปีที่2</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#tab-3" data-toggle="tab"> ชั้นปีที่3</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#tab-4" data-toggle="tab"> ชั้นปีที่4</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="tab-1">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <!-- /.card-header -->

                                            <div class="card-body text-nowrap">
                                                <table id="tbact1" class="table table-condensed  text-center">
                                                    <thead>
                                                        <tr>
                                                            <th>หมวดกิจกรรม</th>
                                                            <th>ช่วงเวลา</th>
                                                            <th>จำนวนครั้งที่จัด</th>
                                                            <th>จำนวนครั้งที่เข้าร่วม</th>
                                                            <th>ผลการประเมิน</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>ฮาลาเกาะห์</td>
                                                            <td>ภาคเรียนที่1</td>
                                                            <td><a href="javascript:;">2</a></td>
                                                            <td><a href="javascript:;">0</a></td>
                                                            <td><i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i></td>
                                                        </tr>
                                                        <tr>
                                                            <td>ฮาลาเกาะห์</td>
                                                            <td>ภาคเรียนที่2</td>
                                                            <td><a href="javascript:;">2</a></td>
                                                            <td><a href="javascript:;">1</a></td>
                                                            <td><i class="fa fa-check text-success"><b>ผ่าน</b></i></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- /.card-body -->
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="tab-pane fade" id="tab-2">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <!-- /.card-header -->

                                            <div class="card-body text-nowrap">
                                                <table id="tbact2" class="table table-condensed  text-center">
                                                    <thead>
                                                        <tr>
                                                            <th>หมวดกิจกรรม</th>
                                                            <th>ช่วงเวลา</th>
                                                            <th>จำนวนครั้งที่จัด</th>
                                                            <th>จำนวนครั้งที่เข้าร่วม</th>
                                                            <th>ผลการประเมิน</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>ฮาลาเกาะห์</td>
                                                            <td>ภาคเรียนที่1</td>
                                                            <td><a href="javascript:;">2</a></td>
                                                            <td><a href="javascript:;">0</a></td>
                                                            <td><i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i></td>
                                                        </tr>
                                                        <tr>
                                                            <td>ฮาลาเกาะห์</td>
                                                            <td>ภาคเรียนที่2</td>
                                                            <td><a href="javascript:;">2</a></td>
                                                            <td><a href="javascript:;">1</a></td>
                                                            <td><i class="fa fa-check text-success"><b>ผ่าน</b></i></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- /.card-body -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="tab-3">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <!-- /.card-header -->

                                            <div class="card-body text-nowrap">
                                                <table id="tbact3" class="table table-condensed  text-center">
                                                    <thead>
                                                        <tr>
                                                            <th>หมวดกิจกรรม</th>
                                                            <th>ช่วงเวลา</th>
                                                            <th>จำนวนครั้งที่จัด</th>
                                                            <th>จำนวนครั้งที่เข้าร่วม</th>
                                                            <th>ผลการประเมิน</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>ฮาลาเกาะห์</td>
                                                            <td>ภาคเรียนที่1</td>
                                                            <td><a href="javascript:;">2</a></td>
                                                            <td><a href="javascript:;">0</a></td>
                                                            <td><i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i></td>
                                                        </tr>
                                                        <tr>
                                                            <td>ฮาลาเกาะห์</td>
                                                            <td>ภาคเรียนที่2</td>
                                                            <td><a href="javascript:;">2</a></td>
                                                            <td><a href="javascript:;">1</a></td>
                                                            <td><i class="fa fa-check text-success"><b>ผ่าน</b></i></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- /.card-body -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="tab-4">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <!-- /.card-header -->

                                            <div class="card-body text-nowrap">
                                                <table id="tbact1" class="table table-condensed  text-center">
                                                    <thead>
                                                        <tr>
                                                            <th>หมวดกิจกรรม</th>
                                                            <th>ช่วงเวลา</th>
                                                            <th>จำนวนครั้งที่จัด</th>
                                                            <th>จำนวนครั้งที่เข้าร่วม</th>
                                                            <th>ผลการประเมิน</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>ฮาลาเกาะห์</td>
                                                            <td>ภาคเรียนที่1</td>
                                                            <td><a href="javascript:;">2</a></td>
                                                            <td><a href="javascript:;">0</a></td>
                                                            <td><i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i></td>
                                                        </tr>
                                                        <tr>
                                                            <td>ฮาลาเกาะห์</td>
                                                            <td>ภาคเรียนที่2</td>
                                                            <td><a href="javascript:;">2</a></td>
                                                            <td><a href="javascript:;">1</a></td>
                                                            <td><i class="fa fa-check text-success"><b>ผ่าน</b></i></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- /.card-body -->
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
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
            $('#tbhal').DataTable({
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
            $('#tbqiyam').DataTable({
                pageLength: 10,
                "scrollX": true
            });
            $('#tbcamp').DataTable({
                pageLength: 10,
                "scrollX": true
            });
            $('#tbitiqaf').DataTable({
                pageLength: 10,
                "scrollX": true
            });
            $('#tbpathom').DataTable({
                pageLength: 10,
                "scrollX": true
            });
            $('#tbpajchim').DataTable({
                pageLength: 10,
                "scrollX": true
            });
            $('#tbuniclub').DataTable({
                pageLength: 10,
                "scrollX": true
            });
            $('#tbfctclub').DataTable({
                pageLength: 10,
                "scrollX": true
            });
            $('#tbakhlaq').DataTable({
                pageLength: 10,
                "scrollX": true
            });
            $('#tbhal2').DataTable({
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
            $('#tbqiyam2').DataTable({
                pageLength: 10,
                "scrollX": true
            });
            $('#tbcamp2').DataTable({
                pageLength: 10,
                "scrollX": true
            });
            $('#tbitiqaf2').DataTable({
                pageLength: 10,
                "scrollX": true
            });
            $('#tbpajchim2').DataTable({
                pageLength: 10,
                "scrollX": true
            });
            $('#tbuniclub2').DataTable({
                pageLength: 10,
                "scrollX": true
            });
            $('#tbfctclub2').DataTable({
                pageLength: 10,
                "scrollX": true
            });
            $('#tbakhlaq2').DataTable({
                pageLength: 10,
                "scrollX": true
            });
            $('#tbhal3').DataTable({
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
            $('#tbqiyam3').DataTable({
                pageLength: 10,
                "scrollX": true
            });
            $('#tbcamp3').DataTable({
                pageLength: 10,
                "scrollX": true
            });
            $('#tbitiqaf3').DataTable({
                pageLength: 10,
                "scrollX": true
            });
            $('#tbpathom3').DataTable({
                pageLength: 10,
                "scrollX": true
            });
            $('#tbpajchim3').DataTable({
                pageLength: 10,
                "scrollX": true
            });
            $('#tbuniclub3').DataTable({
                pageLength: 10,
                "scrollX": true
            });
            $('#tbfctclub3').DataTable({
                pageLength: 10,
                "scrollX": true
            });
            $('#tbakhlaq3').DataTable({
                pageLength: 10,
                "scrollX": true
            });
            $('#tbhal4').DataTable({
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
            $('#tbqiyam4').DataTable({
                pageLength: 10,
                "scrollX": true
            });
            $('#tbcamp4').DataTable({
                pageLength: 10,
                "scrollX": true
            });
            $('#tbitiqaf4').DataTable({
                pageLength: 10,
                "scrollX": true
            });
            $('#tbpathom4').DataTable({
                pageLength: 10,
                "scrollX": true
            });
            $('#tbpajchim4').DataTable({
                pageLength: 10,
                "scrollX": true
            });
            $('#tbuniclub4').DataTable({
                pageLength: 10,
                "scrollX": true
            });
            $('#tbfctclub4').DataTable({
                pageLength: 10,
                "scrollX": true
            });
            $('#tbakhlaq4').DataTable({
                pageLength: 10,
                "scrollX": true
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