<?php
require_once '../../db/dbconfig.php';
$stmt = $DBcon->prepare("SELECT mainorg.*, department.*, faculty.* FROM department
JOIN faculty ON faculty.faculty = department.dpmfct
JOIN mainorg ON mainorg.mainorgNo = faculty.faculty
WHERE department.dpmfct='" . $_POST["faculty"] . "' ");
$stmt->execute();
?>
 <option selected="selected" disabled="disabled">--สาขา--</option>
<?php
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
$dpmNo = $row["dpmNo"];
$departmentlist = $row["department"];
?>
<option value="<?php echo $dpmNo ?>"> <?php echo $departmentlist ?></option>
<?php
}
?>
