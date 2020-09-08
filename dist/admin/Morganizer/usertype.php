<?php
session_start();
if (!isset($_SESSION['orgzerName']) && ($_SESSION['orgzerID'])) {
    header('location: ../../');
    echo "กรุณาเข้าสู่ระบบ!";
} else {
}
include '../../db/dbcon.php';
$usertypeAddby = $_SESSION['orgzerID'];
?>
<?php

include '../../db/dbcon.php';

if (isset($_POST["btupdateusertype"])) {

    $sqspacial = "SELECT usertypeID FROM usertype";
    $resulda = mysqli_query($conn, $sqspacial);

    if (mysqli_num_rows($resulda) > 0) {
        while ($roid = mysqli_fetch_assoc($resulda)) {

            //menu1
            if (isset($_POST["cb1" . $roid["usertypeID"]])) {
                $trdo1 = "true";
            } else {
                $trdo1 = "false";
            }
            //menu2
            if (isset($_POST["cb2" . $roid["usertypeID"]])) {
                $trdo2 = "true";
            } else {
                $trdo2 = "false";
            }
            //menu3
            if (isset($_POST["cb3" . $roid["usertypeID"]])) {
                $trdo3 = "true";
            } else {
                $trdo3 = "false";
            }
            //menu4
            if (isset($_POST["cb4" . $roid["usertypeID"]])) {
                $trdo4 = "true";
            } else {
                $trdo4 = "false";
            }
            //menu5
            if (isset($_POST["cb5" . $roid["usertypeID"]])) {
                $trdo5 = "true";
            } else {
                $trdo5 = "false";
            }
            //menu6
            if (isset($_POST["cb6" . $roid["usertypeID"]])) {
                $trdo6 = "true";
            } else {
                $trdo6 = "false";
            }
            //menu7
            if (isset($_POST["cb7" . $roid["usertypeID"]])) {
                $trdo7 = "true";
            } else {
                $trdo7 = "false";
            }
            //menu8
            if (isset($_POST["cb8" . $roid["usertypeID"]])) {
                $trdo8 = "true";
            } else {
                $trdo8 = "false";
            }
            //menu9
            if (isset($_POST["cb9" . $roid["usertypeID"]])) {
                $trdo9 = "true";
            } else {
                $trdo9 = "false";
            }
            //menu10
            if (isset($_POST["cb10" . $roid["usertypeID"]])) {
                $trdo10 = "true";
            } else {
                $trdo10 = "false";
            }
            //menu11
            if (isset($_POST["cb11" . $roid["usertypeID"]])) {
                $trdo11 = "true";
            } else {
                $trdo11 = "false";
            }
            //menu12
            if (isset($_POST["cb12" . $roid["usertypeID"]])) {
                $trdo12 = "true";
            } else {
                $trdo12 = "false";
            }
            //menu13
            if (isset($_POST["cb13" . $roid["usertypeID"]])) {
                $trdo13 = "true";
            } else {
                $trdo13 = "false";
            }
            //menu14
            if (isset($_POST["cb14" . $roid["usertypeID"]])) {
                $trdo14 = "true";
            } else {
                $trdo14 = "false";
            }


            $sqlu = "UPDATE usertype 
                        SET M_1='$trdo1',M_2='$trdo2',
                            M_3='$trdo3',M_4='$trdo4',
                            M_5='$trdo5',M_6='$trdo6',
                            M_7='$trdo7',M_8='$trdo8',
                            M_9='$trdo9',M_10='$trdo10',
                            M_11='$trdo11',M_12='$trdo12',
                            M_13='$trdo13',M_14='$trdo14'
                        WHERE usertypeID='$roid[usertypeID]'";
            mysqli_query($conn, $sqlu);
        }
    }
}
?>
<?php
if (isset($_POST['btaddusertype'])) {
    $eutype = $_POST["userType"];
    $eutypeSec = $_POST["usertypeSec"];
    if ($eutype != "" && $eutypeSec != "") {

        include '../../db/dbcon.php';
        $sql1 = "SELECT * FROM usertype WHERE userType='$eutype' && usertypeSec= '$eutypeSec' ";
        $result = $conn->query($sql1);
        if ($result->num_rows > 0) {
            $errMSG = "ขออภัย!ประเภทผู้ใช้นี้ได้ถูกเพิ่มแล้ว";
        } else {

            //checkbox 1
            if (!isset($_POST["cb1"])) {
                $eucheck1 = "false";
            } else {

                $eucheck1 = $_POST["cb1"];
                //echo "cb1 is not blank.".$eucheck2;
            }
            //checkbox 2
            if (!isset($_POST["cb2"])) {
                $eucheck2 = "false";
            } else {

                $eucheck2 = $_POST["cb2"];
                //echo "cb2 is not blank.".$eucheck2;
            }
            //checkbox 3
            if (!isset($_POST["cb3"])) {
                $eucheck3 = "false";
            } else {

                $eucheck3 = $_POST["cb3"];
                //echo "cb2 is not blank.".$eucheck2;
            }
            //checkbox 4
            if (!isset($_POST["cb4"])) {
                $eucheck4 = "false";
            } else {

                $eucheck4 = $_POST["cb4"];
                //echo "cb1 is not blank.".$eucheck2;
            }
            //checkbox 5
            if (!isset($_POST["cb5"])) {
                $eucheck5 = "false";
            } else {

                $eucheck5 = $_POST["cb5"];
                //echo "cb1 is not blank.".$eucheck2;
            }
            //checkbox 6
            if (!isset($_POST["cb6"])) {
                $eucheck6 = "false";
            } else {

                $eucheck6 = $_POST["cb6"];
                //echo "cb1 is not blank.".$eucheck2;
            }
            //checkbox 7
            if (!isset($_POST["cb7"])) {
                $eucheck7 = "false";
            } else {

                $eucheck7 = $_POST["cb7"];
                //echo "cb1 is not blank.".$eucheck2;
            }
            //checkbox 8
            if (!isset($_POST["cb8"])) {
                $eucheck8 = "false";
            } else {

                $eucheck8 = $_POST["cb8"];
                //echo "cb1 is not blank.".$eucheck2;
            }
            //checkbox 9
            if (!isset($_POST["cb9"])) {
                $eucheck9 = "false";
            } else {

                $eucheck9 = $_POST["cb9"];
                //echo "cb1 is not blank.".$eucheck2;
            }
            //checkbox 10
            if (!isset($_POST["cb10"])) {
                $eucheck10 = "false";
            } else {

                $eucheck10 = $_POST["cb10"];
                //echo "cb1 is not blank.".$eucheck2;
            }
            //checkbox 11
            if (!isset($_POST["cb11"])) {
                $eucheck11 = "false";
            } else {

                $eucheck11 = $_POST["cb11"];
                //echo "cb1 is not blank.".$eucheck2;
            }
            //checkbox 12
            if (!isset($_POST["cb12"])) {
                $eucheck12 = "false";
            } else {

                $eucheck12 = $_POST["cb12"];
                //echo "cb1 is not blank.".$eucheck2;
            }
            //checkbox 13
            if (!isset($_POST["cb13"])) {
                $eucheck13 = "false";
            } else {

                $eucheck13 = $_POST["cb13"];
                //echo "cb1 is not blank.".$eucheck2;
            }//checkbox 14
            if (!isset($_POST["cb14"])) {
                $eucheck14 = "false";
            } else {

                $eucheck14 = $_POST["cb14"];
                //echo "cb1 is not blank.".$eucheck2;
            }

            //insert into database
            $sql2 = "INSERT INTO usertype (userType,usertypeSec,M_1, M_2, M_3, M_4, M_5, M_6, M_7, M_8, M_9, M_10, M_11, M_12, M_13,M_14, usertypeAddby) VALUES ('$eutype','$eutypeSec','$eucheck1','$eucheck2','$eucheck3','$eucheck4','$eucheck5','$eucheck6','$eucheck7','$eucheck8','$eucheck9','$eucheck10','$eucheck11','$eucheck12','$eucheck13','$eucheck14','$usertypeAddby')";
            if (mysqli_query($conn, $sql2)) {
                $successMSG = "ทำการเพิ่มประเภทผู้ใช้เรียบร้อย";
                header("refresh:1; usertype.php");
            } else {
                $errMSG = "Error: " . $sql2 . "<br>" . mysqli_error($conn);
            }
        }
    } else {
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width initial-scale=1.0">
    <title>ระบบกิจกรรมนักศึกษา| จัดการประเภทผู้ใช้</title>
    <!-- GLOBAL MAINLY STYLES-->
    <link href="../../assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../../assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
    <link href="../../assets/vendors/themify-icons/css/themify-icons.css" rel="stylesheet" />
    <!-- PLUGINS STYLES-->
    <link href="../../assets/vendors/select2/dist/css/select2.min.css" rel="stylesheet" />
    <link href="../../assets/vendors/DataTables/datatables.min.css" rel="stylesheet" />
    <link href="../../assets/vendors/jvectormap/jquery-jvectormap-2.0.3.css" rel="stylesheet" />
    <!-- THEME STYLES-->
    <link href="../../assets/css/main.min.css" rel="stylesheet" />
    <!-- PAGE LEVEL STYLES-->
    <style>
        .breadcrumb-item {
            font-size: 16px;
        }

        .td {
            text-align: center;
        }
    </style>
</head>

<body class="fixed-navbar" >

    <!-- Main content -->

    <div class="page-content fade-in-up" style="padding:20px;padding-top:0px">
        <div class="page-heading">
            <h1 class="page-title">จัดการประเภทผู้ใช้</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                </li>
                <li class="breadcrumb-item"><a href="organizer.php">จัดการเจ้าหน้าที่</a></li>
                <li class="breadcrumb-item">จัดการประเภทผู้ใช้</li>
            </ol>
        </div>
        <br>

        <a href="organizer.php"><button class="btn btn-info"  type="button"> <span class="fa fa-pencil"></span> &nbsp; จัดการเจ้าหน้าที่</button></a>&nbsp;&nbsp;
        <a href="organization.php"><button class="btn btn-info"  type="button"> <span class="fa fa-pencil"></span> &nbsp; จัดการรายชื่อองค์กร</button></a>&nbsp;&nbsp;
        <a href="../Mhalaqah/halaqahtc.php"><button class="btn btn-info"  type="button"> <span class="fa fa-pencil"></span> &nbsp; จัดการที่ปรึกษากลุ่มศึกษาอัลกุรอ่าน</button></a>&nbsp;&nbsp;
        <a href="mainorg.php"><button class="btn btn-info"  type="button"> <span class="fa fa-pencil"></span> &nbsp; จัดการรายชื่อสังกัด</button></a>
        
        <br>
        <br>
        <?php
        if (isset($errMSG)) {
        ?>
            <div class="alert alert-danger">
                <span class="fa fa-info-sign"></span> <strong><?php echo $errMSG; ?></strong>
            </div>
        <?php
        } else if (isset($successMSG)) {
        ?>
            <div class="alert alert-success">
                <strong><span class="fa fa-info-sign"></span> <?php echo $successMSG; ?></strong>
            </div>
        <?php
        }
        ?>
        <div class="ibox" style="box-shadow: 0 5px 4px rgba(0,0,0,.1);">
            <div class="ibox-head" style="background-color:#d1cbaf;">
                <div class="ibox-title" style="color:#484848;">
                    <h5>เพิ่มประเภทผู้ใช้</h5>
                </div>
                <div class="ibox-tools">
                    <a class="ibox-collapse" style="color:#484848;"><i class="fa fa-minus"></i></a>
                </div>
            </div>
            <div class="ibox-body">
                <form class="form-horizontal" id="form-sample-1" method="post" novalidate="novalidate">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">ประเภทผู้ใช้</label>
                        <div class="col-sm-3">
                            <input class="form-control" type="text" name="userType" value="" required />
                        </div>
                        <label class="col-sm-1 col-form-label">ระดับ</label>
                        <div class="col-sm-3">
                            <select class="form-control select2_demo_1" style="width: 100%;" name="usertypeSec" required>
                                <option selected="selected" disabled="disabled">--ระดับ--</option>
                                <option value="คณะ"> คณะ</option>
                                <option value="มหาวิทยาลัย"> มหาวิทยาลัย</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">จัดการผู้ดูแล</label>
                        <div class="col-sm-1">
                            <input type="checkbox" name="cb1" value="true">
                        </div>
                        <label class="col-sm-3 col-form-label">จัดการเจ้าหน้าที่</label>
                        <div class="col-sm-1">
                            <input type="checkbox" name="cb2" value="true">
                        </div>
                        <label class="col-sm-3 col-form-label">จัดการนักศึกษา</label>
                        <div class="col-sm-1">
                            <input type="checkbox" name="cb3" value="true">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">จัดการตำแหน่งนักศึกษา</label>
                        <div class="col-sm-1">
                            <input type="checkbox" name="cb4" value="true">
                        </div>
                        <label class="col-sm-3 col-form-label">จัดการชมรม</label>
                        <div class="col-sm-1">
                            <input type="checkbox" name="cb5" value="true">
                        </div>
                        <label class="col-sm-3 col-form-label">ส่งคำร้องขอกิจกรรม</label>
                        <div class="col-sm-1">
                            <input type="checkbox" name="cb6" value="true">
                        </div>
                        
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">ตอบกลับคำร้องขอกิจกรรม</label>
                        <div class="col-sm-1">
                            <input type="checkbox" name="cb7" value="true">
                        </div>
                        <label class="col-sm-3 col-form-label">จัดการกิจกรรมทั้งหมด</label>
                        <div class="col-sm-1">
                            <input type="checkbox" name="cb8" value="true">
                        </div>
                        <label class="col-sm-3 col-form-label">จัดการกิจกรรมของฉัน</label>
                        <div class="col-sm-1">
                            <input type="checkbox" name="cb9" value="true">
                        </div>
                        
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">ตรวจสอบการเข้าร่วม</label>
                        <div class="col-sm-1">
                            <input type="checkbox" name="cb10" value="true">
                        </div>
                        <label class="col-sm-3 col-form-label">จัดการบอร์ดประชาสัมพันธ์</label>
                        <div class="col-sm-1">
                            <input type="checkbox" name="cb11" value="true">
                        </div>
                        <label class="col-sm-3 col-form-label">จัดการกลุ่มศึกษาอัลกุรอ่าน</label>
                        <div class="col-sm-1">
                            <input type="checkbox" name="cb12" value="true">
                        </div>
                        
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">ติดต่อ</label>
                        <div class="col-sm-1">
                            <input type="checkbox" name="cb13" value="true">
                        </div>
                        <label class="col-sm-3 col-form-label">ประวัติการเข้าใช้</label>
                        <div class="col-sm-1">
                            <input type="checkbox" name="cb14" value="true">
                        </div>
                        <div class="col-sm-3">
                            <input class="form-control" type="hidden" name="usertypeAddby" value="<?php echo $usertypeAddby; ?>" readonly />
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12 text-center">
                            <button class="btn btn-info" type="submit" name="btaddusertype" value="submit">เพิ่ม</button>
                            <a href="usertype.php"><button class="btn btn-danger" type="button" data-dismiss="ibox">ยกเลิก</button></a>
                        </div>
                    </div>
                </form>

            </div>
        </div>
        <div class="row ">
            <div class="col-12">
            <div class="card"style="border-width:0px;border-bottom-width:4px;border-right-width:4px;">
                    <div class="card-header"style="background-color:#d1cbaf">
                        <h5 style="color:#2c2c2c">ตารางประเภทผู้ใช้</h5>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body  text-nowrap">
                        <form method="post">
                            <table id="tbusertype" class="table table-bordered  table-striped table-md text-center">
                            <thead>
                                <tr style="color:#528124;">
                                    <th> ประเภทผู้ใช้</th>
                                    <th>ระดับ</th>
                                    <!--td align="center" bgcolor="#FF6600">Image</td-->
                                    <!--this here will add column for change image-->
                                    <th>จัดการผู้ดูแล</th>
                                    <th>จัดการเจ้าหน้าที่</th>
                                    <th>จัดการนักศึกษา</th>
                                    <th>จัดการตำแหน่งนักศึกษา</th>
                                    <th>จัดการชมรม</th>
                                    <th>ส่งคำร้องขอกิจกรรม</th>
                                    <th>ตอบกลับคำร้องขอกิจกรรม</th>
                                    <th>จัดการกิจกรรมทั้งหมด</th>
                                    <th>จัดการกิจกรรมของฉัน</th>
                                    <th>ตรวจสอบการเข้าร่วม</th>
                                    <th>จัดการบอร์ดประชาสัมพันธ์</th>
                                    <th>จัดการกลุ่มศึกษาอัลกุรอ่าน</th>
                                    <th>ติดต่อ</th>
                                    <th>ประวัติการเข้าใช้</th>
                                    <th>เพิ่มโดย</th>
                                    
                                </tr>
                            </thead> 
                            
                            <tbody>
                                <?php
                                include '../../db/dbcon.php';
                                $sqld = "SELECT * FROM usertype ORDER BY usertypeID DESC";
                                $result = mysqli_query($conn, $sqld);

                                if (mysqli_num_rows($result) > 0) {
                                    // output data of each row
                                    while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                            <tr>
                                                <td><?php echo $row['userType']; ?></td>
                                                <td><?php echo $row['usertypeSec']; ?></td>
                                                <td><?php echo "<input type=\"checkbox\" name=\"cb1" . $row["usertypeID"] . "\" value=\"" . $row["M_1"] . "\" "; ?>
                                                    <?php if ($row["M_1"] == "true") {
                                                        echo "checked";
                                                    } else {
                                                    }
                                                    echo ">";
                                                    ?>
                                                </td>
                                                <td><?php echo "<input type=\"checkbox\" name=\"cb2" . $row["usertypeID"] . "\" value=\"" . $row["M_2"] . "\" "; ?>
                                                    <?php if ($row["M_2"] == "true") {
                                                        echo "checked";
                                                    } else {
                                                    }
                                                    echo ">";
                                                    ?>
                                                </td>
                                                <td><?php echo "<input type=\"checkbox\" name=\"cb3" . $row["usertypeID"] . "\" value=\"" . $row["M_3"] . "\" "; ?>
                                                    <?php if ($row["M_3"] == "true") {
                                                        echo "checked";
                                                    } else {
                                                    }
                                                    echo ">";
                                                    ?>
                                                </td>
                                                <td><?php echo "<input type=\"checkbox\" name=\"cb4" . $row["usertypeID"] . "\" value=\"" . $row["M_4"] . "\" "; ?>
                                                    <?php if ($row["M_4"] == "true") {
                                                        echo "checked";
                                                    } else {
                                                    }
                                                    echo ">";
                                                    ?>
                                                </td>
                                                <td><?php echo "<input type=\"checkbox\" name=\"cb5" . $row["usertypeID"] . "\" value=\"" . $row["M_5"] . "\" "; ?>
                                                    <?php if ($row["M_5"] == "true") {
                                                        echo "checked";
                                                    } else {
                                                    }
                                                    echo ">";
                                                    ?>
                                                </td>
                                                <td><?php echo "<input type=\"checkbox\" name=\"cb6" . $row["usertypeID"] . "\" value=\"" . $row["M_6"] . "\" "; ?>
                                                    <?php if ($row["M_6"] == "true") {
                                                        echo "checked";
                                                    } else {
                                                    }
                                                    echo ">";
                                                    ?>
                                                </td>
                                                <td><?php echo "<input type=\"checkbox\" name=\"cb7" . $row["usertypeID"] . "\" value=\"" . $row["M_7"] . "\" "; ?>
                                                    <?php if ($row["M_7"] == "true") {
                                                        echo "checked";
                                                    } else {
                                                    }
                                                    echo ">";
                                                    ?>
                                                </td>
                                                <td><?php echo "<input type=\"checkbox\" name=\"cb8" . $row["usertypeID"] . "\" value=\"" . $row["M_8"] . "\" "; ?>
                                                    <?php if ($row["M_8"] == "true") {
                                                        echo "checked";
                                                    } else {
                                                    }
                                                    echo ">";
                                                    ?>
                                                </td>
                                                <td><?php echo "<input type=\"checkbox\" name=\"cb9" . $row["usertypeID"] . "\" value=\"" . $row["M_9"] . "\" "; ?>
                                                    <?php if ($row["M_9"] == "true") {
                                                        echo "checked";
                                                    } else {
                                                    }
                                                    echo ">";
                                                    ?>
                                                </td>
                                                <td><?php echo "<input type=\"checkbox\" name=\"cb10" . $row["usertypeID"] . "\" value=\"" . $row["M_10"] . "\" "; ?>
                                                    <?php if ($row["M_10"] == "true") {
                                                        echo "checked";
                                                    } else {
                                                    }
                                                    echo ">";
                                                    ?>
                                                </td>
                                                <td><?php echo "<input type=\"checkbox\" name=\"cb11" . $row["usertypeID"] . "\" value=\"" . $row["M_11"] . "\" "; ?>
                                                    <?php if ($row["M_11"] == "true") {
                                                        echo "checked";
                                                    } else {
                                                    }
                                                    echo ">";
                                                    ?>
                                                </td>
                                                <td><?php echo "<input type=\"checkbox\" name=\"cb12" . $row["usertypeID"] . "\" value=\"" . $row["M_12"] . "\" "; ?>
                                                    <?php if ($row["M_12"] == "true") {
                                                        echo "checked";
                                                    } else {
                                                    }
                                                    echo ">";
                                                    ?>
                                                </td>
                                                <td><?php echo "<input type=\"checkbox\" name=\"cb13" . $row["usertypeID"] . "\" value=\"" . $row["M_13"] . "\" "; ?>
                                                    <?php if ($row["M_13"] == "true") {
                                                        echo "checked";
                                                    } else {
                                                    }
                                                    echo ">";
                                                    ?>
                                                </td>
                                                <td><?php echo "<input type=\"checkbox\" name=\"cb14" . $row["usertypeID"] . "\" value=\"" . $row["M_14"] . "\" "; ?>
                                                    <?php if ($row["M_14"] == "true") {
                                                        echo "checked";
                                                    } else {
                                                    }
                                                    echo ">";
                                                    ?>
                                                </td>
                                                <td><?php echo $row['usertypeAddby']; ?></td>
                                                
                                            </tr>
                                    <?php }
                                } else {
                                    echo "0 results";
                                }

                                mysqli_close($conn);
                                    ?>

                            </tbody>
                        </table>
                        <input align="center" type="submit" name="btupdateusertype" value="SAVE">
                        </form>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>



    <!-- BEGIN PAGA BACKDROPS-->
    <!-- END PAGA BACKDROPS-->
    <!-- CORE PLUGINS-->
    <script src="../../assets/vendors/jquery/dist/jquery.min.js" type="text/javascript"></script>
    <script src="../../assets/vendors/popper.js/dist/umd/popper.min.js" type="text/javascript"></script>
    <script src="../../assets/vendors/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="../../assets/vendors/metisMenu/dist/metisMenu.min.js" type="text/javascript"></script>
    <script src="../../assets/vendors/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <!-- PAGE LEVEL PLUGINS-->
    <script src="../../assets/vendors/select2/dist/js/select2.full.min.js" type="text/javascript"></script>
    <script src="../../assets/vendors/jquery.maskedinput/dist/jquery.maskedinput.min.js" type="text/javascript"></script>
    <script src="../../assets/vendors/jquery-validation/dist/jquery.validate.min.js" type="text/javascript"></script>
    <script src="../../assets/vendors/DataTables/datatables.min.js" type="text/javascript"></script>
    <!-- CORE SCRIPTS-->
    <script src="../../assets/js/app.min.js" type="text/javascript"></script>
    <!-- PAGE LEVEL SCRIPTS-->
    <script src="../../assets/js/scripts/form-plugins.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(function() {
            $('#tbusertype').DataTable({
                pageLength: 10,
                "scrollX": true
                //"ajax": './assets/demo/data/table_data.json',
                /*"columns": [
                    { "data": "name" },
                    { "data": "office" },
                    { "data": "extn" },
                    { "data": "start_date" },
                    { "data": "salary" }
                ]*/
            });
            $('.dataTables_length').addClass('bs-select');
        });
        $('#ex-phone').mask('(999) 999-9999');
        $("#form-sample-1").validate({
            rules: {
                name: {
                    minlength: 2,
                    required: !0
                },
                email: {
                    required: !0,
                    email: !0
                },
                url: {
                    required: !0,
                    url: !0
                },
                number: {
                    required: !0,
                    number: !0
                },
                min: {
                    required: !0,
                    minlength: 3
                },
                max: {
                    required: !0,
                    maxlength: 4
                },
                password: {
                    required: !0
                },
                password_confirmation: {
                    required: !0,
                    equalTo: "#password"
                }
            },
            errorClass: "help-block error",
            highlight: function(e) {
                $(e).closest(".form-group.row").addClass("has-error")
            },
            unhighlight: function(e) {
                $(e).closest(".form-group.row").removeClass("has-error")
            },
        });
    </script>

</body>

</html>