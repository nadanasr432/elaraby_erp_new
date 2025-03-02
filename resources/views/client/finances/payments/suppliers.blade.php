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
                    <div class="d-flex justify-content-between">
                        <div class="col-lg-12 margin-tb d-flex flex-wrap justify-content-between align-items-center">
                            <h5 class="custom-title alert ">دفعات النقدية السابقة الى الموردين </h5>
                            <a class="btn btnn text-white px-3 py-1" style="background-color: #ec6880"
                               href="{{ route('client.add.cash.suppliers') }}"><i
                                    class="fa fa-plus"></i> دفع نقدى الى مورد </a>
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
                                <th class="text-center">رقم العملية</th>
                                <th class="text-center">المورد</th>
                                <th class="text-center">المبلغ</th>
                                <th class="text-center">رصيد قبل</th>
                                <th class="text-center">رصيد بعد</th>
                                <th class="text-center">رقم الفاتورة</th>
                                <th class="text-center">التاريخ</th>
                                <th class="text-center">الوقت</th>
                                <th class="text-center">خزنة الدفع</th>
                                <th class="text-center"> ملاحظات </th>
                                <th class="text-center">المسؤول</th>
                                <th class="text-center">تحكم</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $i=0;
                            @endphp
                            @foreach ($buy_cashs as $key => $cash)
                                <tr>
                                    <td>{{ $cash->cash_number }}</td>
                                    <td>{{ $cash->supplier->supplier_name }}</td>
                                    <td>
                                        {{floatval($cash->amount)}}
                                    </td>
                                    <td>
                                        {{floatval($cash->balance_before)}}
                                    </td>
                                    <td>
                                        {{floatval($cash->balance_after)}}
                                    </td>
                                    <td>{{ $cash->bill_id }}</td>
                                    <td>{{ $cash->date }}</td>
                                    <td>{{ $cash->time }}</td>
                                    <td>{{ $cash->safe->safe_name }}</td>
                                    <td>{{ $cash->notes }}</td>
                                    <td>{{ $cash->client->name }}</td>
                                    <td class="d-flex justify-content-center">
                                        <a href="{{ route('client.edit.cash.suppliers', $cash->id) }}"
                                           class="" data-toggle="tooltip"
                                           title="تعديل" data-placement="top"><svg width="19" height="16" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M18.21 4.87258C18.6 4.48258 18.6 3.83258 18.21 3.46258L15.87 1.12258C15.5 0.732578 14.85 0.732578 14.46 1.12258L12.62 2.95258L16.37 6.70258M0.5 15.0826V18.8326H4.25L15.31 7.76258L11.56 4.01258L0.5 15.0826Z" fill="#4AA16A"></path>
                                            </svg></a>

                                        <a class="modal-effect  delete_cash"
                                           cash_id="{{ $cash->id }}"
                                           cash_details="{{ $cash->cash_number }}" data-toggle="modal"
                                           href="#modaldemo9"
                                           title="delete"><svg width="25" height="22" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M18.912 7.33301L18.111 20.95C18.0812 21.4594 17.8577 21.9381 17.4865 22.2881C17.1153 22.6382 16.6243 22.8331 16.114 22.833H8.886C8.37575 22.8331 7.88475 22.6382 7.5135 22.2881C7.14226 21.9381 6.91885 21.4594 6.889 20.95L6.09 7.33301H4V6.33301C4 6.2004 4.05268 6.07322 4.14645 5.97945C4.24021 5.88569 4.36739 5.83301 4.5 5.83301H20.5C20.6326 5.83301 20.7598 5.88569 20.8536 5.97945C20.9473 6.07322 21 6.2004 21 6.33301V7.33301H18.912ZM10.5 3.33301H14.5C14.6326 3.33301 14.7598 3.38569 14.8536 3.47945C14.9473 3.57322 15 3.7004 15 3.83301V4.83301H10V3.83301C10 3.7004 10.0527 3.57322 10.1464 3.47945C10.2402 3.38569 10.3674 3.33301 10.5 3.33301ZM9.5 9.83301L10 18.833H11.5L11.1 9.83301H9.5ZM14 9.83301L13.5 18.833H15L15.5 9.83301H14Z" fill="#F55549"></path>
                                        </svg></a>
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
            <div class="modal-dialog modal-dialog-centered" cash="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header text-center">
                        <h6 class="modal-title w-100" style="font-family: 'Cairo'; ">حذف عملية سداد من عميل</h6>
                        <button aria-label="Close" class="close"
                                data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form action="{{ route('client.destroy.cash.suppliers', 'test') }}" method="post">
                        {{ method_field('delete') }}
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <p>هل انت متأكد من الحذف ?</p><br>
                            <input type="hidden" name="cashid" id="cashid">
                            <input class="form-control" name="cashdetails" id="cashdetails" type="text" readonly>
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
        $('.delete_cash').on('click', function () {
            var cash_id = $(this).attr('cash_id');
            var cash_details = $(this).attr('cash_details');
            $('.modal-body #cashid').val(cash_id);
            $('.modal-body #cashdetails').val(cash_details);
        });
        $('img').on('click', function () {
            var image_larger = $('#image_larger');
            var path = $(this).attr('src');
            $(image_larger).prop('src', path);
        });
    });
</script>
