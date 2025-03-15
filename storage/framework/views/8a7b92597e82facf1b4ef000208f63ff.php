<style>

</style>
<?php $__env->startSection('content'); ?>
    <!-- main-content closed -->
    <?php if(count($errors) > 0): ?>
        <div class="alert alert-danger">
            <strong>Errors :</strong>
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- row opened -->
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="col-12">
                        <a class="btn btn-primary btn-sm pull-left"
                            href="<?php echo e(route('client.clients.index')); ?>"><?php echo e(__('main.back')); ?></a>
                        <h5 style="min-width: 300px;" class="pull-right alert alert-sm alert-success">
                            <?php echo e(__('sidebar.add-new-user')); ?>

                        </h5>
                    </div>
                </div>
                <div class="card-body p-1 m-1">
                    <form action="<?php echo e(route('client.clients.store')); ?>" method="post">
                        <?php echo e(csrf_field()); ?>

                        <div class="row m-t-3 mb-3">
                            <div class="col-md-4">
                                <label> <?php echo e(__('main.username')); ?> <span class="text-danger">*</span></label>
                                <input class="form-control mg-b-20" name="name" required type="text">
                            </div>
                            <div class="parsley-input col-md-4 mg-t-20 mg-md-t-0" id="lnWrapper">
                                <label> <?php echo e(__('main.email')); ?> : <span class="text-danger">*</span></label>
                                <input class="form-control  mg-b-20" style="text-align: left;direction:ltr;"
                                    data-parsley-class-handler="#lnWrapper" name="email" required="" type="email">
                            </div>
                            <div class="parsley-input col-md-4 mg-t-20 mg-md-t-0" id="lnWrapper">
                                <label class="form-label"> <?php echo e(__('main.status')); ?> </label>
                                <select name="Status" id="select-beast" class="form-control">
                                    <option selected value="active"><?php echo e(__('main.active')); ?></option>
                                    <option value="blocked"><?php echo e(__('main.deactive')); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="row m-t-3 mb-3">
                            <div class="parsley-input col-md-3 mg-t-20 mg-md-t-0" id="lnWrapper">
                                <label> <?php echo e(__('main.password')); ?> : <span class="text-danger">*</span></label>
                                <input class="form-control  mg-b-20" style="text-align: left;direction:ltr;"
                                    data-parsley-class-handler="#lnWrapper" name="password" required="" type="password">
                            </div>
                            <div class="parsley-input col-md-3 mg-t-20 mg-md-t-0" id="lnWrapper">
                                <label> <?php echo e(__('main.confirm-password')); ?> : <span class="text-danger">*</span></label>
                                <input class="form-control  mg-b-20" style="text-align: left;direction:ltr;"
                                    data-parsley-class-handler="#lnWrapper" name="confirm-password" required=""
                                    type="password">
                            </div>
                            <div class="parsley-input col-md-3 mg-t-20 mg-md-t-0" id="lnWrapper">
                                <label class="form-label"> <?php echo e(__('main.permission')); ?> </label>
                                <select id="role_name" data-live-search="true" data-style="btn-info"
                                    title="<?php echo e(__('main.permission')); ?>" class="form-control selectpicker" required
                                    name="role_name[]">
                                    <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($role); ?>"><?php echo e($role); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="col-md-3 mg-t-20 mg-md-t-0 branch" style="display: none;">
                                <label class="form-label"> <?php echo e(__('branches.branche-name')); ?> </label>
                                <select id="branch_id" data-live-search="true" data-style="btn-danger" title="اختر الفرع"
                                    class="form-control selectpicker show-tick" name="branch_id">
                                    <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($branch->id); ?>"><?php echo e($branch->branch_name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button class="btn btn-info pd-x-20" type="submit"><?php echo e(__('main.save')); ?></button>
                        </div>
                    </form>
                    <?php if(session('error')): ?>
                        <div class="alert alert-danger">
                            <?php echo e(session('error')); ?>

                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<script src="<?php echo e(asset('app-assets/js/jquery.min.js')); ?>"></script>
<script>
    $(document).ready(function() {
        $('#role_name').on('change', function() {
            var role_name = $(this).val();
            $('#branch_id').val("");
            $('#branch_id').selectpicker('refresh');
            if (role_name != "مدير النظام") {
                $('.branch').show();
            } else {
                $('.branch').hide();
            }
        });
    });
</script>

<?php echo $__env->make('client.layouts.app-main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/elaraby_erp_new/resources/views/client/clients/create.blade.php ENDPATH**/ ?>