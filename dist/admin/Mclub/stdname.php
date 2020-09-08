<?php
require_once '../../db/dbconfig.php';
$stmt = $DBcon->prepare("SELECT * FROM student
WHERE stdID='" . $_POST["stdID"] . "' ");
$stmt->execute();
?>
<?php
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
$stdName = $row["stdName"];
?>
<option value="<?php echo $stdName ?>"> <?php echo $stdName ?></option>
<?php
}
?>
