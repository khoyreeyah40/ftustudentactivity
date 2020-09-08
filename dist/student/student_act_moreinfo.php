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

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $stmt_view = $DB_con->prepare('SELECT activity.*, organization.*, acttype.*, mainorg.* 
                                   FROM activity 
                                   JOIN organization ON organization.orgtionNo = activity.actOrgtion
                                   JOIN acttype ON acttype.acttypeNo = activity.actType
                                   JOIN mainorg ON mainorg.mainorgNo = activity.actMainorg 
                                   WHERE activity.actID=:actID');
    $stmt_view->execute(array(':actID' => $id));
    $view_row = $stmt_view->fetch(PDO::FETCH_ASSOC);
    extract($view_row);
}
?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body ">
                <ul class="nav nav-tabs nav-pills">
                    <li class="nav-item">
                        <a class="nav-link active" href="#pill-1-1" data-toggle="tab">รายละเอียดเพิ่มเติม</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#pill-1-2" data-toggle="tab">รายชื่อผู้ลงทะเบียน</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="pill-1-1">
                        <table class="table">
                            <tr>
                                <td class="text-info" style="font-size:16px;width: 30%;border-top: 0px;"><b>ประจำปีการศึกษา</b></td>
                                <td style="border-top: 0px;"><?php echo $actSem; ?>/<?php echo $actYear; ?> </td>
                            </tr>
                            <tr>
                                <td class="text-info" style="font-size:16px;width: 30%;"><b>ชื่อกิจกรรม</td>
                                <td><?php echo $actName; ?></td>
                            </tr>
                            <tr>
                                <td class="text-info" style="font-size:16px;width: 30%;"><b>หมวดหมู่</td>
                                <td><?php echo $acttypeName; ?></td>
                            </tr>
                            <tr>
                                <td class="text-info" style="font-size:16px;width: 30%;"><b>กลุ่ม</td>
                                <td><?php echo $actGroup; ?></td>
                            </tr>
                            <tr>
                                <td class="text-info" style="font-size:16px;width: 30%;"><b>ระดับ</td>
                                <td><?php echo $actSec; ?></td>
                            </tr>
                            <tr>
                                <td class="text-info" style="font-size:16px;width: 30%;"><b>สังกัด</td>
                                <td><?php echo $mainorg; ?></td>
                            </tr>
                            <tr>
                                <td class="text-info" style="font-size:16px;width: 30%;"><b>องค์กร</td>
                                <td><?php echo $organization; ?></td>
                            </tr>
                            <tr>
                                <td class="text-info" style="font-size:16px;width: 30%;"><b>เวลาที่จัด</td>
                                <td><?php echo $actTimeb; ?> - <?php echo $actTimee; ?></td>
                            </tr>
                            <tr>
                                <td class="text-info" style="font-size:16px;width: 30%;"><b>วันที่จัด</td>
                                <td><?php echo $actDateb; ?> - <?php echo $actDatee; ?></td>
                            </tr>
                            <tr>
                                <td class="text-info" style="font-size:16px;width: 30%;"><b>สถานที่</td>
                                <td><?php echo $actLocate; ?></td>
                            </tr>
                            <tr>
                                <td class="text-info" style="font-size:16px;width: 30%;"><b>ค่าลงทะเบียน</td>
                                <td><?php echo $actPay; ?></td>
                            </tr>
                            <tr>
                                <td class="text-info" style="font-size:16px;width: 30%;"><b>หลักการและเหตุผล</td>
                                <td><?php echo $actReason; ?></td>
                            </tr>
                            <tr>
                                <td class="text-info" style="font-size:16px;width: 30%;"><b>วัตถุประสงค์โครงการ</td>
                                <td><?php echo $actPurpose; ?></td>
                            </tr>
                            <tr>
                                <td class="text-info" style="font-size:16px;width: 30%;"><b>รูปแบบหรือลักษณะการดำเนินการ</td>
                                <td><?php echo $actStyle; ?></td>
                            </tr>
                            <tr style="border-bottom: 1px solid #e8e8e8;">
                                <td class="text-info" style="font-size:16px;width: 30%;"><b>หมายเหตุ</td>
                                <td><?php echo $actNote; ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="tab-pane" id="pill-1-2">
                        <table id="tbactreg" class="table table-hover table-striped text-center" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>รหัสนักศึกษา</th>
                                    <th>ชื่อ-สกุล</th>
                                    <th>สาขา</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                require_once '../db/dbconfig.php';
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
                                        <td><?php echo $row['actregstdID']; ?></td>
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