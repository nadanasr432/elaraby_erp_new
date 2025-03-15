<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href="<?php echo e(asset('images/favicon.png')); ?>" type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title> الصفحة غير موجودة </title>
    <link rel="shortcut icon" href="<?php echo e(asset('assets/images/favicon.png')); ?>" type="image/x-icon">
    <?php echo $__env->make('site.layouts.common.css_links', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <style>
        @font-face {
            font-family: 'Cairo';
            src: url("<?php echo e(asset('fonts/Cairo.ttf')); ?>");
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Cairo' !important;
        }

        body, html {
            font-family: 'Cairo' !important;
        }
    </style>
</head>
<body>
<!-- ==========Four-Not-Four-Section========== -->
<section class="section-404" style="padding: 0!important;">
    <div class="container">
        <div class="thumb-404">
            <img style="width: 80%!important;" src="<?php echo e(asset('assets/images/404.png')); ?>" alt="404">
        </div>
        <h3 class="title">
            نعتذر .. هذه الصفحة المطلوبة غير موجودة
        </h3>
        <a href="<?php echo e(route('index')); ?>" class="custom-button"> العودة الى الصفحة الرئيسية <i
                class="flaticon-right"></i></a>
    </div>
</section>
<!-- ==========Four-Not-Four-Section========== -->
<?php echo $__env->make('site.layouts.common.js_links', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</body>
</html>
<?php /**PATH /var/www/html/elaraby_erp_new/resources/views/errors/404.blade.php ENDPATH**/ ?>