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
require_once '../../db/dbconfig.php';

if (isset($_POST['btaddfile'])) {
    $year = $_POST['year'];
    $stdid = $_POST['stdid'];
    $acttype = $_POST['acttype'];
    $imgFile = $_FILES['file']['name'];
    $tmp_dir = $_FILES['file']['tmp_name'];
    $imgSize = $_FILES['file']['size'];

    if (empty($imgFile)) {
        $errMSG = "กรุณาแนบไฟล์กิจกรรม";
    } else {
        $upload_dir = '../file/'; // upload directory
        $imgExt = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION)); // get image extension
        // valid image extensions
        $valid_extensions = array('pdf', 'docx', 'xlsx', 'pptx'); // valid extensions
        // rename uploading image
        $file = "eiatiqaf" . "/" . rand(1000, 1000000) . "." . $imgExt;

        // allow valid image file formats
        if (in_array($imgExt, $valid_extensions)) {
            // Check file size '5MB'
            move_uploaded_file($tmp_dir, $upload_dir . $file);
        } else {
            $errMSG = "อนุญาตไฟล์ประเภท PDF, DOCX, XLSX & PPTX เท่านั้น";
        }
    }
    // if no error occured, continue ....
    if (!isset($errMSG)) {
        $stmt = $DBcon->prepare("INSERT INTO eiatiqaf(eiatiqafstdID,eiatiqafYear, eiatiqafactType, eiatiqafFile) VALUES
                                                (:eiatiqafstdID,:eiatiqafYear,:eiatiqafactType,:eiatiqafFile)");
        $stmt->bindParam(':eiatiqafstdID', $stdid);
        $stmt->bindParam(':eiatiqafYear', $year);
        $stmt->bindParam(':eiatiqafactType', $acttype);
        $stmt->bindParam(':eiatiqafFile', $file);
        if ($stmt->execute()) {
            $successMSG = "ทำการเพิ่มสำเร็จ";
            header("refresh;actpaticipant.php");
        } else {
            $errMSG = "error while inserting....";
        }
    }
}
require_once 'dbconfig1.php';

if (isset($_POST['btupdatefile'])) {
    $eiatiqafNo = $_POST['eiatiqafNo'];
    $file = $_POST['file'];
    $imgFile = $_FILES['file']['name'];
    $tmp_dir = $_FILES['file']['tmp_name'];
    $imgSize = $_FILES['file']['size'];
    $sql = " SELECT * 
    FROM eiatiqaf
    WHERE eiatiqafNo=:eiatiqagNo";
      $result = mysqli_query($conn, $sql);
      $row = mysqli_fetch_array($result);
      $eiatiqafFile = $row["eiatiqafFile"];

    if ($imgFile) {
        $upload_dir = '../file/'; // upload directory
        $imgExt = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION)); // get image extension
        // valid image extensions
        $valid_extensions = array('pdf', 'docx', 'xlsx', 'pptx'); // valid extensions
        // rename uploading image
        $file = "eiatiqaf" . "/" . rand(1000, 1000000) . "." . $imgExt;

        // allow valid image file formats
        if (in_array($imgExt, $valid_extensions)) {
            // Check file size '5MB'
            unlink($upload_dir.$eiatiqafFile);
            move_uploaded_file($tmp_dir, $upload_dir . $file);
        } else {
            $errMSG = "อนุญาตไฟล์ประเภท PDF, DOCX, XLSX & PPTX เท่านั้น";
        }
    } else {
        // if no image selected the old image remain as it is.
    // old image from database
    $file = $eiatiqafFile;
    }
    // if no error occured, continue ....
    if (!isset($errMSG)) {
        $stmt = $DB_con->prepare('UPDATE eiatiqaf
                                SET eiatiqafNo=:eiatiqafNo,
                                eiatiqafFile =:eiatiqafFile
                                WHERE eiatiqafNo=:eiatiqafNo');
        $stmt->bindParam(':eiatiqafNo', $eiatiqafNo);
        $stmt->bindParam(':eiatiqafFile', $file);
        if ($stmt->execute()) {
?>
            <script>
                alert('ทำการแก้ไขเรียบร้อย ...');
                window.location.href = 'actparticipant.php';
            </script>
<?php
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
            <h1 class="page-title" style="color:#528124;">การเข้าร่วมกิจกรรม</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                </li>
                <li class="breadcrumb-item">การเข้าร่วมกิจกรรม</li>
            </ol>
        </div>
        <br>
        <div class="row">
            <div class="col-12">
            <div class="card"style="border-width:0px;border-top-width:4px;">
                    <div class="card-body ">
                        <ul class="nav nav-tabs ">
                            <li class="nav-item">
                                <a class="nav-link active" href="#pill-1-1" data-toggle="tab">
                                    <h4 style="color:#528124;"><?php echo $stdUser; ?></h4>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " href="#pill-1-2" data-toggle="tab">
                                    <h4 style="color:#528124;">กิจกรรมของฉัน</h4>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="pill-1-1">
                                <div class="row justify-content-center">
                                    <h4 class="m-t-10 m-b-10 font-strong">การเข้าร่วมกิจกรรม</h4>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-md-10">
                                        <table id="tbresult" class="table table-condensed  text-center">
                                            <tbody>
                                                <tr>
                                                    <td style="border-top: 0px;">กิจกรรมชั้นปีที่1</td>
                                                    <td style="width: 70%;border-top: 0px;">
                                                        <div class="progress m-b-0">
                                                            <div class="progress-bar progress-bar-success pull-right" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%;">100%</div>
                                                        </div>
                                                    </td>
                                                    <td style="border-top: 0px;"><i class="fa fa-check text-success"><b>ผ่าน</b></i></td>
                                                </tr>
                                                <tr>
                                                    <td>กิจกรรมชั้นปีที่2</td>
                                                    <td style="width: 70%;">
                                                        <div class="progress m-b-0">
                                                            <div class="progress-bar progress-bar-danger pull-right" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" style="width:30%;">30%</div>
                                                        </div>
                                                    </td>
                                                    <td><i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i></td>
                                                </tr>
                                                <tr>
                                                    <td>กิจกรรมชั้นปีที่3</td>
                                                    <td style="width: 70%;">
                                                        <div class="progress m-b-0">
                                                            <div class="progress-bar progress-bar-danger pull-right" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" style="width:30%;">30%</div>
                                                        </div>
                                                    </td>
                                                    <td><i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i></td>
                                                </tr>
                                                <tr>
                                                    <td>กิจกรรมชั้นปีที่4</td>
                                                    <td style="width: 70%;">
                                                        <div class="progress m-b-0">
                                                            <div class="progress-bar progress-bar-danger pull-right" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" style="width:30%;">30%</div>
                                                        </div>
                                                    </td>
                                                    <td><i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i></td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 18px;">สถานะ</td>
                                                    <td style="width: 70%;">

                                                    </td>
                                                    <td style="font-size: 18px;"><i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <br>
                                <div class="row justify-content-center">
                                    <h4 class="m-t-10 m-b-10 font-strong">ตำแหน่งนักศึกษา</h4>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-md-10">
                                        <table id="tbact1" class="table table-condensed  text-center">
                                            <thead>
                                                <tr style="color:#528124;">
                                                    <th>ปีการศึกษา</th>
                                                    <th>ตำแหน่ง</th>
                                                    <th>สังกัด</th>
                                                    <th>องค์กร</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                require_once '../../db/dbconfig.php';
                                                $stmt = $DBcon->prepare("SELECT pst.*, organization.*, mainorg.* FROM pst 
                                                    JOIN organization ON organization.orgtionNo = pst.pstOrgtion
                                                    JOIN mainorg ON mainorg.mainorgNo = pst.pstMainorg
                                                    WHERE pststdID = '$stdUser'
                                                    ");
                                                $stmt->execute();
                                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                ?>
                                                    <tr>
                                                        <td><?php echo $row['pstYear']; ?></td>
                                                        <td><?php echo $row['pst']; ?></td>
                                                        <td><?php echo $row['organization']; ?></td>
                                                        <td><?php echo $row['mainorg']; ?></td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="pill-1-2">
                                <div class="ibox">
                                    <div class="ibox-head">
                                        <div class="ibox-title" style="color:#528124;">ตารางกิจกรรมประจำปี</div>
                                        <ul class="nav nav-tabs tabs-line pull-right">
                                            <li class="nav-item">
                                                <a class="nav-link active" href="#tab-8-1" data-toggle="tab">ชั้นปีที่ 1</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#tab-8-2" data-toggle="tab">ชั้นปีที่ 2</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#tab-8-3" data-toggle="tab">ชั้นปีที่ 3</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#tab-8-4" data-toggle="tab">ชั้นปีที่ 4</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="ibox-body">
                                        <div class="tab-content">
                                            <div class="tab-pane fade show active" id="tab-8-1">
                                                <div class="row justify-content-center">
                                                    <div class="col-md-12">
                                                        <?php
                                                        require_once '../../db/dbconfig.php';
                                                        $stmt = $DBcon->prepare("SELECT student.*, club.*, organization.*,department.* FROM student 
                                                            JOIN club ON club.clubstdID = student.stdID
                                                            JOIN organization ON club.clubOrgtion = organization.orgtionNo
                                                            JOIN department ON student.stdDpm = department.dpmNo
                                                            WHERE student.stdID = '$stdUser' && club.clubYear = student.stdYear ");
                                                        $stmt->execute();
                                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                            $fct = $row["stdFct"];
                                                            $dpm = $row["stdDpm"];
                                                            $dpmName = $row["department"];
                                                            $year = $row["stdYear"];
                                                            $group = $row["stdGroup"];
                                                            $club = $row["clubOrgtion"];
                                                            $clubname = $row["organization"];

                                                        ?>
                                                            <table id="tbact1" class="table table-condensed ">
                                                                <thead>
                                                                    <tr style="color:#528124;">
                                                                        <th>หมวดหมู่</th>
                                                                        <th></th>
                                                                        <th>จำนวนครั้งที่จัด</th>
                                                                        <th>จำนวนครั้งที่เข้าร่วม</th>
                                                                        <th>ผลการประเมิน</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                <!--act1กลุ่มศึกษาอัลกุรอ่าน-->
                                                                    <tr>
                                                                        <td><a href="javascript:;">กลุ่มศึกษาอัลกุรอ่าน</a></td>
                                                                        <td>ภาคเรียนที่ 1</td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <?php
                                                                        require_once '../../db/dbconfig.php';
                                                                        $stmt = $DBcon->prepare("SELECT halaqahstd.*, halaqahtc.* FROM halaqahstd
                                                                                                JOIN halaqahtc ON halaqahtc.halaqahtcNo = halaqahstd.halaqahID
                                                                                                WHERE halaqahstd.halaqahstdID = '$stdUser' && halaqahtc.halaqahtcYear = '$year'
                                                                                                ");
                                                                        $stmt->execute();
                                                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                                            if ($row['halaqahstdsem1Status'] == 'ผ่าน') { ?>
                                                                                <td><i class="fa fa-check text-success"><b><?php echo $row['halaqahstdsem1Status']; ?></b></i></td>
                                                                            <?php } else if ($row['halaqahstdsem1Status'] == 'ไม่ผ่าน') { ?>
                                                                                <td><i class="fa fa-times text-danger"><b><?php echo $row['halaqahstdsem1Status']; ?></b></i></td>
                                                                            <?php } else { ?>
                                                                                <td><?php echo $row['halaqahstdsem1Status']; ?></td>
                                                                        <?php }
                                                                        }
                                                                        ?>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="font-size:16px;width: 30%;border-top: 0px;"></td>
                                                                        <td>ภาคเรียนที่ 2</td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <?php
                                                                        require_once '../../db/dbconfig.php';
                                                                        $stmt = $DBcon->prepare("SELECT halaqahstd.*, halaqahtc.* FROM halaqahstd
                                                                                                JOIN halaqahtc ON halaqahtc.halaqahtcNo = halaqahstd.halaqahID
                                                                                                WHERE halaqahstd.halaqahstdID = '$stdUser' && halaqahtc.halaqahtcYear = '$year'
                                                                                                ");
                                                                        $stmt->execute();
                                                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                                            if ($row['halaqahstdsem2Status'] == 'ผ่าน') { ?>
                                                                                <td><i class="fa fa-check text-success"><b><?php echo $row['halaqahstdsem2Status']; ?></b></i></td>
                                                                            <?php } else if ($row['halaqahstdsem2Status'] == 'ไม่ผ่าน') { ?>
                                                                                <td><i class="fa fa-times text-danger"><b><?php echo $row['halaqahstdsem2Status']; ?></b></i></td>
                                                                            <?php } else { ?>
                                                                                <td><?php echo $row['halaqahstdsem2Status']; ?></td>
                                                                        <?php }
                                                                        }
                                                                        ?>
                                                                    </tr>
                                                                <!--act2กิยามุลลัยล์-->
                                                                    <tr>
                                                                        <?php
                                                                        require_once '../../db/dbconfig.php';
                                                                        $sql = "SELECT activity.*, actsem.*,acttype.* 
                                                                            FROM activity 
                                                                            JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                            JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                            WHERE 
                                                                            acttype.acttypeName = 'กิยามุลลัยล์' 
                                                                            && (activity.actYear = '$year' && actsem.actsem = '1') 
                                                                            && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                            && (activity.actMainorg = '$fct' || activity.actSec = 'มหาวิทยาลัย') 
                                                                            && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                            ";
                                                                        $result = mysqli_query($conn, $sql);
                                                                        $row = mysqli_num_rows($result);
                                                                        $rowget = mysqli_fetch_assoc($result);
                                                                        ?>
                                                                        <td><a href="javascript:;">กิยามุลลัยล์</a></td>
                                                                        <td>ภาคเรียนที่ 1</td>
                                                                        <td>
                                                                            <?php if ($row > 0) {
                                                                            ?>
                                                                                <a href="actall_sem.php?acttype=<?php echo $rowget['acttypeName']; ?>&&actyear=<?php echo $year ?>&&actsem=<?php echo $rowget['actsem']; ?>"><?php echo $row ?></a>
                                                                            <?php } else if ($row < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*, actsem.*,acttype.*,actregister.*
                                                                                FROM actregister 
                                                                                JOIN activity ON activity.actID = actregister.actregactID
                                                                                JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'กิยามุลลัยล์' && actregister.actregstdID ='$stdUser' 
                                                                                && actregister.actregStatus='ยืนยันเรียบร้อย'
                                                                                && (activity.actYear = '$year' && actsem.actsem = '1') 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actMainorg = '$fct' || activity.actSec = 'มหาวิทยาลัย') 
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row1 = mysqli_num_rows($result);
                                                                            $rowget1 = mysqli_fetch_assoc($result);
                                                                            if ($row1 > 0) {
                                                                            ?>
                                                                                <a href="actreg_sem.php?acttype=<?php echo $rowget1['acttypeName']; ?>&&actyear=<?php echo $year ?>&&actsem=<?php echo $rowget1['actsem']; ?>"><?php echo $row1 ?></a>
                                                                            <?php } else if ($row1 < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT actsem.*, activity.*
                                                                                FROM actsem 
                                                                                JOIN activity ON activity.actSem = actsem.actsemNo
                                                                                WHERE 
                                                                                activity.actYear = '$year' && actsem.actsem = '1' && actsem.actsemStatus = 'สำเร็จกิจกรรมแล้ว'
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $rowsem = mysqli_num_rows($result);
                                                                            if ($rowsem > 0) {
                                                                                if ($row <= 1) {
                                                                                    if (($row1 && $row) == 0) {
                                                                            ?>
                                                                                    <?php
                                                                                    } elseif ($row1 < 1) {
                                                                                    ?>
                                                                                        <i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i>
                                                                                    <?php
                                                                                    } elseif ($row1 >= 1) {
                                                                                    ?>
                                                                                        <i class="fa fa-check text-success"><b>ผ่าน</b></i>
                                                                                    <?php
                                                                                    }
                                                                                } elseif ($row > 1) {
                                                                                    $rowresult = ($row - $row1);
                                                                                    if ($rowresult >= 2) {
                                                                                    ?>
                                                                                        <i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i>
                                                                                    <?php
                                                                                    } elseif ($rowresult < 2) {
                                                                                    ?>
                                                                                        <i class="fa fa-check text-success"><b>ผ่าน</b></i>
                                                                            <?php
                                                                                    }
                                                                                }
                                                                            } else if ($rowsem < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                    </tr>
                                                                <!--กิยามุลลัยล์2-->
                                                                    <tr>
                                                                        <td style="font-size:16px;width: 30%;border-top: 0px;"></td>
                                                                        <td>ภาคเรียนที่ 2</td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*, actsem.*,acttype.* 
                                                                                FROM activity 
                                                                                JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'กิยามุลลัยล์' 
                                                                                && (activity.actYear = '$year' && actsem.actsem = '2') 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actMainorg = '$fct' || activity.actSec = 'มหาวิทยาลัย') 
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row = mysqli_num_rows($result);
                                                                            $rowget = mysqli_fetch_assoc($result);
                                                                            if ($row > 0) {
                                                                            ?>
                                                                                <a href="actall_sem.php?acttype=<?php echo $rowget['acttypeName']; ?>&&actyear=<?php echo $year ?>&&actsem=<?php echo $rowget['actsem']; ?>"><?php echo $row ?></a>
                                                                            <?php
                                                                            } elseif ($row < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*, actsem.*,acttype.*,actregister.*
                                                                                FROM actregister 
                                                                                JOIN activity ON activity.actID = actregister.actregactID
                                                                                JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'กิยามุลลัยล์' && actregister.actregstdID ='$stdUser' 
                                                                                && actregister.actregStatus='ยืนยันเรียบร้อย'
                                                                                && (activity.actYear = '$year' && actsem.actsem = '2') 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row1 = mysqli_num_rows($result);
                                                                            $rowget1 = mysqli_fetch_assoc($result);
                                                                            if ($row1 > 0) {
                                                                            ?>
                                                                                <a href="actreg_sem.php?acttype=<?php echo $rowget1['acttypeName']; ?>&&actyear=<?php echo $year ?>&&actsem=<?php echo $rowget1['actsem']; ?>"><?php echo $row1 ?></a>
                                                                            <?php
                                                                            } else if ($row1 < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT actsem.*, activity.*
                                                                                FROM actsem 
                                                                                JOIN activity ON activity.actSem = actsem.actsemNo
                                                                                WHERE 
                                                                                activity.actYear = '$year' && actsem.actsem = '2' && actsem.actsemStatus = 'สำเร็จกิจกรรมแล้ว'
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $rowsem = mysqli_num_rows($result);
                                                                            if ($rowsem > 0) {
                                                                                if ($row <= 1) {
                                                                                    if (($row1 && $row) == 0) {
                                                                            ?>
                                                                                    <?php
                                                                                    } elseif ($row1 < 1) {
                                                                                    ?>
                                                                                        <i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i>
                                                                                    <?php
                                                                                    } elseif ($row1 >= 1) {
                                                                                    ?>
                                                                                        <i class="fa fa-check text-success"><b>ผ่าน</b></i>
                                                                                    <?php
                                                                                    }
                                                                                } elseif ($row > 1) {
                                                                                    $rowresult = ($row - $row1);
                                                                                    if ($rowresult >= 2) {
                                                                                    ?>
                                                                                        <i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i>
                                                                                    <?php
                                                                                    } elseif ($rowresult < 2) {
                                                                                    ?>
                                                                                        <i class="fa fa-check text-success"><b>ผ่าน</b></i>
                                                                            <?php
                                                                                    }
                                                                                }
                                                                            } else if ($rowsem < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                    </tr>
                                                                <!--act3อบรมคุณธรรมจริยธรรม-->
                                                                    <tr>
                                                                    <td><a href="javascript:;">อบรมคุณธรรมจริยธรรม</a></td>
                                                                        <td>ตลอดทั้งปีการศึกษา</td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*, actsem.*,acttype.* 
                                                                                FROM activity 
                                                                                JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'อบรมคุณธรรมจริยธรรม' 
                                                                                && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actMainorg = '$fct' || activity.actSec = 'มหาวิทยาลัย') 
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row = mysqli_num_rows($result);
                                                                            $rowget = mysqli_fetch_assoc($result);
                                                                            // output data of each row
                                                                            ?>
                                                                            <?php if ($row > 0) {
                                                                            ?>
                                                                                <a href="actall_year.php?acttype=<?php echo $rowget['acttypeName']; ?>&&actyear=<?php echo $year ?>"><?php echo $row ?></a>
                                                                            <?php
                                                                            } else if ($row < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*,acttype.*,actregister.*
                                                                                FROM actregister 
                                                                                JOIN activity ON activity.actID = actregister.actregactID
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'อบรมคุณธรรมจริยธรรม' && actregister.actregstdID ='$stdUser' 
                                                                                && actregister.actregStatus='ยืนยันเรียบร้อย'
                                                                                && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row1 = mysqli_num_rows($result);
                                                                            $rowget1 = mysqli_fetch_assoc($result);
                                                                            if ($row1 > 0) {
                                                                            ?>
                                                                                <a href="actreg_year.php?acttype=<?php echo $rowget1['acttypeName']; ?>&&actyear=<?php echo $year ?>"><?php echo $row1 ?></a>
                                                                            <?php
                                                                            } else if ($row1 < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT actsem.*, activity.*
                                                                                FROM actsem 
                                                                                JOIN activity ON activity.actSem = actsem.actsemNo
                                                                                WHERE 
                                                                                activity.actYear = '$year' && actsem.actsem = '2' && actsem.actsemStatus = 'สำเร็จกิจกรรมแล้ว'
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $rowsem = mysqli_num_rows($result);
                                                                            if ($rowsem > 0) {
                                                                                if ($row <= 1) {
                                                                                    if (($row1 && $row) == 0) {
                                                                            ?>
                                                                                    <?php
                                                                                    } elseif ($row1 < 1) {
                                                                                    ?>
                                                                                        <i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i>
                                                                                    <?php
                                                                                    } elseif ($row1 >= 1) {
                                                                                    ?>
                                                                                        <i class="fa fa-check text-success"><b>ผ่าน</b></i>
                                                                                    <?php
                                                                                    }
                                                                                } elseif ($row > 1) {
                                                                                    $rowresult = ($row - $row1);
                                                                                    if ($rowresult >= 2) {
                                                                                    ?>
                                                                                        <i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i>
                                                                                    <?php
                                                                                    } elseif ($rowresult < 2) {
                                                                                    ?>
                                                                                        <i class="fa fa-check text-success"><b>ผ่าน</b></i>
                                                                            <?php
                                                                                    }
                                                                                }
                                                                            } else if ($rowsem < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                    </tr>
                                                                <!--act4ค่ายพัฒนานักศึกษา-->
                                                                    <tr>
                                                                    <td ><a href="javascript:;">ค่ายพัฒนานักศึกษา</a></td>
                                                                        <td>ชั้นปีที่ 1</td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*, actsem.*,acttype.* 
                                                                                FROM activity 
                                                                                JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'ค่ายพัฒนานักศึกษา(ปี1)' && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actMainorg = '$fct' || activity.actSec = 'มหาวิทยาลัย') 
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row = mysqli_num_rows($result);
                                                                            $rowget = mysqli_fetch_assoc($result);
                                                                            // output data of each row
                                                                            ?>
                                                                            <?php if ($row > 0) {
                                                                            ?>
                                                                                <a href="actall_year.php?acttype=<?php echo $rowget['acttypeName']; ?>&&actyear=<?php echo $year ?>"><?php echo $row ?></a>
                                                                            <?php
                                                                            } elseif ($row < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*,acttype.*,actregister.*
                                                                                FROM actregister 
                                                                                JOIN activity ON activity.actID = actregister.actregactID
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'ค่ายพัฒนานักศึกษา(ปี1)' && actregister.actregstdID ='$stdUser' 
                                                                                && actregister.actregStatus='ยืนยันเรียบร้อย'
                                                                                && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row1 = mysqli_num_rows($result);
                                                                            $rowget1 = mysqli_fetch_assoc($result);
                                                                            if ($row1 > 0) {
                                                                            ?>
                                                                                <a href="actreg_year.php?acttype=<?php echo $rowget1['acttypeName']; ?>&&actyear=<?php echo $year ?>"><?php echo $row1 ?></a>
                                                                            <?php
                                                                            } else if ($row1 < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT actsem.*, activity.*
                                                                                FROM actsem 
                                                                                JOIN activity ON activity.actSem = actsem.actsemNo
                                                                                WHERE 
                                                                                activity.actYear = '$year' && actsem.actsem = '2' && actsem.actsemStatus = 'สำเร็จกิจกรรมแล้ว'
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $rowsem = mysqli_num_rows($result);
                                                                            if ($rowsem > 0) {
                                                                                if ($row <= 1) {
                                                                                    if (($row1 && $row) == 0) {
                                                                            ?>
                                                                                    <?php
                                                                                    } elseif ($row1 < 1) {
                                                                                    ?>
                                                                                        <i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i>
                                                                                    <?php
                                                                                    } elseif ($row1 >= 1) {
                                                                                    ?>
                                                                                        <i class="fa fa-check text-success"><b>ผ่าน</b></i>
                                                                                    <?php
                                                                                    }
                                                                                } elseif ($row > 1) {
                                                                                    $rowresult = ($row - $row1);
                                                                                    if ($rowresult >= 2) {
                                                                                    ?>
                                                                                        <i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i>
                                                                                    <?php
                                                                                    } elseif ($rowresult < 2) {
                                                                                    ?>
                                                                                        <i class="fa fa-check text-success"><b>ผ่าน</b></i>
                                                                            <?php
                                                                                    }
                                                                                }
                                                                            } else if ($rowsem < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                    </tr>
                                                                <!--act5อิอฺติก๊าฟ-->
                                                                    <tr>
                                                                    <td><a href="javascript:;">อิอฺติก๊าฟ 10 วันสุดท้ายเดือนรอมฎอน</a></td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT * 
                                                                                FROM eiatiqaf
                                                                                WHERE 
                                                                                eiatiqafstdID = '$stdUser' && eiatiqafYear = '$year' 
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $rowfile = mysqli_num_rows($result);
                                                                            $rowfileeia = mysqli_fetch_assoc($result);
                                                                            // output data of each row
                                                                            ?>
                                                                            <?php if ($rowfile > 0) {
                                                                            ?>
                                                                                <form enctype="multipart/form-data" method="post">
                                                                                    <input class="input-group" type="hidden" name="eiatiqafNo" value="<?php echo $rowfileeia['eiatiqafNo']; ?>" />
                                                                                    <input class="input-group" type="file" name="file" accept="file/*" />
                                                                                    <button class="btn btn-warning btn-xs" type="submit" name="btupdatefile">แก้ไข</button>
                                                                                </form>
                                                                                <?php
                                                                            } else if ($rowfile == 0) {
                                                                                $sql = "SELECT * FROM acttype
                                                                                WHERE acttypeName = 'อิอฺติก๊าฟ 10 วันสุดท้ายเดือนรอมฎอน'
                                                                                ";
                                                                                $result = $conn->query($sql);

                                                                                if ($result->num_rows > 0) {
                                                                                    while ($row = $result->fetch_assoc()) {
                                                                                        $acttypeNo = $row["acttypeNo"];
                                                                                ?>
                                                                                        <form enctype="multipart/form-data" method="post">
                                                                                            <input class="input-group" type="hidden" name="acttype" value="<?php echo $acttypeNo ?>" />
                                                                                    <?php }
                                                                                } else {
                                                                                    echo "something";
                                                                                } ?>
                                                                                    <input class="input-group" type="hidden" name="year" value="<?php echo $year ?>" />
                                                                                    <input class="input-group" type="hidden" name="stdid" value="<?php echo $stdUser ?>" />
                                                                                    <input class="input-group" type="file" name="file" accept="file/*" />
                                                                                    <button class="btn btn-info btn-xs" type="submit" name="btaddfile">เพิ่ม</button>
                                                                                        </form>
                                                                                    <?php  }
                                                                                    ?>

                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*,acttype.* 
                                                                                FROM activity 
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'อิอฺติก๊าฟ 10 วันสุดท้ายเดือนรอมฎอน' 
                                                                                && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actMainorg = '$fct' || activity.actSec = 'มหาวิทยาลัย') 
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row = mysqli_num_rows($result);
                                                                            $rowget = mysqli_fetch_assoc($result);
                                                                            // output data of each row
                                                                            ?>
                                                                            <?php if ($row > 0) {
                                                                            ?>
                                                                                <a href="actall_year.php?acttype=<?php echo $rowget['acttypeName']; ?>&&actyear=<?php echo $year ?>"><?php echo $row ?></a>
                                                                            <?php
                                                                            } else if ($row < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            if($rowfile>0){?> 
                                                                            <a href="../file/<?php echo $rowfileeia['eiatiqafFile']; ?>"><?php echo $rowfileeia['eiatiqafFile'] ?></a>
                                                                            <?php } else{
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*,acttype.*,actregister.*
                                                                                FROM actregister 
                                                                                JOIN activity ON activity.actID = actregister.actregactID
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'อิอฺติก๊าฟ 10 วันสุดท้ายเดือนรอมฎอน' && actregister.actregstdID ='$stdUser' 
                                                                                && actregister.actregStatus='ยืนยันเรียบร้อย'
                                                                                && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row1 = mysqli_num_rows($result);
                                                                            $rowget1 = mysqli_fetch_assoc($result);
                                                                            if ($row1 > 0) {
                                                                            ?>
                                                                                <a href="actreg_year.php?acttype=<?php echo $rowget1['acttypeName']; ?>&&actyear=<?php echo $year ?>"><?php echo $row1 ?></a>
                                                                            <?php
                                                                            } else if ($row1 < 0) {
                                                                            }}
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT actsem.*, activity.*
                                                                                FROM actsem 
                                                                                JOIN activity ON activity.actSem = actsem.actsemNo
                                                                                WHERE 
                                                                                activity.actYear = '$year' && actsem.actsem = '2' && actsem.actsemStatus = 'สำเร็จกิจกรรมแล้ว'
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $rowsem = mysqli_num_rows($result);
                                                                            if ($rowsem > 0) {
                                                                                if($rowfile==1){?>
                                                                                    <i class="fa fa-check text-success"><b>ผ่าน</b></i>
                                                                                <?php }else{
                                                                                if ($row <= 1) {
                                                                                    if (($row1 && $row) == 0) {
                                                                            ?>
                                                                                    <?php
                                                                                    } elseif ($row1 < 1) {
                                                                                    ?>
                                                                                        <i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i>
                                                                                    <?php
                                                                                    } elseif ($row1 >= 1) {
                                                                                    ?>
                                                                                        <i class="fa fa-check text-success"><b>ผ่าน</b></i>
                                                                                    <?php
                                                                                    }
                                                                                } elseif ($row > 1) {
                                                                                    $rowresult = ($row - $row1);
                                                                                    if ($rowresult >= 2) {
                                                                                    ?>
                                                                                        <i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i>
                                                                                    <?php
                                                                                    } elseif ($rowresult < 2) {
                                                                                    ?>
                                                                                        <i class="fa fa-check text-success"><b>ผ่าน</b></i>
                                                                            <?php
                                                                                    }
                                                                                }}
                                                                            } else if ($rowsem < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                    </tr>
                                                                <!--act6ปฐมนิเทศ-->
                                                                    <tr>
                                                                    <td><a href="javascript:;">ปฐมนิเทศ</a></td>
                                                                        <td>ชั้นปีที่ 1</td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*, actsem.*,acttype.* 
                                                                                FROM activity 
                                                                                JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'ปฐมนิเทศ' && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && activity.actSec = 'มหาวิทยาลัย' 
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row = mysqli_num_rows($result);
                                                                            $rowget = mysqli_fetch_assoc($result);
                                                                            // output data of each row
                                                                            ?>
                                                                            <?php if ($row > 0) {
                                                                            ?>
                                                                                <a href="actall_year.php?acttype=<?php echo $rowget['acttypeName']; ?>&&actyear=<?php echo $year ?>"><?php echo $row ?></a>
                                                                            <?php
                                                                            } elseif ($row < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*,acttype.*,actregister.*
                                                                                FROM actregister 
                                                                                JOIN activity ON activity.actID = actregister.actregactID
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'ปฐมนิเทศ' && actregister.actregstdID ='$stdUser' 
                                                                                && actregister.actregStatus='ยืนยันเรียบร้อย'
                                                                                && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row1 = mysqli_num_rows($result);
                                                                            $rowget1 = mysqli_fetch_assoc($result);
                                                                            if ($row1 > 0) {
                                                                            ?>
                                                                                <a href="actreg_year.php?acttype=<?php echo $rowget1['acttypeName']; ?>&&actyear=<?php echo $year ?>"><?php echo $row1 ?></a>
                                                                            <?php
                                                                            } else if ($row1 < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT actsem.*, activity.*
                                                                                FROM actsem 
                                                                                JOIN activity ON activity.actSem = actsem.actsemNo
                                                                                WHERE 
                                                                                activity.actYear = '$year' && actsem.actsem = '2' && actsem.actsemStatus = 'สำเร็จกิจกรรมแล้ว'
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $rowsem = mysqli_num_rows($result);
                                                                            if ($rowsem > 0) {
                                                                                if ($row <= 1) {
                                                                                    if (($row1 && $row) == 0) {
                                                                            ?>
                                                                                    <?php
                                                                                    } elseif ($row1 < 1) {
                                                                                    ?>
                                                                                        <i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i>
                                                                                    <?php
                                                                                    } elseif ($row1 >= 1) {
                                                                                    ?>
                                                                                        <i class="fa fa-check text-success"><b>ผ่าน</b></i>
                                                                                    <?php
                                                                                    }
                                                                                } elseif ($row > 1) {
                                                                                    $rowresult = ($row - $row1);
                                                                                    if ($rowresult >= 2) {
                                                                                    ?>
                                                                                        <i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i>
                                                                                    <?php
                                                                                    } elseif ($rowresult < 2) {
                                                                                    ?>
                                                                                        <i class="fa fa-check text-success"><b>ผ่าน</b></i>
                                                                            <?php
                                                                                    }
                                                                                }
                                                                            } else if ($rowsem < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                    </tr>
                                                                <!--act7ชมรม-->
                                                                    <tr>
                                                                    <td><a href="javascript:;">กิจกรรมชมรม</a></td>
                                                                        <td><?php echo $clubname ?></td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*, actsem.*,acttype.*
                                                                                FROM activity 
                                                                                JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'กิจกรรมชมรม' && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && activity.actSec = 'มหาวิทยาลัย' && activity.actOrgtion = '$club'
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row = mysqli_num_rows($result);
                                                                            $rowget = mysqli_fetch_assoc($result);
                                                                            // output data of each row
                                                                            ?>
                                                                            <?php if ($row > 0) {
                                                                            ?>
                                                                                <a href="actall_year.php?acttype=<?php echo $rowget['acttypeName']; ?>&&actyear=<?php echo $year ?>"><?php echo $row ?></a>
                                                                            <?php
                                                                            } else if ($row < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*,acttype.*,actregister.*
                                                                                FROM actregister 
                                                                                JOIN activity ON activity.actID = actregister.actregactID
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'กิจกรรมชมรม' && actregister.actregstdID ='$stdUser' 
                                                                                && actregister.actregStatus='ยืนยันเรียบร้อย'
                                                                                && activity.actYear = '$year' 
                                                                                && activity.actSec = 'มหาวิทยาลัย' && activity.actOrgtion = '$club'
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row1 = mysqli_num_rows($result);
                                                                            $rowget1 = mysqli_fetch_assoc($result);
                                                                            if ($row1 > 0) {
                                                                            ?>
                                                                                <a href="actreg_year.php?acttype=<?php echo $rowget1['acttypeName']; ?>&&actyear=<?php echo $year ?>"><?php echo $row1 ?></a>
                                                                            <?php
                                                                            } else if ($row1 < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT actsem.*, activity.*
                                                                                FROM actsem 
                                                                                JOIN activity ON activity.actSem = actsem.actsemNo
                                                                                WHERE 
                                                                                activity.actYear = '$year' && actsem.actsem = '2' && actsem.actsemStatus = 'สำเร็จกิจกรรมแล้ว'
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $rowsem = mysqli_num_rows($result);
                                                                            if ($rowsem > 0) {
                                                                                if ($row <= 1) {
                                                                                    if (($row1 && $row) == 0) {
                                                                            ?>
                                                                                    <?php
                                                                                    } elseif ($row1 < 1) {
                                                                                    ?>
                                                                                        <i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i>
                                                                                    <?php
                                                                                    } elseif ($row1 >= 1) {
                                                                                    ?>
                                                                                        <i class="fa fa-check text-success"><b>ผ่าน</b></i>
                                                                                    <?php
                                                                                    }
                                                                                } elseif ($row > 1) {
                                                                                    $rowresult = ($row - $row1);
                                                                                    if ($rowresult >= 2) {
                                                                                    ?>
                                                                                        <i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i>
                                                                                    <?php
                                                                                    } elseif ($rowresult < 2) {
                                                                                    ?>
                                                                                        <i class="fa fa-check text-success"><b>ผ่าน</b></i>
                                                                            <?php
                                                                                    }
                                                                                }
                                                                            } else if ($rowsem < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                    </tr>
                                                                <!--act8ชุมนุม-->
                                                                    <tr>
                                                                    <td><a href="javascript:;">กิจกรรมชุมนุม</a></td>
                                                                        <td><?php echo $dpmName ?></td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*, actsem.*,acttype.*, organization.*
                                                                                FROM activity 
                                                                                JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                JOIN organization ON activity.actOrgtion = organization.orgtionNo
                                                                                WHERE 
                                                                                acttype.acttypeName = 'กิจกรรมชุมนุม' && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actMainorg = '$fct' && organization.organization = '$dpmName')
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row = mysqli_num_rows($result);
                                                                            $rowget = mysqli_fetch_assoc($result);
                                                                            // output data of each row
                                                                            ?>
                                                                            <?php if ($row > 0) {
                                                                            ?>
                                                                                <a href="actall_year.php?acttype=<?php echo $rowget['acttypeName']; ?>&&actyear=<?php echo $year ?>"><?php echo $row ?></a>
                                                                            <?php
                                                                            } else if ($row < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*,acttype.*,actregister.*, organization.*
                                                                                FROM actregister 
                                                                                JOIN activity ON activity.actID = actregister.actregactID
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                JOIN organization ON activity.actOrgtion = organization.orgtionNo
                                                                                WHERE 
                                                                                acttype.acttypeName = 'กิจกรรมชุมนุม' && actregister.actregstdID ='$stdUser' 
                                                                                && actregister.actregStatus='ยืนยันเรียบร้อย'
                                                                                && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actMainorg = '$fct' && organization.organization = '$dpmName')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row1 = mysqli_num_rows($result);
                                                                            $rowget1 = mysqli_fetch_assoc($result);
                                                                            if ($row1 > 0) {
                                                                            ?>
                                                                                <a href="actreg_year.php?acttype=<?php echo $rowget1['acttypeName']; ?>&&actyear=<?php echo $year ?>"><?php echo $row1 ?></a>
                                                                            <?php
                                                                            } else if ($row1 < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT actsem.*, activity.*
                                                                                FROM actsem 
                                                                                JOIN activity ON activity.actSem = actsem.actsemNo
                                                                                WHERE 
                                                                                activity.actYear = '$year' && actsem.actsem = '2' && actsem.actsemStatus = 'สำเร็จกิจกรรมแล้ว'
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $rowsem = mysqli_num_rows($result);
                                                                            if ($rowsem > 0) {
                                                                                if ($row <= 1) {
                                                                                    if (($row1 && $row) == 0) {
                                                                            ?>
                                                                                    <?php
                                                                                    } elseif ($row1 < 1) {
                                                                                    ?>
                                                                                        <i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i>
                                                                                    <?php
                                                                                    } elseif ($row1 >= 1) {
                                                                                    ?>
                                                                                        <i class="fa fa-check text-success"><b>ผ่าน</b></i>
                                                                                    <?php
                                                                                    }
                                                                                } elseif ($row > 1) {
                                                                                    $rowresult = ($row - $row1);
                                                                                    if ($rowresult >= 2) {
                                                                                    ?>
                                                                                        <i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i>
                                                                                    <?php
                                                                                    } elseif ($rowresult < 2) {
                                                                                    ?>
                                                                                        <i class="fa fa-check text-success"><b>ผ่าน</b></i>
                                                                            <?php
                                                                                    }
                                                                                }
                                                                            } else if ($rowsem < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                    </tr>
                                                                <!--act9กิจกรรมอบศ-->
                                                                    <tr>
                                                                    <td><a href="javascript:;">เข้าร่วม 5 กิจกรรมที่จัดโดยองค์การบริหารนักศึกษา</a></td>
                                                                        <td>ตลอดทั้งปีการศึกษา</td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*, actsem.*,acttype.*,mainorg.*,organization.* 
                                                                                FROM activity 
                                                                                JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                JOIN mainorg ON mainorg.mainorgNo = activity.actMainorg
                                                                                JOIN organization ON organization.orgtionNo = activity.actOrgtion
                                                                                WHERE 
                                                                                acttype.acttypeName = 'กิจกรรมองค์การบริหารนักศึกษา' 
                                                                                && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (mainorg.mainorg = 'องค์การบริหารนักศึกษา' || organization.organization = 'องค์การบริหารนักศึกษา') 
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row = mysqli_num_rows($result);
                                                                            $rowget = mysqli_fetch_assoc($result);
                                                                            // output data of each row
                                                                            ?>
                                                                            <?php if ($row > 0) {
                                                                            ?>
                                                                                <a href="actall_year.php?acttype=<?php echo $rowget['acttypeName']; ?>&&actyear=<?php echo $year ?>"><?php echo $row ?></a>
                                                                            <?php
                                                                            } else if ($row < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*,acttype.*,actregister.*,mainorg.*,organization.* 
                                                                                FROM actregister 
                                                                                JOIN activity ON activity.actID = actregister.actregactID
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                JOIN mainorg ON mainorg.mainorgNo = activity.actMainorg
                                                                                JOIN organization ON organization.orgtionNo = activity.actOrgtion
                                                                                WHERE 
                                                                                acttype.acttypeName = 'กิจกรรมองค์การบริหารนักศึกษา' && actregister.actregstdID ='$stdUser' 
                                                                                && actregister.actregStatus='ยืนยันเรียบร้อย'
                                                                                && activity.actYear = '$year' 
                                                                                && (mainorg.mainorg = 'องค์การบริหารนักศึกษา' || organization.organization = 'องค์การบริหารนักศึกษา') 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row1 = mysqli_num_rows($result);
                                                                            $rowget1 = mysqli_fetch_assoc($result);
                                                                            if ($row1 > 0) {
                                                                            ?>
                                                                                <a href="actreg_year.php?acttype=<?php echo $rowget1['acttypeName']; ?>&&actyear=<?php echo $year ?>"><?php echo $row1 ?></a>
                                                                            <?php
                                                                            } else if ($row1 < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT actsem.*, activity.*
                                                                                FROM actsem 
                                                                                JOIN activity ON activity.actSem = actsem.actsemNo
                                                                                WHERE 
                                                                                activity.actYear = '$year' && actsem.actsem = '2' && actsem.actsemStatus = 'สำเร็จกิจกรรมแล้ว'
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $rowsem = mysqli_num_rows($result);
                                                                            if ($rowsem > 0) {
                                                                                if ($row <= 1) {
                                                                                    if (($row1 && $row) == 0) {
                                                                            ?>
                                                                                    <?php
                                                                                    } elseif ($row1 < 1) {
                                                                                    ?>
                                                                                        <i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i>
                                                                                    <?php
                                                                                    } elseif ($row1 >= 1) {
                                                                                    ?>
                                                                                        <i class="fa fa-check text-success"><b>ผ่าน</b></i>
                                                                                    <?php
                                                                                    }
                                                                                } elseif ($row > 1) {
                                                                                    $rowresult = ($row - $row1);
                                                                                    if (($rowresult < 2) || ($row1 = 5)) {
                                                                                    ?>
                                                                                        <i class="fa fa-check text-success"><b>ผ่าน</b></i>
                                                                                    <?php } elseif ($rowresult >= 2) {
                                                                                    ?>
                                                                                        <i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i>
                                                                            <?php
                                                                                    }
                                                                                }
                                                                            } else if ($rowsem < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                    </tr>
                                                                <!--act10กิจกรรมสโมสร-->
                                                                    <tr>
                                                                    <td><a href="javascript:;">เข้าร่วม 5 กิจกรรมที่จัดโดยสโมสรคณะ</a></td>
                                                                        <td>ตลอดทั้งปีการศึกษา</td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*, actsem.*,acttype.*, organization.* 
                                                                                FROM activity 
                                                                                JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                JOIN organization ON activity.actOrgtion = organization.orgtionNo
                                                                                WHERE 
                                                                                acttype.acttypeName = 'กิจกรรมสโมรสรคณะ' 
                                                                                && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actMainorg = '$fct' || organization.organization = 'สโมสรคณะ') 
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row = mysqli_num_rows($result);
                                                                            $rowget = mysqli_fetch_assoc($result);
                                                                            // output data of each row
                                                                            ?>
                                                                            <?php if ($row > 0) {
                                                                            ?>
                                                                                <a href="actall_year.php?acttype=<?php echo $rowget['acttypeName']; ?>&&actyear=<?php echo $year ?>"><?php echo $row ?></a>
                                                                            <?php  } else if ($row < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*,acttype.*,actregister.*, organization.*
                                                                                FROM actregister 
                                                                                JOIN activity ON activity.actID = actregister.actregactID
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                JOIN organization ON activity.actOrgtion = organization.orgtionNo
                                                                                WHERE 
                                                                                acttype.acttypeName = 'กิจกรรมสโมสรคณะ' && actregister.actregstdID ='$stdUser' 
                                                                                && actregister.actregStatus='ยืนยันเรียบร้อย'
                                                                                && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actMainorg = '$fct' || organization.organization = 'สโมสรคณะ') 
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row1 = mysqli_num_rows($result);
                                                                            $rowget1 = mysqli_fetch_assoc($result);
                                                                            if ($row1 > 0) {
                                                                            ?>
                                                                                <a href="actreg_year.php?acttype=<?php echo $rowget1['acttypeName']; ?>&&actyear=<?php echo $year ?>"><?php echo $row1 ?></a>
                                                                            <?php
                                                                            } else if ($row1 < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT actsem.*, activity.*
                                                                                FROM actsem 
                                                                                JOIN activity ON activity.actSem = actsem.actsemNo
                                                                                WHERE 
                                                                                activity.actYear = '$year' && actsem.actsem = '2' && actsem.actsemStatus = 'สำเร็จกิจกรรมแล้ว'
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $rowsem = mysqli_num_rows($result);
                                                                            if ($rowsem > 0) {
                                                                                if ($row <= 1) {
                                                                                    if (($row1 && $row) == 0) {
                                                                            ?>
                                                                                    <?php
                                                                                    } elseif ($row1 < 1) {
                                                                                    ?>
                                                                                        <i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i>
                                                                                    <?php
                                                                                    } elseif ($row1 >= 1) {
                                                                                    ?>
                                                                                        <i class="fa fa-check text-success"><b>ผ่าน</b></i>
                                                                                    <?php
                                                                                    }
                                                                                } elseif ($row > 1) {
                                                                                    $rowresult = ($row - $row1);
                                                                                    if (($rowresult < 2) || ($row1 = 5)) {
                                                                                    ?>
                                                                                        <i class="fa fa-check text-success"><b>ผ่าน</b></i>
                                                                                    <?php } elseif ($rowresult >= 2) {
                                                                                    ?>
                                                                                        <i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i>
                                                                            <?php
                                                                                    }
                                                                                }
                                                                            } else if ($rowsem < 0) {
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
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="tab-8-2">
                                                <div class="row justify-content-center">
                                                    <div class="col-md-12">
                                                        <?php
                                                        require_once '../../db/dbconfig.php';
                                                        $stmt = $DBcon->prepare("SELECT student.*, club.*,organization.*,department.* FROM student 
                                                            JOIN club ON club.clubstdID = student.stdID
                                                            JOIN organization ON club.clubOrgtion = organization.orgtionNo
                                                            JOIN department ON student.stdDpm = department.dpmNo
                                                            WHERE student.stdID = '$stdUser' && club.clubYear = student.stdYear+1 ");
                                                        $stmt->execute();
                                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                            $fct = $row["stdFct"];
                                                            $dpm = $row["stdDpm"];
                                                            $dpmName = $row["department"];
                                                            $year = $row["stdYear"] + 1;
                                                            $group = $row["stdGroup"];
                                                            $club = $row["clubOrgtion"];
                                                            $clubname = $row["organization"];

                                                        ?>
                                                            <table id="tbact1" class="table table-condensed ">
                                                                <thead>
                                                                <tr style="color:#528124;">
                                                                        <th>หมวดหมู่</th>
                                                                        <th></th>
                                                                        <th>จำนวนครั้งที่จัด</th>
                                                                        <th>จำนวนครั้งที่เข้าร่วม</th>
                                                                        <th>ผลการประเมิน</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                <!--act1กลุ่มศึกษาอัลกุรอ่าน-->
                                                                    <tr>
                                                                    <td><a href="javascript:;">กลุ่มศึกษาอัลกุรอ่าน</a></td>
                                                                        <td>ภาคเรียนที่ 1</td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <?php
                                                                        require_once '../../db/dbconfig.php';
                                                                        $stmt = $DBcon->prepare("SELECT halaqahstd.*, halaqahtc.* FROM halaqahstd
                                                                                                JOIN halaqahtc ON halaqahtc.halaqahtcNo = halaqahstd.halaqahID
                                                                                                WHERE halaqahstd.halaqahstdID = '$stdUser' && halaqahtc.halaqahtcYear = '$year'
                                                                                                ");
                                                                        $stmt->execute();
                                                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                                            if ($row['halaqahstdsem1Status'] == 'ผ่าน') { ?>
                                                                                <td><i class="fa fa-check text-success"><b><?php echo $row['halaqahstdsem1Status']; ?></b></i></td>
                                                                            <?php } else if ($row['halaqahstdsem1Status'] == 'ไม่ผ่าน') { ?>
                                                                                <td><i class="fa fa-times text-danger"><b><?php echo $row['halaqahstdsem1Status']; ?></b></i></td>
                                                                            <?php } else { ?>
                                                                                <td><?php echo $row['halaqahstdsem1Status']; ?></td>
                                                                        <?php }
                                                                        }
                                                                        ?>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="font-size:16px;width: 30%;border-top: 0px;"></td>
                                                                        <td>ภาคเรียนที่ 2</td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <?php
                                                                        require_once '../../db/dbconfig.php';
                                                                        $stmt = $DBcon->prepare("SELECT halaqahstd.*, halaqahtc.* FROM halaqahstd
                                                                                                JOIN halaqahtc ON halaqahtc.halaqahtcNo = halaqahstd.halaqahID
                                                                                                WHERE halaqahstd.halaqahstdID = '$stdUser' && halaqahtc.halaqahtcYear = '$year'
                                                                                                ");
                                                                        $stmt->execute();
                                                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                                            if ($row['halaqahstdsem2Status'] == 'ผ่าน') { ?>
                                                                                <td><i class="fa fa-check text-success"><b><?php echo $row['halaqahstdsem2Status']; ?></b></i></td>
                                                                            <?php } else if ($row['halaqahstdsem2Status'] == 'ไม่ผ่าน') { ?>
                                                                                <td><i class="fa fa-times text-danger"><b><?php echo $row['halaqahstdsem2Status']; ?></b></i></td>
                                                                            <?php } else { ?>
                                                                                <td><?php echo $row['halaqahstdsem2Status']; ?></td>
                                                                        <?php }
                                                                        }
                                                                        ?>
                                                                    </tr>
                                                                    <!--act2กิยามุลลัยล์-->
                                                                    <tr>
                                                                        <?php
                                                                        require_once '../../db/dbconfig.php';
                                                                        $sql = "SELECT activity.*, actsem.*,acttype.* 
                                                                            FROM activity 
                                                                            JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                            JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                            WHERE 
                                                                            acttype.acttypeName = 'กิยามุลลัยล์' 
                                                                            && (activity.actYear = '$year' && actsem.actsem = '1') 
                                                                            && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                            && (activity.actMainorg = '$fct' || activity.actSec = 'มหาวิทยาลัย') 
                                                                            && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                            ";
                                                                        $result = mysqli_query($conn, $sql);
                                                                        $row = mysqli_num_rows($result);
                                                                        $rowget = mysqli_fetch_assoc($result);
                                                                        ?>
                                                                        <td><a href="javascript:;">กิยามุลลัยล์</a></td>
                                                                        <td>ภาคเรียนที่ 1</td>
                                                                        <td>
                                                                            <?php if ($row > 0) {
                                                                            ?>
                                                                                <a href="actall_sem.php?acttype=<?php echo $rowget['acttypeName']; ?>&&actyear=<?php echo $year ?>&&actsem=<?php echo $rowget['actsem']; ?>"><?php echo $row ?></a>
                                                                            <?php } else if ($row < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*, actsem.*,acttype.*,actregister.*
                                                                                FROM actregister 
                                                                                JOIN activity ON activity.actID = actregister.actregactID
                                                                                JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'กิยามุลลัยล์' && actregister.actregstdID ='$stdUser' 
                                                                                && actregister.actregStatus='ยืนยันเรียบร้อย'
                                                                                && (activity.actYear = '$year' && actsem.actsem = '1') 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actMainorg = '$fct' || activity.actSec = 'มหาวิทยาลัย') 
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row1 = mysqli_num_rows($result);
                                                                            $rowget1 = mysqli_fetch_assoc($result);
                                                                            if ($row1 > 0) {
                                                                            ?>
                                                                                <a href="actreg_sem.php?acttype=<?php echo $rowget1['acttypeName']; ?>&&actyear=<?php echo $year ?>&&actsem=<?php echo $rowget1['actsem']; ?>"><?php echo $row1 ?></a>
                                                                            <?php } else if ($row1 < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT actsem.*, activity.*
                                                                                FROM actsem 
                                                                                JOIN activity ON activity.actSem = actsem.actsemNo
                                                                                WHERE 
                                                                                activity.actYear = '$year' && actsem.actsem = '1' && actsem.actsemStatus = 'สำเร็จกิจกรรมแล้ว'
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $rowsem = mysqli_num_rows($result);
                                                                            if ($rowsem > 0) {
                                                                                if ($row <= 1) {
                                                                                    if (($row1 && $row) == 0) {
                                                                            ?>
                                                                                    <?php
                                                                                    } elseif ($row1 < 1) {
                                                                                    ?>
                                                                                        <i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i>
                                                                                    <?php
                                                                                    } elseif ($row1 >= 1) {
                                                                                    ?>
                                                                                        <i class="fa fa-check text-success"><b>ผ่าน</b></i>
                                                                                    <?php
                                                                                    }
                                                                                } elseif ($row > 1) {
                                                                                    $rowresult = ($row - $row1);
                                                                                    if ($rowresult >= 2) {
                                                                                    ?>
                                                                                        <i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i>
                                                                                    <?php
                                                                                    } elseif ($rowresult < 2) {
                                                                                    ?>
                                                                                        <i class="fa fa-check text-success"><b>ผ่าน</b></i>
                                                                            <?php
                                                                                    }
                                                                                }
                                                                            } else if ($rowsem < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                    </tr>
                                                                    <!--กิยามุลลัยล์2-->
                                                                    <tr>
                                                                        <td style="font-size:16px;width: 30%;border-top: 0px;"></td>
                                                                        <td>ภาคเรียนที่ 2</td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*, actsem.*,acttype.* 
                                                                                FROM activity 
                                                                                JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'กิยามุลลัยล์' 
                                                                                && (activity.actYear = '$year' && actsem.actsem = '2') 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actMainorg = '$fct' || activity.actSec = 'มหาวิทยาลัย') 
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row = mysqli_num_rows($result);
                                                                            $rowget = mysqli_fetch_assoc($result);
                                                                            if ($row > 0) {
                                                                            ?>
                                                                                <a href="actall_sem.php?acttype=<?php echo $rowget['acttypeName']; ?>&&actyear=<?php echo $year ?>&&actsem=<?php echo $rowget['actsem']; ?>"><?php echo $row ?></a>
                                                                            <?php
                                                                            } elseif ($row < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*, actsem.*,acttype.*,actregister.*
                                                                                FROM actregister 
                                                                                JOIN activity ON activity.actID = actregister.actregactID
                                                                                JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'กิยามุลลัยล์' && actregister.actregstdID ='$stdUser' 
                                                                                && actregister.actregStatus='ยืนยันเรียบร้อย'
                                                                                && (activity.actYear = '$year' && actsem.actsem = '2') 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row1 = mysqli_num_rows($result);
                                                                            $rowget1 = mysqli_fetch_assoc($result);
                                                                            if ($row1 > 0) {
                                                                            ?>
                                                                                <a href="actreg_sem.php?acttype=<?php echo $rowget1['acttypeName']; ?>&&actyear=<?php echo $year ?>&&actsem=<?php echo $rowget1['actsem']; ?>"><?php echo $row1 ?></a>
                                                                            <?php
                                                                            } else if ($row1 < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT actsem.*, activity.*
                                                                                FROM actsem 
                                                                                JOIN activity ON activity.actSem = actsem.actsemNo
                                                                                WHERE 
                                                                                activity.actYear = '$year' && actsem.actsem = '2' && actsem.actsemStatus = 'สำเร็จกิจกรรมแล้ว'
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $rowsem = mysqli_num_rows($result);
                                                                            if ($rowsem > 0) {
                                                                                if ($row <= 1) {
                                                                                    if (($row1 && $row) == 0) {
                                                                            ?>
                                                                                    <?php
                                                                                    } elseif ($row1 < 1) {
                                                                                    ?>
                                                                                        <i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i>
                                                                                    <?php
                                                                                    } elseif ($row1 >= 1) {
                                                                                    ?>
                                                                                        <i class="fa fa-check text-success"><b>ผ่าน</b></i>
                                                                                    <?php
                                                                                    }
                                                                                } elseif ($row > 1) {
                                                                                    $rowresult = ($row - $row1);
                                                                                    if ($rowresult >= 2) {
                                                                                    ?>
                                                                                        <i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i>
                                                                                    <?php
                                                                                    } elseif ($rowresult < 2) {
                                                                                    ?>
                                                                                        <i class="fa fa-check text-success"><b>ผ่าน</b></i>
                                                                            <?php
                                                                                    }
                                                                                }
                                                                            } else if ($rowsem < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                    </tr>
                                                                <!--act3อบรมคุณธรรมจริยธรรม-->
                                                                    <tr>
                                                                    <td><a href="javascript:;">อบรมคุณธรรมจริยธรรม</a></td>
                                                                        <td>ตลอดทั้งปีการศึกษา</td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*, actsem.*,acttype.* 
                                                                                FROM activity 
                                                                                JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'อบรมคุณธรรมจริยธรรม' 
                                                                                && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actMainorg = '$fct' || activity.actSec = 'มหาวิทยาลัย') 
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row = mysqli_num_rows($result);
                                                                            $rowget = mysqli_fetch_assoc($result);
                                                                            // output data of each row
                                                                            ?>
                                                                            <?php if ($row > 0) {
                                                                            ?>
                                                                                <a href="actall_year.php?acttype=<?php echo $rowget['acttypeName']; ?>&&actyear=<?php echo $year ?>"><?php echo $row ?></a>
                                                                            <?php
                                                                            } else if ($row < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*,acttype.*,actregister.*
                                                                                FROM actregister 
                                                                                JOIN activity ON activity.actID = actregister.actregactID
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'อบรมคุณธรรมจริยธรรม' && actregister.actregstdID ='$stdUser' 
                                                                                && actregister.actregStatus='ยืนยันเรียบร้อย'
                                                                                && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row1 = mysqli_num_rows($result);
                                                                            $rowget1 = mysqli_fetch_assoc($result);
                                                                            if ($row1 > 0) {
                                                                            ?>
                                                                                <a href="actreg_year.php?acttype=<?php echo $rowget1['acttypeName']; ?>&&actyear=<?php echo $year ?>"><?php echo $row1 ?></a>
                                                                            <?php
                                                                            } else if ($row1 < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT actsem.*, activity.*
                                                                                FROM actsem 
                                                                                JOIN activity ON activity.actSem = actsem.actsemNo
                                                                                WHERE 
                                                                                activity.actYear = '$year' && actsem.actsem = '2' && actsem.actsemStatus = 'สำเร็จกิจกรรมแล้ว'
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $rowsem = mysqli_num_rows($result);
                                                                            if ($rowsem > 0) {
                                                                                if ($row <= 1) {
                                                                                    if (($row1 && $row) == 0) {
                                                                            ?>
                                                                                    <?php
                                                                                    } elseif ($row1 < 1) {
                                                                                    ?>
                                                                                        <i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i>
                                                                                    <?php
                                                                                    } elseif ($row1 >= 1) {
                                                                                    ?>
                                                                                        <i class="fa fa-check text-success"><b>ผ่าน</b></i>
                                                                                    <?php
                                                                                    }
                                                                                } elseif ($row > 1) {
                                                                                    $rowresult = ($row - $row1);
                                                                                    if ($rowresult >= 2) {
                                                                                    ?>
                                                                                        <i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i>
                                                                                    <?php
                                                                                    } elseif ($rowresult < 2) {
                                                                                    ?>
                                                                                        <i class="fa fa-check text-success"><b>ผ่าน</b></i>
                                                                            <?php
                                                                                    }
                                                                                }
                                                                            } else if ($rowsem < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                <!--act5อิอฺติก๊าฟ-->
                                                                    <tr>
                                                                    <td ><a href="javascript:;">อิอฺติก๊าฟ 10 วันสุดท้ายเดือนรอมฎอน</a></td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT * 
                                                                                FROM eiatiqaf
                                                                                WHERE 
                                                                                eiatiqafstdID = '$stdUser' && eiatiqafYear = '$year' 
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $rowfile = mysqli_num_rows($result);
                                                                            $rowfileeia = mysqli_fetch_assoc($result);
                                                                            // output data of each row
                                                                            ?>
                                                                            <?php if ($rowfile > 0) {
                                                                            ?>
                                                                                <form enctype="multipart/form-data" method="post">
                                                                                    <input class="input-group" type="hidden" name="eiatiqafNo" value="<?php echo $rowfileeia['eiatiqafNo']; ?>" />
                                                                                    <input class="input-group" type="hidden" name="eiatiqafFile" value="<?php echo $rowfileeia['eiatiqafFile']; ?>" />
                                                                                    <input class="input-group" type="file" name="file" accept="file/*" />
                                                                                    <button class="btn btn-warning btn-xs" type="submit" name="btupdatefile">แก้ไข</button>
                                                                                </form>
                                                                                <?php
                                                                            } else if ($rowfile == 0) {
                                                                                $sql = "SELECT * FROM acttype
                                                                                WHERE acttypeName = 'อิอฺติก๊าฟ 10 วันสุดท้ายเดือนรอมฎอน'
                                                                                ";
                                                                                $result = $conn->query($sql);

                                                                                if ($result->num_rows > 0) {
                                                                                    while ($row = $result->fetch_assoc()) {
                                                                                        $acttypeNo = $row["acttypeNo"];
                                                                                ?>
                                                                                        <form enctype="multipart/form-data" method="post">
                                                                                            <input class="input-group" type="hidden" name="acttype" value="<?php echo $acttypeNo ?>" />
                                                                                    <?php }
                                                                                } else {
                                                                                    echo "something";
                                                                                } ?>
                                                                                    <input class="input-group" type="hidden" name="year" value="<?php echo $year ?>" />
                                                                                    <input class="input-group" type="hidden" name="stdid" value="<?php echo $stdUser ?>" />
                                                                                    <input class="input-group" type="file" name="file" accept="file/*" />
                                                                                    <button class="btn btn-info btn-xs" type="submit" name="btaddfile">เพิ่ม</button>
                                                                                        </form>
                                                                                    <?php  }
                                                                                    ?>

                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*,acttype.* 
                                                                                FROM activity 
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'อิอฺติก๊าฟ 10 วันสุดท้ายเดือนรอมฎอน' 
                                                                                && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actMainorg = '$fct' || activity.actSec = 'มหาวิทยาลัย') 
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row = mysqli_num_rows($result);
                                                                            $rowget = mysqli_fetch_assoc($result);
                                                                            // output data of each row
                                                                            ?>
                                                                            <?php if ($row > 0) {
                                                                            ?>
                                                                                <a href="actall_year.php?acttype=<?php echo $rowget['acttypeName']; ?>&&actyear=<?php echo $year ?>"><?php echo $row ?></a>
                                                                            <?php
                                                                            } else if ($row < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            if($rowfile>0){?> 
                                                                            <a href="../file/<?php echo $rowfileeia['eiatiqafFile']; ?>"><?php echo $rowfileeia['eiatiqafFile'] ?></a>
                                                                            <?php } else{
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*,acttype.*,actregister.*
                                                                                FROM actregister 
                                                                                JOIN activity ON activity.actID = actregister.actregactID
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'อิอฺติก๊าฟ 10 วันสุดท้ายเดือนรอมฎอน' && actregister.actregstdID ='$stdUser' 
                                                                                && actregister.actregStatus='ยืนยันเรียบร้อย'
                                                                                && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row1 = mysqli_num_rows($result);
                                                                            $rowget1 = mysqli_fetch_assoc($result);
                                                                            if ($row1 > 0) {
                                                                            ?>
                                                                                <a href="actreg_year.php?acttype=<?php echo $rowget1['acttypeName']; ?>&&actyear=<?php echo $year ?>"><?php echo $row1 ?></a>
                                                                            <?php
                                                                            } else if ($row1 < 0) {
                                                                            }}
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT *
                                                                                FROM actyear 
                                                                                WHERE 
                                                                                actyear = '$year' && actyearStatus = 'สำเร็จกิจกรรมแล้ว'
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $rowsem = mysqli_num_rows($result);
                                                                            if ($rowsem > 0) {
                                                                                if($rowfile==1){?>
                                                                                    <i class="fa fa-check text-success"><b>ผ่าน</b></i>
                                                                                <?php }else{
                                                                                if ($row <= 1) {
                                                                                    if (($row1 && $row) == 0) {
                                                                            ?>
                                                                                    <?php
                                                                                    } elseif ($row1 < 1) {
                                                                                    ?>
                                                                                        <i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i>
                                                                                    <?php
                                                                                    } elseif ($row1 >= 1) {
                                                                                    ?>
                                                                                        <i class="fa fa-check text-success"><b>ผ่าน</b></i>
                                                                                    <?php
                                                                                    }
                                                                                } elseif ($row > 1) {
                                                                                    $rowresult = ($row - $row1);
                                                                                    if ($rowresult >= 2) {
                                                                                    ?>
                                                                                        <i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i>
                                                                                    <?php
                                                                                    } elseif ($rowresult < 2) {
                                                                                    ?>
                                                                                        <i class="fa fa-check text-success"><b>ผ่าน</b></i>
                                                                            <?php
                                                                                    }
                                                                                }}
                                                                            } else if ($rowsem < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                    </tr>
                                                                
                                                                <!--act7ชมรม-->
                                                                    <tr>

                                                                    <td><a href="javascript:;">กิจกรรมชมรม</a></td>
                                                                        <td><?php echo $clubname ?></td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*, actsem.*,acttype.*
                                                                                FROM activity 
                                                                                JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'กิจกรรมชมรม' && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && activity.actSec = 'มหาวิทยาลัย' && activity.actOrgtion = '$club'
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row = mysqli_num_rows($result);
                                                                            $rowget = mysqli_fetch_assoc($result);
                                                                            // output data of each row
                                                                            ?>
                                                                            <?php if ($row > 0) {
                                                                            ?>
                                                                                <a href="actall_year.php?acttype=<?php echo $rowget['acttypeName']; ?>&&actyear=<?php echo $year ?>"><?php echo $row ?></a>
                                                                            <?php
                                                                            } else if ($row < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*,acttype.*,actregister.*
                                                                                FROM actregister 
                                                                                JOIN activity ON activity.actID = actregister.actregactID
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'กิจกรรมชมรม' && actregister.actregstdID ='$stdUser' 
                                                                                && actregister.actregStatus='ยืนยันเรียบร้อย'
                                                                                && activity.actYear = '$year' 
                                                                                && activity.actSec = 'มหาวิทยาลัย' && activity.actOrgtion = '$club'
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row1 = mysqli_num_rows($result);
                                                                            $rowget1 = mysqli_fetch_assoc($result);
                                                                            if ($row1 > 0) {
                                                                            ?>
                                                                                <a href="actreg_year.php?acttype=<?php echo $rowget1['acttypeName']; ?>&&actyear=<?php echo $year ?>"><?php echo $row1 ?></a>
                                                                            <?php
                                                                            } else if ($row1 < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT actsem.*, activity.*
                                                                                FROM actsem 
                                                                                JOIN activity ON activity.actSem = actsem.actsemNo
                                                                                WHERE 
                                                                                activity.actYear = '$year' && actsem.actsem = '2' && actsem.actsemStatus = 'สำเร็จกิจกรรมแล้ว'
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $rowsem = mysqli_num_rows($result);
                                                                            if ($rowsem > 0) {
                                                                                if ($row <= 1) {
                                                                                    if (($row1 && $row) == 0) {
                                                                            ?>
                                                                                    <?php
                                                                                    } elseif ($row1 < 1) {
                                                                                    ?>
                                                                                        <i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i>
                                                                                    <?php
                                                                                    } elseif ($row1 >= 1) {
                                                                                    ?>
                                                                                        <i class="fa fa-check text-success"><b>ผ่าน</b></i>
                                                                                    <?php
                                                                                    }
                                                                                } elseif ($row > 1) {
                                                                                    $rowresult = ($row - $row1);
                                                                                    if ($rowresult >= 2) {
                                                                                    ?>
                                                                                        <i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i>
                                                                                    <?php
                                                                                    } elseif ($rowresult < 2) {
                                                                                    ?>
                                                                                        <i class="fa fa-check text-success"><b>ผ่าน</b></i>
                                                                            <?php
                                                                                    }
                                                                                }
                                                                            } else if ($rowsem < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                    </tr>
                                                                <!--act8ชุมนุม-->
                                                                    <tr>
                                                                    <td><a href="javascript:;">กิจกรรมชุมนุม</a></td>
                                                                        <td><?php echo $dpmName ?></td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*, actsem.*,acttype.*, organization.*
                                                                                FROM activity 
                                                                                JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                JOIN organization ON activity.actOrgtion = organization.orgtionNo
                                                                                WHERE 
                                                                                acttype.acttypeName = 'กิจกรรมชุมนุม' && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actMainorg = '$fct' && organization.organization = '$dpmName')
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row = mysqli_num_rows($result);
                                                                            $rowget = mysqli_fetch_assoc($result);
                                                                            // output data of each row
                                                                            ?>
                                                                            <?php if ($row > 0) {
                                                                            ?>
                                                                                <a href="actall_year.php?acttype=<?php echo $rowget['acttypeName']; ?>&&actyear=<?php echo $year ?>"><?php echo $row ?></a>
                                                                            <?php  } else if ($row < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*,acttype.*,actregister.*, organization.*
                                                                                FROM actregister 
                                                                                JOIN activity ON activity.actID = actregister.actregactID
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                JOIN organization ON activity.actOrgtion = organization.orgtionNo
                                                                                WHERE 
                                                                                acttype.acttypeName = 'กิจกรรมชุมนุม' && actregister.actregstdID ='$stdUser' 
                                                                                && actregister.actregStatus='ยืนยันเรียบร้อย'
                                                                                && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actMainorg = '$fct' && organization.organization = '$dpmName')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row1 = mysqli_num_rows($result);
                                                                            $rowget1 = mysqli_fetch_assoc($result);
                                                                            if ($row1 > 0) {
                                                                            ?>
                                                                                <a href="actreg_year.php?acttype=<?php echo $rowget1['acttypeName']; ?>&&actyear=<?php echo $year ?>"><?php echo $row1 ?></a>
                                                                            <?php
                                                                            } else if ($row1 < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT actsem.*, activity.*
                                                                                FROM actsem 
                                                                                JOIN activity ON activity.actSem = actsem.actsemNo
                                                                                WHERE 
                                                                                activity.actYear = '$year' && actsem.actsem = '2' && actsem.actsemStatus = 'สำเร็จกิจกรรมแล้ว'
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $rowsem = mysqli_num_rows($result);
                                                                            if ($rowsem > 0) {
                                                                                if ($row <= 1) {
                                                                                    if (($row1 && $row) == 0) {
                                                                            ?>
                                                                                    <?php
                                                                                    } elseif ($row1 < 1) {
                                                                                    ?>
                                                                                        <i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i>
                                                                                    <?php
                                                                                    } elseif ($row1 >= 1) {
                                                                                    ?>
                                                                                        <i class="fa fa-check text-success"><b>ผ่าน</b></i>
                                                                                    <?php
                                                                                    }
                                                                                } elseif ($row > 1) {
                                                                                    $rowresult = ($row - $row1);
                                                                                    if ($rowresult >= 2) {
                                                                                    ?>
                                                                                        <i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i>
                                                                                    <?php
                                                                                    } elseif ($rowresult < 2) {
                                                                                    ?>
                                                                                        <i class="fa fa-check text-success"><b>ผ่าน</b></i>
                                                                            <?php
                                                                                    }
                                                                                }
                                                                            } else if ($rowsem < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                    </tr>
                                                                <!--act9กิจกรรมอบศ-->
                                                                    <tr>
                                                                    <td><a href="javascript:;">เข้าร่วม 5 กิจกรรมที่จัดโดยองค์การบริหารนักศึกษา</a></td>
                                                                        <td>ตลอดทั้งปีการศึกษา</td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*, actsem.*,acttype.*,mainorg.*,organization.* 
                                                                                FROM activity 
                                                                                JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                JOIN mainorg ON mainorg.mainorgNo = activity.actMainorg
                                                                                JOIN organization ON organization.orgtionNo = activity.actOrgtion
                                                                                WHERE 
                                                                                acttype.acttypeName = 'กิจกรรมองค์การบริหารนักศึกษา' 
                                                                                && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (mainorg.mainorg = 'องค์การบริหารนักศึกษา' || organization.organization = 'องค์การบริหารนักศึกษา') 
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row = mysqli_num_rows($result);
                                                                            $rowget = mysqli_fetch_assoc($result);
                                                                            // output data of each row
                                                                            ?>
                                                                            <?php if ($row > 0) {
                                                                            ?>
                                                                                <a href="actall_year.php?acttype=<?php echo $rowget['acttypeName']; ?>&&actyear=<?php echo $year ?>"><?php echo $row ?></a>
                                                                            <?php
                                                                            } else if ($row < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*,acttype.*,actregister.*,mainorg.*,organization.* 
                                                                                FROM actregister 
                                                                                JOIN activity ON activity.actID = actregister.actregactID
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                JOIN mainorg ON mainorg.mainorgNo = activity.actMainorg
                                                                                JOIN organization ON organization.orgtionNo = activity.actOrgtion
                                                                                WHERE 
                                                                                acttype.acttypeName = 'กิจกรรมองค์การบริหารนักศึกษา' && actregister.actregstdID ='$stdUser' 
                                                                                && actregister.actregStatus='ยืนยันเรียบร้อย'
                                                                                && activity.actYear = '$year' 
                                                                                && (mainorg.mainorg = 'องค์การบริหารนักศึกษา' || organization.organization = 'องค์การบริหารนักศึกษา') 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row1 = mysqli_num_rows($result);
                                                                            $rowget1 = mysqli_fetch_assoc($result);
                                                                            if ($row1 > 0) {
                                                                            ?>
                                                                                <a href="actreg_year.php?acttype=<?php echo $rowget1['acttypeName']; ?>&&actyear=<?php echo $year ?>"><?php echo $row1 ?></a>
                                                                            <?php
                                                                            } else if ($row1 < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT actsem.*, activity.*
                                                                                FROM actsem 
                                                                                JOIN activity ON activity.actSem = actsem.actsemNo
                                                                                WHERE 
                                                                                activity.actYear = '$year' && actsem.actsem = '2' && actsem.actsemStatus = 'สำเร็จกิจกรรมแล้ว'
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $rowsem = mysqli_num_rows($result);
                                                                            if ($rowsem > 0) {
                                                                                if ($row <= 1) {
                                                                                    if (($row1 && $row) == 0) {
                                                                            ?>
                                                                                    <?php
                                                                                    } elseif ($row1 < 1) {
                                                                                    ?>
                                                                                        <i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i>
                                                                                    <?php
                                                                                    } elseif ($row1 >= 1) {
                                                                                    ?>
                                                                                        <i class="fa fa-check text-success"><b>ผ่าน</b></i>
                                                                                    <?php
                                                                                    }
                                                                                } elseif ($row > 1) {
                                                                                    $rowresult = ($row - $row1);
                                                                                    if (($rowresult < 2) || ($row1 = 5)) {
                                                                                    ?>
                                                                                        <i class="fa fa-check text-success"><b>ผ่าน</b></i>
                                                                                    <?php } elseif ($rowresult >= 2) {
                                                                                    ?>
                                                                                        <i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i>
                                                                            <?php
                                                                                    }
                                                                                }
                                                                            } else if ($rowsem < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                    </tr>
                                                                <!--act10กิจกรรมสโมสร-->
                                                                    <tr>
                                                                    <td><a href="javascript:;">เข้าร่วม 5 กิจกรรมที่จัดโดยสโมสรคณะ</a></td>
                                                                        <td>ตลอดทั้งปีการศึกษา</td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*, actsem.*,acttype.*, organization.* 
                                                                                FROM activity 
                                                                                JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                JOIN organization ON activity.actOrgtion = organization.orgtionNo
                                                                                WHERE 
                                                                                acttype.acttypeName = 'กิจกรรมสโมรสรคณะ' 
                                                                                && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actMainorg = '$fct' || organization.organization = 'สโมสรคณะ') 
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row = mysqli_num_rows($result);
                                                                            $rowget = mysqli_fetch_assoc($result);
                                                                            // output data of each row
                                                                            ?>
                                                                            <?php if ($row > 0) {
                                                                            ?>
                                                                                <a href="actall_year.php?acttype=<?php echo $rowget['acttypeName']; ?>&&actyear=<?php echo $year ?>"><?php echo $row ?></a>
                                                                            <?php } else if ($row < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*,acttype.*,actregister.*, organization.*
                                                                                FROM actregister 
                                                                                JOIN activity ON activity.actID = actregister.actregactID
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                JOIN organization ON activity.actOrgtion = organization.orgtionNo
                                                                                WHERE 
                                                                                acttype.acttypeName = 'กิจกรรมสโมสรคณะ' && actregister.actregstdID ='$stdUser' 
                                                                                && actregister.actregStatus='ยืนยันเรียบร้อย'
                                                                                && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actMainorg = '$fct' || organization.organization = 'สโมสรคณะ') 
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row1 = mysqli_num_rows($result);
                                                                            $rowget1 = mysqli_fetch_assoc($result);
                                                                            if ($row1 > 0) {
                                                                            ?>
                                                                                <a href="actreg_year.php?acttype=<?php echo $rowget1['acttypeName']; ?>&&actyear=<?php echo $year ?>"><?php echo $row1 ?></a>
                                                                            <?php
                                                                            } else if ($row1 < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT actsem.*, activity.*
                                                                                FROM actsem 
                                                                                JOIN activity ON activity.actSem = actsem.actsemNo
                                                                                WHERE 
                                                                                activity.actYear = '$year' && actsem.actsem = '2' && actsem.actsemStatus = 'สำเร็จกิจกรรมแล้ว'
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $rowsem = mysqli_num_rows($result);
                                                                            if ($rowsem > 0) {
                                                                                if ($row <= 1) {
                                                                                    if (($row1 && $row) == 0) {
                                                                            ?>
                                                                                    <?php
                                                                                    } elseif ($row1 < 1) {
                                                                                    ?>
                                                                                        <i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i>
                                                                                    <?php
                                                                                    } elseif ($row1 >= 1) {
                                                                                    ?>
                                                                                        <i class="fa fa-check text-success"><b>ผ่าน</b></i>
                                                                                    <?php
                                                                                    }
                                                                                } elseif ($row > 1) {
                                                                                    $rowresult = ($row - $row1);
                                                                                    if (($rowresult < 2) || ($row1 = 5)) {
                                                                                    ?>
                                                                                        <i class="fa fa-check text-success"><b>ผ่าน</b></i>
                                                                                    <?php } elseif ($rowresult >= 2) {
                                                                                    ?>
                                                                                        <i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i>
                                                                            <?php
                                                                                    }
                                                                                }
                                                                            } else if ($rowsem < 0) {
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
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="tab-8-3">
                                                <div class="row justify-content-center">
                                                    <div class="col-md-12">
                                                        <?php
                                                        require_once '../../db/dbconfig.php';
                                                        $stmt = $DBcon->prepare("SELECT student.*, club.*, organization.*,department.* FROM student 
                                                            JOIN club ON club.clubstdID = student.stdID
                                                            JOIN organization ON club.clubOrgtion = organization.orgtionNo
                                                            JOIN department ON student.stdDpm = department.dpmNo
                                                            WHERE student.stdID = '$stdUser' && club.clubYear = student.stdYear+2 ");
                                                        $stmt->execute();
                                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                            $fct = $row["stdFct"];
                                                            $dpm = $row["stdDpm"];
                                                            $dpmName = $row["department"];
                                                            $year = $row["stdYear"] + 2;
                                                            $group = $row["stdGroup"];
                                                            $club = $row["clubOrgtion"];
                                                            $clubname = $row["organization"];

                                                        ?>
                                                            <table id="tbact1" class="table table-condensed ">
                                                                <thead>
                                                                    <tr style="color:#528124;">
                                                                        <th>หมวดหมู่</th>
                                                                        <th></th>
                                                                        <th>จำนวนครั้งที่จัด</th>
                                                                        <th>จำนวนครั้งที่เข้าร่วม</th>
                                                                        <th>ผลการประเมิน</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                <!--act1กลุ่มศึกษาอัลกุรอ่าน-->
                                                                    <tr>
                                                                    <td><a href="javascript:;">กลุ่มศึกษาอัลกุรอ่าน</a></td>
                                                                        <td>ภาคเรียนที่ 1</td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <?php
                                                                        require_once '../../db/dbconfig.php';
                                                                        $stmt = $DBcon->prepare("SELECT halaqahstd.*, halaqahtc.* FROM halaqahstd
                                                                                                JOIN halaqahtc ON halaqahtc.halaqahtcNo = halaqahstd.halaqahID
                                                                                                WHERE halaqahstd.halaqahstdID = '$stdUser' && halaqahtc.halaqahtcYear = '$year'
                                                                                                ");
                                                                        $stmt->execute();
                                                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                                            if ($row['halaqahstdsem1Status'] == 'ผ่าน') { ?>
                                                                                <td><i class="fa fa-check text-success"><b><?php echo $row['halaqahstdsem1Status']; ?></b></i></td>
                                                                            <?php } else if ($row['halaqahstdsem1Status'] == 'ไม่ผ่าน') { ?>
                                                                                <td><i class="fa fa-times text-danger"><b><?php echo $row['halaqahstdsem1Status']; ?></b></i></td>
                                                                            <?php } else { ?>
                                                                                <td><?php echo $row['halaqahstdsem1Status']; ?></td>
                                                                        <?php }
                                                                        }
                                                                        ?>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="font-size:16px;width: 30%;border-top: 0px;"></td>
                                                                        <td>ภาคเรียนที่ 2</td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <?php
                                                                        require_once '../../db/dbconfig.php';
                                                                        $stmt = $DBcon->prepare("SELECT halaqahstd.*, halaqahtc.* FROM halaqahstd
                                                                                                JOIN halaqahtc ON halaqahtc.halaqahtcNo = halaqahstd.halaqahID
                                                                                                WHERE halaqahstd.halaqahstdID = '$stdUser' && halaqahtc.halaqahtcYear = '$year'
                                                                                                ");
                                                                        $stmt->execute();
                                                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                                            if ($row['halaqahstdsem2Status'] == 'ผ่าน') { ?>
                                                                                <td><i class="fa fa-check text-success"><b><?php echo $row['halaqahstdsem2Status']; ?></b></i></td>
                                                                            <?php } else if ($row['halaqahstdsem2Status'] == 'ไม่ผ่าน') { ?>
                                                                                <td><i class="fa fa-times text-danger"><b><?php echo $row['halaqahstdsem2Status']; ?></b></i></td>
                                                                            <?php } else { ?>
                                                                                <td><?php echo $row['halaqahstdsem2Status']; ?></td>
                                                                        <?php }
                                                                        }
                                                                        ?>
                                                                    </tr>
                                                                <!--act2กิยามุลลัยล์-->
                                                                    <tr>
                                                                        <?php
                                                                        require_once '../../db/dbconfig.php';
                                                                        $sql = "SELECT activity.*, actsem.*,acttype.* 
                                                                            FROM activity 
                                                                            JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                            JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                            WHERE 
                                                                            acttype.acttypeName = 'กิยามุลลัยล์' 
                                                                            && (activity.actYear = '$year' && actsem.actsem = '1') 
                                                                            && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                            && (activity.actMainorg = '$fct' || activity.actSec = 'มหาวิทยาลัย') 
                                                                            && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                            ";
                                                                        $result = mysqli_query($conn, $sql);
                                                                        $row = mysqli_num_rows($result);
                                                                        $rowget = mysqli_fetch_assoc($result);
                                                                        ?>
                                                                        <td><a href="javascript:;">กิยามุลลัยล์</a></td>
                                                                        <td>ภาคเรียนที่ 1</td>
                                                                        <td>
                                                                            <?php if ($row > 0) {
                                                                            ?>
                                                                                <a href="actall_sem.php?acttype=<?php echo $rowget['acttypeName']; ?>&&actyear=<?php echo $year ?>&&actsem=<?php echo $rowget['actsem']; ?>"><?php echo $row ?></a>
                                                                            <?php } else if ($row < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*, actsem.*,acttype.*,actregister.*
                                                                                FROM actregister 
                                                                                JOIN activity ON activity.actID = actregister.actregactID
                                                                                JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'กิยามุลลัยล์' && actregister.actregstdID ='$stdUser' 
                                                                                && actregister.actregStatus='ยืนยันเรียบร้อย'
                                                                                && (activity.actYear = '$year' && actsem.actsem = '1') 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actMainorg = '$fct' || activity.actSec = 'มหาวิทยาลัย') 
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row1 = mysqli_num_rows($result);
                                                                            $rowget1 = mysqli_fetch_assoc($result);
                                                                            if ($row1 > 0) {
                                                                            ?>
                                                                                <a href="actreg_sem.php?acttype=<?php echo $rowget1['acttypeName']; ?>&&actyear=<?php echo $year ?>&&actsem=<?php echo $rowget1['actsem']; ?>"><?php echo $row1 ?></a>
                                                                            <?php } else if ($row1 < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT actsem.*, activity.*
                                                                                FROM actsem 
                                                                                JOIN activity ON activity.actSem = actsem.actsemNo
                                                                                WHERE 
                                                                                activity.actYear = '$year' && actsem.actsem = '1' && actsem.actsemStatus = 'สำเร็จกิจกรรมแล้ว'
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $rowsem = mysqli_num_rows($result);
                                                                            if ($rowsem > 0) {
                                                                                if ($row <= 1) {
                                                                                    if (($row1 && $row) == 0) {
                                                                            ?>
                                                                                    <?php
                                                                                    } elseif ($row1 < 1) {
                                                                                    ?>
                                                                                        <i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i>
                                                                                    <?php
                                                                                    } elseif ($row1 >= 1) {
                                                                                    ?>
                                                                                        <i class="fa fa-check text-success"><b>ผ่าน</b></i>
                                                                                    <?php
                                                                                    }
                                                                                } elseif ($row > 1) {
                                                                                    $rowresult = ($row - $row1);
                                                                                    if ($rowresult >= 2) {
                                                                                    ?>
                                                                                        <i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i>
                                                                                    <?php
                                                                                    } elseif ($rowresult < 2) {
                                                                                    ?>
                                                                                        <i class="fa fa-check text-success"><b>ผ่าน</b></i>
                                                                            <?php
                                                                                    }
                                                                                }
                                                                            } else if ($rowsem < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                    </tr>
                                                                    <!--กิยามุลลัยล์2-->
                                                                    <tr>
                                                                        <td style="font-size:16px;width: 30%;border-top: 0px;"></td>
                                                                        <td>ภาคเรียนที่ 2</td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*, actsem.*,acttype.* 
                                                                                FROM activity 
                                                                                JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'กิยามุลลัยล์' 
                                                                                && (activity.actYear = '$year' && actsem.actsem = '2') 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actMainorg = '$fct' || activity.actSec = 'มหาวิทยาลัย') 
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row = mysqli_num_rows($result);
                                                                            $rowget = mysqli_fetch_assoc($result);
                                                                            if ($row > 0) {
                                                                            ?>
                                                                                <a href="actall_sem.php?acttype=<?php echo $rowget['acttypeName']; ?>&&actyear=<?php echo $year ?>&&actsem=<?php echo $rowget['actsem']; ?>"><?php echo $row ?></a>
                                                                            <?php
                                                                            } elseif ($row < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*, actsem.*,acttype.*,actregister.*
                                                                                FROM actregister 
                                                                                JOIN activity ON activity.actID = actregister.actregactID
                                                                                JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'กิยามุลลัยล์' && actregister.actregstdID ='$stdUser' 
                                                                                && actregister.actregStatus='ยืนยันเรียบร้อย'
                                                                                && (activity.actYear = '$year' && actsem.actsem = '2') 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row1 = mysqli_num_rows($result);
                                                                            $rowget1 = mysqli_fetch_assoc($result);
                                                                            if ($row1 > 0) {
                                                                            ?>
                                                                                <a href="actreg_sem.php?acttype=<?php echo $rowget1['acttypeName']; ?>&&actyear=<?php echo $year ?>&&actsem=<?php echo $rowget1['actsem']; ?>"><?php echo $row1 ?></a>
                                                                            <?php
                                                                            } else if ($row1 < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT actsem.*, activity.*
                                                                                FROM actsem 
                                                                                JOIN activity ON activity.actSem = actsem.actsemNo
                                                                                WHERE 
                                                                                activity.actYear = '$year' && actsem.actsem = '2' && actsem.actsemStatus = 'สำเร็จกิจกรรมแล้ว'
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $rowsem = mysqli_num_rows($result);
                                                                            if ($rowsem > 0) {
                                                                                if ($row <= 1) {
                                                                                    if (($row1 && $row) == 0) {
                                                                            ?>
                                                                                    <?php
                                                                                    } elseif ($row1 < 1) {
                                                                                    ?>
                                                                                        <i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i>
                                                                                    <?php
                                                                                    } elseif ($row1 >= 1) {
                                                                                    ?>
                                                                                        <i class="fa fa-check text-success"><b>ผ่าน</b></i>
                                                                                    <?php
                                                                                    }
                                                                                } elseif ($row > 1) {
                                                                                    $rowresult = ($row - $row1);
                                                                                    if ($rowresult >= 2) {
                                                                                    ?>
                                                                                        <i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i>
                                                                                    <?php
                                                                                    } elseif ($rowresult < 2) {
                                                                                    ?>
                                                                                        <i class="fa fa-check text-success"><b>ผ่าน</b></i>
                                                                            <?php
                                                                                    }
                                                                                }
                                                                            } else if ($rowsem < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                    </tr>
                                                                <!--act3อบรมคุณธรรมจริยธรรม-->
                                                                    <tr>
                                                                    <td><a href="javascript:;">อบรมคุณธรรมจริยธรรม</a></td>
                                                                        <td>ตลอดทั้งปีการศึกษา</td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*, actsem.*,acttype.* 
                                                                                FROM activity 
                                                                                JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'อบรมคุณธรรมจริยธรรม' 
                                                                                && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actMainorg = '$fct' || activity.actSec = 'มหาวิทยาลัย') 
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row = mysqli_num_rows($result);
                                                                            $rowget = mysqli_fetch_assoc($result);
                                                                            // output data of each row
                                                                            ?>
                                                                            <?php if ($row > 0) {
                                                                            ?>
                                                                                <a href="actall_year.php?acttype=<?php echo $rowget['acttypeName']; ?>&&actyear=<?php echo $year ?>"><?php echo $row ?></a>
                                                                            <?php
                                                                            } else if ($row < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*,acttype.*,actregister.*
                                                                                FROM actregister 
                                                                                JOIN activity ON activity.actID = actregister.actregactID
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'อบรมคุณธรรมจริยธรรม' && actregister.actregstdID ='$stdUser' 
                                                                                && actregister.actregStatus='ยืนยันเรียบร้อย'
                                                                                && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row1 = mysqli_num_rows($result);
                                                                            $rowget1 = mysqli_fetch_assoc($result);
                                                                            if ($row1 > 0) {
                                                                            ?>
                                                                                <a href="actreg_year.php?acttype=<?php echo $rowget1['acttypeName']; ?>&&actyear=<?php echo $year ?>"><?php echo $row1 ?></a>
                                                                            <?php
                                                                            } else if ($row1 < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT actsem.*, activity.*
                                                                                FROM actsem 
                                                                                JOIN activity ON activity.actSem = actsem.actsemNo
                                                                                WHERE 
                                                                                activity.actYear = '$year' && actsem.actsem = '2' && actsem.actsemStatus = 'สำเร็จกิจกรรมแล้ว'
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $rowsem = mysqli_num_rows($result);
                                                                            if ($rowsem > 0) {
                                                                                if ($row <= 1) {
                                                                                    if (($row1 && $row) == 0) {
                                                                            ?>
                                                                                    <?php
                                                                                    } elseif ($row1 < 1) {
                                                                                    ?>
                                                                                        <i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i>
                                                                                    <?php
                                                                                    } elseif ($row1 >= 1) {
                                                                                    ?>
                                                                                        <i class="fa fa-check text-success"><b>ผ่าน</b></i>
                                                                                    <?php
                                                                                    }
                                                                                } elseif ($row > 1) {
                                                                                    $rowresult = ($row - $row1);
                                                                                    if ($rowresult >= 2) {
                                                                                    ?>
                                                                                        <i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i>
                                                                                    <?php
                                                                                    } elseif ($rowresult < 2) {
                                                                                    ?>
                                                                                        <i class="fa fa-check text-success"><b>ผ่าน</b></i>
                                                                            <?php
                                                                                    }
                                                                                }
                                                                            } else if ($rowsem < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                    </tr>
                                                                <!--act4ค่ายพัฒนานักศึกษา-->
                                                                    <tr>
                                                                    <td><a href="javascript:;">ค่ายพัฒนานักศึกษา</a></td>
                                                                        <td>ชั้นปีที่ 3</td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*, actsem.*,acttype.* 
                                                                                FROM activity 
                                                                                JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'ค่ายพัฒนานักศึกษา(ปี3)' && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actMainorg = '$fct' || activity.actSec = 'มหาวิทยาลัย') 
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row = mysqli_num_rows($result);
                                                                            $rowget = mysqli_fetch_assoc($result);
                                                                            // output data of each row
                                                                            ?>
                                                                            <?php if ($row > 0) {
                                                                            ?>
                                                                                <a href="actall_year.php?acttype=<?php echo $rowget['acttypeName']; ?>&&actyear=<?php echo $year ?>"><?php echo $row ?></a>
                                                                            <?php
                                                                            } elseif ($row < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*,acttype.*,actregister.*
                                                                                FROM actregister 
                                                                                JOIN activity ON activity.actID = actregister.actregactID
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'ค่ายพัฒนานักศึกษา(ปี3)' && actregister.actregstdID ='$stdUser' 
                                                                                && actregister.actregStatus='ยืนยันเรียบร้อย'
                                                                                && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row1 = mysqli_num_rows($result);
                                                                            $rowget1 = mysqli_fetch_assoc($result);
                                                                            if ($row1 > 0) {
                                                                            ?>
                                                                                <a href="actreg_year.php?acttype=<?php echo $rowget1['acttypeName']; ?>&&actyear=<?php echo $year ?>"><?php echo $row1 ?></a>
                                                                            <?php
                                                                            } else if ($row1 < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT actsem.*, activity.*
                                                                                FROM actsem 
                                                                                JOIN activity ON activity.actSem = actsem.actsemNo
                                                                                WHERE 
                                                                                activity.actYear = '$year' && actsem.actsem = '2' && actsem.actsemStatus = 'สำเร็จกิจกรรมแล้ว'
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $rowsem = mysqli_num_rows($result);
                                                                            if ($rowsem > 0) {
                                                                                if ($row <= 1) {
                                                                                    if (($row1 && $row) == 0) {
                                                                            ?>
                                                                                    <?php
                                                                                    } elseif ($row1 < 1) {
                                                                                    ?>
                                                                                        <i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i>
                                                                                    <?php
                                                                                    } elseif ($row1 >= 1) {
                                                                                    ?>
                                                                                        <i class="fa fa-check text-success"><b>ผ่าน</b></i>
                                                                                    <?php
                                                                                    }
                                                                                } elseif ($row > 1) {
                                                                                    $rowresult = ($row - $row1);
                                                                                    if ($rowresult >= 2) {
                                                                                    ?>
                                                                                        <i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i>
                                                                                    <?php
                                                                                    } elseif ($rowresult < 2) {
                                                                                    ?>
                                                                                        <i class="fa fa-check text-success"><b>ผ่าน</b></i>
                                                                            <?php
                                                                                    }
                                                                                }
                                                                            } else if ($rowsem < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                    </tr>
                                                                <!--act5อิอฺติก๊าฟ-->
                                                                    <tr>
                                                                    <td><a href="javascript:;">อิอฺติก๊าฟ 10 วันสุดท้ายเดือนรอมฎอน</a></td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT * 
                                                                                FROM eiatiqaf
                                                                                WHERE 
                                                                                eiatiqafstdID = '$stdUser' && eiatiqafYear = '$year' 
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $rowfile = mysqli_num_rows($result);
                                                                            $rowfileeia = mysqli_fetch_assoc($result);
                                                                            // output data of each row
                                                                            ?>
                                                                            <?php if ($rowfile > 0) {
                                                                            ?>
                                                                                <form enctype="multipart/form-data" method="post">
                                                                                    <input class="input-group" type="hidden" name="eiatiqafNo" value="<?php echo $rowfileeia['eiatiqafNo']; ?>" />
                                                                                    <input class="input-group" type="hidden" name="eiatiqafFile" value="<?php echo $rowfileeia['eiatiqafFile']; ?>" />
                                                                                    <input class="input-group" type="file" name="file" accept="file/*" />
                                                                                    <button class="btn btn-warning btn-xs" type="submit" name="btupdatefile">แก้ไข</button>
                                                                                </form>
                                                                                <?php
                                                                            } else if ($rowfile == 0) {
                                                                                $sql = "SELECT * FROM acttype
                                                                                WHERE acttypeName = 'อิอฺติก๊าฟ 10 วันสุดท้ายเดือนรอมฎอน'
                                                                                ";
                                                                                $result = $conn->query($sql);

                                                                                if ($result->num_rows > 0) {
                                                                                    while ($row = $result->fetch_assoc()) {
                                                                                        $acttypeNo = $row["acttypeNo"];
                                                                                ?>
                                                                                        <form enctype="multipart/form-data" method="post">
                                                                                            <input class="input-group" type="hidden" name="acttype" value="<?php echo $acttypeNo ?>" />
                                                                                    <?php }
                                                                                } else {
                                                                                    echo "something";
                                                                                } ?>
                                                                                    <input class="input-group" type="hidden" name="year" value="<?php echo $year ?>" />
                                                                                    <input class="input-group" type="hidden" name="stdid" value="<?php echo $stdUser ?>" />
                                                                                    <input class="input-group" type="file" name="file" accept="file/*" />
                                                                                    <button class="btn btn-info btn-xs" type="submit" name="btaddfile">เพิ่ม</button>
                                                                                        </form>
                                                                                    <?php  }
                                                                                    ?>

                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*,acttype.* 
                                                                                FROM activity 
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'อิอฺติก๊าฟ 10 วันสุดท้ายเดือนรอมฎอน' 
                                                                                && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actMainorg = '$fct' || activity.actSec = 'มหาวิทยาลัย') 
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row = mysqli_num_rows($result);
                                                                            $rowget = mysqli_fetch_assoc($result);
                                                                            // output data of each row
                                                                            ?>
                                                                            <?php if ($row > 0) {
                                                                            ?>
                                                                                <a href="actall_year.php?acttype=<?php echo $rowget['acttypeName']; ?>&&actyear=<?php echo $year ?>"><?php echo $row ?></a>
                                                                            <?php
                                                                            } else if ($row < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            if($rowfile>0){?> 
                                                                            <a href="../file/<?php echo $rowfileeia['eiatiqafFile']; ?>"><?php echo $rowfileeia['eiatiqafFile'] ?></a>
                                                                            <?php } else{
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*,acttype.*,actregister.*
                                                                                FROM actregister 
                                                                                JOIN activity ON activity.actID = actregister.actregactID
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'อิอฺติก๊าฟ 10 วันสุดท้ายเดือนรอมฎอน' && actregister.actregstdID ='$stdUser' 
                                                                                && actregister.actregStatus='ยืนยันเรียบร้อย'
                                                                                && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row1 = mysqli_num_rows($result);
                                                                            $rowget1 = mysqli_fetch_assoc($result);
                                                                            if ($row1 > 0) {
                                                                            ?>
                                                                                <a href="actreg_year.php?acttype=<?php echo $rowget1['acttypeName']; ?>&&actyear=<?php echo $year ?>"><?php echo $row1 ?></a>
                                                                            <?php
                                                                            } else if ($row1 < 0) {
                                                                            }}
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT *
                                                                                FROM actyear 
                                                                                WHERE 
                                                                                actyear = '$year' && actyearStatus = 'สำเร็จกิจกรรมแล้ว'
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $rowsem = mysqli_num_rows($result);
                                                                            if ($rowsem > 0) {
                                                                                if($rowfile==1){?>
                                                                                    <i class="fa fa-check text-success"><b>ผ่าน</b></i>
                                                                                <?php }else{
                                                                                if ($row <= 1) {
                                                                                    if (($row1 && $row) == 0) {
                                                                            ?>
                                                                                    <?php
                                                                                    } elseif ($row1 < 1) {
                                                                                    ?>
                                                                                        <i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i>
                                                                                    <?php
                                                                                    } elseif ($row1 >= 1) {
                                                                                    ?>
                                                                                        <i class="fa fa-check text-success"><b>ผ่าน</b></i>
                                                                                    <?php
                                                                                    }
                                                                                } elseif ($row > 1) {
                                                                                    $rowresult = ($row - $row1);
                                                                                    if ($rowresult >= 2) {
                                                                                    ?>
                                                                                        <i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i>
                                                                                    <?php
                                                                                    } elseif ($rowresult < 2) {
                                                                                    ?>
                                                                                        <i class="fa fa-check text-success"><b>ผ่าน</b></i>
                                                                            <?php
                                                                                    }
                                                                                }}
                                                                            } else if ($rowsem < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                    </tr>
                                                                
                                                                <!--act7ชมรม-->
                                                                    <tr>

                                                                    <td><a href="javascript:;">กิจกรรมชมรม</a></td>
                                                                        <td><?php echo $clubname ?></td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*, actsem.*,acttype.*
                                                                                FROM activity 
                                                                                JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'กิจกรรมชมรม' && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && activity.actSec = 'มหาวิทยาลัย' && activity.actOrgtion = '$club'
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row = mysqli_num_rows($result);
                                                                            $rowget = mysqli_fetch_assoc($result);
                                                                            // output data of each row
                                                                            ?>
                                                                            <?php if ($row > 0) {
                                                                            ?>
                                                                                <a href="actall_year.php?acttype=<?php echo $rowget['acttypeName']; ?>&&actyear=<?php echo $year ?>"><?php echo $row ?></a>
                                                                            <?php
                                                                            } else if ($row < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*,acttype.*,actregister.*
                                                                                FROM actregister 
                                                                                JOIN activity ON activity.actID = actregister.actregactID
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'กิจกรรมชมรม' && actregister.actregstdID ='$stdUser' 
                                                                                && actregister.actregStatus='ยืนยันเรียบร้อย'
                                                                                && activity.actYear = '$year' 
                                                                                && activity.actSec = 'มหาวิทยาลัย' && activity.actOrgtion = '$club'
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row1 = mysqli_num_rows($result);
                                                                            $rowget1 = mysqli_fetch_assoc($result);
                                                                            if ($row1 > 0) {
                                                                            ?>
                                                                                <a href="actreg_year.php?acttype=<?php echo $rowget1['acttypeName']; ?>&&actyear=<?php echo $year ?>"><?php echo $row1 ?></a>
                                                                            <?php
                                                                            } else if ($row1 < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT actsem.*, activity.*
                                                                                FROM actsem 
                                                                                JOIN activity ON activity.actSem = actsem.actsemNo
                                                                                WHERE 
                                                                                activity.actYear = '$year' && actsem.actsem = '2' && actsem.actsemStatus = 'สำเร็จกิจกรรมแล้ว'
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $rowsem = mysqli_num_rows($result);
                                                                            if ($rowsem > 0) {
                                                                                if ($row <= 1) {
                                                                                    if (($row1 && $row) == 0) {
                                                                            ?>
                                                                                    <?php
                                                                                    } elseif ($row1 < 1) {
                                                                                    ?>
                                                                                        <i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i>
                                                                                    <?php
                                                                                    } elseif ($row1 >= 1) {
                                                                                    ?>
                                                                                        <i class="fa fa-check text-success"><b>ผ่าน</b></i>
                                                                                    <?php
                                                                                    }
                                                                                } elseif ($row > 1) {
                                                                                    $rowresult = ($row - $row1);
                                                                                    if ($rowresult >= 2) {
                                                                                    ?>
                                                                                        <i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i>
                                                                                    <?php
                                                                                    } elseif ($rowresult < 2) {
                                                                                    ?>
                                                                                        <i class="fa fa-check text-success"><b>ผ่าน</b></i>
                                                                            <?php
                                                                                    }
                                                                                }
                                                                            } else if ($rowsem < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                    </tr>
                                                                <!--act8ชุมนุม-->
                                                                    <tr>
                                                                    <td><a href="javascript:;">กิจกรรมชุมนุม</a></td>
                                                                        <td><?php echo $dpmName ?></td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*, actsem.*,acttype.*, organization.*
                                                                                FROM activity 
                                                                                JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                JOIN organization ON activity.actOrgtion = organization.orgtionNo
                                                                                WHERE 
                                                                                acttype.acttypeName = 'กิจกรรมชุมนุม' && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actMainorg = '$fct' && organization.organization = '$dpmName')
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row = mysqli_num_rows($result);
                                                                            $rowget = mysqli_fetch_assoc($result);
                                                                            // output data of each row
                                                                            ?>
                                                                            <?php if ($row > 0) {
                                                                            ?>
                                                                                <a href="actall_year.php?acttype=<?php echo $rowget['acttypeName']; ?>&&actyear=<?php echo $year ?>"><?php echo $row ?></a>
                                                                            <?php  } else if ($row < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*,acttype.*,actregister.*, organization.*
                                                                                FROM actregister 
                                                                                JOIN activity ON activity.actID = actregister.actregactID
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                JOIN organization ON activity.actOrgtion = organization.orgtionNo
                                                                                WHERE 
                                                                                acttype.acttypeName = 'กิจกรรมชุมนุม' && actregister.actregstdID ='$stdUser' 
                                                                                && actregister.actregStatus='ยืนยันเรียบร้อย'
                                                                                && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actMainorg = '$fct' && organization.organization = '$dpmName')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row1 = mysqli_num_rows($result);
                                                                            $rowget1 = mysqli_fetch_assoc($result);
                                                                            if ($row1 > 0) {
                                                                            ?>
                                                                                <a href="actreg_year.php?acttype=<?php echo $rowget1['acttypeName']; ?>&&actyear=<?php echo $year ?>"><?php echo $row1 ?></a>
                                                                            <?php
                                                                            } else if ($row1 < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT actsem.*, activity.*
                                                                                FROM actsem 
                                                                                JOIN activity ON activity.actSem = actsem.actsemNo
                                                                                WHERE 
                                                                                activity.actYear = '$year' && actsem.actsem = '2' && actsem.actsemStatus = 'สำเร็จกิจกรรมแล้ว'
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $rowsem = mysqli_num_rows($result);
                                                                            if ($rowsem > 0) {
                                                                                if ($row <= 1) {
                                                                                    if (($row1 && $row) == 0) {
                                                                            ?>
                                                                                    <?php
                                                                                    } elseif ($row1 < 1) {
                                                                                    ?>
                                                                                        <i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i>
                                                                                    <?php
                                                                                    } elseif ($row1 >= 1) {
                                                                                    ?>
                                                                                        <i class="fa fa-check text-success"><b>ผ่าน</b></i>
                                                                                    <?php
                                                                                    }
                                                                                } elseif ($row > 1) {
                                                                                    $rowresult = ($row - $row1);
                                                                                    if ($rowresult >= 2) {
                                                                                    ?>
                                                                                        <i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i>
                                                                                    <?php
                                                                                    } elseif ($rowresult < 2) {
                                                                                    ?>
                                                                                        <i class="fa fa-check text-success"><b>ผ่าน</b></i>
                                                                            <?php
                                                                                    }
                                                                                }
                                                                            } else if ($rowsem < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                    </tr>
                                                                <!--act9กิจกรรมอบศ-->
                                                                    <tr>
                                                                    <td><a href="javascript:;">เข้าร่วม 5 กิจกรรมที่จัดโดยองค์การบริหารนักศึกษา</a></td>
                                                                        <td>ตลอดทั้งปีการศึกษา</td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*, actsem.*,acttype.*,mainorg.*,organization.* 
                                                                                FROM activity 
                                                                                JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                JOIN mainorg ON mainorg.mainorgNo = activity.actMainorg
                                                                                JOIN organization ON organization.orgtionNo = activity.actOrgtion
                                                                                WHERE 
                                                                                acttype.acttypeName = 'กิจกรรมองค์การบริหารนักศึกษา' 
                                                                                && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (mainorg.mainorg = 'องค์การบริหารนักศึกษา' || organization.organization = 'องค์การบริหารนักศึกษา') 
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row = mysqli_num_rows($result);
                                                                            $rowget = mysqli_fetch_assoc($result);
                                                                            // output data of each row
                                                                            ?>
                                                                            <?php if ($row > 0) {
                                                                            ?>
                                                                                <a href="actall_year.php?acttype=<?php echo $rowget['acttypeName']; ?>&&actyear=<?php echo $year ?>"><?php echo $row ?></a>
                                                                            <?php
                                                                            } else if ($row < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*,acttype.*,actregister.*,mainorg.*,organization.* 
                                                                                FROM actregister 
                                                                                JOIN activity ON activity.actID = actregister.actregactID
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                JOIN mainorg ON mainorg.mainorgNo = activity.actMainorg
                                                                                JOIN organization ON organization.orgtionNo = activity.actOrgtion
                                                                                WHERE 
                                                                                acttype.acttypeName = 'กิจกรรมองค์การบริหารนักศึกษา' && actregister.actregstdID ='$stdUser' 
                                                                                && actregister.actregStatus='ยืนยันเรียบร้อย'
                                                                                && activity.actYear = '$year' 
                                                                                && (mainorg.mainorg = 'องค์การบริหารนักศึกษา' || organization.organization = 'องค์การบริหารนักศึกษา') 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row1 = mysqli_num_rows($result);
                                                                            $rowget1 = mysqli_fetch_assoc($result);
                                                                            if ($row1 > 0) {
                                                                            ?>
                                                                                <a href="actreg_year.php?acttype=<?php echo $rowget1['acttypeName']; ?>&&actyear=<?php echo $year ?>"><?php echo $row1 ?></a>
                                                                            <?php
                                                                            } else if ($row1 < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT actsem.*, activity.*
                                                                                FROM actsem 
                                                                                JOIN activity ON activity.actSem = actsem.actsemNo
                                                                                WHERE 
                                                                                activity.actYear = '$year' && actsem.actsem = '2' && actsem.actsemStatus = 'สำเร็จกิจกรรมแล้ว'
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $rowsem = mysqli_num_rows($result);
                                                                            if ($rowsem > 0) {
                                                                                if ($row <= 1) {
                                                                                    if (($row1 && $row) == 0) {
                                                                            ?>
                                                                                    <?php
                                                                                    } elseif ($row1 < 1) {
                                                                                    ?>
                                                                                        <i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i>
                                                                                    <?php
                                                                                    } elseif ($row1 >= 1) {
                                                                                    ?>
                                                                                        <i class="fa fa-check text-success"><b>ผ่าน</b></i>
                                                                                    <?php
                                                                                    }
                                                                                } elseif ($row > 1) {
                                                                                    $rowresult = ($row - $row1);
                                                                                    if (($rowresult < 2) || ($row1 = 5)) {
                                                                                    ?>
                                                                                        <i class="fa fa-check text-success"><b>ผ่าน</b></i>
                                                                                    <?php } elseif ($rowresult >= 2) {
                                                                                    ?>
                                                                                        <i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i>
                                                                            <?php
                                                                                    }
                                                                                }
                                                                            } else if ($rowsem < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                    </tr>
                                                                <!--act10กิจกรรมสโมสร-->
                                                                    <tr>
                                                                    <td><a href="javascript:;">เข้าร่วม 5 กิจกรรมที่จัดโดยสโมสรคณะ</a></td>
                                                                        <td>ตลอดทั้งปีการศึกษา</td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*, actsem.*,acttype.*, organization.* 
                                                                                FROM activity 
                                                                                JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                JOIN organization ON activity.actOrgtion = organization.orgtionNo
                                                                                WHERE 
                                                                                acttype.acttypeName = 'กิจกรรมสโมรสรคณะ' 
                                                                                && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actMainorg = '$fct' || organization.organization = 'สโมสรคณะ') 
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row = mysqli_num_rows($result);
                                                                            $rowget = mysqli_fetch_assoc($result);
                                                                            // output data of each row
                                                                            ?>
                                                                            <?php if ($row > 0) {
                                                                            ?>
                                                                                <a href="actall_year.php?acttype=<?php echo $rowget['acttypeName']; ?>&&actyear=<?php echo $year ?>"><?php echo $row ?></a>
                                                                            <?php  } else if ($row < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*,acttype.*,actregister.*, organization.*
                                                                                FROM actregister 
                                                                                JOIN activity ON activity.actID = actregister.actregactID
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                JOIN organization ON activity.actOrgtion = organization.orgtionNo
                                                                                WHERE 
                                                                                acttype.acttypeName = 'กิจกรรมสโมสรคณะ' && actregister.actregstdID ='$stdUser' 
                                                                                && actregister.actregStatus='ยืนยันเรียบร้อย'
                                                                                && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actMainorg = '$fct' || organization.organization = 'สโมสรคณะ') 
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row1 = mysqli_num_rows($result);
                                                                            $rowget1 = mysqli_fetch_assoc($result);
                                                                            if ($row1 > 0) {
                                                                            ?>
                                                                                <a href="actreg_year.php?acttype=<?php echo $rowget1['acttypeName']; ?>&&actyear=<?php echo $year ?>"><?php echo $row1 ?></a>
                                                                            <?php
                                                                            } else if ($row1 < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT actsem.*, activity.*
                                                                                FROM actsem 
                                                                                JOIN activity ON activity.actSem = actsem.actsemNo
                                                                                WHERE 
                                                                                activity.actYear = '$year' && actsem.actsem = '2' && actsem.actsemStatus = 'สำเร็จกิจกรรมแล้ว'
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $rowsem = mysqli_num_rows($result);
                                                                            if ($rowsem > 0) {
                                                                                if ($row <= 1) {
                                                                                    if (($row1 && $row) == 0) {
                                                                            ?>
                                                                                    <?php
                                                                                    } elseif ($row1 < 1) {
                                                                                    ?>
                                                                                        <i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i>
                                                                                    <?php
                                                                                    } elseif ($row1 >= 1) {
                                                                                    ?>
                                                                                        <i class="fa fa-check text-success"><b>ผ่าน</b></i>
                                                                                    <?php
                                                                                    }
                                                                                } elseif ($row > 1) {
                                                                                    $rowresult = ($row - $row1);
                                                                                    if (($rowresult < 2) || ($row1 = 5)) {
                                                                                    ?>
                                                                                        <i class="fa fa-check text-success"><b>ผ่าน</b></i>
                                                                                    <?php } elseif ($rowresult >= 2) {
                                                                                    ?>
                                                                                        <i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i>
                                                                            <?php
                                                                                    }
                                                                                }
                                                                            } else if ($rowsem < 0) {
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
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="tab-8-4">
                                                <div class="row justify-content-center">
                                                    <div class="col-md-12">
                                                        <?php
                                                        require_once '../../db/dbconfig.php';
                                                        $stmt = $DBcon->prepare("SELECT student.*, club.*, organization.*,department.* FROM student 
                                                            JOIN club ON club.clubstdID = student.stdID
                                                            JOIN organization ON club.clubOrgtion = organization.orgtionNo
                                                            JOIN department ON student.stdDpm = department.dpmNo
                                                            WHERE student.stdID = '$stdUser' && club.clubYear = student.stdYear+3");
                                                        $stmt->execute();
                                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                            $fct = $row["stdFct"];
                                                            $dpm = $row["stdDpm"];
                                                            $dpmName = $row["department"];
                                                            $year = $row["stdYear"] + 3;
                                                            $group = $row["stdGroup"];
                                                            $club = $row["clubOrgtion"];
                                                            $clubname = $row["organization"];

                                                        ?>
                                                            <table id="tbact1" class="table table-condensed ">
                                                                <thead>
                                                                    <tr style="color:#528124;">
                                                                        <th>หมวดหมู่</th>
                                                                        <th></th>
                                                                        <th>จำนวนครั้งที่จัด</th>
                                                                        <th>จำนวนครั้งที่เข้าร่วม</th>
                                                                        <th>ผลการประเมิน</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                <!--act1กลุ่มศึกษาอัลกุรอ่าน-->
                                                                    <tr>
                                                                    <td><a href="javascript:;">กลุ่มศึกษาอัลกุรอ่าน</a></td>
                                                                        <td>ภาคเรียนที่ 1</td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <?php
                                                                        require_once '../../db/dbconfig.php';
                                                                        $stmt = $DBcon->prepare("SELECT halaqahstd.*, halaqahtc.* FROM halaqahstd
                                                                                                JOIN halaqahtc ON halaqahtc.halaqahtcNo = halaqahstd.halaqahID
                                                                                                WHERE halaqahstd.halaqahstdID = '$stdUser' && halaqahtc.halaqahtcYear = '$year'
                                                                                                ");
                                                                        $stmt->execute();
                                                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                                            if ($row['halaqahstdsem1Status'] == 'ผ่าน') { ?>
                                                                                <td><i class="fa fa-check text-success"><b><?php echo $row['halaqahstdsem1Status']; ?></b></i></td>
                                                                            <?php } else if ($row['halaqahstdsem1Status'] == 'ไม่ผ่าน') { ?>
                                                                                <td><i class="fa fa-times text-danger"><b><?php echo $row['halaqahstdsem1Status']; ?></b></i></td>
                                                                            <?php } else { ?>
                                                                                <td><?php echo $row['halaqahstdsem1Status']; ?></td>
                                                                        <?php }
                                                                        }
                                                                        ?>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="font-size:16px;width: 30%;border-top: 0px;"></td>
                                                                        <td>ภาคเรียนที่ 2</td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <?php
                                                                        require_once '../../db/dbconfig.php';
                                                                        $stmt = $DBcon->prepare("SELECT halaqahstd.*, halaqahtc.* FROM halaqahstd
                                                                                                JOIN halaqahtc ON halaqahtc.halaqahtcNo = halaqahstd.halaqahID
                                                                                                WHERE halaqahstd.halaqahstdID = '$stdUser' && halaqahtc.halaqahtcYear = '$year'
                                                                                                ");
                                                                        $stmt->execute();
                                                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                                            if ($row['halaqahstdsem2Status'] == 'ผ่าน') { ?>
                                                                                <td><i class="fa fa-check text-success"><b><?php echo $row['halaqahstdsem2Status']; ?></b></i></td>
                                                                            <?php } else if ($row['halaqahstdsem2Status'] == 'ไม่ผ่าน') { ?>
                                                                                <td><i class="fa fa-times text-danger"><b><?php echo $row['halaqahstdsem2Status']; ?></b></i></td>
                                                                            <?php } else { ?>
                                                                                <td><?php echo $row['halaqahstdsem2Status']; ?></td>
                                                                        <?php }
                                                                        }
                                                                        ?>
                                                                    </tr>
                                                                <!--act2กิยามุลลัยล์-->
                                                                    <tr>
                                                                        <?php
                                                                        require_once '../../db/dbconfig.php';
                                                                        $sql = "SELECT activity.*, actsem.*,acttype.* 
                                                                            FROM activity 
                                                                            JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                            JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                            WHERE 
                                                                            acttype.acttypeName = 'กิยามุลลัยล์' 
                                                                            && (activity.actYear = '$year' && actsem.actsem = '1') 
                                                                            && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                            && (activity.actMainorg = '$fct' || activity.actSec = 'มหาวิทยาลัย') 
                                                                            && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                            ";
                                                                        $result = mysqli_query($conn, $sql);
                                                                        $row = mysqli_num_rows($result);
                                                                        $rowget = mysqli_fetch_assoc($result);
                                                                        ?>
                                                                        <td><a href="javascript:;">กิยามุลลัยล์</a></td>
                                                                        <td>ภาคเรียนที่ 1</td>
                                                                        <td>
                                                                            <?php if ($row > 0) {
                                                                            ?>
                                                                                <a href="actall_sem.php?acttype=<?php echo $rowget['acttypeName']; ?>&&actyear=<?php echo $year ?>&&actsem=<?php echo $rowget['actsem']; ?>"><?php echo $row ?></a>
                                                                            <?php } else if ($row < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*, actsem.*,acttype.*,actregister.*
                                                                                FROM actregister 
                                                                                JOIN activity ON activity.actID = actregister.actregactID
                                                                                JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'กิยามุลลัยล์' && actregister.actregstdID ='$stdUser' 
                                                                                && actregister.actregStatus='ยืนยันเรียบร้อย'
                                                                                && (activity.actYear = '$year' && actsem.actsem = '1') 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actMainorg = '$fct' || activity.actSec = 'มหาวิทยาลัย') 
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row1 = mysqli_num_rows($result);
                                                                            $rowget1 = mysqli_fetch_assoc($result);
                                                                            if ($row1 > 0) {
                                                                            ?>
                                                                                <a href="actreg_sem.php?acttype=<?php echo $rowget1['acttypeName']; ?>&&actyear=<?php echo $year ?>&&actsem=<?php echo $rowget1['actsem']; ?>"><?php echo $row1 ?></a>
                                                                            <?php } else if ($row1 < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT actsem.*, activity.*
                                                                                FROM actsem 
                                                                                JOIN activity ON activity.actSem = actsem.actsemNo
                                                                                WHERE 
                                                                                activity.actYear = '$year' && actsem.actsem = '1' && actsem.actsemStatus = 'สำเร็จกิจกรรมแล้ว'
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $rowsem = mysqli_num_rows($result);
                                                                            if ($rowsem > 0) {
                                                                                if ($row <= 1) {
                                                                                    if (($row1 && $row) == 0) {
                                                                            ?>
                                                                                    <?php
                                                                                    } elseif ($row1 < 1) {
                                                                                    ?>
                                                                                        <i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i>
                                                                                    <?php
                                                                                    } elseif ($row1 >= 1) {
                                                                                    ?>
                                                                                        <i class="fa fa-check text-success"><b>ผ่าน</b></i>
                                                                                    <?php
                                                                                    }
                                                                                } elseif ($row > 1) {
                                                                                    $rowresult = ($row - $row1);
                                                                                    if ($rowresult >= 2) {
                                                                                    ?>
                                                                                        <i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i>
                                                                                    <?php
                                                                                    } elseif ($rowresult < 2) {
                                                                                    ?>
                                                                                        <i class="fa fa-check text-success"><b>ผ่าน</b></i>
                                                                            <?php
                                                                                    }
                                                                                }
                                                                            } else if ($rowsem < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                    </tr>
                                                                    <!--กิยามุลลัยล์2-->
                                                                    <tr>
                                                                        <td style="font-size:16px;width: 30%;border-top: 0px;"></td>
                                                                        <td>ภาคเรียนที่ 2</td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*, actsem.*,acttype.* 
                                                                                FROM activity 
                                                                                JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'กิยามุลลัยล์' 
                                                                                && (activity.actYear = '$year' && actsem.actsem = '2') 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actMainorg = '$fct' || activity.actSec = 'มหาวิทยาลัย') 
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row = mysqli_num_rows($result);
                                                                            $rowget = mysqli_fetch_assoc($result);
                                                                            if ($row > 0) {
                                                                            ?>
                                                                                <a href="actall_sem.php?acttype=<?php echo $rowget['acttypeName']; ?>&&actyear=<?php echo $year ?>&&actsem=<?php echo $rowget['actsem']; ?>"><?php echo $row ?></a>
                                                                            <?php
                                                                            } elseif ($row < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*, actsem.*,acttype.*,actregister.*
                                                                                FROM actregister 
                                                                                JOIN activity ON activity.actID = actregister.actregactID
                                                                                JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'กิยามุลลัยล์' && actregister.actregstdID ='$stdUser' 
                                                                                && actregister.actregStatus='ยืนยันเรียบร้อย'
                                                                                && (activity.actYear = '$year' && actsem.actsem = '2') 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row1 = mysqli_num_rows($result);
                                                                            $rowget1 = mysqli_fetch_assoc($result);
                                                                            if ($row1 > 0) {
                                                                            ?>
                                                                                <a href="actreg_sem.php?acttype=<?php echo $rowget1['acttypeName']; ?>&&actyear=<?php echo $year ?>&&actsem=<?php echo $rowget1['actsem']; ?>"><?php echo $row1 ?></a>
                                                                            <?php
                                                                            } else if ($row1 < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT actsem.*, activity.*
                                                                                FROM actsem 
                                                                                JOIN activity ON activity.actSem = actsem.actsemNo
                                                                                WHERE 
                                                                                activity.actYear = '$year' && actsem.actsem = '2' && actsem.actsemStatus = 'สำเร็จกิจกรรมแล้ว'
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $rowsem = mysqli_num_rows($result);
                                                                            if ($rowsem > 0) {
                                                                                if ($row <= 1) {
                                                                                    if (($row1 && $row) == 0) {
                                                                            ?>
                                                                                    <?php
                                                                                    } elseif ($row1 < 1) {
                                                                                    ?>
                                                                                        <i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i>
                                                                                    <?php
                                                                                    } elseif ($row1 >= 1) {
                                                                                    ?>
                                                                                        <i class="fa fa-check text-success"><b>ผ่าน</b></i>
                                                                                    <?php
                                                                                    }
                                                                                } elseif ($row > 1) {
                                                                                    $rowresult = ($row - $row1);
                                                                                    if ($rowresult >= 2) {
                                                                                    ?>
                                                                                        <i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i>
                                                                                    <?php
                                                                                    } elseif ($rowresult < 2) {
                                                                                    ?>
                                                                                        <i class="fa fa-check text-success"><b>ผ่าน</b></i>
                                                                            <?php
                                                                                    }
                                                                                }
                                                                            } else if ($rowsem < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                    </tr>
                                                                <!--act3อบรมคุณธรรมจริยธรรม-->
                                                                    <tr>
                                                                    <td><a href="javascript:;">อบรมคุณธรรมจริยธรรม</a></td>
                                                                        <td>ตลอดทั้งปีการศึกษา</td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*, actsem.*,acttype.* 
                                                                                FROM activity 
                                                                                JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'อบรมคุณธรรมจริยธรรม' 
                                                                                && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actMainorg = '$fct' || activity.actSec = 'มหาวิทยาลัย') 
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row = mysqli_num_rows($result);
                                                                            $rowget = mysqli_fetch_assoc($result);
                                                                            // output data of each row
                                                                            ?>
                                                                            <?php if ($row > 0) {
                                                                            ?>
                                                                                <a href="actall_year.php?acttype=<?php echo $rowget['acttypeName']; ?>&&actyear=<?php echo $year ?>"><?php echo $row ?></a>
                                                                            <?php
                                                                            } else if ($row < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*,acttype.*,actregister.*
                                                                                FROM actregister 
                                                                                JOIN activity ON activity.actID = actregister.actregactID
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'อบรมคุณธรรมจริยธรรม' && actregister.actregstdID ='$stdUser' 
                                                                                && actregister.actregStatus='ยืนยันเรียบร้อย'
                                                                                && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row1 = mysqli_num_rows($result);
                                                                            $rowget1 = mysqli_fetch_assoc($result);
                                                                            if ($row1 > 0) {
                                                                            ?>
                                                                                <a href="actreg_year.php?acttype=<?php echo $rowget1['acttypeName']; ?>&&actyear=<?php echo $year ?>"><?php echo $row1 ?></a>
                                                                            <?php
                                                                            } else if ($row1 < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT actsem.*, activity.*
                                                                                FROM actsem 
                                                                                JOIN activity ON activity.actSem = actsem.actsemNo
                                                                                WHERE 
                                                                                activity.actYear = '$year' && actsem.actsem = '2' && actsem.actsemStatus = 'สำเร็จกิจกรรมแล้ว'
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $rowsem = mysqli_num_rows($result);
                                                                            if ($rowsem > 0) {
                                                                                if ($row <= 1) {
                                                                                    if (($row1 && $row) == 0) {
                                                                            ?>
                                                                                    <?php
                                                                                    } elseif ($row1 < 1) {
                                                                                    ?>
                                                                                        <i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i>
                                                                                    <?php
                                                                                    } elseif ($row1 >= 1) {
                                                                                    ?>
                                                                                        <i class="fa fa-check text-success"><b>ผ่าน</b></i>
                                                                                    <?php
                                                                                    }
                                                                                } elseif ($row > 1) {
                                                                                    $rowresult = ($row - $row1);
                                                                                    if ($rowresult >= 2) {
                                                                                    ?>
                                                                                        <i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i>
                                                                                    <?php
                                                                                    } elseif ($rowresult < 2) {
                                                                                    ?>
                                                                                        <i class="fa fa-check text-success"><b>ผ่าน</b></i>
                                                                            <?php
                                                                                    }
                                                                                }
                                                                            } else if ($rowsem < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                    </tr>
                                                                <!--act5อิอฺติก๊าฟ-->
                                                                    <tr>
                                                                    <td><a href="javascript:;">อิอฺติก๊าฟ 10 วันสุดท้ายเดือนรอมฎอน</a></td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT * 
                                                                                FROM eiatiqaf
                                                                                WHERE 
                                                                                eiatiqafstdID = '$stdUser' && eiatiqafYear = '$year' 
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $rowfile = mysqli_num_rows($result);
                                                                            $rowfileeia = mysqli_fetch_assoc($result);
                                                                            // output data of each row
                                                                            ?>
                                                                            <?php if ($rowfile > 0) {
                                                                            ?>
                                                                                <form enctype="multipart/form-data" method="post">
                                                                                    <input class="input-group" type="hidden" name="eiatiqafNo" value="<?php echo $rowfileeia['eiatiqafNo']; ?>" />
                                                                                    <input class="input-group" type="hidden" name="eiatiqafFile" value="<?php echo $rowfileeia['eiatiqafFile']; ?>" />
                                                                                    <input class="input-group" type="file" name="file" accept="file/*" />
                                                                                    <button class="btn btn-warning btn-xs" type="submit" name="btupdatefile">แก้ไข</button>
                                                                                </form>
                                                                                <?php
                                                                            } else if ($rowfile == 0) {
                                                                                $sql = "SELECT * FROM acttype
                                                                                WHERE acttypeName = 'อิอฺติก๊าฟ 10 วันสุดท้ายเดือนรอมฎอน'
                                                                                ";
                                                                                $result = $conn->query($sql);

                                                                                if ($result->num_rows > 0) {
                                                                                    while ($row = $result->fetch_assoc()) {
                                                                                        $acttypeNo = $row["acttypeNo"];
                                                                                ?>
                                                                                        <form enctype="multipart/form-data" method="post">
                                                                                            <input class="input-group" type="hidden" name="acttype" value="<?php echo $acttypeNo ?>" />
                                                                                    <?php }
                                                                                } else {
                                                                                    echo "something";
                                                                                } ?>
                                                                                    <input class="input-group" type="hidden" name="year" value="<?php echo $year ?>" />
                                                                                    <input class="input-group" type="hidden" name="stdid" value="<?php echo $stdUser ?>" />
                                                                                    <input class="input-group" type="file" name="file" accept="file/*" />
                                                                                    <button class="btn btn-info btn-xs" type="submit" name="btaddfile">เพิ่ม</button>
                                                                                        </form>
                                                                                    <?php  }
                                                                                    ?>

                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*,acttype.* 
                                                                                FROM activity 
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'อิอฺติก๊าฟ 10 วันสุดท้ายเดือนรอมฎอน' 
                                                                                && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actMainorg = '$fct' || activity.actSec = 'มหาวิทยาลัย') 
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row = mysqli_num_rows($result);
                                                                            $rowget = mysqli_fetch_assoc($result);
                                                                            // output data of each row
                                                                            ?>
                                                                            <?php if ($row > 0) {
                                                                            ?>
                                                                                <a href="actall_year.php?acttype=<?php echo $rowget['acttypeName']; ?>&&actyear=<?php echo $year ?>"><?php echo $row ?></a>
                                                                            <?php
                                                                            } else if ($row < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            if($rowfile>0){?> 
                                                                            <a href="../file/<?php echo $rowfileeia['eiatiqafFile']; ?>"><?php echo $rowfileeia['eiatiqafFile'] ?></a>
                                                                            <?php } else{
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*,acttype.*,actregister.*
                                                                                FROM actregister 
                                                                                JOIN activity ON activity.actID = actregister.actregactID
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'อิอฺติก๊าฟ 10 วันสุดท้ายเดือนรอมฎอน' && actregister.actregstdID ='$stdUser' 
                                                                                && actregister.actregStatus='ยืนยันเรียบร้อย'
                                                                                && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row1 = mysqli_num_rows($result);
                                                                            $rowget1 = mysqli_fetch_assoc($result);
                                                                            if ($row1 > 0) {
                                                                            ?>
                                                                                <a href="actreg_year.php?acttype=<?php echo $rowget1['acttypeName']; ?>&&actyear=<?php echo $year ?>"><?php echo $row1 ?></a>
                                                                            <?php
                                                                            } else if ($row1 < 0) {
                                                                            }}
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT *
                                                                                FROM actyear 
                                                                                WHERE 
                                                                                actyear = '$year' && actyearStatus = 'สำเร็จกิจกรรมแล้ว'
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $rowsem = mysqli_num_rows($result);
                                                                            if ($rowsem > 0) {
                                                                                if($rowfile==1){?>
                                                                                    <i class="fa fa-check text-success"><b>ผ่าน</b></i>
                                                                                <?php }else{
                                                                                if ($row <= 1) {
                                                                                    if (($row1 && $row) == 0) {
                                                                            ?>
                                                                                    <?php
                                                                                    } elseif ($row1 < 1) {
                                                                                    ?>
                                                                                        <i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i>
                                                                                    <?php
                                                                                    } elseif ($row1 >= 1) {
                                                                                    ?>
                                                                                        <i class="fa fa-check text-success"><b>ผ่าน</b></i>
                                                                                    <?php
                                                                                    }
                                                                                } elseif ($row > 1) {
                                                                                    $rowresult = ($row - $row1);
                                                                                    if ($rowresult >= 2) {
                                                                                    ?>
                                                                                        <i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i>
                                                                                    <?php
                                                                                    } elseif ($rowresult < 2) {
                                                                                    ?>
                                                                                        <i class="fa fa-check text-success"><b>ผ่าน</b></i>
                                                                            <?php
                                                                                    }
                                                                                }}
                                                                            } else if ($rowsem < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                    </tr>
                                                                
                                                                <!--act6ปัจฉิมนิเทศ-->
                                                                    <tr>

                                                                    <td><a href="javascript:;">ปัจฉิมนิเทศ</a></td>
                                                                        <td>ชั้นปีที่ 4</td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*, actsem.*,acttype.* 
                                                                                FROM activity 
                                                                                JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'ปัจฉิมนิเทศ' && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && activity.actSec = 'มหาวิทยาลัย' 
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row = mysqli_num_rows($result);
                                                                            $rowget = mysqli_fetch_assoc($result);
                                                                            // output data of each row
                                                                            ?>
                                                                            <?php if ($row > 0) {
                                                                            ?>
                                                                                <a href="actall_year.php?acttype=<?php echo $rowget['acttypeName']; ?>&&actyear=<?php echo $year ?>"><?php echo $row ?></a>
                                                                            <?php
                                                                            } elseif ($row < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*,acttype.*,actregister.*
                                                                                FROM actregister 
                                                                                JOIN activity ON activity.actID = actregister.actregactID
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'ปัจฉิมนิเทศ' && actregister.actregstdID ='$stdUser' 
                                                                                && actregister.actregStatus='ยืนยันเรียบร้อย'
                                                                                && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row1 = mysqli_num_rows($result);
                                                                            $rowget1 = mysqli_fetch_assoc($result);
                                                                            if ($row1 > 0) {
                                                                            ?>
                                                                                <a href="actreg_year.php?acttype=<?php echo $rowget1['acttypeName']; ?>&&actyear=<?php echo $year ?>"><?php echo $row1 ?></a>
                                                                            <?php
                                                                            } else if ($row1 < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT actsem.*, activity.*
                                                                                FROM actsem 
                                                                                JOIN activity ON activity.actSem = actsem.actsemNo
                                                                                WHERE 
                                                                                activity.actYear = '$year' && actsem.actsem = '2' && actsem.actsemStatus = 'สำเร็จกิจกรรมแล้ว'
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $rowsem = mysqli_num_rows($result);
                                                                            if ($rowsem > 0) {
                                                                                if ($row <= 1) {
                                                                                    if (($row1 && $row) == 0) {
                                                                            ?>
                                                                                    <?php
                                                                                    } elseif ($row1 < 1) {
                                                                                    ?>
                                                                                        <i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i>
                                                                                    <?php
                                                                                    } elseif ($row1 >= 1) {
                                                                                    ?>
                                                                                        <i class="fa fa-check text-success"><b>ผ่าน</b></i>
                                                                                    <?php
                                                                                    }
                                                                                } elseif ($row > 1) {
                                                                                    $rowresult = ($row - $row1);
                                                                                    if ($rowresult >= 2) {
                                                                                    ?>
                                                                                        <i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i>
                                                                                    <?php
                                                                                    } elseif ($rowresult < 2) {
                                                                                    ?>
                                                                                        <i class="fa fa-check text-success"><b>ผ่าน</b></i>
                                                                            <?php
                                                                                    }
                                                                                }
                                                                            } else if ($rowsem < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                    </tr>
                                                                <!--act7ชมรม-->
                                                                    <tr>

                                                                    <td><a href="javascript:;">กิจกรรมชมรม</a></td>
                                                                        <td><?php echo $clubname ?></td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*, actsem.*,acttype.*
                                                                                FROM activity 
                                                                                JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'กิจกรรมชมรม' && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && activity.actSec = 'มหาวิทยาลัย' && activity.actOrgtion = '$club'
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row = mysqli_num_rows($result);
                                                                            $rowget = mysqli_fetch_assoc($result);
                                                                            // output data of each row
                                                                            ?>
                                                                            <?php if ($row > 0) {
                                                                            ?>
                                                                                <a href="actall_year.php?acttype=<?php echo $rowget['acttypeName']; ?>&&actyear=<?php echo $year ?>"><?php echo $row ?></a>
                                                                            <?php
                                                                            } else if ($row < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*,acttype.*,actregister.*
                                                                                FROM actregister 
                                                                                JOIN activity ON activity.actID = actregister.actregactID
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'กิจกรรมชมรม' && actregister.actregstdID ='$stdUser' 
                                                                                && actregister.actregStatus='ยืนยันเรียบร้อย'
                                                                                && activity.actYear = '$year' 
                                                                                && activity.actSec = 'มหาวิทยาลัย' && activity.actOrgtion = '$club'
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row1 = mysqli_num_rows($result);
                                                                            $rowget1 = mysqli_fetch_assoc($result);
                                                                            if ($row1 > 0) {
                                                                            ?>
                                                                                <a href="actreg_year.php?acttype=<?php echo $rowget1['acttypeName']; ?>&&actyear=<?php echo $year ?>"><?php echo $row1 ?></a>
                                                                            <?php
                                                                            } else if ($row1 < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT actsem.*, activity.*
                                                                                FROM actsem 
                                                                                JOIN activity ON activity.actSem = actsem.actsemNo
                                                                                WHERE 
                                                                                activity.actYear = '$year' && actsem.actsem = '2' && actsem.actsemStatus = 'สำเร็จกิจกรรมแล้ว'
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $rowsem = mysqli_num_rows($result);
                                                                            if ($rowsem > 0) {
                                                                                if ($row <= 1) {
                                                                                    if (($row1 && $row) == 0) {
                                                                            ?>
                                                                                    <?php
                                                                                    } elseif ($row1 < 1) {
                                                                                    ?>
                                                                                        <i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i>
                                                                                    <?php
                                                                                    } elseif ($row1 >= 1) {
                                                                                    ?>
                                                                                        <i class="fa fa-check text-success"><b>ผ่าน</b></i>
                                                                                    <?php
                                                                                    }
                                                                                } elseif ($row > 1) {
                                                                                    $rowresult = ($row - $row1);
                                                                                    if ($rowresult >= 2) {
                                                                                    ?>
                                                                                        <i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i>
                                                                                    <?php
                                                                                    } elseif ($rowresult < 2) {
                                                                                    ?>
                                                                                        <i class="fa fa-check text-success"><b>ผ่าน</b></i>
                                                                            <?php
                                                                                    }
                                                                                }
                                                                            } else if ($rowsem < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                    </tr>
                                                                <!--act8ชุมนุม-->
                                                                    <tr>
                                                                    <td><a href="javascript:;">กิจกรรมชุมนุม</a></td>
                                                                        <td><?php echo $dpmName ?></td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*, actsem.*,acttype.*, organization.*
                                                                                FROM activity 
                                                                                JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                JOIN organization ON activity.actOrgtion = organization.orgtionNo
                                                                                WHERE 
                                                                                acttype.acttypeName = 'กิจกรรมชุมนุม' && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actMainorg = '$fct' && organization.organization = '$dpmName')
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row = mysqli_num_rows($result);
                                                                            $rowget = mysqli_fetch_assoc($result);
                                                                            // output data of each row
                                                                            ?>
                                                                            <?php if ($row > 0) {
                                                                            ?>
                                                                                <a href="actall_year.php?acttype=<?php echo $rowget['acttypeName']; ?>&&actyear=<?php echo $year ?>"><?php echo $row ?></a>
                                                                            <?php  } else if ($row < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*,acttype.*,actregister.*, organization.*
                                                                                FROM actregister 
                                                                                JOIN activity ON activity.actID = actregister.actregactID
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                JOIN organization ON activity.actOrgtion = organization.orgtionNo
                                                                                WHERE 
                                                                                acttype.acttypeName = 'กิจกรรมชุมนุม' && actregister.actregstdID ='$stdUser' 
                                                                                && actregister.actregStatus='ยืนยันเรียบร้อย'
                                                                                && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actMainorg = '$fct' && organization.organization = '$dpmName')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row1 = mysqli_num_rows($result);
                                                                            $rowget1 = mysqli_fetch_assoc($result);
                                                                            if ($row1 > 0) {
                                                                            ?>
                                                                                <a href="actreg_year.php?acttype=<?php echo $rowget1['acttypeName']; ?>&&actyear=<?php echo $year ?>"><?php echo $row1 ?></a>
                                                                            <?php
                                                                            } else if ($row1 < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT actsem.*, activity.*
                                                                                FROM actsem 
                                                                                JOIN activity ON activity.actSem = actsem.actsemNo
                                                                                WHERE 
                                                                                activity.actYear = '$year' && actsem.actsem = '2' && actsem.actsemStatus = 'สำเร็จกิจกรรมแล้ว'
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $rowsem = mysqli_num_rows($result);
                                                                            if ($rowsem > 0) {
                                                                                if ($row <= 1) {
                                                                                    if (($row1 && $row) == 0) {
                                                                            ?>
                                                                                    <?php
                                                                                    } elseif ($row1 < 1) {
                                                                                    ?>
                                                                                        <i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i>
                                                                                    <?php
                                                                                    } elseif ($row1 >= 1) {
                                                                                    ?>
                                                                                        <i class="fa fa-check text-success"><b>ผ่าน</b></i>
                                                                                    <?php
                                                                                    }
                                                                                } elseif ($row > 1) {
                                                                                    $rowresult = ($row - $row1);
                                                                                    if ($rowresult >= 2) {
                                                                                    ?>
                                                                                        <i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i>
                                                                                    <?php
                                                                                    } elseif ($rowresult < 2) {
                                                                                    ?>
                                                                                        <i class="fa fa-check text-success"><b>ผ่าน</b></i>
                                                                            <?php
                                                                                    }
                                                                                }
                                                                            } else if ($rowsem < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                    </tr>
                                                                <!--act9กิจกรรมอบศ-->
                                                                    <tr>
                                                                    <td><a href="javascript:;">เข้าร่วม 5 กิจกรรมที่จัดโดยองค์การบริหารนักศึกษา</a></td>
                                                                        <td>ตลอดทั้งปีการศึกษา</td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*, actsem.*,acttype.*,mainorg.*,organization.* 
                                                                                FROM activity 
                                                                                JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                JOIN mainorg ON mainorg.mainorgNo = activity.actMainorg
                                                                                JOIN organization ON organization.orgtionNo = activity.actOrgtion
                                                                                WHERE 
                                                                                acttype.acttypeName = 'กิจกรรมองค์การบริหารนักศึกษา' 
                                                                                && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (mainorg.mainorg = 'องค์การบริหารนักศึกษา' || organization.organization = 'องค์การบริหารนักศึกษา') 
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row = mysqli_num_rows($result);
                                                                            $rowget = mysqli_fetch_assoc($result);
                                                                            // output data of each row
                                                                            ?>
                                                                            <?php if ($row > 0) {
                                                                            ?>
                                                                                <a href="actall_year.php?acttype=<?php echo $rowget['acttypeName']; ?>&&actyear=<?php echo $year ?>"><?php echo $row ?></a>
                                                                            <?php
                                                                            } else if ($row < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*,acttype.*,actregister.*,mainorg.*,organization.* 
                                                                                FROM actregister 
                                                                                JOIN activity ON activity.actID = actregister.actregactID
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                JOIN mainorg ON mainorg.mainorgNo = activity.actMainorg
                                                                                JOIN organization ON organization.orgtionNo = activity.actOrgtion
                                                                                WHERE 
                                                                                acttype.acttypeName = 'กิจกรรมองค์การบริหารนักศึกษา' && actregister.actregstdID ='$stdUser' 
                                                                                && actregister.actregStatus='ยืนยันเรียบร้อย'
                                                                                && activity.actYear = '$year' 
                                                                                && (mainorg.mainorg = 'องค์การบริหารนักศึกษา' || organization.organization = 'องค์การบริหารนักศึกษา') 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row1 = mysqli_num_rows($result);
                                                                            $rowget1 = mysqli_fetch_assoc($result);
                                                                            if ($row1 > 0) {
                                                                            ?>
                                                                                <a href="actreg_year.php?acttype=<?php echo $rowget1['acttypeName']; ?>&&actyear=<?php echo $year ?>"><?php echo $row1 ?></a>
                                                                            <?php
                                                                            } else if ($row1 < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT actsem.*, activity.*
                                                                                FROM actsem 
                                                                                JOIN activity ON activity.actSem = actsem.actsemNo
                                                                                WHERE 
                                                                                activity.actYear = '$year' && actsem.actsem = '2' && actsem.actsemStatus = 'สำเร็จกิจกรรมแล้ว'
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $rowsem = mysqli_num_rows($result);
                                                                            if ($rowsem > 0) {
                                                                                if ($row <= 1) {
                                                                                    if (($row1 && $row) == 0) {
                                                                            ?>
                                                                                    <?php
                                                                                    } elseif ($row1 < 1) {
                                                                                    ?>
                                                                                        <i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i>
                                                                                    <?php
                                                                                    } elseif ($row1 >= 1) {
                                                                                    ?>
                                                                                        <i class="fa fa-check text-success"><b>ผ่าน</b></i>
                                                                                    <?php
                                                                                    }
                                                                                } elseif ($row > 1) {
                                                                                    $rowresult = ($row - $row1);
                                                                                    if (($rowresult < 2) || ($row1 = 5)) {
                                                                                    ?>
                                                                                        <i class="fa fa-check text-success"><b>ผ่าน</b></i>
                                                                                    <?php } elseif ($rowresult >= 2) {
                                                                                    ?>
                                                                                        <i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i>
                                                                            <?php
                                                                                    }
                                                                                }
                                                                            } else if ($rowsem < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                    </tr>
                                                                <!--act10กิจกรรมสโมสร-->
                                                                    <tr>
                                                                    <td><a href="javascript:;">เข้าร่วม 5 กิจกรรมที่จัดโดยสโมสรคณะ</a></td>
                                                                        <td>ตลอดทั้งปีการศึกษา</td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*, actsem.*,acttype.*, organization.* 
                                                                                FROM activity 
                                                                                JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                JOIN organization ON activity.actOrgtion = organization.orgtionNo
                                                                                WHERE 
                                                                                acttype.acttypeName = 'กิจกรรมสโมรสรคณะ' 
                                                                                && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actMainorg = '$fct' || organization.organization = 'สโมสรคณะ') 
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row = mysqli_num_rows($result);
                                                                            $rowget = mysqli_fetch_assoc($result);
                                                                            // output data of each row
                                                                            ?>
                                                                            <?php if ($row > 0) {
                                                                            ?>
                                                                                <a href="actall_year.php?acttype=<?php echo $rowget['acttypeName']; ?>&&actyear=<?php echo $year ?>"><?php echo $row ?></a>
                                                                            <?php  } else if ($row < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*,acttype.*,actregister.*, organization.*
                                                                                FROM actregister 
                                                                                JOIN activity ON activity.actID = actregister.actregactID
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                JOIN organization ON activity.actOrgtion = organization.orgtionNo
                                                                                WHERE 
                                                                                acttype.acttypeName = 'กิจกรรมสโมสรคณะ' && actregister.actregstdID ='$stdUser' 
                                                                                && actregister.actregStatus='ยืนยันเรียบร้อย'
                                                                                && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actMainorg = '$fct' || organization.organization = 'สโมสรคณะ') 
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row1 = mysqli_num_rows($result);
                                                                            $rowget1 = mysqli_fetch_assoc($result);
                                                                            if ($row1 > 0) {
                                                                            ?>
                                                                                <a href="actreg_year.php?acttype=<?php echo $rowget1['acttypeName']; ?>&&actyear=<?php echo $year ?>"><?php echo $row1 ?></a>
                                                                            <?php
                                                                            } else if ($row1 < 0) {
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT actsem.*, activity.*
                                                                                FROM actsem 
                                                                                JOIN activity ON activity.actSem = actsem.actsemNo
                                                                                WHERE 
                                                                                activity.actYear = '$year' && actsem.actsem = '2' && actsem.actsemStatus = 'สำเร็จกิจกรรมแล้ว'
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $rowsem = mysqli_num_rows($result);
                                                                            if ($rowsem > 0) {
                                                                                if ($row <= 1) {
                                                                                    if (($row1 && $row) == 0) {
                                                                            ?>
                                                                                    <?php
                                                                                    } elseif ($row1 < 1) {
                                                                                    ?>
                                                                                        <i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i>
                                                                                    <?php
                                                                                    } elseif ($row1 >= 1) {
                                                                                    ?>
                                                                                        <i class="fa fa-check text-success"><b>ผ่าน</b></i>
                                                                                    <?php
                                                                                    }
                                                                                } elseif ($row > 1) {
                                                                                    $rowresult = ($row - $row1);
                                                                                    if (($rowresult < 2) || ($row1 = 5)) {
                                                                                    ?>
                                                                                        <i class="fa fa-check text-success"><b>ผ่าน</b></i>
                                                                                    <?php } elseif ($rowresult >= 2) {
                                                                                    ?>
                                                                                        <i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i>
                                                                            <?php
                                                                                    }
                                                                                }
                                                                            } else if ($rowsem < 0) {
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
                                                </div>
                                            </div>
                                        </div><br>
                                    </div>
                                </div>
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

</body>

</html>