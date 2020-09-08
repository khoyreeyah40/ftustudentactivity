<?php
session_start();
if(!isset($_SESSION['stdID'])){
	
	echo "กรุณาลงชื่อเข้าใช้ระบบก่อน!";
	
} else if(isset($_SESSION['stdID'])){
	
	include '../../db/dbcon.php';
	
	$lgid = $_SESSION["stdID"];
	$lgby = $_SESSION["stdName"];
	
	$sql = "INSERT INTO loginhistory (userID, userName, userType, action)
	VALUES ('$lgid', '$lgby', 'student', 'logout')";

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