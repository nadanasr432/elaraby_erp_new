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
                        <a class="btn btn-primary btn-sm pull-left" href="<?php echo e(route('admin.companies.index')); ?>">
                            عودة
                            للخلف</a>
                        <h5 style="min-width: 300px;" class="pull-right alert alert-sm alert-success">
                            تحديث بيانات الشركة
                        </h5>
                    </div>
                    <div class="clearfix"></div>
                    <br>

                    <form class="parsley-style-1" id="selectForm2" name="selectForm2"
                          action="<?php echo e(route('admin.companies.update',$company->id)); ?>" enctype="multipart/form-data"
                          method="post">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PATCH'); ?>
                        <h5 class="col-lg-12 d-block mb-2">البيانات الاساسية</h5>
                        <hr>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label> اسم الشركة <span class="text-danger">*</span></label>
                                <input dir="rtl" value="<?php echo e($company->company_name); ?>" required class="form-control"
                                       name="company_name" type="text">
                            </div>
                            <div class="col-md-4">
                                <label> الحالة <span class="text-danger">*</span></label>
                                <select class="form-control" name="status" id="">
                                    <option <?php if($company->status == "active"): ?> selected <?php endif; ?> value="active">مفعل</option>
                                    <option <?php if($company->status == "blocked"): ?> selected <?php endif; ?> value="blocked">معطل</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="d-block" dir="rtl"> ملاحظات ( اكتب سبب التعطيل ) </label>
                                <input dir="rtl" value="<?php echo e($company->notes); ?>" class="form-control"
                                       name="notes" type="text">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button class="btn btn-info pd-x-20" type="submit">تحديث</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app-main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/elaraby_erp_new/resources/views/admin/companies/edit.blade.php ENDPATH**/ ?>