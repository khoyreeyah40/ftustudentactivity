<?php
session_start();
if (!isset($_SESSION['orgzerName']) && ($_SESSION['orgzerID'])) {
    header('location: ../../welocome/home.php');
    echo "กรุณาเข้าสู่ระบบ!";
} else {
}
include '../../db/dbcon.php';
$pstAddby = $_SESSION['orgzerID'];
?>
<?php


error_reporting(~E_NOTICE); // avoid notice
require_once '../../db/dbconfig.php';

if (isset($_POST['btaddposition'])) {
    $pstYear = $_POST['pstYear'];
    $pststdID = $_POST['pststdID'];
    $pst = $_POST['pst'];
    $pstOrgtion = $_POST['pstOrgtion'];
    $pstMainorg = $_POST['pstMainorg'];
    $pstAddby = $_POST['pstAddby'];

    if (empty($pst)) {
        $errMSG = "กรุณากรอกรายละเอียดให้ครบถ้วน";
    }
    //check username
    if ($pst != ""&& $pststdID != ""&& $pstYear != ""&& $pstOrgtion != ""&& $pstMainorg != "") {
        include '../../db/dbcon.php';

        $cesql = "SELECT * FROM pst WHERE pst='$pst' && pststdID='$pststdID' && pstYear='$pstYear' && pstOrgtion='$pstOrgtion' && pstMainorg='$pstMainorg'";
        $checkexist = mysqli_query($conn, $cesql);
        if (mysqli_num_rows($checkexist)) {

            $errMSG = "รายชื่อนี้ได้ถูกเพิ่มแล้ว";
        }
    }
    // if no error occured, continue ....
    if (!isset($errMSG)) {
        $stmt = $DBcon->prepare("INSERT INTO pst(pstYear, pststdID,  pst,  pstOrgtion, pstMainorg, pstAddby) VALUES
                                                (:pstYear, :pststdID, :pst, :pstOrgtion, :pstMainorg, :pstAddby)");
        $stmt->bindParam(':pstYear', $pstYear);
        $stmt->bindParam(':pststdID', $pststdID);
        $stmt->bindParam(':pst', $pst);
        $stmt->bindParam(':pstOrgtion', $pstOrgtion);
        $stmt->bindParam(':pstMainorg', $pstMainorg);
        $stmt->bindParam(':pstAddby', $pstAddby);
        if ($stmt->execute()) {

            $successMSG = "ทำการเพิ่มสำเร็จ";
            header("refresh:2;position.php");
        } else {
            $errMSG = "error while inserting....";
        }
    }
}
?>


<?php
require_once 'dbconfig.php';
if (isset($_GET['delete_id'])) {
    // it will delete an actual record from db
    if (!isset($errMSG)) {
    $stmt_delete = $DBcon->prepare('DELETE FROM pst WHERE pstNo =:pstNo');
    $stmt_delete->bindParam(':pstNo', $_GET['delete_id']);
    $stmt_delete->execute();
    header("Location: position.php");
    }
    else {
        $errMSG = "ไม่สามารถลบได้";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width initial-scale=1.0">
    <title>ระบบกิจกรรมนักศึกษา| จัดการตำแหน่งนักศึกษา</title>
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
            <h1 class="page-title">จัดการตำแหน่งนักศึกษา</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                </li>
                <li class="breadcrumb-item">จัดการตำแหน่งนักศึกษา</li>
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
        <div class="ibox" style="box-shadow: 0 5px 4px rgba(0,0,0,.1);">
      <div class="ibox-head" style="background-color:#d1cbaf;">
        <div class="ibox-title" style="color:#484848;">
                    <h5>เพิ่มรายชื่อ</h5>
                </div>
                <div class="ibox-tools">
                    <a class="ibox-collapse" style="color:#484848;"><i class="fa fa-minus"></i></a>
                </div>
            </div>
            <div class="ibox-body">
                <form class="form-horizontal" id="form-sample-1" enctype="multipart/form-data" method="post" novalidate="novalidate">
                    <div class="form-group row">
                        <label class="col-sm-1 col-form-label">ปีการศึกษา</label>
                        <div class="col-sm-2">
                            <select class="form-control select2_demo_1" style="width: 100%;" name="pstYear" required />
                            <?php
                                $sql = "SELECT * FROM actyear WHERE actyearStatus='ดำเนินกิจกรรม'";
                                $result = $conn->query($sql);
                                ?>
                                <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $actyear = $row["actyear"];
                                ?>
                                        <option value="<?php echo $actyear ?>"> <?php echo $actyear ?></option>
                                <?php
                                    }
                                } else {
                                    echo "something";
                                }
                                ?>
                            </select>
                        </div>
                        <label class="col-sm-1 col-form-label">รหัสนักศึกษา</label>
                        <div class="col-sm-3">
                            <select class="form-control select2_demo_1" style="width: 100%;" name="pststdID" required>
                                <?php
                                $sql = "SELECT * FROM student WHERE stdStatus = 'กำลังศึกษา'";
                                $result = $conn->query($sql);
                                ?>
                                <option selected="selected" disabled="disabled">--รหัสนักศึกษา--</option>
                                <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $stdID = $row["stdID"];
                                        $stdName = $row["stdName"];
                                ?>
                                        <option value="<?php echo $stdID ?>"> <?php echo $stdID ?>: <?php echo $stdName ?></option>
                                <?php
                                    }
                                } else {
                                    echo "something";
                                }
                                ?>
                            </select>
                        </div>
                        <label class="col-sm-1 col-form-label">ตำแหน่ง</label>
                        <div class="col-sm-4">
                            <input class="form-control" type="text" name="pst" value="<?php echo $pst; ?>" require />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-1 col-form-label">สังกัด</label>
                        <div class="col-sm-5">
                            <select class="form-control select2_demo_1" style="width: 100%;" name="pstMainorg" >
                                <?php
                                $sql = "SELECT orgzerSec FROM organizer WHERE orgzerID = '$pstAddby'";
                                $result = mysqli_query($conn, $sql);
                                mysqli_num_rows($result);
                                // output data of each row
                                $row = mysqli_fetch_assoc($result);
                                ?>
                                <?php
                                if ($row["orgzerSec"] == "Admin") {
                                    $sql = "SELECT mainorgNo, mainorg FROM mainorg";
                                    $result = $conn->query($sql);
                                ?>
                                    <option selected="selected" disabled="disabled">--สังกัด--</option>
                                    <?php
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            $mainorgNo = $row["mainorgNo"];
                                            $mainorglist = $row["mainorg"];
                                    ?>
                                            <option value="<?php echo $mainorgNo ?>"> <?php echo $mainorglist ?></option>
                                        <?php
                                        }
                                    } else {
                                        echo "something";
                                    }
                                }
                                if ($row["orgzerSec"] == "คณะ") {
                                    $sql = "SELECT organizer.*, mainorg.* FROM organizer
                                              JOIN mainorg ON organizer.orgzerMainorg = mainorg.mainorgNo
                                              WHERE organizer.orgzerID = '$pstAddby'
                                              ";
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            $mainorgNo = $row["mainorgNo"];
                                            $mainorglist = $row["mainorg"];
                                        ?>
                                            <option value="<?php echo $mainorgNo ?>"> <?php echo $mainorglist ?></option>
                                        <?php
                                        }
                                    } else {
                                        echo "something";
                                    }
                                }
                                if ($row["orgzerSec"] == "มหาวิทยาลัย") {
                                    $sec = $row["orgzerSec"];
                                    $sql = "SELECT * FROM mainorg
                                              WHERE mainorgSec = '$sec'
                                              ";
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            $mainorgNo = $row["mainorgNo"];
                                            $mainorglist = $row["mainorg"];
                                        ?>
                                            <option value="<?php echo $mainorgNo ?>"> <?php echo $mainorglist ?></option>
                                <?php
                                        }
                                    } else {
                                        echo "something";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <label class="col-sm-1 col-form-label">องค์กร</label>
                        <div class="col-sm-5">
                            <select class="form-control select2_demo_1" style="width: 100%;" name="pstOrgtion">
                                <?php
                                $sql = "SELECT orgzerSec FROM organizer WHERE orgzerID = '$pstAddby'";
                                $result = mysqli_query($conn, $sql);
                                mysqli_num_rows($result);
                                // output data of each row
                                $row = mysqli_fetch_assoc($result);
                                ?>
                                <?php
                                if ($row["orgzerSec"] == "Admin") {
                                    $sql = "SELECT * FROM organization";
                                    $result = $conn->query($sql);
                                ?>
                                    <option selected="selected" disabled="disabled">--องค์กร--</option>
                                    <?php
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            $orgtionNo = $row["orgtionNo"];
                                            $organizationlist = $row["organization"];
                                    ?>
                                            <option value="<?php echo $orgtionNo ?>"> <?php echo $organizationlist ?></option>
                                        <?php
                                        }
                                    } else {
                                        echo "something";
                                    }
                                }
                                if (($row["orgzerSec"] == "คณะ")||($row["orgzerSec"] == "มหาวิทยาลัย")) {
                                    $sql = "SELECT organizer.*, organization.* FROM organization
                                              JOIN organizer ON organizer.orgzerOrgtion = organization.orgtionNo
                                              WHERE organizer.orgzerID = '$pstAddby'
                                              ";
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            $orgtionNo = $row["orgtionNo"];
                                            $organizationlist = $row["organization"];
                                        ?>
                                            <option value="<?php echo $orgtionNo ?>"> <?php echo $organizationlist ?></option>
                                        <?php
                                        }
                                    } else {
                                        echo "something";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <input class="form-control" type="hidden" name="pstAddby" value="<?php echo $pstAddby; ?>" readonly />
                    <div class="form-group row">
                        <div class="col-sm-12 text-center">
                            <button class="btn btn-info" type="submit" name="btaddposition">เพิ่ม</button>
                            <a href="position.php"><button class="btn btn-danger" type="button" data-dismiss="ibox">ยกเลิก</button></a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
            <div class="card"style="border-width:0px;border-bottom-width:4px;border-right-width:4px;">
          <div class="card-header"style="background-color:#d1cbaf">
            <h5 style="color:#2c2c2c">ตารางตำแหน่งนักศึกษา</h5>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body text-nowrap">
                        <table id="tbpst" class="table table-hover-sm table-striped text-center" cellspacing="0" width="100%">
                            <thead>
                            <tr style="color:#528124;">
                                    <th>ปีการศึกษา</th>
                                    <th>รหัสนักศึกษา</th>
                                    <th>ชื่อ-สกุล</th>
                                    <th>ตำแหน่ง</th>
                                    <th>หมายเลขโทรศัพท์</th>
                                    <th>องค์กร</th>
                                    <th>แก้ไข/ลบ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT orgzerOrgtion,orgzerSec FROM organizer WHERE orgzerID = '$pstAddby'";
                                $result = mysqli_query($conn, $sql);
                                mysqli_num_rows($result);
                                // output data of each row
                                $row = mysqli_fetch_assoc($result);
                                if ($row["orgzerSec"] == "Admin") {
                                require_once '../../db/dbconfig.php';
                                $stmt = $DBcon->prepare("SELECT pst.*, organization.*, student.* FROM pst 
                                JOIN organization ON organization.orgtionNo = pst.pstOrgtion
                                JOIN student ON student.stdID = pst.pststdID
                                 ");
                                $stmt->execute();
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                    <tr>
                                        <td><?php echo $row['pstYear']; ?></td>
                                        <td><a href="" data-toggle="modal" data-target="#modalmoreinfo" data-id="<?php echo $row['stdID']; ?>" id="moreinfo"><?php echo $row['stdID']; ?></a></td>
                                        <td><?php echo $row['stdName']; ?></td>
                                        <td><?php echo $row['pst']; ?></td>
                                        <td><?php echo $row['stdPhone']; ?></td>
                                        <td><?php echo $row['organization']; ?></td>
                                        <td>
                                            <a href="updatepst.php?update_id=<?php echo $row['pstNo']; ?>" title="แก้ไขตำแหน่งนักศึกษา" onclick="return confirm('ต้องการแก้ไขตำแหน่งนักศึกษา ?')"><button class="btn btn-warning btn-sm m-r-5" data-toggle="tooltip" ><i class="fa fa-pencil font-30"></i></button></a>
                                            <a href="?delete_id=<?php echo $row['pstNo']; ?>" title="ลบรายชื่อออกจากตำแหน่งนักศึกษา" onclick="return confirm('ต้องการลบรายชื่อออกจากตำแหน่งนักศึกษา ?')"><button class="btn btn-danger btn-sm" data-toggle="tooltip" ><i class="fa fa-trash font-30"></i></button></a>
                                        </td>
                                    </tr>
                                <?php
                                }
                            }if ($row["orgzerSec"] == "มหาวิทยาลัย"||$row["orgzerSec"] == "คณะ") {
                                    $org = $row["orgzerOrgtion"];
                                    require_once '../../db/dbconfig.php';
                                    $stmt = $DBcon->prepare("SELECT pst.*, organization.*, student.*, actyear.* FROM pst 
                                    JOIN organization ON organization.orgtionNo = pst.pstOrgtion
                                    JOIN student ON student.stdID = pst.pststdID
                                    JOIN actyear ON pst.pstYear = actyear.actyear
                                    WHERE pstOrgtion='$org' && actyear.actyearStatus = 'ดำเนินกิจกรรม'
                                     ");
                                    $stmt->execute();
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                        <tr>
                                        <td><?php echo $row['pstYear']; ?></td>
                                        <td><a href="" data-toggle="modal" data-target="#modalmoreinfo" data-id="<?php echo $row['stdID']; ?>" id="moreinfo"><?php echo $row['stdID']; ?></a></td>
                                        <td><?php echo $row['stdName']; ?></td>
                                        <td><?php echo $row['pst']; ?></td>
                                        <td><?php echo $row['stdPhone']; ?></td>
                                        <td><?php echo $row['organization']; ?></td>
                                            <td>
                                                <a href="updatepst.php?update_id=<?php echo $row['pstNo']; ?>" title="แก้ไขตำแหน่งนักศึกษา" onclick="return confirm('ต้องการแก้ไขตำแหน่งนักศึกษา ?')"><button class="btn btn-warning btn-sm m-r-5" data-toggle="tooltip" ><i class="fa fa-pencil font-30"></i></button></a>
                                                <a href="?delete_id=<?php echo $row['pstNo']; ?>" title="ลบรายชื่อออกจากตำแหน่งนักศึกษา" onclick="return confirm('ต้องการลบรายชื่อออกจากตำแหน่งนักศึกษา ?')"><button class="btn btn-danger btn-sm" data-toggle="tooltip"><i class="fa fa-trash font-30"></i></button></a>
                                            </td>
                                        </tr>
                                    <?php
                                    }}
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal fade" id="modalmoreinfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content ">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle" style="color:#528124;" >รายละเอียดเพิ่มเติม</h5>
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
            $('#tbpst').DataTable({
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

        var stdid = $(this).data('id'); // it will get id of clicked row

        $('#dynamic-content').html(''); // leave it blank before ajax call
        $('#modal-loader').show(); // load ajax loader

        $.ajax({
            url: 'morestdinfo.php',
            type: 'POST',
            data: 'id=' + stdid,
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