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
    @if (session('error'))
        <div class="alert alert-danger text-center">
            <button class="close" data-dismiss="alert" aria-label="Close">×</button>
            {{ session('error') }}
        </div>
    @endif

    <!-- row -->
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <div class="col-lg-12 margin-tb">
                            <a class="btn pull-left btn-primary btn-sm" href="{{ route('client.suppliers.create') }}"><i
                                    class="fa fa-plus"></i> {{ __('sidebar.add-new-supplier') }} </a>
                            <h5 class="pull-right alert alert-sm alert-success">{{ __('sidebar.list-of-supplier') }} </h5>
                        </div>
                        <br>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-condensed table-striped table-bordered text-center table-hover"
                            id="example-table">
                            <thead>
                                <tr>
                                    <th class="text-center">{{ __('main.name') }}</th>
                                    <th class="text-center">{{ __('main.category') }}</th>
                                    <th class="text-center">{{ __('main.phone') }}</th>
                                    <th class="text-center">{{ __('main.address') }}</th>
                                    <th class="text-center">{{ __('main.tax-number') }}</th>
                                    <th class="text-center">{{ __('main.company') }}</th>
                                    <th class="text-center">{{ __('main.indebtedness') }}</th>
                                    <th class="text-center" style="width: 20% !important;">{{ __('main.control') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 0;
                                @endphp
                                @foreach ($suppliers as $key => $supplier)
                                    <tr>
                                        <td>{{ $supplier->supplier_name }}</td>
                                        <td>{{ $supplier->supplier_category }}</td>
                                        <td dir="ltr">
                                            @if (!$supplier->phones->isEmpty())
                                                {{ $supplier->phones[0]->supplier_phone }}
                                            @endif
                                        </td>
                                        <td>
                                            @if (!$supplier->addresses->isEmpty())
                                                {{ $supplier->addresses[0]->supplier_address }}
                                            @endif
                                        </td>
                                        <td>{{ $supplier->tax_number }}</td>
                                        <td>{{ $supplier->shop_name }}</td>

                                        <td>
                                            @if ($supplier->prev_balance > 0)
                                                {{ __('main.from') }}
                                                {{ floatval($supplier->prev_balance) }}
                                            @elseif($supplier->prev_balance < 0)
                                                {{ __('main.on') }}
                                                {{ floatval(abs($supplier->prev_balance)) }}
                                            @else
                                                0
                                            @endif
                                        </td>
                                        <td style="width: 20% !important;">
                                            <a href="{{ route('client.suppliers.show', $supplier->id) }}"
                                                class="btn btn-sm btn-success" data-toggle="tooltip"
                                                title="{{ __('main.show') }}" data-placement="top"><i
                                                    class="fa fa-eye"></i></a>

                                            <a href="{{ route('client.suppliers.edit', $supplier->id) }}"
                                                class="btn btn-sm btn-info" data-toggle="tooltip"
                                                title="{{ __('main.edit') }}" data-placement="top"><i
                                                    class="fa fa-edit"></i></a>

                                            <a class="modal-effect btn btn-sm btn-danger delete_supplier"
                                                supplier_id="{{ $supplier->id }}"
                                                supplier_name="{{ $supplier->supplier_name }}" data-toggle="modal"
                                                href="#modaldemo9" title="{{ __('main.delete') }}"><i
                                                    class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 pull-right p-2">
                <p class="alert alert-success alert-sm" dir="rtl">
                    {{ __('suppliers.total-suppliers-indebtedness') }} :
                    @if ($total_balances > 0)
                        {{ __('main.from') }}
                        {{ floatval($total_balances) }}
                    @elseif($total_balances < 0)
                        {{ __('main.to') }}
                        {{ floatval(abs($total_balances)) }}
                    @else
                        0
                    @endif
                </p>
            </div>
            <div class="col-lg-4 pull-right p-2">
                <a href="{{ route('client.suppliers.print') }}" target="_blank" role="button"
                    class="btn-danger btn btn-md" dir="rtl">
                    <i class="fa fa-print"></i>
                    {{ __('suppliers.print-suppliers') }}
                </a>
            </div>

            <div class="clearfix"></div>
            <hr>
            <form class="d-inline" action="{{ route('suppliers.import') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-6 pull-right p-1" style="border-left: 1px solid #ccc">
                        <a href="javascript:;" class="text-danger open_box">
                            <i class="fa fa-plus"></i>
                            {{ __('suppliers.customer-import-instructions') }} :
                        </a>
                        <div class="box mt-2 mb-2" style="display: none;">
                            <ul>
                                <li>
                                    ان يكون الملف اكسيل فقط وامتداده .xlsx
                                </li>
                                <li>
                                    لا يحتوى على heading row او مايسمى صف عناوين الاعمدة
                                </li>
                                <li>
                                    تجنب وجود صفوف فارغة او خالية من البيانات قدر الامكان
                                </li>
                                <li>
                                    اول عمود مخصص لاسم المورد
                                </li>
                                <li>
                                    ثانى عمود مخصص لمستحقات المورد
                                </li>
                            </ul>
                            <p>
                                مرفق صورة توضيحية لشكل الملف من الداخل
                                <br>
                                <br>
                                <img style="width: 100%;border-radius: 5px; padding: 5px;border: 1px solid #000;"
                                    src="{{ asset('images/suppliers.png') }}" alt="">
                            </p>
                        </div>
                        <label class="d-block mt-2" for="">{{ __('main.import-data') }}</label>
                        <input accept=".xlsx" required type="file" name="file" class="form-control">
                        <br>
                        <button class="btn btn-success">{{ __('main.click-to-import') }}</button>
                    </div>
                    <div class="col-lg-6 pull-left p-1">
                        <label class="d-block" for="">{{ __('main.export-data') }}</label>
                        <a class="btn btn-warning"
                            href="{{ route('suppliers.export') }}">{{ __('main.click-to-export') }}</a>
                    </div>
                </div>
            </form>
            <div class="clearfix"></div>
            <hr>

        </div>

        <div class="modal" id="modaldemo9">
            <div class="modal-dialog modal-dialog-centered" supplier="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header text-center">
                        <h6 class="modal-title w-100" style="font-family: 'Cairo'; ">حذف مورد</h6>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                    <form action="{{ route('client.suppliers.destroy', 'test') }}" method="post">
                        {{ method_field('delete') }}
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <p>هل انت متأكد من الحذف ?</p><br>
                            <input type="hidden" name="supplierid" id="supplierid">
                            <input class="form-control" name="suppliername" id="suppliername" type="text" readonly>
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
<script src="{{ asset('app-assets/js/jquery.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.delete_supplier').on('click', function() {
            var supplier_id = $(this).attr('supplier_id');
            var supplier_name = $(this).attr('supplier_name');
            $('.modal-body #supplierid').val(supplier_id);
            $('.modal-body #suppliername').val(supplier_name);
        });

        $('.open_box').on('click', function() {
            $('.box').toggle();
        });
    });
</script>
