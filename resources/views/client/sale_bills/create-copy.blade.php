@extends('client.layouts.app-main')
<style>
    .btn.dropdown-toggle.bs-placeholder,
    /* .form-control {
        height: 40px !important;
    } */

    a,
    a:hover {
        text-decoration: none;
        color: #444;
    }

    .bootstrap-select {
        width: 80% !important;
    }

    .bill_details {
        margin-top: 30px !important;
        min-height: 150px !important;
    }
</style>
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
        <h6 class="alert alert-info alert-sm text-center no-print  font-weight-bold" dir="rtl">
            <center>
                {{ __('sidebar.add-new-sales-invoice') }}
            </center>
        </h6>


        <!----Store--->

        <div class="col-lg-3 pl-0 pull-right no-print">
            <label>
                {{ __('sales_bills.select-store') }}
                <span class="text-danger font-weight-bold">*</span>
            </label>
            <div class="d-flex align-items-center">
                <select name="store_id" id="store_id" class="selectpicker me-2" data-style="btn-newdark"
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
                <a target="_blank" href="{{ route('client.stores.create') }}" role="button" class="btn btn-sm">
                    <i>{{ __('sales_bills.add-store') }}</i>
                </a>
            </div>
        </div>


        <!----CLIENT--->
        <div class="col-lg-3 p-0 pull-right no-print">
            <label>
                {{ __('sales_bills.client-name') }}
                <span class="text-danger font-weight-bold">*</span>
            </label>
            <div class="d-flex align-items-center">
                <select name="outer_client_id" id="outer_client_id" data-style="btn-newdark"
                    title="{{ __('sales_bills.client-name') }}" class="selectpicker w-100 me-2" data-live-search="true">
                    @foreach ($outer_clients as $outer_client)
                        <option value="{{ $outer_client->id }}">{{ $outer_client->client_name }}</option>
                    @endforeach
                </select>
                <a target="_blank" href="{{ route('client.outer_clients.create') }}" role="button" class="btn btn-sm">
                    <i>{{ __('sales_bills.add-client') }}</i>
                </a>
            </div>
        </div>



        <!----DATE--->
        <div class="col-lg-3 col-md-3 col-sm-3 pull-right no-print">
            <div class="form-group" dir="rtl">
                <label>{{ __('sales_bills.invoice-date') }}</label>
                <span class="text-danger font-weight-bold">*</span>
                <input type="date" required name="date" id="date" class="form-control"
                    value="{{ date('Y-m-d') }}" />
            </div>
        </div>

        <!----TIME--->
        <div class="col-lg-3 col-md-3 col-sm-3 pull-right no-print">
            <div class="form-group" dir="rtl">
                <label>{{ __('sales_bills.invoice-time') }}</label>
                <span class="text-danger font-weight-bold">*</span>
                <input type="time" required name="time" id="time" class="form-control"
                    value="{{ date('H:i:s') }}" />
            </div>
        </div>
        <!--tax-->
        <div class="clearfix no-print"></div>
        <div class="col-lg-3 pl-0 pull-right no-print">
            <label for="value_added_tax">{{ __('sales_bills.prices-for-tax') }}
                <span class="text-danger font-weight-bold">*</span>

            </label>

            <div class="d-flex align-items-center">
                <select required name="value_added_tax" id="value_added_tax" class="selectpicker me-2"
                    data-style="btn-newdark" data-live-search="true">
                    <option value="0">
                        {{ __('sales_bills.not-including-tax') }}</option>
                    <option value="2" selected>
                        {{ __('sales_bills.including-tax') }}</option>
                    <option value="1">
                        {{ __('sales_bills.exempt-tax') }}</option>
                </select>
            </div>
        </div>


        <!----Product--->

        <!----->
        <div class="col-lg-3 p-0 pull-right no-print">
            <label>
                {{ __('sales_bills.product-code') }}
                <span class="text-danger font-weight-bold">*</span>
            </label>
            <div class="d-flex align-items-center">
                <select name="product_id" id="product_id" class="selectpicker w-50" data-style="btn-newdark"
                    data-live-search="true" title="{{ __('sales_bills.product-code') }}">
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
                {{-- <select name="outer_client_id" id="outer_client_id" data-style="btn-newdark"
                    title="{{ __('sales_bills.client-name') }}" class="selectpicker w-100 me-2" data-live-search="true">
                    @foreach ($outer_clients as $outer_client)
                        <option value="{{ $outer_client->id }}">{{ $outer_client->client_name }}</option>
                    @endforeach
                </select> --}}
                <a target="_blank" href="{{ route('client.products.create') }} }}" role="button" class="btn btn-sm">
                    <i>{{ __('sales_bills.add-product') }}</i>
                </a>
            </div>
        </div>
        <div class="clearfix no-print"></div>

        <input type="number" id='grand_total_input' name="grand_total" hidden>
        <input type="number" id='grand_tax_input' name="grand_tax" hidden>
        <input type="number" id='grand_discount_input' name="total_discount" hidden>

        <!-- Table to display selected products -->
        <table class="table table-bordered mt-2" id="products_table">
            <thead>
                <tr>
                    <th>{{ __('sales_bills.product') }}</th>
                    <th>{{ __('sales_bills.price_type') }}</th>
                    <th>{{ __('sales_bills.price') }}</th>
                    <th>{{ __('sales_bills.quantity') }}</th>
                    <th>{{ __('sales_bills.unit') }}</th>
                    <th>{{ __('sales_bills.discount') }}
                        <div class="tax_discount"
                            style="display: inline-block; margin-left: 10px; vertical-align: middle;">
                            <select id="discount_application" class="form-control form-control-sm"
                                style="font-size: 12px; width: 20px; height: 20px;" name="products_discount_type">
                                <option value="before_tax">{{ __('sales_bills.discount_before_tax') }}</option>
                                <option value="after_tax">{{ __('sales_bills.discount_after_tax') }}</option>
                            </select>
                        </div>
                    </th>
                    <th>{{ __('sales_bills.tax') }}</th>
                    <th>{{ __('sales_bills.total') }}</th>
                    <th>{{ __('sales_bills.actions') }}</th>
                </tr>
            </thead>
            <tbody></tbody>
            <tfoot>
                <tr>
                    <td colspan="6">{{ __('sales_bills.grand_tax') }}</td>
                    <td colspan="3" id="grand_tax" class="text-right">0.00</td>
                </tr>
                <tr>
                    <td colspan="6">{{ __('sales_bills.grand_total') }}</td>
                    <td colspan="3" id="grand_total" class="text-right">0.00</td>
                </tr>
            </tfoot>
        </table>


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
                   style="width: 15%;display: inline;" class="btn btn-sm btn-danger open_popup">
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
        <div class="col-lg-12" style="margin: 20px auto;">
            <div class="col-lg-12">
                <div class="col-lg-6 col-md-6 col-xs-6 pull-right">
                    <div class="form-group" dir="rtl">
                        <label for="discount">{{ __('sales_bills.discount-on-the-total-bill') }}</label> <br>


                        <select name="discount_type" id="discount_type" class="form-control"
                            style="width: 20%;display: inline;float: right; margin-left:5px;">
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
                            style="width: 50%;display: inline;float: right;" id="discount_value" class="form-control "
                            step = "any" />
                        {{-- <span id="dicountForBill"></span> --}}


                        <input type="text" name="discount_note" id="discount_note" placeholder="ملاحظات الخصم. . ."
                            class="form-control" style="position:relative;top: 15px;width:93%; ">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-xs-6 pull-right">
                    <div class="form-group" dir="rtl">
                        <label for="extra">{{ __('main.shipping-expenses') }}</label> <br>

                        <select name="extra_type" id="extra_type" class="form-control"
                            style="width: 20%;display: inline;float: right;margin-left: 5px">
                            <option value="">اختر نوع الشحن</option>
                            <option value="pound">{{ $extra_settings->currency }}</option>
                            <option value="percent">%</option>
                        </select>
                        <input value="0" type="number" name="extra_value" min='0'
                            style="width: 50%;display: inline;float: right;" id="extra_value" class="form-control"
                            step = "any" />

                    </div>
                </div>
                <div class="clearfix"></div>
            </div> <!--  End Col-lg-12 -->
        </div><!--  End Row -->
        <!-----notes------->
        <div class="col-sm-12 pull-right no-print">
            <div class="form-group" dir="rtl">
                <label for="time">{{ __('main.notes') }}</label>
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

        <div class="col-lg-12 no-print text-center"
            style="padding-top: 25px;height: auto !important;display: flex;justify-content: center;">
            <button type="button" data-toggle="modal" style="height: 40px;" data-target="#myModal2"
                class="btn btn-md btn-dark pay_btn pull-right">
                <i class="fa fa-money"></i>
                {{ __('main.record') }}
            </button>



            <!------PRINT MAIN INVOICE---->
            {{-- <a href="javascript:;" role="button" class="btn save_btn1 btn-md btn-info text-white pull-right ml-1 "
                isMoswada="0" invoiceType='2' style="height: 40px;">
                حفظ و طباعة 1
            </a> --}}
            <button type="button" id="add" class="btn btn-info btn-md ml-1" style="height: 40px;">
                <i class="fa fa-plus"></i>
                {{ __('sales_bills.save') }}
            </button>
            <button type="button" role="button" class="btn save_btn1 btn-md btn-info text-white pull-right ml-1"
                isMoswada="0" invoiceType='2' style="height: 40px;">
                حفظ و طباعة 1
            </button>

            <!------PRINT 1---->
            <a href="javascript:;"
                style="height: 40px;border:1px solid #085d4a;background: #085d4a !important;color:white !important;"
                role="button" class="btn save_btn2 btn-md pull-right ml-1" printColor="1" isMoswada="0"
                invoiceType='2'>
                حفظ و طباعة 2
            </a>

            <a href="javascript:;" role="button"
                style="height: 40px;border:1px solid #5e8b0b;background: #5e8b0b !important;color:white !important;"
                class="btn save_btn2 btn-md btn-primary pull-right ml-1" printColor="2" isMoswada="0" invoiceType='4'>
                حفظ و طباعة 3
            </a>
            <!------PRINT 2---->
            <a href="javascript:;" role="button" style="height: 40px;"
                class="btn save_btn2 btn-md btn-primary pull-right ml-1" printColor="2" isMoswada="0" invoiceType='2'>
                حفظ و طباعة 4
            </a>

            <!------FATOORAH MOSWADA---->
            <a href="javascript:;" role="button" style="height: 40px;"
                class="btn save_btn2 btn-md btn-warning pull-right ml-1" printColor="2" isMoswada="1" invoiceType='2'>
                فاتورة مسودة
            </a>
            <!------FATOORAH No Tax---->
            <a href="javascript:;" role="button" style="height: 40px;"
                class="btn save_btn2 btn-md btn-success pull-right ml-1" printColor="2" isMoswada="0" invoiceType='3'>
                فاتورة غير ضريبية
            </a>
        </div>
        <div class="modal fade" dir="rtl" id="myModal2" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel2">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header w-100">
                        <h4 class="modal-title text-center" id="myModalLabel2">دفع نقدى</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="company_id" value="{{ $company_id }}">
                        <h5 class="col-lg-12 d-block mb-2">{{ __('main.main-information') }}</h5>
                        <hr>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label> رقم العملية <span class="text-danger">*</span></label>
                                <input required readonly value="{{ $pre_cash }}" class="form-control"
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
                                    @foreach ($safes as $safe)
                                        <option value="{{ $safe->id }}">{{ $safe->safe_name }}</option>
                                    @endforeach
                                </select>
                                <a target="_blank" href="{{ route('client.safes.create') }}" role="button"
                                    style="width: 15%;display: inline;" class="btn btn-sm btn-danger open_popup">
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
                                    @foreach ($banks as $bank)
                                        <option value="{{ $bank->id }}">{{ $bank->bank_name }}</option>
                                    @endforeach
                                </select>
                                <a target="_blank" href="{{ route('client.banks.create') }}" role="button"
                                    style="width: 15%;display: inline;" class="btn btn-sm btn-danger open_popup">
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
                        {{-- <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button class="btn btn-success pd-x-20 pay_cash" type="button">تسجيل الدفع</button>
                        </div> --}}
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
                        <form action="{{ route('save.notes') }}" method="post">
                            @csrf
                            @method('POST')

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


    <input type="hidden" id="final_total" />
    <input type="hidden" id="product" placeholder="product" name="product" />
    <input type="hidden" id="net_total" placeholder="اجمالى قبل الخصم" name="total" />
    <input type="hidden" value="0" id="check" />
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
            $('.save_btn1').on('click', function() {
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

                $.post("{{ url('/client/sale-bills/saveAll') }}", formData, function(data) {

                    location.href = '/sale-bills/print/' + data;
                });
            });

            //onsave btn حفظ الفاتورة
            $('.save_btn2').on('click', function() {
                let printColor = $(this).attr('printColor');
                let isMoswada = $(this).attr('isMoswada');
                let invoiceType = $(this).attr('invoiceType');
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

                $.post("{{ url('/client/sale-bills/saveAll') }}", formData, function(data) {
                    location.href = '/sale-bills/print/' + data + '/' + invoiceType + '/' +
                        printColor + '/' +
                        isMoswada;
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
                $.post("{{ url('/client/sale-bills/post') }}", formData, function(data) {
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
                        window.location.href = `/client/sale-bill/${data.id}`;
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

                if (existingRow.length > 0) {
                    var quantityInput = existingRow.find(
                        `input[name="products[${existingRow.data('index')}][quantity]"]`);
                    var currentQuantity = parseFloat(quantityInput.val()) || 0;
                    var newQuantity = currentQuantity + 1;

                    if (categoryType !== "خدمية" && newQuantity > remaining) {
                        alert(`${translations.max_quantity} ${remaining}`);
                        newQuantity = remaining;
                    }

                    quantityInput.val(newQuantity);
                    calculateRowTotal(existingRow);
                } else {
                    var rowHtml = `
                     <tr data-product-id="${productId}" data-index="${rowIndex}">
                         <td>${productName}</td>
                         <td>
                             <label><input type="radio" name="products[${rowIndex}][price_type]" value="sector" class="price_type" checked> ${translations.sector}</label>
                             <label><input type="radio" name="products[${rowIndex}][price_type]" value="wholesale" class="price_type"> ${translations.wholesale}</label>
                         </td>
                         <td><input type="number" min="1" name="products[${rowIndex}][product_price]" class="form-control price" value="${sectorPrice}" step="any"></td>
                         <td><input type="number" name="products[${rowIndex}][quantity]" class="form-control quantity" value="1" min="1" max="${remaining}" step="any"></td>
                         <td>
                             <select name="products[${rowIndex}][unit_id]" class="form-control unit">
                                 <option disabled>${translations.choose_unit}</option>
                                 @foreach ($units as $unit)
                                     <option value="{{ $unit->id }}" ${unitId === {{ $unit->id }} ? 'selected' : ''}>{{ $unit->unit_name }}</option>
                                 @endforeach
                             </select>
                         </td>
                         <td>
                             <label><input type="radio" name="products[${rowIndex}][discount_type]" value="pound" class="discount_type"> ${translations.pound}</label>
                             <label><input type="radio" name="products[${rowIndex}][discount_type]" value="percent" checked class="discount_type"> ${translations.percent}</label>
                             <input type="number" name="products[${rowIndex}][discount]" class="form-control discount" value="0" min="0" step="any">
                             <input type="number" hidden name="products[${rowIndex}][applied_discount]" class="form-control applied_discount" value="0" min="0" style="display:none;" step="any">
                         </td>
                         <td>
                              <select name="products[${rowIndex}][tax]" class="form-control tax_type">
                               <option value="0" ${valueAddedTax == 0 ? 'selected' : ''}>${translations.not_including_tax}</option>
                               <option value="1" ${valueAddedTax == 1 ? 'selected' : ''}>${translations.exempt_tax}</option>
                               <option value="2" ${valueAddedTax == 2 ? 'selected' : ''}>${translations.including_tax}</option>
                           </select>
                             <input type="number" readonly name="products[${rowIndex}][tax_amount]" class="form-control tax_amount" value="0" min="0" step="any">
                         </td>
                         <td><input type="number" name="products[${rowIndex}][total]" class="form-control total" value="0" readonly step="any"><input type="number" hidden name="products[${rowIndex}][product_id]" class="form-control total" value="${productId}"></td>
                         <td><button type="button" class="btn btn-danger remove-product">${translations.remove}</button></td>
                     </tr>`;

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
