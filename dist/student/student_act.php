<?php
session_start();
if (!isset($_SESSION['stdName']) && ($_SESSION['stdID'])) {
    header('location: ../welcome/home.php');
    echo "กรุณาเข้าสู่ระบบ!";
} else {
}
include '../db/dbcon.php';
$stdUser = $_SESSION['stdID'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width initial-scale=1.0">
    <title>ระบบกิจกรรมนักศึกษา| ลงทะเบียนกิจกรรม</title>
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
            <h1 class="page-title">ลงทะเบียนกิจกรรม</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                </li>
                <li class="breadcrumb-item">ลงทะเบียนกิจกรรม</li>
            </ol>
        </div>
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
        <div class="row justify-content-center">
            <div class="col-sm-10 ">
                <div class="ibox">
                    <div class="ibox-body">
                        <form>
                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <select class="form-control select2_demo_1" style="width: 100%;" name="fct" id="fct" onChange="getdpm(this.value);" required>
                                        <?php
                                        $sql = "SELECT mainorg.*, faculty.* FROM faculty
                  JOIN mainorg ON faculty.faculty = mainorg.mainorgNo ORDER BY faculty DESC";
                                        $result = $conn->query($sql);
                                        ?>
                                        <option selected="selected" disabled="disabled">--คณะ--</option>
                                        <option>ทั้งหมด</option>
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
                                        ?>
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <select class="form-control select2_demo_1" style="width: 100%;" name="dpm" id="dpm" required>
                                        <option selected="selected" disabled="disabled">--สาขา--</option>
                                        <option>ทั้งหมด</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <select class="form-control select2_demo_1" style="width: 100%;" name="year" required>
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
                                    <select class="form-control select2_demo_1" style="width: 100%;" name="group" required>
                                        <option selected="selected" disabled="disabled">--กลุ่ม--</option>
                                        <option>ทั้งหมด</option>
                                        <option value="ชาย">ชาย</option>
                                        <option value="หญิง">หญิง</option>
                                    </select>
                                </div>
                            </div>
                            <br>
                            <div class="form-group ">
                                <div class="col-sm-12 text-center">
                                    <button class="btn btn-fix btn-primary" onChange="search(this.value);">ค้นหา</button>
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
                <h3>ตารางกิจกรรม</h3>
                <hr>
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body text-nowrap">
                        <table id="tbact" class="table table-hover table-striped text-center" cellspacing="0" width="100%">
                            <thead>
                                <tr>
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
                                require_once '../db/dbconfig.php';
                                $stmt = $DBcon->prepare("SELECT activity.*, acttype.*, organization.*  FROM activity
                                        JOIN acttype ON activity.actType = acttype.acttypeNo
                                        JOIN organization ON activity.actOrgtion = organization.orgtionNo
                                        WHERE activity.actStatus='ดำเนินกิจกรรม' ||
                                        activity.actStatus='ปลดล๊อก'||
                                        activity.actStatus='ปิดการลงทะเบียน'
                                        ORDER BY activity.actID DESC
                                          ");
                                $stmt->execute();
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                    <tr>
                                        <td><?php echo $row['actID']; ?></td>
                                        <td><a href="" type="button" data-toggle="modal" data-target="#modalactmoreinfo" data-id="<?php echo $row['actID']; ?>" id="actmoreinfo"><?php echo $row['actName']; ?></a></td>
                                        <td><?php echo $row['actDateb']; ?>-<?php echo $row['actDatee']; ?></td>
                                        <td><?php echo $row['acttypeName']; ?></td>
                                        <td><?php echo $row['actGroup']; ?></td>
                                        <td><?php echo $row['organization']; ?></td>
                                        <td>
                                            <?php
                                            if ($row['actStatus'] == 'ดำเนินกิจกรรม') {
                                            ?>
                                                <button class="btn btn-fix btn-sm btn-info" type="submit" name="btregact" title="ลงทะเบียนกิจกรรม" onclick="return confirm('ต้องการลงทะเบียนกิจกรรมนี้ ?')">ลงทะเบียน</button>
                                            <?php
                                            } else if ($row['actStatus'] == 'ปลดล๊อก') {
                                            ?>
                                                <button class="btn btn-fix btn-sm btn-danger" type="submit" name="btregact" title="ลงทะเบียนกิจกรรม" onclick="return confirm('ต้องการลงทะเบียนกิจกรรมนี้ ?')">ลงทะเบียนแก้</button>
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
                        <h5 class="modal-title" id="exampleModalLongTitle">ข้อมูลเพิ่มเติม</h5>
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
    <script src="../assets/vendors/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>

    <!-- CORE SCRIPTS-->
    <script src="../assets/js/app.min.js" type="text/javascript"></script>
    <!-- PAGE LEVEL SCRIPTS-->
    <script src="../assets/js/scripts/form-plugins.js" type="text/javascript"></script>
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
            $('#tbactreg').DataTable({
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
                        url: 'student_act_moreinfo.php',
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