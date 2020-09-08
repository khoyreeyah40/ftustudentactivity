
                                <div class="row justify-content-center">
                                    <div class="col-md-10">
                                        <table id="tbresult" class="table table-condensed  text-center">
                                            <tbody>        
                                                <tr>
                                                    <td style="border-top: 0px;">กิจกรรมชั้นปีที่1</td>
                                                    <td style="width: 70%;border-top: 0px;">
                                                        <div class="progress m-b-0">
                                                            <div class="progress-bar progress-bar-success pull-right" name="y1" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:100%;">0%</div>
                                                        </div>
                                                    </td>
                                                    <td style="border-top: 0px;"><i class="fa fa-check text-success"><b>ผ่าน</b></i></td>
                                                </tr>
                                                <tr>
                                                    <td>กิจกรรมชั้นปีที่2</td>
                                                    <td style="width: 70%;">
                                                        <div class="progress m-b-0">
                                                            <div class="progress-bar progress-bar-danger pull-right" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" style="width:30%;">30%</div>
                                                        </div>
                                                    </td>
                                                    <td><i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i></td>
                                                </tr>
                                                <tr>
                                                    <td>กิจกรรมชั้นปีที่3</td>
                                                    <td style="width: 70%;">
                                                        <div class="progress m-b-0">
                                                            <div class="progress-bar progress-bar-danger pull-right" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" style="width:30%;">30%</div>
                                                        </div>
                                                    </td>
                                                    <td><i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i></td>
                                                </tr>
                                                <tr>
                                                    <td>กิจกรรมชั้นปีที่4</td>
                                                    <td style="width: 70%;">
                                                        <div class="progress m-b-0">
                                                            <div class="progress-bar progress-bar-danger pull-right" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" style="width:30%;">30%</div>
                                                        </div>
                                                    </td>
                                                    <td><i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i></td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 18px;">สถานะ</td>
                                                    <td style="width: 70%;">

                                                    </td>
                                                    <td style="font-size: 18px;"><i class="fa fa-times text-danger"><b>ไม่ผ่าน</b></i></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!--ปี1-->
                                                    <?php
                                                        require_once '../../db/dbconfig.php';
                                                        $stmt = $DBcon->prepare("SELECT student.*, club.*, organization.*,department.* FROM student 
                                                            JOIN club ON club.clubstdID = student.stdID
                                                            JOIN organization ON club.clubOrgtion = organization.orgtionNo
                                                            JOIN department ON student.stdDpm = department.dpmNo
                                                            WHERE student.stdID = '$stdUser' && club.clubYear = student.stdYear ");
                                                        $stmt->execute();
                                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                            $fct = $row["stdFct"];
                                                            $dpm = $row["stdDpm"];
                                                            $dpmName = $row["department"];
                                                            $year = $row["stdYear"];
                                                            $group = $row["stdGroup"];
                                                            $club = $row["clubOrgtion"];
                                                            $clubname = $row["organization"];
                                                            $act;
                                                        ?>

                                                                <!--act1ฮาลาเกาะห์-->
                                                                        <?php
                                                                        require_once '../../db/dbconfig.php';
                                                                        $stmt = $DBcon->prepare("SELECT halaqahstd.*, halaqahtc.* FROM halaqahstd
                                                                                                JOIN halaqahtc ON halaqahtc.halaqahtcNo = halaqahstd.halaqahID
                                                                                                WHERE halaqahstd.halaqahstdID = '$stdUser' && halaqahtc.halaqahtcYear = '$year'
                                                                                                ");
                                                                        $stmt->execute();
                                                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                                            if ($row['halaqahstdsem1Status'] == 'ผ่าน') 
                                                                            { $act=="ผ่าน";}
                                                                            else{$act=="ไม่ผ่าน";}
                                                                        }
                                                                        ?>

                                                                        <?php
                                                                        require_once '../../db/dbconfig.php';
                                                                        $stmt = $DBcon->prepare("SELECT halaqahstd.*, halaqahtc.* FROM halaqahstd
                                                                                                JOIN halaqahtc ON halaqahtc.halaqahtcNo = halaqahstd.halaqahID
                                                                                                WHERE halaqahstd.halaqahstdID = '$stdUser' && halaqahtc.halaqahtcYear = '$year'
                                                                                                ");
                                                                        $stmt->execute();
                                                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                                            if ($row['halaqahstdsem2Status'] == 'ผ่าน') 
                                                                            { $act=="ผ่าน";}
                                                                            else{$act=="ไม่ผ่าน";}
                                                                        }
                                                                        ?>
                                                                <!--act2กิยามุลลัยล์-->
                                                                        <?php
                                                                        require_once '../../db/dbconfig.php';
                                                                        $sql = "SELECT activity.*, actsem.*,acttype.* 
                                                                            FROM activity 
                                                                            JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                            JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                            WHERE 
                                                                            acttype.acttypeName = 'กิยามุลลัยล์' 
                                                                            && (activity.actYear = '$year' && actsem.actsem = '1') 
                                                                            && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                            && (activity.actMainorg = '$fct' || activity.actSec = 'มหาวิทยาลัย') 
                                                                            && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                            ";
                                                                        $result = mysqli_query($conn, $sql);
                                                                        $row = mysqli_num_rows($result);
                                                                            
                                                                        require_once '../../db/dbconfig.php';
                                                                        $sql = "SELECT activity.*, actsem.*,acttype.*,actregister.*
                                                                            FROM actregister 
                                                                            JOIN activity ON activity.actID = actregister.actregactID
                                                                            JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                            JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                            WHERE 
                                                                            acttype.acttypeName = 'กิยามุลลัยล์' && actregister.actregstdID ='$stdUser' 
                                                                            && actregister.actregStatus='ยืนยันเรียบร้อย'
                                                                            && (activity.actYear = '$year' && actsem.actsem = '1') 
                                                                            && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                            && (activity.actMainorg = '$fct' || activity.actSec = 'มหาวิทยาลัย') 
                                                                            ";
                                                                        $result = mysqli_query($conn, $sql);
                                                                        $row1 = mysqli_num_rows($result);
                                                                        
                                                                        if ($row > 0){  
                                                                            if (($row <= 1) && ($row1 >= 1)) { $act=="ผ่าน"; 
                                                                            }elseif (($row > 1) && (($row - $row1)<2)){ $act=="ผ่าน"; 
                                                                            }else{ $act=="ไม่ผ่าน";}
                                                                        }else{ }
                                                                        ?>
                                                                    <!--กิยามุลลัยล์2-->
                                                                        <?php
                                                                        require_once '../../db/dbconfig.php';
                                                                        $sql = "SELECT activity.*, actsem.*,acttype.* 
                                                                            FROM activity 
                                                                            JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                            JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                            WHERE 
                                                                            acttype.acttypeName = 'กิยามุลลัยล์' 
                                                                            && (activity.actYear = '$year' && actsem.actsem = '2') 
                                                                            && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                            && (activity.actMainorg = '$fct' || activity.actSec = 'มหาวิทยาลัย') 
                                                                            && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                            ";
                                                                        $result = mysqli_query($conn, $sql);
                                                                        $row = mysqli_num_rows($result);

                                                                        require_once '../../db/dbconfig.php';
                                                                        $sql = "SELECT activity.*, actsem.*,acttype.*,actregister.*
                                                                            FROM actregister 
                                                                            JOIN activity ON activity.actID = actregister.actregactID
                                                                            JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                            JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                            WHERE 
                                                                            acttype.acttypeName = 'กิยามุลลัยล์' && actregister.actregstdID ='$stdUser' 
                                                                            && actregister.actregStatus='ยืนยันเรียบร้อย'
                                                                            && (activity.actYear = '$year' && actsem.actsem = '2') 
                                                                            && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                            ";
                                                                        $result = mysqli_query($conn, $sql);
                                                                        $row1 = mysqli_num_rows($result);

                                                                        if ($row > 0){  
                                                                            if (($row <= 1) && ($row1 >= 1)) { $act=="ผ่าน"; 
                                                                            }elseif (($row > 1) && (($row - $row1)<2)){ $act=="ผ่าน"; 
                                                                            }else{ $act=="ไม่ผ่าน";}
                                                                        }else{ }
                                                                        ?>
                                                                <!--act3อบรมคุณธรรมจริยธรรม-->
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*, actsem.*,acttype.* 
                                                                                FROM activity 
                                                                                JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'อบรมคุณธรรมจริยธรรม' 
                                                                                && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actMainorg = '$fct' || activity.actSec = 'มหาวิทยาลัย') 
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row = mysqli_num_rows($result);

                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*,acttype.*,actregister.*
                                                                                FROM actregister 
                                                                                JOIN activity ON activity.actID = actregister.actregactID
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'อบรมคุณธรรมจริยธรรม' && actregister.actregstdID ='$stdUser' 
                                                                                && actregister.actregStatus='ยืนยันเรียบร้อย'
                                                                                && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row1 = mysqli_num_rows($result);

                                                                            if ($row > 0){  
                                                                                if (($row <= 1) && ($row1 >= 1)) { $act=="ผ่าน"; 
                                                                                }elseif (($row > 1) && (($row - $row1)<2)){ $act=="ผ่าน"; 
                                                                                }else{ $act=="ไม่ผ่าน";}
                                                                            }else{ }
                                                                            ?>
                                                                <!--act4ค่ายพัฒนานักศึกษา-->
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*, actsem.*,acttype.* 
                                                                                FROM activity 
                                                                                JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'ค่ายพัฒนานักศึกษา(ปี1)' && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actMainorg = '$fct' || activity.actSec = 'มหาวิทยาลัย') 
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row = mysqli_num_rows($result);

                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*,acttype.*,actregister.*
                                                                                FROM actregister 
                                                                                JOIN activity ON activity.actID = actregister.actregactID
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'ค่ายพัฒนานักศึกษา(ปี1)' && actregister.actregstdID ='$stdUser' 
                                                                                && actregister.actregStatus='ยืนยันเรียบร้อย'
                                                                                && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row1 = mysqli_num_rows($result);

                                                                            if ($row > 0){  
                                                                                if (($row <= 1) && ($row1 >= 1)) { $act=="ผ่าน"; 
                                                                                }elseif (($row > 1) && (($row - $row1)<2)){ $act=="ผ่าน"; 
                                                                                }else{ $act=="ไม่ผ่าน";}
                                                                            }else{ }
                                                                            ?>
                                                                <!--act5อิอฺติก๊าฟ-->
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT * 
                                                                                FROM eiatiqaf
                                                                                WHERE 
                                                                                eiatiqafstdID = '$stdUser' && eiatiqafYear = '$year' 
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $rowfile = mysqli_num_rows($result);

                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*,acttype.* 
                                                                                FROM activity 
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'อิอฺติก๊าฟ 10 วันสุดท้ายเดือนรอมฎอน' 
                                                                                && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actMainorg = '$fct' || activity.actSec = 'มหาวิทยาลัย') 
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row = mysqli_num_rows($result);

                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*,acttype.*,actregister.*
                                                                                FROM actregister 
                                                                                JOIN activity ON activity.actID = actregister.actregactID
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'อิอฺติก๊าฟ 10 วันสุดท้ายเดือนรอมฎอน' && actregister.actregstdID ='$stdUser' 
                                                                                && actregister.actregStatus='ยืนยันเรียบร้อย'
                                                                                && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row1 = mysqli_num_rows($result);
                                                                            
                                                                            if ($row > 0) {  
                                                                                if (($row <= 1) && ($row1 >= 1)) { $act=="ผ่าน"; 
                                                                                }elseif (($row > 1) && (($row - $row1)<2)){ $act=="ผ่าน"; 
                                                                                }elseif($rowfile>1){$act ="ผ่าน";   
                                                                                }else{$act=="ไม่ผ่าน";}
                                                                            }else{ }
                                                                            ?>
                                                                <!--act6ปฐมนิเทศ-->
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*, actsem.*,acttype.* 
                                                                                FROM activity 
                                                                                JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'ปฐมนิเทศ' && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && activity.actSec = 'มหาวิทยาลัย' 
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row = mysqli_num_rows($result);

                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*,acttype.*,actregister.*
                                                                                FROM actregister 
                                                                                JOIN activity ON activity.actID = actregister.actregactID
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'ปฐมนิเทศ' && actregister.actregstdID ='$stdUser' 
                                                                                && actregister.actregStatus='ยืนยันเรียบร้อย'
                                                                                && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row1 = mysqli_num_rows($result);
                                                                            if ($row > 0){  
                                                                                if (($row <= 1) && ($row1 >= 1)) { $act=="ผ่าน"; 
                                                                                }elseif (($row > 1) && (($row - $row1)<2)){ $act=="ผ่าน"; 
                                                                                }else{ $act=="ไม่ผ่าน";}
                                                                            }else{ }
                                                                            ?>
                                                                <!--act7ชมรม-->
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*, actsem.*,acttype.*
                                                                                FROM activity 
                                                                                JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'กิจกรรมชมรม' && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && activity.actSec = 'มหาวิทยาลัย' && activity.actOrgtion = '$club'
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row = mysqli_num_rows($result);

                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*,acttype.*,actregister.*
                                                                                FROM actregister 
                                                                                JOIN activity ON activity.actID = actregister.actregactID
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'กิจกรรมชมรม' && actregister.actregstdID ='$stdUser' 
                                                                                && actregister.actregStatus='ยืนยันเรียบร้อย'
                                                                                && activity.actYear = '$year' 
                                                                                && activity.actSec = 'มหาวิทยาลัย' && activity.actOrgtion = '$club'
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row1 = mysqli_num_rows($result);
                                                                            
                                                                            if ($row > 0){  
                                                                                if (($row <= 1) && ($row1 >= 1)) { $act=="ผ่าน"; 
                                                                                }elseif (($row > 1) && (($row - $row1)<2)){ $act=="ผ่าน"; 
                                                                                }else{ $act=="ไม่ผ่าน";}
                                                                            }else{ }
                                                                            ?>
                                                                <!--act8ชุมนุม-->
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*, actsem.*,acttype.*, organization.*
                                                                                FROM activity 
                                                                                JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                JOIN organization ON activity.actOrgtion = organization.orgtionNo
                                                                                WHERE 
                                                                                acttype.acttypeName = 'กิจกรรมชุมนุม' && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actMainorg = '$fct' && organization.organization = '$dpmName')
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row = mysqli_num_rows($result);

                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*,acttype.*,actregister.*, organization.*
                                                                                FROM actregister 
                                                                                JOIN activity ON activity.actID = actregister.actregactID
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                JOIN organization ON activity.actOrgtion = organization.orgtionNo
                                                                                WHERE 
                                                                                acttype.acttypeName = 'กิจกรรมชุมนุม' && actregister.actregstdID ='$stdUser' 
                                                                                && actregister.actregStatus='ยืนยันเรียบร้อย'
                                                                                && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actMainorg = '$fct' && organization.organization = '$dpmName')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row1 = mysqli_num_rows($result);
                                                                            
                                                                            if ($row > 0){  
                                                                                if (($row <= 1) && ($row1 >= 1)) { $act=="ผ่าน"; 
                                                                                }elseif (($row > 1) && (($row - $row1)<2)){ $act=="ผ่าน"; 
                                                                                }else{ $act=="ไม่ผ่าน";}
                                                                            }else{ }
                                                                            ?>
                                                                <!--act9กิจกรรมอบศ-->
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*, actsem.*,acttype.*,mainorg.*,organization.* 
                                                                                FROM activity 
                                                                                JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                JOIN mainorg ON mainorg.mainorgNo = activity.actMainorg
                                                                                JOIN organization ON organization.orgtionNo = activity.actOrgtion
                                                                                WHERE 
                                                                                acttype.acttypeName = 'กิจกรรมองค์การบริหารนักศึกษา' 
                                                                                && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (mainorg.mainorg = 'องค์การบริหารนักศึกษา' || organization.organization = 'องค์การบริหารนักศึกษา') 
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row = mysqli_num_rows($result);

                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*,acttype.*,actregister.*,mainorg.*,organization.* 
                                                                                FROM actregister 
                                                                                JOIN activity ON activity.actID = actregister.actregactID
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                JOIN mainorg ON mainorg.mainorgNo = activity.actMainorg
                                                                                JOIN organization ON organization.orgtionNo = activity.actOrgtion
                                                                                WHERE 
                                                                                acttype.acttypeName = 'กิจกรรมองค์การบริหารนักศึกษา' && actregister.actregstdID ='$stdUser' 
                                                                                && actregister.actregStatus='ยืนยันเรียบร้อย'
                                                                                && activity.actYear = '$year' 
                                                                                && (mainorg.mainorg = 'องค์การบริหารนักศึกษา' || organization.organization = 'องค์การบริหารนักศึกษา') 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row1 = mysqli_num_rows($result);
                                                                            if ($row > 0){  
                                                                                if (($row <= 1) && ($row1 >= 1)) { $act=="ผ่าน"; 
                                                                                }elseif (($row > 1) && ((($row - $row1)<2) || ($row1 = 5))){ $act=="ผ่าน"; 
                                                                                }else{ $act=="ไม่ผ่าน";}
                                                                            }else{ }
                                                                            ?>
                                                                <!--act10กิจกรรมสโมสร-->
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*, actsem.*,acttype.*, organization.* 
                                                                                FROM activity 
                                                                                JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                JOIN organization ON activity.actOrgtion = organization.orgtionNo
                                                                                WHERE 
                                                                                acttype.acttypeName = 'กิจกรรมสโมรสรคณะ' 
                                                                                && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actMainorg = '$fct' || organization.organization = 'สโมสรคณะ') 
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row = mysqli_num_rows($result);

                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*,acttype.*,actregister.*, organization.*
                                                                                FROM actregister 
                                                                                JOIN activity ON activity.actID = actregister.actregactID
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                JOIN organization ON activity.actOrgtion = organization.orgtionNo
                                                                                WHERE 
                                                                                acttype.acttypeName = 'กิจกรรมสโมสรคณะ' && actregister.actregstdID ='$stdUser' 
                                                                                && actregister.actregStatus='ยืนยันเรียบร้อย'
                                                                                && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actMainorg = '$fct' || organization.organization = 'สโมสรคณะ') 
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row1 = mysqli_num_rows($result);
                                                                            if ($row > 0){  
                                                                                if (($row <= 1) && ($row1 >= 1)) { $act=="ผ่าน"; 
                                                                                }elseif (($row > 1) && ((($row - $row1)<2) || ($row1 = 5))){ $act=="ผ่าน"; 
                                                                                }else{ $act=="ไม่ผ่าน";}
                                                                            }else{ 
                                                                }          
                                                            
                                                                require_once '../../db/dbconfig.php';
                                                                $sql = "SELECT actsem.*, activity.*
                                                                    FROM actsem 
                                                                    JOIN activity ON activity.actSem = actsem.actsemNo
                                                                    WHERE 
                                                                    activity.actYear = '$year' && actsem.actsem = '2' && actsem.actsemStatus = 'สำเร็จกิจกรรมแล้ว'
                                                                    ";
                                                                $result = mysqli_query($conn, $sql);
                                                                $rowsem = mysqli_num_rows($result);
                                                                if ($rowsem > 0) {
                                                                    $num=10;
                                                                    $progress=0;
                                                                    if($act=="ผ่าน"){
                                                                    }
                                                                } else if ($rowsem < 0) {
                                                                } 
                                                            }
                                                                ?>
                                <!--ปี1-->
                                <!--ปี2-->
                                                        <?php
                                                        require_once '../../db/dbconfig.php';
                                                        $stmt = $DBcon->prepare("SELECT student.*, club.*,organization.*,department.* FROM student 
                                                            JOIN club ON club.clubstdID = student.stdID
                                                            JOIN organization ON club.clubOrgtion = organization.orgtionNo
                                                            JOIN department ON student.stdDpm = department.dpmNo
                                                            WHERE student.stdID = '$stdUser' && club.clubYear = student.stdYear+1 ");
                                                        $stmt->execute();
                                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                            $fct = $row["stdFct"];
                                                            $dpm = $row["stdDpm"];
                                                            $dpmName = $row["department"];
                                                            $year = $row["stdYear"] + 1;
                                                            $group = $row["stdGroup"];
                                                            $club = $row["clubOrgtion"];
                                                            $clubname = $row["organization"];

                                                        ?>
                                                    
                                                                <!--act1ฮาลาเกาะห์-->
                                                                    <?php
                                                                        require_once '../../db/dbconfig.php';
                                                                        $stmt = $DBcon->prepare("SELECT halaqahstd.*, halaqahtc.* FROM halaqahstd
                                                                                                JOIN halaqahtc ON halaqahtc.halaqahtcNo = halaqahstd.halaqahID
                                                                                                WHERE halaqahstd.halaqahstdID = '$stdUser' && halaqahtc.halaqahtcYear = '$year'
                                                                                                ");
                                                                        $stmt->execute();
                                                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                                            if ($row['halaqahstdsem1Status'] == 'ผ่าน') 
                                                                            { $act=="ผ่าน";}
                                                                            else{$act=="ไม่ผ่าน";}
                                                                        }
                                                                        ?>

                                                                        <?php
                                                                        require_once '../../db/dbconfig.php';
                                                                        $stmt = $DBcon->prepare("SELECT halaqahstd.*, halaqahtc.* FROM halaqahstd
                                                                                                JOIN halaqahtc ON halaqahtc.halaqahtcNo = halaqahstd.halaqahID
                                                                                                WHERE halaqahstd.halaqahstdID = '$stdUser' && halaqahtc.halaqahtcYear = '$year'
                                                                                                ");
                                                                        $stmt->execute();
                                                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                                            if ($row['halaqahstdsem2Status'] == 'ผ่าน') 
                                                                            { $act=="ผ่าน";}
                                                                            else{$act=="ไม่ผ่าน";}
                                                                        }
                                                                        ?>
                                                                <!--act2กิยามุลลัยล์-->
                                                                        <?php
                                                                        require_once '../../db/dbconfig.php';
                                                                        $sql = "SELECT activity.*, actsem.*,acttype.* 
                                                                            FROM activity 
                                                                            JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                            JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                            WHERE 
                                                                            acttype.acttypeName = 'กิยามุลลัยล์' 
                                                                            && (activity.actYear = '$year' && actsem.actsem = '1') 
                                                                            && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                            && (activity.actMainorg = '$fct' || activity.actSec = 'มหาวิทยาลัย') 
                                                                            && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                            ";
                                                                        $result = mysqli_query($conn, $sql);
                                                                        $row = mysqli_num_rows($result);
                                                                            
                                                                        require_once '../../db/dbconfig.php';
                                                                        $sql = "SELECT activity.*, actsem.*,acttype.*,actregister.*
                                                                            FROM actregister 
                                                                            JOIN activity ON activity.actID = actregister.actregactID
                                                                            JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                            JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                            WHERE 
                                                                            acttype.acttypeName = 'กิยามุลลัยล์' && actregister.actregstdID ='$stdUser' 
                                                                            && actregister.actregStatus='ยืนยันเรียบร้อย'
                                                                            && (activity.actYear = '$year' && actsem.actsem = '1') 
                                                                            && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                            && (activity.actMainorg = '$fct' || activity.actSec = 'มหาวิทยาลัย') 
                                                                            ";
                                                                        $result = mysqli_query($conn, $sql);
                                                                        $row1 = mysqli_num_rows($result);
                                                                        
                                                                        if ($row > 0){  
                                                                            if (($row <= 1) && ($row1 >= 1)) { $act=="ผ่าน"; 
                                                                            }elseif (($row > 1) && (($row - $row1)<2)){ $act=="ผ่าน"; 
                                                                            }else{ $act=="ไม่ผ่าน";}
                                                                        }else{ }
                                                                        ?>
                                                                    <!--กิยามุลลัยล์2-->
                                                                        <?php
                                                                        require_once '../../db/dbconfig.php';
                                                                        $sql = "SELECT activity.*, actsem.*,acttype.* 
                                                                            FROM activity 
                                                                            JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                            JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                            WHERE 
                                                                            acttype.acttypeName = 'กิยามุลลัยล์' 
                                                                            && (activity.actYear = '$year' && actsem.actsem = '2') 
                                                                            && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                            && (activity.actMainorg = '$fct' || activity.actSec = 'มหาวิทยาลัย') 
                                                                            && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                            ";
                                                                        $result = mysqli_query($conn, $sql);
                                                                        $row = mysqli_num_rows($result);

                                                                        require_once '../../db/dbconfig.php';
                                                                        $sql = "SELECT activity.*, actsem.*,acttype.*,actregister.*
                                                                            FROM actregister 
                                                                            JOIN activity ON activity.actID = actregister.actregactID
                                                                            JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                            JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                            WHERE 
                                                                            acttype.acttypeName = 'กิยามุลลัยล์' && actregister.actregstdID ='$stdUser' 
                                                                            && actregister.actregStatus='ยืนยันเรียบร้อย'
                                                                            && (activity.actYear = '$year' && actsem.actsem = '2') 
                                                                            && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                            ";
                                                                        $result = mysqli_query($conn, $sql);
                                                                        $row1 = mysqli_num_rows($result);

                                                                        if ($row > 0){  
                                                                            if (($row <= 1) && ($row1 >= 1)) { $act=="ผ่าน"; 
                                                                            }elseif (($row > 1) && (($row - $row1)<2)){ $act=="ผ่าน"; 
                                                                            }else{ $act=="ไม่ผ่าน";}
                                                                        }else{ }
                                                                        ?>
                                                                <!--act3อบรมคุณธรรมจริยธรรม-->
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*, actsem.*,acttype.* 
                                                                                FROM activity 
                                                                                JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'อบรมคุณธรรมจริยธรรม' 
                                                                                && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actMainorg = '$fct' || activity.actSec = 'มหาวิทยาลัย') 
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row = mysqli_num_rows($result);

                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*,acttype.*,actregister.*
                                                                                FROM actregister 
                                                                                JOIN activity ON activity.actID = actregister.actregactID
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'อบรมคุณธรรมจริยธรรม' && actregister.actregstdID ='$stdUser' 
                                                                                && actregister.actregStatus='ยืนยันเรียบร้อย'
                                                                                && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row1 = mysqli_num_rows($result);

                                                                            if ($row > 0){  
                                                                                if (($row <= 1) && ($row1 >= 1)) { $act=="ผ่าน"; 
                                                                                }elseif (($row > 1) && (($row - $row1)<2)){ $act=="ผ่าน"; 
                                                                                }else{ $act=="ไม่ผ่าน";}
                                                                            }else{ }
                                                                            ?>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*, actsem.*,acttype.* 
                                                                                FROM activity 
                                                                                JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'ค่ายพัฒนานักศึกษา(ปี1)' && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actMainorg = '$fct' || activity.actSec = 'มหาวิทยาลัย') 
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row = mysqli_num_rows($result);

                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*,acttype.*,actregister.*
                                                                                FROM actregister 
                                                                                JOIN activity ON activity.actID = actregister.actregactID
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'ค่ายพัฒนานักศึกษา(ปี1)' && actregister.actregstdID ='$stdUser' 
                                                                                && actregister.actregStatus='ยืนยันเรียบร้อย'
                                                                                && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row1 = mysqli_num_rows($result);

                                                                            if ($row > 0){  
                                                                                if (($row <= 1) && ($row1 >= 1)) { $act=="ผ่าน"; 
                                                                                }elseif (($row > 1) && (($row - $row1)<2)){ $act=="ผ่าน"; 
                                                                                }else{ $act=="ไม่ผ่าน";}
                                                                            }else{ }
                                                                            ?>
                                                                <!--act5อิอฺติก๊าฟ-->
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT * 
                                                                                FROM eiatiqaf
                                                                                WHERE 
                                                                                eiatiqafstdID = '$stdUser' && eiatiqafYear = '$year' 
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $rowfile = mysqli_num_rows($result);

                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*,acttype.* 
                                                                                FROM activity 
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'อิอฺติก๊าฟ 10 วันสุดท้ายเดือนรอมฎอน' 
                                                                                && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actMainorg = '$fct' || activity.actSec = 'มหาวิทยาลัย') 
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row = mysqli_num_rows($result);

                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*,acttype.*,actregister.*
                                                                                FROM actregister 
                                                                                JOIN activity ON activity.actID = actregister.actregactID
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'อิอฺติก๊าฟ 10 วันสุดท้ายเดือนรอมฎอน' && actregister.actregstdID ='$stdUser' 
                                                                                && actregister.actregStatus='ยืนยันเรียบร้อย'
                                                                                && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row1 = mysqli_num_rows($result);
                                                                            
                                                                            if ($row > 0) {  
                                                                                if (($row <= 1) && ($row1 >= 1)) { $act=="ผ่าน"; 
                                                                                }elseif (($row > 1) && (($row - $row1)<2)){ $act=="ผ่าน"; 
                                                                                }elseif($rowfile>1){$act ="ผ่าน";   
                                                                                }else{$act=="ไม่ผ่าน";}
                                                                            }else{ }
                                                                            ?>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*, actsem.*,acttype.* 
                                                                                FROM activity 
                                                                                JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'ปฐมนิเทศ' && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && activity.actSec = 'มหาวิทยาลัย' 
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row = mysqli_num_rows($result);

                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*,acttype.*,actregister.*
                                                                                FROM actregister 
                                                                                JOIN activity ON activity.actID = actregister.actregactID
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'ปฐมนิเทศ' && actregister.actregstdID ='$stdUser' 
                                                                                && actregister.actregStatus='ยืนยันเรียบร้อย'
                                                                                && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row1 = mysqli_num_rows($result);
                                                                            if ($row > 0){  
                                                                                if (($row <= 1) && ($row1 >= 1)) { $act=="ผ่าน"; 
                                                                                }elseif (($row > 1) && (($row - $row1)<2)){ $act=="ผ่าน"; 
                                                                                }else{ $act=="ไม่ผ่าน";}
                                                                            }else{ }
                                                                            ?>
                                                                <!--act7ชมรม-->
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*, actsem.*,acttype.*
                                                                                FROM activity 
                                                                                JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'กิจกรรมชมรม' && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && activity.actSec = 'มหาวิทยาลัย' && activity.actOrgtion = '$club'
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row = mysqli_num_rows($result);

                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*,acttype.*,actregister.*
                                                                                FROM actregister 
                                                                                JOIN activity ON activity.actID = actregister.actregactID
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'กิจกรรมชมรม' && actregister.actregstdID ='$stdUser' 
                                                                                && actregister.actregStatus='ยืนยันเรียบร้อย'
                                                                                && activity.actYear = '$year' 
                                                                                && activity.actSec = 'มหาวิทยาลัย' && activity.actOrgtion = '$club'
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row1 = mysqli_num_rows($result);
                                                                            
                                                                            if ($row > 0){  
                                                                                if (($row <= 1) && ($row1 >= 1)) { $act=="ผ่าน"; 
                                                                                }elseif (($row > 1) && (($row - $row1)<2)){ $act=="ผ่าน"; 
                                                                                }else{ $act=="ไม่ผ่าน";}
                                                                            }else{ }
                                                                            ?>
                                                                <!--act8ชุมนุม-->
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*, actsem.*,acttype.*, organization.*
                                                                                FROM activity 
                                                                                JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                JOIN organization ON activity.actOrgtion = organization.orgtionNo
                                                                                WHERE 
                                                                                acttype.acttypeName = 'กิจกรรมชุมนุม' && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actMainorg = '$fct' && organization.organization = '$dpmName')
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row = mysqli_num_rows($result);

                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*,acttype.*,actregister.*, organization.*
                                                                                FROM actregister 
                                                                                JOIN activity ON activity.actID = actregister.actregactID
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                JOIN organization ON activity.actOrgtion = organization.orgtionNo
                                                                                WHERE 
                                                                                acttype.acttypeName = 'กิจกรรมชุมนุม' && actregister.actregstdID ='$stdUser' 
                                                                                && actregister.actregStatus='ยืนยันเรียบร้อย'
                                                                                && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actMainorg = '$fct' && organization.organization = '$dpmName')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row1 = mysqli_num_rows($result);
                                                                            
                                                                            if ($row > 0){  
                                                                                if (($row <= 1) && ($row1 >= 1)) { $act=="ผ่าน"; 
                                                                                }elseif (($row > 1) && (($row - $row1)<2)){ $act=="ผ่าน"; 
                                                                                }else{ $act=="ไม่ผ่าน";}
                                                                            }else{ }
                                                                            ?>
                                                                <!--act9กิจกรรมอบศ-->
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*, actsem.*,acttype.*,mainorg.*,organization.* 
                                                                                FROM activity 
                                                                                JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                JOIN mainorg ON mainorg.mainorgNo = activity.actMainorg
                                                                                JOIN organization ON organization.orgtionNo = activity.actOrgtion
                                                                                WHERE 
                                                                                acttype.acttypeName = 'กิจกรรมองค์การบริหารนักศึกษา' 
                                                                                && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (mainorg.mainorg = 'องค์การบริหารนักศึกษา' || organization.organization = 'องค์การบริหารนักศึกษา') 
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row = mysqli_num_rows($result);

                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*,acttype.*,actregister.*,mainorg.*,organization.* 
                                                                                FROM actregister 
                                                                                JOIN activity ON activity.actID = actregister.actregactID
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                JOIN mainorg ON mainorg.mainorgNo = activity.actMainorg
                                                                                JOIN organization ON organization.orgtionNo = activity.actOrgtion
                                                                                WHERE 
                                                                                acttype.acttypeName = 'กิจกรรมองค์การบริหารนักศึกษา' && actregister.actregstdID ='$stdUser' 
                                                                                && actregister.actregStatus='ยืนยันเรียบร้อย'
                                                                                && activity.actYear = '$year' 
                                                                                && (mainorg.mainorg = 'องค์การบริหารนักศึกษา' || organization.organization = 'องค์การบริหารนักศึกษา') 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row1 = mysqli_num_rows($result);
                                                                            if ($row > 0){  
                                                                                if (($row <= 1) && ($row1 >= 1)) { $act=="ผ่าน"; 
                                                                                }elseif (($row > 1) && ((($row - $row1)<2) || ($row1 = 5))){ $act=="ผ่าน"; 
                                                                                }else{ $act=="ไม่ผ่าน";}
                                                                            }else{ }
                                                                            ?>
                                                                <!--act10กิจกรรมสโมสร-->
                                                                    <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*, actsem.*,acttype.*, organization.* 
                                                                                FROM activity 
                                                                                JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                JOIN organization ON activity.actOrgtion = organization.orgtionNo
                                                                                WHERE 
                                                                                acttype.acttypeName = 'กิจกรรมสโมรสรคณะ' 
                                                                                && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actMainorg = '$fct' || organization.organization = 'สโมสรคณะ') 
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row = mysqli_num_rows($result);

                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*,acttype.*,actregister.*, organization.*
                                                                                FROM actregister 
                                                                                JOIN activity ON activity.actID = actregister.actregactID
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                JOIN organization ON activity.actOrgtion = organization.orgtionNo
                                                                                WHERE 
                                                                                acttype.acttypeName = 'กิจกรรมสโมสรคณะ' && actregister.actregstdID ='$stdUser' 
                                                                                && actregister.actregStatus='ยืนยันเรียบร้อย'
                                                                                && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actMainorg = '$fct' || organization.organization = 'สโมสรคณะ') 
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row1 = mysqli_num_rows($result);
                                                                            if ($row > 0){  
                                                                                if (($row <= 1) && ($row1 >= 1)) { $act=="ผ่าน"; 
                                                                                }elseif (($row > 1) && ((($row - $row1)<2) || ($row1 = 5))){ $act=="ผ่าน"; 
                                                                                }else{ $act=="ไม่ผ่าน";}
                                                                            }else{ }
                                                            }
                                                                ?>
                                <!--ปี2-->  
                                <!--ปี3-->                              
                                                        <?php
                                                        require_once '../../db/dbconfig.php';
                                                        $stmt = $DBcon->prepare("SELECT student.*, club.*, organization.*,department.* FROM student 
                                                            JOIN club ON club.clubstdID = student.stdID
                                                            JOIN organization ON club.clubOrgtion = organization.orgtionNo
                                                            JOIN department ON student.stdDpm = department.dpmNo
                                                            WHERE student.stdID = '$stdUser' && club.clubYear = student.stdYear+2 ");
                                                        $stmt->execute();
                                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                            $fct = $row["stdFct"];
                                                            $dpm = $row["stdDpm"];
                                                            $dpmName = $row["department"];
                                                            $year = $row["stdYear"] + 2;
                                                            $group = $row["stdGroup"];
                                                            $club = $row["clubOrgtion"];
                                                            $clubname = $row["organization"];

                                                        ?>
                                                                <!--act1ฮาลาเกาะห์-->
                                                                        <?php
                                                                        require_once '../../db/dbconfig.php';
                                                                        $stmt = $DBcon->prepare("SELECT halaqahstd.*, halaqahtc.* FROM halaqahstd
                                                                                                JOIN halaqahtc ON halaqahtc.halaqahtcNo = halaqahstd.halaqahID
                                                                                                WHERE halaqahstd.halaqahstdID = '$stdUser' && halaqahtc.halaqahtcYear = '$year'
                                                                                                ");
                                                                        $stmt->execute();
                                                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                                            if ($row['halaqahstdsem1Status'] == 'ผ่าน') 
                                                                            { $act=="ผ่าน";}
                                                                            else{$act=="ไม่ผ่าน";}
                                                                        }
                                                                        ?>

                                                                        <?php
                                                                        require_once '../../db/dbconfig.php';
                                                                        $stmt = $DBcon->prepare("SELECT halaqahstd.*, halaqahtc.* FROM halaqahstd
                                                                                                JOIN halaqahtc ON halaqahtc.halaqahtcNo = halaqahstd.halaqahID
                                                                                                WHERE halaqahstd.halaqahstdID = '$stdUser' && halaqahtc.halaqahtcYear = '$year'
                                                                                                ");
                                                                        $stmt->execute();
                                                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                                            if ($row['halaqahstdsem2Status'] == 'ผ่าน') 
                                                                            { $act=="ผ่าน";}
                                                                            else{$act=="ไม่ผ่าน";}
                                                                        }
                                                                        ?>
                                                                <!--act2กิยามุลลัยล์-->
                                                                        <?php
                                                                        require_once '../../db/dbconfig.php';
                                                                        $sql = "SELECT activity.*, actsem.*,acttype.* 
                                                                            FROM activity 
                                                                            JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                            JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                            WHERE 
                                                                            acttype.acttypeName = 'กิยามุลลัยล์' 
                                                                            && (activity.actYear = '$year' && actsem.actsem = '1') 
                                                                            && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                            && (activity.actMainorg = '$fct' || activity.actSec = 'มหาวิทยาลัย') 
                                                                            && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                            ";
                                                                        $result = mysqli_query($conn, $sql);
                                                                        $row = mysqli_num_rows($result);
                                                                            
                                                                        require_once '../../db/dbconfig.php';
                                                                        $sql = "SELECT activity.*, actsem.*,acttype.*,actregister.*
                                                                            FROM actregister 
                                                                            JOIN activity ON activity.actID = actregister.actregactID
                                                                            JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                            JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                            WHERE 
                                                                            acttype.acttypeName = 'กิยามุลลัยล์' && actregister.actregstdID ='$stdUser' 
                                                                            && actregister.actregStatus='ยืนยันเรียบร้อย'
                                                                            && (activity.actYear = '$year' && actsem.actsem = '1') 
                                                                            && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                            && (activity.actMainorg = '$fct' || activity.actSec = 'มหาวิทยาลัย') 
                                                                            ";
                                                                        $result = mysqli_query($conn, $sql);
                                                                        $row1 = mysqli_num_rows($result);
                                                                        
                                                                        if ($row > 0){  
                                                                            if (($row <= 1) && ($row1 >= 1)) { $act=="ผ่าน"; 
                                                                            }elseif (($row > 1) && (($row - $row1)<2)){ $act=="ผ่าน"; 
                                                                            }else{ $act=="ไม่ผ่าน";}
                                                                        }else{ }
                                                                        ?>
                                                                    <!--กิยามุลลัยล์2-->
                                                                        <?php
                                                                        require_once '../../db/dbconfig.php';
                                                                        $sql = "SELECT activity.*, actsem.*,acttype.* 
                                                                            FROM activity 
                                                                            JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                            JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                            WHERE 
                                                                            acttype.acttypeName = 'กิยามุลลัยล์' 
                                                                            && (activity.actYear = '$year' && actsem.actsem = '2') 
                                                                            && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                            && (activity.actMainorg = '$fct' || activity.actSec = 'มหาวิทยาลัย') 
                                                                            && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                            ";
                                                                        $result = mysqli_query($conn, $sql);
                                                                        $row = mysqli_num_rows($result);

                                                                        require_once '../../db/dbconfig.php';
                                                                        $sql = "SELECT activity.*, actsem.*,acttype.*,actregister.*
                                                                            FROM actregister 
                                                                            JOIN activity ON activity.actID = actregister.actregactID
                                                                            JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                            JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                            WHERE 
                                                                            acttype.acttypeName = 'กิยามุลลัยล์' && actregister.actregstdID ='$stdUser' 
                                                                            && actregister.actregStatus='ยืนยันเรียบร้อย'
                                                                            && (activity.actYear = '$year' && actsem.actsem = '2') 
                                                                            && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                            ";
                                                                        $result = mysqli_query($conn, $sql);
                                                                        $row1 = mysqli_num_rows($result);

                                                                        if ($row > 0){  
                                                                            if (($row <= 1) && ($row1 >= 1)) { $act=="ผ่าน"; 
                                                                            }elseif (($row > 1) && (($row - $row1)<2)){ $act=="ผ่าน"; 
                                                                            }else{ $act=="ไม่ผ่าน";}
                                                                        }else{ }
                                                                        ?>
                                                                <!--act3อบรมคุณธรรมจริยธรรม-->
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*, actsem.*,acttype.* 
                                                                                FROM activity 
                                                                                JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'อบรมคุณธรรมจริยธรรม' 
                                                                                && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actMainorg = '$fct' || activity.actSec = 'มหาวิทยาลัย') 
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row = mysqli_num_rows($result);

                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*,acttype.*,actregister.*
                                                                                FROM actregister 
                                                                                JOIN activity ON activity.actID = actregister.actregactID
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'อบรมคุณธรรมจริยธรรม' && actregister.actregstdID ='$stdUser' 
                                                                                && actregister.actregStatus='ยืนยันเรียบร้อย'
                                                                                && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row1 = mysqli_num_rows($result);

                                                                            if ($row > 0){  
                                                                                if (($row <= 1) && ($row1 >= 1)) { $act=="ผ่าน"; 
                                                                                }elseif (($row > 1) && (($row - $row1)<2)){ $act=="ผ่าน"; 
                                                                                }else{ $act=="ไม่ผ่าน";}
                                                                            }else{ }
                                                                            ?>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*, actsem.*,acttype.* 
                                                                                FROM activity 
                                                                                JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'ค่ายพัฒนานักศึกษา(ปี1)' && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actMainorg = '$fct' || activity.actSec = 'มหาวิทยาลัย') 
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row = mysqli_num_rows($result);

                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*,acttype.*,actregister.*
                                                                                FROM actregister 
                                                                                JOIN activity ON activity.actID = actregister.actregactID
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'ค่ายพัฒนานักศึกษา(ปี1)' && actregister.actregstdID ='$stdUser' 
                                                                                && actregister.actregStatus='ยืนยันเรียบร้อย'
                                                                                && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row1 = mysqli_num_rows($result);

                                                                            if ($row > 0){  
                                                                                if (($row <= 1) && ($row1 >= 1)) { $act=="ผ่าน"; 
                                                                                }elseif (($row > 1) && (($row - $row1)<2)){ $act=="ผ่าน"; 
                                                                                }else{ $act=="ไม่ผ่าน";}
                                                                            }else{ }
                                                                            ?>
                                                                <!--act4ค่ายพัฒนานักศึกษา-->
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*, actsem.*,acttype.* 
                                                                                FROM activity 
                                                                                JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'ค่ายพัฒนานักศึกษา(ปี3)' && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actMainorg = '$fct' || activity.actSec = 'มหาวิทยาลัย') 
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row = mysqli_num_rows($result);

                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*,acttype.*,actregister.*
                                                                                FROM actregister 
                                                                                JOIN activity ON activity.actID = actregister.actregactID
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'ค่ายพัฒนานักศึกษา(ปี3)' && actregister.actregstdID ='$stdUser' 
                                                                                && actregister.actregStatus='ยืนยันเรียบร้อย'
                                                                                && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row1 = mysqli_num_rows($result);

                                                                            if ($row > 0){  
                                                                                if (($row <= 1) && ($row1 >= 1)) { $act=="ผ่าน"; 
                                                                                }elseif (($row > 1) && (($row - $row1)<2)){ $act=="ผ่าน"; 
                                                                                }else{ $act=="ไม่ผ่าน";}
                                                                            }else{ }
                                                                            ?>
                                                                            
                                                                <!--act5อิอฺติก๊าฟ-->
                                                                    <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT * 
                                                                                FROM eiatiqaf
                                                                                WHERE 
                                                                                eiatiqafstdID = '$stdUser' && eiatiqafYear = '$year' 
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $rowfile = mysqli_num_rows($result);

                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*,acttype.* 
                                                                                FROM activity 
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'อิอฺติก๊าฟ 10 วันสุดท้ายเดือนรอมฎอน' 
                                                                                && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actMainorg = '$fct' || activity.actSec = 'มหาวิทยาลัย') 
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row = mysqli_num_rows($result);

                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*,acttype.*,actregister.*
                                                                                FROM actregister 
                                                                                JOIN activity ON activity.actID = actregister.actregactID
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'อิอฺติก๊าฟ 10 วันสุดท้ายเดือนรอมฎอน' && actregister.actregstdID ='$stdUser' 
                                                                                && actregister.actregStatus='ยืนยันเรียบร้อย'
                                                                                && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row1 = mysqli_num_rows($result);
                                                                            
                                                                            if ($row > 0) {  
                                                                                if (($row <= 1) && ($row1 >= 1)) { $act=="ผ่าน"; 
                                                                                }elseif (($row > 1) && (($row - $row1)<2)){ $act=="ผ่าน"; 
                                                                                }elseif($rowfile>1){$act ="ผ่าน";   
                                                                                }else{$act=="ไม่ผ่าน";}
                                                                            }else{ }
                                                                            ?>
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*, actsem.*,acttype.* 
                                                                                FROM activity 
                                                                                JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'ปฐมนิเทศ' && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && activity.actSec = 'มหาวิทยาลัย' 
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row = mysqli_num_rows($result);

                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*,acttype.*,actregister.*
                                                                                FROM actregister 
                                                                                JOIN activity ON activity.actID = actregister.actregactID
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'ปฐมนิเทศ' && actregister.actregstdID ='$stdUser' 
                                                                                && actregister.actregStatus='ยืนยันเรียบร้อย'
                                                                                && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row1 = mysqli_num_rows($result);
                                                                            if ($row > 0){  
                                                                                if (($row <= 1) && ($row1 >= 1)) { $act=="ผ่าน"; 
                                                                                }elseif (($row > 1) && (($row - $row1)<2)){ $act=="ผ่าน"; 
                                                                                }else{ $act=="ไม่ผ่าน";}
                                                                            }else{ }
                                                                            ?>
                                                                <!--act7ชมรม-->
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*, actsem.*,acttype.*
                                                                                FROM activity 
                                                                                JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'กิจกรรมชมรม' && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && activity.actSec = 'มหาวิทยาลัย' && activity.actOrgtion = '$club'
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row = mysqli_num_rows($result);

                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*,acttype.*,actregister.*
                                                                                FROM actregister 
                                                                                JOIN activity ON activity.actID = actregister.actregactID
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'กิจกรรมชมรม' && actregister.actregstdID ='$stdUser' 
                                                                                && actregister.actregStatus='ยืนยันเรียบร้อย'
                                                                                && activity.actYear = '$year' 
                                                                                && activity.actSec = 'มหาวิทยาลัย' && activity.actOrgtion = '$club'
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row1 = mysqli_num_rows($result);
                                                                            
                                                                            if ($row > 0){  
                                                                                if (($row <= 1) && ($row1 >= 1)) { $act=="ผ่าน"; 
                                                                                }elseif (($row > 1) && (($row - $row1)<2)){ $act=="ผ่าน"; 
                                                                                }else{ $act=="ไม่ผ่าน";}
                                                                            }else{ }
                                                                            ?>
                                                                <!--act8ชุมนุม-->
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*, actsem.*,acttype.*, organization.*
                                                                                FROM activity 
                                                                                JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                JOIN organization ON activity.actOrgtion = organization.orgtionNo
                                                                                WHERE 
                                                                                acttype.acttypeName = 'กิจกรรมชุมนุม' && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actMainorg = '$fct' && organization.organization = '$dpmName')
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row = mysqli_num_rows($result);

                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*,acttype.*,actregister.*, organization.*
                                                                                FROM actregister 
                                                                                JOIN activity ON activity.actID = actregister.actregactID
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                JOIN organization ON activity.actOrgtion = organization.orgtionNo
                                                                                WHERE 
                                                                                acttype.acttypeName = 'กิจกรรมชุมนุม' && actregister.actregstdID ='$stdUser' 
                                                                                && actregister.actregStatus='ยืนยันเรียบร้อย'
                                                                                && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actMainorg = '$fct' && organization.organization = '$dpmName')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row1 = mysqli_num_rows($result);
                                                                            
                                                                            if ($row > 0){  
                                                                                if (($row <= 1) && ($row1 >= 1)) { $act=="ผ่าน"; 
                                                                                }elseif (($row > 1) && (($row - $row1)<2)){ $act=="ผ่าน"; 
                                                                                }else{ $act=="ไม่ผ่าน";}
                                                                            }else{ }
                                                                            ?>
                                                                <!--act9กิจกรรมอบศ-->
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*, actsem.*,acttype.*,mainorg.*,organization.* 
                                                                                FROM activity 
                                                                                JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                JOIN mainorg ON mainorg.mainorgNo = activity.actMainorg
                                                                                JOIN organization ON organization.orgtionNo = activity.actOrgtion
                                                                                WHERE 
                                                                                acttype.acttypeName = 'กิจกรรมองค์การบริหารนักศึกษา' 
                                                                                && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (mainorg.mainorg = 'องค์การบริหารนักศึกษา' || organization.organization = 'องค์การบริหารนักศึกษา') 
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row = mysqli_num_rows($result);

                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*,acttype.*,actregister.*,mainorg.*,organization.* 
                                                                                FROM actregister 
                                                                                JOIN activity ON activity.actID = actregister.actregactID
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                JOIN mainorg ON mainorg.mainorgNo = activity.actMainorg
                                                                                JOIN organization ON organization.orgtionNo = activity.actOrgtion
                                                                                WHERE 
                                                                                acttype.acttypeName = 'กิจกรรมองค์การบริหารนักศึกษา' && actregister.actregstdID ='$stdUser' 
                                                                                && actregister.actregStatus='ยืนยันเรียบร้อย'
                                                                                && activity.actYear = '$year' 
                                                                                && (mainorg.mainorg = 'องค์การบริหารนักศึกษา' || organization.organization = 'องค์การบริหารนักศึกษา') 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row1 = mysqli_num_rows($result);
                                                                            if ($row > 0){  
                                                                                if (($row <= 1) && ($row1 >= 1)) { $act=="ผ่าน"; 
                                                                                }elseif (($row > 1) && ((($row - $row1)<2) || ($row1 = 5))){ $act=="ผ่าน"; 
                                                                                }else{ $act=="ไม่ผ่าน";}
                                                                            }else{ }
                                                                            ?>
                                                                <!--act10กิจกรรมสโมสร-->
                                                                    <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*, actsem.*,acttype.*, organization.* 
                                                                                FROM activity 
                                                                                JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                JOIN organization ON activity.actOrgtion = organization.orgtionNo
                                                                                WHERE 
                                                                                acttype.acttypeName = 'กิจกรรมสโมรสรคณะ' 
                                                                                && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actMainorg = '$fct' || organization.organization = 'สโมสรคณะ') 
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row = mysqli_num_rows($result);

                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*,acttype.*,actregister.*, organization.*
                                                                                FROM actregister 
                                                                                JOIN activity ON activity.actID = actregister.actregactID
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                JOIN organization ON activity.actOrgtion = organization.orgtionNo
                                                                                WHERE 
                                                                                acttype.acttypeName = 'กิจกรรมสโมสรคณะ' && actregister.actregstdID ='$stdUser' 
                                                                                && actregister.actregStatus='ยืนยันเรียบร้อย'
                                                                                && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actMainorg = '$fct' || organization.organization = 'สโมสรคณะ') 
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row1 = mysqli_num_rows($result);
                                                                            if ($row > 0){  
                                                                                if (($row <= 1) && ($row1 >= 1)) { $act=="ผ่าน"; 
                                                                                }elseif (($row > 1) && ((($row - $row1)<2) || ($row1 = 5))){ $act=="ผ่าน"; 
                                                                                }else{ $act=="ไม่ผ่าน";}
                                                                            }else{ }
                                                            }
                                                                ?>
                                <!--ปี3-->  
                                <!--ปี4--> 
                                                        <?php
                                                        require_once '../../db/dbconfig.php';
                                                        $stmt = $DBcon->prepare("SELECT student.*, club.*, organization.*,department.* FROM student 
                                                            JOIN club ON club.clubstdID = student.stdID
                                                            JOIN organization ON club.clubOrgtion = organization.orgtionNo
                                                            JOIN department ON student.stdDpm = department.dpmNo
                                                            WHERE student.stdID = '$stdUser' && club.clubYear = student.stdYear+3");
                                                        $stmt->execute();
                                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                            $fct = $row["stdFct"];
                                                            $dpm = $row["stdDpm"];
                                                            $dpmName = $row["department"];
                                                            $year = $row["stdYear"] + 3;
                                                            $group = $row["stdGroup"];
                                                            $club = $row["clubOrgtion"];
                                                            $clubname = $row["organization"];

                                                        ?>
                                                                <!--act1ฮาลาเกาะห์-->
                                                                    <?php
                                                                        require_once '../../db/dbconfig.php';
                                                                        $stmt = $DBcon->prepare("SELECT halaqahstd.*, halaqahtc.* FROM halaqahstd
                                                                                                JOIN halaqahtc ON halaqahtc.halaqahtcNo = halaqahstd.halaqahID
                                                                                                WHERE halaqahstd.halaqahstdID = '$stdUser' && halaqahtc.halaqahtcYear = '$year'
                                                                                                ");
                                                                        $stmt->execute();
                                                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                                            if ($row['halaqahstdsem1Status'] == 'ผ่าน') 
                                                                            { $act=="ผ่าน";}
                                                                            else{$act=="ไม่ผ่าน";}
                                                                        }
                                                                        ?>

                                                                        <?php
                                                                        require_once '../../db/dbconfig.php';
                                                                        $stmt = $DBcon->prepare("SELECT halaqahstd.*, halaqahtc.* FROM halaqahstd
                                                                                                JOIN halaqahtc ON halaqahtc.halaqahtcNo = halaqahstd.halaqahID
                                                                                                WHERE halaqahstd.halaqahstdID = '$stdUser' && halaqahtc.halaqahtcYear = '$year'
                                                                                                ");
                                                                        $stmt->execute();
                                                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                                            if ($row['halaqahstdsem2Status'] == 'ผ่าน') 
                                                                            { $act=="ผ่าน";}
                                                                            else{$act=="ไม่ผ่าน";}
                                                                        }
                                                                        ?>
                                                                <!--act2กิยามุลลัยล์-->
                                                                        <?php
                                                                        require_once '../../db/dbconfig.php';
                                                                        $sql = "SELECT activity.*, actsem.*,acttype.* 
                                                                            FROM activity 
                                                                            JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                            JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                            WHERE 
                                                                            acttype.acttypeName = 'กิยามุลลัยล์' 
                                                                            && (activity.actYear = '$year' && actsem.actsem = '1') 
                                                                            && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                            && (activity.actMainorg = '$fct' || activity.actSec = 'มหาวิทยาลัย') 
                                                                            && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                            ";
                                                                        $result = mysqli_query($conn, $sql);
                                                                        $row = mysqli_num_rows($result);
                                                                            
                                                                        require_once '../../db/dbconfig.php';
                                                                        $sql = "SELECT activity.*, actsem.*,acttype.*,actregister.*
                                                                            FROM actregister 
                                                                            JOIN activity ON activity.actID = actregister.actregactID
                                                                            JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                            JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                            WHERE 
                                                                            acttype.acttypeName = 'กิยามุลลัยล์' && actregister.actregstdID ='$stdUser' 
                                                                            && actregister.actregStatus='ยืนยันเรียบร้อย'
                                                                            && (activity.actYear = '$year' && actsem.actsem = '1') 
                                                                            && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                            && (activity.actMainorg = '$fct' || activity.actSec = 'มหาวิทยาลัย') 
                                                                            ";
                                                                        $result = mysqli_query($conn, $sql);
                                                                        $row1 = mysqli_num_rows($result);
                                                                        
                                                                        if ($row > 0){  
                                                                            if (($row <= 1) && ($row1 >= 1)) { $act=="ผ่าน"; 
                                                                            }elseif (($row > 1) && (($row - $row1)<2)){ $act=="ผ่าน"; 
                                                                            }else{ $act=="ไม่ผ่าน";}
                                                                        }else{ }
                                                                        ?>
                                                                    <!--กิยามุลลัยล์2-->
                                                                        <?php
                                                                        require_once '../../db/dbconfig.php';
                                                                        $sql = "SELECT activity.*, actsem.*,acttype.* 
                                                                            FROM activity 
                                                                            JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                            JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                            WHERE 
                                                                            acttype.acttypeName = 'กิยามุลลัยล์' 
                                                                            && (activity.actYear = '$year' && actsem.actsem = '2') 
                                                                            && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                            && (activity.actMainorg = '$fct' || activity.actSec = 'มหาวิทยาลัย') 
                                                                            && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                            ";
                                                                        $result = mysqli_query($conn, $sql);
                                                                        $row = mysqli_num_rows($result);

                                                                        require_once '../../db/dbconfig.php';
                                                                        $sql = "SELECT activity.*, actsem.*,acttype.*,actregister.*
                                                                            FROM actregister 
                                                                            JOIN activity ON activity.actID = actregister.actregactID
                                                                            JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                            JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                            WHERE 
                                                                            acttype.acttypeName = 'กิยามุลลัยล์' && actregister.actregstdID ='$stdUser' 
                                                                            && actregister.actregStatus='ยืนยันเรียบร้อย'
                                                                            && (activity.actYear = '$year' && actsem.actsem = '2') 
                                                                            && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                            ";
                                                                        $result = mysqli_query($conn, $sql);
                                                                        $row1 = mysqli_num_rows($result);

                                                                        if ($row > 0){  
                                                                            if (($row <= 1) && ($row1 >= 1)) { $act=="ผ่าน"; 
                                                                            }elseif (($row > 1) && (($row - $row1)<2)){ $act=="ผ่าน"; 
                                                                            }else{ $act=="ไม่ผ่าน";}
                                                                        }else{ }
                                                                        ?>
                                                                <!--act3อบรมคุณธรรมจริยธรรม-->
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*, actsem.*,acttype.* 
                                                                                FROM activity 
                                                                                JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'อบรมคุณธรรมจริยธรรม' 
                                                                                && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actMainorg = '$fct' || activity.actSec = 'มหาวิทยาลัย') 
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row = mysqli_num_rows($result);

                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*,acttype.*,actregister.*
                                                                                FROM actregister 
                                                                                JOIN activity ON activity.actID = actregister.actregactID
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'อบรมคุณธรรมจริยธรรม' && actregister.actregstdID ='$stdUser' 
                                                                                && actregister.actregStatus='ยืนยันเรียบร้อย'
                                                                                && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row1 = mysqli_num_rows($result);

                                                                            if ($row > 0){  
                                                                                if (($row <= 1) && ($row1 >= 1)) { $act=="ผ่าน"; 
                                                                                }elseif (($row > 1) && (($row - $row1)<2)){ $act=="ผ่าน"; 
                                                                                }else{ $act=="ไม่ผ่าน";}
                                                                            }else{ }
                                                                            ?>
                                                                <!--act4ค่ายพัฒนานักศึกษา-->
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*, actsem.*,acttype.* 
                                                                                FROM activity 
                                                                                JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'ค่ายพัฒนานักศึกษา(ปี1)' && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actMainorg = '$fct' || activity.actSec = 'มหาวิทยาลัย') 
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row = mysqli_num_rows($result);

                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*,acttype.*,actregister.*
                                                                                FROM actregister 
                                                                                JOIN activity ON activity.actID = actregister.actregactID
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'ค่ายพัฒนานักศึกษา(ปี1)' && actregister.actregstdID ='$stdUser' 
                                                                                && actregister.actregStatus='ยืนยันเรียบร้อย'
                                                                                && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row1 = mysqli_num_rows($result);

                                                                            if ($row > 0){  
                                                                                if (($row <= 1) && ($row1 >= 1)) { $act=="ผ่าน"; 
                                                                                }elseif (($row > 1) && (($row - $row1)<2)){ $act=="ผ่าน"; 
                                                                                }else{ $act=="ไม่ผ่าน";}
                                                                            }else{ }
                                                                            ?>
                                                                <!--act5อิอฺติก๊าฟ-->
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT * 
                                                                                FROM eiatiqaf
                                                                                WHERE 
                                                                                eiatiqafstdID = '$stdUser' && eiatiqafYear = '$year' 
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $rowfile = mysqli_num_rows($result);

                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*,acttype.* 
                                                                                FROM activity 
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'อิอฺติก๊าฟ 10 วันสุดท้ายเดือนรอมฎอน' 
                                                                                && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actMainorg = '$fct' || activity.actSec = 'มหาวิทยาลัย') 
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row = mysqli_num_rows($result);

                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*,acttype.*,actregister.*
                                                                                FROM actregister 
                                                                                JOIN activity ON activity.actID = actregister.actregactID
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'อิอฺติก๊าฟ 10 วันสุดท้ายเดือนรอมฎอน' && actregister.actregstdID ='$stdUser' 
                                                                                && actregister.actregStatus='ยืนยันเรียบร้อย'
                                                                                && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row1 = mysqli_num_rows($result);
                                                                            
                                                                            if ($row > 0) {  
                                                                                if (($row <= 1) && ($row1 >= 1)) { $act=="ผ่าน"; 
                                                                                }elseif (($row > 1) && (($row - $row1)<2)){ $act=="ผ่าน"; 
                                                                                }elseif($rowfile>1){$act ="ผ่าน";   
                                                                                }else{$act=="ไม่ผ่าน";}
                                                                            }else{ }
                                                                            ?>
                                                                <!--act6ปัจฉิมนิเทศ-->
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*, actsem.*,acttype.* 
                                                                                FROM activity 
                                                                                JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'ปัจฉิมนิเทศ' && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && activity.actSec = 'มหาวิทยาลัย' 
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row = mysqli_num_rows($result);

                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*,acttype.*,actregister.*
                                                                                FROM actregister 
                                                                                JOIN activity ON activity.actID = actregister.actregactID
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'ปัจฉิมนิเทศ' && actregister.actregstdID ='$stdUser' 
                                                                                && actregister.actregStatus='ยืนยันเรียบร้อย'
                                                                                && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row1 = mysqli_num_rows($result);
                                                                            if ($row > 0){  
                                                                                if (($row <= 1) && ($row1 >= 1)) { $act=="ผ่าน"; 
                                                                                }elseif (($row > 1) && (($row - $row1)<2)){ $act=="ผ่าน"; 
                                                                                }else{ $act=="ไม่ผ่าน";}
                                                                            }else{ }
                                                                            ?>          
                                                                <!--act7ชมรม-->
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*, actsem.*,acttype.*
                                                                                FROM activity 
                                                                                JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'กิจกรรมชมรม' && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && activity.actSec = 'มหาวิทยาลัย' && activity.actOrgtion = '$club'
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row = mysqli_num_rows($result);

                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*,acttype.*,actregister.*
                                                                                FROM actregister 
                                                                                JOIN activity ON activity.actID = actregister.actregactID
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                WHERE 
                                                                                acttype.acttypeName = 'กิจกรรมชมรม' && actregister.actregstdID ='$stdUser' 
                                                                                && actregister.actregStatus='ยืนยันเรียบร้อย'
                                                                                && activity.actYear = '$year' 
                                                                                && activity.actSec = 'มหาวิทยาลัย' && activity.actOrgtion = '$club'
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row1 = mysqli_num_rows($result);
                                                                            
                                                                            if ($row > 0){  
                                                                                if (($row <= 1) && ($row1 >= 1)) { $act=="ผ่าน"; 
                                                                                }elseif (($row > 1) && (($row - $row1)<2)){ $act=="ผ่าน"; 
                                                                                }else{ $act=="ไม่ผ่าน";}
                                                                            }else{ }
                                                                            ?>
                                                                <!--act8ชุมนุม-->
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*, actsem.*,acttype.*, organization.*
                                                                                FROM activity 
                                                                                JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                JOIN organization ON activity.actOrgtion = organization.orgtionNo
                                                                                WHERE 
                                                                                acttype.acttypeName = 'กิจกรรมชุมนุม' && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actMainorg = '$fct' && organization.organization = '$dpmName')
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row = mysqli_num_rows($result);

                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*,acttype.*,actregister.*, organization.*
                                                                                FROM actregister 
                                                                                JOIN activity ON activity.actID = actregister.actregactID
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                JOIN organization ON activity.actOrgtion = organization.orgtionNo
                                                                                WHERE 
                                                                                acttype.acttypeName = 'กิจกรรมชุมนุม' && actregister.actregstdID ='$stdUser' 
                                                                                && actregister.actregStatus='ยืนยันเรียบร้อย'
                                                                                && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actMainorg = '$fct' && organization.organization = '$dpmName')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row1 = mysqli_num_rows($result);
                                                                            
                                                                            if ($row > 0){  
                                                                                if (($row <= 1) && ($row1 >= 1)) { $act=="ผ่าน"; 
                                                                                }elseif (($row > 1) && (($row - $row1)<2)){ $act=="ผ่าน"; 
                                                                                }else{ $act=="ไม่ผ่าน";}
                                                                            }else{ }
                                                                            ?>
                                                                <!--act9กิจกรรมอบศ-->
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*, actsem.*,acttype.*,mainorg.*,organization.* 
                                                                                FROM activity 
                                                                                JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                JOIN mainorg ON mainorg.mainorgNo = activity.actMainorg
                                                                                JOIN organization ON organization.orgtionNo = activity.actOrgtion
                                                                                WHERE 
                                                                                acttype.acttypeName = 'กิจกรรมองค์การบริหารนักศึกษา' 
                                                                                && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (mainorg.mainorg = 'องค์การบริหารนักศึกษา' || organization.organization = 'องค์การบริหารนักศึกษา') 
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row = mysqli_num_rows($result);

                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*,acttype.*,actregister.*,mainorg.*,organization.* 
                                                                                FROM actregister 
                                                                                JOIN activity ON activity.actID = actregister.actregactID
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                JOIN mainorg ON mainorg.mainorgNo = activity.actMainorg
                                                                                JOIN organization ON organization.orgtionNo = activity.actOrgtion
                                                                                WHERE 
                                                                                acttype.acttypeName = 'กิจกรรมองค์การบริหารนักศึกษา' && actregister.actregstdID ='$stdUser' 
                                                                                && actregister.actregStatus='ยืนยันเรียบร้อย'
                                                                                && activity.actYear = '$year' 
                                                                                && (mainorg.mainorg = 'องค์การบริหารนักศึกษา' || organization.organization = 'องค์การบริหารนักศึกษา') 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row1 = mysqli_num_rows($result);
                                                                            if ($row > 0){  
                                                                                if (($row <= 1) && ($row1 >= 1)) { $act=="ผ่าน"; 
                                                                                }elseif (($row > 1) && ((($row - $row1)<2) || ($row1 = 5))){ $act=="ผ่าน"; 
                                                                                }else{ $act=="ไม่ผ่าน";}
                                                                            }else{ }
                                                                            ?>
                                                                <!--act10กิจกรรมสโมสร-->
                                                                            <?php
                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*, actsem.*,acttype.*, organization.* 
                                                                                FROM activity 
                                                                                JOIN actsem ON actsem.actsemNo = activity.actSem
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                JOIN organization ON activity.actOrgtion = organization.orgtionNo
                                                                                WHERE 
                                                                                acttype.acttypeName = 'กิจกรรมสโมรสรคณะ' 
                                                                                && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actMainorg = '$fct' || organization.organization = 'สโมสรคณะ') 
                                                                                && (activity.actStatus!='รอการอนุมัติ' || activity.actStatus!='ไม่อนุมัติ')
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row = mysqli_num_rows($result);

                                                                            require_once '../../db/dbconfig.php';
                                                                            $sql = "SELECT activity.*,acttype.*,actregister.*, organization.*
                                                                                FROM actregister 
                                                                                JOIN activity ON activity.actID = actregister.actregactID
                                                                                JOIN acttype ON acttype.acttypeNo = activity.actType
                                                                                JOIN organization ON activity.actOrgtion = organization.orgtionNo
                                                                                WHERE 
                                                                                acttype.acttypeName = 'กิจกรรมสโมสรคณะ' && actregister.actregstdID ='$stdUser' 
                                                                                && actregister.actregStatus='ยืนยันเรียบร้อย'
                                                                                && activity.actYear = '$year' 
                                                                                && (activity.actGroup = '$group' || activity.actGroup = 'รวม')
                                                                                && (activity.actMainorg = '$fct' || organization.organization = 'สโมสรคณะ') 
                                                                                ";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            $row1 = mysqli_num_rows($result);
                                                                            if ($row > 0){  
                                                                                if (($row <= 1) && ($row1 >= 1)) { $act=="ผ่าน"; 
                                                                                }elseif (($row > 1) && ((($row - $row1)<2) || ($row1 = 5))){ $act=="ผ่าน"; 
                                                                                }else{ $act=="ไม่ผ่าน";}
                                                                            }else{ }
                                                            }
                                                                ?>
                                <!--ปี4-->  
                                

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
    <script src="../../assets/vendors/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>

    <!-- CORE SCRIPTS-->
    <script src="../../assets/js/app.min.js" type="text/javascript"></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- PAGE LEVEL SCRIPTS-->
    <script src="../../assets/js/scripts/form-plugins.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(function() {
            $('#tbact').DataTable({
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
        })
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
    <script>

$(function(){

    $("#submit-form").click(function(){

        alert($( "form" ).serialize());

        return false;
    });

});

//กำหนดค่าเริ่มต้น progress bar 
progress = 0;

//ตัวแปร checked สำหรับ เก็บ ข้อที่ได้ตอบไปแล้ว
checked = [];

//จำนวนข้อทั้งหมด
number = 5;

//ฟังชั่นตรวจสอบการเลือกคำถามในแบบฟอร์ม
function checkForm(qname){
//ตรวจสอบว่ามีการเลือกไปแล้วหรือยัง
    if(!isChecked(qname)){

        progress ++;

        checked.push(qname);
    }
    
    //แสดง progress bar เป็น แบบ เปอร์เซ้น
    show_progress = (progress * 100) / number;
    
    $(".progress-bar").attr('style','width:'+show_progress+'%').text(parseInt(show_progress)+' %');
}

//ฟังชั่น ตรวจสอบ ว่า มีการ เลือกคำตอบไปแล้วหรือยัง
function isChecked(qname){

    for(i = 0; i<=checked.length;i++){

        if(checked[i] == qname){
                                           //คืนค่าจริง หาก มีการเลือกข้อนี้ไปแล้ว
            return true;
        }
    }
                            //คืนค่าเท็จ กรณียังไม่มีการเลือก
    return false;
}

</script>
<script>

$(function(){

    $("#submit-form").click(function(){

        alert($( "form" ).serialize());

        return false;
    });

});

//กำหนดค่าเริ่มต้น progress bar 
progress = 0;

//ตัวแปร checked สำหรับ เก็บ ข้อที่ได้ตอบไปแล้ว
checked = [];

//จำนวนข้อทั้งหมด
number = 5;

//ฟังชั่นตรวจสอบการเลือกคำถามในแบบฟอร์ม
function checkForm(qname){
//ตรวจสอบว่ามีการเลือกไปแล้วหรือยัง
    if(!isChecked(qname)){

        progress ++;

        checked.push(qname);
    }
    
    //แสดง progress bar เป็น แบบ เปอร์เซ้น
    show_progress = (progress * 100) / number;
    
    $(".progress-bar").attr('style','width:'+show_progress+'%').text(parseInt(show_progress)+' %');
}

//ฟังชั่น ตรวจสอบ ว่า มีการ เลือกคำตอบไปแล้วหรือยัง
function isChecked(qname){

    for(i = 0; i<=checked.length;i++){

        if(checked[i] == qname){
                                           //คืนค่าจริง หาก มีการเลือกข้อนี้ไปแล้ว
            return true;
        }
    }
                            //คืนค่าเท็จ กรณียังไม่มีการเลือก
    return false;
}

</script>

</body>

</html>