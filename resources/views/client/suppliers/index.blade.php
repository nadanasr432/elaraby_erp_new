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
                        <div class="col-lg-12 d-flex flex-wrap justify-content-between">
                            <h5 class=" custom-title">{{ __('sidebar.list-of-supplier') }} </h5>

                            <a class="btn btnn px-3 py-1 text-white" style="background-color: #ec6880"  href="{{ route('client.suppliers.create') }}"><i
                                    class="fa fa-plus"></i> {{ __('sidebar.add-new-supplier') }} </a>
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
                                                class="" data-toggle="tooltip"
                                                title="{{ __('main.show') }}" data-placement="top">
                                                <svg width="19" height="16" viewBox="0 0 576 512" fill="#222751"><path d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z"></path></svg>
                                                </a>

                                            <a href="{{ route('client.suppliers.edit', $supplier->id) }}"
                                                class="" data-toggle="tooltip"
                                                title="{{ __('main.edit') }}" data-placement="top">
                                                <svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M18.21 4.87258C18.6 4.48258 18.6 3.83258 18.21 3.46258L15.87 1.12258C15.5 0.732578 14.85 0.732578 14.46 1.12258L12.62 2.95258L16.37 6.70258M0.5 15.0826V18.8326H4.25L15.31 7.76258L11.56 4.01258L0.5 15.0826Z" fill="#4AA16A"/>
                                                    </svg>
                                                </a>

                                            <a class="modal-effect delete_supplier"
                                                supplier_id="{{ $supplier->id }}"
                                                supplier_name="{{ $supplier->supplier_name }}" data-toggle="modal"
                                                href="#modaldemo9" title="{{ __('main.delete') }}">
                                                    <svg width="17" height="20" viewBox="0 0 17 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M14.912 4.33301L14.111 17.95C14.0812 18.4594 13.8577 18.9381 13.4865 19.2881C13.1153 19.6382 12.6243 19.8331 12.114 19.833H4.886C4.37575 19.8331 3.88475 19.6382 3.5135 19.2881C3.14226 18.9381 2.91885 18.4594 2.889 17.95L2.09 4.33301H0V3.33301C0 3.2004 0.0526785 3.07322 0.146447 2.97945C0.240215 2.88569 0.367392 2.83301 0.5 2.83301H16.5C16.6326 2.83301 16.7598 2.88569 16.8536 2.97945C16.9473 3.07322 17 3.2004 17 3.33301V4.33301H14.912ZM6.5 0.333008H10.5C10.6326 0.333008 10.7598 0.385686 10.8536 0.479455C10.9473 0.573223 11 0.7004 11 0.833008V1.83301H6V0.833008C6 0.7004 6.05268 0.573223 6.14645 0.479455C6.24021 0.385686 6.36739 0.333008 6.5 0.333008ZM5.5 6.83301L6 15.833H7.5L7.1 6.83301H5.5ZM10 6.83301L9.5 15.833H11L11.5 6.83301H10Z" fill="#F55549"/>
                                                    </svg>
                                                </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 d-flex justify-content-between align-items-center bg-white p-2">
                <p class="alert custom-title alert-sm" dir="rtl">
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
         
                <a href="{{ route('client.suppliers.print') }}" target="_blank" role="button"
                     dir="rtl" class="btn btnn px-3 py-1 text-white" style="background-color: #ec6880" >
                    <i class="fa fa-print"></i>
                    {{ __('suppliers.print-suppliers') }}
                </a>
            </div>

            <div class="clearfix"></div>
            <div style="background-color: #fff">
            <form class="d-inline" action="{{ route('suppliers.import') }}" method="POST"
                enctype="multipart/form-data" >
                @csrf
                <div class="row px-3 pb-3">
                    <div class="col-lg-6  " style="border-left: 1px solid #ccc">
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
                    <div class="col-lg-6  ">
                        <label class="d-block" for="">{{ __('main.export-data') }}</label>
                        <a class="btn btn-warning"
                            href="{{ route('suppliers.export') }}">{{ __('main.click-to-export') }}</a>
                    </div>
                </div>
            </form>
            </div>
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
