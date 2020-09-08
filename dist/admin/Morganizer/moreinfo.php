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
    $stmt_view = $DB_con->prepare('SELECT organizer.*, usertype.*, mainorg.*, organization.* FROM organizer
                                    JOIN usertype ON organizer.orgzeruserType = usertype.usertypeID
                                    JOIN mainorg ON organizer.orgzerMainorg = mainorg.mainorgNo
                                    JOIN organization ON organizer.orgzerOrgtion = organization.orgtionNo
                                    WHERE organizer.orgzerID = :id');
    $stmt_view->execute(array('id' => $id));
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
                            <img class="img-circle" src="../../assets/img/<?php echo $orgzerImage ?>" />
                        </div>
                        <h6 class="font-strong m-b-10 m-t-10"><?php echo $orgzerName ?></h6>
                        <div class="m-b-20 text-muted"><?php echo $userType ?></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-md-8">
                <div class="ibox">
                    <div class="ibox-body">
                        <div class="row justify-content-center">
                            <div class="col-md-10">
                                <ul class="list-group list-group-full list-group-divider">
                                    <li class="list-group-item">รหัสผู้ใช้
                                        <a href="javascript:;"><span class="pull-right "><?php echo $orgzerID ?></span></a>
                                    </li>
                                    <li class="list-group-item">ชื่อ-สกุล
                                        <a href="javascript:;"><span class="pull-right "><?php echo $orgzerName ?></span></a>
                                    </li>
                                    <li class="list-group-item">สถานะ
                                        <a href="javascript:;"><span class="pull-right "><?php echo $userType ?></span></a>
                                    </li>
                                    <li class="list-group-item">กลุ่ม
                                        <a href="javascript:;"><span class="pull-right "><?php echo $orgzerGroup ?></span></a>
                                    </li>
                                    <li class="list-group-item">ระดับ
                                        <a href="javascript:;"><span class="pull-right "><?php echo $orgzerSec ?></span></a>
                                    </li>
                                    <li class="list-group-item">สังกัด
                                        <a href="javascript:;"><span class="pull-right "><?php echo $mainorg ?></span></a>
                                    </li>
                                    <li class="list-group-item">องค์กร
                                        <a href="javascript:;"><span class="pull-right "><?php echo $organization ?></span></a>
                                    </li>
                                    <li class="list-group-item">หมายเลขโทรศัพท์
                                        <a href="javascript:;"><span class="pull-right "><?php echo $orgzerPhone ?></span></a>
                                    </li>
                                    <li class="list-group-item">Email
                                        <a href="javascript:;"><span class="pull-right "><?php echo $orgzerEmail ?></span></a>
                                    </li>
                                    <li class="list-group-item">Facebook
                                        <a href="javascript:;"><span class="pull-right "><?php echo $orgzerFb ?></span></a>
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