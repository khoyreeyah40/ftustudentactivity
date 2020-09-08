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
    $stmt_view = $DB_con->prepare('SELECT * FROM board WHERE boardNo=:id');
    $stmt_view->execute(array(':id' => $id));
    $view_row = $stmt_view->fetch(PDO::FETCH_ASSOC);
    extract($view_row);
}
?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body ">
                        <table class="table">
                            <tr>
                                <td style="color:#417d19;font-size:16px;width: 30%;border-top: 0px;"><b>ชื่อบอร์ด</b></td>
                                <td style="border-top: 0px;"><?php echo $boardName; ?> </td>
                            </tr>
                            <tr>
                                <td style="color:#417d19;" style="font-size:16px;width: 30%;"><b>คำอธิบาย</td>
                                <td><?php echo $boardDiscribe; ?></td>
                            </tr>
                            <tr>
                                <td style="color:#417d19;" style="font-size:16px;width: 30%;"><b>ลิ้งค์บอร์ด</td>
                                <td><a href="<?php echo $boardLink ?>"target="_blank"><?php echo $boardLink ?></a></td>
                            </tr>
                            <tr>
                                <td style="color:#417d19;" style="font-size:16px;width: 30%;"><b>บอร์ด</td>
                                <td><img src="../../assets/img/<?php echo $board; ?>" align="center" class="img-rounded" width="500px" height="450px" /></td>
                            </tr>
                        </table>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-sm ml-auto">
                                <div class="form-group" style="color:#417d19;">
                                    <label >เพิ่มเมื่อ:</label>
                                    <span><?php echo $createat;?></span>
                                </div>
                            </div>
                            <div class="col-sm mr-auto">
                                <div class="form-group" style="color:#417d19;">
                                    <label>เพิ่มโดย:</label>
                                    <span><?php echo $boardAddby;?></span>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>