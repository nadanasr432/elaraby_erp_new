<?php $__env->startSection('content'); ?>
    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissable fade show text-center">
            <button class="close" data-dismiss="alert" aria-label="Close">×</button>
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>
    <div class="alert alert-success alert-dismissable text-center box_success d-none no-print">
        <button class="close" data-dismiss="alert" aria-label="Close">×</button>
        <span class="msg_success"></span>
    </div>

    <div class="alert alert-dark alert-dismissable text-center box_error d-none no-print">
        <button class="close" data-dismiss="alert" aria-label="Close">×</button>
        <span class="msg_error"></span>
    </div>
    <?php if(count($errors) > 0): ?>
        <div class="alert alert-dark no-print">
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
    <form id="myForm" target="_blank" action="#" method="POST">
        <?php echo csrf_field(); ?>
        <?php echo method_field('POST'); ?>
        <h6 class="alert alert-info alert-sm text-center no-print  font-weight-bold" dir="rtl"
            style="background-color: #d8daf5 !important; border:#d8daf5">
            <center>
                <?php echo e(__('sidebar.add-new-sales-invoice')); ?>

            </center>
        </h6>

        <div class="row">
            <!----DATE--->
            <div class="col-md-6 pull-right no-print">
                <div class="form-group" dir="rtl">
                    <label><?php echo e(__('sales_bills.invoice-date')); ?></label>
                    <span class="text-danger font-weight-bold">*</span>
                    <input type="date" required name="date" id="date" class="form-control"
                        value="<?php echo e(date('Y-m-d')); ?>" />
                </div>
            </div>

            <!----TIME--->
            <div class="col-md-6 pull-right no-print">
                <div class="form-group" dir="rtl">
                    <label><?php echo e(__('sales_bills.invoice-time')); ?></label>
                    <span class="text-danger font-weight-bold">*</span>
                    <input type="time" required name="time" id="time" class="form-control"
                        value="<?php echo e(date('H:i:s')); ?>" />
                </div>
            </div>
        </div>
        <div class="row">

            <!----CLIENT--->
            <div class="col-md-6 pull-right no-print">
                <label>
                    <?php echo e(__('sales_bills.client-name')); ?>

                    <span class="text-danger font-weight-bold">*</span>
                </label>
                <div class="d-flex align-items-center justify-content-between">
                    <select name="outer_client_id" id="outer_client_id" data-style="btn-new_color"
                        title="<?php echo e(__('sales_bills.client-name')); ?>" class="selectpicker w-100 me-2" data-live-search="true">
                        <?php $__currentLoopData = $outer_clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $outer_client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($outer_client->id); ?>"><?php echo e($outer_client->client_name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addClientModal">
                        <i class="fa fa-plus" aria-hidden="true"> </i> <?php echo e(__('main.add immediate client')); ?>

                    </button>
                </div>
            </div>
            <!----Store--->
            <div class="col-md-6 pull-right no-print">
                <label>
                    <?php echo e(__('sales_bills.select-store')); ?>

                    <span class="text-danger font-weight-bold">*</span>
                </label>
                <div class="d-flex justify-content-between">
                    <select name="store_id" id="store_id" class="selectpicker me-2" data-style="btn-new_color"
                        data-live-search="true" title="<?php echo e(__('sales_bills.select-store')); ?>">
                        <?php $__currentLoopData = $stores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($store->id); ?>" <?php echo e($index == 0 ? 'selected' : ''); ?>>
                                <?php echo e($store->store_name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <a target="_blank" href="<?php echo e(route('client.stores.create')); ?>" role="button" class="btn btn-primary">
                        <i class="fa fa-plus" aria-hidden="true"></i> <?php echo e(__('sales_bills.add-store')); ?>

                    </a>
                </div>
            </div>

        </div>
        <!--tax-->
        <div class="row mt-2">
            <!----->
            <div class="col-md-6 pull-right no-print">
                <label>
                    <?php echo e(__('sales_bills.product-code')); ?>

                    <span class="text-danger font-weight-bold">*</span>
                </label>
                <div class="d-flex align-items-center justify-content-between">
                  <select name="product_id" id="product_id" class="selectpicker w-50" data-style="btn-new_color"
                        data-live-search="true" title="<?php echo e(__('sales_bills.choose product')); ?>">
                        <?php $__currentLoopData = $all_products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($product->id); ?>" data-name="<?php echo e(strtolower($product->product_name)); ?>"
                                data-sectorprice="<?php echo e($product->sector_price); ?>"
                                data-wholesaleprice="<?php echo e($product->wholesale_price); ?>"
                                data-tokens="<?php echo e($product->code_universal); ?>"
                                data-remaining="<?php echo e($product->total_remaining); ?>"
                                data-categorytype="<?php echo e($product->category_type); ?>" data-unitid="<?php echo e($product->unit_id); ?>">
                                <?php echo e($product->product_name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <button type="button" class="btn btn-primary instantProduct">
                        <i class="fa fa-plus"></i> <?php echo e(__('main.add immediate product')); ?>

                    </button>
                </div>
            </div>

            <div class="col-md-6 pull-right no-print">
                <label for="value_added_tax"><?php echo e(__('sales_bills.prices-for-tax')); ?>

                    <span class="text-danger font-weight-bold">*</span>

                </label>

                <div class="d-flex align-items-center justify-content-between">
                    <select required name="value_added_tax" id="value_added_tax" class="selectpicker w-100"
                        data-style="btn-new_color" data-live-search="true">
                        <option value="0" selected>
                            <?php echo e(__('sales_bills.not-including-tax')); ?></option>
                        <option value="2">
                            <?php echo e(__('sales_bills.including-tax')); ?></option>
                        <option value="1">
                            <?php echo e(__('sales_bills.exempt-tax')); ?></option>
                    </select>
                </div>
            </div>
        </div>
        <div class="clearfix no-print"></div>

        <input type="number" id='grand_total_input' name="grand_total" hidden>
        <input type="number" id='grand_tax_input' name="grand_tax" hidden>
        <input type="number" id='grand_discount_input' name="total_discount" hidden>


        <div>
            <div class="table-responsive">
                <table class="table table-bordered mt-2" id="products_table"
                    style="background-color: #ffffff; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); border-radius: 5px;">
                    <thead>
                        <tr>
                            <th
                                style="background-color: #d8daf5; color: #333; text-align: center; padding: 10px; font-weight: bold;">
                                <?php echo e(__('sales_bills.product')); ?></th>
                            <th
                                style="background-color: #d8daf5; color: #333; text-align: center; padding: 10px; font-weight: bold;">
                                <?php echo e(__('sales_bills.price_type')); ?></th>
                            <th
                                style="background-color: #d8daf5; color: #333; text-align: center; padding: 10px; font-weight: bold;">
                                <?php echo e(__('sales_bills.price')); ?></th>
                            <th
                                style="background-color: #d8daf5; color: #333; text-align: center; padding: 10px; font-weight: bold;">
                                <?php echo e(__('sales_bills.quantity')); ?></th>
                            <th
                                style="background-color: #d8daf5; color: #333; text-align: center; padding: 10px; font-weight: bold;">
                                <?php echo e(__('sales_bills.unit')); ?></th>
                            <th
                                style="background-color: #d8daf5; color: #333; text-align: center; padding: 5px; font-weight: bold;">
                                <?php echo e(__('sales_bills.discount')); ?>

                                <div class="tax_discount"
                                    style="display: inline-block; margin-left: 10px; vertical-align: middle;">
                                    <select id="discount_application" class="form-control"
                                        style="font-size: 12px; height: 30px;" name="products_discount_type">
                                        <option value="before_tax"><?php echo e(__('sales_bills.discount_before_tax')); ?></option>
                                        <option value="after_tax"><?php echo e(__('sales_bills.discount_after_tax')); ?></option>
                                    </select>
                                </div>
                            </th>
                            <th
                                style="background-color: #d8daf5; color: #333; text-align: center; padding: 10px; font-weight: bold;">
                                <?php echo e(__('sales_bills.tax')); ?></th>
                            <th
                                style="background-color: #d8daf5; color: #333; text-align: center; padding: 10px; font-weight: bold;">
                                <?php echo e(__('sales_bills.total')); ?></th>
                            <th
                                style="background-color: #d8daf5; color: #333; text-align: center; padding: 10px; font-weight: bold;">
                                <?php echo e(__('sales_bills.actions')); ?></th>
                        </tr>
                    </thead>
                    <tbody style="text-align: center;">
                        <!-- هنا يتم عرض البيانات -->
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="6" style="background-color: #f9f9f9; font-weight: bold;">
                                <?php echo e(__('sales_bills.grand_tax')); ?></td>
                            <td colspan="3" id="grand_tax" class="text-right" style="background-color: #f9f9f9;">0.00
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6" style="background-color: #f9f9f9; font-weight: bold;">
                                <?php echo e(__('sales_bills.grand_total')); ?></td>
                            <td colspan="3" id="grand_total" class="text-right" style="background-color: #f9f9f9;">
                                0.00</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 pull-right">
                <div class="form-group" dir="rtl">
                    <label for="discount"><?php echo e(__('sales_bills.discount-on-the-total-bill')); ?></label> <br>
                    <select name="discount_type" id="discount_type" class="form-control"
                        style="width: 60%;display: inline;float: right; margin-left:5px;">
                        <option value="">اختر نوع الخصم</option>
                        <option value="pound">خصم قبل الضريبة (مسطح)</option>
                        <option value="percent">خصم قبل الضريبة (%)</option>
                        <option value="poundAfterTax">ضمان اعمال (مسطح)</option>
                        <option value="poundAfterTaxPercent">ضمان اعمال (%)</option>
                        <option value="afterTax" class="d-none">
                            خصم علي اجمالي المبلغ شامل الضريبة
                        </option>
                    </select>
                    <input type="number" value="0" name="discount_value" min="0"
                        style="width: 20%;display: inline;float: right;" id="discount_value" class="form-control "
                        step = "any" />
                    <input type="text" name="discount_note" id="discount_note" placeholder="ملاحظات الخصم. . ."
                        class="form-control mt-5" style="width: 80%;">
                    
                </div>


            </div>
            <div class="col-md-6 pull-right">
                <div class="form-group" dir="rtl">
                    <label for="extra"><?php echo e(__('main.shipping-expenses')); ?></label> <br>

                    <select name="extra_type" id="extra_type" class="form-control"
                        style="width:60%;display: inline;float: right;margin-left: 5px">
                        <option value="">اختر نوع الشحن</option>
                        <option value="pound"><?php echo e($extra_settings->currency); ?></option>
                        <option value="percent">%</option>
                    </select>
                    <input value="0" type="number" name="extra_value" min='0'
                        style="width: 20%;display: inline;float: right;" id="extra_value" class="form-control"
                        step = "any" />
                </div>
            </div>
        </div><!--  End Row -->
        <!-----notes------->
        <div class="col-sm-12 pull-right no-print">
            <div class="form-group" dir="rtl">
                <label for="time"><?php echo e(__('main.notes')); ?></label>
                <textarea name="main_notes" id="notes" class="summernotes">
                  </textarea>
                <a data-toggle="modal" data-target="#myModal3" class="btn btn-link add_extra_notes d-none"
                    style="color: blue!important;">
                    اضف ملاحظات اخرى
                </a>
            </div>
        </div>
        <div class="clearfix no-print"></div>

        <hr>
        </div>
        <div class="company_details printy" style="display: none;">
            <div class="text-center">
                <img class="logo" style="width: 20%;" src="<?php echo e(asset($company->company_logo)); ?>" alt="">
            </div>
            <div class="text-center">
                <div class="col-lg-12 text-center justify-content-center">
                    <p class="alert alert-info text-center alert-sm"
                        style="margin: 10px auto; font-size: 17px;line-height: 1.9;" dir="rtl">
                        <?php echo e($company->company_name); ?> -- <?php echo e($company->business_field); ?> <br>
                        <?php echo e($company->company_owner); ?> -- <?php echo e($company->phone_number); ?> <br>
                    </p>
                </div>
            </div>
        </div>

        <div class="col-lg-12 no-print text-center pt-3">
            <div class="d-flex justify-content-start align-items-center flex-nowrap"
                style="overflow-x: auto; white-space: nowrap;">
                <!-- Record Button -->
                <button type="button" data-toggle="modal" style="height: 40px" data-target="#myModal2"
                    class="btn btn-md btn-dark pay_btn m-1">
                    <i class="fa fa-money"></i> <?php echo e(__('main.record')); ?>

                </button>
                <button type="button" id="add" class="btn btn-info btn-md m-1" style="height: 40px">
                    <i class="fa fa-plus"></i> <?php echo e(__('sales_bills.save and show')); ?>

                </button>

                <!-- Save and Print 1 Button -->
                <button type="button" role="button" class="btn save_btn1 btn-md btn-info text-white m-1"
                    isMoswada="0" invoiceType="2" style="height: 40px">
                    حفظ و طباعة 1
                </button>

                <!-- Save and Print 2 Button -->
                <a href="javascript:;" role="button" class="btn save_btn2 btn-md m-1"
                    style="height: 40px; border: 1px solid #085d4a !important; background: #085d4a !important; color: white;"
                    printColor="1" isMoswada="0" invoiceType="2">
                    حفظ و طباعة 2
                </a>

                <!-- Save and Print 3 Button -->
                <a href="javascript:;" role="button" class="btn save_btn2 btn-md btn-primary m-1"
                    style="height: 40px; border: 1px solid #5e8b0b !important; background: #5e8b0b !important; color: white;"
                    printColor="2" isMoswada="0" invoiceType="4">
                    حفظ و طباعة 3
                </a>

                <!-- Save and Print 4 Button -->
                <a href="javascript:;" role="button" class="btn save_btn2 btn-md btn-primary pull-right m-1"
                    style="height: 40px; border: 1px solid #0bb3b3 !important; background: #0bb3b3 !important; color: white;"
                    printColor="3" isMoswada="0" invoiceType="5">
                    حفظ و طباعة 4
                </a>

                <!-- Save and Print 5 Button -->
                <a href="javascript:;" role="button" class="btn save_btn2 btn-md btn-primary pull-right m-1"
                    style="height: 40px;" printColor="2" isMoswada="0" invoiceType="2">
                    حفظ و طباعة 5
                </a>

                <!-- Save and Print 6 Button -->
                <a href="javascript:;" role="button" class="btn save_btn2 btn-md btn-primary pull-right m-1"
                    style="height: 40px; border: 1px solid #0b228b !important; background: #0b228b !important; color: white;"
                    printColor="2" isMoswada="0" invoiceType="6">
                    حفظ و طباعة 6
                </a>

                <!-- Save and Print 7 Button -->
                <a href="javascript:;" role="button" class="btn save_btn2 btn-md btn-primary pull-right m-1"
                    style="height: 40px; border: 1px solid #9b4aad !important; background: #9b4aad !important; color: white;"
                    printColor="2" isMoswada="0" invoiceType="7">
                    حفظ و طباعة 7
                </a>

                <!-- Save and Print 8 Button -->
                <a href="javascript:;" role="button" class="btn save_btn2 btn-md btn-primary pull-right m-1"
                    style="height: 40px; border: 1px solid #3d121264 !important; background: #3d121264 !important; color: white;"
                    printColor="2" isMoswada="0" invoiceType="8">
                    حفظ و طباعة 8
                </a>

                <!-- Draft Invoice Button -->
                <a href="javascript:;" role="button" class="btn save_btn2 btn-md btn-warning m-1" style="height: 40px;"
                    printColor="2" isMoswada="1" invoiceType="2">
                    فاتورة مسودة
                </a>

                <!-- Non-Tax Invoice Button -->
                <a href="javascript:;" role="button" class="btn save_btn2 btn-md btn-success m-1" style="height: 40px;"
                    printColor="2" isMoswada="0" invoiceType="3">
                    فاتورة غير ضريبية
                </a>
            </div>
        </div>
        <div class="modal fade" dir="rtl" id="myModal2" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel2">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header w-100">
                        <h4 class="modal-title text-center" id="myModalLabel2">دفع نقدى</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="company_id" value="<?php echo e($company_id); ?>">
                        <h5 class="col-lg-12 d-block mb-2"><?php echo e(__('main.main-information')); ?></h5>
                        <hr>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label> رقم العملية <span class="text-danger">*</span></label>
                                <input required readonly value="<?php echo e($pre_cash); ?>" class="form-control"
                                    id="cash_number" name="cash_number" type="text">
                            </div>
                            <div class="col-md-4">
                                <label> المبلغ المدفوع <span class="text-danger">*</span></label>
                                <input required class="form-control" name="amount" id="amount" type="text"
                                    dir="ltr">
                            </div>
                            <div class="col-md-4">
                                <label> طريقة الدفع <span class="text-danger">*</span></label>
                                <select required id="payment_method" name="payment_method" class="form-control">
                                    <option value="">اختر طريقة الدفع</option>
                                    <option value="cash">دفع كاش نقدى</option>
                                    <option value="bank">دفع بنكى شبكة</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3 cash" style="display: none;">
                            <div class="col-md-4">
                                <label> خزنة الدفع <span class="text-danger">*</span></label>
                                <select style="width: 80% !important; display: inline !important;" required id="safe_id"
                                    name="safe_id" class="form-control">
                                    <option value="">اختر خزنة الدفع</option>
                                    <?php $__currentLoopData = $safes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $safe): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($safe->id); ?>"><?php echo e($safe->safe_name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <a target="_blank" href="<?php echo e(route('client.safes.create')); ?>" role="button"
                                    style="width: 15%;display: inline;" class="btn btn-primary btn-danger open_popup">
                                    <i class="fa fa-plus"></i>
                                </a>
                            </div>
                        </div>
                        <div class="row mb-3 bank" style="display: none;">
                            <div class="col-md-4">
                                <label class="d-block"> البنك <span class="text-danger">*</span></label>
                                <select style="width: 80% !important; display: inline !important;" required id="bank_id"
                                    name="bank_id" class="form-control">
                                    <option value="">اختر البنك</option>
                                    <?php $__currentLoopData = $banks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($bank->id); ?>"><?php echo e($bank->bank_name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <a target="_blank" href="<?php echo e(route('client.banks.create')); ?>" role="button"
                                    style="width: 15%;display: inline;" class="btn btn-primary btn-danger open_popup">
                                    <i class="fa fa-plus"></i>
                                </a>
                            </div>
                            <div class="col-md-4">
                                <label for="">رقم المعاملة</label>
                                <input type="text" class="form-control" id="bank_check_number"
                                    name="bank_check_number" />
                            </div>
                            <div class="col-md-4">
                                <label for="">ملاحظات</label>
                                <input type="text" class="form-control" id="bank_notes" name="bank_notes" />
                            </div>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="client_name" id="client_name" />
                        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i>
                            اغلاق
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" dir="rtl" id="myModal3" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel3">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header w-100">
                        <h4 class="modal-title w-100 text-center" id="myModalLabel3">
                            ملاحظات على الفاتورة
                        </h4>
                    </div>
                    <div class="modal-body">
                        <form action="<?php echo e(route('save.notes')); ?>" method="post">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('POST'); ?>

                            <div class="notes">
                                <div class="col-lg-6 pull-right">
                                    <div class="form-group">
                                        <label class="d-block">
                                            الملاحظة رقم 1
                                        </label>
                                        <input type="text" class="form-control" name="notes[]" />
                                    </div>
                                </div>
                                <div class="col-lg-6 pull-right">
                                    <div class="form-group">
                                        <label class="d-block">
                                            الملاحظة رقم 2
                                        </label>
                                        <input type="text" class="form-control" name="notes[]" />
                                    </div>
                                </div>
                                <div class="col-lg-6 pull-right">
                                    <div class="form-group">
                                        <label class="d-block">
                                            الملاحظة رقم 3
                                        </label><input type="text" class="form-control" name="notes[]" />
                                    </div>
                                </div>
                                <div class="col-lg-6 pull-right">
                                    <div class="form-group">
                                        <label class="d-block">
                                            الملاحظة رقم 4
                                        </label>
                                        <input type="text" class="form-control" name="notes[]" />
                                    </div>
                                </div>
                                <div class="col-lg-6 pull-right">
                                    <div class="form-group">
                                        <label class="d-block">
                                            الملاحظة رقم 5
                                        </label><input type="text" class="form-control" name="notes[]" />
                                    </div>
                                </div>
                                <div class="col-lg-6 pull-right">
                                    <div class="form-group">
                                        <label class="d-block">
                                            الملاحظة رقم 6
                                        </label>
                                        <input type="text" class="form-control" name="notes[]" />
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button form="myForm" type="submit" class="btn btn-md btn-success">
                            <i class="fa fa-save"></i>
                            حفظ الملاحظات
                        </button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i>
                            اغلاق
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div class="modal fade" id="addClientModal" tabindex="-1" aria-labelledby="addClientModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="addClientForm" action="<?php echo e(route('client.outer_clients.storeApi')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="modal-header">
                        <h5 class="modal-title" id="addClientModalLabel"><?php echo e(__('sales_bills.add-client')); ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="client_name"><?php echo e(__('clients.client-name')); ?></label>
                            <input type="text" name="client_name" id="client_name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="phone"><?php echo e(__('clients.phone-with-code')); ?></label>
                            <input type="text" name="phones[]" id="phone" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label style="display: block" for="address"> <?php echo e(__('clients.client-address')); ?> </label>
                            <input type="text" name="addresses[]" class="form-control">

                            <div class="clearfix"></div>
                            <div class="dom3"></div>
                        </div>
                        <div class="form-group">
                            <label for="client_category"><?php echo e(__('clients.dealing-type')); ?></label>
                            <select name="client_category" class="form-control" required>
                                <option value=""><?php echo e(__('clients.choose-type')); ?></option>
                                <option selected value="جملة">جملة</option>
                                <option value="قطاعى">قطاعى</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="prev_balance"><?php echo e(__('clients.client-indebtedness')); ?></label>
                            <input style="margin-right:5px;margin-left:5px;" type="radio" value="for"
                                name="balance" />
                            <?php echo e(__('main.for')); ?>

                            <input style="margin-right:5px;margin-left:5px;" checked type="radio" value="on"
                                name="balance" /> <?php echo e(__('main.on')); ?>

                            <input required type="number" value="0" name="prev_balance" class="form-control"
                                step="1" dir="ltr" />
                            <input type="hidden" name="company_id" value="<?php echo e($company_id); ?>">
                        </div>
                        <div class="form-group">
                            <label for="tax_number"><?php echo e(__('main.tax-number')); ?></label>
                            <input type="text" name="tax_number" class="form-control" dir="ltr" />
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal"><?php echo e(__('main.close')); ?></button>
                        <button type="submit" class="btn btn-primary"><?php echo e(__('main.add')); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <input type="hidden" id="final_total" />
    <input type="hidden" id="product" placeholder="product" name="product" />
    <input type="hidden" id="net_total" placeholder="اجمالى قبل الخصم" name="total" />
    <input type="hidden" value="0" id="check" />
    <style>
        input {
            min-width: 100px;
        }

        select {
            min-width: 100px;
        }
    </style>
    <script src="<?php echo e(asset('app-assets/js/jquery.min.js')); ?>"></script>
    <script>
        var translations = {
            sector: "<?php echo e(__('sales_bills.sector')); ?>",
            wholesale: "<?php echo e(__('sales_bills.wholesale')); ?>",
            choose_unit: "<?php echo e(__('sales_bills.choose_unit')); ?>",
            pound: "<?php echo e(__('sales_bills.pound')); ?>",
            percent: "<?php echo e(__('sales_bills.percent')); ?>",
            include_tax: "<?php echo e(__('sales_bills.include_tax')); ?>",
            remove: "<?php echo e(__('sales_bills.remove')); ?>",
            max_quantity: "<?php echo e(__('sales_bills.max_quantity')); ?>",
            not_including_tax: "<?php echo e(__('sales_bills.not-including-tax')); ?>",
            including_tax: "<?php echo e(__('sales_bills.including-tax')); ?>",
            exempt_tax: "<?php echo e(__('sales_bills.exempt-tax')); ?>",
            enter_product_name: "<?php echo e(__('products.pname')); ?>",
            enter_product_price: "<?php echo e(__('products.sectorprice')); ?>",

        };
    </script>
    <script>
        var somethingChanged = false;
        $(document).ready(function() {
            $('.summernotes').summernote({
                height: 100,
                direction: 'rtl',
            });
        })
        //onsave btn حفظ الفاتورة
        $(document).ready(function() {
            $('#value_added_tax').on('change', function() {
                const newTaxType = $(this).val();

                // Show a SweetAlert confirmation dialog
                Swal.fire({
                    title: 'تأكيد التغيير',
                    text: 'سيتم تغيير نوع الضريبة لجميع العناصر في الجدول إلى القيمة المحددة. هل تريد المتابعة؟',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'نعم، تغيير',
                    cancelButtonText: 'إلغاء',
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Update all tax types in the table to match the selected value
                        $('#products_table tbody tr').each(function() {
                            $(this).find('select[name*="[tax]"]').val(newTaxType).trigger(
                                'change');
                        });

                        handleTaxCalculation(); // Recalculate taxes after the update
                        Swal.fire(
                            'تم التغيير!',
                            'تم تحديث نوع الضريبة بنجاح.',
                            'success'
                        );
                    } else {
                        // Reset the dropdown to its previous value
                        $(this).val($(this).data('previous-value'));
                    }
                });

                // Save the current value as previous for potential reset
                $(this).data('previous-value', newTaxType);
            });
          $('.save_btn1').on('click', function (e) {
    e.preventDefault(); // Prevent default form submission

    // Disable both buttons to prevent multiple clicks
    $('.save_btn1, .save_btn2').prop('disabled', true);

    const discountType = document.getElementById('discount_type').value;
    const discountValue = parseFloat(document.getElementById('discount_value').value) || 0;
    const grandTotal = parseFloat(document.getElementById('grand_total').textContent) || 0;

    if ((discountType === 'pound' || discountType === 'poundAfterTax') && discountValue > grandTotal + discountValue) {
        Swal.fire({
            icon: 'warning',
            title: 'تحذير',
            text: 'لا يمكن أن يكون الخصم أكبر من الإجمالي!',
            confirmButtonText: 'موافق'
        });
        $('.save_btn1, .save_btn2').prop('disabled', false); // Re-enable buttons
        return false;
    }

    let outerClientId = $('#outer_client_id').val();
    if (!outerClientId) {
        Swal.fire({
            icon: 'warning',
            title: 'تحذير',
            text: 'يجب اختيار العميل',
            confirmButtonText: 'موافق'
        });
        $('.save_btn1, .save_btn2').prop('disabled', false); // Re-enable buttons
        return false;
    }

    let hasProduct = false;
    $('#products_table tbody tr').each(function () {
        let quantity = $(this).find('input[name*="[quantity]"]').val();
        let price = $(this).find('input[name*="[product_price]"]').val();
        let unit = $(this).find('select[name*="[unit_id]"]').val();

        if (quantity > 0 && price > 0 && unit) {
            hasProduct = true;
        }
    });

    if (!hasProduct) {
        Swal.fire({
            icon: 'warning',
            title: 'تحذير',
            text: 'يجب اختيار منتج واحد على الأقل، وتحديد الكمية، والسعر، والوحدة لكل منتج',
            confirmButtonText: 'موافق'
        });
        $('.save_btn1, .save_btn2').prop('disabled', false); // Re-enable buttons
        return false;
    }

    var formData = $('#myForm').serialize();

    $.post("<?php echo e(url('/client/sale-bills/saveAll1')); ?>", formData)
        .done(function (data) {
            location.href = '/sale-bills/print/' + data;
        })
        .fail(function (jqXHR) {
            let errorMessage = "حدث خطأ أثناء حفظ البيانات";
            if (jqXHR.responseJSON) {
                errorMessage = jqXHR.responseJSON.message || jqXHR.responseJSON.error || errorMessage;
            } else if (jqXHR.responseText) {
                errorMessage = jqXHR.responseText;
            }

            Swal.fire({
                icon: 'error',
                title: errorMessage,
                text: '',
                confirmButtonText: 'إغلاق'
            });

            $('.save_btn1, .save_btn2').prop('disabled', false); // Re-enable buttons on error
        });
});

// Save button 2
$('.save_btn2').on('click', function (e) {
    e.preventDefault(); // Prevent default form submission

    // Disable both buttons to prevent multiple clicks
    $('.save_btn1, .save_btn2').prop('disabled', true);

    let printColor = $(this).attr('printColor');
    let isMoswada = $(this).attr('isMoswada');
    let invoiceType = $(this).attr('invoiceType');
    let outerClientId = $('#outer_client_id').val();

    const discountType = document.getElementById('discount_type').value;
    const discountValue = parseFloat(document.getElementById('discount_value').value) || 0;
    const grandTotal = parseFloat(document.getElementById('grand_total').textContent) || 0;

    if ((discountType === 'pound' || discountType === 'poundAfterTax') && discountValue > grandTotal + discountValue) {
        Swal.fire({
            icon: 'warning',
            title: 'تحذير',
            text: 'لا يمكن أن يكون الخصم أكبر من الإجمالي!',
            confirmButtonText: 'موافق'
        });
        $('.save_btn1, .save_btn2').prop('disabled', false); // Re-enable buttons
        return false;
    }

    if (!outerClientId) {
        Swal.fire({
            icon: 'warning',
            title: 'تحذير',
            text: 'يجب اختيار العميل',
            confirmButtonText: 'موافق'
        });
        $('.save_btn1, .save_btn2').prop('disabled', false); // Re-enable buttons
        return false;
    }

    let hasProduct = false;
    $('#products_table tbody tr').each(function () {
        let quantity = $(this).find('input[name*="[quantity]"]').val();
        let price = $(this).find('input[name*="[product_price]"]').val();
        let unit = $(this).find('select[name*="[unit_id]"]').val();

        if (quantity > 0 && price > 0 && unit) {
            hasProduct = true;
        }
    });

    if (!hasProduct) {
        Swal.fire({
            icon: 'warning',
            title: 'تحذير',
            text: 'يجب اختيار منتج واحد على الأقل، وتحديد الكمية، والسعر، والوحدة لكل منتج',
            confirmButtonText: 'موافق'
        });
        $('.save_btn1, .save_btn2').prop('disabled', false); // Re-enable buttons
        return false;
    }

    var formData = $('#myForm').serialize();

    $.post("<?php echo e(url('/client/sale-bills/saveAll1')); ?>", formData)
        .done(function (data) {
            location.href = '/sale-bills/print/' + data + '/' + invoiceType + '/' + printColor + '/' + isMoswada;
        })
        .fail(function (jqXHR) {
            let errorMessage = "حدث خطأ أثناء حفظ البيانات";
            if (jqXHR.responseJSON) {
                errorMessage = jqXHR.responseJSON.message || jqXHR.responseJSON.error || errorMessage;
            } else if (jqXHR.responseText) {
                errorMessage = jqXHR.responseText;
            }

            Swal.fire({
                icon: 'error',
                title: errorMessage,
                text: '',
                confirmButtonText: 'إغلاق'
            });

            $('.save_btn1, .save_btn2').prop('disabled', false); // Re-enable buttons on error
        });
});




            $('.pay_cash').on('click', function() {
                let company_id = $('#company_id').val();
                let outer_client_id = $('#outer_client_id').val();
                let sale_bill_number = $('#sale_bill_number').val();
                let date = $('#date').val();
                let time = $('#time').val()
                let cash_number = $('#cash_number').val();
                let amount = $('#amount').val();
                let safe_id = $('#safe_id').val();
                let bank_id = $('#bank_id').val();
                let bank_check_number = $('#bank_check_number').val();
                let notes = $('#bank_notes').val();
                let payment_method = $('#payment_method').val();
                if (payment_method == "cash" && safe_id == "") {
                    alert('اختر الخزنة اولا');
                } else if (payment_method == "bank" && bank_id == "") {
                    alert('اختر البنك اولا ');
                } else if (payment_method == "") {
                    alert('اختر طريقة الدفع اولا ');
                } else {
                    $.post("<?php echo e(route('client.store.cash.outerClients.SaleBill', 'test')); ?>", {
                        outer_client_id: outer_client_id,
                        company_id: company_id,
                        bill_id: sale_bill_number,
                        date: date,
                        time: time,
                        cash_number: cash_number,
                        amount: amount,
                        safe_id: safe_id,
                        bank_id: bank_id,
                        bank_check_number: bank_check_number,
                        notes: notes,
                        payment_method: payment_method,
                        "_token": "<?php echo e(csrf_token()); ?>"
                    }, function(data) {
                        if (data.status == true) {
                            $('<div class="alert alert-dark alert-sm"> ' + data.msg + '</div>')
                                .insertAfter(
                                    '#company_id');

                            $('.delete_pay').on('click', function() {
                                let payment_method = $(this).attr('payment_method');
                                let cash_id = $(this).attr('cash_id');
                                $.post("<?php echo e(route('sale_bills.pay.delete')); ?>", {
                                    '_token': "<?php echo e(csrf_token()); ?>",
                                    payment_method: payment_method,
                                    cash_id: cash_id,
                                }, function(data) {

                                });
                                $(this).parent().hide();

                            });
                            setTimeout(function() {
                                $('#myModal2').hide();
                                $('#myModal2').removeClass('show');
                                $('#myModal2').css('display', 'none')
                                $('body').removeClass('modal-open');
                                $('.modal-backdrop').remove();
                            }, 2000);

                        } else {
                            $('<br/><br/> <p class="alert alert-dark alert-sm"> ' + data.msg +
                                    '</p>')
                                .insertAfter('#company_id');
                        }
                    });
                }
            });
            $('.delete_pay').on('click', function() {
                let payment_method = $(this).attr('payment_method');
                let cash_id = $(this).attr('cash_id');
                $.post("<?php echo e(route('sale_bills.pay.delete')); ?>", {
                    '_token': "<?php echo e(csrf_token()); ?>",
                    payment_method: payment_method,
                    cash_id: cash_id,
                }, function(data) {

                });
                $(this).parent().parent().hide();

            });
            $('#outer_client_id').on('change', function() {
                let outer_client_id = $(this).val();
                if (outer_client_id != "") {
                    $('.outer_client_details').fadeIn(200);
                    $.post("<?php echo e(url('/client/sale-bills/getOuterClientDetails')); ?>", {
                        outer_client_id: outer_client_id,
                        "_token": "<?php echo e(csrf_token()); ?>"
                    }, function(data) {
                        $('#category').html(data.category);
                        $('#balance_before').html(data.balance_before);
                        $('#client_national').html(data.client_national);
                        $('#tax_number').html(data.tax_number);
                        $('#shop_name').html(data.shop_name);
                        $('#client_phone').html(data.client_phone);
                        $('#client_address').html(data.client_address);
                    });
                } else {
                    $('.outer_client_details').fadeOut(200);
                }
            });
            $('#store_id').on('change', function() {
                let store_id = $(this).val();
                if (store_id != "" || store_id != "0") {
                    $('.options').fadeIn(200);
                    $.post("<?php echo e(url('/client/sale-bills/getProducts')); ?>", {
                        store_id: store_id,
                        "_token": "<?php echo e(csrf_token()); ?>"
                    }, function(data) {
                        $('select#product_id').html(data);
                        $('select#product_id').selectpicker('refresh');
                    });
                } else {
                    $('.options').fadeOut(200);
                }
            });
            $('#product_id').on('change', function() {
                $('#sector').prop('checked', false);
                $('#quantity').val('');
                $('#quantity_price').val('');
                let sale_bill_number = $('#sale_bill_number').val();
                let product_id = $(this).val();
                $.post("<?php echo e(url('/client/sale-bills/get')); ?>", {
                    product_id: product_id,
                    sale_bill_number: sale_bill_number,
                    "_token": "<?php echo e(csrf_token()); ?>"
                }, function(data) {
                    $('#wholesale').prop('checked', true);
                    $('input#product_price').val(data.wholesale_price);
                    $('input#quantity_price').val(data.wholesale_price);
                    $('input#quantity').val("1");
                    $('select#unit_id').val(data.unit_id);
                    $('input#quantity').attr('max', data.first_balance);
                    $('.available').html('الكمية المتاحة : ' + data.first_balance);
                });
            });
            $('#wholesale').on('click', function() {
                let product_id = $('#product_id').val();
                $.post("<?php echo e(url('/client/sale-bills/get')); ?>", {
                    product_id: product_id,
                    "_token": "<?php echo e(csrf_token()); ?>"
                }, function(data) {
                    $('input#product_price').val(data.wholesale_price);
                    let quantity = $('#quantity').val();
                    let quantity_price = quantity * data.wholesale_price;
                    $('#quantity_price').val(quantity_price);
                });
            });
            $('#sector').on('click', function() {
                let product_id = $('#product_id').val();
                $.post("<?php echo e(url('/client/sale-bills/get')); ?>", {
                    product_id: product_id,
                    "_token": "<?php echo e(csrf_token()); ?>"
                }, function(data) {
                    $('input#product_price').val(data.sector_price);
                    let quantity = $('#quantity').val();
                    let quantity_price = quantity * data.sector_price;
                    $('#quantity_price').val(quantity_price);
                });
            });
            $('#quantity').on('keyup change', function() {
                let product_id = $('#product_id').val();
                let product_price = $('#product_price').val();
                let quantity = $(this).val();
                let quantity_price = quantity * product_price;
                $('#quantity_price').val(quantity_price);
            });
            $('#product_price').on('keyup change', function() {
                let product_id = $('#product_id').val();
                let product_price = $(this).val();
                let quantity = $('#quantity').val();
                let quantity_price = quantity * product_price;
                $('#quantity_price').val(quantity_price);
            });

        });

        $(document).ready(function() {
            $('#myModal2').on('hide.bs.modal', function(e) {
                let amount = $('#amount').val();

                // Check if #amount exists and has a value greater than 0
                if (amount && parseFloat(amount) > 0) {
                    let paymentMethod = $('#payment_method').val();
                    let safeId = $('#safe_id').val();
                    let bankId = $('#bank_id').val();

                    // Validate payment method based on the value of #amount
                    if (paymentMethod === "cash" && !safeId) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'تحذير',
                            text: 'اختر الخزنة اولا',
                            confirmButtonText: 'موافق'
                        });
                        e.preventDefault(); // Prevent the modal from closing
                    } else if (paymentMethod === "bank" && !bankId) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'تحذير',
                            text: 'اختر البنك اولا',
                            confirmButtonText: 'موافق'
                        });
                        e.preventDefault(); // Prevent the modal from closing
                    } else if (!paymentMethod) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'تحذير',
                            text: 'اختر طريقة الدفع اولا',
                            confirmButtonText: 'موافق'
                        });
                        e.preventDefault(); // Prevent the modal from closing
                    }
                }
            });

            $('#add').on('click', function(e) { // Add 'e' as the event parameter
                e.preventDefault(); // Prevent default form submission

                let outerClientId = $('#outer_client_id').val();

                const discountType = document.getElementById('discount_type').value;
                const discountValue = parseFloat(document.getElementById('discount_value').value) || 0;
                const grandTotal = parseFloat(document.getElementById('grand_total').textContent) || 0;

                // Check if discount exceeds grand total
                if (
                    (discountType === 'pound' || discountType === 'poundAfterTax') &&
                    discountValue > grandTotal + discountValue
                ) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'تحذير',
                        text: 'لا يمكن أن يكون الخصم أكبر من الإجمالي!',
                        confirmButtonText: 'موافق'
                    });
                    return false; // Stop submission
                }
                // Ensure discount is less than or equal to the grand total
                if (discountValue > grandTotal + discountValue) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'تحذير',
                        text: 'يجب أن يكون الخصم أقل أو مساوياً للإجمالي!',
                        confirmButtonText: 'موافق'
                    });
                    return false; // Stop submission
                }


                // Check if the outer client ID is selected
                if (!outerClientId) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'تحذير',
                        text: 'يجب اختيار العميل',
                        confirmButtonText: 'موافق'
                    });
                    return false;
                }

                // Validate that at least one product is selected
                let hasProduct = false;
                $('#products_table tbody tr').each(function() {
                    let quantity = $(this).find('input[name*="[quantity]"]').val();
                    let price = $(this).find('input[name*="[product_price]"]').val();
                    let unit = $(this).find('select[name*="[unit_id]"]').val();

                    if (quantity > 0 && price > 0 && unit) {
                        hasProduct = true;
                    }
                });

                if (!hasProduct) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'تحذير',
                        text: 'يجب اختيار منتج واحد على الأقل، وتحديد الكمية، والسعر، والوحدة لكل منتج',
                        confirmButtonText: 'موافق'
                    });
                    return false;
                }

                var formData = $('#myForm').serialize();
                console.log(formData);

                $.post("<?php echo e(url('/client/sale-bills/saveAll1')); ?>", formData)
                    .done(function(data) {
                        // Success handling
                        Swal.fire({
                            icon: 'success',
                            title: 'تم الحفظ بنجاح',
                            text: 'سيتم توجيهك إلى صفحة الطباعة',
                            confirmButtonText: 'حسنًا'
                        }).then(() => {
                            // Redirect to the print page
                            location.href = '/sale-bills/print/' + data;
                        });
                    })
                    .fail(function(jqXHR) {
                        // Default error message
                        let errorMessage = "حدث خطأ أثناء حفظ البيانات";

                        // Extract error message from response if available
                        if (jqXHR.responseJSON) {
                            if (jqXHR.responseJSON.message) {
                                errorMessage = jqXHR.responseJSON.message;
                            } else if (jqXHR.responseJSON.error) {
                                errorMessage = jqXHR.responseJSON.error;
                            }
                        } else if (jqXHR.responseText) {
                            errorMessage = jqXHR.responseText;
                        }

                        // Show error alert
                        Swal.fire({
                            icon: 'error',
                            title: errorMessage, // Use the extracted or default error message
                            text: '',
                            confirmButtonText: 'إغلاق'
                        });
                    });

            });


        });

        // apply discount //
        $('#exec_discount').on('click', function() {
            let sale_bill_number = $('#sale_bill_number').val();
            let discount_type = $('#discount_type').val();
            let discount_value = $('#discount_value').val();
            let discount_note = $('#discount_note').val();

            // apply discount //
            $.post("<?php echo e(url('/client/sale-bills/discount')); ?>", {
                "_token": "<?php echo e(csrf_token()); ?>",
                sale_bill_number: sale_bill_number,
                discount_type: discount_type,
                discount_value: discount_value,
                discount_note: discount_note
            }, function(data) {
                alert('تم تطبيق الخصم');
                $('.after_totals').html(data);
            });

            // refresh //
            $.post("<?php echo e(url('/client/sale-bills/refresh')); ?>", {
                "_token": "<?php echo e(csrf_token()); ?>",
                sale_bill_number: sale_bill_number,
            }, function(data) {
                $('#final_total').val(data.final_total);
            });
        });

        $('.pay_btn').on('click', function() {
            let final_total = $('#grand_total_input').val();
            $('#amount').val(final_total);
        })

        $('.edit_element').on('click', function() {
            let element_id = $(this).attr('element_id');
            let sale_bill_number = $(this).attr('sale_bill_number');

            $.post("<?php echo e(url('/client/sale-bills/edit-element')); ?>", {
                "_token": "<?php echo e(csrf_token()); ?>",
                sale_bill_number: sale_bill_number,
                element_id: element_id
            }, function(data) {
                $('#product_id').val(data.product_id);
                $('#product_id').selectpicker('refresh');
                $('#product_price').val(data.product_price);
                $('#unit_id').val(data.unit_id);
                $('#quantity').val(data.quantity);
                $('#quantity_price').val(data.quantity_price);
                let product_id = data.product_id;
                $.post("<?php echo e(url('/client/sale-bills/get-edit')); ?>", {
                    product_id: product_id,
                    sale_bill_number: sale_bill_number,
                    "_token": "<?php echo e(csrf_token()); ?>"
                }, function(data) {
                    $('input#quantity').attr('max', data.first_balance);
                    $('.available').html('الكمية المتاحة : ' + data.first_balance);
                });
                $('#add').hide();
                $('#edit').show();
                $('#edit').attr('element_id', element_id);
                $('#edit').attr('sale_bill_number', sale_bill_number);

            });
        });

        $('#edit').on('click', function() {
            let element_id = $(this).attr('element_id');
            let sale_bill_number = $(this).attr('sale_bill_number');

            let product_id = $('#product_id').val();
            let product_price = $('#product_price').val();
            let quantity = $('#quantity').val();
            let quantity_price = $('#quantity_price').val();
            let unit_id = $('#unit_id').val();

            let discount_type = $('#discount_type').val();
            let discount_value = $('#discount_value').val();
            let first_balance = parseFloat($('#quantity').attr('max'));
            let extra_type = $('#extra_type').val();
            let extra_value = $('#extra_value').val();
            let value_added_tax = $('#value_added_tax').val();
            if (!isNaN(first_balance)) {
                if (product_id == "" || product_id <= "0") {
                    alert("لابد ان تختار المنتج أولا");
                } else if (product_price == "" || product_price == "0") {
                    alert("لم يتم اختيار سعر المنتج");
                } else if (quantity == "" || quantity <= "0" || quantity > first_balance) {
                    alert("الكمية غير مناسبة");
                } else if (quantity_price == "" || quantity_price == "0") {
                    alert("الكمية غير مناسبة او الاجمالى غير صحيح");
                } else if (unit_id == "" || unit_id == "0") {
                    alert("اختر الوحدة");
                } else {
                    $.post('/client/sale-bills/element/update', {
                        '_token': "<?php echo e(csrf_token()); ?>",
                        element_id: element_id,
                        value_added_tax: value_added_tax,
                        product_id: product_id,
                        product_price: product_price,
                        quantity: quantity,
                        quantity_price: quantity_price,
                        unit_id: unit_id,
                    }, function(data) {
                        $.post('/client/sale-bills/elements', {
                            '_token': "<?php echo e(csrf_token()); ?>",
                            sale_bill_number: sale_bill_number
                        }, function(elements) {
                            $('.bill_details').html(elements);
                        });

                        $('#add').show();
                        $('#edit').hide();
                        $('#product_id').val('').trigger('change');
                        $('#unit_id').val('');
                        $('.available').html("");
                        $('#product_price').val('0');
                        $('#quantity').val('');
                        $('#quantity_price').val('');
                    });
                    $.post('/client/sale-bills/discount', {
                        '_token': "<?php echo e(csrf_token()); ?>",
                        sale_bill_number: sale_bill_number,
                        discount_type: discount_type,
                        discount_value: discount_value
                    }, function(data) {
                        alert('تم تطبيق الخصم');
                        $('.after_totals').html(data);
                    });

                    $.post('/client/sale-bills/extra', {
                        '_token': "<?php echo e(csrf_token()); ?>",
                        sale_bill_number: sale_bill_number,
                        extra_type: extra_type,
                        extra_value: extra_value
                    }, function(data) {
                        $('.after_totals').html(data);
                    });
                    $.post("<?php echo e(url('/client/sale-bills/refresh')); ?>", {
                        "_token": "<?php echo e(csrf_token()); ?>",
                        sale_bill_number: sale_bill_number,
                    }, function(data) {
                        $('#final_total').val(data.final_total);
                    });
                }
            } else {

                $.post('/client/sale-bills/element/update', {
                    '_token': "<?php echo e(csrf_token()); ?>",
                    element_id: element_id,
                    product_id: product_id,
                    value_added_tax: value_added_tax,
                    product_price: product_price,
                    quantity: quantity,
                    quantity_price: quantity_price,
                    unit_id: unit_id,
                }, function(data) {
                    $.post('/client/sale-bills/elements', {
                        '_token': "<?php echo e(csrf_token()); ?>",
                        sale_bill_number: sale_bill_number
                    }, function(elements) {
                        $('.bill_details').html(elements);
                    });
                    $('#add').show();
                    $('#edit').hide();
                    $('#product_id').val('').trigger('change');
                    $('#unit_id').val('');
                    $('.available').html("");
                    $('#product_price').val('0');
                    $('#quantity').val('');
                    $('#quantity_price').val('');
                });

                $.post('/client/sale-bills/discount', {
                    '_token': "<?php echo e(csrf_token()); ?>",
                    sale_bill_number: sale_bill_number,
                    discount_type: discount_type,
                    discount_value: discount_value
                }, function(data) {
                    alert('تم تطبيق الخصم');
                    $('.after_totals').html(data);
                });

                $.post('/client/sale-bills/extra', {
                    '_token': "<?php echo e(csrf_token()); ?>",
                    sale_bill_number: sale_bill_number,
                    extra_type: extra_type,
                    extra_value: extra_value
                }, function(data) {
                    $('.after_totals').html(data);
                });

                $.post("<?php echo e(url('/client/sale-bills/refresh')); ?>", {
                    "_token": "<?php echo e(csrf_token()); ?>",
                    sale_bill_number: sale_bill_number,
                }, function(data) {
                    $('#final_total').val(data.final_total);
                });
            }

        });

        $('.remove_element').on('click', function() {
            let element_id = $(this).attr('element_id');
            let sale_bill_number = $(this).attr('sale_bill_number');

            let discount_type = $('#discount_type').val();
            let discount_value = $('#discount_value').val();

            let extra_type = $('#extra_type').val();
            let extra_value = $('#extra_value').val();

            $.post('/client/sale-bills/element/delete', {
                '_token': "<?php echo e(csrf_token()); ?>",
                element_id: element_id
            }, function(data) {
                $.post('/client/sale-bills/elements', {
                    '_token': "<?php echo e(csrf_token()); ?>",
                    sale_bill_number: sale_bill_number
                }, function(elements) {
                    $('.bill_details').html(elements);
                });
            });

            $.post('/client/sale-bills/discount', {
                '_token': "<?php echo e(csrf_token()); ?>",
                sale_bill_number: sale_bill_number,
                discount_type: discount_type,
                discount_value: discount_value
            }, function(data) {
                $('.after_totals').html(data);
            });

            $.post('/client/sale-bills/extra', {
                '_token': "<?php echo e(csrf_token()); ?>",
                sale_bill_number: sale_bill_number,
                extra_type: extra_type,
                extra_value: extra_value
            }, function(data) {
                $('.after_totals').html(data);
            });

            $.post("<?php echo e(url('/client/sale-bills/refresh')); ?>", {
                "_token": "<?php echo e(csrf_token()); ?>",
                sale_bill_number: sale_bill_number,
            }, function(data) {
                $('#final_total').val(data.final_total);
            });

            $(this).parent().parent().fadeOut(300);
        });

        $('#exec_extra').on('click', function() {
            let sale_bill_number = $('#sale_bill_number').val();
            let extra_type = $('#extra_type').val();
            let extra_value = $('#extra_value').val();
            $.post("<?php echo e(url('/client/sale-bills/extra')); ?>", {
                "_token": "<?php echo e(csrf_token()); ?>",
                sale_bill_number: sale_bill_number,
                extra_type: extra_type,
                extra_value: extra_value
            }, function(data) {
                $('.after_totals').html(data);
            });

            $.post("<?php echo e(url('/client/sale-bills/refresh')); ?>", {
                "_token": "<?php echo e(csrf_token()); ?>",
                sale_bill_number: sale_bill_number,
            }, function(data) {
                $('#final_total').val(data.final_total);
            });
        });

        $('#payment_method').on('change', function() {
            let payment_method = $(this).val();
            if (payment_method == "cash") {
                $('.cash').show();
                $('.bank').hide();
            } else if (payment_method == "bank") {
                $('.bank').show();
                $('.cash').hide();
            } else {
                $('.bank').hide();
                $('.cash').hide();
            }
        });

        function checkChanges() {
            somethingChanged = true
        }

        document.getElementById('addClientForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const url = this.action;

            fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content'),
                        'Accept': 'application/json',
                    },
                    body: formData,
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Append the new client to the dropdown
                        const newOption = new Option(data.client.client_name, data.client.id, false, false);
                        document.getElementById('outer_client_id').add(newOption);

                        // Refresh the selectpicker (if using Bootstrap Select)
                        $('.selectpicker').selectpicker('refresh');

                        // Close the modal
                        $('#addClientModal').modal('hide');

                        // Optionally, display a success message
                        alert(data.message || '<?php echo e(__('main.client-added-successfully')); ?>');
                    } else {
                        alert(data.message || '<?php echo e(__('main.error-adding-client')); ?>');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('<?php echo e(__('main.error-adding-client')); ?>');
                });
        });

        window.addEventListener("pageshow", function(event) {
            var historyTraversal = event.persisted ||
                (typeof window.performance != "undefined" &&
                    window.performance.navigation.type === 2);
            if (historyTraversal) {
                // Handle page restore.
                window.location.reload();
            }
        });
        var rowIndex = 0;

        function addProductRow({
            productId,
            productName,
            sectorPrice,
            wholesalePrice,
            remaining,
            unitId,
            isImmediate = false
        }) {
            var valueAddedTax = $('#value_added_tax').val(); // Get the selected tax setting

            var rowHtml = `
            <tr data-product-id="${productId}" data-index="${rowIndex}">
                <td>${isImmediate ? `<input type="text" name="products[${rowIndex}][product_name]" class="form-control" placeholder="${translations.enter_product_name}" required>` : productName}</td>
                <td class="text-left">
                    <div class="d-flex flex-column">
                        <label class="form-check-inline">
                            <input type="radio" name="products[${rowIndex}][price_type]" value="sector" class="price_type form-check-input" checked>
                            ${translations.sector}
                        </label>
                        <label class="form-check-inline">
                            <input type="radio" name="products[${rowIndex}][price_type]" value="wholesale" class="price_type form-check-input">
                            ${translations.wholesale}
                        </label>
                    </div>
                </td>
                <td>
                    <div class="input-group">
                        <input type="number" min="1" name="products[${rowIndex}][product_price]" class="form-control price w-100" value="${sectorPrice}" step="any">
                        <input type="number" hidden name="products[${rowIndex}][product_id]" class="form-control product_id w-100" value="${productId}" >
                    </div>
                </td>
                <td>
                    <div class="input-group">
                        <input type="number" name="products[${rowIndex}][quantity]" class="form-control quantity w-100" value="1" min="1" max="${remaining}" step="any">
                    </div>
                </td>
                <td>
                    <div class="input-group">
                        <select name="products[${rowIndex}][unit_id]" class="form-control w-100 unit">
                            <option disabled>${translations.choose_unit}</option>
                            <?php $__currentLoopData = $units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                             <option value="<?php echo e($unit->id); ?>" ${unitId === <?php echo e($unit->id); ?> ? 'selected' : ''}><?php echo e($unit->unit_name); ?></option>
                                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </td>
                <td>
                    <div class="d-flex flex-column">
                        <label class="form-check-inline">
                            <input type="radio" name="products[${rowIndex}][discount_type]" value="pound" class="discount_type form-check-input">
                            ${translations.pound}
                        </label>
                        <label class="form-check-inline">
                            <input type="radio" name="products[${rowIndex}][discount_type]" value="percent" class="discount_type form-check-input" checked>
                            ${translations.percent}
                        </label>
                        <input type="number" name="products[${rowIndex}][discount]" class="form-control discount w-100 mt-1" value="0" min="0" step="any">
                    </div>
                </td>
                <td>
                    <div class="input-group">
                        <select name="products[${rowIndex}][tax]" class="form-control tax_type w-100 mb-1">
                            <option value="0" ${valueAddedTax == 0 ? 'selected' : ''}>${translations.not_including_tax}</option>
                            <option value="1" ${valueAddedTax == 1 ? 'selected' : ''}>${translations.exempt_tax}</option>
                            <option value="2" ${valueAddedTax == 2 ? 'selected' : ''}>${translations.including_tax}</option>
                        </select>
                        <input type="number" readonly name="products[${rowIndex}][tax_amount]" class="form-control tax_amount w-100 mt-1" value="0" min="0" step="any">

                    </div>
                </td>
                <td>
                    <input type="number" name="products[${rowIndex}][total]" class="form-control total w-100" value="0" readonly step="any">
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm remove-product">${translations.remove}</button>
                </td>
            </tr>
          `;

            $('#products_table tbody').append(rowHtml);
            rowIndex++;
        }

        function handleAddProductRow(event) {
            event.preventDefault();
            rowIndex = $('#products_table tbody tr').length;
            console.log(rowIndex);

            // Call the addProductRow function with the required parameters
            addProductRow({
                productId: `new-${rowIndex}`,
                productName: '',
                sectorPrice: 0,
                wholesalePrice: 0,
                remaining: 99999,
                unitId: 191,
                isImmediate: true
            });
        }

        function validateDiscount() {
            $('input[name^="products["][name$="[discount]"]').each(function() {
                var discountInput = $(this);
                var rowIndex = discountInput.attr('name').match(/\[(\d+)\]/)[1]; // Extract row index
                var discountType = $('input[name="products[' + rowIndex + '][discount_type]"]:checked')
                    .val();
                var discountValue = parseFloat(discountInput.val());

                if (discountType === 'percent' && discountValue > 100) {
                    alert('Discount cannot be more than 100% for percentage discount.');
                    discountInput.val(100); // Reset to maximum allowed value
                }
            });
        }

        function validateDiscountTotal() {
            var discountType = $('#discount_type').val(); // Get selected discount type
            var discountValue = parseFloat($('#discount_value').val()); // Get discount value

            // Check if discount type is percentage-based
            if ((discountType === 'percent' || discountType === 'poundAfterTaxPercent') && discountValue > 100) {
                alert('الخصم لا يمكن أن يكون أكثر من 100% لنوع الخصم المحدد.');
                $('#discount_value').val(100); // Reset discount value to 100
            }
        }

        // Attach validation to discount value input change
        $('#discount_value').on('input', function() {
            validateDiscount();
            validateDiscountTotal();
        });

        $(document).ready(function() {
            var rowIndex = 0;
            var roductPrice = 0;

            var taxRate = 0.15; // Tax rate of 15%
            function handleTaxCalculation(flag = 1) {

                $('#products_table tbody tr').each(function() {
                    var row = $(this);
                    var taxTypeSelect = row.find(`select[name="products[${row.data('index')}][tax]"]`);
                    var taxAmountField = row.find(
                        `input[name="products[${row.data('index')}][tax_amount]"]`);
                    var productPrice = parseFloat(row.find(
                        `input[name="products[${row.data('index')}][product_price]"]`).val()) || 0;
                    var quantity = parseFloat(row.find(
                        `input[name="products[${row.data('index')}][quantity]"]`).val()) || 0;
                    var taxType = taxTypeSelect.val();
                    var tax = 0;

                    switch (taxType) {
                        case "2": // Including tax

                            // Calculate the tax amount considering quantity
                            tax = (productPrice - (productPrice / (1 + taxRate))) * quantity;
                            console.log(taxAmountField);
                            taxAmountField.show().val(tax.toFixed(2));
                            break;
                        case "0": // Not including tax
                            tax = (productPrice * taxRate) *
                                quantity; // Calculate the tax amount considering quantity
                            taxAmountField.show().val(tax.toFixed(2));
                            break;
                        case "1": // Exempt from tax
                        default:
                            taxAmountField.show().val(0); // Set tax to 0 if exempt
                            break;
                    }

                    calculateRowTotal(row); // Recalculate the row total after updating the tax
                });

                calculateGrandTotal(); // Recalculate the grand total after updating all rows
            }

            function calculateRowTotal(row) {
                var taxType = row.find(`select[name="products[${row.data('index')}][tax]"]`)
                    .val(); // Get tax type for this row

                var quantity = parseFloat(row.find(`input[name="products[${row.data('index')}][quantity]"]`)
                    .val()) || 0;
                var price = parseFloat(row.find(`input[name="products[${row.data('index')}][product_price]"]`)
                    .val()) || 0;
                var discount = parseFloat(row.find(`input[name="products[${row.data('index')}][discount]"]`)
                    .val()) || 0;
                var discountType = row.find(`input[name="products[${row.data('index')}][discount_type]"]:checked`)
                    .val();
                var taxRate = 0.15; // 15% tax rate
                var discountApplication = $('#discount_application')
                    .val(); // whether discount is applied before or after tax

                var subtotal = quantity * price;
                var discountAmount = discountType === 'percent' ? (subtotal * discount / 100) : discount;

                var total;
                var taxValue = 0; // Default to no tax

                // If discount is applied before tax
                if (discountApplication === 'before_tax' && discount) {
                    // Subtotal after applying discount
                    var discountedSubtotal = subtotal - discountAmount;

                    // Apply tax based on tax type
                    if (taxType === "0") { // Not including tax
                        taxValue = discountedSubtotal * taxRate;
                        total = discountedSubtotal + taxValue;

                    } else if (taxType === "2") { // Including tax
                        // No additional tax, already included in price
                        taxValue = (price - (price / (1 + taxRate))) * quantity;
                        total = discountedSubtotal;

                        // taxValue = 0;
                    } else if (taxType === "1") { // Exempt from tax
                        taxValue = 0;
                        total = discountedSubtotal;

                    }


                } else { // If discount is applied after tax
                    // Apply tax based on the subtotal before discount
                    if (taxType === "0") { // Not including tax
                        taxValue = subtotal * taxRate;
                        total = subtotal + taxValue - discountAmount;

                    } else if (taxType === "2") { // Including tax
                        // No additional tax, already included in price
                        taxValue = (price - (price / (1 + taxRate))) * quantity;
                        total = subtotal - discountAmount;
                    } else if (taxType === "1") { // Exempt from tax
                        taxValue = 0;
                        total = subtotal + taxValue - discountAmount;

                    }

                    // Total after applying tax and then subtracting the discount
                }

                // Update row fields
                row.find(`input[name="products[${row.data('index')}][applied_discount]"]`).val(discountAmount
                    .toFixed(2));
                row.find(`input[name="products[${row.data('index')}][tax_amount]"]`).val(taxValue.toFixed(2));
                row.find(`input[name="products[${row.data('index')}][total]"]`).val(total.toFixed(2));

                calculateGrandTotal(); // Update the overall totals
            }



            function calculateGrandTotal() {
                var grandTotal = 0;
                var grandTotalWithoutChange = 0;
                var totalAppliedDiscount = 0;
                var totalDiscount = 0;
                var discount = 0;
                var grandTax = 0;
                var discountType = $('#discount_type').val();
                var discountValue = parseFloat($('#discount_value').val()) || 0;
                var extraType = $('#extra_type').val();
                var extraValue = parseFloat($('#extra_value').val()) || 0;

                $('#products_table tbody tr').each(function() {
                    var total = parseFloat($(this).find(
                        `input[name="products[${$(this).data('index')}][total]"]`).val()) || 0;
                    var appliedDiscount = parseFloat($(this).find(
                            `input[name="products[${$(this).data('index')}][applied_discount]"]`).val()) ||
                        0;
                    var totalWithoutChange = parseFloat($(this).find(
                        `input[name="products[${$(this).data('index')}][product_price]"]`).val()) || 0;

                    var taxAmount = parseFloat($(this).find(
                        `input[name="products[${$(this).data('index')}][tax_amount]"]`).val()) || 0;
                    grandTotal += total;
                    grandTotalWithoutChange += totalWithoutChange;
                    totalAppliedDiscount += appliedDiscount;
                    grandTax += taxAmount;
                });

                // Apply discount to grand total based on the selected option
                // var discount = 0;
                // Apply discount based on type
                // var oldgrandToatal = grandTotal;
                // var oldgrandTax = grandTax;
                var valueAddedTax = $('#value_added_tax').val(); // الحصول على إعداد الضريبة المختار

                var totalWithoutTax = grandTotal - grandTax;
                var taxRatio = valueAddedTax == 0 ? .15 : 0;
                if (discountType === 'pound') {
                    total = totalWithoutTax - discountValue;
                    // grandTax = total * taxRatio;
                    grandTotal = total + grandTax;
                } else if (discountType === 'percent') {
                    discountValue = (totalWithoutTax * discountValue / 100);
                    total = totalWithoutTax - discountValue;
                    // grandTax = total * taxRatio;
                    grandTotal = total + grandTax;
                }

                // Apply discounts after tax if specified
                if (discountType === 'poundAfterTax') {
                    grandTotal -= discountValue; // Apply flat discount after tax

                } else if (discountType === 'poundAfterTaxPercent') {
                    discountValue = (grandTotal * discountValue / 100);
                    grandTotal -= discountValue; // Apply percentage discount after tax
                }

                // Apply extra charges
                if (extraType === 'percent') {
                    grandTotal += (grandTotal * extraValue / 100); // Extra as percentage
                } else if (extraType === 'pound') {
                    grandTotal += extraValue; // Extra as fixed amount
                }

                // Total discount = row-level discounts + bill-level discounts
                totalDiscount = totalAppliedDiscount + discountValue;
                $('#grand_tax').text(grandTax.toFixed(2));
                $('#grand_total').text(grandTotal.toFixed(2));
                $('#grand_tax_input').val(grandTax.toFixed(2));
                $('#grand_total_input').val(grandTotal.toFixed(2));
                $('#grand_discount_input').val(totalDiscount.toFixed(2));
                $('#dicountForBill').text(discount);

            }

            function reindexRows() {
                $('#products_table tbody tr').each(function(index) {
                    $(this).data('index', index);
                    $(this).find('input, select').each(function() {
                        var name = $(this).attr('name');
                        if (name) {
                            var newName = name.replace(/\[\d+\]/, `[${index}]`);
                            $(this).attr('name', newName);
                        }
                    });
                });
                rowIndex = $('#products_table tbody tr').length;
            }

            $('#value_added_tax').on('change', function() {
                handleTaxCalculation();
            });



            $(document).ready(function() {
                var rowIndex = 0;

                // Handle product selection
                $('#product_id').on('change', function() {
                    var productId = $(this).val();
                    if (productId === 'new') {
                        addProductRow({
                            productId: `new-${rowIndex}`,
                            productName: '',
                            sectorPrice: 0,
                            wholesalePrice: 0,
                            remaining: 99999,
                            unitId: 191,
                            isImmediate: true
                        });
                        handleTaxCalculation();

                    } else {
                        var productId = $(this).val();
                        var productName = $('option:selected', this).data('name');
                        var sectorPrice = $('option:selected', this).data('sectorprice');
                        var wholesalePrice = $('option:selected', this).data('wholesaleprice');
                        var categoryType = $('option:selected', this).data('categorytype');
                        var unitId = $('option:selected', this).data('unitid') ||
                            191; // Default to 191 if null
                        var existingRow = $(
                            `#products_table tbody tr[data-product-id="${productId}"]`);
                        var remaining = categoryType !== "خدمية" ? $('option:selected', this).data(
                                'remaining') :
                            99999;
                        var valueAddedTax = $('#value_added_tax')
                            .val(); // الحصول على إعداد الضريبة المختار
                        $(this).val("");
                        if (existingRow.length > 0 && productId != 'new') {
                            var quantityInput = existingRow.find(
                                `input[name="products[${existingRow.data('index')}][quantity]"]`
                            );
                            var currentQuantity = parseFloat(quantityInput.val()) || 0;
                            var newQuantity = currentQuantity + 1;
                            if (categoryType !== "خدمية" && newQuantity > remaining) {
                                alert(`${translations.max_quantity} ${remaining}`);
                                newQuantity = remaining;
                            }

                            quantityInput.val(newQuantity);
                            calculateRowTotal(existingRow);
                        } else {
                            addProductRow({
                                productId,
                                productName,
                                sectorPrice,
                                wholesalePrice,
                                remaining,
                                unitId
                            });
                            handleTaxCalculation();

                        }
                    }
                    $(this).val(""); // Reset selection

                });

                // Handle "Add Product" button
                $('.instantProduct').on('click', function(e) {
                    rowIndex = $('#products_table tbody tr').length;
                    console.log('Row index:', rowIndex);

                    // Call the addProductRow function with the required parameters
                    addProductRow({
                        productId: `new-${rowIndex}`,
                        productName: '',
                        sectorPrice: 0,
                        wholesalePrice: 0,
                        remaining: 99999,
                        unitId: 191,
                        isImmediate: true
                    });
                });

                // Remove product row
                $('#products_table').on('click', '.remove-product', function() {
                    $(this).closest('tr').remove();
                });
            });


            $('#products_table').on('input', '.quantity', function() {
                var row = $(this).closest('tr');
                var maxQty = parseFloat($(this).attr('max')) || Infinity;

                if ($(this).val() > maxQty) {
                    alert(`Maximum available quantity is ${maxQty}`);
                    $(this).val(maxQty);
                }

                calculateRowTotal(row);
            });


            $('#products_table').on('input', '.quantity', function() {
                var row = $(this).closest('tr');
                var maxQty = parseFloat($(this).attr('max')) || Infinity;

                if ($(this).val() > maxQty) {
                    alert(`Maximum available quantity is ${maxQty}`);
                    $(this).val(maxQty);
                }

                calculateRowTotal(row);
            });


            $('#products_table').on('change', '.price_type', function() {
                var row = $(this).closest('tr');
                var productId = row.data('product-id');
                var selectedPriceType = $(this).val();
                var sectorPrice = $('option[value="' + productId + '"]').data('sectorprice');
                var wholesalePrice = $('option[value="' + productId + '"]').data('wholesaleprice');
                var selectedPrice = selectedPriceType === 'sector' ? sectorPrice : wholesalePrice;

                row.find(`input[name="products[${row.data('index')}][product_price]"]`).val(selectedPrice);
                handleTaxCalculation();
            });

            $('#products_table').on('input', '.price, .quantity, .discount, .tax_amount', function() {
                var row = $(this).closest('tr');
                validateDiscount();
                handleTaxCalculation();
            });

            $('#products_table').on('change', '.tax_type', function() {
                var row = $(this).closest('tr');
                var taxAmountField = row.find(`input[name="products[${row.data('index')}][tax_amount]"]`);
                if ($(this).is(':checked')) {
                    flag = 1;
                } else {
                    flag = 0;

                }
                handleTaxCalculation(flag);
            });

            $('#products_table').on('change', '.discount_type', function() {
                var row = $(this).closest('tr');
                calculateRowTotal(row);
            });

            $('#discount_application').on('change', function() {
                $('#products_table tbody tr').each(function() {
                    calculateRowTotal($(this));
                });
                calculateGrandTotal();
            });

            $('#discount_type, #discount_value').on('change', function() {
                validateDiscount();
                validateDiscountTotal();
                calculateGrandTotal();
            });

            $('#extra_type, #extra_value').on('change', function() {
                calculateGrandTotal();
            });

            $('#products_table').on('click', '.remove-product', function() {
                $(this).closest('tr').remove();
                calculateGrandTotal();
                reindexRows();
            });

            function reindexRows() {
                $('#products_table tbody tr').each(function(index) {
                    $(this).data('index', index);
                    $(this).find('input, select').each(function() {
                        var name = $(this).attr('name');
                        if (name) {
                            var newName = name.replace(/\[\d+\]/, `[${index}]`);
                            $(this).attr('name', newName);
                        }
                    });
                });
                rowIndex = $('#products_table tbody tr').length;
            }

            handleTaxCalculation(); // Initial call to set the correct tax logic
        });
     

    </script>
<!--    <script>-->
<!--   $(document).ready(function () {-->
<!--    function loadProducts(storeId) {-->
<!--        if (storeId) {-->
<!--            $.ajax({-->
<!--                url: "<?php echo e(route('get.store.products')); ?>",-->
<!--                type: "GET",-->
<!--                data: { store_id: storeId },-->
<!--                dataType: "json",-->
<!--                success: function (data) {-->
<!--                    let productDropdown = $('#product_id');-->
<!--                    productDropdown.empty();-->

<!--                    $.each(data, function (key, product) {-->
<!--                        productDropdown.append(`-->
<!--                            <option value="${product.id}" data-tokens="${product.code_universal}"-->
<!--                                product_name="${product.product_name}" product_price="${product.sector_price}">-->
<!--                                ${product.product_name}-->
<!--                            </option>-->
<!--                        `);-->
<!--                    });-->

                    $('.selectpicker').selectpicker('refresh'); // Refresh the dropdown
<!--                },-->
<!--                error: function (xhr) {-->
<!--                    console.log("Error:", xhr.responseText);-->
<!--                }-->
<!--            });-->
<!--        }-->
<!--    }-->

    // Load products for the first store on page load
<!--    let firstStoreId = $('#store_id').val();-->
<!--    loadProducts(firstStoreId);-->

    // Update products when the store changes
<!--    $('#store_id').on('change', function () {-->
<!--        let storeId = $(this).val();-->
<!--        loadProducts(storeId);-->
<!--    });-->
<!--});-->

<!--    </script>-->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('client.layouts.app-main1', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/elaraby_erp_new/resources/views/client/sale_bills1/create.blade.php ENDPATH**/ ?>