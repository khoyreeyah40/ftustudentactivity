<?php
require_once '../../db/dbconfig.php';
$stmt = $DBcon->prepare("SELECT mainorg.*, teacher.*, faculty.* FROM teacher
JOIN faculty ON faculty.faculty = teacher.teacherfct
JOIN mainorg ON mainorg.mainorgNo = faculty.faculty
WHERE teacher.teacherfct='" . $_POST["faculty"] . "' ");
$stmt->execute();
?>

 <option  disabled="disabled">--อาจารย์ที่ปรึกษา--</option>
 
<?php
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
$tcNo = $row["teacherNo"];
$teacherlist = $row["teacher"];
?>
<option value="<?php echo $tcNo ?>"> <?php echo $teacherlist ?></option>
<?php
}
?>
