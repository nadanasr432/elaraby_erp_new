@extends('client.layouts.app-main')
<style>
    .btn.dropdown-toggle.bs-placeholder {
        height: 40px;
    }

    .bootstrap-select {
        width: 80% !important;
    }

    .form-control {
        height: 45px !important;
        padding: 10px !important;
    }

    .form-switch .form-check-input {
        width: 50px !important;
        height: 20px !important;
    }
</style>
@section('content')

    <div class="row p-0">
        <div class="col-md-12">
            <div class="card">
                <!------HEADER----->
                <div class="card-header border-bottom border-secondary p-1">
                    <div class="d-flex justify-content-between align-items-baseline">
                        <h3 class="pull-right font-weight-bold ml-1">
                            {{ __('manufactures.addnewmanufacture') }}
                        </h3>
                        <a class="btn btn-danger btn-sm pull-left p-1" href="http://arabygithub.test/ar/client/journal/get">
                            {{ __('products.back') }}
                        </a>
                    </div>
                </div>

                <!------HEADER----->
                <div class="card-body p-2">
                    <form class="parsley-style-1" id="selectForm2" name="selectForm2"
                        action="{{ route('client.manufactures.store', 'test') }}" enctype="multipart/form-data"
                        method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="company_id" value="{{ $company_id }}">
                        <div class="alert alert-danger" id="showErrMsg" style="display:none">

                        </div>

                        <div class="row p-0">

                            <!----store---->
                            <div class="form-group col-lg-3 pr-0" dir="rtl">
                                <label for="store_id">

                                    {{ __('products.store_name') }}
                                    <span class="text-danger font-weight-bold">*</span>
                                </label>
                                <select required name="store_id" id="store" class="form-control">
                                    <option value="">{{ __('products.choose_store') }}</option>
                                    <?php $i = 0; ?>
                                    @foreach ($stores as $store)
                                        @if ($stores->count() == 1)
                                            <option selected value="{{ $store->id }}">{{ $store->store_name }}</option>
                                        @else
                                            @if ($i == 0)
                                                <option selected value="{{ $store->id }}">{{ $store->store_name }}
                                                </option>
                                            @else
                                                <option value="{{ $store->id }}">{{ $store->store_name }}</option>
                                            @endif
                                        @endif
                                        <?php $i++; ?>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-lg-3 pr-0" dir="rtl">
                                <label for="status">

                                    {{ __('manufactures.status') }}
                                    <span class="text-danger font-weight-bold">*</span>
                                </label>
                                <select required name="status" id="store" class="form-control">
                                    <option value="">{{ __('manufactures.choose_status') }}</option>
                                    <option selected value="processing">{{ __('manufactures.processing') }}</option>
                                    <option value="complete">{{ __('manufactures.complete') }}</option>

                                </select>
                            </div>
                            <div class="form-group col-lg-3 pr-0" dir="rtl">
                                <label for="date">

                                    {{ __('manufactures.date') }}
                                    <span class="text-danger font-weight-bold">*</span>
                                </label>
                                <input type="date" name="date" class="form-control"
                                    value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">

                            </div>
                        </div>
                        <div class='row'>
                            <label for="products" class="mt-5">

                                {{ __('manufactures.choose_products') }}
                                <span class="text-danger font-weight-bold">*</span>
                            </label>
                            <select name="product" id="productsc" class="form-control">
                                <option selected value="">{{ __('manufactures.choose_product') }}</option>
                                @foreach ($ManufactureProducts as $product)
                                    <option value="{{ $product->id }}" data-name="{{ $product->product_name }}"
                                        data-price="{{ $product->sector_price }}">{{ $product->product_name }}</option>
                                @endforeach
                            </select>
                            <table class="table table-bordered mt-3 mb-3">
                                <thead>
                                    <tr>
                                        <th>{{ __('manufactures.Product Name') }}</th>
                                        <th>{{ __('manufactures.Price') }}</th>
                                        <th>{{ __('manufactures.Quantity') }}</th>
                                        <th>{{ __('manufactures.Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody id="productTable">
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2">{{ __('manufactures.Total') }}</td>
                                        <td colspan="2" id="totalPrice">0</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">{{ __('manufactures.Total Quantity') }}</td>
                                        <td colspan="2" id="totalQty">0</td>
                                    </tr>
                                </tfoot>
                            </table>

                            <input type="hidden" name="total" id="totalInput" value="0">
                            <input type="hidden" name="qty" id="totalQtyInput" value="0">
                        </div>
                        <div class="form-group row">
                            <label for="date">

                                {{ __('manufactures.note') }}
                            </label>
                            <textarea name="note" class="form-control"></textarea>

                        </div>
                        <button class="btn btn-md btn-success w-100 font-weight-bold"
                            type="submit">{{ __('products.add') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if (count($errors) > 0)
        <div class="alert alert-danger">
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

    <script src="{{ asset('app-assets/js/jquery.min.js') }}"></script>
    <script>
       function calculateTotal() {
            let total = 0;
            let totalQty = 0;
            $('#productTable tr').each(function() {
                const price = parseFloat($(this).find('.product-price').text());
                const qty = parseInt($(this).find('input[name$="[qty]"]').val()) || 0;
                total += price * qty;
                totalQty += qty;
            });
            $('#totalPrice').text(total.toFixed(2));
            $('#totalInput').val(total.toFixed(2));
            $('#totalQty').text(totalQty);
            $('#totalQtyInput').val(totalQty);
        }
        $(document).ready(function() {
            $('#productsc').change(function() {
                var selectedOption = $(this).find('option:selected');
                var productId = selectedOption.val();
                var productName = selectedOption.data('name');
                var productPrice = selectedOption.data('price');
                if (productId) {
                    var existingRow = $('#productTable').find('input[name$="[id]"][value="' + productId +
                        '"]').closest('tr');
                    if (existingRow.length > 0) {
                        var qtyInput = existingRow.find('input[name$="[qty]"]');
                        qtyInput.val(parseInt(qtyInput.val()) + 1);
                    } else {
                        var index = $('#productTable tr').length;

                        var newRow = `<tr>
                                <td>${productName}</td>
                                <td class="product-price">${productPrice}</td>
                                <td><input type="number" name="products[${index}][qty]" class="form-control" required value="1"></td>
                                <td>
                                    <button type="button" class="btn btn-danger remove-row">Remove</button>
                                </td>
                                <input type="hidden" name="products[${index}][id]" value="${productId}">
                                <input type="hidden" name="products[${index}][cost]" value="${productPrice}">
                              </tr>`;
                        $('#productTable').append(newRow);
                    }

                    // Reset the dropdown to its default option
                    $(this).val('');

                    // Recalculate total
                    calculateTotal();
                }
            });

            $(document).on('input', 'input[name$="[qty]"]', function() {
                calculateTotal();
            });

            $(document).on('click', '.remove-row', function() {
                $(this).closest('tr').remove();
                calculateTotal();
            });

        });
    </script>

@endsection
