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
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="pull-right font-weight-bold ml-1 custom-title">
                            {{__('sidebar.products-deleted')}}
                            <span class="badge circle" style="background-color: #36c7d6">{{floatval( $products->count()  )}}</span>
                        </h3>
                        {{-- <div class="row">
                            <a class="mr-1 btn btn-success btn-sm-new"
                               href="{{ route('client.products.create') }}">
                                <i class="fa fa-plus"></i>
                                {{__('products.addnewproduct')}}
                            </a>
                            <a class="mr-1 btn btn-success btn-sm-new"
                               href="{{ route('client.products.createservice') }}">
                                <i class="fa fa-plus"></i>
                                {{__('products.addnewproductseveces')}}
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

                        </div> --}}

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
                                <th style="width:120px !important;">{{ __('products.pname') }}</th>
                                <th style="width:120px !important;">{{ __('products.pname_en') }}</th>
                                <th style="width:120px !important;">{{ __('products.store') }}</th>
                                <th>{{ __('products.category') }}</th>
                                <th>{{ __('products.whole') }}</th>
                                <th>{{ __('products.sector') }}</th>
                                <th>{{ __('products.cost') }}</th>
                                <th>{{ __('products.quantity') }}</th>
                                <th>{{ __('products.barcode') }}</th>
                                <th>{{ __('products.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 0;
                            @endphp
                            @foreach ($products as $key => $product)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td style="width: 120px !important;">{{ $product->product_name ?? ' ' }}</td>
                                    <td style="width: 120px !important;">{{ $product->product_name_en ?? ' ' }}</td>
                                    <td style="width:120px !important;">
                                        @if (!empty($product->store_id))
                                            {{ $product->store->store_name ?? ' ' }}
                                        @endif
                                    </td>
                                    <td>
                                        {{ $product->category->category_name }}
                                        @if (!empty($product->sub_category_id))
                                            {{ $product->subcategory->sub_category_name ?? ' ' }}
                                        @endif
                                    </td>
                                    <td>{{ floatval($product->wholesale_price ?? ' ') }}</td>
                                    <td>{{ floatval($product->sector_price ?? ' ') }}</td>
                                    <td>{{ floatval($product->purchasing_price ?? ' ') }}</td>
                                    <td>{{ $product->first_balance > 0 ? $product->first_balance : 'خدمية' }}
                                        @if (!empty($product->unit_id) && $product->first_balance > 0)
                                            {{ $product->unit->unit_name ?? ' ' }}
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
                                                        d="M64 360a56 56 0 1 0 0 112 56 56 0 1 0 0-112zm0-160a56 56 0 1 0 0 112 56 56 0 1 0 0-112zM120 96A56 56 0 1 0 8 96a56 56 0 1 0 112 0z">
                                                    </path>
                                                </svg>
                                            </button>
                                            <div class="dropdown-menu p-0" aria-labelledby="dropdownMenuButton"
                                                x-placement="bottom-start"
                                                >
                                                @can('قائمة المنتجات المتوفرة (تحكم كامل)')
                                                    <!--DELETE--->
                                                    <button product_id="{{ $product->id }}"
                                                        product_name="{{ $product->product_name }}" data-toggle="modal"
                                                        href="#modaldemo9"
                                                        class="dropdown-item modal-effect delete_product d-inline"
                                                        style="font-size: 12px !important; padding: 9px 11px;border-bottom: 1px solid #2d2d2d2d;cursor:pointer;"
                                                        subscriptionid="32">
                                                        <svg style="width: 15px; fill: #8c0909;display: inline;margin-left: 5px;"
                                                            xmlns="http://www.w3.org/2000/svg" height="1em"
                                                            viewBox="0 0 448 512">
                                                            <path
                                                                d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm79 143c9.4-9.4 24.6-9.4 33.9 0l47 47 47-47c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-47 47 47 47c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0l-47-47-47 47c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l47-47-47-47c-9.4-9.4-9.4-24.6 0-33.9z">
                                                            </path>
                                                        </svg>
                                                        {{ __('products.restore') }}
                                                    </button>
                                                @endcan


                                            </div>
                                        </div>


                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>                </div>
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
                    <form action="{{ route('products.restore', 'test') }}" method="post">
                        {{ method_field('post') }}
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <p>هل انت متأكد من الغاء الحذف ?</p><br>
                            <input type="hidden" name="productid" id="productid">
                            <input class="form-control" name="productname" id="productname" type="text" readonly>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                            <button type="submit" class="btn btn-danger">تأكيد</button>
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
