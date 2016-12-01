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
                            <li><?php if ($this->config->item('allow_registration', 'tank_auth')) echo anchor('/auth/register/', 'Register User'); ?></li>
                        </ul>
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
                <!-- Breadcrumbs -->
                <div id="da-breadcrumb">
                    <ul>
                        <li id="nav-home"><a href="/home"><i class="icon-home"></i> Home</a></li>
                        <li id="nav-menu"><a href="#">Barang</a></li>
                        <li id="nav-submenu" class="active"><span>Kategori Barang</span></li>
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
                    <ul id="menu">
                        <li id="home">
                            <a href="/home">
                                <!-- Icon Container -->
                                    <span class="da-nav-icon">
                                        <i class="icon-home"></i>
                                    </span>
                                Home
                            </a>
                            <input id="home" type="hidden" name="checkmenu" value="home">
                        </li>
                        <li id="planning">
                            <a href="/planning">
                                <!-- Icon Container -->
                                    <span class="da-nav-icon">
                                        <i class="icon-edit"></i>
                                    </span>
                                Perencanaan Bahan
                            </a>
                        </li>
                        <li id="purchaseorder">
                            <a href="#">
                                <!-- Icon Container -->
                                    <span class="da-nav-icon">
                                        <i class="icon-edit"></i>
                                    </span>
                                Purchase Order
                            </a>
                            <ul>
                                <li><a href="/purchaseorder">Purchase Order</a></li>
                                <li><a href="/purchaseorder/receive">Terima Barang</a></li>
                                <li><a href="/purchaseorder/label">Print Label</a></li>
                                <li><a href="/purchaseorder/pembayaran_po">Pembayaran</a></li>
                            </ul>
                        </li>
                        <li id="useitem">
                            <a href="/useitem">
                                <!-- Icon Container -->
                                    <span class="da-nav-icon">
                                        <i class="icon-classic-hammer"></i>
                                    </span>
                                Pakai Barang
                            </a>
                        </li>
                        <li id="returnitem">
                            <a href="/returnitem">
                                <!-- Icon Container -->
                                    <span class="da-nav-icon">
                                        <i class="icon-classic-hammer"></i>
                                    </span>
                                Return Barang
                            </a>
                        </li>
                        <li id="returnsupplier">
                            <a href="/returnsupplier">
                                <!-- Icon Container -->
                                    <span class="da-nav-icon">
                                        <i class="icon-classic-hammer"></i>
                                    </span>
                                Return Barang Supplier
                            </a>
                        </li>
                        <li id="barang-li">
                            <a href="#">
                                <!-- Icon Container -->
                                	<span class="da-nav-icon">
                                        <i class="icon-table"></i>
                                    </span>
                                Barang
                            </a>
                            <!-- <input id="barang" type="hidden" name="checkmenu" value="barang"> -->
                            <ul id="sm-barang">
                                <!-- <li id="sm-kategori"><a href="/category">Kategori Barang</a></li>
                                <li id="sm-kategorirev"><a href="/categoryrev">Kategori Barang Rev</a></li>
                                <li id="sm-item"><a href="/item">Jenis Barang</a></li> -->
                                <li><a href="/category">Kategori Barang</a></li>
                                <li><a href="/categoryrev">Kategori Barang Rev</a></li>
                                <li><a href="/item">Jenis Barang</a></li>
                                <li><a href="/stock">Stok Barang</a></li>
                                <li><a href="/stock/limit_stock">Kekurangan Stok Barang</a></li>
                                <li><a href="/supplier">Supplier</a></li>
                                <li><a href="/unit">Satuan</a></li>
                            </ul>
                        </li>
                        <li id="blum">
                            <a href="#">
                                <!-- Icon Container -->
                                    <span class="da-nav-icon">
                                        <i class="icon-table"></i>
                                    </span>
                                BLUM Library
                            </a>
                            <!-- <input id="blum" type="hidden" name="checkmenu" value="blum"> -->
                            <ul>
                                <li><a href="/intivo">Intivo</a></li>
                                <li><a href="/intivoacc">Intivo Accessories</a></li>
                            </ul>
                        </li>
                        <li id="gnd">
                            <a href="/gnd">
                                <!-- Icon Container -->
                                    <span class="da-nav-icon">
                                        <i class="icon-table"></i>
                                    </span>
                                Generator No. Dokumen
                            </a>
                        </li>
                        <li id="project">
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
                        <li id="warna">
                            <a href="#">
                                <!-- Icon Container -->
                                    <span class="da-nav-icon">
                                        <i class="icon-table"></i>
                                    </span>
                                Warna
                            </a>
                            <ul>
                                <li><a href="/warna">Warna</a></li>
                                <li><a href="/warna/pantone_master">Pantone Master</a></li>
                                <li><a href="/warna/corak">Corak</a></li>
                                <li><a href="/warna/pattern_warna">Pattern</a></li>
                            </ul>
                        </li>
                        <li id="tukang">
                            <a href="#">
                                <!-- Icon Container -->
                                    <span class="da-nav-icon">
                                        <i class="icon-table"></i>
                                    </span>
                                Tukang
                            </a>
                            <ul>
                                <li><a href="/worker">Tukang</a></li>
                                <li><a href="/worker/detail">Grup Tukang</a></li>
                                <li><a href="/division">Divisi Tukang</a></li>
                            </ul>
                        </li>
                        <li id="absensi">
                            <a href="#">
                                <!-- Icon Container -->
                                    <span class="da-nav-icon">
                                        <i class="icon-edit"></i>
                                    </span>
                                Absensi
                            </a>
                            <ul>
                                <li><a href="/absensi">Absensi</a></li>
                                <li><a href="/absensi/tugastukang">Tugas Tukang</a></li>
                                <li><a href="/absensi/projectdetail_worker">Project Detail Tukang</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>

            </div>