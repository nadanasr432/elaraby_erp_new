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
                        <div class="col-lg-12 margin-tb">
                            <a class="btn pull-left btn-primary btn-sm"
                               href="{{ route('client.add.cashbank.clients') }}"><i
                                    class="fa fa-plus"></i> دفع بنكى من عميل </a>
                            <h5 class="pull-right alert alert-sm alert-success">دفعات بنكية سابقة من العملاء</h5>
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
                                <th class="text-center">العميل</th>
                                <th class="text-center">المبلغ</th>
                                <th class="text-center">رصيد قبل</th>
                                <th class="text-center">رصيد بعد</th>
                                <th class="text-center">رقم الفاتورة</th>
                                <th class="text-center">التاريخ</th>
                                <th class="text-center">الوقت</th>
                                <th class="text-center">البنك</th>
                                <th class="text-center">رقم المعاملة</th>
                                <th class="text-center">ملاحظات</th>
                                <th class="text-center">المسؤول</th>
                                <th class="text-center">تحكم</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $i=0;
                            @endphp
                            @foreach ($cashs as $key => $cash)
                                <tr>
                                    <td>{{ $cash->cash_number }}</td>
                                   <td>{{ $cash->outerClient->client_name ?? '' }}</td>

                                    <td>
                                        {{floatval($cash->amount)}}
                                    </td>
                                    <td>
                                        {{floatval($cash->balance_before)}}
                                    </td>
                                    <td>
                                        {{floatval($cash->balance_after)}}
                                    </td>
                                    <td>{{ $cash->bill_id ?? ''}}</td>
                                    <td>{{ $cash->date ?? ''}}</td>
                                    <td>{{ $cash->time ?? ''}}</td>
                                    <td>{{ $cash->bank->bank_name ?? '' }}</td>
                                    <td>{{ $cash->bank_check_number ?? ''}}</td>
                                    <td>{{ $cash->notes ?? ''}}</td>
                                    <td>{{ $cash->client->name ?? ''}}</td>
                                    <td>
                                        <a href="{{ route('client.edit.cashbank.clients', $cash->id) }}"
                                           class="btn btn-sm btn-info" data-toggle="tooltip"
                                           title="تعديل" data-placement="top"><i class="fa fa-edit"></i></a>

                                        <a class="modal-effect btn btn-sm btn-danger delete_cash"
                                           cash_id="{{ $cash->id }}"
                                           cash_details="{{ $cash->outerClient->client_name ?? ' '}}" data-toggle="modal"
                                           href="#modaldemo9"
                                           title="delete"><i
                                                class="fa fa-trash"></i></a>
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
                    <form action="{{ route('client.destroy.cashbank.clients', 'test') }}" method="post">
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
