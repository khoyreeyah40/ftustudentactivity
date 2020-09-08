<?php

error_reporting(~E_NOTICE);

$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = '';
$DB_NAME = 'dbmyproject';

try {
    $DB_con = new PDO("mysql:host={$DB_HOST};dbname={$DB_NAME}", $DB_USER, $DB_PASS);
    $DB_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $e->getMessage();
}

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $stmt_view = $DB_con->prepare('SELECT student.*,department.*, teacher.*, faculty.*, mainorg.* FROM student 
                                    JOIN department ON department.dpmNo = student.stdDpm
                                    JOIN teacher ON teacher.teacherNo = student.stdTc
                                    JOIN faculty ON faculty.faculty = student.stdFct
                                    JOIN mainorg ON mainorg.mainorgNo = faculty.faculty
                                    WHERE stdID=:stdID');
    $stmt_view->execute(array(':stdID' => $id));
    $view_row = $stmt_view->fetch(PDO::FETCH_ASSOC);
    extract($view_row);
}
?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body ">
            <div class="row">
            <div class="col-lg-3 col-md-4">
                <div class="ibox">
                    <div class="ibox-body text-center">
                        <div class="m-t-20">
                            <img class="img-circle" src="../../assets/img/<?php echo $stdImage ?>" />
                        </div>
                        <h5 class="font-strong m-b-10 m-t-10"><?php echo $stdName ?></h5>
                        <div class="m-b-20 text-muted"><?php echo $stdStatus ?></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-md-8">
                <div class="ibox">
                    <div class="ibox-body">
                        <div class="row justify-content-center">
                            <h1 class="m-t-10 m-b-10 font-strong">ข้อมูลส่วนตัว</h1>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-10">
                                <ul class="list-group list-group-full list-group-divider">
                                    <li class="list-group-item">ปีที่เข้าศึกษา
                                        <a href="javascript:;"><span class="pull-right"><?php echo $stdYear ?></span></a>
                                    </li>
                                    <li class="list-group-item">รหัสนักศึกษา
                                        <a href="javascript:;"><span class="pull-right "><?php echo $stdID ?></span></a>
                                    </li>
                                    <li class="list-group-item">ชื่อ-สกุล
                                        <a href="javascript:;"><span class="pull-right "><?php echo $stdName ?></span></a>
                                    </li>
                                    <li class="list-group-item">สถานะ
                                        <a href="javascript:;"><span class="pull-right "><?php echo $stdStatus ?></span></a>
                                    </li>
                                    <li class="list-group-item">กลุ่ม
                                        <a href="javascript:;"><span class="pull-right "><?php echo $stdGroup ?></span></a>
                                    </li>
                                    <li class="list-group-item">คณะ
                                        <a href="javascript:;"><span class="pull-right "><?php echo $mainorg ?></span></a>
                                    </li>
                                    <li class="list-group-item">สาขา
                                        <a href="javascript:;"><span class="pull-right "><?php echo $department ?></span></a>
                                    </li>
                                    <li class="list-group-item">อาจารย์ที่ปรึกษา
                                        <a href="javascript:;"><span class="pull-right "><?php echo $teacher ?></span></a>
                                    </li>
                                    <li class="list-group-item">หมายเลขโทรศัพท์
                                        <a href="javascript:;"><span class="pull-right "><?php echo $stdPhone ?></span></a>
                                    </li>
                                    <li class="list-group-item">Email
                                        <a href="javascript:;"><span class="pull-right "><?php echo $stdEmail ?></span></a>
                                    </li>
                                    <li class="list-group-item">Facebook
                                        <a href="javascript:;"><span class="pull-right "><?php echo $stdFb ?></span></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <style>
                .profile-social a {
                    font-size: 16px;
                    margin: 0 10px;
                    color: #999;
                }

                .profile-social a:hover {
                    color: #485b6f;
                }

                .profile-stat-count {
                    font-size: 22px
                }
            </style>
        </div>
            </div>
        </div>
    </div>

</div>
<script type="text/javascript">
        $(function() {
            $('#tbactreg').DataTable({
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