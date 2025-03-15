<?php $__env->startSection('content'); ?>
    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissable fade show">
            <button class="close" data-dismiss="alert" aria-label="Close">×</button>
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>
    <!-- row opened -->
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="col-lg-12 margin-tb">
                        <a class="btn pull-left btn-primary btn-sm" href="<?php echo e(route('client.clients.create')); ?>">
                            <i class="fa fa-plus"></i> <?php echo e(__('sidebar.add-new-user')); ?> </a>
                        <h5 style="min-width: 300px;" class="pull-right alert alert-sm alert-success">
                            <?php echo e(__('sidebar.list-of-users')); ?></h5>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="card-body p-1 m-1">
                    <div class="table-responsive hoverable-table">
                        <table class="table table-striped table-bordered zero-configuration" id="example-table"
                            style="text-align: center;">
                            <thead>
                                <tr>
                                    <th class="wd-10p border-bottom-0 text-center">#</th>
                                    <th class="wd-15p border-bottom-0 text-center"><?php echo e(__('main.username')); ?></th>
                                    <th class="wd-20p border-bottom-0 text-center"><?php echo e(__('main.email')); ?></th>
                                    <th class="wd-15p border-bottom-0 text-center"><?php echo e(__('main.status')); ?></th>
                                    <th class="wd-15p border-bottom-0 text-center"><?php echo e(__('branches.branche-name')); ?></th>
                                    <th class="wd-15p border-bottom-0 text-center"><?php echo e(__('main.permission')); ?></th>
                                    <th class="wd-10p border-bottom-0 text-center"><?php echo e(__('main.control')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $i = 0;
                                ?>

                                <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e(++$i); ?></td>
                                        <td><?php echo e($client->name); ?></td>
                                        <td><?php echo e($client->email); ?></td>
                                        <td>
                                            <?php if($client->Status == 'active'): ?>
                                                <span class="badge badge-success">
                                                    <?php echo e(__('main.active')); ?>

                                                </span>
                                            <?php elseif($client->Status == 'blocked'): ?>
                                                <span class="badge badge-danger">
                                                    <?php echo e(__('main.deactive')); ?>

                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if($client->branch == ''): ?>
                                                غير محدد
                                            <?php else: ?>
                                                <?php echo e($client->branch->branch_name); ?>

                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if(!empty($client->getRoleNames())): ?>
                                                <?php $__currentLoopData = $client->getRoleNames(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <label class="badge badge-success"><?php echo e($v); ?></label>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="<?php echo e(route('client.clients.edit', $client->id)); ?>"
                                                class="btn btn-sm btn-info" data-toggle="tooltip" title="تعديل"
                                                data-placement="top"><i class="fa fa-edit"></i></a>
                                            <?php if(!in_array('مدير النظام', $client->role_name)): ?>
                                                <a class="modal-effect btn btn-sm btn-danger delete_client"
                                                    client_id="<?php echo e($client->id); ?>" email="<?php echo e($client->email); ?>"
                                                    data-toggle="modal" href="#modaldemo8" title="delete"><i
                                                        class="fa fa-trash"></i></a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!--/div-->

        <!-- Modal effects -->
        <div class="modal" id="modaldemo8">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header text-center">
                        <h6 class="modal-title w-100" style="font-family: 'Cairo'; "><?php echo e(__('main.delete')); ?></h6>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                    <form action="<?php echo e(route('client.clients.destroy', 'test')); ?>" method="post">
                        <?php echo e(method_field('delete')); ?>

                        <?php echo e(csrf_field()); ?>

                        <div class="modal-body">
                            <p><?php echo e(__('main.are-you-sure-to-delete')); ?></p><br>
                            <input type="hidden" name="client_id" id="client_id" value="">
                            <input class="form-control" name="email" id="email" type="text" readonly>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                data-dismiss="modal"><?php echo e(__('main.cancel')); ?></button>
                            <button type="submit" class="btn btn-danger"><?php echo e(__('main.delete')); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<script src="<?php echo e(asset('app-assets/js/jquery.min.js')); ?>"></script>
<script>
    $(document).ready(function() {
        $('.delete_client').on('click', function() {
            var client_id = $(this).attr('client_id');
            var email = $(this).attr('email');
            $('.modal-body #client_id').val(client_id);
            $('.modal-body #email').val(email);
        });
    });
</script>

<?php echo $__env->make('client.layouts.app-main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/elaraby_erp_new/resources/views/client/clients/index.blade.php ENDPATH**/ ?>