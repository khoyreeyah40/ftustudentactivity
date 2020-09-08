<?php
session_start();
if (!isset($_SESSION['orgzerName']) && ($_SESSION['orgzerID'])) {
    header('location: ../../');
    echo "กรุณาเข้าสู่ระบบ!";
} else {
}
include '../../db/dbcon.php';
$acttypeAddby = $_SESSION['orgzerID'];
?>
<?php
error_reporting(~E_NOTICE); // avoid notice
require_once 'dbconfig.php';

if (isset($_POST['btaddacttype'])) {
    $acttypeName = $_POST['acttypeName'];
    $acttypeAddby = $_POST['acttypeAddby'];


    if (empty($acttypeName)) {
        $errMSG = "กรุณากรอกรายละเอียดให้ครบถ้วน";
    }
    //check username
    if ($acttypeName != "") {
        include '../../db/dbcon.php';

        $cesql = "SELECT acttypeName FROM acttype WHERE acttypeName='$acttypeName'";
        $checkexist = mysqli_query($conn, $cesql);
        if (mysqli_num_rows($checkexist)) {


            $errMSG = "หมวดหมู่นี้ได้ถูกเพิ่มแล้ว";
        }
    }

    // if no error occured, continue ....
    if (!isset($errMSG)) {
        $stmt = $DB_con->prepare('INSERT INTO acttype(acttypeName,acttypeAddby) VALUES
                                                        (:acttypeName,:acttypeAddby)');
        $stmt->bindParam(':acttypeName', $acttypeName);
        $stmt->bindParam(':acttypeAddby', $acttypeAddby);
        if ($stmt->execute()) {
            $successMSG = "ทำการเพิ่มสำเร็จ";
            header("refresh:2;acttype.php");
        } else {
            $errMSG = "พบข้อผิดพลาด";
        }
    }
}
?>

<?php
require_once '../../db/dbconfig.php';
if (isset($_GET['delete_id'])) {
    // it will delete an actual record from db
    $stmt_delete = $DBcon->prepare('DELETE FROM acttype WHERE acttypeNo =:acttypeno');
    $stmt_delete->bindParam(':acttypeno', $_GET['delete_id']);
    $stmt_delete->execute();

    header("Location: acttype.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width initial-scale=1.0">
    <title>ระบบกิจกรรมนักศึกษา| จัดการหมวดหมู่กิจกรรม</title>
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

<body class="fixed-navbar" >

    <!-- Main content -->

    <div class="page-content fade-in-up" style="padding:20px;padding-top:0px">
        <div class="page-heading">
            <h1 class="page-title">จัดการหมวดหมู่กิจกรรม</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                </li>
                <li class="breadcrumb-item"><a href="actall.php">เพิ่มกิจกรรม</a></li>
                <li class="breadcrumb-item">จัดการหมวดหมู่กิจกรรม</li>
            </ol>
        </div>
        <br>
        <a href="actyear.php"><button class="btn btn-info"  type="button"> <span class="fa fa-check"></span> &nbsp; จัดการช่วงเวลากิจกรรม</button></a>&nbsp;&nbsp;
        <a href="actall.php"><button class="btn btn-info"  type="button"> <span class="fa fa-pencil"></span> &nbsp; เพิ่มกิจกรรม</button></a>
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
        <div class="ibox" style="box-shadow: 0 5px 4px rgba(0,0,0,.1);">
      <div class="ibox-head" style="background-color:#d1cbaf;">
        <div class="ibox-title" style="color:#484848;">
                    <h5>เพิ่มหมวดหมู่กิจกรรม</h5>
                </div>
                <div class="ibox-tools">
                    <a class="ibox-collapse"style="color:#484848;" ><i class="fa fa-minus"></i></a>
                </div>
            </div>
            <div class="ibox-body">
                <form class="form-horizontal" id="form-sample-1" method="post" novalidate="novalidate">
                    <div class="form-group row">
                        <label class="col-sm-1 col-form-label">ชื่อหมวดหมู่</label>
                        <div class="col-sm-5">
                            <input class="form-control" type="text" name="acttypeName" value="<?php echo $acttypeName; ?>" required />
                        </div>
                        <label class="col-sm-1 col-form-label">เพิ่มโดย</label>
                        <div class="col-sm-5">
                            <input class="form-control" type="text" name="acttypeAddby" value="<?php echo $acttypeAddby; ?>" readonly />
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12 text-center">
                            <button class="btn btn-info" type="submit" name="btaddacttype">เพิ่ม</button>
                            <a href="acttype.php"><button class="btn btn-danger" type="button" data-dismiss="ibox">ยกเลิก</button></a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
            <div class="card"style="border-width:0px;border-bottom-width:4px;border-right-width:4px;">
          <div class="card-header"style="background-color:#d1cbaf">
            <h5 style="color:#2c2c2c">ตารางหมวดหมู่กิจกรรม</h5>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body pad table-responsive">
                        <table id="tbacttype" class="table table-hover-sm table-striped text-center" cellspacing="0" width="100%">
                            <thead>
                                <tr style="color:#528124;">
                                    <th>ชื่อหมวดหมู่</th>
                                    <th>เพิ่มโดย</th>
                                    <th>แก้ไข</th>
                                    <th>ลบ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                require_once '../../db/dbconfig.php';
                                $stmt = $DBcon->prepare("SELECT * FROM acttype 
                                ORDER BY acttypeNo DESC");
                                $stmt->execute();
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                    <tr>
                                        <td><?php echo $row['acttypeName']; ?></td>
                                        <td><?php echo $row['acttypeAddby']; ?></td>
                                        <td>
                                            <a class="btn btn-sm btn-warning" href="updateacttype.php?update_id=<?php echo $row['acttypeNo']; ?>" title="แก้ไขหมวดหมู่กิจกรรม" onclick="return confirm('ต้องการแก้ไขหมวดหมู่กิจกรรม ?')"><span class="fa fa-edit"></span> แก้ไข</a>
                                        </td>
                                        <td>
                                            <a class="btn btn-sm  btn-danger" href="?delete_id=<?php echo $row['acttypeNo']; ?>" title="ลบหมวดหมู่กิจกรรม" onclick="return confirm('ต้องการลบหมวดหมู่กิจกรรม ?')"> <i class="fa fa-trash"></i> ลบ</a>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
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
            $('#tbacttype').DataTable({
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
</body>

</html>