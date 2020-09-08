<?php
session_start();
if (!isset($_SESSION['orgzerName']) && ($_SESSION['orgzerID'])) {
  header('location: ../../');
  echo "กรุณาเข้าสู่ระบบ!";
} else {
}
include '../../db/dbcon.php';
$orgzerAddby = $_SESSION['orgzerID'];
?>
<?php
                $sql = "SELECT orgzerSec FROM organizer WHERE orgzerID = '$orgzerAddby'";
                $result = mysqli_query($conn, $sql);
                mysqli_num_rows($result);
                // output data of each row
                $row = mysqli_fetch_assoc($result);
                ?>
                <option  selected="selected"disabled="disabled">--กรุณาเลือกสังกัด--</option>
                <?php
                if (($row["orgzerSec"] == "Admin")||($row["orgzerSec"] == "มหาวิทยาลัย")) {
                    require_once '../../db/dbconfig.php';
                    $stmt = $DBcon->prepare("SELECT * FROM mainorg
                    WHERE mainorgSec='" . $_POST["secName"] . "' ");
                    $stmt->execute();
                    ?>
                                  

                    <?php
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $mainorgNo = $row["mainorgNo"];
                    $mainorg = $row["mainorg"];
                    ?>
                    <option value="<?php echo $mainorgNo ?>"> <?php echo $mainorg ?></option>
                    <?php
                    }
                }
                if ($row["orgzerSec"] == "คณะ") {
                  $sql = "SELECT organizer.*, mainorg.* FROM organizer
                                              JOIN mainorg ON organizer.orgzerMainorg = mainorg.mainorgNo
                                              WHERE organizer.orgzerID = '$orgzerAddby'
                                              ";
                  $result = $conn->query($sql);

                  if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                      $mainorgNo = $row["mainorgNo"];
                      $mainorglist = $row["mainorg"];
                    ?>
                      <option value="<?php echo $mainorgNo ?>"> <?php echo $mainorglist ?></option>
                    <?php
                    }
                  } else {
                    echo "something";
                  }
                }
                ?>