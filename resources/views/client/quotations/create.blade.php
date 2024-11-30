@extends('client.layouts.app-main1')


@section('content')

    @if (session('success'))
        <div class="alert alert-success alert-dismissable fade show text-center">
            <button class="close" data-dismiss="alert" aria-label="Close">×</button>
            {{ session('success') }}
        </div>
    @endif
    <div class="alert alert-success alert-dismissable text-center box_success d-none no-print">
        <button class="close" data-dismiss="alert" aria-label="Close">×</button>
        <span class="msg_success"></span>
    </div>

    <div class="alert alert-dark alert-dismissable text-center box_error d-none no-print">
        <button class="close" data-dismiss="alert" aria-label="Close">×</button>
        <span class="msg_error"></span>
    </div>
    @if (count($errors) > 0)
        <div class="alert alert-dark no-print">
            <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>الاخطاء :</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form id="myForm" target="_blank" action="#" method="POST">
        @csrf
        @method('POST')
        <h6 class="alert alert-info alert-sm text-center no-print  font-weight-bold" dir="rtl"
            style="background-color: #d8daf5 !important; border:#d8daf5">
            <center>
                {{ __('sidebar.addNewQuotation') }}
            </center>
        </h6>

        <div class="row">
            <!----DATE--->
            <div class="col-md-6 pull-right no-print">
                <div class="form-group" dir="rtl">
                    <label> {{ __('sales_bills.offer-start-date') }}
                    </label>
                    <span class="text-danger font-weight-bold">*</span>
                    <input type="date" name="start_date" class="form-control" value="{{ date('Y-m-d') }}"
                        id="start_date" />
                </div>
            </div>

            <!----TIME--->
            <div class="col-md-6 pull-right no-print">
                <div class="form-group" dir="rtl">
                    <label>{{ __('sales_bills.offer-end-date') }}</label>
                    <span class="text-danger font-weight-bold">*</span>
                    <input type="date" name="expiration_date" value="<?php echo date('Y-m-d'); ?>" id="expiration_date"
                        class="form-control" />
                </div>
            </div>
        </div>
        <!----Store--->
        <div class="row">
            <div class="col-md-6 pull-right no-print">
                <label>
                    {{ __('sales_bills.select-store') }}
                    <span class="text-danger font-weight-bold">*</span>
                </label>
                <div class="d-flex justify-content-between">
                    <select name="store_id" id="store_id" class="selectpicker me-2" data-style="btn-new_color"
                        data-live-search="true" title="{{ __('sales_bills.select-store') }}">
                        <?php $i = 0; ?>
                        @foreach ($stores as $store)
                            @if ($stores->count() == 1)
                                <option selected value="{{ $store->id }}">{{ $store->store_name }}</option>
                            @else
                                @if ($i == 0)
                                    <option selected value="{{ $store->id }}">{{ $store->store_name }}</option>
                                @else
                                    <option value="{{ $store->id }}">{{ $store->store_name }}</option>
                                @endif
                            @endif
                            <?php $i++; ?>
                        @endforeach
                    </select>
                    <a target="_blank" href="{{ route('client.stores.create') }}" role="button" class="btn btn-primary ">
                        <i class="fa fa-plus" aria-hidden="true"> </i>
                        {{ __('sales_bills.add-store') }}
                    </a>
                </div>
            </div>
            <!----CLIENT--->
            <div class="col-md-6 pull-right no-print">
                <label>
                    {{ __('sales_bills.client-name') }}
                    <span class="text-danger font-weight-bold">*</span>
                </label>
                <div class="d-flex align-items-center justify-content-between">
                    <select name="outer_client_id" id="outer_client_id" data-style="btn-new_color"
                        title="{{ __('sales_bills.client-name') }}" class="selectpicker w-100 me-2"
                        data-live-search="true">
                        @foreach ($outer_clients as $outer_client)
                            <option value="{{ $outer_client->id }}">{{ $outer_client->client_name }}</option>
                        @endforeach
                    </select>
                    <a target="_blank" href="{{ route('client.outer_clients.create') }}" role="button"
                        class="btn btn-primary">
                        <i class="fa fa-plus" aria-hidden="true"> </i> {{ __('sales_bills.add-client') }}
                    </a>
                </div>
            </div>
        </div>
        <!--tax-->
        <div class="row mt-2">
            <!----->
            <div class="col-md-6 pull-right no-print">
                <label>
                    {{ __('sales_bills.product-code') }}
                    <span class="text-danger font-weight-bold">*</span>
                </label>
                <div class="d-flex align-items-center justify-content-between">
                    <select name="product_id" id="product_id" class="selectpicker w-50" data-style="btn-new_color"
                        data-live-search="true" data-dropup-auto="false" title="{{ __('sales_bills.choose product') }}">
                        @foreach ($all_products as $product)
                            <option value="{{ $product->id }}" data-name="{{ strtolower($product->product_name) }}"
                                data-sectorprice="{{ $product->sector_price }}"
                                data-wholesaleprice="{{ $product->wholesale_price }}"
                                data-tokens="{{ $product->code_universal }}"
                                data-remaining="{{ $product->total_remaining }}"
                                data-categorytype="{{ $product->category_type }}" data-unitid="{{ $product->unit_id }}">
                                {{ $product->product_name }}
                            </option>
                        @endforeach
                    </select>
                    {{-- <select name="outer_client_id" id="outer_client_id" data-style="btn-new_color"
                    title="{{ __('sales_bills.client-name') }}" class="selectpicker w-100 me-2" data-live-search="true">
                    @foreach ($outer_clients as $outer_client)
                        <option value="{{ $outer_client->id }}">{{ $outer_client->client_name }}</option>
                    @endforeach
                </select> --}}
                    <a target="_blank" href="{{ route('client.products.create') }} }}" role="button"
                        class="btn btn-primary">
                        <i class="fa fa-plus" aria-hidden="true"> </i> {{ __('sales_bills.add-product') }}
                    </a>
                </div>
            </div>
            <div class="col-md-6 pull-right no-print">
                <label for="value_added_tax">{{ __('sales_bills.prices-for-tax') }}
                    <span class="text-danger font-weight-bold">*</span>

                </label>

                <div class="d-flex align-items-center justify-content-between">
                    <select required disabled name="value_added_tax" id="value_added_tax" class="selectpicker w-100"
                        data-style="btn-new_color" data-live-search="true">
                        <option value="0" selected>
                            {{ __('sales_bills.not-including-tax') }}</option>
                        <option value="2">
                            {{ __('sales_bills.including-tax') }}</option>
                        <option value="1">
                            {{ __('sales_bills.exempt-tax') }}</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="clearfix no-print"></div>

        <input type="number" id='grand_total_input' name="grand_total" hidden>
        <input type="number" id='grand_tax_input' name="grand_tax" hidden>
        <input type="number" id='grand_discount_input' name="total_discount" hidden>


        <div class="container">
            <div class="table-responsive">
                <table class="table table-bordered mt-2" id="products_table"
                    style="background-color: #ffffff; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); border-radius: 5px;">
                    <thead>
                        <tr>
                            <th
                                style="background-color: #d8daf5; color: #333; text-align: center; padding: 10px; font-weight: bold;">
                                {{ __('sales_bills.product') }}</th>
                            <th
                                style="background-color: #d8daf5; color: #333; text-align: center; padding: 10px; font-weight: bold;">
                                {{ __('sales_bills.price_type') }}</th>
                            <th
                                style="background-color: #d8daf5; color: #333; text-align: center; padding: 10px; font-weight: bold;">
                                {{ __('sales_bills.price') }}</th>
                            <th
                                style="background-color: #d8daf5; color: #333; text-align: center; padding: 10px; font-weight: bold;">
                                {{ __('sales_bills.quantity') }}</th>
                            <th
                                style="background-color: #d8daf5; color: #333; text-align: center; padding: 10px; font-weight: bold;">
                                {{ __('sales_bills.unit') }}</th>
                            {{-- <th
                                style="background-color: #d8daf5; color: #333; text-align: center; padding: 5px; font-weight: bold;">
                                {{ __('sales_bills.discount') }}
                                <div class="tax_discount"
                                    style="display: inline-block; margin-left: 10px; vertical-align: middle;">
                                    <select id="discount_application" class="form-control"
                                        style="font-size: 12px; height: 30px;" name="products_discount_type">
                                        <option value="before_tax">{{ __('sales_bills.discount_before_tax') }}</option>
                                        <option value="after_tax">{{ __('sales_bills.discount_after_tax') }}</option>
                                    </select>
                                </div>
                            </th> --}}
                            {{-- <th
                                style="background-color: #d8daf5; color: #333; text-align: center; padding: 10px; font-weight: bold;">
                                {{ __('sales_bills.tax') }}</th> --}}
                            <th
                                style="background-color: #d8daf5; color: #333; text-align: center; padding: 10px; font-weight: bold;">
                                {{ __('sales_bills.total') }}</th>
                            <th
                                style="background-color: #d8daf5; color: #333; text-align: center; padding: 10px; font-weight: bold;">
                                {{ __('sales_bills.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody style="text-align: center;">
                        <!-- هنا يتم عرض البيانات -->
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="6" style="background-color: #f9f9f9; font-weight: bold;">
                                {{ __('sales_bills.grand_tax') }}</td>
                            <td colspan="3" id="grand_tax" class="text-right" style="background-color: #f9f9f9;">0.00
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6" style="background-color: #f9f9f9; font-weight: bold;">
                                {{ __('sales_bills.grand_total') }}</td>
                            <td colspan="3" id="grand_total" class="text-right" style="background-color: #f9f9f9;">
                                0.00</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>




        {{-- <div class="row options no-print products">
            <div class="col-lg-3 pull-right">
                <label for=""> {{ __('sales_bills.product-code') }} </label>
               <select name="product_id" id="product_id" class="selectpicker w-80" data-style="btn-success"
                    data-live-search="true" title="{{ __('sales_bills.product-code') }}">

                    @foreach ($all_products as $product)
                        <option value="{{ $product->id }}" data-tokens="{{ $product->code_universal }}">
                            {{ $product->product_name }}</option>
                    @endforeach
                </select>
                <a target="_blank" href="{{ route('client.products.create') }}" role="button"
                   style="width: 15%;display: inline;" class="btn btn-primary btn-danger open_popup">
                    <i class="fa fa-plus"></i>
                </a>
                <div class="available text-center" style="color: #000; font-size: 14px; margin-top: 10px;"></div>

            </div>
            <!------PRICE------>
            <div class="col-lg-3 pull-right">
                <label for="">{{ __('sales_bills.product-price') }}</label>
                <input style="margin-right:5px;margin-left:5px;" type="radio" name="price" id="sector"/>
                {{ __('main.retail') }}
                <input style="margin-right:5px;margin-left:5px;" type="radio" name="price" id="wholesale"/>
                {{ __('main.wholesale') }}
                <input type="number" name="product_price" value="0"
                       @cannot('تعديل السعر في فاتورة البيع') readonly @endcan
                       id="product_price" class="form-control"/>
            </div>


            <!------UNIT------>
            <div class="col-lg-3 pull-right">
                <label class="d-block" for=""> {{ __('main.quantity') }} </label>
                <input type="number" name="quantity" id="quantity"
                       style="width: 50%;"
                       class="form-control d-inline float-left"/>

                <select style="width: 50%;" class="form-control d-inline float-right" name="unit_id" id="unit_id">
                    <option value="">{{ __('units.unit-name') }}</option>
                    @foreach ($units as $unit)
                        <option value="{{ $unit->id }}">{{ $unit->unit_name }}</option>
                    @endforeach
                </select>
            </div>

            <!------TOTAL------>
            <div class="col-lg-3 pull-right">
                <label for=""> {{ __('main.total') }} </label>
                <input type="number" name="quantity_price" readonly
                       id="quantity_price" class="form-control"/>
            </div>
        </div> --}}
        <div class="row">
            <div class="col-md-6 pull-right">
                <div class="form-group" dir="rtl">
                    <label for="discount">{{ __('sales_bills.discount-on-the-total-bill') }}</label> <br>
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
                    {{-- <span id="dicountForBill"></span> --}}
                </div>


            </div>
            <div class="col-md-6 pull-right">
                <div class="form-group" dir="rtl">
                    <label for="extra">{{ __('main.shipping-expenses') }}</label> <br>

                    <select name="extra_type" id="extra_type" class="form-control"
                        style="width:60%;display: inline;float: right;margin-left: 5px">
                        <option value="">اختر نوع الشحن</option>
                        <option value="pound">{{ $extra_settings->currency }}</option>
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
                <label for="time">{{ __('main.notes') }}</label>
                <textarea name="notes" id="notes" class="summernotes">
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
                <img class="logo" style="width: 20%;" src="{{ asset($company->company_logo) }}" alt="">
            </div>
            <div class="text-center">
                <div class="col-lg-12 text-center justify-content-center">
                    <p class="alert alert-info text-center alert-sm"
                        style="margin: 10px auto; font-size: 17px;line-height: 1.9;" dir="rtl">
                        {{ $company->company_name }} -- {{ $company->business_field }} <br>
                        {{ $company->company_owner }} -- {{ $company->phone_number }} <br>
                    </p>
                </div>
            </div>
        </div>

        <div class="col-lg-12 no-print text-center pt-3" style="overflow-x: auto">
            <div class="d-flex justify-content-center align-items-center flex-nowrap">
                <!-- Save and Print 1 Button -->
                <button type="button" role="button" class="btn save_btn1 btn-md btn-info text-white m-1"
                    isMoswada="0" invoiceType="2" style="height: 40px">
                    حفظ و طباعة
                </button>
                <button type="button" role="button" class="btn save_btn2 btn-md btn-success text-white m-1"
                    isMoswada="0" invoiceType="2" style="height: 40px">
                    حفظ و طباعة
                    2
                </button>


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
                        <form action="{{ route('save.notes') }}" method="post">
                            @csrf
                            @method('POST')

                            {{-- <div class="notes">
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
                            </div> --}}
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


    <input type="hidden" id="final_total" />
    <input type="hidden" id="product" placeholder="product" name="product" />
    <input type="hidden" id="net_total" placeholder="اجمالى قبل الخصم" name="total" />
    <input type="hidden" value="0" id="check" />
    <style>
        /* Limit the height of the dropdown and allow scrolling */
        .bootstrap-select .dropdown-menu.inner {
            max-height: 300px;
            /* Adjust based on preference */
            max-width: 500px;
            /* Adjust based on preference */
            overflow-y: auto;
            /* Enable scrolling */
        }

        /* Ensures dropdown position behaves naturally without overriding transforms */
        .bootstrap-select .dropdown-menu {
            position: absolute;
            will-change: unset !important;
            /* Remove will-change to prevent forced transforms */
            transform: none !important;
            /* Ensure transform isn't causing misalignment */
        }

        input {
            min-width: 100px;
        }

        select {
            min-width: 100px;
        }
    </style>
    <script src="{{ asset('app-assets/js/jquery.min.js') }}"></script>
    <script>
        var translations = {
            sector: "{{ __('sales_bills.sector') }}",
            wholesale: "{{ __('sales_bills.wholesale') }}",
            choose_unit: "{{ __('sales_bills.choose_unit') }}",
            pound: "{{ __('sales_bills.pound') }}",
            percent: "{{ __('sales_bills.percent') }}",
            include_tax: "{{ __('sales_bills.include_tax') }}",
            remove: "{{ __('sales_bills.remove') }}",
            max_quantity: "{{ __('sales_bills.max_quantity') }}",
            not_including_tax: "{{ __('sales_bills.not-including-tax') }}",
            including_tax: "{{ __('sales_bills.including-tax') }}",
            exempt_tax: "{{ __('sales_bills.exempt-tax') }}",
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
            // const discountType = document.getElementById('discount_type');
            // const discountValue = document.getElementById('discount_value');
            // const grandTotalElement = document.getElementById('grand_total');

            // if (discountValue && discountType && grandTotalElement) {
            //     discountValue.addEventListener('input', function() {
            //         const grandTotal = parseFloat(grandTotalElement.textContent) || 0;
            //         const discountTypeValue = discountType.value;

            //         if (
            //             (discountTypeValue === 'pound' || discountTypeValue === 'poundAfterTax') &&
            //             parseFloat(discountValue.value) > grandTotal
            //         ) {
            //             Swal.fire({
            //                 icon: 'warning',
            //                 title: 'تحذير',
            //                 text: 'لا يمكن أن يكون الخصم أكبر من الإجمالي!',
            //                 confirmButtonText: 'موافق'
            //             }).then(() => {
            //                 discountValue.value = 0; // Optionally reset the discount value
            //             });
            //         }
            //     });
            // }

            // Save button 1
            $('.save_btn1').on('click', function(e) {
                e.preventDefault(); // Prevent default form submission

                const discountType = document.getElementById('discount_type').value;
                const discountValue = parseFloat(document.getElementById('discount_value').value) || 0;
                const grandTotal = parseFloat(document.getElementById('grand_total').textContent) || 0;

                // Check if discount exceeds grand total
                if (
                    (discountType === 'pound' || discountType === 'poundAfterTax') &&
                    discountValue > grandTotal
                ) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'تحذير',
                        text: 'لا يمكن أن يكون الخصم أكبر من الإجمالي!',
                        confirmButtonText: 'موافق'
                    });
                    return false; // Stop submission
                }

                let outerClientId = $('#outer_client_id').val();

                // Validate outer client ID
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

                // Validate start_date and expiration_date
                let startDate = $('#start_date').val();
                let expirationDate = $('#expiration_date').val();

                if (new Date(startDate) > new Date(expirationDate)) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'تحذير',
                        text: 'تاريخ البداية يجب أن يكون قبل تاريخ الانتهاء',
                        confirmButtonText: 'موافق'
                    });
                    return false;
                }

                // Submit the form via AJAX
                let formData = $('#myForm').serialize();

                $.post("{{ route('client.quotations.redirectANDprint') }}", formData)
                    .done(function(data) {
                        location.href = '/client/quotations/view/' + data;
                    })
                    .fail(function(jqXHR) {
                        let errorMessage = "حدث خطأ أثناء حفظ البيانات";

                        if (jqXHR.responseJSON) {
                            if (jqXHR.responseJSON.message) {
                                errorMessage = jqXHR.responseJSON.message;
                            } else if (jqXHR.responseJSON.error) {
                                errorMessage = jqXHR.responseJSON.error;
                            }
                        } else if (jqXHR.responseText) {
                            errorMessage = jqXHR.responseText;
                        }

                        Swal.fire({
                            icon: 'error',
                            title: errorMessage,
                            text: '',
                            confirmButtonText: 'إغلاق'
                        });
                    });
            });
            // Save button 2
            $('.save_btn2').on('click', function() {
                let outerClientId = $('#outer_client_id').val();
                const discountType = document.getElementById('discount_type').value;
                const discountValue = parseFloat(document.getElementById('discount_value').value) || 0;
                const grandTotal = parseFloat(document.getElementById('grand_total').textContent) || 0;

                // Check if discount exceeds grand total
                if (
                    (discountType === 'pound' || discountType === 'poundAfterTax') &&
                    discountValue > grandTotal
                ) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'تحذير',
                        text: 'لا يمكن أن يكون الخصم أكبر من الإجمالي!',
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
                // Check if start_date is before expiration_date
                let startDate = $('#start_date').val();
                let expirationDate = $('#expiration_date').val();

                if (new Date(startDate) > new Date(expirationDate)) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'تحذير',
                        text: 'تاريخ البداية يجب أن يكون قبل تاريخ الانتهاء',
                        confirmButtonText: 'موافق'
                    });
                    return false;
                }


                var formData = $('#myForm').serialize();

                $.post("{{ route('client.quotations.redirectANDprint2') }} ", formData)
                    .done(function(data) {
                        location.href = '/client/quotations/print/' + data;
                    })
                    .fail(function(jqXHR) {
                        // Check if responseJSON exists and try to extract message
                        let errorMessage = "حدث خطأ أثناء حفظ البيانات";

                        if (jqXHR.responseJSON) {
                            if (jqXHR.responseJSON.message) {
                                errorMessage = jqXHR.responseJSON.message;
                            } else if (jqXHR.responseJSON.error) {
                                errorMessage = jqXHR.responseJSON.error;
                            }
                        } else if (jqXHR.responseText) {
                            errorMessage = jqXHR.responseText;
                        }

                        Swal.fire({
                            icon: 'error',
                            title: errorMessage, // Replace title with the error message
                            text: '',
                            confirmButtonText: 'إغلاق'
                        });
                    });
            });
            // $('.save_btn2').on('click', function() {
            //     let printColor = $(this).attr('printColor');
            //     let isMoswada = $(this).attr('isMoswada');
            //     let invoiceType = $(this).attr('invoiceType');
            //     let outerClientId = $('#outer_client_id').val();

            //     // Check if the outer client ID is selected
            //     if (!outerClientId) {
            //         Swal.fire({
            //             icon: 'warning',
            //             title: 'تحذير',
            //             text: 'يجب اختيار العميل',
            //             confirmButtonText: 'موافق'
            //         });
            //         return false;
            //     }

            //     // Validate that at least one product is selected
            //     let hasProduct = false;
            //     $('#products_table tbody tr').each(function() {
            //         let quantity = $(this).find('input[name*="[quantity]"]').val();
            //         let price = $(this).find('input[name*="[product_price]"]').val();
            //         let unit = $(this).find('select[name*="[unit_id]"]').val();

            //         if (quantity > 0 && price > 0 && unit) {
            //             hasProduct = true;
            //         }
            //     });

            //     if (!hasProduct) {
            //         Swal.fire({
            //             icon: 'warning',
            //             title: 'تحذير',
            //             text: 'يجب اختيار منتج واحد على الأقل، وتحديد الكمية، والسعر، والوحدة لكل منتج',
            //             confirmButtonText: 'موافق'
            //         });
            //         return false;
            //     }

            //     var formData = $('#myForm').serialize();

            //     $.post("{{ url('/client/sale-bills/saveAll1') }}", formData)
            //         .done(function(data) {
            //             location.href = '/client/quotations/view/' + data;
            //         })
            //         .fail(function(jqXHR) {
            //             // Check if responseJSON exists and try to extract message
            //             let errorMessage = "حدث خطأ أثناء حفظ البيانات";

            //             if (jqXHR.responseJSON) {
            //                 if (jqXHR.responseJSON.message) {
            //                     errorMessage = jqXHR.responseJSON.message;
            //                 } else if (jqXHR.responseJSON.error) {
            //                     errorMessage = jqXHR.responseJSON.error;
            //                 }
            //             } else if (jqXHR.responseText) {
            //                 errorMessage = jqXHR.responseText;
            //             }

            //             Swal.fire({
            //                 icon: 'error',
            //                 title: errorMessage, // Replace title with the error message
            //                 text: '',
            //                 confirmButtonText: 'إغلاق'
            //             });
            //         });
            // });



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
                    $.post("{{ route('client.store.cash.outerClients.SaleBill', 'test') }}", {
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
                        "_token": "{{ csrf_token() }}"
                    }, function(data) {
                        if (data.status == true) {
                            $('<div class="alert alert-dark alert-sm"> ' + data.msg + '</div>')
                                .insertAfter(
                                    '#company_id');

                            $('.delete_pay').on('click', function() {
                                let payment_method = $(this).attr('payment_method');
                                let cash_id = $(this).attr('cash_id');
                                $.post("{{ route('sale_bills.pay.delete') }}", {
                                    '_token': "{{ csrf_token() }}",
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
                $.post("{{ route('sale_bills.pay.delete') }}", {
                    '_token': "{{ csrf_token() }}",
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
                    $.post("{{ url('/client/sale-bills/getOuterClientDetails') }}", {
                        outer_client_id: outer_client_id,
                        "_token": "{{ csrf_token() }}"
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
                    $.post("{{ url('/client/sale-bills/getProducts') }}", {
                        store_id: store_id,
                        "_token": "{{ csrf_token() }}"
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
                $.post("{{ url('/client/sale-bills/get') }}", {
                    product_id: product_id,
                    sale_bill_number: sale_bill_number,
                    "_token": "{{ csrf_token() }}"
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
                $.post("{{ url('/client/sale-bills/get') }}", {
                    product_id: product_id,
                    "_token": "{{ csrf_token() }}"
                }, function(data) {
                    $('input#product_price').val(data.wholesale_price);
                    let quantity = $('#quantity').val();
                    let quantity_price = quantity * data.wholesale_price;
                    $('#quantity_price').val(quantity_price);
                });
            });
            $('#sector').on('click', function() {
                let product_id = $('#product_id').val();
                $.post("{{ url('/client/sale-bills/get') }}", {
                    product_id: product_id,
                    "_token": "{{ csrf_token() }}"
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

        //add-new-sale-bill button --- اضافة فاتورة بيع جديدة.
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

            $('#add').on('click', function() {
                let outerClientId = $('#outer_client_id').val();

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
                $.post("{{ url('/client/sale-bills/post1') }}", formData, function(data) {
                    //     $('#outer_client_id').attr('disabled', true).addClass('disabled');
                    //     $('#product_id').val('').trigger('change');
                    //     $('#unit_id').val('');
                    //     $('#discount_type').attr('disabled', false);
                    //     $('.print_btn').removeClass('disabled');
                    //     $('.pay_btn').attr('disabled', false);
                    //     $('.close_btn').attr('disabled', false);
                    //     $('.save_btn1').removeClass('disabled');
                    //     $('.save_btn2').removeClass('disabled');
                    //     $('.send_btn').removeClass('disabled');
                    //     $('.add_extra_notes').removeClass('disabled');
                    //     $('#discount_value').attr('disabled', false);
                    //     $('#exec_discount').attr('disabled', false);
                    //     $('#extra_type').attr('disabled', false);
                    //     $('#extra_value').attr('disabled', false);
                    //     $('#exec_extra').attr('disabled', false);
                    //     $('#value_added_tax').attr('disabled', true).addClass('disabled');
                    //     $('.available').html("");
                    //     $('#product_price').val('0');
                    //     $('#quantity').val('');
                    //     $('#quantity_price').val('');

                    if (data.status === true) {
                        //-----show success msg.------//
                        $('.box_success').removeClass('d-none').fadeIn(200);
                        $('.msg_success').html(data.msg);
                        $('.box_success').delay(3000).fadeOut(300);
                        window.location.href = `/client/sale-bill1/${data.id}`;
                    } else {
                        $('.box_error').removeClass('d-none').fadeIn(200);
                        $('.msg_error').html(data.msg);
                        $('.box_error').delay(3000).fadeOut(300);
                    }
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
            $.post("{{ url('/client/sale-bills/discount') }}", {
                "_token": "{{ csrf_token() }}",
                sale_bill_number: sale_bill_number,
                discount_type: discount_type,
                discount_value: discount_value,
                discount_note: discount_note
            }, function(data) {
                alert('تم تطبيق الخصم');
                $('.after_totals').html(data);
            });

            // refresh //
            $.post("{{ url('/client/sale-bills/refresh') }}", {
                "_token": "{{ csrf_token() }}",
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

            $.post("{{ url('/client/sale-bills/edit-element') }}", {
                "_token": "{{ csrf_token() }}",
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
                $.post("{{ url('/client/sale-bills/get-edit') }}", {
                    product_id: product_id,
                    sale_bill_number: sale_bill_number,
                    "_token": "{{ csrf_token() }}"
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
                        '_token': "{{ csrf_token() }}",
                        element_id: element_id,
                        value_added_tax: value_added_tax,
                        product_id: product_id,
                        product_price: product_price,
                        quantity: quantity,
                        quantity_price: quantity_price,
                        unit_id: unit_id,
                    }, function(data) {
                        $.post('/client/sale-bills/elements', {
                            '_token': "{{ csrf_token() }}",
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
                        '_token': "{{ csrf_token() }}",
                        sale_bill_number: sale_bill_number,
                        discount_type: discount_type,
                        discount_value: discount_value
                    }, function(data) {
                        alert('تم تطبيق الخصم');
                        $('.after_totals').html(data);
                    });

                    $.post('/client/sale-bills/extra', {
                        '_token': "{{ csrf_token() }}",
                        sale_bill_number: sale_bill_number,
                        extra_type: extra_type,
                        extra_value: extra_value
                    }, function(data) {
                        $('.after_totals').html(data);
                    });
                    $.post("{{ url('/client/sale-bills/refresh') }}", {
                        "_token": "{{ csrf_token() }}",
                        sale_bill_number: sale_bill_number,
                    }, function(data) {
                        $('#final_total').val(data.final_total);
                    });
                }
            } else {

                $.post('/client/sale-bills/element/update', {
                    '_token': "{{ csrf_token() }}",
                    element_id: element_id,
                    product_id: product_id,
                    value_added_tax: value_added_tax,
                    product_price: product_price,
                    quantity: quantity,
                    quantity_price: quantity_price,
                    unit_id: unit_id,
                }, function(data) {
                    $.post('/client/sale-bills/elements', {
                        '_token': "{{ csrf_token() }}",
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
                    '_token': "{{ csrf_token() }}",
                    sale_bill_number: sale_bill_number,
                    discount_type: discount_type,
                    discount_value: discount_value
                }, function(data) {
                    alert('تم تطبيق الخصم');
                    $('.after_totals').html(data);
                });

                $.post('/client/sale-bills/extra', {
                    '_token': "{{ csrf_token() }}",
                    sale_bill_number: sale_bill_number,
                    extra_type: extra_type,
                    extra_value: extra_value
                }, function(data) {
                    $('.after_totals').html(data);
                });

                $.post("{{ url('/client/sale-bills/refresh') }}", {
                    "_token": "{{ csrf_token() }}",
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
                '_token': "{{ csrf_token() }}",
                element_id: element_id
            }, function(data) {
                $.post('/client/sale-bills/elements', {
                    '_token': "{{ csrf_token() }}",
                    sale_bill_number: sale_bill_number
                }, function(elements) {
                    $('.bill_details').html(elements);
                });
            });

            $.post('/client/sale-bills/discount', {
                '_token': "{{ csrf_token() }}",
                sale_bill_number: sale_bill_number,
                discount_type: discount_type,
                discount_value: discount_value
            }, function(data) {
                $('.after_totals').html(data);
            });

            $.post('/client/sale-bills/extra', {
                '_token': "{{ csrf_token() }}",
                sale_bill_number: sale_bill_number,
                extra_type: extra_type,
                extra_value: extra_value
            }, function(data) {
                $('.after_totals').html(data);
            });

            $.post("{{ url('/client/sale-bills/refresh') }}", {
                "_token": "{{ csrf_token() }}",
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
            $.post("{{ url('/client/sale-bills/extra') }}", {
                "_token": "{{ csrf_token() }}",
                sale_bill_number: sale_bill_number,
                extra_type: extra_type,
                extra_value: extra_value
            }, function(data) {
                $('.after_totals').html(data);
            });

            $.post("{{ url('/client/sale-bills/refresh') }}", {
                "_token": "{{ csrf_token() }}",
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


        window.addEventListener("pageshow", function(event) {
            var historyTraversal = event.persisted ||
                (typeof window.performance != "undefined" &&
                    window.performance.navigation.type === 2);
            if (historyTraversal) {
                // Handle page restore.
                window.location.reload();
            }
        });

        $(document).ready(function() {
            var rowIndex = 0;
            var roductPrice = 0;
            $('.selectpicker').selectpicker({
                liveSearch: true,
                dropupAuto: false,
                // container: 'body'
            });

            function handleTaxCalculation(flag = 1) {
                var taxRate = 0.15; // Tax rate of 15%

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
                            tax = (productPrice - (productPrice / (1 + taxRate))) *
                                quantity; // Calculate the tax amount considering quantity
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
                var taxValue = parseFloat(row.find(`input[name="products[${row.data('index')}][tax_amount]"]`)
                    .val()) || 0;
                var discountApplication = $('#discount_application').val();

                var subtotal = quantity * price;
                // var subtotalForDiscount = discountApplication === 'before_tax' ? subtotal - taxValue : subtotal;
                if (taxType === "0") { // not include
                    var subtotalForDiscount = discountApplication === 'before_tax' ? subtotal : subtotal + taxValue;
                } else {
                    var subtotalForDiscount = discountApplication === 'before_tax' ? subtotal - taxValue : subtotal;

                }

                var discountAmount = discountType === 'percent' ? (subtotalForDiscount * discount / 100) : discount;
                var total = subtotal - discountAmount;

                // Adjust the total based on tax type in the row
                if (taxType === "2") { // Including tax
                    // The tax is included in the price, so no need to adjust the total
                    total = subtotal - discountAmount; // Total remains as calculated without adding tax
                } else if (taxType === "0") { // Not including tax
                    total += taxValue; // Add tax value to the total
                } else if (taxType === "1") { // Exempt tax
                    // Tax is exempt, no adjustment needed
                }

                // Update the row with calculated values
                row.find(`input[name="products[${row.data('index')}][applied_discount]"]`).val(discountAmount
                    .toFixed(2));
                row.find(`input[name="products[${row.data('index')}][tax_amount]"]`).val(taxValue.toFixed(2));
                row.find(`input[name="products[${row.data('index')}][total]"]`).val(total.toFixed(2));

                // Recalculate the grand total
                calculateGrandTotal();
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
                // var discountApplication = $('#discount_application').val();
                // if (discountApplication === 'before_tax') {
                if (discountType === 'pound' || discountType === 'poundAfterTax' || discountType ===
                    'poundAfterTaxPercent') {
                    discount = discountValue;
                } else if (discountType === 'percent') {

                    discount = ((grandTotal - grandTax) * discountValue / 100)
                } else if (discountType === 'afterTax') {
                    discount = (grandTotal * discountValue / 100);
                }
                grandTotal -= discount;

                // } else { // 'after_tax'
                //     if (discountType === 'pound') {
                //         grandTotal -= discountValue;
                //     } else if (discountType === 'percent') {
                //         grandTotal -= (grandTotal * discountValue / 100);
                //     }
                // }

                // Add extra charges
                if (extraType === 'percent') {
                    grandTotal += (grandTotal * extraValue / 100);
                } else if (extraType === 'pound') {
                    grandTotal += extraValue;
                }

                totalDiscount = totalAppliedDiscount + discount;
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
            // <td>
            //     <label>
            //         <input type="radio" name="products[${rowIndex}][discount_type]" value="pound" class="discount_type">
            //         ${translations.pound}
            //     </label>
            //     <label>
            //         <input type="radio" name="products[${rowIndex}][discount_type]" value="percent" checked class="discount_type">
            //         ${translations.percent}
            //     </label>
            //     <input type="number" name="products[${rowIndex}][discount]" class="form-control discount" value="0" min="0" step="any">
            //     <input type="number" hidden name="products[${rowIndex}][applied_discount]" class="form-control applied_discount" value="0" style="display:none;" step="any">
            // </td>
            // <td>
            // </td>
            $('#product_id').on('change', function() {
                var productId = $(this).val();
                var productName = $('option:selected', this).data('name');
                var sectorPrice = $('option:selected', this).data('sectorprice');
                var wholesalePrice = $('option:selected', this).data('wholesaleprice');
                var categoryType = $('option:selected', this).data('categorytype');
                var unitId = $('option:selected', this).data('unitid') || 191; // Default to 191 if null
                var existingRow = $(`#products_table tbody tr[data-product-id="${productId}"]`);
                var remaining = categoryType !== "خدمية" ? $('option:selected', this).data('remaining') :
                    99999;
                var valueAddedTax = $('#value_added_tax').val(); // الحصول على إعداد الضريبة المختار
                console.log(valueAddedTax);
                $(this).val("");
                if (existingRow.length > 0) {
                    var quantityInput = existingRow.find(
                        `input[name="products[${existingRow.data('index')}][quantity]"]`);
                    var currentQuantity = parseFloat(quantityInput.val()) || 0;
                    var newQuantity = currentQuantity + 1;

                    // if (categoryType !== "خدمية" && newQuantity > remaining) {
                    //     alert(`${translations.max_quantity} ${remaining}`);
                    //     newQuantity = remaining;
                    // }

                    quantityInput.val(newQuantity);
                    calculateRowTotal(existingRow);
                } else {
                    var rowHtml = `
                  <tr data-product-id="${productId}" data-index="${rowIndex}">
                      <td>${productName}</td>
                      <td class="text-left">
                          <label>
                              <input type="radio" name="products[${rowIndex}][price_type]" value="sector" class="price_type" checked>
                              ${translations.sector}
                          </label>
                          <label>
                              <input type="radio" name="products[${rowIndex}][price_type]" value="wholesale" class="price_type">
                              ${translations.wholesale}
                          </label>
                      </td>
                      <td>
                          <input type="number" min="1" name="products[${rowIndex}][product_price]" class="form-control form-control-sm price w-auto" value="${sectorPrice}" step="any">
                      </td>
                      <td>
                          <input type="number" name="products[${rowIndex}][quantity]" class="form-control form-control-sm quantity w-auto" value="1" min="1" max="${remaining}" step="any">
                      </td>
                      <td>
                          <select name="products[${rowIndex}][unit_id]" class="form-control form-control-sm unit w-auto">
                              <option disabled>${translations.choose_unit}</option>
                              @foreach ($units as $unit)
                                  <option value="{{ $unit->id }}" ${unitId === {{ $unit->id }} ? 'selected' : ''}>{{ $unit->unit_name }}</option>
                              @endforeach
                          </select>
                          <select name="products[${rowIndex}][tax]" hidden class="form-control tax_type w-auto mb-1">
                              <option value="0" ${valueAddedTax == 0 ? 'selected' : ''}>${translations.not_including_tax}</option>
                              <option value="1" ${valueAddedTax == 1 ? 'selected' : ''}>${translations.exempt_tax}</option>
                              <option value="2" ${valueAddedTax == 2 ? 'selected' : ''}>${translations.including_tax}</option>
                          </select>
                          <input type="number" hidden name="products[${rowIndex}][tax_amount]" class="form-control form-control-sm tax_amount w-auto" value="0" min="0" step="any">
                      </td>

                      <td>
                          <input type="number" name="products[${rowIndex}][total]" class="form-control form-control-sm total w-auto" value="0" readonly step="any">
                          <input type="number" hidden name="products[${rowIndex}][product_id]" class="form-control form-control-sm total" value="${productId}">
                      </td>
                      <td>
                          <button type="button" class="btn btn-danger btn-sm remove-product">${translations.remove}</button>
                      </td>
                  </tr>
                  `;


                    $('#products_table tbody').append(rowHtml);
                    handleTaxCalculation();
                    rowIndex++;
                }

                calculateGrandTotal();
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
@endsection
