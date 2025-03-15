<style>

</style>
<?php $__env->startSection('content'); ?>
    <?php if(count($errors) > 0): ?>
        <div class="alert alert-danger">
            <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>الاخطاء :</strong>
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-12">
            <div class="card mg-b-20">
                <div class="card-body">
                    <div class="col-12">
                        <a class="btn btn-primary btn-sm pull-left" href="<?php echo e(route('admin.types.index')); ?>">
                            عودة
                            للخلف</a>
                        <h5 style="min-width: 300px;" class="pull-right alert alert-sm alert-success">
                            تحديث بيانات نوع الاشتراك
                        </h5>
                    </div>
                    <div class="clearfix"></div>
                    <br>

                    <form class="parsley-style-1" id="selectForm2" name="selectForm2"
                          action="<?php echo e(route('admin.types.update',$type->id)); ?>" enctype="multipart/form-data"
                          method="post">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PATCH'); ?>
                        <h5 class="col-lg-12 d-block mb-2">البيانات الاساسية</h5>
                        <hr>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label> اسم الاشتراك <span class="text-danger">*</span></label>
                                <input value="<?php echo e($type->type_name); ?>" dir="rtl" required class="form-control"
                                       name="type_name" type="text">
                            </div>
                            <div class="col-md-3">
                                <label> سعر الاشتراك <span class="text-danger">*</span></label>
                                <input value="<?php echo e($type->type_price); ?>" required class="form-control" dir="ltr"
                                       name="type_price" type="text">
                            </div>
                            <div class="col-md-3">
                                <label> مدة الاشتراك بالايام <span class="text-danger">*</span></label>
                                <input required value="<?php echo e($type->period); ?>" class="form-control" dir="ltr" name="period"
                                       type="text">
                            </div>
                            <div class="col-md-3">
                                <label> الباقة <span class="text-danger">*</span></label>
                                <select name="package_id" required class="form-control">
                                    <option value="">اختر الباقة</option>
                                    <?php $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option
                                            <?php if($package->id == $type->package_id): ?>
                                            selected
                                            <?php endif; ?>
                                            value="<?php echo e($package->id); ?>"><?php echo e($package->package_name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button class="btn btn-info pd-x-20" type="submit">اضافة</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app-main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/elaraby_erp_new/resources/views/admin/types/edit.blade.php ENDPATH**/ ?>