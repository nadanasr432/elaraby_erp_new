@extends('client.layouts.app-main')
<style>

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
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between text-align-center">
                        <div class="col-lg-12 margin-tb">
                            {{-- <a class="btn pull-left btn-primary btn-sm" href="{{ route('client.products.create') }}"><i
                                    class="fa fa-plus"></i> اضافة منتج جديد </a>
                            --}}
                            <h5 class=" alert custom-title">عرض المنتجات التى اوشكت على انتهاء الصلاحية
                            </h5>
                        </div>
                        <br>
                    </div>

                    <form method="GET" action="{{ route('client.products.expires') }}" id="filterForm" class="mt-4">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="start_date">Start Date:</label>
                                <input type="date" id="start_date" name="start_date" class="form-control">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="end_date">End Date:</label>
                                <input type="date" id="end_date" name="end_date" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="expiry_status">Expiry Status:</label>
                                <select id="expiry_status" name="expiry_status" class="form-control">
                                    <option value="">Select Status</option>
                                    <option value="expired">Expired</option>
                                    <option value="soon_expired">Soon Expired</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            
                            <div class="form-group col-md-6" style="margin-top: 25px">
                                <button type="submit" class=" btn text-white px-4 py-1 mb-1" style="background-color: #222751 !important; box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);">
                                    <i class="fas fa-filter"></i> Filter
                                </button>
                                 <button type="button" class=" btn text-white px-4 py-1 mb-1" style="background-color: #36c7d6" onclick="resetForm()">
                                <i class="fas fa-undo"></i> Reset
                            </button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-condensed table-striped table-bordered text-center table-hover"
                            id="example-table">
                            <thead>
                                <tr>
                                    <th class="text-center">تكويد</th>
                                    <th class="text-center">المخزن</th>
                                    <th class="text-center">الفئة</th>
                                    <th class="text-center">الاسم</th>
                                    <th class="text-center">تاريخ الانتاج</th>
                                    <th class="text-center">تاريخ الانتهاء</th>
                                    <th class="text-center" style="width: 20% !important;">تحكم</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 0;
                                @endphp
                                @foreach ($products as $key => $product)
                                    <tr>
                                        <td>{{ $product->code_universal ?? '' }}</td>
                                        <td>{{ $product->store->store_name ?? '' }}</td>
                                        <td>
                                            {{ $product->category->category_name ?? '' }}
                                            @if (!empty($product->sub_category_id))
                                                {{ $product->subcategory->sub_category_name ?? '' }}
                                            @endif
                                        </td>
                                        <td>{{ $product->product_name }}</td>
                                        <td>{{ $product->start_date }}</td>
                                        <td>{{ $product->end_date }}</td>
                                        <td style="width: 20% !important;">
                                            <a href="{{ route('client.products.show', $product->id) }}"
                                                class="btn btn-sm btn-success" data-toggle="tooltip" title="عرض"
                                                data-placement="top"><i class="fa fa-eye"></i></a>
                                            @can('قائمة المنتجات المتوفرة (تحكم كامل)')
                                                <a href="{{ route('client.products.edit', $product->id) }}"
                                                    class="btn btnn btn-sm btn-info" data-toggle="tooltip" title="تعديل"
                                                    data-placement="top"><i class="fa fa-edit"></i></a>

                                                <a class="modal-effect btn btnn btn-sm btn-danger delete_product"
                                                    product_id="{{ $product->id }}"
                                                    product_name="{{ $product->product_name }}" data-toggle="modal"
                                                    href="#modaldemo9" title="delete"><i class="fa fa-trash"></i></a>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal" id="modaldemo9">
            <div class="modal-dialog modal-dialog-centered" product="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header text-center">
                        <h6 class="modal-title w-100" style="font-family: 'Cairo'; ">حذف منتج</h6>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                                aria-hidden="true">&times;</span></button>
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
                            <button type="button" class="btn btnn btn-secondary" data-dismiss="modal">الغاء</button>
                            <button type="submit" class="btn btnn btn-danger">حذف</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
<script src="{{ asset('app-assets/js/jquery.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.delete_product').on('click', function() {
            var product_id = $(this).attr('product_id');
            var product_name = $(this).attr('product_name');
            $('.modal-body #productid').val(product_id);
            $('.modal-body #productname').val(product_name);
        });
    });

    function resetForm() {
        document.getElementById('filterForm').reset();
    }

    function resetForm() {
        // Clear the form inputs
        document.getElementById('filterForm').reset();

        // Redirect to the same route without any query parameters
        window.location.href = "{{ route('client.products.expires') }}";
    }
</script>
