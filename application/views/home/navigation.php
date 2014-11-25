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
                                <img src="/assets/images/logo.png" alt="Subianto & Siane">
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Header Toolbar Menu -->
                <div id="da-header-toolbar" class="clearfix">
                    <div id="da-user-profile-wrap">
                        <div id="da-user-profile" data-toggle="dropdown" class="clearfix">
                            <div id="da-user-info">
                                <?php echo $username ?>
                                <span class="da-user-title"><?php echo $company_title?></span>
                            </div>
                        </div>
                        <ul class="dropdown-menu">
                            <li><a href="#">Profile</a></li>
                            <li><a href="#">Settings</a></li>
                            <li><a href="#">Change Password</a></li>
                        </ul>
                    </div>
                    <div id="da-header-button-container">
                        <ul>
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
                <!--
                <div id="da-search">
                    <form>
                        <input type="text" class="search-query" placeholder="Search...">
                    </form>
                </div>
                -->
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
                        <li>
                            <a href="#">
                                <!-- Icon Container -->
                                	<span class="da-nav-icon">
                                        <i class="icon-table"></i>
                                    </span>
                                List
                            </a>
                            <ul>
                                <li><a href="/item">Jenis Barang</a></li>
                                <li><a href="/stock">Stok Barang</a></li>
                                <li><a href="/category">Kategori Barang</a></li>
                                <li><a href="/unit">Satuan</a></li>
                                <li><a href="/supplier">Supplier</a></li>

                            </ul>
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