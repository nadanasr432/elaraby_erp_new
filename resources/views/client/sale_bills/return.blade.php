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

    .bootstrap-select {
        width: 100% !important;
    }

    .bill_details {
        margin-top: 30px !important;
        min-height: 150px !important;
    }
</style>
@section('content')

    <div class="alert alert-success alert-dismissable text-center box_success d-none no-print">
        <button class="close" data-dismiss="alert" aria-label="Close">×</button>
        <span class="msg_success"></span>
    </div>

    <div class="alert alert-danger alert-dismissable text-center box_error d-none no-print">
        <button class="close" data-dismiss="alert" aria-label="Close">×</button>
        <span class="msg_error"></span>
    </div>
    @if (count($errors) > 0)
        <div class="alert alert-danger no-print">
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
    <div class="col-lg-12 text-center mt-1 mb-1">
        <p class="alert alert-sm alert-info">
            اضافة مرتجع فاتورة مبيعات
        </p>
    </div>
    <form action="{{ route('client.sale_bills.post.return') }}" method="post">
        @csrf
        @method('POST')
        <input type="hidden" value="{{ $sale_bill->id }}" name="bill_id" />
        <input type="hidden" value="{{ $element->id }}" name="element_id" />
        <div class="row mt-2 mb-2">
            <div class="col-lg-3 pull-right no-print">
                <label for="" class="d-block">اسم العميل</label>
                <input type="hidden"
                    @if (empty($sale_bill->outer_client_id)) value="" @else
                value="{{ $sale_bill->OuterClient->id }}" @endif
                    required name="outer_client_id" id="outer_client_id" />
                <input type="text" class="form-control" readonly
                    @if (empty($sale_bill->outer_client_id)) value="عميل مبيعات نقدية" @else value="{{ $sale_bill->OuterClient->client_name }}" @endif />
            </div>
            <div class="col-lg-3 pull-right no-print">
                <label for="" class="d-block">تاريخ الارتجاع</label>
                <input type="date" value="{{ date('Y-m-d') }}" class="form-control" required name="date" />
            </div>
            <div class="col-lg-3 pull-right no-print">
                <label for="" class="d-block"> وقت الارتجاع </label>
                <input type="time" value="{{ date('H:i:s') }}" class="form-control" required name="time" />
            </div>
            <div class="col-lg-3 pull-right no-print">
                <label for="" class="d-block">اسم المنتج</label>
                <input type="hidden" value="{{ $element->product_id }}" required name="product_id" id="product_id" />
                <input type="text" class="form-control" readonly value="{{ $element->product->product_name }}" />
            </div>
        </div>
        <div class="row mt-1 mb-1">
            <div class="col-lg-3 pull-right">
                <div class="form-group" dir="rtl">
                    <label for="return_quantity">الكمية المرتجعة</label>
                    <input type="number" step="any" name="return_quantity" min="0" max="{{ $element->quantity }}"
                        value="{{ $element->quantity }}" id="return_quantity" class="form-control" required>
                    <input type="number" hidden name="main_return_quantity" min="0" max="{{ $element->quantity }}"
                        value="{{ $element->quantity }}" id="main_return_quantity" step="any" class="form-control" required>
                    <span id="quantityError" class="text-danger" style="display: none;">الكمية المرتجعة لا يمكن أن تكون أكبر
                        من {{ $element->quantity }}</span>
                </div>
            </div>
            <div class="col-lg-3 pull-right">
                <div class="form-group" dir="rtl">
                    <label for="before_return">الموجود بالمخزن قبل الارتجاع</label>
                    <input type="text" name="before_return" id="before_return"
                        value="{{ $element->product->first_balance }}" readonly class="form-control" required>
                </div>
            </div>

            <div class="col-lg-3 pull-right">
                <div class="form-group" dir="rtl">
                    <label for="after_return">الموجود بالمخزن بعد الارتجاع</label>
                    <input type="text" name="after_return" id="after_return" readonly class="form-control" required>
                </div>
            </div>
            <div class="col-lg-3 pull-right">
                <div class="form-group" dir="rtl">
                    <label for="notes">ملاحظات</label>
                    <input type="text" dir="rtl" name="notes" id="notes" class="form-control" />
                </div>
            </div>
        </div>
        <div class="row mt-1 mb-1">
            <div class="col-lg-3 pull-right">
                <div class="form-group" dir="rtl">
                    <label for="product_price">سعر المنتج</label>
                    <input type="text" readonly value="{{ $element->product_price }}" name="product_price"
                        id="product_price" class="form-control" required>
                </div>
            </div>

            <div class="col-lg-3 pull-right">
                <div class="form-group" dir="rtl">
                    <label for="quantity_price">سعر الكمية</label>
                    <input type="text" name="quantity_price" id="quantity_price" readonly class="form-control"
                        required>
                </div>
            </div>
            {{-- @dump($sale_bill->OuterClient->prev_balance) --}}
            <div class="col-lg-3 pull-right">
                <div class="form-group" dir="rtl">
                    <label for="balance_before">مديونية سابقة</label>
                    <input type="text" name="balance_before" id="balance_before"
                        @if (empty($sale_bill->outer_client_id)) value="0" @else value="{{ $sale_bill->OuterClient->prev_balance }}" @endif
                        class="form-control" readonly required>
                </div>
            </div>
            @php
                $ProdTax = 0;
                if ($company->tax_value_added && $company->tax_value_added != 0) {
                    $ProdTax = $sale_bill->value_added_tax
                        ? $element->quantity_price - ($element->quantity_price * 20) / 23
                        : ($element->quantity_price * 15) / 100;
                }

                // Calculate Product Total
                $ProdTotal = $element->quantity_price;
                if ($company->tax_value_added && $company->tax_value_added != 0) {
                    $ProdTotal = $sale_bill->value_added_tax
                        ? $element->quantity_price
                        : $element->quantity_price + ($element->quantity_price * 15) / 100;
                }
                $productPrice =
                    $element->tax_type == 0 ? $element->product_price + $element->tax_value : $element->product_price;
                $elementDiscount =
                    $element->discount_type == 'percent'
                        ? ($element->quantity_price * $element->discount_value) / 100
                        : $element->discount_value;
                $finalPrice = round(
                    $element->tax_type == 0
                        ? $element->quantity_price + $element->tax_value - $elementDiscount
                        : $element->quantity_price - $elementDiscount,
                    2,
                );
            @endphp
            <div class="col-lg-3 pull-right">
                <div class="form-group" dir="rtl">
                    <label for="balance_after">مديونية حالية</label>
                    <input type="text" name="balance_after"
                        @if (empty($sale_bill->outer_client_id)) value="0" @else  value="{{ $finalPrice }}" @endif
                        id="balance_after" readonly class="form-control" required>
                    <input type="text" name="main_balance_after" hidden
                        @if (empty($sale_bill->outer_client_id)) value="0" @else  value="{{ $finalPrice }}" @endif
                        id="main_balance_after" readonly class="form-control" required>
                </div>
            </div>
        </div>
        <div class="col-lg-12 mt-1 mb-1 text-center">
            <button type="submit" class="btn btn-md btn-success">
                <i class="fa fa-edit"></i>
                ارتجاع الكمية
            </button>
        </div>
    </form>

    <script src="{{ asset('app-assets/js/jquery.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            let outer_client_id = $('#outer_client_id').val();
            let main_return_quantity = parseFloat($('#main_return_quantity').val()) || 0;
            let main_balance_after = parseFloat($('#main_balance_after').val()) || 0;
            let before_return = parseFloat($('#before_return').val()) || 0;
            let product_price = parseFloat($('#product_price').val()) || 0;

            function calculateValues(return_quantity) {
                return_quantity = parseFloat(return_quantity) || 0;

                // Validate decimal input
                if (isNaN(return_quantity)) {
                    return;
                }

                let after_return = before_return + return_quantity;
                $('#after_return').val(after_return.toFixed(2)); // Show 2 decimal places

                let quantity_price = product_price * return_quantity;
                $('#quantity_price').val(quantity_price.toFixed(2));

                if (outer_client_id) {
                    let balance_after = (main_balance_after / main_return_quantity) * return_quantity;
                    $('#balance_after').val(balance_after.toFixed(2));
                }
            }

            // Initial calculation
            let return_quantity = parseFloat($('#return_quantity').val()) || 0;
            calculateValues(return_quantity);

            // Event Listener for Input Changes
            $('#return_quantity').on('input', function() {
                let value = $(this).val();

                // Allow only numbers and one decimal point
                if (!/^\d*\.?\d*$/.test(value)) {
                    $(this).val(value.slice(0, -1));
                    return;
                }

                calculateValues(value);
            });

            // Validate Return Quantity
            document.getElementById('return_quantity').addEventListener('change', function() {
                let maxQuantity = parseFloat({{ $element->quantity }});
                let inputValue = parseFloat(this.value) || 0;
                let errorMessage = document.getElementById('quantityError');

                if (inputValue > maxQuantity) {
                    this.setCustomValidity("الكمية المرتجعة لا يمكن أن تكون أكبر من " + maxQuantity);
                    errorMessage.style.display = "block";
                } else {
                    this.setCustomValidity("");
                    errorMessage.style.display = "none";
                }
            });
        });
    </script>

@endsection
