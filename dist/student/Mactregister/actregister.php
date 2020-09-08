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
<?php
error_reporting(~E_NOTICE); // avoid notice
require_once 'dbconfig.php';

if (isset($_GET['actreg_id'])) {
    $actid = $_GET['actreg_id'];
    //check username
    if ($actid && $stdUser != "") {
        include '../../db/dbcon.php';

        $cesql = "SELECT * FROM actregister WHERE actregactID='$actid' && actregstdID='$stdUser'";
        $checkexist = mysqli_query($conn, $cesql);
        if (mysqli_num_rows($checkexist)) {


            $errMSG = "รายชื่อนี้ได้ทำการลงทะเบียนแล้ว";
        }
    }

    // if no error occured, continue ....
    if (!isset($errMSG)) {
        $stmt = $DB_con->prepare('INSERT INTO actregister(actregactID,actregstdID,actregStatus) VALUES
                                                        (:actregactID,:actregstdID,"รอยืนยันการเข้าร่วม")');
        $stmt->bindParam(':actregactID', $actid);
        $stmt->bindParam(':actregstdID', $stdUser);
        if ($stmt->execute()) {
            $successMSG = "ทำการลงทะเบียนสำเร็จ";
            header("refresh:2;actregister.php");
        } else {
            $errMSG = "พบข้อผิดพลาด";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width initial-scale=1.0">
    <title>ระบบกิจกรรมนักศึกษา| ลงทะเบียนกิจกรรม</title>
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
                    $("#dpm").html(data);
                }
            });
        }
    </script>
</head>

<body class="fixed-navbar">

    <!-- Main content -->

    <div class="page-content fade-in-up" style="padding:20px;padding-top:0px">
        <div class="page-heading">
            <h1 class="page-title" style="color:#528124;">ลงทะเบียนกิจกรรม</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                </li>
                <li class="breadcrumb-item">ลงทะเบียนกิจกรรม</li>
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
        <br>
        <div class="row">
            <div class="col-12">
                <h3 style="color:#528124;">ตารางกิจกรรม</h3>
                <b><hr style="margin-top: 0rem;border-color:#528124;border-width: 2px;"></b>
                <div class="card"style="border-width:0px;border-top-width:4px;">
                    <!-- /.card-header -->
                    <div class="card-body text-nowrap">
                        <table id="tbact" class="table table-hover table-striped text-center" cellspacing="0" width="100%">
                            <thead>
                                <tr style="color:#528124;">
                                    <th>รหัสกิจกรรม</th>
                                    <th>ชื่อกิจกรรม</th>
                                    <th>วันที่จัด</th>
                                    <th>หมวดหมู่</th>
                                    <th>กลุ่ม</th>
                                    <th>องค์กร</th>
                                    <th>สถานะ</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                require_once '../../db/dbconfig.php';
                                $stmt = $DBcon->prepare("SELECT activity.*, acttype.*, organization.*  FROM activity
                                        JOIN acttype ON activity.actType = acttype.acttypeNo
                                        JOIN organization ON activity.actOrgtion = organization.orgtionNo
                                        WHERE activity.actStatus='ดำเนินกิจกรรม' ||
                                        activity.actStatus='ปลดล๊อก'||
                                        activity.actStatus='ปิดการลงทะเบียน'
                                        ORDER BY activity.actStatus='ดำเนินกิจกรรม' DESC
                                          ");
                                $stmt->execute();
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                    <tr>
                                        <td><?php echo $row['actID']; ?></td>
                                        <td><a href=""  data-toggle="modal" data-target="#modalactmoreinfo" data-id="<?php echo $row['actID']; ?>" id="actmoreinfo"><?php echo $row['actName']; ?></a></td>
                                        <td><?php echo $row['actDateb']; ?>-<?php echo $row['actDatee']; ?></td>
                                        <td><?php echo $row['acttypeName']; ?></td>
                                        <td><?php echo $row['actGroup']; ?></td>
                                        <td><?php echo $row['organization']; ?></td>
                                        <td>
                                            <?php
                                            if ($row['actStatus'] == 'ดำเนินกิจกรรม') {
                                            ?>
                                                <a href="?actreg_id=<?php echo $row['actID']; ?>" title="ลงทะเบียนกิจกรรม" onclick="return confirm('ต้องการลงทะเบียนกิจกรรมนี้ ?')"><button class="btn btn-fix btn-sm btn-info">ลงทะเบียน</button></a>
                                            <?php
                                            } else if ($row['actStatus'] == 'ปลดล๊อก') {
                                            ?>
                                            <a href="?actreg_id=<?php echo $row['actID']; ?>" title="ลงทะเบียนกิจกรรม" onclick="return confirm('ต้องการลงทะเบียนกิจกรรมนี้ ?')"><button class="btn btn-fix btn-sm btn-danger">ลงทะเบียนแก้</button></a>
                                            <?php
                                            } else if ($row['actStatus'] == 'ปิดการลงทะเบียน') {
                                            ?>
                                                <button class="btn btn-fix btn-sm btn-default">ปิดการลงทะเบียน</button>
                                            <?php
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <!-- /.card -->
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