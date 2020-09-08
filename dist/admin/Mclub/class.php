<?php
    require_once("../class/session.php");
    
    require_once("../class/class.organizer.php");
    $auth_orgzer = new ORGANIZER();
     
    $orgzerID = $_SESSION['orgzer_session'];
    
    $stmt = $auth_orgzer->runQuery("SELECT organizer.*, usertype.* FROM organizer
    JOIN usertype ON organizer.orgzeruserType = usertype.usertypeID WHERE orgzerID=:orgzerID");
    $stmt->execute(array(":orgzerID"=>$orgzerID));
    
    $orgzerRow=$stmt->fetch(PDO::FETCH_ASSOC);
?>