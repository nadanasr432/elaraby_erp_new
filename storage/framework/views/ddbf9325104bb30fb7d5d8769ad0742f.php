<style>

</style>
<?php $__env->startSection('content'); ?>
    <section class="account-section bg_img" data-background="./assets/images/account/account-bg.jpg">
        <div class="container">
            <div class="padding-top padding-bottom">
                <div class="account-area" style="background: #0a1e5e !important;">
                    <div class="section-header-3">
                        <h3>
                            لوحة تحكم الادارة
                        </h3>
                    </div>
                    <form class="account-form" method="POST" action="<?php echo e(route('admin.login')); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="form-group">
                            <label class="d-block text-white"
                                   style="direction: rtl!important;text-align: right!important;"
                                   for="email">البريد الالكترونى<span>*</span></label>
                            <input value="<?php echo e(old('email')); ?>" name="email" autofocus
                                   style="direction: ltr!important;text-align: left!important;"
                                   type="email" placeholder="اكتب البريد الالكترونى" id="email" required>
                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span style="direction: rtl!important;text-align: right!important;" role="alert">
                                    <strong><?php echo e($message); ?></strong>
                                </span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="form-group">
                            <label class="d-block text-white"
                                   style="direction: rtl!important;text-align: right!important;"
                                   for="pass3">كلمة المرور<span>*</span></label>
                            <input type="password" placeholder="كلمة المرور"
                                   name="password" dir="ltr" id="pass3" required
                                   style="direction: ltr!important;text-align: left!important;">
                            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="text-right" dir="rtl" role="alert">
                                    <strong><?php echo e($message); ?></strong>
                                </span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="form-group text-center">
                            <input type="submit" value="تسجيل الدخول">
                        </div>
                    </form>
                    <?php if(Route::has('admin.password.request')): ?>
                        <div class="form-group checkgroup text-right mt-5" dir="rtl">
                            <a href="<?php echo e(route('admin.password.request')); ?>" class="forget-pass text-white234">
                                هل نسيت كلمة المرور ؟
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('site.layouts.app-main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/elaraby_erp_new/resources/views/admin/auth/login.blade.php ENDPATH**/ ?>