@extends('client.layouts.app-pos')
<style>
    .ekt4fstyle {
        font-family: Cairo;
        font-size: 20px;
        font-weight: 500;
    }

    .rounded {
        border-radius: 5px !important;
    }

    h4.ekt4fstyle {
        font-family: Cairo;
        font-size: 17px;
        width: 100%;
        padding: 10px;
        border-radius: 7px;
        font-weight: 500;
        border: 1px solid #e5e5e5e5;
    }

    h4.ekt4fstyle svg {
        top: 3px;
        position: relative;
    }

    .badge-lightnew {
        background: rgba(229, 241, 255, 0.51) !important;
        color: #0A246A !important;
        font-weight: 500 !important;
        font-size: 13px !important;
    }

    .newdark {
        background: #0A246A !important;
        color: white !important;
        font-size: 13px !important;
    }

    .m-nos {
        margin: 4px;
    }

    .circle {
        border-radius: 10px !important;
    }

    .imgBox {
        height: 95px;
        width: 100%;
    }

    .imgBox2 {
        width: 99px;
        height: 100%;
    }

    .imgBox img {
        height: 100%;
        width: 100%;
        object-fit: cover;
    }

    .cbod {
        padding: 6px !important;
    }

    .ctitle {
        color: #0A246A;
        font-weight: 600 !important;
    }

    .ctitle,
    .ctxt {
        margin-bottom: 3px !important;
    }

    .cproduct {
        box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
        border: 1px solid rgba(229, 229, 229, 0.4) !important;
        min-height: 179px;
        max-height: 179px;
        width: 12rem;
    }

    .plusIcon {
        width: 19px;
        display: inline-block;
        text-align: center;
        height: 20px;
        border-radius: 10px;
        color: white;
        background: #0A246A;
    }

    .minusIcon {
        width: 19px;
        display: inline-block;
        text-align: center;
        height: 21px;
        border-radius: 10px;
        color: #0A246A;
        background: rgba(224, 224, 224, 0.59);
    }

    .p-nos {
        padding: 5px !important;
    }

    .mt-nos {
        margin-top: 5px !important;
    }

    .mb-nos {
        margin-bottom: 5px !important;
    }

    .pt-nos {
        padding-top: 5px !important;
    }

    .pb-nos {
        padding-bottom: 5px !important;
    }

    .pr-nos {
        padding-left: 5px !important;
    }

    .pl-nos {
        padding-right: 5px !important;
    }

    .lineProduct {
        margin-right: 5px;
        padding-left: 11px;
        box-shadow: rgb(255 185 190 / 10%) 5px 7px 29px 0px;
        border-radius: 10px;
        margin-bottom: 10px;
    }

    .inv-items {
        min-height: 280px;
        max-height: 280px;
        overflow-y: scroll;
        overflow-x: hidden;
    }

    .text-new {
        color: #0A246A;
        font-weight: 500;
    }

    .actionBtn {
        font-size: 11px !important;
        border-radius: 10px !important;
        overflow: hidden;
        width: 8.5rem;
        height: 5.7rem;
    }

    .card .card-title {
        font-size: 1rem !important;
    }

    .sub_categories {
        border-top: 1px solid #2d2d2d2d;
        width: 99% !important;
        margin: auto !important;
        margin-right: -8px !important;
    }

    .alert-danger {
        border-color: #ff9aa4 !important;
        background-color: #ffe2e2 !important;
        color: #960014 !important;
        margin-bottom: 1px !important;
        width: 100%;
    }

    .products {
        min-height: 640px !important;
        max-height: 640px !important;
        overflow-y: scroll;
    }

    /* width */
    ::-webkit-scrollbar {
        width: 10px !important;
        display: none;
    }

    .table th,
    .table td {
        padding: 9px 5px !important;
        font-size: 11px !important;
    }

    .category,
    .sub_category {
        cursor: pointer;
    }

    .table thead th {
        vertical-align: bottom !important;
        border-bottom: 0px solid #E3EBF3 !important;
        border-top: 1px solid #E3EBF3 !important;
    }

    .table-bordered th,
    .table-bordered td {
        border: 1px solid #ffffff45;
    }

    .dropdown-menu.show {
        transform: translate3d(0px, 39px, 0px) !important;
        min-width: 28px !important;
    }

    .dropdown-menu.inner.show {
        margin-top: -40px !important;
    }

    .inner.show {
        min-height: 159px !important;
    }
    .payment .filter-option-inner-inner{
        color: #fff !important
    }
    .searchproducts .filter-option{
        background-color: #F4F5FA !important
    }
    .filter-option{
        display: flex;
    align-items: center;
    justify-content: end;
    }
</style>
@section('content')
    <div class="row mt-5 mb-5">

        <div class="col-md-7 py-1 px-1 pl-1">
            <div class="inner-sectoin bg-white rounded px-1" style="border: 1px solid #2d2d2d1f;height: 100%;">

                <div class="section-header">
                    <div class="row justify-content-between px-2 pb-0 pt-1">
                        <h3 class="ekt4fstyle">اكتشف افضل المنتجات</h3>
                        <a href="#"
                            class="text-warning font-weight-bold getSubCatsWithProducts cursor_pointer bg-white">عرض
                            الكل</a>

                    </div>
                </div>

                <div class="section-pro-content">
                    <div class="cat-section">
                        <div class="row p-nos px-1">
                            <div class="col-md-8">
                                <span
                                    class="category getSubCatsWithProducts m-nos p-1 circle badge badge-lightnew newdark cursor_pointer">
                                    الكل
                                </span>
                                @foreach ($categories as $cat)
                                    <span category_id="{{ $cat->id }}"
                                        class="category m-nos p-1 circle badge badge-lightnew cursor_pointer">
                                        {{ $cat->category_name }}
                                    </span>
                                @endforeach
                            </div>
                            <div class="col-md-4 d-flex justify-content-end mb-1">
                                <a href="#" class="btn btn-warning p-1" data-toggle="modal"
                                    data-target="#addProductModal" title="{{ __('main.add_product') }}">
                                    <i class="fa fa-plus"></i>
                                </a>
                                <!-- Add Product Modal -->
                                <div class="modal fade" id="addProductModal" tabindex="-1" role="dialog"
                                    aria-labelledby="addProductModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="addProductModalLabel">{{ __('Add Product') }}
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form class="parsley-style-1" id="selectForm2" name="selectForm2"
                                                    action="{{ route('pos.product.store') }}" enctype="multipart/form-data"
                                                    method="post">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="company_id" value="{{ $company_id }}">
                                                    <div class="alert alert-danger" id="showErrMsg" style="display:none">

                                                    </div>

                                                    <div class="row p-0">
                                                        <!-- Form Input for Start Date and End Date -->
                                                        <div class="form-group col-lg-6" style="display: none">
                                                            <label for="start_date">{{ __('Start Date') }}</label>
                                                            <input type="date" class="form-control" id="start_date"
                                                                name="start_date">
                                                        </div>
                                                        <div class="form-group col-lg-6" style="display: none">
                                                            <label for="end_date">{{ __('End Date') }}</label>
                                                            <input type="date" class="form-control" id="end_date"
                                                                name="end_date">
                                                        </div>

                                                        <!----store---->
                                                        <div class="form-group col-lg-3 " dir="rtl">
                                                            <label for="store_id">

                                                                {{ __('products.store_name') }}
                                                                <span class="text-danger font-weight-bold">*</span>
                                                            </label>
                                                            <select required name="store_id" id="store"
                                                                class="form-control">
                                                                <option value="" >{{ __('products.choose_store') }}
                                                                </option>
                                                                <?php $i = 0; ?>
                                                                @foreach ($stores as $store)
                                                                    @if ($stores->count() == 1)
                                                                        <option selected  value="{{ $store->id }}">
                                                                            {{ $store->store_name }}</option>
                                                                    @else
                                                                        @if ($i == 0)
                                                                            <option selected value="{{ $store->id }}">
                                                                                {{ $store->store_name }}
                                                                            </option>
                                                                        @else
                                                                            <option value="{{ $store->id }}">
                                                                                {{ $store->store_name }}</option>
                                                                        @endif
                                                                    @endif
                                                                    <?php $i++; ?>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <!---------------------->

                                                        <!----category_id---->
                                                        <div class="form-group col-lg-3 " dir="rtl">
                                                            <label for="store_id">
                                                                {{ __('products.main_cat') }}
                                                                <span class="text-danger font-weight-bold">*</span>
                                                            </label>
                                                            <select required name="category_id" id="category"
                                                                class="form-control">
                                                                <option value="">{{ __('products.choose_main_cat') }}
                                                                </option>
                                                                <?php $i = 0; ?>
                                                                @foreach ($categories as $category)
                                                                    @if ($categories->count() == 1)
                                                                        <option type="{{ $category->category_type }}"
                                                                            selected value="{{ $category->id }}">
                                                                            {{ $category->category_name }}
                                                                        </option>
                                                                    @else
                                                                        @if ($i == 0)
                                                                            <option type="{{ $category->category_type }}"
                                                                                selected value="{{ $category->id }}">
                                                                                {{ $category->category_name }}
                                                                            </option>
                                                                        @else
                                                                            <option type="{{ $category->category_type }}"
                                                                                value="{{ $category->id }}">
                                                                                {{ $category->category_name }}
                                                                            </option>
                                                                        @endif
                                                                    @endif
                                                                    <?php $i++; ?>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <!---------------------->

                                                        <!----sub_category---->
                                                        <div class="form-group col-lg-3 " dir="rtl">
                                                            <label for="store_id">
                                                                {{ __('products.subcat') }}

                                                            </label>
                                                            <select name="sub_category_id" id="sub_category"
                                                                class="form-control">
                                                                <option value="">{{ __('products.choose_subcat') }}
                                                                </option>
                                                                @foreach ($sub_categories as $category)
                                                                    <option value="{{ $category->id }}">
                                                                        {{ $category->sub_category_name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <!-------------------->

                                                        <!----product_model---->
                                                        <div class="form-group col-lg-3 " dir="rtl"
                                                            style="display: none">
                                                            <label>{{ __('products.pmodel') }}</label>
                                                            <input type="text" name="product_model"
                                                                placeholder="موديل المنتج" class="form-control"
                                                                id='model'>
                                                        </div>
                                                        <!---------------------->

                                                        <!----product_name---->
                                                        <div class="form-group col-lg-3 " dir="rtl">
                                                            <label>
                                                                {{ __('products.pname') }}
                                                                <span class="text-danger font-weight-bold">*</span>
                                                            </label>
                                                            <input type="text" name="product_name" id="order_name"
                                                                placeholder="{{ __('products.pname') }}"
                                                                class="form-control" required>
                                                        </div>
                                                        <!---------------------->

                                                        <!----unit_id---->
                                                        <div class="form-group col-lg-3 ">
                                                            <label>
                                                                {{ __('products.punit') }}
                                                                <span class="text-danger font-weight-bold">*</span>
                                                            </label>
                                                            <select name="unit_id" class="form-control">
                                                                <option value="">{{ __('products.choseunit') }}
                                                                </option>
                                                                @foreach ($units as $unit)
                                                                    <option value="{{ $unit->id }}">
                                                                        {{ $unit->unit_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <!---------------------->

                                                        <!----code_universal---->
                                                        <div class="form-group col-lg-3 " dir="rtl">
                                                            <label>
                                                                {{ __('products.barcodenum') }}
                                                                <span class="text-danger font-weight-bold">*</span>
                                                            </label>
                                                            <input type="text" class="form-control"
                                                                value="{{ $code_universal }}" dir="ltr"
                                                                placeholder="{{ __('products.barcodenum') }}"
                                                                id="order_universal" name="code_universal" />
                                                        </div>
                                                        <!---------------------->

                                                        <!----first_balance---->
                                                        <div class="form-group col-lg-3 " dir="rtl">
                                                            <label>
                                                                {{ __('products.storeqty') }}
                                                                <span class="text-danger font-weight-bold">*</span>
                                                            </label>
                                                            <input type="number" step="0.01"
                                                                placeholder="{{ __('products.storeqty') }}"
                                                                name="first_balance" id="first_balance" value="0"
                                                                class="form-control" required>
                                                        </div>
                                                        <!---------------------->

                                                        <!----purchasing_price--->
                                                        <div class="form-group col-lg-3 " dir="rtl">
                                                            <label>
                                                                {{ __('products.costprice') }}
                                                                <span class="text-danger font-weight-bold">*</span>
                                                            </label>
                                                            <input type="number" step="0.01" name="purchasing_price"
                                                                id='purchasing_price' value="0" class="form-control"
                                                                placeholder="{{ __('products.costprice') }}">
                                                        </div>
                                                        <!---------------------->

                                                        <!----wholesale_price--->
                                                        <div class="form-group col-lg-3 " dir="rtl">
                                                            <label>
                                                                {{ __('products.wholeprice') }}
                                                                <span class="text-danger font-weight-bold">*</span>
                                                            </label>
                                                            <input type="number" step="0.01" name="wholesale_price"
                                                                value="0" id="wholesale_price" class="form-control"
                                                                placeholder="{{ __('products.wholeprice') }}">
                                                        </div>
                                                        <!-------------------->

                                                        <!----sector_price--->
                                                        <div class="form-group col-lg-3 " dir="rtl">
                                                            <label>
                                                                {{ __('products.sectorprice') }}
                                                                <span class="text-danger font-weight-bold">*</span>
                                                            </label>
                                                            <input type="number" step="0.01" value="0"
                                                                name="sector_price"
                                                                placeholder="{{ __('products.sectorprice') }}"
                                                                id="sector_price" class="form-control">
                                                        </div>
                                                        <!-------------------->

                                                        <!----min_balance--->
                                                        <div class="form-group pull-right col-lg-3" dir="rtl">
                                                            <label>{{ __('products.minimumqty') }}</label>
                                                            <input type="number" step="0.01" value="0"
                                                                name="min_balance" id="min_balance"
                                                                class="form-control" />
                                                        </div>
                                                        <!-------------------->

                                                        <!-------color------->
                                                        <div class="form-group  col-lg-6 d-none" dir="rtl">
                                                            <label>{{ __('products.choosecolor') }}</label>
                                                            <input style="width: 100%!important;" type="color"
                                                                placeholder="{{ __('products.choosecolor') }}"
                                                                name="color" id="color" />
                                                        </div>
                                                        <!---------------------->

                                                        <!----description---->
                                                        <div class="form-group col-lg-6" dir="rtl"
                                                            style="display: none">
                                                            <label>{{ __('products.pdesc') }}</label>
                                                            <textarea name="description" id="description" class="form-control" placeholder="{{ __('products.pdesc2') }}"
                                                                style="height: 60% !important;" rows="2"></textarea>
                                                        </div>
                                                        <!-------------------->

                                                        <div class="form-group col-lg-6 pull-right" dir="rtl"
                                                            style="display: none">
                                                            <label>{{ __('products.pimg') }}</label>
                                                            <input accept=".jpg,.png,.jpeg" type="file"
                                                                name="product_pic"
                                                                oninput="pic.src=window.URL.createObjectURL(this.files[0])"
                                                                id="file" class="form-control">
                                                            <label class="d-block mt-2">
                                                                {{ __('products.previewimg') }}</label>
                                                            <img id="pic" style="width: 100px; height:100px;" />
                                                        </div>
                                                        <!---------------------->

                                                    </div>
                                                    <!--ROW END-->
                                                    <div class="row">
                                                        <!---------------------->
                                                        <!-- Hidden input fields for combo products -->
                                                        <div id="hiddenProductFields"></div>

                                                        <!-- Add the select input and new table container -->
                                                        <div class="form-group col-lg-6" dir="rtl"
                                                            id="searchContainer" style="display: none;">
                                                            <label class="col-lg-6">{{ __('Search Products') }}</label>
                                                            <select class="selectpicker" data-style="btn-warning"
                                                                data-live-search="true" id="productSearch">
                                                                <option value="" disabled selected>
                                                                    {{ __('Search Products') }}</option>
                                                            </select>
                                                        </div>
                                                        <!-- Add this div for the checkbox -->
                                                        <div class="form-check form-switch col-lg-6 mt-2"
                                                            id="checkboxContainer" style="display: none;">
                                                            <input class="form-check-input" type="checkbox"
                                                                id="mySwitch" name="manufacture" value="0">
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



                                                    <button class="btn btn-md btn-warning w-100 font-weight-bold"
                                                        type="submit">{{ __('products.add') }}</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row p-nos sub_categories" style="display: none;">
                        </div>
                    </div>
                    <hr class="m-0">
                    <div class="tab-content">
                        <div class="tab-pane fade p-1" id="nav-bills" role="tabpanel" aria-labelledby="nav-bills-tab">
                            <p class="alert alert-warning alert-sm text-center">
                                {{ __('pos.if-an-invoice-number-is-modified,-the-current-open-invoice-will-be-suspended') }}
                            </p>
                            <div class="row mb-3">
                                <div class="col-lg-6 pull-right">
                                    <div class="form-group">
                                        <label for="" class="d-block">{{ __('main.invoice') }}</label>
                                        <select class="form-control selectpicker" data-live-search="true"
                                            title="{{ __('main.invoice') }}" data-style="btn-danger" name="bill_id"
                                            id="bill_id" dir="rtl">
                                            @foreach ($bills as $bill)
                                                <option value="{{ $bill->id }}">({{ $bill->id }})
                                                    @if (isset($bill->outerClient->client_name))
                                                        ({{ $bill->outerClient->client_name }})
                                                    @endif
                                                    ({{ $bill->created_at }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 pull-right" style="padding-top:25px">
                                    <div class="form-group">
                                        <button class="btn btn-md btn-info edit_bill">
                                            <i class="fa fa-edit"></i>
                                            {{ __('pos.edit-invoice') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <p id="msg" class="alert alert-sm alert-danger text-center" style="font-size: 14px;">
                            </p>
                        </div>
                    </div>
                    <div class="prod-section p-nos">
                        <h5 class="mt-2 text-center loadingH" style="display: none;">
                            جاري التحميل ...
                        </h5>
                        <div class="row justify-content-center products" style="background: #f7fafc;">

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-5 py-1 px-0">
            <div class="inner-sectoin bg-white rounded px-2 pl-nos py-1" style="border: 1px solid #2d2d2d1f;">
                <div class="section bg-white border-0">
                    <div class="mb-nos">
                        <div class=" d-flex justify-content-between align-items-center my-1 p-1 bg-white" style="border: 1px solid #a1a1a11f; border-radius:5px;">

                            <h5 class="font-weight-bold m-0">
                                <svg style="margin-left: 5px;" fill="#0A246A" width="10"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                    <path
                                        d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z">
                                    </path>
                                </svg>
                                اختر العميل
                            </h5>
                            <a href="#" class="btn btn-warning" data-toggle="modal"
                                data-target="#addCustomerModal" title="{{ __('home.Add a client') }}">
                                <i class="fa fa-plus"></i>
                            </a>
                        </div>
                    {{-- modal add client --}}
                    <div class="modal fade" id="addCustomerModal" tabindex="-1" role="dialog"
                        aria-labelledby="addCustomerModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addCustomerModalLabel">{{ __('home.add-customer') }}
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form class="parsley-style-1" id="selectForm2" name="selectForm2"
                                        action="{{ route('pos.outer_clients.store', 'test') }}"
                                        enctype="multipart/form-data" method="post">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="company_id" value="{{ $company_id }}">
                                        <div class="col-lg-6 col-xs-12 pull-right">
                                            <div class="form-group pull-right" dir="rtl">
                                                <label for="order">{{ __('clients.client-name') }} </label>
                                                <input type="text" name="client_name" class="form-control" required>
                                            </div>
                                            <input type="hidden" name="notes[]" class="form-control"
                                                style="width:90%; display: inline; float: right;" dir="rtl">
                                        </div>
                                        <div class="col-lg-6 col-xs-12  pull-left" style="display: none">
                                            <div class="form-group  pull-right col-lg-6" dir="rtl">
                                                <input style="margin-right:5px;margin-left:5px;"type="hidden"
                                                    value="for" name="balance" /> {{ __('main.for') }}
                                                <input style="margin-right:5px;margin-left:5px;" checked type="hidden"
                                                    value="on" name="balance" />
                                                {{ __('main.on') }}
                                                <input required type="hidden"value="0" name="prev_balance"
                                                    class="form-control" step="1" dir="ltr" />
                                            </div>
                                            <div class="form-group pull-right col-lg-6" dir="ltr">
                                                <input type="hidden" name="phones[]" class="form-control"
                                                    style="width:80%; display: inline; float: right;" dir="ltr">


                                                <div class="dom1"></div>
                                            </div>

                                            <div class="form-group pull-right col-lg-12" dir="ltr">
                                                <input type="hidden" name="addresses[]" class="form-control"
                                                    style="width:90%; display: inline; float: right;" dir="rtl">


                                                <div class="dom3"></div>
                                            </div>
                                        </div>
                                        <div class="extras" style="display: none">
                                            <div class="col-lg-12">
                                                <div class="form-group  col-lg-4  pull-right" dir="rtl"
                                                    style="display: none">
                                                    <select name="client_category" class="form-control" required>
                                                        <option value="">{{ __('clients.choose-type') }}
                                                        </option>
                                                        <option selected value="جملة">جملة</option>
                                                        <option value="قطاعى">قطاعى</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-lg-4  pull-right" dir="rtl">
                                                    <input type="hidden" name="client_email" dir="ltr"
                                                        class="form-control">
                                                </div>

                                                <div class="form-group  pull-right col-lg-4" dir="rtl">
                                                    <input type="hidden" name="shop_name" class="form-control"
                                                        dir="rtl">
                                                </div>
                                                <div class="form-group  pull-right col-lg-4" dir="rtl"
                                                    style="display: none">
                                                    <select type="hidden" name="client_national" class="form-control">
                                                        <option value="">{{ __('main.choose-country') }}
                                                        </option>
                                                        @foreach ($timezones as $timezone)
                                                            <option @if ($timezone->country_name == 'السعودية') selected @endif
                                                                value="{{ $timezone->country_name }}">
                                                                {{ $timezone->country_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group  pull-right col-lg-4" dir="rtl">

                                                    <input type="hidden" name="tax_number" class="form-control"
                                                        dir="ltr" />
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-md-12 modal-footer d-flex justify-content-between">
                                            <button class="btn btn-info" type="submit">{{ __('main.add') }}</button>
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">{{ __('home.close') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <select id="outer_client_id" class="selectpicker payment w-100" data-style="btn-warning"
                        data-live-search="true" title="{{ __('pos.choose-client-name') }}" >
                        @foreach ($outer_clients as $outer_client)
                            <option @if ($outer_client->client_name == 'Cash') selected @endif value="{{ $outer_client->id }}">
                                {{ $outer_client->client_name }}
                            </option>
                        @endforeach
                    </select>
                    <select id="product_id" class="selectpicker searchproducts form-control w-100 mt-nos p-0 " 
                        data-live-search="true"
                        title="{{ __('pos.search-for-products-by-code-name-or-using-a-barcode-device') }}"
                        >
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}" data-tokens="{{ $product->code_universal }}"
                                product_name="{{ $product->product_name }}"
                                product_price="{{ $product->sector_price }}">
                                {{ $product->product_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="table-responsive" style=" border:1px solid #f5f5f5;height: 370px; overflow:auto !important;">
                    <table class="table table-striped table-bordered table-condensed table-hover posTable"
                        style="margin-bottom: 0px; padding: 0px;border-collapse:separate;border-spacing:0 3px;">
                        <thead style="background: #FF9149; color: #fff;top: -2px !important; position: relative;">
                            <tr>
                                <th style="width: 30%!important;"> {{ __('main.product-name') }}</th>
                                <th style="width: 15%!important;"> {{ __('main.amount') }}</th>
                                <th style="width: 15%!important;">{{ __('main.quantity') }}</th>
                                <th style="width: 15%!important;"> {{ __('main.discount') }}</th>
                                <th style="width: 6%!important;"> {{ __('main.total') }}</th>
                                <th style="width: 4%!important;text-align: center;">
                                    @if (isset($pos_open) && $pos_open->editing)
                                        {{ __('main.return') }}
                                    @else
                                        {{ __('main.delete') }}
                                    @endif
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bill_details">
                        </tbody>
                    </table>
                </div>
                <table id="totalTable" style="width:100%; float:right; padding:5px; color:#000; background: #FFF;">
                    <tbody>
                        <tr>
                            <td style="padding: 5px 10px;border-top: 1px solid #DDD;width: 30%;"> {{ __('main.items') }}
                            </td>
                            <td class="text-right"
                                style="padding: 5px 10px;font-size: 14px; font-weight:bold;border-top: 1px solid #DDD;width: 30%;">
                                <span id="items">0</span>
                                (<span id="total_quantity">0</span>)
                            </td>
                            <td style="padding: 5px 10px;border-top: 1px solid #DDD;"> {{ __('main.total') }}</td>
                            <td class="text-right"
                                style="padding: 5px 10px;font-size: 14px; font-weight:bold;border-top: 1px solid #DDD;">
                                <span id="sum">
                                    @if (isset($pos_open) && !$pos_open_elements->isEmpty())
                                        <?php
                                        $sum = 0;
                                        foreach ($pos_open_elements as $pos_open_element) {
                                            $sum = $sum + $pos_open_element->quantity_price;
                                        }
                                        ?>
                                        {{ $sum }}
                                    @else
                                        0
                                    @endif
                                </span>
                            </td>
                        </tr>
                        <tr>
                            @if ($pos_settings->tax == '1')
                                <td style="padding: 5px 10px;">
                                    {{ __('main.order-tax') }}
                                    <a href="#chooseTaxValue" data-toggle="modal" class="modal-effect">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <br>
                                    <span class="text-danger noTaxAddedMsg font-weight-bold"
                                        style="display: none;font-size: 11px;">(لم يتم اضافة ضريبة)</span>
                                </td>
                                <td class="text-right" style="padding: 5px 10px;font-size: 14px; font-weight:bold;">
                                    <span id="tds_2">
                                        <span id="taxValueAmount">0</span>
                                        ( <span id="posTaxValue">0</span> %)
                                    </span>
                                </td>
                            @endif
                            @if ($pos_settings->discount == '1')
                                <td style="padding: 5px 10px;"> {{ __('main.discount') }}
                                    <a href="#modaldemo7" style="font-size: 17px !important;" data-toggle="modal"
                                        class="modal-effect">
                                        <i class="fa fa-edit" style="font-size: 17px !important;"></i>
                                    </a>
                                </td>
                                <td class="text-right" style="padding: 5px 10px;font-weight:bold;">
                                    <span id="tds">
                                        @if (isset($pos_open) && !empty($pos_open_discount))
                                            <?php
                                            $discount_value = $pos_open_discount->discount_value;
                                            $discount_type = $pos_open_discount->discount_type;
                                            $sum = 0;
                                            foreach ($pos_open_elements as $pos_open_element) {
                                                $sum = $sum + $pos_open_element->quantity_price;
                                            }
                                            if ($discount_type == 'pound') {
                                                echo $discount_value;
                                            } else {
                                                echo $discount_value = ($discount_value / 100) * $sum;
                                                echo ' ( ' . $pos_open_discount->discount_value . ' % ) ';
                                            }
                                            ?>
                                        @else
                                            0
                                        @endif
                                    </span>
                                </td>
                            @endif
                        </tr>
                        <tr>
                            <td style="padding: 5px 10px; border-top: 1px solid #666; border-bottom: 1px solid #333; font-weight:bold;  color:#000000;"
                                colspan="2">
                                {{ __('main.total-amount') }}
                            </td>
                            <td class="text-right"
                                style="padding:5px 10px 5px 10px; font-size: 14px;border-top: 1px solid #666; border-bottom: 1px solid #333; font-weight:bold; color:#000000;"
                                colspan="2">
                                <span id="total" style="color: #000000 !important;">
                                    @if (isset($pos_open))
                                        <?php
                                        $sum = 0;
                                        foreach ($pos_open_elements as $pos_open_element) {
                                            $sum = $sum + $pos_open_element->quantity_price;
                                        }
                                        if (isset($pos_open) && isset($pos_open_tax) && empty($pos_open_discount)) {
                                            $tax_value = $pos_open_tax->tax_value;
                                            $percent = ($tax_value / 100) * $sum;
                                            $sum = $sum + $percent;
                                        } elseif (isset($pos_open) && isset($pos_open_discount) && empty($pos_open_tax)) {
                                            $discount_value = $pos_open_discount->discount_value;
                                            $discount_type = $pos_open_discount->discount_type;
                                            if ($discount_type == 'pound') {
                                                $sum = $sum - $discount_value;
                                            } else {
                                                $discount_value = ($discount_value / 100) * $sum;
                                                $sum = $sum - $discount_value;
                                            }
                                        } elseif (isset($pos_open) && !empty($pos_open_discount) && !empty($pos_open_tax)) {
                                            $tax_value = $pos_open_tax->tax_value;
                                            $discount_value = $pos_open_discount->discount_value;
                                            $discount_type = $pos_open_discount->discount_type;
                                            if ($discount_type == 'pound') {
                                                $sum = $sum - $discount_value;
                                            } else {
                                                $discount_value = ($discount_value / 100) * $sum;
                                                $sum = $sum - $discount_value;
                                            }
                                            $percent = ($tax_value / 100) * $sum;
                                            $sum = $sum + $percent;
                                        }
                                        echo $sum;
                                        ?>
                                    @else
                                        0
                                    @endif
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="clearfix"></div>
                <div id="botbuttons" class="col-lg-12 text-center">
                    <input type="hidden" name="biller" id="biller" value="3">
                    <div class="row">
                        <div class="col-lg-12 py-1" style="padding: 0;">
                            <div class="d-flex flex-wrap flex-column">
                                <div class="row g-2">
                                  
                                    @if ($pos_settings->suspension == '1')
                                        <div class="col-lg-4 col-6 px-1 mt-2">
                                            <a role="button" class="btn btn-warning w-100 font-weight-bold py-1" data-toggle="modal" href="#pendingPosInvModal">
                                                <svg fill="white" width="8"
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                                                    <path d="M48 64C21.5 64 0 85.5 0 112V400c0 26.5 21.5 48 48 48H80c26.5 0 48-21.5 48-48V112c0-26.5-21.5-48-48-48H48zm192 0c-26.5 0-48 21.5-48 48V400c0 26.5 21.5 48 48 48h32c26.5 0 48-21.5 48-48V112c0-26.5-21.5-48-48-48H240z" />
                                                </svg>
                                                {{ __('pos.hold-invoice') }}
                                            </a>
                                        </div>
                                    @endif
                                    @if ($pos_settings->cancel == '1')
                                    {{-- <div class="col-4">
                                        <a role="button" class="d-none btn btn-danger btn-flat w-100 font-weight-bold" data-toggle="modal" href="#modaldemo5">
                                            <i class="fa fa-trash-o" ></i> {{ __('pos.cancel-invoice') }}
                                        </a>
                                    </div> --}}
                                    <div class="col-lg-4 col-6 px-1 mt-2">
                                        <button class="deletePosInv btn  btn-flat w-100 font-weight-bold py-1" style="border:1px solid #ec6880; color: #ec6880; ">
                                            <i class="fa fa-trash-o" style="color: #ec6880"></i> {{ __('pos.cancel-invoice') }}
                                        </button>
                                    </div>
                                @endif
                                    @if ($pos_settings->payment == '1')
                                    <div class="col-lg-4 col-6 px-1 mt-2">
                                        <a href="#recordPaymentModal" role="button" data-toggle="modal"
                                            class="btn btn-warning w-100 font-weight-bold py-1" id="payment">
                                            <i class="fa fa-money" ></i>
                                            {{ __('pos.record-payment') }}
                                        </a>
                                    </div>

                                @endif
                      
                                   
                                    @if ($pos_settings->fast_finish == '1')
                                        <div class="col-lg-4 col-6 px-1 mt-2">
                                            <button type="button" id="finishBank" class="btn w-100 btn-md font-weight-bold py-1"  style="border:1px solid #ec6880; color: #ec6880; ">
                                                <i class="fa fa-check-circle-o" style="color: #ec6880"></i>
                                                دفع شبكة سريع
                                            </button>
                                        </div>
                                        <div class="col-lg-4 col-6 px-1 mt-2">
                                            <button type="button" id="finish" class="btn btn-warning w-100 btn-md font-weight-bold py-1">
                                                <i class="fa fa-check-circle-o" ></i>
                                                دفع كاش سريع
                                            </button>
                                        </div>
                                    @endif
                       
                                    @if ($pos_settings->print_save == '1')
                                        <div class="col-lg-4 col-6 px-1 mt-2">
                                            <button type="button" class="btn  w-100 btn-md font-weight-bold py-1"  style="border:1px solid #ec6880; color: #ec6880; " id="save_pos">
                                                <i class="fa fa-save" style="color: #ec6880"></i>
                                                {{ __('pos.save-and-print') }}
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                        </div>
                    </div>
                   
                </div>
            </div>
        </div>
    </div>
    </div>


    <!--===========modal for choosing tax values===========-->
    <div class="modal" id="chooseTaxValue">
        <div class="modal-dialog modal-sm modal-dialog-centered" capital="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header text-center">
                    <h6 class="modal-title w-100" style="font-family: 'Cairo'; "> تحرير النظام الضريبي</h6>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="" class="d-block">ضريبة الطلب</label>

                        <select id="tax_id" class="form-control d-inline float-left w-50">
                            <option value="" selected disabled>اختر نوع الضريبة</option>
                            @foreach ($taxes as $tax)
                                <option @if (isset($pos_open) && !empty($pos_open_tax) && $pos_open_tax->tax_id == $tax->id) selected @endif
                                    @if ($pos_settings->taxStatusPos == 1 && $tax->tax_value == 15) selected @endif
                                    @if ($pos_settings->taxStatusPos == 2 && $tax->tax_value == 130) selected @endif taxvalue="{{ $tax->tax_value }}"
                                    value="{{ $tax->id }}">{{ $tax->tax_name }}
                                </option>
                            @endforeach

                            <option value="inclusive" @if ($pos_settings->taxStatusPos == 3) selected @endif>شامل
                                الضريبة
                            </option>
                        </select>

                        <!--for saving tax value-->
                        <input type="number" id="tax_value"
                            @if (isset($pos_open) && !empty($pos_open_tax)) value="{{ $pos_open_tax->tax_value }}" @endif
                            style="width: 40%;" name="tax_value" class="form-control d-inline float-right" />

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning save_tax">حفظ</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                </div>
            </div>
        </div>
    </div>
    <!--==================================================-->


    <!--===========modal for choosing fast bank===========-->
    <div class="modal fade" id="finishBankModal">
        <div class="modal-dialog modal-sm modal-dialog-centered" capital="document">
            <div class="modal-content modal-content-demo px-2">
                <div class="modal-header text-center">
                    <h6 class="modal-title w-100" style="font-family: 'Cairo'; ">
                        اختر البنك ليتم الدفع السريع
                    </h6>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="row extra_div bank">
                    <!------bank_id-------->
                    <div class="col-md-12 p-2">
                        <label class="d-block"> {{ __('banks.bank-name') }}
                            <span class="text-danger">*</span>
                        </label>
                        <select style="display: inline !important;" id="fast_bank_id" class="form-control" required>
                            <option value="">{{ __('banks.bank-name') }}</option>
                            @foreach ($banks as $bank)
                                <option value="{{ $bank->id }}">{{ $bank->bank_name }}</option>
                            @endforeach
                        </select>

                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 text-center mb-2">
                    <a target="_blank" href="{{ route('client.banks.create') }}"
                        class="btn btn-info rounded open_popup" role="button">
                        <i class="fa fa-plus" style="font-size: 16px"></i>
                        اضافة بنك جديد
                    </a>
                    <button class="btn btn-warning rounded finishBank ml-1" type="button">
                        <i class="fa fa-check-circle-o"
                            style="font-size: 15px; margin-left: 2px; top: 2px; position: relative;"></i>
                        {{ __('banks.record-process') }}
                    </button>

                </div>
            </div>
        </div>
    </div>
    <!--==================================================-->

    <!--===========modal for pending inv==================-->
    <div class="modal fade" id="pendingPosInvModal">
        <div class="modal-dialog modal-sm modal-dialog-centered" capital="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header text-center">
                    <h4 class="modal-title w-100" style="font-family: 'Cairo';color: #0A246A !important; ">
                        <svg style="position: relative; top: 4px; margin-left: 6px;" fill="#0A246A" width="10"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                            <path
                                d="M48 64C21.5 64 0 85.5 0 112V400c0 26.5 21.5 48 48 48H80c26.5 0 48-21.5 48-48V112c0-26.5-21.5-48-48-48H48zm192 0c-26.5 0-48 21.5-48 48V400c0 26.5 21.5 48 48 48h32c26.5 0 48-21.5 48-48V112c0-26.5-21.5-48-48-48H240z">
                            </path>
                        </svg>
                        تعليق عملية البيع وحفظها كفاتورة مفتوحة
                    </h4>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <h5>برجاء كتابة الملاحظة المرجعية لتعليق هذة العملية!</h5>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="سبب تعليق الفاتورة..." id="notes_2" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" id="pending">تعليق الفاتورة</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">رجوع</button>
                </div>
            </div>
        </div>
    </div>
    <!--==================================================-->

    <!--====modal to record payment for pos inv ==========-->
    <div class="modal fade" dir="rtl" id="recordPaymentModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header w-100">
                    <h4 class="modal-title text-center"
                        style="display: flex; align-items: end; color: #0A246A !important; font-weight: 500;">
                        <i class="fa fa-money" style="font-size: 19px;position: inherit; top: 2px; margin-left: 6px;"></i>
                        تسجيل دفع للفاتورة
                    </h4>
                </div>
                <div class="modal-body">
                    @if (
                        (isset($pos_cash) && !$pos_cash->isEmpty()) ||
                            (isset($pos_bank_cash) && !$pos_bank_cash->isEmpty()) ||
                            (isset($pos_coupon_cash) && !$pos_coupon_cash->isEmpty()))
                        <table class="table table-condensed table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('main.amount') }}</th>
                                    <th>{{ __('main.payment-method') }}</th>
                                    <th>{{ __('main.delete') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $j = 0; ?>
                                @if (isset($pos_cash) && !$pos_cash->isEmpty())
                                    @foreach ($pos_cash as $cash)
                                        <tr>
                                            <td>{{ ++$j }}</td>
                                            <td>{{ $cash->amount }}</td>
                                            <td>{{ __('main.cash') }}
                                                <br>
                                                ({{ $cash->safe->safe_name }})
                                            </td>
                                            <td>
                                                <button type="button" payment_method="cash"
                                                    cash_id="{{ $cash->id }}"
                                                    class="btn btn-danger delete_pay">{{ __('main.delete') }}
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                @if (isset($pos_bank_cash) && !$pos_bank_cash->isEmpty())
                                    @foreach ($pos_bank_cash as $cash)
                                        <tr>
                                            <td>{{ ++$j }}</td>
                                            <td>{{ $cash->amount }}</td>
                                            <td>دفع بنكى شبكة
                                                <br>
                                                @if (!empty($cash->bank_id))
                                                    ({{ $cash->bank->bank_name }})
                                                @endif
                                                <br>
                                                ( {{ $cash->bank_check_number }} )
                                            </td>
                                            <td>
                                                <button type="button" payment_method="bank"
                                                    cash_id="{{ $cash->id }}" class="btn btn-danger delete_pay">حذف
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                @if (isset($pos_coupon_cash) && !$pos_coupon_cash->isEmpty())
                                    @foreach ($pos_coupon_cash as $cash)
                                        <tr>
                                            <td>{{ ++$j }}</td>
                                            <td>{{ $cash->amount }}</td>
                                            <td>دفع كوبون خصم
                                                <br>
                                                ({{ $cash->coupon->coupon_code }})
                                            </td>
                                            <td>
                                                <button type="button" payment_method="coupon"
                                                    cash_id="{{ $cash->id }}" class="btn btn-danger delete_pay">حذف
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif

                            </tbody>
                        </table>
                    @endif
                    <input type="hidden" id="company_id" value="{{ $company_id }}">
                    <input type="hidden" name="client_name" id="client_name" />
                    <div class="row mb-1">
                        <!------cash_number------->
                        <div class="col-md-4" style="display: none;">
                            <label> رقم العملية <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="cash_number" value="{{ $pre_cash }}"
                                required readonly>
                        </div>

                        <!------amount------->
                        <div class="col-md-6">
                            <label> {{ __('main.paid-amount') }} <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="amount" dir="rtl"
                                placeholder="{{ __('main.paid-amount') }}" required>
                        </div>

                        <!------payment_method------->
                        <div class="col-md-6">
                            <label> {{ __('main.payment-method') }} <span class="text-danger">*</span></label>
                            <select required id="payment_method" name="payment_method" class="form-control">
                                <option value="" disabled selected>{{ __('main.payment-method') }}</option>
                                <option value="cash">دفع كاش نقدى</option>
                                <option value="bank">دفع بنكى شبكة</option>
                                <option value="coupon">دفع كوبون خصم</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-1 extra_div cash" style="display: none;">
                        <div class="col-md-6">
                            <label class="d-block"> خزنة الدفع <span class="text-danger">*</span></label>
                            <select required id="safe_id" class="form-control">
                                <option value="">اختر خزنة الدفع</option>
                                @foreach ($safes as $safe)
                                    <option value="{{ $safe->id }}">{{ $safe->safe_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-1 extra_div coupon" style="display: none;">
                        <div class="col-md-4">
                            <label> رقم كوبون الخصم <span class="text-danger">*</span></label>
                            <select class="form-control selectpicker show-tick" data-style="btn-info"
                                data-live-search="true" data-title="اختر الكوبون" name="couponcode" id="couponcode">
                            </select>
                        </div>
                    </div>
                    <div class="row mb-1 extra_div bank" style="display: none;">
                        <!------bank_id-------->
                        <div class="col-md-4">
                            <label class="d-block"> {{ __('banks.bank-name') }} <span
                                    class="text-danger">*</span></label>
                            <select id="bank_id" class="form-control" required>
                                <option value="" disabled selected>{{ __('banks.bank-name') }}</option>
                                @foreach ($banks as $bank)
                                    <option value="{{ $bank->id }}">{{ $bank->bank_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!------bank_check_number-------->
                        <div class="col-md-4">
                            <label>رقم المعاملة</label>
                            <input type="text" class="form-control" placeholder="رقم المعاملة"
                                id="bank_check_number" />
                        </div>
                        <!------bank_notes-------->
                        <div class="col-md-4">
                            <label>{{ __('main.notes') }}</label>
                            <input type="text" class="form-control" placeholder="{{ __('main.notes') }}"
                                id="bank_notes" />
                        </div>
                    </div>
                    <hr>
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <button class="btn btn-warning pay_cash" style="height: 39px;">
                            {{ __('banks.record-process') }}
                        </button>
                        <a href="{{ route('client.safes.create') }}" target="_blank"
                            class="btn btn-sm btn-warning py-1" style="height: 39px;">
                            <i class="fa fa-plus"></i>
                            اضافة خزنة جديدة
                        </a>
                        <a href="{{ route('client.banks.create') }}" target="_blank" class="btn btn-sm py-1 btn-info"
                            style="height: 39px;">
                            <i class="fa fa-plus"></i>
                            اضافة بنك جديد
                        </a>
                        <button class="btn btn-danger" data-dismiss="modal" style="height: 39px;">
                            <i class="fa fa-close"></i>
                            اغلاق
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--==================================================-->

@endsection


<script src="{{ asset('app-assets/js/jquery.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        setTimeout(function() {
            $(".app-content.content").show();
            $(".loader").hide();
        }, 700);

        //get tax value
        let posTaxValue = localStorage.getItem('pos_tax_value');
        if (!posTaxValue) {
            $(".noTaxAddedMsg").show();
        } else {
            $("#posTaxValue").text(posTaxValue);
        }
        //chk if الضريبة الانتقائية exists or not. if not add it
        $.post("{{ route('pos.open.checkTaxEntka2ya') }}", function(res) {
            if (res === 1)
                window.location.reload();
        });

        //when selecting product from selectbox...
        $('#product_id').on('change', function() {
            let product_id = $(this).val();
            let product_price = $(this).find(':selected').attr('product_price');
            let product_name = $(this).find(':selected').attr('product_name');
            let outer_client_id = $('#outer_client_id').val();
            if (outer_client_id.length == 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'يجب اختيار العميل اولا',
                    timeout: 600,
                    showConfirmButton: true,
                    confirmButtonText: 'اغلاق',
                    confirmButtonColor: '#ff4961',
                })
                return false;
            }

            if ($("#" + product_id).length == 0) {
                //add new row to the table..
                var productRow = '<tr class="bg-white" id="' + product_id + '"> <td>' + product_name +
                    '</td> <td style="padding:5px 1px 5px 1px !important;"><input type="number" style="height: 30px !important;background: none;border:1px solid rgba(45,45,45,0.11)" id="edit_price-' +
                    product_id + '" class="edit_price w-100" value="' + product_price +
                    '"></td> <td style="padding:5px 1px 5px 1px !important;"><input type="number" style="height: 30px !important;background: none;border:1px solid rgba(45,45,45,0.11)" id="edit_quantity-' +
                    product_id +
                    '" class="edit_quantity w-100" value="1"></td> <td style="padding:5px 1px 5px 1px !important;"><input type="number" style="height: 30px !important;background: none;border:1px solid rgba(45,45,45,0.11)" id="edit_discount-' +
                    product_id + '" class="edit_discount w-100" value="0"></td> <td id="totalPrice-' +
                    product_id + '" class="totalPrice font-weight-bold">' + product_price +
                    '</td> <td class="no-print"> <button class="btn btn-sm btn-danger remove_element"> <i class="fa fa-trash"></i> </button> </td> </tr>';
                $('.bill_details').append(productRow);
            } else {
                //update qty on table of products..
                $('#edit_quantity-' + product_id).val(Number($('#edit_quantity-' + product_id).val()) +
                    1);
            }
            var audioElement = document.createElement('audio');
            audioElement.setAttribute('src', "{{ asset('app-assets/mp3/beep.mp3') }}");
            audioElement.play();
            $('#product_id').val('');

            refreshBillDetails();
        });

        //when selecting product from selectbox...
        $(document).on('click', '.product', function() {
            let product_id = $(this).attr('product_id');
            let product_price = $(this).attr('product_price');
            let product_name = $(this).attr('product_name');
            let outer_client_id = $('#outer_client_id').val();
            if (outer_client_id.length == 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'يجب اختيار العميل اولا',
                    timeout: 600,
                    showConfirmButton: true,
                    confirmButtonText: 'اغلاق',
                    confirmButtonColor: '#ff4961',
                })
                return false;
            }

            if ($("#" + product_id).length == 0) {
                //add new row to the table..
                var productRow = '<tr class="bg-white" id="' + product_id + '"> <td>' + product_name +
                    '</td> <td style="padding:5px 1px 5px 1px !important;"><input type="number" style="height: 30px !important;background: none;border:1px solid rgba(45,45,45,0.11)" id="edit_price-' +
                    product_id + '" class="edit_price w-100" value="' + product_price +
                    '"></td> <td style="padding:5px 1px 5px 1px !important;"><input type="number" style="height: 30px !important;background: none;border:1px solid rgba(45,45,45,0.11)" id="edit_quantity-' +
                    product_id +
                    '" class="edit_quantity w-100" value="1"></td> <td style="padding:5px 1px 5px 1px !important;"><input type="number" style="height: 30px !important;background: none;border:1px solid rgba(45,45,45,0.11)" id="edit_discount-' +
                    product_id + '" class="edit_discount w-100" value="0"></td> <td id="totalPrice-' +
                    product_id + '" class="totalPrice font-weight-bold">' + product_price +
                    '</td> <td class="no-print"> <button class="btn btn-sm btn-danger remove_element"> <i class="fa fa-trash"></i> </button> </td> </tr>';
                $('.bill_details').append(productRow);
            } else {
                //update qty on table of products..
                $('#edit_quantity-' + product_id).val(Number($('#edit_quantity-' + product_id).val()) +
                    1);
            }
            var audioElement = document.createElement('audio');
            audioElement.setAttribute('src', "{{ asset('app-assets/mp3/beep.mp3') }}");
            audioElement.play();
            $('#product_id').val('');

            refreshBillDetails();
        });

        //save_discount...
        $('.save_discount').on('click', function() {
            let discount_type = $('#discount_type').val();
            let discount_value = $('#discount_value').val();
            if (discount_value == "") {
                $('#discount_value').css('border', '1px solid red');
            } else {
                $('#discount_value').css('border', '1px solid #BABFC7');
                $.post("{{ route('pos.open.store.discount') }}", {
                    discount_type: discount_type,
                    discount_value: discount_value,
                    "_token": "{{ csrf_token() }}"
                }, function(data) {
                    $('#modaldemo7').modal('toggle');
                    if (discount_type == "pound") {
                        $('#tds').html(discount_value);
                    } else {
                        $('#tds').html(discount_value + " % ");
                    }
                    $.post("{{ url('/client/pos-open/refresh') }}", {
                            "_token": "{{ csrf_token() }}"
                        },
                        function(proto) {
                            $('#items').html(proto.items);
                            $('#total_quantity').html("( " + proto.total_quantity + " )");
                            $('#sum').html(proto.sum);
                            $('#total').html(proto.total);
                            $('#final_total').val(proto.total);
                            $('#tds_2').html(proto.percent);
                            $('#tds').html(proto.discount_value);

                        });
                });
            }
        });

        //tax_id...
        $('#tax_id').on('change', function() {
            let tax_id = $(this).val();
            let tax_value = 0;
            if (tax_id == 0) {
                tax_value = 0;
            } else if (tax_id == 'inclusive') {
                tax_value = 'inclusive';
            } else {
                tax_value = $('option:selected', this).attr('taxvalue');
            }
            $('#tax_value').val(tax_value);
        });


        //save_tax...
        $('.save_tax').on('click', function() {
            //getting tax_id & tax_value
            let tax_id = $('#tax_id').val();
            let tax_value = $('#tax_value').val();
            if (tax_id == "") {
                $('#tax_id').css('border', '1px solid red');
            } else if (tax_id != 'inclusive' && tax_value == "") {
                $('#tax_value').css('border', '1px solid red');
            } else {
                localStorage.setItem('pos_tax_value', tax_value);
                window.location.reload();
            }
        });

        //===============pending pos inv action==================//
        $('#pending').on('click', function() {
            if (!chkInvHasProductsAndClient()) {
                $('#pendingPosInvModal').modal('toggle');
                return false;
            }
            let notes = $('#notes_2').val();
            if (notes == "") {
                Swal.fire({
                    icon: 'error',
                    title: 'يرجي ادخال سبب تعليق الفاتورة.',
                    timeout: 600,
                    showConfirmButton: true,
                    confirmButtonText: 'اغلاق',
                    confirmButtonColor: '#ff4961',
                })
            } else {
                //---bill details---//
                let billDetails = {
                    outer_client_id: $('#outer_client_id').val(),
                    tableNum: $('#tableNum').val(),
                    value_added_tax: '0',
                    notes: notes,
                    total_amount: Number($("#total").text()),
                    tax_amount: Number($("#taxValueAmount").text()),
                    tax_value: Number($("#posTaxValue").text()),
                };

                //---products details---//
                let productsArr = [];
                let totalSum = 0;
                $(".edit_price").each(function(index) {
                    let product_id = $($(".edit_price")[index]).parent().parent().attr('id');
                    var productPrice = $($(".edit_price")[index]).val();
                    var productQty = $($(".edit_quantity")[index]).val();
                    var productDiscount = $($(".edit_discount")[index]).val();
                    totalSum = productPrice * productQty - productDiscount;

                    productsArr.push({
                        product_id: product_id,
                        product_price: productPrice,
                        quantity: productQty,
                        discount: productDiscount,
                        quantity_price: totalSum,
                    })
                });

                $.post("{{ route('pos.open.pending') }}", {
                    "_token": "{{ csrf_token() }}",
                    billDetails: billDetails,
                    productsArr: productsArr
                }, function(data) {
                    if (data.success == 1) {
                        $('#pendingPosInvModal').modal('toggle');
                        Swal.fire({
                            icon: 'success',
                            title: 'تم تعليق الفاتورة',
                            timeout: 1300,
                            showConfirmButton: true,
                            confirmButtonText: 'اغلاق',
                            confirmButtonColor: '#69d26f',
                        })

                        setTimeout(() => {
                            location.reload();
                        }, 50);
                    }
                });
            }
        });
        //=======================================================//

        // ========get subcategories according to category=======//
        $('.category').on('click', function() {
            if ($(this).hasClass('getSubCatsWithProducts')) {
                return false;
            }
            $('.sub_categories').hide();
            $('.products').empty();
            $(".loadingH").show();
            $('.category').removeClass('newdark');
            $(this).addClass('newdark');
            var category_id = $(this).attr('category_id');
            var sub_category_id = "all";
            //get subcategories request//
            $.post("{{ url('/client/pos/get-subcategories-by-category-id') }}", {
                category_id: category_id,
                "_token": "{{ csrf_token() }}"
            }, function(subCategories) {
                if (subCategories.length == 0) { // there is not subcategories.
                    //get products by category_id because there aren't subcategories..
                    $.post("{{ url('/client/pos/get-products-by-category-id') }}", {
                        category_id: category_id,
                        "_token": "{{ csrf_token() }}"
                    }, function(productsData) {
                        $(".loadingH").hide();

                        if (productsData.length == 0) {
                            var errMsg =
                                "<span class='alert alert-danger text-center'>لا يوجد فئات فرعية ولا منتجات</span>";
                            $('.sub_categories').html(errMsg).fadeIn(500);
                            $('.products').empty();
                        } else {
                            $('.sub_categories').hide();
                            $('.products').empty();
                            $('.products').html(productsData);
                        }
                    })
                } else {
                    $(".loadingH").hide();
                    $('.sub_categories').html(subCategories).fadeIn(500);
                    $('.products').empty();

                    //-------------------------------------------------------
                    //get products by subcategory_id ..
                    $.post("{{ url('/client/pos/get-products-by-sub-category-id') }}", {
                        sub_category_id: sub_category_id,
                        category_id: category_id,
                        "_token": "{{ csrf_token() }}"
                    }, function(data) {
                        $('.products').html(data);
                    });
                    //-------------------------------------------------------
                }

            });
        });
        // ======================================================//

        // ========get subcategories according to category=======//
        function loadSubCategoriesAndProducts() {
            $('.sub_categories').hide();
            $('.sub_categories').empty();
            $('.products').empty();
            $(".loadingH").show();
            $('.category').removeClass('newdark');

            $.post("{{ url('/client/pos/get-subcategories-and-products') }}", {
                "_token": "{{ csrf_token() }}"
            }, function(allData) {
                allData = JSON.parse(allData);
                (allData[1].data).forEach(function(product) {
                    let productElement =
                    '<div class="card cproduct m-nos product" product_id="' + product.id +
                    '" product_name="' + product.product_name + '" product_price="' + product.sector_price + 
                    '" style="box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px !important; border: 1px solid rgba(229, 229, 229, 0.4) !important; min-height: 172px !important; max-height: 172px !important; width: 12rem !important;margin-bottom: 5px !important;">' +
                    '<div class="imgBox" style="height: 75px !important; width: 100% !important;">' +
                    '<img style="height: 100% !important; width: 100% !important; object-fit: contain !important;" src="../../../' +
                    (product.product_pic ? product.product_pic : 'images/logo.png') +
                    '" class="card-img-top"> </div>' +
                    '<div class="card-body cbod" style="padding: 6px !important;">' +
                    '<h5 class="card-title ctitle" style="font-size: 12px !important;min-height: 33px !important;color: #0A246A !important; font-weight: 600 !important;">' +
                    product.product_name +
                    '</h5>' +
                    '<p class="card-text ctxt" style="margin-bottom: 3px !important;">' +
                    product.code_universal +
                    '</p>' +
                    '<div class="row col-12 justify-content-between m-0 pl-0">' +
                    '<span class="text-warning font-weight-bold">' + product.sector_price + '</span>' +
                    '<span class="row p-0 d-inline">' +
                    '<span class="plusIcon">+</span>' +
                    '<span class="m-nos font-weight-bold">1</span>' +
                    '<span class="minusIcon">-</span>' +
                    '</span>' +
                    '</div>' +
                    '</div>' +
                    '</div>';

                $(".products").append(productElement);

                });
                (allData[0]).forEach(function(subcat) {
                    let subCatElement = '<span sub_category_id="' + subcat.id +
                        '" class="sub_category m-nos p-1 circle badge badge-lightnew cursor_pointer"> ' +
                        subcat.sub_category_name + ' </span>';
                    $(".sub_categories").append(subCatElement);
                });
                $(".loadingH").hide();
                $(".sub_categories").fadeIn(500);
                $(".products").fadeIn(500);
            });
        }

        // Call function on page load
        $(document).ready(function() {
            loadSubCategoriesAndProducts();
        });

        // Bind click event
        $('.getSubCatsWithProducts').on('click', function() {
            $('.category').removeClass('newdark');
            $(this).addClass('newdark');
            loadSubCategoriesAndProducts();
        });

        // ========get products according to sub_category=======//
        $(document).on('click', '.sub_category', function() {
            $('.sub_category').removeClass('newdark');
            $(this).addClass('newdark');
            var sub_category_id = $(this).attr('sub_category_id');
            $.post('/client/pos/get-products-by-sub-category-id', {
                sub_category_id: sub_category_id,
                '_token': "{{ csrf_token() }}",
            }, function(data) {
                $('.products').html(data);
            });
        });
        // ======================================================//

        $('#payment_method').on('change', function() {
            let payment_method = $(this).val();
            let outer_client_id = $('#outer_client_id').val();
            if (payment_method == "cash") {
                $('.cash').show();
                $('.bank').hide();
                $('.coupon').hide();
            } else if (payment_method == "bank") {
                $('.bank').show();
                $('.cash').hide();
                $('.coupon').hide();
            } else if (payment_method == "coupon") {
                $.post("{{ route('get.coupon.codes') }}", {
                    "_token": "{{ csrf_token() }}",
                    outer_client_id: outer_client_id,
                }, function(data) {
                    $('#couponcode').html(data);
                    $('#couponcode').selectpicker('refresh');
                });

                $('.coupon').show();
                $('.bank').hide();
                $('.cash').hide();
            } else {
                $('.bank').hide();
                $('.cash').hide();
                $('.coupon').hide();
            }
        });

        $('#couponcode').on('change', function() {
            let coupon_code = $(this).val();
            $.post("{{ route('get.coupon.code') }}", {
                "_token": "{{ csrf_token() }}",
                "coupon_code": coupon_code,
            }, function(data) {
                if (data.status == "success") {
                    $('#amount').val(data.coupon_value).attr('readonly', true);
                    $('.pay_cash').removeClass('disabled');
                    $('.pay_cash').attr('disabled', false);
                } else {
                    $('.pay_cash').addClass('disabled');
                    $('.pay_cash').attr('disabled', true);
                    $('#amount').val("").attr('readonly', false);
                }
            });
        });
        //############################PAYING BUTTONS ACTIONS #######################//

        //=================زر حفظ وطباعة بدون دفع===========
       $('#save_pos').on('click', function () {
    if (!chkInvHasProductsAndClient()) return false;

    //---bill details---//
    let billDetails = {
        outer_client_id: $('#outer_client_id').val(),
        tableNum: $('#tableNum').val(),
        status: 'done',
        value_added_tax: '0',
        notes: $('#notes').val(),
        total_amount: Number($("#total").text()),
        tax_amount: Number($("#taxValueAmount").text()),
        tax_value: Number($("#posTaxValue").text()),
    };

    //---products details---//
    let productsArr = [];
    let totalSum = 0;
    let hasInvalidProduct = false;

    $(".edit_price").each(function (index) {
        let product_id = $($(".edit_price")[index]).parent().parent().attr('id');
        let productPrice = Number($($(".edit_price")[index]).val());
        let productQty = Number($($(".edit_quantity")[index]).val());
        let productDiscount = Number($($(".edit_discount")[index]).val());
        totalSum = productPrice * productQty - productDiscount;

        // Check if the product price is zero
        if (productPrice === 0) {
            hasInvalidProduct = true;
            return false; // Break out of the loop
        }

        productsArr.push({
            product_id: product_id,
            product_price: productPrice,
            quantity: productQty,
            discount: productDiscount,
            quantity_price: totalSum,
        });
    });

    // If any product has a price of 0, show an alert and stop the process
    if (hasInvalidProduct) {
        Swal.fire({
            icon: 'warning',
            title: 'تنبيه',
            text: 'لا يمكن حفظ الفاتورة لأن بعض المنتجات تحتوي على سعر 0!',
            confirmButtonText: 'إغلاق',
            confirmButtonColor: '#d33',
        });
        return false;
    }

    $.post("{{ route('pos.open.done') }}", {
        "_token": "{{ csrf_token() }}",
        billDetails: billDetails,
        productsArr: productsArr
    }, function (data) {
        if (data.success == 1) {
            Swal.fire({
                icon: 'success',
                title: 'تم حفظ الفاتورة بنجاح',
                timeout: 1300,
                showConfirmButton: true,
                confirmButtonText: 'اغلاق',
                confirmButtonColor: '#69d26f',
            });

            setTimeout(() => {
                window.location.href = '/pos-print/' + data.pos_id;
            }, 50);
        }
    }).fail(function (jqXHR) {
        let errorMessage = jqXHR.responseJSON ? jqXHR.responseJSON.message : "An error occurred";

        Swal.fire({
            icon: 'error',
            title: 'خطأ',
            text: errorMessage,
            confirmButtonText: 'إغلاق',
            confirmButtonColor: '#d33',
        });
    });
});
        //==================================================

        //================دفع شبكة سريع================
        $('#finishBank').on('click', function() {
            if (!chkInvHasProductsAndClient()) return false;
            $("#finishBankModal").modal();
        });

        //============= ACTION DB دفع شبكة سريع========
        $(".finishBank").click(function() {
            // Validation
            let bank_id = $('#fast_bank_id').val();
            if (!chkIfExistsBanks(bank_id)) return false;

            //--- Bill details ---//
            let billDetails = {
                outer_client_id: $('#outer_client_id').val(),
                tableNum: $('#tableNum').val(),
                status: 'done',
                value_added_tax: '0',
                notes: $('#notes').val(),
                total_amount: Number($("#total").text()),
                tax_amount: Number($("#taxValueAmount").text()),
                tax_value: Number($("#posTaxValue").text()),
                bank_id: bank_id,
            };

            //--- Products details ---//
            let productsArr = [];
            let totalSum = 0;
            $(".edit_price").each(function(index) {
                let product_id = $($(".edit_price")[index]).parent().parent().attr('id');
                var productPrice = $($(".edit_price")[index]).val();
                var productQty = $($(".edit_quantity")[index]).val();
                var productDiscount = $($(".edit_discount")[index]).val();
                totalSum = productPrice * productQty - productDiscount;

                productsArr.push({
                    product_id: product_id,
                    product_price: productPrice,
                    quantity: productQty,
                    discount: productDiscount,
                    quantity_price: totalSum,
                });
            });

            $.post("{{ route('pos.open.finishBank') }}", {
                "_token": "{{ csrf_token() }}",
                billDetails: billDetails,
                productsArr: productsArr
            }, function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'تم الدفع وحفظ الفاتورة بنجاح',
                    timeout: 1300,
                    showConfirmButton: true,
                    confirmButtonText: 'اغلاق',
                    confirmButtonColor: '#69d26f',
                });

                setTimeout(() => {
                    if (response.success == 1)
                        window.location.href = '/pos-print/' + response.pos_id;
                }, 50);
            }).fail(function(jqXHR) {
                // Extract the error message from the response
                let errorMessage = jqXHR.responseJSON ? jqXHR.responseJSON.message : "حدث خطأ";

                // Display the error message using Swal
                Swal.fire({
                    icon: 'error',
                    title: 'خطأ',
                    text: errorMessage,
                    confirmButtonText: 'إغلاق',
                    confirmButtonColor: '#d33',
                });
            });
        });

        //=============================================

        //================دفع كاش سريع==================
        $('#finish').on('click', function() {
            // validation //
            if (!chkInvHasProductsAndClient()) return false;

            //---bill details---//
            let billDetails = {
                outer_client_id: $('#outer_client_id').val(),
                tableNum: $('#tableNum').val(),
                status: 'done',
                value_added_tax: '0',
                notes: $('#notes').val(),
                total_amount: Number($("#total").text()),
                tax_amount: Number($("#taxValueAmount").text()),
                tax_value: Number($("#posTaxValue").text()),
            };

            //---products details---//
            let productsArr = [];
            let totalSum = 0;
            $(".edit_price").each(function(index) {
                let product_id = $($(".edit_price")[index]).parent().parent().attr('id');
                var productPrice = $($(".edit_price")[index]).val();
                var productQty = $($(".edit_quantity")[index]).val();
                var productDiscount = $($(".edit_discount")[index]).val();
                totalSum = productPrice * productQty - productDiscount;

                productsArr.push({
                    product_id: product_id,
                    product_price: productPrice,
                    quantity: productQty,
                    discount: productDiscount,
                    quantity_price: totalSum,
                });
            });

            $.post("{{ route('pos.open.finish') }}", {
                "_token": "{{ csrf_token() }}",
                billDetails: billDetails,
                productsArr: productsArr
            }, function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'تم الدفع وحفظ الفاتورة بنجاح!',
                    timeout: 1300,
                    showConfirmButton: true,
                    confirmButtonText: 'اغلاق',
                    confirmButtonColor: '#69d26f',
                });

                setTimeout(() => {
                    if (response.success == 1)
                        window.location.href = '/pos-print/' + response.pos_id;
                }, 50);
            }).fail(function(jqXHR) {
                // Extracting the error message from the response
                let errorMessage = jqXHR.responseJSON ? jqXHR.responseJSON.message : "حدث خطأ";

                // Display the error message using Swal
                Swal.fire({
                    icon: 'error',
                    title: 'خطأ',
                    text: errorMessage,
                    confirmButtonText: 'إغلاق',
                    confirmButtonColor: '#d33',
                });
            });
        });

        //=============================================

        //================تسجيل دفع==================
        $('#payment').on('click', function() {
            if ($('.bill_details tr').length == 0) {
                $('#recordPaymentModal').modal('hide');
                if (!chkInvHasProductsAndClient()) return false;
            }
            $("#amount").val(Number($("#total").text()));

        });

        $('.pay_cash').on('click', function() {
            if (!validateRecordPayment()) return false;

            //---bill details---//
            let billDetails = {
                outer_client_id: $('#outer_client_id').val(),
                tableNum: $('#tableNum').val(),
                status: 'done',
                value_added_tax: '0',
                notes: $('#notes').val(),
                total_amount: Number($("#total").text()),
                tax_amount: Number($("#taxValueAmount").text()),
                tax_value: Number($("#posTaxValue").text()),
                //====paying options=====//
                payment_method: $('#payment_method').val(),
                paid_amount: $('#amount').val(),
                safe_id: $('#safe_id').val(),
                cash_number: $('#cash_number').val(),
                bank_id: $('#bank_id').val(),
                bank_check_number: $('#bank_check_number').val(),
                bank_notes: $('#bank_notes').val(),
                coupon_code: $('#couponcode').val(),
            };

            //---products details---//
            let productsArr = [];
            let totalSum = 0;
            $(".edit_price").each(function(index) {
                let product_id = $($(".edit_price")[index]).parent().parent().attr('id');
                var productPrice = $($(".edit_price")[index]).val();
                var productQty = $($(".edit_quantity")[index]).val();
                var productDiscount = $($(".edit_discount")[index]).val();
                totalSum = productPrice * productQty - productDiscount;

                productsArr.push({
                    product_id: product_id,
                    product_price: productPrice,
                    quantity: productQty,
                    discount: productDiscount,
                    quantity_price: totalSum,
                })
            });
            $.post("{{ route('client.store.cash.clients.pos') }}", {
                "_token": "{{ csrf_token() }}",
                billDetails: billDetails,
                productsArr: productsArr
            }, function(posID) {
                Swal.fire({
                    icon: 'success',
                    title: 'تم الدفع وحفظ الفاتورة بنجاح!',
                    timeout: 1300,
                    showConfirmButton: true,
                    confirmButtonText: 'اغلاق',
                    confirmButtonColor: '#69d26f',
                });

                setTimeout(() => {
                    window.location.href = '/pos-print/' + posID;
                }, 50);
            }).fail(function(jqXHR) {
                // Extract the error message from the response
                let errorMessage = jqXHR.responseJSON ? jqXHR.responseJSON.message : "حدث خطأ";

                // Display the error message using Swal
                Swal.fire({
                    icon: 'error',
                    title: 'خطأ',
                    text: errorMessage,
                    confirmButtonText: 'إغلاق',
                    confirmButtonColor: '#d33',
                });
            });


        });
        //=============================================
        //############################PAYING BUTTONS ACTIONS END####################//

        // Handle the edit button click
        $('.edit_bill').on('click', function() {
            let bill_id = $('#bill_id').val();
            $.post("{{ route('pos.edit') }}", {
                "_token": "{{ csrf_token() }}",
                bill_id: bill_id
            }, function(data) {
                console.log(data);
                if (data.success == 1) {
                    // Store data in localStorage
                    localStorage.setItem('edit_bill_data', JSON.stringify(data));

                    // Reload the page
                    location.reload();
                } else {
                    $('#msg').html(data.message);
                }
            });
        });

        window.onload = function() {
            let storedData = localStorage.getItem('edit_bill_data');
            if (storedData) {
                let data = JSON.parse(storedData);
                localStorage.removeItem('edit_bill_data'); // Clear the data

                // Populate the form with the returned data
                if (data.success) {
                    const elements = data.elements;

                    // Populate the client select
                    if (data.outer_client_id) {
                        $('#outer_client_id').val(data.outer_client_id).selectpicker('refresh').trigger(
                            'change');
                    }

                    // Clear existing rows
                    $('.bill_details').empty();

                    // Populate the product details table
                    if (elements && elements.length > 0) {
                        elements.forEach(element => {
                            let product_id = element.product_id;
                            let product_price = element.product_price;
                            let product_name = element.product_name;
                            let quantity = element.quantity;
                            let discount = element.discount;
                            console.log(element);
                            let productRow = `
                        <tr class="bg-white" id="${product_id}">
                            <td>${product_name}</td>
                            <td style="padding:5px 1px !important;">
                                <input type="number" style="height: 30px !important;background: none;border:1px solid rgba(45,45,45,0.11)" id="edit_price-${product_id}" class="edit_price w-100" value="${product_price}">
                            </td>
                            <td style="padding:5px 1px !important;">
                                <input type="number" style="height: 30px !important;background: none;border:1px solid rgba(45,45,45,0.11)" id="edit_quantity-${product_id}" class="edit_quantity w-100" value="${quantity}">
                            </td>
                            <td style="padding:5px 1px !important;">
                                <input type="number" style="height: 30px !important;background: none;border:1px solid rgba(45,45,45,0.11)" id="edit_discount-${product_id}" class="edit_discount w-100" value="${discount}">
                            </td>
                            <td id="totalPrice-${product_id}" class="totalPrice font-weight-bold">${product_price}</td>
                            <td class="no-print">
                                <button class="btn btn-sm btn-danger remove_element">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                            $('.bill_details').append(productRow);
                            $('#product_id').val(elements.map(e => e.product_id)).trigger('change');

                        });

                        // Trigger change event for input fields
                        $('.edit_price, .edit_quantity, .edit_discount').trigger('change');
                    }

                    // Update sum and other fields
                    $('#sum').val(data.sum).trigger('change');
                    // Handle other fields as needed

                    $('#msg').html(''); // Clear previous messages
                } else {
                    $('#msg').html(data.message);
                }
            }
        };
        $('.remove_bill').on('click', function() {
            let bill_id = $('#bill_id').val();
            $.post("{{ route('pos.delete') }}", {
                "_token": "{{ csrf_token() }}",
                bill_id: bill_id,
            }, function(data) {
                if (data.success == 1) {
                    alert(data.message);
                    location.reload();
                } else {
                    $('#msg').html(data.message);
                }
            });
        });

        $('.delete_pay').on('click', function() {
            let payment_method = $(this).attr('payment_method');
            let cash_id = $(this).attr('cash_id');
            $.post("{{ route('pay.delete') }}", {
                "_token": "{{ csrf_token() }}",
                payment_method: payment_method,
                cash_id: cash_id,
            }, function(data) {

            });
            $(this).parent().parent().hide();
        });

        //=============on change price===========//
        $(document).on('keyup', '.edit_price', function() {
            //----update row details----//
            let element_id = $(this).parent().parent().attr('id');
            let edit_price = $(this).val();
            let edit_quantity = $("#edit_quantity-" + element_id).val();
            let edit_discount = $("#edit_discount-" + element_id).val();
            if (edit_price > 0) {
                let totalPrice = (edit_quantity * edit_price) - edit_discount;
                $("#totalPrice-" + element_id).text(totalPrice.toFixed(3));
            } else {
                
                return false;
            }
            refreshBillDetails();
        });
        //=============================================

        //=============on change qty===========//
        $(document).on('keyup', '.edit_quantity', function() {
            //----update row details----//
            let element_id = $(this).parent().parent().attr('id');
            let edit_quantity = $(this).val();
            let edit_price = $("#edit_price-" + element_id).val();
            let edit_discount = $("#edit_discount-" + element_id).val();
            if (edit_quantity > 0) {
                let totalPrice = (edit_quantity * edit_price) - edit_discount;
                $("#totalPrice-" + element_id).text(totalPrice.toFixed(3));
            } else {
                
                return false;
            }
            refreshBillDetails();
        });
        //=============================================

        //=============on change discount'===========//
        $(document).on('keyup', '.edit_discount', function() {
            //----update row details----//
            let element_id = $(this).parent().parent().attr('id');
            let edit_discount = $(this).val();
            let edit_price = $("#edit_price-" + element_id).val();
            let edit_quantity = $("#edit_quantity-" + element_id).val();
            if (edit_quantity > 0) {
                let totalPrice = (edit_quantity * edit_price) - edit_discount;
                $("#totalPrice-" + element_id).text(totalPrice.toFixed(3));
            } else {
                
                return false;
            }
            refreshBillDetails();
        });
        //=============================================

        //=====remove product from pos table'=========//
        $(document).on('click', '.remove_element', function() {
            //----update row details----//
            $(this).parent().parent().remove();
            var audioElement = document.createElement('audio');
            audioElement.setAttribute('src', "{{ asset('failed.mp3') }}");
            audioElement.play();
            refreshBillDetails();
        });
        //=============================================

        // ============ delete pos invoice ===========//
        $(document).on('click', '.deletePosInv', function() {
            if (!chkInvHasProductsAndClient()) return false;
            Swal.fire({
                title: "هل بالفعل تريد حذف الفاتورة",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#69d26f",
                cancelButtonColor: "#ff4961",
                confirmButtonText: "نعم احذف الفاتورة",
                cancelButtonText: 'الغاء'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        icon: 'success',
                        title: 'تم حذف الفاتورة بنجاح',
                        timeout: 600,
                        showConfirmButton: true,
                        confirmButtonText: 'اغلاق',
                        confirmButtonColor: '#69d26f',
                    })
                    setTimeout(function() {
                        location.reload();
                    }, 300)
                }
            });
        });
        //=============================================

        // ===== chk if pos table has products =======//
        function chkInvHasProductsAndClient() {
            if ($('.bill_details tr').length == 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'يجب اضافة منتجات للفاتورة اولا',
                    timeout: 600,
                    showConfirmButton: true,
                    confirmButtonText: 'اغلاق',
                    confirmButtonColor: '#ff4961',
                })
                return false;
            }
            if ($('#outer_client_id').length == 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'يجب اختيار عميل للفاتورة',
                    timeout: 600,
                    showConfirmButton: true,
                    confirmButtonText: 'اغلاق',
                    confirmButtonColor: '#ff4961',
                })
                return false;
            }
            return true;
        }

        //==============================================

        // ==== (refresh | update) bill details =======//
        function refreshBillDetails() {
            //----update bill details----//
            let totalSum = 0;
            let totalQty = 0;
            $(".edit_price").each(function(index) {
                var productPrice = Number($($(".edit_price")[index]).val());
                var productQty = Number($($(".edit_quantity")[index]).val());
                totalQty += productQty;
                var productDiscount = Number($($(".edit_discount")[index]).val());
                totalSum += productPrice * productQty - productDiscount;
            });
            $("#sum").text(totalSum.toFixed(3));
            //------Calc Tax Value & total PriceWithTax-------//
            let posTaxValue = Number($("#posTaxValue").text());
            let taxValueAmount = totalSum / 100 * posTaxValue;
            $("#taxValueAmount").text(taxValueAmount.toFixed(3));
            $("#total").text((totalSum + taxValueAmount).toFixed(3));
            $("#total_quantity").text(totalQty);
            $("#items").text($('.bill_details tr').length);
        }

        //===============================================

        // =====chk for existing banks before pay======//
        function chkIfExistsBanks(bank_id) {
            if (bank_id.length == 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'يجب اضافة بنك اولا',
                    timeout: 600,
                    showConfirmButton: true,
                    confirmButtonText: 'اغلاق',
                    confirmButtonColor: '#ff4961',
                })
                return false;
            }
            return true;
        }

        //===============================================

        // =====validate on recording payment======//
        function validateRecordPayment() {
            let paymentMethod = $('#payment_method').val();
            if ((!paymentMethod) || paymentMethod.length == 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'يرجي اختيار طريقة الدفع',
                    timeout: 500,
                    showConfirmButton: true,
                    confirmButtonText: 'اغلاق',
                    confirmButtonColor: '#ff4961',
                })
                return false;
            } else {
                if (paymentMethod == 'cash') {
                    if (!($("#safe_id").val()) || $("#safe_id").val().length == 0) {
                        Swal.fire({
                            icon: 'error',
                            title: 'يرجي اختيار خزنة للدفع',
                            timeout: 500,
                            showConfirmButton: true,
                            confirmButtonText: 'اغلاق',
                            confirmButtonColor: '#ff4961',
                        })
                        return false;

                    }
                } else if (paymentMethod == 'bank') {
                    if (!($("#bank_id").val()) || $("#bank_id").val().length == 0) {
                        Swal.fire({
                            icon: 'error',
                            title: 'يرجي اختيار البنك ليتم الدفع',
                            timeout: 500,
                            showConfirmButton: true,
                            confirmButtonText: 'اغلاق',
                            confirmButtonColor: '#ff4961',
                        })
                        return false;

                    }
                } else {
                    if (!($("#couponcode").val()) || $("#couponcode").val().length == 0) {
                        Swal.fire({
                            icon: 'error',
                            title: 'يرجي اختيار كود خصم ليتم الدفع',
                            timeout: 500,
                            showConfirmButton: true,
                            confirmButtonText: 'اغلاق',
                            confirmButtonColor: '#ff4961',
                        })
                        return false;

                    }
                }
            }

            if ($('#amount').val() <= 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'يرجي ادخال رقم صحيح اكبر من الصفر',
                    timeout: 500,
                    showConfirmButton: true,
                    confirmButtonText: 'اغلاق',
                    confirmButtonColor: '#ff4961',
                })
                return false;
            }
            return true;
        }

        //===============================================
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
        } else {
            $('#first_balance').attr('readonly', false);
            $('#model').attr('readonly', false);
            $('#order_universal').attr('readonly', false);
            $('#min_balance').attr('readonly', false);
            $('#store').attr('disabled', false);
            $('#start_date').attr('disabled', false);
            $('#end_date').attr('disabled', false);
        }
    });
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

