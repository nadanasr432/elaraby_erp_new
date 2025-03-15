<style>

    span.badge {
        font-size: 13px !important;
        padding: 10px !important;
    }

    .clients {
        display: none;
    }

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
                            <h5 class="pull-right alert alert-sm alert-success">عرض كل الشركات</h5>
                        </div>
                        <br>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered text-center"
                               id="">
                            <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th style="padding:5px 100px;" class="text-center">اسم الشركة</th>
                                <th class="text-center">هاتف الشركة</th>
                                <th class="text-center">عنوان الشركة</th>
                                <th class="text-center">اسم مدير الشركة</th>
                                <th class="text-center">هاتف مدير الشركة</th>
                                <th class="text-center"> البريد الالكترونى لمدير الشركة</th>
                                <th class="text-center">حالة</th>
                                <th class="text-center">ملاحظات</th>
                                <th class="text-center">تاريخ الاضافة</th>
                                <th class="text-center">تعديل</th>
                                <th class="text-center">حذف</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                                $i=0;
                            ?>
                            <?php $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e(++$i); ?></td>
                                        <td>
                                            <a href="javascript:;" class="company"><?php echo e($company->company_name); ?></a>
                                            <ul class="clients">
                                                <?php $__currentLoopData = $company->clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <li><?php echo e($client->name); ?></li>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </ul>
                                        </td>
                                        <td><?php echo e($company->phone_number); ?></td>
                                        <td><?php echo e($company->company_address); ?></td>
                                        <?php
                                        $company_admins = \App\Models\Client::where('company_id', $company->id)
                                            ->get();
                                        foreach ($company_admins as $company_admin) {
                                            if (in_array("مدير النظام", $company_admin->role_name)) {
                                                echo "<td>" . $company_admin->name . "</td>";
                                                echo "<td>" . $company_admin->phone_number . "</td>";
                                                echo "<td>" . $company_admin->email . "</td>";
                                            }
                                            break;
                                        }
                                        ?>
                                        <td>
                                            <?php if($company->status == 'active'): ?>
                                                <span class="badge badge-success">
                                                    مفعل
                                                </span>
                                            <?php elseif($company->status == 'blocked'): ?>
                                                <span class="badge badge-danger">
                                                    معطل
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($company->notes); ?></td>
                                        <td><?php echo e(date('Y-m-d',strtotime($company->created_at))); ?></td>
                                        <?php if($company->id == 29): ?>
                                            <td colspan="2">غير مسموح</td>
                                        <?php else: ?>
                                            <td>
                                                <a href="<?php echo e(route('admin.companies.edit', $company->id)); ?>"
                                                   class="btn btn-sm btn-info" data-toggle="tooltip"
                                                   title="تعديل" data-placement="top"><i class="fa fa-edit"></i></a>
                                            </td>
                                            <td>
                                                <a class="modal-effect btn btn-sm btn-danger delete_company"
                                                   company_id="<?php echo e($company->id); ?>"
                                                   company_name="<?php echo e($company->company_name); ?>" data-toggle="modal"
                                                   href="#modaldemo9"
                                                   title="delete"><i
                                                        class="fa fa-trash"></i></a>
                                            </td>
                                        <?php endif; ?>

                                    </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="modaldemo9">
        <div class="modal-dialog modal-dialog-centered" company="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header text-center">
                    <h6 class="modal-title w-100" style="font-family: 'Cairo'; ">حذف شركة</h6>
                    <button aria-label="Close" class="close"
                            data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="<?php echo e(route('admin.companies.destroy', 'test')); ?>" method="post">
                    <?php echo e(method_field('delete')); ?>

                    <?php echo e(csrf_field()); ?>

                    <div class="modal-body">
                        <p>هل انت متأكد من الحذف ?</p><br>
                        <input type="hidden" name="companyid" id="companyid">
                        <input class="form-control" name="companyname" id="companyname" type="text" readonly>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                        <button type="submit" class="btn btn-danger">حذف</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<script src="<?php echo e(asset('app-assets/js/jquery.min.js')); ?>"></script>
<script>
    $(document).ready(function () {
        $('.delete_company').on('click', function () {
            var company_id = $(this).attr('company_id');
            var company_name = $(this).attr('company_name');
            $('.modal-body #companyid').val(company_id);
            $('.modal-body #companyname').val(company_name);
        });
        $('.company').on('click', function () {
            $('.clients').fadeOut(0);
            $(this).parent().find('.clients').fadeIn(0);
        });
    });
</script>

<?php echo $__env->make('admin.layouts.app-main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/elaraby_erp_new/resources/views/admin/companies/index.blade.php ENDPATH**/ ?>