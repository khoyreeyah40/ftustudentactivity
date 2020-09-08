<?php
	require_once('../class/session.php');
	require_once('../class/class.organizer.php');
	$logout = new ORGANIZER();
	
	if($logout->is_loggedin()!="")
	{
		$logout->redirect('../Mhome/homepage.php');
	}
	if(isset($_GET['logout']) && $_GET['logout']=="true")
	{
		$logout->doLogout();
		$logout->redirect('../../welcome/home.php');
	}