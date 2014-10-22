<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--><html lang="en"><!--<![endif]-->

<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Bootstrap Stylesheet -->
    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css" media="screen">

    <!-- Plugin Stylesheet -->

    <!-- Theme Stylesheet -->
    <link rel="stylesheet" href="/assets/css/dandelion.theme.css" media="screen">
    <!-- Icon Stylesheet -->
    <link rel="stylesheet" href="/assets/css/fonts/glyphicons/style.css" media="screen">
    <!--  Main Stylesheet -->
    <link rel="stylesheet" href="/assets/css/dandelion.css" media="screen">
    <!-- Demo Stylesheet -->
    <link rel="stylesheet" href="/assets/css/demo.css" media="screen">

    <title>Subianto & Siane</title>

</head>

<body>
<!-- Main Wrapper. Set this to 'fixed' for fixed layout and 'fluid' for fluid layout' -->
<div id="da-wrapper">
    <!-- Header -->
    <div id="da-header">
        <div id="da-header-top">
            <!-- Container -->
            <div class="da-container clearfix">
                <!-- Logo Container. All images put here will be vertically centere -->
                <div id="da-logo-wrap">
                    <div id="da-logo">
                        <div id="da-logo-img">
                            <a href="/dashboard">
                                <img src="assets/images/logo.png" alt="Subianto & Siane">
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Header Toolbar Menu -->
                <div id="da-header-toolbar" class="clearfix">
                    <div id="da-user-profile-wrap">
                        <div id="da-user-profile" data-toggle="dropdown" class="clearfix">
                            <!-- Profile Picture -->
                            <!--
                            <div id="da-user-avatar">
                                <img src="assets/images/pp.jpg" alt="">
                            </div>
                            -->

                            <div id="da-user-info">
                                <?php echo $username ?>
                                <span class="da-user-title"><?php echo $company_title?></span>
                            </div>
                        </div>
                        <ul class="dropdown-menu">
                            <li><a href="dashboard.html">Dashboard</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Profile</a></li>
                            <li><a href="#">Settings</a></li>
                            <li><a href="#">Change Password</a></li>
                        </ul>
                    </div>
                    <div id="da-header-button-container">
                        <ul>
                            <!-- Notification Drop Down -->
                            <!--
                            <li class="da-header-button-wrap">
                                <div class="da-header-button" data-toggle="dropdown">
                                    <span class="btn-count">32</span>
                                    <a href="#"><i class="icon-circle-exclamation-mark"></i></a>
                                </div>
                                <ul class="dropdown-menu pull-right">
                                    <li>
                                        <span class="da-dropdown-sub-title">Notifications</span>
                                        <ul class="da-dropdown-sub">
                                            <li class="unread">
                                                <a href="#">
                                                    <span class="thumbnail"><img src="assets/images/pp.jpg" alt=""></span>
                                                        <span class="info">
                                                            <span class="name">John Doe</span>
                                                            <span class="message">
                                                                Lorem ipsum dolor sit amet consectetur adipiscing elit, et al commore
                                                            </span>
                                                            <span class="time">
                                                                January 21, 2012
                                                            </span>
                                                        </span>
                                                </a>
                                            </li>
                                        </ul>
                                        <a class="da-dropdown-sub-footer" href="#">
                                            View all notifications
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            -->

                            <!-- Message Drop Down -->
                            <!--
                            <li class="da-header-button-wrap">
                                <div class="da-header-button" data-toggle="dropdown">
                                    <span class="btn-count">5</span>
                                    <a href="#"><i class="icon-envelope"></i></a>
                                </div>
                                <ul class="dropdown-menu pull-right">
                                    <li>
                                        <span class="da-dropdown-sub-title">Messages</span>
                                        <ul class="da-dropdown-sub">
                                            <li class="unread">
                                                <a href="#">
                                                    <span class="thumbnail"><img src="assets/images/pp.jpg" alt=""></span>
                                                        <span class="info">
                                                            <span class="name">John Doe</span>
                                                            <span class="message">
                                                                Lorem ipsum dolor sit amet consectetur adipiscing elit, et al commore
                                                            </span>
                                                            <span class="time">
                                                                January 21, 2012
                                                            </span>
                                                        </span>
                                                </a>
                                            </li>
                                        </ul>
                                        <a class="da-dropdown-sub-footer" href="#">
                                            View all messages
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            -->

                            <li class="da-header-button-wrap">
                                <div class="da-header-button">
                                    <a href="../index.html"><i class="icon-power"></i></a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div id="da-header-bottom">
            <!-- Container -->
            <div class="da-container clearfix">
                <div id="da-search">
                    <form>
                        <input type="text" class="search-query" placeholder="Search...">
                    </form>
                </div>
                <!-- Breadcrumbs -->
                <div id="da-breadcrumb">
                    <ul>
                        <li class="active"><a href="/dashboard"><i class="icon-home"></i> Home</a></li>
                    </ul>
                </div>

            </div>
        </div>
    </div>

    <!-- Content -->
    <div id="da-content">
        <!-- Container -->
        <div class="da-container clearfix">
            <!-- Sidebar Separator do not remove -->
            <div id="da-sidebar-separator"></div>
            <!-- Sidebar -->
            <div id="da-sidebar">
                <!-- Navigation Toggle for < 480px -->
                <div id="da-sidebar-toggle"></div>
                <!-- Main Navigation -->
                <div id="da-main-nav" class="btn-container">
                    <ul>
                        <li class="active">
                            <a href="/dashboard">
                                <!-- Icon Container -->
                                    <span class="da-nav-icon">
                                        <i class="icon-home"></i>
                                    </span>
                                Home
                            </a>
                        </li>

                        <!--
                        <li>
                            <a href="statistics.html">
                                // Nav Notification
                                <span class="da-nav-count">32</span>
                                // Icon Container
                                    <span class="da-nav-icon">
                                        <i class="icon-stats"></i>
                                    </span>
                                Statistics
                            </a>
                        </li>
                        -->
                    </ul>
                </div>

            </div>

            <!-- Main Content Wrapper -->
            <div id="da-content-wrap" class="clearfix">
                <!-- Content Area -->
                <div id="da-content-area">
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div id="da-footer">
        <div class="da-container clearfix">
            <p>Copyright 2014. Hans Hartono. All Rights Reserved.
        </div>
    </div>

    <!-- JS Libs -->
    <script src="/assets/js/libs/jquery-1.8.3.min.js"></script>
    <script src="/assets/js/libs/jquery.placeholder.min.js"></script>
    <script src="/assets/js/libs/jquery.mousewheel.min.js"></script>

    <!-- JS Bootstrap -->
    <script src="/assets/bootstrap/js/bootstrap.min.js"></script>

    <!-- jQuery-UI JavaScript Files -->

    <!-- JS Plugins -->

    <!-- JS Demo -->

    <!-- JS Template -->
    <script src="/assets/js/core/dandelion.core.js"></script>

    <!-- JS Customizer -->
    <script src="/assets/js/core/dandelion.customizer.js"></script>
</body>
</html>