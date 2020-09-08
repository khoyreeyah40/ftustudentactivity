<?php
require_once '../../db/dbconfig.php';
$stmt = $DBcon->prepare("SELECT * FROM organization
                WHERE orgtionMainorg='" . $_POST["mainorgNo"] . "' ");
$stmt->execute();
?>
              <option  selected="selected" disabled="disabled">--กรุณาเลือกองค์กร--</option>

<?php
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $orgtionNo = $row["orgtionNo"];
    $organization = $row["organization"];
?>
    <option value="<?php echo $orgtionNo ?>"> <?php echo $organization ?></option>
    <?php
}
?>