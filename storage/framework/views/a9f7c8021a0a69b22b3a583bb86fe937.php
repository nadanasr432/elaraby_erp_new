<style>

</style>
<?php $__env->startSection('content'); ?>
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

    <!-- row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card mg-b-20">
                <div class="card-body">
                    <div class="col-12">
                        <h5 style="min-width: 300px;" class="pull-left alert alert-sm alert-success">
                            <?php echo e(__('sidebar.add-new-permission')); ?>

                        </h5>
                    </div>
                    <div class="clearfix"></div>
                    <br>
                    <form method="POST" action="<?php echo e(route('client.roles.store')); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="main-content-label mg-b-5">
                            <div class="row">
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <label for="name"><?php echo e(__('main.permission')); ?> :</label>
                                        <input type="text" id="name" name="name" class="form-control" required>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="row m-3 p-3">
                            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                                aria-orientation="vertical">
                                <a class="nav-link active" id="v-pills-branch-tab" data-toggle="pill" href="#v-pills-branch"
                                    role="tab" aria-controls="v-pills-branch" aria-selected="true">
                                    <?php echo e(__('sidebar.branches') . ' ' . __('main.and') . ' ' . __('sidebar.storages')); ?>

                                </a>
                                <a class="nav-link" id="v-pills-products-tab" data-toggle="pill" href="#v-pills-products"
                                    role="tab" aria-controls="v-pills-products" aria-selected="false">
                                    <?php echo e(__('sidebar.main-categories') . ' ' . __('main.and') . ' ' . __('sidebar.products')); ?>

                                </a>
                                <a class="nav-link" id="v-pills-suppliers-tab" data-toggle="pill" href="#v-pills-suppliers"
                                    role="tab" aria-controls="v-pills-suppliers" aria-selected="false">
                                    <?php echo e(__('sidebar.clients') . ' ' . __('main.and') . ' ' . __('sidebar.suppliers')); ?>

                                </a>
                                <a class="nav-link" id="v-pills-banks-tab" data-toggle="pill" href="#v-pills-banks"
                                    role="tab" aria-controls="v-pills-banks" aria-selected="false">
                                    <?php echo e(__('sidebar.banks') . ' ' . __('main.and') . ' ' . __('sidebar.payments')); ?>

                                </a>
                                <a class="nav-link" id="v-pills-cashs-tab" data-toggle="pill" href="#v-pills-cashs"
                                    role="tab" aria-controls="v-pills-cashs" aria-selected="false">
                                    <?php echo e(__('sidebar.purchases')); ?>

                                </a>
                                <a class="nav-link" id="v-pills-gifts-tab" data-toggle="pill" href="#v-pills-gifts"
                                    role="tab" aria-controls="v-pills-gifts" aria-selected="false">
                                    <?php echo e(__('sidebar.special-customer-gifts') . ' ' . __('main.and') . ' ' . __('sidebar.emails')); ?>

                                </a>

                                <a class="nav-link" id="v-pills-quotations-tab" data-toggle="pill"
                                    href="#v-pills-quotations" role="tab" aria-controls="v-pills-quotations"
                                    aria-selected="false">
                                    <?php echo e(__('sidebar.quotes') . ' ' . __('main.and') . ' ' . __('sidebar.sales-invoices')); ?>

                                </a>

                                <a class="nav-link" id="v-pills-fast-tab" data-toggle="pill" href="#v-pills-fast"
                                    role="tab" aria-controls="v-pills-fast" aria-selected="false">
                                    <?php echo e(__('sidebar.purchases-invoices')); ?>

                                </a>

                                <a class="nav-link" id="v-pills-daily-tab" data-toggle="pill" href="#v-pills-daily"
                                    role="tab" aria-controls="v-pills-daily" aria-selected="false">
                                    <?php echo e(__('reports.account-statement-reports') . ' ' . __('main.and') . ' ' . __('sidebar.journal')); ?>

                                </a>

                                <a class="nav-link" id="v-pills-reports-tab" data-toggle="pill" href="#v-pills-reports"
                                    role="tab" aria-controls="v-pills-reports" aria-selected="false">
                                    <?php echo e(__('sidebar.users-permissions') . ' ' . __('main.and') . ' ' . __('sidebar.settings')); ?>

                                </a>
                            </div>
                            <div class="tab-content p-5" id="v-pills-tabContent" style="border-right: 1px solid #ddd;">
                                <div class="tab-pane fade show active" id="v-pills-branch" role="tabpanel"
                                    aria-labelledby="v-pills-branch-tab">
                                    <?php $__currentLoopData = $permission; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($value->key == 'branch' || $value->key == 'store' || $value->key == 'safe'): ?>
                                            <label style="font-size: 16px;">
                                                <input type="checkbox" name="permission[]" value="<?php echo e($value->id); ?>" class="name">
                                                <?php echo e($value->name); ?>

                                            </label>
                                            <br>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>

                                <div class="tab-pane fade" id="v-pills-products" role="tabpanel"
                                    aria-labelledby="v-pills-products-tab">
                                    <?php $__currentLoopData = $permission; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($value->key == 'category' || $value->key == 'product'): ?>
                                            <label style="font-size: 16px;">
<input type="checkbox" name="permission[]" value="<?php echo e($value->id); ?>" class="name">
                                                <?php echo e($value->name); ?>

                                            </label>
                                            <br>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                                <div class="tab-pane fade" id="v-pills-suppliers" role="tabpanel"
                                    aria-labelledby="v-pills-suppliers-tab">
                                    <?php $__currentLoopData = $permission; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($value->key == 'outer_client' || $value->key == 'supplier'): ?>
                                            <label style="font-size: 16px;">
<input type="checkbox" name="permission[]" value="<?php echo e($value->id); ?>" class="name">
                                                <?php echo e($value->name); ?>

                                            </label>
                                            <br>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                                <div class="tab-pane fade" id="v-pills-banks" role="tabpanel"
                                    aria-labelledby="v-pills-banks-tab">
                                    <?php $__currentLoopData = $permission; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($value->key == 'bank' || $value->key == 'expense'): ?>
                                            <label style="font-size: 16px;">
<input type="checkbox" name="permission[]" value="<?php echo e($value->id); ?>" class="name">
                                                <?php echo e($value->name); ?>

                                            </label>
                                            <br>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>

                                <div class="tab-pane fade" id="v-pills-cashs" role="tabpanel"
                                    aria-labelledby="v-pills-cashs-tab">
                                    <?php $__currentLoopData = $permission; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($value->key == 'cash' || $value->key == 'capital' || $value->key == 'payments'): ?>
                                            <label style="font-size: 16px;">
<input type="checkbox" name="permission[]" value="<?php echo e($value->id); ?>" class="name">
                                                <?php echo e($value->name); ?>

                                            </label>
                                            <br>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                                <div class="tab-pane fade" id="v-pills-gifts" role="tabpanel"
                                    aria-labelledby="v-pills-gifts-tab">
                                    <?php $__currentLoopData = $permission; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($value->key == 'gifts' || $value->key == 'email'): ?>
                                            <label style="font-size: 16px;">
<input type="checkbox" name="permission[]" value="<?php echo e($value->id); ?>" class="name">
                                                <?php echo e($value->name); ?>

                                            </label>
                                            <br>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>

                                <div class="tab-pane fade" id="v-pills-quotations" role="tabpanel"
                                    aria-labelledby="v-pills-quotations-tab">
                                    <?php $__currentLoopData = $permission; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($value->key == 'quotation' || $value->key == 'sale_bill'): ?>
                                            <label style="font-size: 16px;">
<input type="checkbox" name="permission[]" value="<?php echo e($value->id); ?>" class="name">
                                                <?php echo e($value->name); ?>

                                            </label>
                                            <br>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>


                                <div class="tab-pane fade" id="v-pills-fast" role="tabpanel"
                                    aria-labelledby="v-pills-fast-tab">
                                    <?php $__currentLoopData = $permission; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($value->key == 'buy_bill'): ?>
                                            <label style="font-size: 16px;">
<input type="checkbox" name="permission[]" value="<?php echo e($value->id); ?>" class="name">
                                                <?php echo e($value->name); ?>

                                            </label>
                                            <br>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>


                                <div class="tab-pane fade" id="v-pills-daily" role="tabpanel"
                                    aria-labelledby="v-pills-daily-tab">
                                    <?php $__currentLoopData = $permission; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($value->key == 'summary' || $value->key == 'daily'): ?>
                                            <label style="font-size: 16px;">
<input type="checkbox" name="permission[]" value="<?php echo e($value->id); ?>" class="name">
                                                <?php echo e($value->name); ?>

                                            </label>
                                            <br>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>

                                <div class="tab-pane fade" id="v-pills-reports" role="tabpanel"
                                    aria-labelledby="v-pills-reports-tab">
                                    <?php $__currentLoopData = $permission; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($value->key == 'reports' || $value->key == 'privilege' || $value->key == 'settings'): ?>
                                            <label style="font-size: 16px;">
<input type="checkbox" name="permission[]" value="<?php echo e($value->id); ?>" class="name">
                                                <?php echo e($value->name); ?>

                                            </label>
                                            <br>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                <button type="button" id="check_all" class="btn btn-danger"> تحديد الكل</button>
                                <button type="submit" class="btn btn-info">تأكيد</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- main-content closed -->
    <script src="<?php echo e(asset('app-assets/js/jquery.min.js')); ?>"></script>
    <script>
        $('#check_all').click(function() {
            $('input[type=checkbox]').prop('checked', true);
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('client.layouts.app-main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/elaraby_erp_new/resources/views/client/roles/create.blade.php ENDPATH**/ ?>