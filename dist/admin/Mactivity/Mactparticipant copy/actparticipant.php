<?php
session_start();
if (!isset($_SESSION['stdName']) && ($_SESSION['stdID'])) {
    header('location: ../../welcome/home.php');
    echo "กรุณาเข้าสู่ระบบ!";
} else {
}
include '../../db/dbcon.php';
$stdUser = $_SESSION['stdID'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width initial-scale=1.0">
    <title>ระบบกิจกรรมนักศึกษา| การเข้าร่วมกิจกรรม</title>
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
            <h1 class="page-title">การเข้าร่วมกิจกรรม</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                </li>
                <li class="breadcrumb-item">การเข้าร่วมกิจกรรม</li>
            </ol>
        </div>
        <br>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body ">
                        <ul class="nav nav-tabs ">
                            <li class="nav-item">
                                <a class="nav-link active" href="#pill-1-1" data-toggle="tab">
                                    <h5><?php echo $stdUser; ?></h5>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " href="#pill-1-2" data-toggle="tab">
                                    <h5>กิจกรรมของฉัน</h5>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="pill-1-1">
                                <div class="row justify-content-center">
                                    <div class="col-md-6">
                                        <h5 class="m-t-10 m-b-10 font-strong"></h5>
                                        <ul class="list-group list-group-full list-group-divider">
                                        <?php
                                        require_once '../../db/dbconfig.php';
                                        $stmt = $DBcon->prepare("SELECT student.*, department.*,faculty.*, mainorg.*  FROM actregister
                                        JOIN student ON student.stdID = actregister.actregstdID
                                        JOIN department ON department.dpmNo = student.stdDpm
                                        JOIN activity ON activity.actID = actregister.actregactID
                                        WHERE actregister.actregactID='$id'
                                        ORDER BY actregister.actregNo DESC
                                          ");
                                        $stmt->execute();
                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        ?>
                                            <li class="list-group-item "><?php echo $row['stdID']; ?></li>
                                            <li class="list-group-item">2. Dapibus ac facilisis in
                                                <span class="badge badge-warning badge-square float-right">4</span>
                                            </li>
                                            <li class="list-group-item">3. Morbi leo risus</li>
                                            <li class="list-group-item disabled">4. Disabled item
                                                <span class="badge badge-danger badge-square float-right">HOT</span>
                                            </li>
                                            <li class="list-group-item">5. Vestibulum at eros
                                                <span class="badge badge-info float-right">3</span>
                                            </li>
                                            <?php
                                        }
                                        ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="pill-1-2">
                                <table id="tbact" class="table table-hover table-striped text-left" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>รหัสนักศึกษา</th>
                                            <th>ชื่อ-สกุล</th>
                                            <th>สาขา</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        require_once '../../db/dbconfig.php';
                                        $stmt = $DBcon->prepare("SELECT activity.*, student.*, department.*  FROM actregister
                                        JOIN student ON student.stdID = actregister.actregstdID
                                        JOIN department ON department.dpmNo = student.stdDpm
                                        JOIN activity ON activity.actID = actregister.actregactID
                                        WHERE actregister.actregactID='$id'
                                        ORDER BY actregister.actregNo DESC
                                          ");
                                        $stmt->execute();
                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        ?>
                                            <tr>
                                                <td><?php echo $row['stdID']; ?></td>
                                                <td><?php echo $row['stdName']; ?></td>
                                                <td><?php echo $row['department']; ?></td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="modal fade" id="modalactmoreinfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content ">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle"></h5>
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
    <script src="../../assets/vendors/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>

    <!-- CORE SCRIPTS-->
    <script src="../../assets/js/app.min.js" type="text/javascript"></script>
    <!-- PAGE LEVEL SCRIPTS-->
    <script src="../../assets/js/scripts/form-plugins.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(function() {
            $('#tbact').DataTable({
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

            $(document).on('click', '#actmoreinfo', function(e) {

                e.preventDefault();

                var actID = $(this).data('id'); // it will get id of clicked row

                $('#dynamic-content').html(''); // leave it blank before ajax call
                $('#modal-loader').show(); // load ajax loader

                $.ajax({
                        url: 'actmoreinfo.php',
                        type: 'POST',
                        data: 'id=' + actID,
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