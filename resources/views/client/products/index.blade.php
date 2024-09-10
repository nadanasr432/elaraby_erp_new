@extends('client.layouts.app-main')
<style>
    tr th {
        color: white !important;
        font-weight: normal !important;
        font-size: 12px !important;
    }

    tr td {
        padding: 5px !important;
        font-size: 11px !important;
    }

    .dropdown-toggle::after {
        display: none !important;
    }

    .btn-sm-new {
        font-size: 10px !important;
        padding: 10px !important;
        font-weight: bold !important;
    }
</style>
@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissable fade show">
            <button class="close" data-dismiss="alert" aria-label="Close">×</button>
            {{ session('success') }}
        </div>
    @endif
    <!-- row -->
    <div class="row row-sm">

        <div class="col-md-12">
            <div class="card">
                <!------HEADER----->
                <div class="card-header border-bottom border-secondary p-1">
                    <div class="d-flex justify-content-between align-items-baseline">
                        <h3 class="pull-right font-weight-bold ml-1">
                            {{__('products.manage_products')}}
                            <span class="badge badge-success circle">{{floatval( $total_balances  )}}</span>
                        </h3>
                        <div class="row">
                            <a class="mr-1 btn btn-success btn-sm-new"
                               href="{{ route('client.products.create') }}">
                                <i class="fa fa-plus"></i>
                                {{__('products.addnewproduct')}}
                            </a>
                            <a class="btn btn-info btn-sm-new mr-1" href="{{ route('products.export') }}">
                                {{__('products.exportproducts')}}
                            </a>
                            <button class="btn btn-primary btn-sm-new mr-1 open_box"
                                    href="{{ route('products.export') }}">
                                {{__('products.importproducts')}}

                            </button>
                            <a href="{{route('client.products.print')}}" target="_blank" role="button"
                               class="mr-1 btn-warning btn btn-sm-new " dir="rtl">
                                <i class="fa fa-print"></i>
                                {{__('products.printproducts')}}
                            </a>

                        </div>

                    </div>
                </div>

                <!------HEADER----->
                <div class="card-body p-0">
                    <div class="box mt-2 mb-2" style="display: none;border-bottom: 1px solid #2e2e2e2e">
                        <div class="row">
                            <ul class="col-sm-6 p-4">
                                <li style="font-size: 16px !important;">
                                    ان يكون الملف اكسيل فقط وامتداده .xlsx
                                </li>
                                <li style="font-size: 16px !important;">
                                    لا يحتوى على heading row او مايسمى صف عناوين الاعمدة
                                </li>
                                <li style="font-size: 16px !important;">
                                    تجنب وجود صفوف فارغة او خالية من البيانات قدر الامكان
                                </li>
                                <li style="font-size: 16px !important;">
                                    اول عمود مخصص لاسم المنتج
                                </li>
                                <li style="font-size: 16px !important;">
                                    ثانى عمود مخصص لسعر الشراء
                                </li>
                                <li style="font-size: 16px !important;">
                                    ثالث عمود مخصص لسعر البيع جملة
                                </li>
                                <li style="font-size: 16px !important;">
                                    رابع عمود مخصص لسعر البيع قطاعى
                                </li>
                                <li style="font-size: 16px !important;">
                                    خامس عمود مخصص لرصيد المخازن
                                </li>

                            </ul>
                            <div class="col-sm-6">
                                <p>
                                    {{__('products.attachedImage')}}
                                    <br>
                                    <br>
                                    <img style="width: 60%;border-radius: 5px; padding: 5px;border: 1px solid #000; "
                                         src="{{asset('images/products.png')}}" alt="">
                                </p>
                                <form class="d-inline" action="{{ route('products.import') }}" method="POST"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-6 pull-right p-1">
                                            <label class="d-block mt-2" for="">{{__('products.importproducts')}}</label>
                                            <input accept=".xlsx" required type="file" name="file" class="form-control">
                                            <button
                                                class="btn btn-success mt-1">{{__('products.clicktoimport')}}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <table class="table table-striped text-center" id="example-table">
                        <thead>
                        <tr style="background: #222751;">
                            <th>#</th>
                            <th style="width:120px !important;">{{__('products.name')}}</th>
                            <th style="width:120px !important;">{{__('products.store')}}</th>
                            <th>{{__('products.category')}}</th>
                            <th>{{__('products.whole')}}</th>
                            <th>{{__('products.sector')}}</th>
                            <th>{{__('products.cost')}}</th>
                            <th>{{__('products.quantity')}}</th>
                            <th>{{__('products.barcode')}}</th>
                            <th>{{__('products.actions')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $i=0;
                        @endphp
                        @foreach ($products as $key => $product)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td style="width: 120px !important;">{{ $product->product_name ?? ' '}}</td>
                                <td style="width:120px !important;">
                                    @if(!empty($product->store_id))
                                        {{ $product->store->store_name ?? ' '}}
                                    @endif
                                </td>
                                <td>
                                    {{ $product->category->category_name}}
                                    @if(!empty($product->sub_category_id))
                                        {{ $product->subcategory->sub_category_name ?? ' '}}
                                    @endif
                                </td>
                                <td>{{floatval( $product->wholesale_price  ?? ' ')}}</td>
                                <td>{{floatval( $product->sector_price  ?? ' ')}}</td>
                                <td>{{floatval( $product->purchasing_price  ?? ' ')}}</td>
                                <td>{{floatval( $product->first_balance  ?? ' ')}}
                                    @if(!empty($product->unit_id))
                                        {{$product->unit->unit_name ?? ' '}}
                                    @endif
                                </td>
                                <td>{{ $product->code_universal }}</td>
                                <td style="width: 3% !important;">
                                    <div class="dropdown">
                                        <button class="btn dropDownBtn dropdown-toggle dotsBTN" type="button"
                                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                            <svg style="display:block;fill: #36363f;margin: auto" height="1em"
                                                 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 128 512">
                                                <path
                                                    d="M64 360a56 56 0 1 0 0 112 56 56 0 1 0 0-112zm0-160a56 56 0 1 0 0 112 56 56 0 1 0 0-112zM120 96A56 56 0 1 0 8 96a56 56 0 1 0 112 0z"></path>
                                            </svg>
                                        </button>
                                        <div class="dropdown-menu p-0" aria-labelledby="dropdownMenuButton"
                                             x-placement="bottom-start"
                                             style="position: absolute; transform: translate3d(0px, 29px, 0px); top: 0px; left: 0px; will-change: transform;">
                                            <!--SHOW--->
                                            <a href="{{ route('client.products.show', $product->id) }}"
                                               class="dropdown-item" target="_blank"
                                               style="font-size: 12px !important; padding: 9px 11px;border-bottom: 1px solid #2d2d2d2d">
                                                <svg
                                                    style="width: 15px; fill: forestgreen;display: inline;margin-left: 5px;"
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                                    <path
                                                        d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z"></path>
                                                </svg>
                                                {{__('products.view')}}
                                            </a>

                                        @can('قائمة المنتجات المتوفرة (تحكم كامل)')
                                            <!--EDIT--->
                                                <a href="{{ route('client.products.edit', $product->id) }}"
                                                   class="dropdown-item"
                                                   style="font-size: 12px  !important; padding: 9px 11px;border-bottom: 1px solid #2d2d2d2d">
                                                    <svg
                                                        style="width: 15px; fill: #1956ad;display: inline;margin-left: 5px;"
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                        <path
                                                            d="M441 58.9L453.1 71c9.4 9.4 9.4 24.6 0 33.9L424 134.1 377.9 88 407 58.9c9.4-9.4 24.6-9.4 33.9 0zM209.8 256.2L344 121.9 390.1 168 255.8 302.2c-2.9 2.9-6.5 5-10.4 6.1l-58.5 16.7 16.7-58.5c1.1-3.9 3.2-7.5 6.1-10.4zM373.1 25L175.8 222.2c-8.7 8.7-15 19.4-18.3 31.1l-28.6 100c-2.4 8.4-.1 17.4 6.1 23.6s15.2 8.5 23.6 6.1l100-28.6c11.8-3.4 22.5-9.7 31.1-18.3L487 138.9c28.1-28.1 28.1-73.7 0-101.8L474.9 25C446.8-3.1 401.2-3.1 373.1 25zM88 64C39.4 64 0 103.4 0 152V424c0 48.6 39.4 88 88 88H360c48.6 0 88-39.4 88-88V312c0-13.3-10.7-24-24-24s-24 10.7-24 24V424c0 22.1-17.9 40-40 40H88c-22.1 0-40-17.9-40-40V152c0-22.1 17.9-40 40-40H200c13.3 0 24-10.7 24-24s-10.7-24-24-24H88z"></path>
                                                    </svg>
                                                    {{__('products.edit')}}
                                                </a>

                                                <!--DELETE--->
                                                <button product_id="{{ $product->id }}"
                                                        product_name="{{ $product->product_name }}" data-toggle="modal"
                                                        href="#modaldemo9"
                                                        class="dropdown-item modal-effect delete_product d-inline"
                                                        style="font-size: 12px !important; padding: 9px 11px;border-bottom: 1px solid #2d2d2d2d;cursor:pointer;"
                                                        subscriptionid="32">
                                                    <svg
                                                        style="width: 15px; fill: #8c0909;display: inline;margin-left: 5px;"
                                                        xmlns="http://www.w3.org/2000/svg" height="1em"
                                                        viewBox="0 0 448 512">
                                                        <path
                                                            d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm79 143c9.4-9.4 24.6-9.4 33.9 0l47 47 47-47c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-47 47 47 47c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0l-47-47-47 47c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l47-47-47-47c-9.4-9.4-9.4-24.6 0-33.9z"></path>
                                                    </svg>
                                                    {{__('products.delete')}}
                                                </button>

                                            @endcan


                                        </div>
                                    </div>


                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="modal" id="modaldemo9">
            <div class="modal-dialog modal-dialog-centered" product="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header text-center">
                        <h6 class="modal-title w-100" style="font-family: 'Cairo'; ">حذف منتج</h6>
                        <button aria-label="Close" class="close"
                                data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form action="{{ route('client.products.destroy', 'test') }}" method="post">
                        {{ method_field('delete') }}
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <p>هل انت متأكد من الحذف ?</p><br>
                            <input type="hidden" name="productid" id="productid">
                            <input class="form-control" name="productname" id="productname" type="text" readonly>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                            <button type="submit" class="btn btn-danger">حذف</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
<script src="{{asset('app-assets/js/jquery.min.js')}}"></script>
<script>
    $(document).ready(function () {
        $('.delete_product').on('click', function () {
            var product_id = $(this).attr('product_id');
            var product_name = $(this).attr('product_name');
            $('.modal-body #productid').val(product_id);
            $('.modal-body #productname').val(product_name);
        });
        $('.open_box').on('click', function () {
            $('.box').slideToggle(700);
        });
    });
</script>
