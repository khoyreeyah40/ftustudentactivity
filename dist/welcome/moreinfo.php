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
    $stmt_view = $DB_con->prepare('SELECT actYear,actStatus,actName,actSec,actMainorg,actOrgtion,actType,actGroup,actReason,actPurpose,actStyle,actTimeb,actTimee,actDateb,actDatee,actLocate,actPay,actAddby,actFile,createat FROM activity WHERE actNo=:id');
    $stmt_view->execute(array(':id' => $id));
    $view_row = $stmt_view->fetch(PDO::FETCH_ASSOC);
    extract($view_row);
}
?>
<div class="card-body">
    <div class="row mt-2">
        <div class="col-sm-6">
            <div class="form-group">
                <label>ปีการศึกษา</label>
                <select class="form-control" style="width: 100%;" name="actYear" readonly>
                    <option> <?php echo $actYear; ?></option>
                </select>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>สถานะ</label>
                <select class="form-control" style="width: 100%;" name="actStatus" readonly>
                    <option> <?php echo $actStatus; ?></option>
                </select>
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-sm-6">
            <div class="form-group">
                <label>ชื่อกิจกรรม</label>
                <input type="text" class="form-control" name="actName" value="<?php echo $actName; ?>" readonly />
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>กลุ่ม</label>
                <select class="form-control" style="width: 100%;" name="actGroup" readonly>
                    <option> <?php echo $actGroup; ?></option>
                </select>
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-sm-6">
            <div class="form-group">
                <label>ระดับ</label>
                <select class="form-control" style="width: 100%;" name="actSec" readonly>
                    <option> <?php echo $actSec; ?></option>
                </select>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>สังกัด</label>
                <select class="form-control" style="width: 100%;" name="actMainorg" readonly>
                    <option> <?php echo $actMainorg; ?></option>
                </select>
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-sm-6">
            <div class="form-group">
                <label>องค์กร</label>
                <select class="form-control" style="width: 100%;" name="actOrgtion" readonly>
                    <option> <?php echo $actOrgtion; ?></option>
                </select>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>หมวดหมู่</label>
                <select class="form-control" style="width: 100%;" name="actType" readonly>
                    <option> <?php echo $actType; ?></option>
                </select>
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-sm-12">
            <div class="form-group">
                <label>หลักการและเหตุผล</label>
                <textarea type="text" class="form-control" rows="2" name="actReason" value="<?php echo $actReason; ?>" readonly></textarea>
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-sm-12">
            <div class="form-group">
                <label>วัตถุประสงค์โครงการ</label>
                <textarea type="text" class="form-control" rows="2" name="actPurpose" value="<?php echo $actPurpose; ?>" readonly></textarea>
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-sm-12">
            <div class="form-group">
                <label>รูปแบบหรือลักษณะการดำเนินการ</label>
                <textarea type="text" class="form-control" rows="2" name="actStyle" value="<?php echo $actStyle; ?>" readonly></textarea>
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-sm-12">
            <div class="form-group row" id="date_5">
                <label class="col-sm-1 col-form-label">เวลา</label>
                <div class="col-sm-5 input-daterange input-group" id="datepicker">
                    <input class="input-sm form-control" type="text" name="actTimeb" placeholder="00.00" value="<?php echo $actTimeb; ?>" required />
                    <span class="input-group-addon p-l-10 p-r-10">ถึง</span>
                    <input class="input-sm form-control" type="text" name="actTimee" placeholder="00.00" value="<?php echo $actTimee; ?>" required />
                </div>
                <label class="col-sm-1 col-form-label">วันที่</label>
                <div class="col-sm-5 input-daterange input-group" id="datepicker">
                    <input class="input-sm form-control" type="text" name="actDateb" placeholder="1/1/2563" value="<?php echo $actDateb; ?>" required />
                    <span class="input-group-addon p-l-10 p-r-10">ถึง</span>
                    <input class="input-sm form-control" type="text" name="actDatee" placeholder="1/1/2563" value="<?php echo $actDatee; ?>" required />
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-sm-6">
            <div class="form-group">
                <label>สถานที่</label>
                <input type="text" class="form-control" name="actLocate" value="<?php echo $actLocate; ?>" readonly />
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>ค่าลงทะเบียน</label>
                <input type="text" class="form-control" name="actPay" value="<?php echo $actPay; ?>" readonly />
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-sm-6">
            <div class="form-group">
                <label>ไฟล์ใบโครงการ</label>
                <input type="text" class="form-control" name="actFile" value="<?php echo $actFile; ?>" readonly />
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>เพิ่มโดย</label>
                <input type="text" class="form-control" name="actAddby" value="<?php echo $actAddby; ?>" readonly />
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-sm-6">
            <div class="form-group">
                <label>เพิ่มวันที่</label>
                <input type="text" class="form-control" name="createat" value="<?php echo $createat; ?>" readonly />
            </div>
        </div>
    </div>
</div>