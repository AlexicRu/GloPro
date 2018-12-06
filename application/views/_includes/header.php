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

    <title><?=(!empty($title) ? implode(' :: ', $title) : '')?></title>

    <?if (!empty($styles)) {
        foreach($styles as $style){?>
            <link href="<?=$style?>" rel="stylesheet">
        <?}
    }?>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <?if (!empty($scripts)) {
        foreach($scripts as $script){?>
            <script src="<?=$script?>"></script>
        <?}
    }?>
    <?if (!empty($scriptsRaw)) {?>
        <script>
            <?foreach ($scriptsRaw as $script) {?>
            <?=$script?>
            <?}?>
        </script>
    <?}?>
</head>

<body class="fix-header card-no-border fix-sidebar design__<?=(!empty($customView) ? $customView : Common::DESIGN_DEFAULT)?> <?=(User::loggedIn() ? 'logged-in' : 'logged-out')?>">
<!-- ============================================================== -->
<!-- Preloader - style you can find in spinners.css -->
<!-- ============================================================== -->
<div class="preloader">
    <div class="loader">
        <div class="loader__figure"></div>
        <p class="loader__label"><?=(!empty($title) ? implode(' :: ', $title) : '')?></p>
    </div>
</div>
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
            <?if (User::loggedIn()) { include 'navigation.php'; }?>
        </nav>
    </header>
    <!-- ============================================================== -->
    <!-- End Topbar header -->
    <!-- ============================================================== -->
    <?if (User::loggedIn()) { echo $menu; }?>
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
