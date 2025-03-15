<style>

</style>
<?php $__env->startSection('content'); ?>
    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissable fade show">
            <button class="close" data-dismiss="alert" aria-label="Close">×</button>
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>
    <!-- row -->
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <div class="col-lg-12 margin-tb">



                            <h5 class="pull-right alert alert-sm alert-success">عرض كل المدفوعات </h5>
                        </div>
                        <br>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-condensed table-striped table-bordered text-center table-hover"
                               id="example-table">
                            <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">اسم الشركة</th>
                                <th class="text-center"> المبلغ المدفوع</th>
                                <th class="text-center">التاريخ</th>
                                <th class="text-center">الوقت</th>

                            </tr>
                            </thead>
                            <tbody>
                            <?php
                                $i=0;
                            ?>
                            <?php $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if(!$payment->company->clients->isEmpty()): ?>
                                    <tr>
                                        <td><?php echo e(++$i); ?></td>
                                        <td><?php echo e($payment->company->company_name); ?></td>
                                        <td><?php echo e($payment->amount); ?></td>
                                        <td><?php echo e($payment->date); ?></td>
                                        <td><?php echo e($payment->time); ?></td>











                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

























    </div>
<?php $__env->stopSection(); ?>
<script src="<?php echo e(asset('app-assets/js/jquery.min.js')); ?>"></script>
<script>
    $(document).ready(function () {
        // $('.delete_payment').on('click', function () {
        //     var payment_id = $(this).attr('payment_id');
        //     var payment_name = $(this).attr('payment_name');
        //     $('.modal-body #paymentid').val(payment_id);
        //     $('.modal-body #paymentname').val(payment_name);
        // });
    });
</script>

<?php echo $__env->make('admin.layouts.app-main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/elaraby_erp_new/resources/views/admin/payments/index.blade.php ENDPATH**/ ?>