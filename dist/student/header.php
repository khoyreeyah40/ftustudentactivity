        <header class="header">
        <div class="page-brand" style="background-color:#528124;color:#FFFFFF;">
                <a class="link" href="../Mhome/homepage.php">
                    <span class="brand">ระบบกิจกรรมนักศึกษา
                    </span>
                    <span class="brand-mini"><img src="../../assets/img/ftu_logo.png" /></span>
                </a>
            </div>
            <div class="flexbox flex-1">
                <!-- START TOP-LEFT TOOLBAR-->
                <ul class="nav navbar-toolbar">
                    <li>
                        <a class="nav-link sidebar-toggler js-sidebar-toggler"><i class="ti-menu"></i></a>
                    </li>
                    <li>
                    </li>
                </ul>
                <!-- END TOP-LEFT TOOLBAR-->
                <!-- START TOP-RIGHT TOOLBAR-->
                <ul class="nav navbar-toolbar">
                <li class="dropdown dropdown-user">
                <div class="language">
                    <div class="google">
                    <div id="google_translate_element">
                        <div class="skiptranslate goog-te-gadget" dir="ltr" >
                        <div id=":0.targetLanguage" class="goog-te-gadget-simple" style="white-space: nowrap;"><img src="https://www.google.com/images/cleardot.gif" class="goog-te-gadget-icon" alt="" style="background-image: url(&quot;https://translate.googleapis.com/translate_static/img/te_ctrl3.gif&quot;); background-position: -65px 0px;"><span style="vertical-align: middle;"><a aria-haspopup="true" class="goog-te-menu-value" href="javascript:void(0)"><span>เลือกภาษา</span><img src="https://www.google.com/images/cleardot.gif" alt="" width="1" height="1"><span style="border-left: 1px solid rgb(187, 187, 187);">​</span><img src="https://www.google.com/images/cleardot.gif" alt="" width="1" height="1"><span aria-hidden="true" style="color: rgb(118, 118, 118);">▼</span></a></span></div>
                        </div>
                    </div>
                    <script type="text/javascript">
                        function googleTranslateElementInit() {
                        new google.translate.TranslateElement({
                            pageLanguage: 'th',
                            includedLanguages: 'zh-CN,de,id,km,lo,ms,my,th,tl,vi,th,en',
                            layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
                            multilanguagePage: true
                        }, 'google_translate_element');
                        }
                    </script>
                    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
                    </div>
                </div>
                </li>
                    <li class="dropdown dropdown-user">
                        <a class="nav-link dropdown-toggle link" data-toggle="dropdown"style="color:#528124;">
                            <img src="../../assets/img/<?php echo $stdRow['stdImage']; ?>" />
                            <span></span><?php echo $_SESSION['stdName']; ?><i class="fa fa-angle-down m-l-5"></i></a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="../Mprofile/profilepage.php"style="color:#528124;"><i class="fa fa-user"></i>Profile</a>
                            <li class="dropdown-divider"></li>
                            <a class="dropdown-item" href="../Mlogin/logout.php?logout=true"style="color:#528124;"><i class="fa fa-sign-out"></i>Logout</a>
                        </ul>
                    </li>
                </ul>
                <!-- END TOP-RIGHT TOOLBAR-->
            </div>
        </header>
        <nav class="page-sidebar" id="sidebar">
            <div id="sidebar-collapse">
                <div class="admin-block d-flex">
                    <div>
                        <img src="../../assets/img/<?php echo $stdRow['stdImage']; ?>" width=" 45px" class="img-circle" />
                    </div>
                    <div class="admin-info">
                        <div class="font-strong" style="color:#528124;"><?php echo $stdRow['stdName']; ?></b></a></div><small style="color:#528124;"><?php echo $stdRow['stdStatus']; ?></small>
                    </div>
                </div>