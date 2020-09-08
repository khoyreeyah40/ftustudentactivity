<?php
session_start();
require_once("../class/class.organizer.php");
$login = new ORGANIZER();

if ($login->is_loggedin() != "")  //ล๊อกอินแล้วไปไหน
{
	$login->redirect('../Mhome/homepage.php');
}

if (isset($_POST['btlogin'])) {
	$orgzerID = strip_tags($_POST['orgzerID']);
	$orgzerPassword = strip_tags($_POST['orgzerPassword']);

	if ($login->doLogin($orgzerID, $orgzerPassword)) {
		$login->redirect('../Mhome/homepage.php');
	} else {
		$error = "พบข้อผิดพลาดกรุณากรอกอีกครั้ง !";
	}
}
?>

<?php
include '../../db/dbcon.php';
$orgzerID = $_POST['orgzerID'];
$orgzerPassword = $_POST['orgzerPassword'];


$result = mysqli_query($conn, "SELECT * FROM organizer WHERE orgzerID='$orgzerID' and orgzerPassword = '$orgzerPassword'");


$num_rows = mysqli_num_rows($result);


if ($num_rows == 0) {
	// remove all session variables
	session_unset();

	header('Location: login.php');

	// destroy the session 
	session_destroy();
} else if ($num_rows == 1) {
	echo "You've successfully login." . $num_rows . "<br>";

	mysqli_data_seek($result, 0);
	$dato = mysqli_fetch_array($result);

	$_SESSION["orgzerID"] = $dato['orgzerID'];
	$_SESSION["orgzerName"] = $dato['orgzerName'];
	$_SESSION["orgzerMainorg"] = $dato['orgzerMainorg'];
	$_SESSION["orgzerOrgtion"] = $dato['orgzerOrgtion'];
	$_SESSION["orgzeruserType"] = $dato['orgzeruserType'];


	$lgid = $_SESSION['orgzerID'];
	$lgby = $_SESSION["orgzerName"];
	$lgmainorg = $_SESSION["orgzerMainorg"];
	$lgorgtion = $_SESSION["orgzerOrgtion"];
	$lguserType = $_SESSION["orgzeruserType"];

	echo "id:" . $lgid;
	echo "name:" . $lgby;
	echo "mainorg:" . $lgmainorg;
	echo "orgtion:" . $lgorgtion;
	echo "usertype:" . $lguserType;


	$sql = "INSERT INTO loginhistory (userID, userName, userMainorg, userOrgtion, userType, action)
VALUES ('$lgid', '$lgby','$lgmainorg','$lgorgtion', '$lguserType', 'login')";

	if (mysqli_query($conn, $sql)) {
		echo "New record created successfully";
	} else {
		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}
	header('Location: ../Mhome/homepage.php');
} else if ($num_rows <= 2) {
	echo "myproject Error 001" . $num_rows;
}
?>
