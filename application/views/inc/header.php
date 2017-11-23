<!--
 * CoreUI - Open Source Bootstrap Admin Template
 * @version v1.0.0
 * @link http://coreui.io
 * Copyright (c) 2017 creativeLabs Łukasz Holeczek
 * @license MIT
-->
<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="CoreUI - Open Source Bootstrap Admin Template">
        <meta name="author" content="Łukasz Holeczek">
        <meta name="keyword" content="Bootstrap,Admin,Template,Open,Source,AngularJS,Angular,Angular2,Angular 2,Angular4,Angular 4,jQuery,CSS,HTML,RWD,Dashboard,React,React.js,Vue,Vue.js">
        <link rel="shortcut icon" href="img/favicon.png">
        <title>ERP</title>

        <!-- Icons -->
        <link href="/css/font-awesome.min.css" rel="stylesheet">
        <link href="/css/simple-line-icons.css" rel="stylesheet">

        <!-- Main styles for this application -->
        <link href="/css/style.css" rel="stylesheet">
        <link href="/css/custom.css" rel="stylesheet">
        <style type="text/css">
            div.is-invalid{
                color: #f86c6b;
            }

            .modal {
                overflow:visible;
            }
        </style>

        <link rel="stylesheet" href="http://code.jquery.com/ui/1.8.18/themes/base/jquery-ui.css" type="text/css" />
        <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
    </head>

    <!-- BODY options, add following classes to body to change options
    
    // Header options
    1. '.header-fixed'					- Fixed Header
    
    // Sidebar options
    1. '.sidebar-fixed'					- Fixed Sidebar
    2. '.sidebar-hidden'				- Hidden Sidebar
    3. '.sidebar-off-canvas'		- Off Canvas Sidebar
    4. '.sidebar-minimized'			- Minimized Sidebar (Only icons)
    5. '.sidebar-compact'			  - Compact Sidebar
    
    // Aside options
    1. '.aside-menu-fixed'			- Fixed Aside Menu
    2. '.aside-menu-hidden'			- Hidden Aside Menu
    3. '.aside-menu-off-canvas'	- Off Canvas Aside Menu
    
    // Breadcrumb options
    1. '.breadcrumb-fixed'			- Fixed Breadcrumb
    
    // Footer options
    1. '.footer-fixed'					- Fixed footer
    
    -->

    <body class="app header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden">
        <header class="app-header navbar">
            <button class="navbar-toggler mobile-sidebar-toggler d-lg-none mr-auto" type="button">☰</button>
            <!--<a class="navbar-brand" href="#"></a>-->
            <button class="navbar-toggler sidebar-minimizer d-md-down-none" type="button">☰</button>

        </header>

        <div class="app-body">
            <div class="sidebar">
                <nav class="sidebar-nav">
                    <ul class="nav">
                        <?php if ($this->session->userdata('LEVEL') === 'A') { ?>
                            <li class="nav-item">
                                <a class="nav-link" href="/index/adminConfig"><i class="icon-speedometer"></i> 관리자관리</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/index/typeConfig"><i class="icon-speedometer"></i> 매물구분관리</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/index/optionConfig"><i class="icon-speedometer"></i> 매물옵션관리</a>
                            </li>
                        <?php } ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/index/main"><i class="icon-speedometer"></i> 매물관리 <!-- span class="badge badge-primary">NEW</span --></a>
                        </li>
                    </ul>
                </nav>
            </div>

            <!-- Main content -->
            <main class="main">
                