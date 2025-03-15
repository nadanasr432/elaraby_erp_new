<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="rtl">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title> <?php echo e($system->name); ?> </title>
    <meta name="_token" content="<?php echo e(csrf_token()); ?>" />
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />
    <?php echo $__env->make('admin.layouts.common.css_links', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <style type="text/css" media="print">
        @media print {
            .app-content,.content{
                margin-right: 0 !important;
            }
            body {
                -webkit-print-color-adjust: exact;
                -moz-print-color-adjust: exact;
                print-color-adjust: exact;
                -o-print-color-adjust: exact;
            }
            .no-print {display:none;}
            .printy {display: block !important;}
        }
    </style>
    <style>
        @font-face {
            font-family: 'Cairo';
            src: url("<?php echo e(asset('fonts/Cairo.ttf')); ?>");
        }
        label{
            font-size: 13px !important;
        }

        table {
            font-size: 13px !important;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Cairo' !important;
        }
        .dropdown-menu.dropdown-menu-right.show{
            width: 200px !important;
        }
        body, html {
            font-family: 'Cairo' !important;
            font-size: 13px !important;
        }
        .navigation.navigation-main{
            padding-bottom: 50px !important;
        }

        .btn.dropdown-toggle.bs-placeholder,.btn.dropdown-toggle{
            height: 40px !important;
        }
    </style>
</head>

<body class="vertical-layout vertical-menu-modern 2-columns   menu-expanded fixed-navbar"
      data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">
<?php echo $__env->make('admin.layouts.common.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php echo $__env->make('admin.layouts.common.ul_sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">

        </div>
        <div class="content-body">
            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </div>
</div>
<?php echo $__env->make('admin.layouts.common.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php echo $__env->make('admin.layouts.common.js_links', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

</body>
</html>
<?php /**PATH /var/www/html/elaraby_erp_new/resources/views/admin/layouts/app-main.blade.php ENDPATH**/ ?>