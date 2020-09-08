<?php
session_start();
if(!isset($_SESSION['orgzerName'])){
	
	echo "กรุณาลงชื่อเข้าใช้ระบบก่อน!";
	
} else if(isset($_SESSION['orgzerName'])){
	
	include '../../db/dbcon.php';
	
	$lgid = $_SESSION["orgzerID"];
	$lgby = $_SESSION["orgzerName"];
	$lguserType = $_SESSION["orgzeruserType"];
	
	$sql = "INSERT INTO loginhistory (userID, userName, userType, action)
	VALUES ('$lgid', '$lgby', '$lguserType', 'logout')";

	if (mysqli_query($conn, $sql)) {
		echo "New record created successfully";
	} else {
		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}
	
	session_unset();
	session_destroy();
	echo "ทำการออกจากระบบเรียบร้อย!";
} else {
	echo "Unknown condition!";
}
header ('location: ../../welcome/home.php');
?>