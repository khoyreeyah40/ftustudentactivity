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
    $stmt_view = $DB_con->prepare('SELECT student.*, department.*,faculty.*,mainorg.*, teacher.* FROM student 
    JOIN department ON department.dpmNo = student.stdDpm
    JOIN faculty ON faculty.faculty = student.stdFct
    JOIN mainorg ON mainorg.mainorgNo = faculty.faculty
    JOIN teacher ON teacher.teacherNo = student.stdTC
    WHERE stdID=:id');
    $stmt_view->execute(array(':id' => $id));
    $view_row = $stmt_view->fetch(PDO::FETCH_ASSOC);
    extract($view_row);
}
?>
<div class="card-body">
    <div class="row mt-2">
        <div class="col-sm-6">
            <div class="form-group">
                <label>ปีที่เข้าศึกษา</label>
                <input type="text" class="form-control" name="stdYear" value="<?php echo $stdYear; ?>" readonly>
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-sm-6">
            <div class="form-group">
                <label>รหัสนักศึกษา</label>
                <input type="text" class="form-control" name="stdID" value="<?php echo $stdID; ?>" readonly>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>ชื่อ-สกุล</label>
                <input type="text" class="form-control" name="stdName" value="<?php echo $stdName; ?>" readonly>
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-sm-6">
            <div class="form-group">
                <label>คณะ</label>
                <select class="form-control" style="width: 100%;" name="mainorg" readonly>
                    <option> <?php echo $mainorg; ?></option>
                </select>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>สาขา</label>
                <select class="form-control" style="width: 100%;" name="department" readonly>
                    <option> <?php echo $department; ?></option>
                </select>
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-sm-6">
            <div class="form-group">
                <label>อาจารย์ที่ปรึกษา</label>
                <select class="form-control" style="width: 100%;" name="teacher" readonly>
                    <option> <?php echo $teacher; ?></option>
                </select>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>กลุ่ม</label>
                <select class="form-control" style="width: 100%;" name="stdGroup" readonly>
                    <option> <?php echo $stdGroup; ?></option>
                </select>
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-sm-6">
            <div class="form-group">
                <label>หมายเลขโทรศัพท์</label>
                <input type="text" class="form-control" name="stdPhone" value="<?php echo $stdPhone; ?>" readonly />
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Email</label>
                <input type="text" class="form-control" name="stdEmail" value="<?php echo $stdEmail; ?>" readonly />
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-sm-6">
            <div class="form-group">
                <label>Facebook</label>
                <input type="text" class="form-control" name="stdFb" value="<?php echo $stdFb; ?>" readonly />
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Password</label>
                <input type="text" class="form-control" name="stdPassword" value="<?php echo $stdPassword; ?>" readonly />
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-sm-6">
            <div class="form-group">
                <label>รูปประจำตัว</label>
                <img src="../../assets/img/profile/value=" <?php echo $stdImage; ?>"" align="center" class="img-rounded" width="220px" height="200px" />
            </div>
        </div>
    </div>
</div>