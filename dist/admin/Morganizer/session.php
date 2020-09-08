<?php
    session_start();
    if(!isset($_SESSION['orgzerName'])&&($_SESSION['orgzerID'])){
      header('location: ../../');
      echo "กรุณาเข้าสู่ระบบ!";
    }else{}
    include '../../db/dbcon.php';
    $mainorgAddby = $_SESSION['orgzerID'];
?>