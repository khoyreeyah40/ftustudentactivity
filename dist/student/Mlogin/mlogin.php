<?php
session_start();
require_once("../class/class.student.php");
$login = new STUDENT();

if ($login->is_loggedin() != "")  //ล๊อกอินแล้วไปไหน
{
	$login->redirect('../Mhome/homepage.php');
}

if (isset($_POST['btlogin'])) {
	$stdID = strip_tags($_POST['stdID']);
	$stdPassword = strip_tags($_POST['stdPassword']);

	if ($login->doLogin($stdID, $stdPassword)) {
		$login->redirect('../Mhome/homepage.php');
	} else {
		$error = "พบข้อผิดพลาดกรุณากรอกอีกครั้ง !";
	}
}
?>

<?php
include '../../db/dbcon.php';
$stdID = $_POST['stdID'];
$stdPassword = $_POST['stdPassword'];


$result = mysqli_query($conn, "SELECT * FROM student WHERE stdID='$stdID' and stdPassword = '$stdPassword'");


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

	$_SESSION["stdID"] = $dato['stdID'];
	$_SESSION["stdName"] = $dato['stdName'];
	$_SESSION["stdFct"] = $dato['stdFct'];
	$_SESSION["stdDpm"] = $dato['stdDpm'];


	$lgid = $_SESSION['stdID'];
	$lgby = $_SESSION["stdName"];
	$lgfct = $_SESSION["stdFct"];
	$lgdpm = $_SESSION["stdDpm"];

	echo "id:" . $lgid;
	echo "name:" . $lgby;
	echo "faculty:" . $lgfct;
	echo "department:" . $lgdpm;


	$sql = "INSERT INTO loginhistory (userID, userName, userMainorg, userOrgtion, userType, action)
VALUES ('$lgid', '$lgby','$lgfct','$lgdpm', 'student', 'login')";

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
