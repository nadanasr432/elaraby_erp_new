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
</style>
@section('content')
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
    <div class="row p-0">
        <div class="col-md-12">
            <div class="card">
                <!------HEADER----->
                <div class="card-header border-bottom border-secondary p-1">
                    <div class="d-flex justify-content-between align-items-baseline">
                        <h3 class="pull-right font-weight-bold ml-1">
                            تعديل باينات المنتج
                        </h3>
                        <a class="btn btn-danger btn-sm pull-left p-1" onclick="history.back()">
                            عودة للخلف
                        </a>
                    </div>
                </div>

                <!------HEADER----->
                <div class="card-body p-2">
                    <form class="parsley-style-1" id="selectForm2" name="selectForm2"
                        action="{{ route('client.products.update', $product->id) }}" enctype="multipart/form-data"
                        method="POST">
                        @method('PUT')
                        {{ csrf_field() }}
                        <input type="hidden" name="company_id" value="{{ $company_id }}">
                        <div class="alert alert-danger" id="showErrMsg" style="display:none">

                        </div>

                        <div class="row p-0">
                            <!-- Form Input for Start Date and End Date -->
                            <div class="form-group col-lg-6">
                                <label for="start_date">{{ __('Start Date') }}</label>
                                <input type="date" class="form-control" id="start_date" name="start_date"
                                    value="{{ old('start_date', $product->start_date ?? '') }}">
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="end_date">{{ __('End Date') }}</label>
                                <input type="date" class="form-control" id="end_date" name="end_date"
                                    value="{{ old('end_date', $product->end_date ?? '') }}">
                            </div>
                            <!----store---->
                            <div class="form-group col-lg-3 pr-0" dir="rtl">
                                <label for="store_id">
                                    {{ __('products.store_name') }}
                                    <span class="text-danger font-weight-bold">*</span>
                                </label>
                                <select required name="store_id" id="store" class="form-control">
                                    <option value="">{{ __('products.choose_store') }}</option>
                                    @foreach ($stores as $store)
                                        <option @if ($store->id == $product->store_id) selected @endif
                                            value="{{ $store->id }}">{{ $store->store_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!---------------------->

                            <!----category_id---->
                            <div class="form-group col-lg-3 pr-0" dir="rtl">
                                <label for="category_id">
                                    {{ __('products.main_cat') }}
                                    <span class="text-danger font-weight-bold">*</span>
                                </label>
                                <select required name="category_id" id="category" class="form-control">
                                    <option value="">{{ __('products.choose_main_cat') }}</option>
                                    @foreach ($categories as $i => $category)
                                        <option type="{{ $category->category_type }}" value="{{ $category->id }}"
                                            {{ old('category_id', $product->category_id ?? ($i == 0 && $categories->count() > 1 ? $category->id : null)) == $category->id ? 'selected' : '' }}>
                                            {{ $category->category_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!---------------------->

                            <!----sub_category---->
                            <div class="form-group col-lg-3 pr-0" dir="rtl">
                                <label for="store_id">
                                    {{ __('products.subcat') }}
                                    <span class="text-danger font-weight-bold">*</span>
                                </label>
                                <select name="sub_category_id" id="sub_category" class="form-control">
                                    <option value="">{{ __('products.choose_subcat') }}</option>
                                    @foreach ($sub_categories as $category)
                                        <option @if ($category->id == $product->sub_category_id) selected @endif
                                            value="{{ $category->id }}">
                                            {{ $category->sub_category_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <!-------------------->

                            <!----product_model---->
                            <div class="form-group col-lg-3 pr-0" dir="rtl">
                                <label>{{ __('products.pmodel') }}</label>
                                <input type="text" name="product_model" value="{{ $product->product_model }}"
                                    placeholder="{{ __('products.pmodel') }}" class="form-control" id='model'>
                            </div>
                            <!---------------------->

                            <!----product_name---->
                            <div class="form-group col-lg-3 pr-0" dir="rtl">
                                <label>
                                    {{ __('products.pname') }}
                                    <span class="text-danger font-weight-bold">*</span>
                                </label>
                                <input type="text" name="product_name" id="order_name"
                                    placeholder="{{ __('products.pname') }}" value="{{ $product->product_name }}"
                                    class="form-control" required>
                            </div>
                            <div class="form-group col-lg-3 pr-0" dir="rtl">
                                <label>
                                    {{ __('products.pname_en') }}
                                </label>
                                <input type="text" name="product_name_en" id="order_name"
                                    placeholder="{{ __('products.pname_en') }}" class="form-control" value="{{ $product->product_name_en }}">
                            </div>
                            <!---------------------->

                            <!----unit_id---->
                            <div class="form-group col-lg-3 pr-0">
                                <label>
                                    {{ __('products.punit') }}
                                    <!--<span class="text-danger font-weight-bold">*</span>-->
                                </label>
                                <select name="unit_id" class="form-control">
                                    <option value="">{{ __('products.choseunit') }}</option>
                                    @foreach ($units as $unit)
                                        <option value="{{ $unit->id }}"
                                            @if ($unit->id == $product->unit_id) selected @endif>{{ $unit->unit_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <!---------------------->

                            <!----code_universal---->
                            <div class="form-group col-lg-3 pr-0" dir="rtl">
                                <label>
                                    {{ __('products.barcodenum') }}
                                    <!--<span class="text-danger font-weight-bold">*</span>-->
                                </label>
                                <input type="text" class="form-control" value="{{ $product->code_universal }}"
                                    dir="ltr" placeholder="{{ __('products.barcodenum') }}" id="order_universal"
                                    name="code_universal" />
                            </div>
                            <!---------------------->

                            <!----first_balance---->
                            <div class="form-group col-lg-3 pr-0" dir="rtl">
                                <label>
                                    {{ __('products.storeqty') }}
                                    <span class="text-danger font-weight-bold">*</span>
                                </label>
                                <input type="number" step="0.01" required
                                    placeholder=" {{ __('products.storeqty') }} " name="first_balance"
                                    id="first_balance" value="{{ $product->first_balance }}" class="form-control">
                            </div>
                            <!---------------------->

                            <!----purchasing_price--->
                            <div class="form-group col-lg-3 pr-0" dir="rtl">
                                <label>
                                    {{ __('products.costprice') }}
                                    <!--<span class="text-danger font-weight-bold">*</span>-->
                                </label>
                                <input type="number" step="0.01" name="purchasing_price" id='purchasing_price'
                                    class="form-control" value="{{ $product->purchasing_price }}"
                                    placeholder=" {{ __('products.costprice') }}">
                            </div>
                            <!---------------------->

                            <!----wholesale_price--->
                            <div class="form-group col-lg-3 pr-0" dir="rtl">
                                <label>
                                    {{ __('products.wholeprice') }}
                                    <!--<span class="text-danger font-weight-bold">*</span>-->
                                </label>
                                <input type="number" step="0.01" name="wholesale_price" id="wholesale_price"
                                    class="form-control" value="{{ $product->wholesale_price }}"
                                    placeholder="{{ __('products.wholeprice') }}">
                            </div>
                            <!-------------------->

                            <!----sector_price--->
                            <div class="form-group col-lg-3 pr-0" dir="rtl">
                                <label>
                                    {{ __('products.sectorprice') }}
                                    <!--<span class="text-danger font-weight-bold">*</span>-->
                                </label>
                                <input type="number" step="0.01" name="sector_price"
                                    placeholder=" {{ __('products.sectorprice') }}" id="sector_price"
                                    value="{{ $product->sector_price }}" class="form-control">
                            </div>
                            <!-------------------->

                            <!----min_balance--->
                            <div class="form-group pull-right col-lg-3" dir="rtl">
                                <label>{{ __('products.minimumqty') }}</label>
                                <input type="number" step="0.01" name="min_balance" id="min_balance"
                                    class="form-control" value="{{ $product->min_balance }}" />
                            </div>
                            <!-------------------->

                            <!-------color------->
                            <div class="form-group  col-lg-6 d-none" dir="rtl">
                                <label>{{ __('products.choosecolor') }}</label>
                                <input style="width: 100%!important;" type="color"
                                    placeholder="{{ __('products.choosecolor') }}" name="color" id="color" />
                            </div>
                            <!---------------------->

                            <!----description---->
                            <div class="form-group col-lg-6" dir="rtl">
                                <label>{{ __('products.pdesc') }}</label>
                                <textarea name="description" id="description" class="form-control" placeholder="وصف المنتج. . . ."
                                    style="height: 60% !important;" rows="2">{{ $product->description }}</textarea>
                            </div>
                            <!-------------------->

                            <div class="form-group col-lg-6 pull-right" dir="rtl">
                                <label>{{ __('products.pimg') }}</label>
                                <input accept=".jpg,.png,.jpeg" type="file" name="product_pic"
                                    oninput="pic.src=window.URL.createObjectURL(this.files[0])" id="file"
                                    class="form-control">
                                <label class="d-block mt-2">{{ __('products.previewimg') }}</label>
                                <img id="pic" src="{{ asset($product->product_pic) }}"
                                    style="width: 100px; height:100px;" />
                            </div>
                            <!---------------------->

                        </div>
                        <!--ROW END-->
                        <div class="row">
                            <!---------------------->
                            <!-- Hidden input fields for combo products -->
                            <div id="hiddenProductFields"></div>

                            <!-- Add the select input and new table container -->
                            <div class="form-group col-lg-6" dir="rtl" id="searchContainer" style="display: none;">
                                <label class="col-lg-6">{{ __('Search Products') }}</label>
                                <select class="selectpicker" data-style="btn-success" data-live-search="true"
                                    id="productSearch">
                                    <option value="" disabled selected>{{ __('Search Products') }}</option>
                                </select>
                            </div>
                            <!-- Add this div for the checkbox -->
                            <div class="form-check form-switch col-lg-6 mt-2" id="checkboxContainer"
                                style="display: none;">
                                <input class="form-check-input" type="checkbox" id="mySwitch" name="manufacturer"
                                    value="0">
                                <label class="form-check-label ml-4" for="mySwitch"
                                    style="font-size: 18px !important">manufacture</label>
                            </div>
                        </div>


                        <!-- Add this after the search input -->
                        <div class="col-lg-12" id="newTableContainer" style="display: none;">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>{{ __('products.pname') }}</th>
                                        <th>{{ __('products.costprice') }}</th>
                                        <th>{{ __('products.storeqty') }}</th>
                                        <th>{{ __('products.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody id="newTableBody">

                                </tbody>
                            </table>
                        </div>



                        <button class="btn btn-md btn-success w-100 font-weight-bold" type="submit">تحديث</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script src="{{ asset('app-assets/js/jquery.min.js') }}"></script>    <script src="https://cdn.ckeditor.com/ckeditor5/38.0.1/classic/ckeditor.js"></script>

    <script>
         ClassicEditor.create(document.querySelector('#description'), {
                language: 'ar',
                toolbar: [
                    'heading', 'bold', 'italic', 'underline', 'strikethrough', '|',
                    'link', 'bulletedList', 'numberedList', 'blockQuote', '|',
                    'insertTable', 'tableColumn', 'tableRow', 'mergeTableCells', '|',
                    'undo', 'redo', 'alignment', 'fontColor', 'fontBackgroundColor', '|',
                    'mediaEmbed', 'imageUpload', 'codeBlock'
                ], // Set language to Arabic for RTL support
            })
            .catch(error => {
                console.error(error);
            });
        $("#selectForm2").submit(function(e) {
            e.preventDefault();

            var first_balance = $("#first_balance").val();
            var purchasing_price = $("#purchasing_price").val();
            var wholesale_price = $("#wholesale_price").val();
            var sector_price = $("#sector_price").val();
            var min_balance = $("#min_balance").val();


            if (isNaN(first_balance)) {
                $("#showErrMsg").text(" number only !! غير مسموح بالاحرف في هذا الحقل ارقام فقط!!");
                $("#showErrMsg").show("slow");
                $("#first_balance").css("border-color", "red");
                $("#first_balance").val("");


                setTimeout(function() {
                    $("#showErrMsg").hide("slow");
                }, 4000);

                return false;
            } else {
                $("#first_balance").css("border-color", "#CACFE7");
            }


            if (isNaN(purchasing_price)) {
                $("#showErrMsg").text(" number only !!غير مسموح بالاحرف في هذا الحقل ارقام فقط!!");
                $("#showErrMsg").show("slow");
                $("#purchasing_price").css("border-color", "red");
                $("#purchasing_price").val("");


                setTimeout(function() {
                    $("#showErrMsg").hide("slow");
                }, 4000);

                return false;
            } else {
                $("#purchasing_price").css("border-color", "#CACFE7");
            }

            if (isNaN(wholesale_price)) {
                $("#showErrMsg").text(" number only !!غير مسموح بالاحرف في هذا الحقل ارقام فقط!!");
                $("#showErrMsg").show("slow");
                $("#wholesale_price").css("border-color", "red");
                $("#wholesale_price").val("");


                setTimeout(function() {
                    $("#showErrMsg").hide("slow");
                }, 4000);

                return false;
            } else {
                $("#wholesale_price").css("border-color", "#CACFE7");
            }

            if (isNaN(sector_price)) {
                $("#showErrMsg").text(" number only !! غير مسموح بالاحرف في هذا الحقل ارقام فقط!!");
                $("#showErrMsg").show("slow");
                $("#sector_price").css("border-color", "red");
                $("#sector_price").val("");


                setTimeout(function() {
                    $("#showErrMsg").hide("slow");
                }, 4000);

                return false;
            } else {
                $("#sector_price").css("border-color", "#CACFE7");
            }

            if (isNaN(min_balance)) {
                $("#showErrMsg").text(" number only !! غير مسموح بالاحرف في هذا الحقل ارقام فقط!!");
                $("#showErrMsg").show("slow");
                $("#min_balance").css("border-color", "red");
                $("#min_balance").val("");


                setTimeout(function() {
                    $("#showErrMsg").hide("slow");
                }, 4000);

                return false;
            } else {
                $("#min_balance").css("border-color", "#CACFE7");
            }

            $(this).submit();

        });


        $('#category').on('change', function() {
            var category_name = $(this).val();
            var category_type = $(this).children("option:selected").attr('type');
            if (category_type == 'خدمية') {
                $('#first_balance').val("").attr('readonly', true);
                $('#model').val("").attr('readonly', false);
                // $('#order_universal').val("").attr('readonly', true);
                $('#min_balance').attr('readonly', true);
                $('#store').attr('disabled', true);
                $('#start_date').attr('disabled', true);
                $('#end_date').attr('disabled', true);
                $('#purchasing_price').val("0").attr('readonly', true);
            } else {
                $('#first_balance').attr('readonly', false);
                $('#model').attr('readonly', false);
                $('#order_universal').attr('readonly', false);
                $('#min_balance').attr('readonly', false);
                $('#store').attr('disabled', false);
                $('#start_date').attr('disabled', false);
                $('#end_date').attr('disabled', false);
                $('#purchasing_price').attr('disabled', false);
            }
        });

        // Trigger the change event automatically on page load
        $('#category').trigger('change');
        $(document).ready(function() {
            function performSearch() {
                var query = $('#productSearch').val();

                $.ajax({
                    url: '{{ route('client.products.search') }}',
                    method: 'GET',
                    data: {
                        query: query
                    },
                    dataType: 'json',
                    success: function(data) {
                        var searchResults =
                            '<option value="" disabled selected>{{ __('Search Products') }}</option>';
                        $.each(data, function(index, product) {
                            searchResults += '<option value="' + product.id +
                                '" data-product-name="' + product.product_name +
                                '" data-product-cost="' + product.purchasing_price +
                                '" data-product-qty="' + product.first_balance + '">' + product
                                .product_name + '</option>';
                        });
                        $('#productSearch').html(searchResults).selectpicker('refresh');
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }

            $('#mySwitch').change(function() {
                $(this).val($(this).is(':checked') ? '1' : '0');
            });

            $('#productSearch').on('input', performSearch);

            $('#category').change(function() {
                var categoryType = $(this).children("option:selected").attr('type');
                if (categoryType === 'مجمع') {
                    $('#searchContainer').show();
                    $('#newTableContainer').show();
                    $('#checkboxContainer').show();
                    performSearch();
                } else {
                    $('#searchContainer').hide();
                    $('#newTableContainer').hide();
                    $('#checkboxContainer').hide();
                    $('#productSearch').empty().selectpicker('refresh');
                }
            });

            function addProductToTable(productId, productName, purchasingPrice, storeQty) {
                var newRow = '<tr data-product-id="' + productId + '">' +
                    '<td>' + productName + '</td>' +
                    '<td><input type="number" step="0.01" class="form-control edit-cost-price" value="' +
                    purchasingPrice + '"></td>' +
                    '<td><input type="number" step="0.01" class="form-control edit-store-qty" value="' + storeQty +
                    '"></td>' +
                    '<td><button class="btn btn-danger delete-product-btn">Delete</button></td>' +
                    '</tr>';
                $('#newTableBody').append(newRow);
                addHiddenProductFields(productId, purchasingPrice, storeQty);
            }

            function addHiddenProductFields(productId, purchasingPrice, storeQty) {
                var hiddenFields = '<input type="hidden" name="combo_products[' + productId +
                    '][product_id]" value="' + productId + '">' +
                    '<input type="hidden" name="combo_products[' + productId + '][price]" value="' +
                    purchasingPrice + '">' +
                    '<input type="hidden" name="combo_products[' + productId + '][quantity]" value="' + storeQty +
                    '">';
                $('#hiddenProductFields').append(hiddenFields);
            }

            function removeHiddenProductFields(productId) {
                $('#hiddenProductFields input[name^="combo_products[' + productId + ']"]').remove();
            }

            $(document).on('change', '#productSearch', function() {
                var selectedOption = $(this).find('option:selected');
                var productId = selectedOption.val();
                var productName = selectedOption.data('product-name');
                var purchasingPrice = selectedOption.data('product-cost');
                var storeQty = selectedOption.data('product-qty');

                if (productId) {
                    $('#newTableContainer').show();
                    $('#checkboxContainer').show();
                    addProductToTable(productId, productName, purchasingPrice, storeQty);
                    $(this).val('').selectpicker('refresh');
                }
            });

            $(document).on('click', '.delete-product-btn', function() {
                var productId = $(this).closest('tr').data('product-id');
                $(this).closest('tr').remove();
                removeHiddenProductFields(productId);
            });

            $('.selectpicker').selectpicker();
        });
    </script>

@endsection
