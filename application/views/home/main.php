    <!-- Page Stylesheet -->
    <link rel="stylesheet" href="/assets/css/main.css" media="screen">

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
                            <a href="/home">
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
                            <!--
                            <li><a href="dashboard.html">Dashboard</a></li>
                            <li class="divider"></li>
                            -->
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
                        <li class="active"><a href="/home"><i class="icon-home"></i> Home</a></li>
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
                            <a href="/home">
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
                    <div class="row-fixed">
                        <div class="span3 min-width-menu">
                            <div class="da-panel">
                                <div class="da-panel-content">
                                    <table class="main-center">
                                        <tbody>
                                        <tr>
                                            <td>
                                                <img class="main-center" src="assets/images/po-logo.png" alt="Buat PO">
                                            </td>
                                            <td>
                                                <a href="/hello">
                                                    <h3 class="main-center">Buat<br/>PO</h3>
                                                </a>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="span3 min-width-menu">
                            <div class="da-panel">
                                <div class="da-panel-content">
                                    <table class="main-center">
                                        <tbody>
                                        <tr>
                                            <td>
                                                <img class="main-center" src="assets/images/delivery-logo.png" alt="Terima Barang">
                                            </td>
                                            <td>
                                                <a href="/hello">
                                                    <h3 class="main-center">Terima<br/>Barang</h3>
                                                </a>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="span3 min-width-menu">
                            <div class="da-panel">
                                <div class="da-panel-content">
                                    <table class="main-center">
                                        <tbody>
                                        <tr>
                                            <td>
                                                <img class="main-center" src="assets/images/usage-logo.png" alt="Pakai Barang">
                                            </td>
                                            <td>
                                                <a href="/hello">
                                                    <h3 class="main-center">Pakai<br/>Barang</h3>
                                                </a>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="span3 min-width-menu">
                            <div class="da-panel">
                                <div class="da-panel-content">
                                    <table class="main-center">
                                        <tbody>
                                        <tr>
                                            <td>
                                                <img class="main-center" src="assets/images/project-logo.png" alt="Project">
                                            </td>
                                            <td>
                                                <a href="/hello">
                                                    <h3 class="main-center">Project<br/>Details</h3>
                                                </a>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>