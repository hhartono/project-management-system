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
                        <!--
                        <ul class="dropdown-menu">
                            <li><a href="#">Profile</a></li>
                            <li><a href="#">Settings</a></li>
                            <li><a href="#">Change Password</a></li>
                        </ul>
                        -->
                    </div>
                    <div id="da-header-button-container">
                        <ul>
                            <li class="da-header-button-wrap">
                                <div class="da-header-button">
                                    <a href="/auth/logout"><i class="icon-power"></i></a>
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
                <!-- Breadcrumbs -->
                <div id="da-breadcrumb">
                    <ul>
                        <li><a href="/home"><i class="icon-home"></i> Home</a></li>
                        <li><a href="#">Barang</a></li>
                        <li class="active"><span>Jenis Barang</span></li>
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
                        <li>
                            <a href="/home">
                                <!-- Icon Container -->
                                    <span class="da-nav-icon">
                                        <i class="icon-home"></i>
                                    </span>
                                Home
                            </a>
                        </li>
                        <li>
                            <a href="/purchaseorder">
                                <!-- Icon Container -->
                                    <span class="da-nav-icon">
                                        <i class="icon-edit"></i>
                                    </span>
                                Purchase Order
                            </a>
                        </li>
                        <li>
                            <a href="/useitem">
                                <!-- Icon Container -->
                                    <span class="da-nav-icon">
                                        <i class="icon-classic-hammer"></i>
                                    </span>
                                Pakai Barang
                            </a>
                        </li>
                        <li>
                            <a href="/returnitem">
                                <!-- Icon Container -->
                                    <span class="da-nav-icon">
                                        <i class="icon-classic-hammer"></i>
                                    </span>
                                Return Barang
                            </a>
                        </li>
                        <li class="active">
                            <a href="#">
                                <!-- Icon Container -->
                                	<span class="da-nav-icon">
                                        <i class="icon-table"></i>
                                    </span>
                                Barang
                            </a>
                            <ul>
                                <li><a href="/category">Kategori Barang</a></li>
                                <li><a href="/item">Jenis Barang</a></li>
                                <li><a href="/stock">Stok Barang</a></li>
                                <li><a href="/supplier">Supplier</a></li>
                                <li><a href="/unit">Satuan</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#">
                                <!-- Icon Container -->
                                	<span class="da-nav-icon">
                                        <i class="icon-table"></i>
                                    </span>
                                Project
                            </a>
                            <ul>
                                <li><a href="/project">Project</a></li>
                                <li><a href="/subproject">Subproject</a></li>
                                <li><a href="/projectdetail">Project Detail</a></li>
                                <li><a href="/customer">Customer</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#">
                                <!-- Icon Container -->
                                	<span class="da-nav-icon">
                                        <i class="icon-table"></i>
                                    </span>
                                Tukang
                            </a>
                            <ul>
                                <li><a href="/worker">Tukang</a></li>
                                <li><a href="/division">Divisi Tukang</a></li>
                            </ul>
                        </li>                        
                        <li>
                            <a href="#">
                                <!-- Icon Container -->
                                    <span class="da-nav-icon">
                                        <i class="icon-edit"></i>
                                    </span>
                                Absensi
                            </a>
                            <ul>
                                <li><a href="/absensi">Absensi</a></li>
                                <li><a href="/absensi/projectdetail_worker">Project Detail Tukang</a></li>
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