<?php
require_once '../../db/dbconfig.php';
$stmt = $DBcon->prepare("SELECT * FROM organization
WHERE orgtionMainorg='" . $_POST["mainorgNo"] . "' ");
$stmt->execute();
?>
<?php
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
$orgtionNo = $row["orgtionNo"];
$organization = $row["organization"];
?>
<option value="<?php echo $orgtionNo ?>"> <?php echo $organization ?></option>
<?php
}
?>
