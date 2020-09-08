<?php
session_start();
if (!isset($_SESSION['orgzerName']) && ($_SESSION['orgzerID'])) {
  header('location: ../../../');
  echo "กรุณาเข้าสู่ระบบ!";
} else {
}
include '../../../db/dbcon.php';
$checkAddby = $_SESSION['orgzerID'];
?>

<?php

error_reporting(~E_NOTICE);
$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = '';
$DB_NAME = 'dbmyproject';

try {
    $DB_con = new PDO("mysql:host={$DB_HOST};dbname={$DB_NAME}", $DB_USER, $DB_PASS);
    $DB_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $e->getMessage();
}
$stdUser = $_GET['stdUser'];
$acttype = $_GET['acttype'];
$actyear = $_GET['actyear'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width initial-scale=1.0">
    <title>ระบบกิจกรรมนักศึกษา| กิจกรรมที่ได้จัด</title>
    <!-- GLOBAL MAINLY STYLES-->
    <link href="../../../assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../../../assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
    <link href="../../../assets/vendors/themify-icons/css/themify-icons.css" rel="stylesheet" />
    <!-- PLUGINS STYLES-->
    <link href="../../../assets/vendors/select2/dist/css/select2.min.css" rel="stylesheet" />
    <link href="../../../assets/vendors/DataTables/datatables.min.css" rel="stylesheet" />
    <link href="../../../assets/vendors/jvectormap/jquery-jvectormap-2.0.3.css" rel="stylesheet" />
    <!-- THEME STYLES-->
    <link href="../../../assets/css/main.min.css" rel="stylesheet" />
    <!-- PAGE LEVEL STYLES-->
    <style>
        .breadcrumb-item {
            font-size: 16px;
        }
    </style>
</head>

<body class="fixed-navbar">
    <div class="page-content fade-in-up" style="padding:20px;padding-top:0px">
        <div class="page-heading">
            <h1 class="page-title" style="color:#528124;">กิจกรรมที่ได้จัด</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                </li>
                <li class="breadcrumb-item"><a href="actparticipant.php?stdUser=<?php echo $stdUser ?>">การเข้าร่วมกิจกรรม</a></li>
                <li class="breadcrumb-item">กิจกรรมที่ได้จัด</li>
            </ol>
        </div>
        <br>
        <div class="row ml-1 mr-1">
            <div class="col-12">
            <div class="card"style="border-width:0px;border-top-width:4px;">
                    <!-- /.card-header -->
                    <div class="card-body text-nowrap">
                    <?php
                                require_once '../../../db/dbconfig.php';
                                $stmt = $DBcon->prepare("SELECT student.*, club.*, organization.*,department.* 
                                                            FROM student 
                                                            JOIN club ON club.clubstdID = student.stdID
                                                            JOIN organization ON club.clubOrgtion = organization.orgtionNo
                                                            JOIN department ON student.stdDpm = department.dpmNo
                                                            WHERE student.stdID = '$stdUser'");
                                $stmt->execute();
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    $fct = $row["stdFct"];
                                    $dpm = $row["stdDpm"];
                                    $dpmName = $row["department"];
                                    $group = $row["stdGroup"];
                                    $club = $row["clubOrgtion"];
                                    $clubname = $row["organization"];
                                ?>
                                    <table id="tbact1" class="table table-striped table-hover" cellspacing="0" width="100%">
                                        <thead>
                                            <tr style="color:#528124;">
                                                <th>รหัสกิจกรรม</th>
                                                <th>ชื่อกิจกรรม</th>
                                                <th>วันที่จัด</th>
                                                <th>สังกัด</th>
                                                <th>องค์กร</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql = "SELECT acttypeName FROM acttype WHERE acttypeName='$acttype'";
                                            $result = mysqli_query($conn, $sql);
                                            mysqli_num_rows($result);
                                            $row = mysqli_fetch_assoc($result);
                                            if (($row["acttypeName"] == "อบรมคุณธรรมจริยธรรม")||($row["acttypeName"] == "ค่ายพัฒนานักศึกษา(ปี1)")||($row["acttypeName"] == "ค่ายพัฒนานักศึกษา(ปี3)")||($row["acttypeName"] == "อิอฺติก๊าฟ 10 วันสุดท้ายเดือนรอมฎอน")||($row["acttypeName"] == "ปฐมนิเทศ")||($row["acttypeName"] == "ปัจฉิมนิเทศ")) {
                                            ?>
                                                <?php
                                                require_once '../../../db/dbconfig.php';
                                                $stmt = $DBcon->prepare("SELECT activity.*,acttype.*,organization.*,mainorg.*
                                                                        FROM activity 
                                                                        JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                        JOIN mainorg ON mainorg.mainorgNo = activity.actMainorg
                                                                        JOIN organization ON organization.orgtionNo = activity.actOrgtion
                                                                        WHERE 
                                                                        acttype.acttypeName = '$acttype' 
                                                                        && activity.actYear = '$actyear' 
                                                                        && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                        && (activity.actMainorg = '$fct' || activity.actSec = 'มหาวิทยาลัย') 
                                                                        && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                        ");
                                                $stmt->execute();
                                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                ?>
                                                    <tr>
                                                        <td><?php echo $row['actID'] ?></td>
                                                        <td><a href="" data-toggle="modal" data-target="#modalactmoreinfo" data-id="<?php echo $row['actID']; ?>" id="actmoreinfo"><?php echo $row['actName']; ?></a></td>
                                                        <td><?php echo $row['actDateb'] ?> - <?php echo $row['actDatee'] ?></td>
                                                        <td><?php echo $row['mainorg'] ?></td>
                                                        <td><?php echo $row['organization'] ?></td>
                                                    </tr>
                                        <?php }
                                        }if ($row["acttypeName"] == "กิจกรรมชมรม") {
                                            ?>
                                                <?php
                                                require_once '../../../db/dbconfig.php';
                                                $stmt = $DBcon->prepare("SELECT activity.*,acttype.*,organization.*,mainorg.*
                                                                        FROM activity 
                                                                        JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                        JOIN mainorg ON mainorg.mainorgNo = activity.actMainorg
                                                                        JOIN organization ON organization.orgtionNo = activity.actOrgtion
                                                                        WHERE 
                                                                        acttype.acttypeName = 'กิจกรรมชมรม' && activity.actYear = '$actyear' 
                                                                        && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                        && activity.actSec = 'มหาวิทยาลัย' && activity.actOrgtion = '$club'
                                                                        && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                        ");
                                                $stmt->execute();
                                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                ?>
                                                    <tr>
                                                        <td><?php echo $row['actID'] ?></td>
                                                        <td><a href="" data-toggle="modal" data-target="#modalactmoreinfo" data-id="<?php echo $row['actID']; ?>" id="actmoreinfo"><?php echo $row['actName']; ?></a></td>
                                                        <td><?php echo $row['actDateb'] ?> - <?php echo $row['actDatee'] ?></td>
                                                        <td><?php echo $row['mainorg'] ?></td>
                                                        <td><?php echo $row['organization'] ?></td>
                                                    </tr>
                                        <?php }
                                        }if ($row["acttypeName"] == "กิจกรรมชุมนุม") {
                                            ?>
                                                <?php
                                                require_once '../../../db/dbconfig.php';
                                                $stmt = $DBcon->prepare("SELECT activity.*,acttype.*,organization.*,mainorg.*
                                                                        FROM activity 
                                                                        JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                        JOIN mainorg ON mainorg.mainorgNo = activity.actMainorg
                                                                        JOIN organization ON organization.orgtionNo = activity.actOrgtion
                                                                        WHERE 
                                                                                acttype.acttypeName = 'กิจกรรมชุมนุม' && activity.actYear = '$actyear' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actMainorg = '$fct' && organization.organization = '$dpmName')
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                        ");
                                                $stmt->execute();
                                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                ?>
                                                    <tr>
                                                        <td><?php echo $row['actID'] ?></td>
                                                        <td><a href="" data-toggle="modal" data-target="#modalactmoreinfo" data-id="<?php echo $row['actID']; ?>" id="actmoreinfo"><?php echo $row['actName']; ?></a></td>
                                                        <td><?php echo $row['actDateb'] ?> - <?php echo $row['actDatee'] ?></td>
                                                        <td><?php echo $row['mainorg'] ?></td>
                                                        <td><?php echo $row['organization'] ?></td>
                                                    </tr>
                                        <?php }
                                        }if ($row["acttypeName"] == "กิจกรรมองค์การบริหารนักศึกษา") {
                                            ?>
                                                <?php
                                                require_once '../../../db/dbconfig.php';
                                                $stmt = $DBcon->prepare("SELECT activity.*,acttype.*,organization.*,mainorg.*
                                                                        FROM activity 
                                                                        JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                        JOIN mainorg ON mainorg.mainorgNo = activity.actMainorg
                                                                        JOIN organization ON organization.orgtionNo = activity.actOrgtion
                                                                        WHERE 
                                                                                acttype.acttypeName = 'กิจกรรมองค์การบริหารนักศึกษา' 
                                                                                && activity.actYear = '$actyear' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (mainorg.mainorg = 'องค์การบริหารนักศึกษา' || organization.organization = 'องค์การบริหารนักศึกษา') 
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                        ");
                                                $stmt->execute();
                                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                ?>
                                                    <tr>
                                                        <td><?php echo $row['actID'] ?></td>
                                                        <td><a href="" data-toggle="modal" data-target="#modalactmoreinfo" data-id="<?php echo $row['actID']; ?>" id="actmoreinfo"><?php echo $row['actName']; ?></a></td>
                                                        <td><?php echo $row['actDateb'] ?> - <?php echo $row['actDatee'] ?></td>
                                                        <td><?php echo $row['mainorg'] ?></td>
                                                        <td><?php echo $row['organization'] ?></td>
                                                    </tr>
                                        <?php }
                                        }if ($row["acttypeName"] == "กิจกรรมสโมสรคณะ") {
                                            ?>
                                                <?php
                                                require_once '../../../db/dbconfig.php';
                                                $stmt = $DBcon->prepare("SELECT activity.*,acttype.*,organization.*,mainorg.*
                                                                        FROM activity 
                                                                        JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                        JOIN mainorg ON mainorg.mainorgNo = activity.actMainorg
                                                                        JOIN organization ON organization.orgtionNo = activity.actOrgtion
                                                                        WHERE 
                                                                                acttype.acttypeName = 'กิจกรรมสโมรสรคณะ' 
                                                                                && activity.actYear = '$actyear' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actMainorg = '$fct' || organization.organization = 'สโมสรคณะ') 
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                        ");
                                                $stmt->execute();
                                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                ?>
                                                    <tr>
                                                        <td><?php echo $row['actID'] ?></td>
                                                        <td><a href="" data-toggle="modal" data-target="#modalactmoreinfo" data-id="<?php echo $row['actID']; ?>" id="actmoreinfo"><?php echo $row['actName']; ?></a></td>
                                                        <td><?php echo $row['actDateb'] ?> - <?php echo $row['actDatee'] ?></td>
                                                        <td><?php echo $row['mainorg'] ?></td>
                                                        <td><?php echo $row['organization'] ?></td>
                                                    </tr>
                                        <?php }
                                        }
                                    }
                                        ?>
                                        </tbody>
                                    </table>
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
                    <!-- /.card-body -->
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </div>

    <!-- CORE PLUGINS-->
    <script src="../../../assets/vendors/jquery/dist/jquery.min.js" type="text/javascript"></script>
    <script src="../../../assets/vendors/popper.js/dist/umd/popper.min.js" type="text/javascript"></script>
    <script src="../../../assets/vendors/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="../../../assets/vendors/metisMenu/dist/metisMenu.min.js" type="text/javascript"></script>
    <script src="../../../assets/vendors/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <!-- PAGE LEVEL PLUGINS-->
    <script src="../../../assets/vendors/select2/dist/js/select2.full.min.js" type="text/javascript"></script>
    <script src="../../../assets/vendors/jquery.maskedinput/dist/jquery.maskedinput.min.js" type="text/javascript"></script>
    <script src="../../../assets/vendors/jquery-validation/dist/jquery.validate.min.js" type="text/javascript"></script>
    <script src="../../../assets/vendors/DataTables/datatables.min.js" type="text/javascript"></script>
    <!-- CORE SCRIPTS-->
    <script src="../../../assets/js/app.min.js" type="text/javascript"></script>
    <!-- PAGE LEVEL SCRIPTS-->
    <script src="../../../assets/js/scripts/form-plugins.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(function() {
            $('#tbact1').DataTable({
                pageLength: 10,
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