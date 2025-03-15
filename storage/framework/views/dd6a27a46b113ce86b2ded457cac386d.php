<nav
    class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-without-dd-arrow fixed-top navbar-semi-dark navbar-shadow no-print">
    <div class="navbar-wrapper navbar-dark">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mobile-menu d-md-none mr-auto">
                    <a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#">
                        <i class="fa fa-bars fa-2x"></i>
                    </a>
                </li>
                <li class="nav-item mr-auto  text-center" style="margin-top: -10px!important; margin-right: 20px !important;">
                    <a class="navbar-brand text-center" href="<?php echo e(route('admin.home')); ?>">
                        <h6 class="brand-text  text-center" style="font-size: 16px!important;line-height: 1.6;top: 0;" dir="rtl">
                            لوحة تحكم الادارة
                        </h6>
                    </a>
                </li>
                <li class="nav-item d-none d-md-block float-right">
                    <a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse">
                        <i class="fa fa-toggle-on fa2-x" style="color: #ddd;font-size: 22px !important;"
                           data-ticon="fa fa-toggle-right"></i>
                    </a></li>
                <li class="nav-item d-md-none">
                    <a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i
                            class="la la-ellipsis-v"></i></a>
                </li>
            </ul>
        </div>
        <div class="navbar-container content">
            <div class="collapse navbar-collapse" id="navbar-mobile">
                <ul class="nav navbar-nav mr-auto float-left">

                </ul>
                <ul class="nav navbar-nav float-left">
                    <li class="dropdown dropdown-user nav-item">
                        <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                                <span class="mr-1">
                                  <span class="user-name text-bold-700"
                                        style="color: #ddd;"><?php echo e(Auth::user()->name); ?></span>
                                </span>
                            <span class="avatar avatar-online">
                                    <?php if(isset(Auth::user()->profile->profile_pic) && !empty(Auth::user()->profile->profile_pic) ): ?>
                                    <img src="<?php echo e(asset(Auth::user()->profile->profile_pic)); ?>" alt="avatar"><i></i>
                                <?php else: ?>
                                    <img src="<?php echo e(asset('app-assets/images/user.png')); ?>" alt="avatar"><i></i>
                                <?php endif; ?>
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="<?php echo e(route('admin.profile.edit',Auth::user()->id)); ?>">
                                <i class="fa fa-user"></i> تعديل البيانات
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="<?php echo e(route('admin.logout')); ?>"
                               onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                <i class="fa fa-power-off"></i> تسجيل الخروج
                            </a>
                            <form id="logout-form" action="<?php echo e(route('admin.logout')); ?>" method="POST"
                                  style="display: none;">
                                <?php echo csrf_field(); ?>
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
<?php /**PATH /var/www/html/elaraby_erp_new/resources/views/admin/layouts/common/header.blade.php ENDPATH**/ ?>