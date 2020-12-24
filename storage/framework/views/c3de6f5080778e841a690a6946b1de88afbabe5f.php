<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <!-- Favicon icon -->
    <link rel="apple-touch-icon" sizes="57x57" href="<?php echo e(asset('favicon/apple-icon-57x57.png')); ?>">
    <link rel="apple-touch-icon" sizes="60x60" href="<?php echo e(asset('favicon/apple-icon-60x60.png')); ?>">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo e(asset('favicon/apple-icon-72x72.png')); ?>">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo e(asset('favicon/apple-icon-76x76.png')); ?>">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo e(asset('favicon/apple-icon-114x114.png')); ?>">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo e(asset('favicon/apple-icon-120x120.png')); ?>">
    <link rel="apple-touch-icon" sizes="144x144" href="<?php echo e(asset('favicon/apple-icon-144x144.png')); ?>">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo e(asset('favicon/apple-icon-152x152.png')); ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo e(asset('favicon/apple-icon-180x180.png')); ?>">
    <link rel="icon" type="image/png" sizes="192x192" href="<?php echo e(asset('favicon/android-icon-192x192.png')); ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo e(asset('favicon/favicon-32x32.png')); ?>">
    <link rel="icon" type="image/png" sizes="96x96" href="<?php echo e(asset('favicon/favicon-96x96.png')); ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo e(asset('favicon/favicon-16x16.png')); ?>">
    <link rel="manifest" href="<?php echo e(asset('favicon/manifest.json')); ?>">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="<?php echo e(asset('favicon/ms-icon-144x144.png')); ?>">
    <meta name="theme-color" content="#ffffff">


    <title><?php echo e($pageTitle . ' | ' . $settings->company_name); ?></title>

    <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/custom.css')); ?>">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <style>
        :root {
            --main-color: <?php echo e($themeSettings->primary_color); ?>;
            --active-color: <?php echo e($themeSettings->secondary_color); ?>;
            --sidebar-bg: <?php echo e($themeSettings->sidebar_bg_color); ?>;
            --sidebar-color: <?php echo e($themeSettings->sidebar_text_color); ?>;
            --topbar-color: <?php echo e($themeSettings->topbar_text_color); ?>;
        }
    </style>
    <?php echo $__env->yieldPushContent('head-css'); ?>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-light border-bottom fixed-top align-items-sm-center align-items-start">
        <!-- Left navbar links -->
        <ul class="navbar-nav d-lg-none d-xl-none">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
            </li>
        </ul>
        <div class="row w-100">
            <?php if($user->is_admin == 1): ?>
                <div class="col-sm-8">
                    <form id="search" class="form-inline h-100 mx-3" action="<?php echo e(route('admin.search.store')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="input-group input-group-custom">
                            <input name="search_key" id="search_key" class="form-control form-control-navbar" type="search" placeholder="<?php echo app('translator')->getFromJson('front.searchBy'); ?>" aria-label="Search" autocomplete="off" required title="<?php echo app('translator')->getFromJson('front.searchBy'); ?>" />
                            <div class="input-group-append">
                                <button id="search-button" class="btn btn-navbar" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            <?php endif; ?>
            <div class="<?php if($user->is_admin != 1): ?> offset-sm-8 <?php endif; ?> col-sm-4">
                <ul class="navbar-nav ml-auto pull-right">
                    <li class="dropdown">
                        <select class="form-control language-switcher">
                            <?php $__empty_1 = true; $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <option value="<?php echo e($language->language_code); ?>" <?php if($settings->locale == $language->language_code): ?> selected <?php endif; ?>>
                                    <?php echo e(ucfirst($language->language_name)); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <option value="en" <?php if($settings->locale == "en"): ?> selected <?php endif; ?>>
                                    English
                                </option>
                            <?php endif; ?>
                        </select>
                    </li>

                    <li class="profile-dropdown">
                        <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                            <?php echo e(csrf_field()); ?>

                        </form>
                        <a class="nav-link" data-toggle="dropdown" href="#">
                            <img src="<?php echo e($user->user_image_url); ?>" class="img-circle elevation-1 navbar-img img-size-32" alt="User Image"> <i class="fa fa-chevron-down"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="<?php echo e(route('admin.profile.index')); ?>" class="dropdown-item">
                                <i class="fa fa-user mr-2"></i> <?php echo app('translator')->getFromJson('menu.profile'); ?>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="<?php echo e(route('logout')); ?>" title="Logout" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();"
                            >
                                <i class="fa fa-power-off"></i> <?php echo app('translator')->getFromJson('app.logout'); ?>
                            </a>
                        </div>
                    </li>
                </ul>
                <div class="row text-center">
                    <div class="col col-md-8">
                    </div>
                    <div class="col col-md-4">
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-danger">
        <!-- Brand Logo -->
        <a href="<?php echo e(route('admin.dashboard')); ?>" class="brand-link">
            <img src="<?php echo e($settings->logo_url); ?>" alt=" Logo" class="brand-image">
            <span class="brand-text font-weight-light">&nbsp;</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">

            <?php echo $__env->make('layouts.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <div class="content pt-2">
            <div class="container-fluid">
                <?php echo $__env->yieldContent('content'); ?>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
        <div class="p-3">
            <h5>Title</h5>
            <p>Sidebar content</p>
        </div>
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <footer class="main-footer">
        <!-- To the right -->
        <div class="float-right d-none d-sm-inline">
            <strong> &copy; <?php echo e(\Carbon\Carbon::today()->year); ?> <?php echo e(ucwords($settings->company_name)); ?>. </strong>
        </div>
        <!-- Default to the left -->
    </footer>
</div>
<!-- ./wrapper -->



<div class="modal fade bs-modal-md in" id="application-modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" id="modal-data-application">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <span class="caption-subject font-red-sunglo bold uppercase" id="modelHeading"></span>
            </div>
            <div class="modal-body">
                Loading...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> <?php echo app('translator')->getFromJson('app.cancel'); ?></button>
                <button type="button" class="btn btn-success"><i class="fa fa-check"></i> <?php echo app('translator')->getFromJson('app.save'); ?></button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>



<div class="modal fade bs-modal-lg in" id="application-lg-modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" id="modal-lg-data-application">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <span class="caption-subject font-red-sunglo bold uppercase" id="modalLgHeading"></span>
            </div>
            <div class="modal-body">
                Loading...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> <?php echo app('translator')->getFromJson('app.cancel'); ?></button>
                <button type="button" class="btn btn-success"><i class="fa fa-check"></i> <?php echo app('translator')->getFromJson('app.save'); ?></button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="<?php echo e(asset('js/app.js')); ?>"></script>
<script>
    $('.select2').select2();
    $('.mytooltip').tooltip();

    $(window).resize(function () {
        $('.content').css('margin-top', $('nav.main-header').css('height'));
    }).resize();

    $('.language-switcher').change(function () {
        const code = $(this).val();
        let url = '<?php echo e(route('front.changeLanguage', ':code')); ?>';
        url = url.replace(':code', code);

        $.easyAjax({
            url: url,
            type: 'POST',
            container: 'body',
            data: {
                _token: '<?php echo e(csrf_token()); ?>'
            },
            success: function (response) {
                if (response.status == 'success') {
                    location.reload();
                }
            }
        })
    })
</script>

<?php echo $__env->yieldPushContent('footer-js'); ?>

</body>
</html>
<?php /**PATH E:\laragon\www\booking\resources\views/layouts/master.blade.php ENDPATH**/ ?>