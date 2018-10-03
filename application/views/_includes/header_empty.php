<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Favicon icon -->
    <?=Common::getFaviconRawData(!empty($customView) ? $customView : false)?>

    <title><?=$title?></title>

    <link href="<?=Common::getAssetsLink()?>css/bootstrap/bootstrap.css" rel="stylesheet">
    <link href="<?=Common::getAssetsLink()?>css/google-sans.css" rel="stylesheet">
    <link href="<?=Common::getAssetsLink()?>css/admin-pro/style.css" rel="stylesheet">
    <link href="<?=Common::getAssetsLink()?>css/style.css" rel="stylesheet">
    <link href="<?=Common::getAssetsLink()?>css/admin-pro/colors/<?=!empty($customView) ? 'projects/' . $customView : 'blue'?>.css" rel="stylesheet">
    <link href="<?=Common::getAssetsLink()?>css/design.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body class="fix-header card-no-border fix-sidebar design__<?=(!empty($customView) ? $customView : Common::DESIGN_DEFAULT)?>">

<!-- ============================================================== -->
<!-- Main wrapper - style you can find in pages.scss -->
<!-- ============================================================== -->
<div id="main-wrapper">
    <!-- ============================================================== -->
    <!-- Topbar header - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <header class="topbar">
        <nav class="navbar top-navbar navbar-expand-md navbar-light">
            <!-- ============================================================== -->
            <!-- Logo -->
            <!-- ============================================================== -->
            <div class="navbar-header">
                <a class="navbar-brand" href="/">
                    <!-- Logo icon -->
                    <b>
                        <i class="logo"></i>
                    </b>
                    <!--End Logo icon -->
                </a>
            </div>
            <!-- ============================================================== -->
            <!-- End Logo -->
            <!-- ============================================================== -->
        </nav>
    </header>
    <!-- ============================================================== -->
    <!-- End Topbar header -->
    <!-- ============================================================== -->

    <!-- ============================================================== -->
    <!-- Page wrapper  -->
    <!-- ============================================================== -->
    <div class="page-wrapper">

        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <!-- ============================================================== -->
        <div class="container-fluid">

            <!-- ============================================================== -->
            <!-- Start Page Content -->
            <!-- ============================================================== -->
