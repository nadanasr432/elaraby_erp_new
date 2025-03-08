@extends('client.layouts.app-main')
<style>
    .btn.dropdown-toggle.bs-placeholder,
    .form-control {
        height: 40px !important;
    }

    a,
    a:hover {
        text-decoration: none;
        color: #444;
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

    <h6 class="alert alert-sm alert-info text-center font-weight-bold">
        <i class="fa fa-info-circle"></i>
        بيانات عناصر الفاتورة ({{ $saleBill->sale_bill_number }})
    </h6>


    <div class="table-responsive">
        <table class="table table-condensed table-striped table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>اسم المنتج</th>
                    <th>سعر الوحدة</th>
                    <th>الكمية</th>
                    <th>الاجمالى</th>
                    <th>الخصم</th>
                    <th>الضريبة</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $i = 0;
                    $sum = [];
                @endphp

                @foreach ($saleBill->elements as $element)
                    @php
                        $sum[] =
                            $element->tax_type == 2
                                ? $element->quantity_price - $element->tax_value
                                : $element->quantity_price;
                    @endphp
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ $element->product->product_name }}</td>
                        <td>{{ $element->product_price }}</td>
                        <td>
                            {{ !empty($element->unit_id) ? $element->quantity . ' ' . $element->unit->unit_name : $element->quantity }}
                        </td>
                        <td> {{ $element->tax_type == 1 ? $element->quantity_price - $element->tax_value : $element->quantity_price }}
                        </td>
                        <td>{{ $element->discount_value }}{{ $element->discount_type == 'percent' ? ' %' : '' }}</td>
                        <td>{{ $element->tax_value }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Calculations --}}
    @php
        $total = array_sum($sum) + $saleBill->total_discount;
        $after_total = $saleBill->final_total;
        $tax_option = $saleBill->value_added_tax;
    @endphp

    {{-- @if ($tax_option == 1)
        @php
            $after_total = $total;
        @endphp
    @endif --}}

    <div class="clearfix"></div>
    <div class="alert alert-dark alert-sm text-center">
        <div class="pull-right col-lg-6">
            الاجمالى قبل الخصم والضريبة
            {{ round($total, 2) }} <img src="{{ asset('images/Sr_coin.svg') }}" width="5%">
        </div>
        <div class="pull-left col-lg-6">
            اجمالى الفاتورة بعد الخصم والضريبة
            {{ round($after_total, 2) }} <img src="{{ asset('images/Sr_coin.svg') }}" width="5%">
        </div>
        <div class="pull-left col-lg-6">
            مجموع الخصم
            {{ round($saleBill->total_discount, 2) }} <img src="{{ asset('images/Sr_coin.svg') }}" width="5%">
        </div>
        <div class="pull-left col-lg-6">
            مجموع الضرائب
            {{ round($saleBill->total_tax, 2) }} <img src="{{ asset('images/Sr_coin.svg') }}" width="5%">
        </div>
        <div class="clearfix"></div>
    </div>

    <div class="col-lg-12 no-print text-center"
        style="padding-top: 25px;height: auto !important;display: flex;justify-content: start;overflow-x: auto">

        <button type="button" @if ($saleBill->final_total - $saleBill->paid <= 0) disabled @endif data-toggle="modal" data-target="#myModal2"
            class="btn btn-md btn-dark pay_btn float-right pr-3 pl-3 d-flex align-items-center" style="height: 40px;">
            <i class="fa fa-money"></i>
            <span class="d-none d-sm-inline"> {{ __('main.record') }} </span>
        </button>

        <a href="{{ route('client.sale_bills.edit1', [$saleBill->token, $saleBill->company_id]) }}"
            class="btn btn-info btn-md ml-1" style="height: 40px;">
            {{-- <i class="fa fa-plus"></i> --}}
            {{ __('sales_bills.edit') }}
        </a>

        {{-- <form class="d-inline" method="POST" onsubmit="return checkChanges()"
            action="{{ route('client.sale_bills.cancel') }}">
            @csrf
            @method('POST')
            <input type="hidden" value="{{ $saleBill->sale_bill_number }}" id="sale_bill_number"
                name="sale_bill_number" />


            <!------CANCEL BTN---->
            <button href="" type="submit" class="btn btn-md close_btn btn-danger pull-right ml-1 "
                style="height: 40px;" @if (!isset($saleBill) || empty($saleBill)) disabled @endif>
                <i class="fa fa-trash"></i>
                {{ __('main.cancel') }}
            </button>
        </form> --}}
        <!------PRINT MAIN INVOICE---->
        <!------PRINT MAIN INVOICE---->
        <a class="btn btn-md btn-info text-white pull-right ml-1" role="button"
            href="{{ route('client.sale_bills.print', $saleBill->token) }}" style="height: 40px;">
            طباعة 1
        </a>

        <!------PRINT 1---->
        <a href="{{ route('client.sale_bills.print', [$saleBill->token, 2, 1, 0]) }}" class="btn btn-md pull-right ml-1"
            style="height: 40px;border:1px solid #085d4a;background: #085d4a !important;color:white !important;">
            طباعة 2
        </a>
        <!------PRINT 2---->
        <a href="{{ route('client.sale_bills.print', [$saleBill->token, 4, 1, 0]) }}"
            class="btn btn-md btn-primary pull-right ml-1"
            style="height: 40px;border:1px solid #5e8b0b;background: #5e8b0b !important;color:white !important;"
            printColor="2" isMoswada="0" invoiceType='4'>
            طباعة 3
        </a>
        <!------PRINT 2---->

        <a href="{{ route('client.sale_bills.print', [$saleBill->token, 5, 2, 0]) }}" role="button"
            style="height: 40px;border:1px solid #0bb3b3!important;background: #0bb3b3 !important ;color:white !important;"
            class="btn save_btn5 btn-md btn-primary pull-right ml-1">
            طباعة 4
        </a>

        <a href="{{ route('client.sale_bills.print', [$saleBill->token, 2, 3, 0]) }}" style="height: 40px;"
            class="btn btn-md btn-primary pull-right ml-1">
            طباعة 5

        </a>
        <a href="{{ route('client.sale_bills.print', [$saleBill->token, 6, 3, 0]) }}" role="button"
            style="height: 40px;border:1px solid #0b228b;background: #0b228b !important;color:white !important;"
            class="btn  btn-md btn-primary pull-right ml-1
            " printColor="2" isMoswada="0" invoiceType='6'>
            طباعة 6
        </a>
        <a href="{{ route('client.sale_bills.print', [$saleBill->token, 7, 3, 0]) }}" role="button"
            style="height: 40px;border:1px solid #9b4aad !important ;background: #9b4aad !important;color:white !important;"
            class="btn  btn-md btn-primary pull-right ml-1" printColor="2" isMoswada="0" invoiceType='7'>
            طباعة 7
        </a>
        <a href="{{ route('client.sale_bills.print', [$saleBill->token, 8, 3, 0]) }}" role="button"
            style="height: 40px;border:1px solid #3d121264 !important ;background: #3d121264 !important;color:white !important;"
            class="btn  btn-md btn-primary pull-right ml-1" printColor="2" isMoswada="0" invoiceType='8'>
            طباعة 8
        </a>

        <!------FATOORAH MOSWADA---->
        <a href="{{ route('client.sale_bills.print', [$saleBill->token, 2, 1, 1]) }}" style="height: 40px;"
            class="btn btn-md btn-warning pull-right ml-1">
            فاتورة مسودة
        </a>

        <!------FATOORAH No Tax---->
        <a href="{{ route('client.sale_bills.print', [$saleBill->token, 3, 2, 0]) }}" style="height: 40px;"
            class="btn btn-md btn-success pull-right ml-1">
            فاتورة غير ضريبية
        </a>
    </div>
    <div class="modal fade" dir="rtl" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
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
                            <input required readonly value="{{ $pre_cash }}" class="form-control" id="cash_number"
                                name="cash_number" type="text">
                            <input type="hidden" value="{{ $saleBill->sale_bill_number }}" id="sale_bill_number"
                                name="sale_bill_number" />
                        </div>
                        <div class="col-md-4">
                            <label> المبلغ المدفوع <span class="text-danger">*</span></label>
                            <input required class="form-control" name="amount" id="amount" type="text"
                                value="{{ $saleBill->final_total - $saleBill->paid }}" dir="ltr">
                            <input required class="form-control" name="outer_client_id" hidden id="outer_client_id"
                                type="text" value="{{ $saleBill->outer_client_id }}" dir="ltr">
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
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <button class="btn btn-success pd-x-20 pay_cash" type="button">تسجيل الدفع</button>
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
                    <form id="myForm" action="{{ route('save.notes') }}" method="post">
                        @csrf
                        @method('POST')
                        @if (isset($saleBill) && !empty($saleBill))
                            <input type="hidden" name="counter" value="{{ $saleBill->company_counter }}" />
                        @else
                            <input type="hidden" name="counter" value="777" />
                        @endif
                        <div class="notes">
                            <div class="col-lg-6 pull-right">
                                <div class="form-group">
                                    <label class="d-block">
                                        الملاحظة رقم 1
                                    </label>
                                    <input
                                        @if (isset($saleBill) &&
                                                !empty($saleBill) &&
                                                !empty($saleBill->sale_bill_notes[0]) &&
                                                !$saleBill->sale_bill_notes->isEmpty()) value="{{ $saleBill->sale_bill_notes[0]->notes }}" @endif
                                        type="text" class="form-control" name="notes[]" />
                                </div>
                            </div>
                            <div class="col-lg-6 pull-right">
                                <div class="form-group">
                                    <label class="d-block">
                                        الملاحظة رقم 2
                                    </label>
                                    <input
                                        @if (isset($saleBill) &&
                                                !empty($saleBill) &&
                                                !empty($saleBill->sale_bill_notes[1]) &&
                                                !$saleBill->sale_bill_notes->isEmpty()) value="{{ $saleBill->sale_bill_notes[1]->notes }}" @endif
                                        type="text" class="form-control" name="notes[]" />
                                </div>
                            </div>
                            <div class="col-lg-6 pull-right">
                                <div class="form-group">
                                    <label class="d-block">
                                        الملاحظة رقم 3
                                    </label><input
                                        @if (isset($saleBill) &&
                                                !empty($saleBill) &&
                                                !empty($saleBill->sale_bill_notes[2]) &&
                                                !$saleBill->sale_bill_notes->isEmpty()) value="{{ $saleBill->sale_bill_notes[2]->notes }}" @endif
                                        type="text" class="form-control" name="notes[]" />
                                </div>
                            </div>
                            <div class="col-lg-6 pull-right">
                                <div class="form-group">
                                    <label class="d-block">
                                        الملاحظة رقم 4
                                    </label>
                                    <input
                                        @if (isset($saleBill) &&
                                                !empty($saleBill) &&
                                                !empty($saleBill->sale_bill_notes[3]) &&
                                                !$saleBill->sale_bill_notes->isEmpty()) value="{{ $saleBill->sale_bill_notes[3]->notes }}" @endif
                                        type="text" class="form-control" name="notes[]" />
                                </div>
                            </div>
                            <div class="col-lg-6 pull-right">
                                <div class="form-group">
                                    <label class="d-block">
                                        الملاحظة رقم 5
                                    </label><input
                                        @if (isset($saleBill) &&
                                                !empty($saleBill) &&
                                                !empty($saleBill->sale_bill_notes[4]) &&
                                                !$saleBill->sale_bill_notes->isEmpty()) value="{{ $saleBill->sale_bill_notes[4]->notes }}" @endif
                                        type="text" class="form-control" name="notes[]" />
                                </div>
                            </div>
                            <div class="col-lg-6 pull-right">
                                <div class="form-group">
                                    <label class="d-block">
                                        الملاحظة رقم 6
                                    </label>
                                    <input
                                        @if (isset($saleBill) &&
                                                !empty($saleBill) &&
                                                !empty($saleBill->sale_bill_notes[5]) &&
                                                !$saleBill->sale_bill_notes->isEmpty()) value="{{ $saleBill->sale_bill_notes[5]->notes }}" @endif
                                        type="text" class="form-control" name="notes[]" />
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
    <input type="hidden" id="final_total"
        @if (isset($saleBill) && !empty($saleBill)) value="{{ $saleBill->final_total }}" @endif />
    <input type="hidden" id="product" placeholder="product" name="product" />
    <input type="hidden" id="total" placeholder="اجمالى قبل الخصم" name="total" />
    <input type="hidden" value="0" id="check" />
    <script src="{{ asset('app-assets/js/jquery.min.js') }}"></script>
    <script>
        var somethingChanged = false;
        $(document).ready(function() {
            $('.summernotes').summernote({
                height: 100,
                direction: 'rtl',
            });
        })
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
        //onsave btn حفظ الفاتورة
        $('.save_btn1').on('click', function() {
            checkChanges();
            let sale_bill_number = $('#sale_bill_number').val();
            let payment_method = $('#payment_method').val();

            $.post("{{ url('/client/sale-bills/saveAll') }}", {
                sale_bill_number: sale_bill_number,
                payment_method: payment_method,
                "_token": "{{ csrf_token() }}"
            }, function(data) {

                location.href = '/sale-bills/print/' + data;
            });
        });

        //onsave btn حفظ الفاتورة
        $('.save_btn2').on('click', function() {
            checkChanges();
            let sale_bill_number = $('#sale_bill_number').val();
            let payment_method = $('#payment_method').val();
            let printColor = $(this).attr('printColor');
            let isMoswada = $(this).attr('isMoswada');
            let invoiceType = $(this).attr('invoiceType');
            $.post("{{ url('/client/sale-bills/saveAll') }}", {
                sale_bill_number: sale_bill_number,
                payment_method: payment_method,
                "_token": "{{ csrf_token() }}"
            }, function(data) {
                // console.log(data);
                location.href = '/sale-bills/print/' + data + '/' + invoiceType + '/' + printColor + '/' +
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
                $.post("{{ route('client.store.cash.outerClients.SaleBill1', 'test') }}", {
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
                        $('<div class="alert alert-dark alert-sm"> ' + data.msg + '</div>').insertAfter(
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
                            location.reload();

                        });
                        setTimeout(function() {
                            $('#myModal2').hide();
                            $('#myModal2').removeClass('show');
                            $('#myModal2').css('display', 'none')
                            $('body').removeClass('modal-open');
                            $('.modal-backdrop').remove();
                        }, 2000);

                    } else {
                        $('<br/><br/> <p class="alert alert-dark alert-sm"> ' + data.msg + '</p>')
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


        //add-new-sale-bill button --- اضافة فاتورة بيع جديدة.
        $(document).ready(function() {
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

                let missingUnitId = false;
                $('#product_table tbody tr').each(function() {
                    let unitSelect = $(this).find('select[name$="[unit_id]"]');
                    let unitId = unitSelect.val();
                    if (!unitId || unitId === "") {
                        missingUnitId = true;
                        return false; // Stop loop
                    }
                });

                if (missingUnitId) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'تحذير',
                        text: 'يرجى تحديد وحدة لكل منتج',
                        confirmButtonText: 'موافق'
                    });
                    return false;
                }

                // Serialize the form data
                var formData = $('#myForm').serialize();

                console.log(formData);

                let saleBillNumber = $('#sale_bill_number').val();
                let productId = $('#product_id').val();
                let productPrice = $('#product_price').val();
                let quantity = $('#quantity').val();
                let date = $('#date').val();
                let time = $('#time').val();
                let notes = $('#notes').val();
                let quantityPrice = quantity * productPrice;
                let firstBalance = parseFloat($('#quantity').attr('max'));
                let discountType = $('#discount_type').val();
                let discountValue = $('#discount_value').val();
                let extraType = $('#extra_type').val();
                let extraValue = $('#extra_value').val();
                let valueAddedTax = $('#value_added_tax').val();
                let storeId = $('#store_id').val();

                if (productId == "" || productId <= "0") {
                    Swal.fire({
                        icon: 'warning',
                        title: 'تحذير',
                        text: 'لابد ان تختار المنتج أولا',
                        confirmButtonText: 'موافق'
                    });
                    return false;
                }

                $.post("{{ url('/client/sale-bills/post') }}", formData, function(data) {
                    $('#outer_client_id').attr('disabled', true).addClass('disabled');
                    $('#product_id').val('').trigger('change');
                    $('#unit_id').val('');
                    $('#discount_type').attr('disabled', false);
                    $('.print_btn').removeClass('disabled');
                    $('.pay_btn').attr('disabled', false);
                    $('.close_btn').attr('disabled', false);
                    $('.save_btn1').removeClass('disabled');
                    $('.save_btn2').removeClass('disabled');
                    $('.send_btn').removeClass('disabled');
                    $('.add_extra_notes').removeClass('disabled');
                    $('#discount_value').attr('disabled', false);
                    $('#exec_discount').attr('disabled', false);
                    $('#extra_type').attr('disabled', false);
                    $('#extra_value').attr('disabled', false);
                    $('#exec_extra').attr('disabled', false);
                    $('#value_added_tax').attr('disabled', true).addClass('disabled');
                    $('.available').html("");
                    $('#product_price').val('0');
                    $('#quantity').val('');
                    $('#quantity_price').val('');
                    if (data.status === true) {

                        //-----show success msg.------//
                        $('.box_success').removeClass('d-none').fadeIn(200);
                        $('.msg_success').html(data.msg);
                        $('.box_success').delay(3000).fadeOut(300);

                        //-----get and show added elements.-----//
                        // $.post("{{ url('/client/sale-bills/elements') }}", {
                        //     "_token": "{{ csrf_token() }}",
                        //     sale_bill_number: saleBillNumber
                        // }, function(elements) {
                        //     $('.bill_details').html(elements);
                        // });

                        // //-----apply discount-----//
                        // $.post("{{ url('/client/sale-bills/discount') }}", {
                        //     "_token": "{{ csrf_token() }}",
                        //     sale_bill_number: saleBillNumber,
                        //     discount_type: discountType,
                        //     discount_value: discountValue
                        // }, function(data) {
                        //     $('.after_totals').html(data);
                        // });

                        // //-----apply extra_value which is shipping discount-----//
                        // $.post("{{ url('/client/sale-bills/extra') }}", {
                        //     "_token": "{{ csrf_token() }}",
                        //     sale_bill_number: saleBillNumber,
                        //     extra_type: extraType,
                        //     extra_value: extraValue
                        // }, function(data) {
                        //     $('.after_totals').html(data);
                        // });

                        // $.post("{{ url('/client/sale-bills/refresh') }}", {
                        //     "_token": "{{ csrf_token() }}",
                        //     sale_bill_number: saleBillNumber,
                        // }, function(data) {
                        //     $('#final_total').val(data.final_total);
                        // });

                    } else {
                        $('.box_error').removeClass('d-none').fadeIn(200);
                        $('.msg_error').html(data.msg);
                        $('.box_error').delay(3000).fadeOut(300);

                        // $.post("{{ url('/client/sale-bills/elements') }}", {
                        //     "_token": "{{ csrf_token() }}",
                        //     sale_bill_number: saleBillNumber
                        // }, function(elements) {
                        //     $('.bill_details').html(elements);
                        // });

                        // $.post("{{ url('/client/sale-bills/discount') }}", {
                        //     "_token": "{{ csrf_token() }}",
                        //     sale_bill_number: saleBillNumber,
                        //     discount_type: discountType,
                        //     discount_value: discountValue
                        // }, function(data) {
                        //     Swal.fire({
                        //         icon: 'info',
                        //         title: 'معلومات',
                        //         text: 'تم تطبيق الخصم',
                        //         confirmButtonText: 'موافق'
                        //     });
                        //     $('.after_totals').html(data);
                        // });

                        // $.post("{{ url('/client/sale-bills/extra') }}", {
                        //     "_token": "{{ csrf_token() }}",
                        //     sale_bill_number: saleBillNumber,
                        //     extra_type: extraType,
                        //     extra_value: extraValue
                        // }, function(data) {
                        //     $('.after_totals').html(data);
                        // });

                        // $.post("{{ url('/client/sale-bills/refresh') }}", {
                        //     "_token": "{{ csrf_token() }}",
                        //     sale_bill_number: saleBillNumber,
                        // }, function(data) {
                        //     $('#final_total').val(data.final_total);
                        // });
                    }
                });
            });
        });


        // $('.pay_btn').on('click', function() {
        //     let final_total = $('#final_total').val();
        //     $('#amount').val(final_total);
        // })

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
    </script>
@endsection
