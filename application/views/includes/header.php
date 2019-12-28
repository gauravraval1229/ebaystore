<script type="text/javascript">
var ebayToken = "<?=EBAYTOKEN?>";
var ebayApiUrl =   "<?=EBAYAPIURL?>";
</script>

<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Modern admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities with bitcoin dashboard.">
    <meta name="keywords" content="admin template, modern admin template, dashboard template, flat admin template, responsive admin template, web app, crypto dashboard, bitcoin dashboard">
    <meta name="author" content="PIXINVENT">
    <title>Ebay</title>
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url('assests/app-assets/images/logo/logo.png'); ?>" >
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i%7CQuicksand:300,400,500,700" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assests/app-assets/vendors/css/vendors.min.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assests/app-assets/vendors/css/tables/datatable/datatables.min.css'); ?>">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assests/app-assets/css/bootstrap.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assests/app-assets/css/bootstrap-extended.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assests/app-assets/css/colors.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assests/app-assets/css/components.css'); ?>">
    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assests/app-assets/css/core/menu/menu-types/vertical-menu.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assests/app-assets/css/core/colors/palette-gradient.css'); ?>">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assests/assets/css/style.css'); ?>">
    <!-- END: Custom CSS-->

    <script language="javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.0/jquery.min.js"></script>


</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu 2-columns fixed-navbar" data-open="click" data-menu="vertical-menu" data-col="2-columns">

    <!-- BEGIN: Header-->
    <nav class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-without-dd-arrow fixed-top navbar-semi-light bg-info navbar-shadow">
        <div class="navbar-wrapper">
            <div class="navbar-header">
                <ul class="nav navbar-nav flex-row">
                    <li class="nav-item mobile-menu d-md-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu font-large-1"></i></a></li>
                    <li class="nav-item"><a class="navbar-brand" href="#"><img class="brand-logo" alt="modern admin logo" src="<?php echo base_url('assests/app-assets/images/logo/logo.png');?>">
                            <h3 class="brand-text">Ebay</h3>
                        </a></li>
                    <li class="nav-item d-md-none"><a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i class="la la-ellipsis-v"></i></a></li>
                </ul>
            </div>
            <div class="navbar-container content">
                <div class="collapse navbar-collapse" id="navbar-mobile">
                    <ul class="nav navbar-nav mr-auto float-left">
                        <li class="nav-item d-none d-md-block"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu"></i></a></li>
                    </ul>

                    <ul class="nav navbar-nav float-right">
                        <li class="dropdown dropdown-user nav-item">
                            <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                                <span class="mr-1 user-name text-bold-700"><?php echo $this->session->userdata['logged_in']['firstName'].' '.$this->session->userdata['logged_in']['lastName']; ?></span>
                                <span class="avatar"><img src="<?php echo base_url('assests/app-assets/images/logo/logo.png'); ?>" alt="avatar"><i></i>
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="#"><i class="ft-user"></i> Edit Profile</a>
                                <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="<?php echo base_url('loginController/logout'); ?>"><i class="ft-power"></i> Logout</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <!-- END: Header-->


    <!-- BEGIN: Main Menu-->

    <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow " data-scroll-to-active="true">
        <div class="main-menu-content">
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                <li class="nav-item"><a href="#"><i class="la la-stethoscope"></i><span class="menu-title" data-i18n="nav.color_palette.main">Location</span></a>
                    <ul class="menu-content">
                        <li><a class="menu-item" href="<?php echo base_url('locationController/index'); ?>"><i></i><span data-i18n="nav.color_palette.color_palette_primary">View</span></a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item"><a href="#"><i class="la la-shopping-cart"></i><span class="menu-title" data-i18n="nav.color_palette.main">Item Group</span></a>
                    <ul class="menu-content">
                        <li><a class="menu-item" href="<?php echo base_url('itemGroupController/index'); ?>"><i></i><span data-i18n="nav.color_palette.color_palette_primary">View</span></a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item"><a href="#"><i class="la la-bank"></i><span class="menu-title" data-i18n="nav.color_palette.main">Product</span></a>
                    <ul class="menu-content">
                        <li><a class="menu-item" href="<?php echo base_url('productController/index'); ?>"><i></i><span data-i18n="nav.color_palette.color_palette_primary">View</span></a>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>
    </div>

    <!-- END: Main Menu-->