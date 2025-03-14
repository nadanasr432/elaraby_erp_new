@extends('client.layouts.app-main')
<style>
    .btn.dropdown-toggle.bs-placeholder {
        height: 40px;
    }

    .bootstrap-select {
        width: 100% !important;
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

    <div class="row">
        <div class="col-md-12">
            <div class="card mg-b-20">
                <div class="company_details printy" style="display: none;">
                    <div class="text-center">
                        <img class="logo" style="width: 20%;" src="{{asset($company->company_logo)}}" alt="">
                    </div>
                    <div class="text-center">
                        <div class="col-lg-12 text-center justify-content-center">
                            <p class="alert alert-secondary text-center alert-sm"
                               style="margin: 10px auto; font-size: 17px;line-height: 1.9;" dir="rtl">
                                {{$company->company_name}} -- {{$company->business_field}} <br>
                                {{$company->company_owner}} -- {{$company->phone_number}} <br>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="col-12 no-print">
                        <h5 style="min-width: 300px;" class="pull-right alert alert-sm alert-danger">
                            تقرير ما تم تحصيله من العملاء
                        </h5>
                    </div>
                    <div class="clearfix"></div>
                    <hr>
                    <form action="{{route('client.report11.post')}}" class="no-print" method="POST">
                        @csrf
                        @method('POST')
                        <div class="col-lg-3 pull-right no-print">
                            <label for="" class="d-block">اسم العميل</label>
                            <select required name="outer_client_id" id="outer_client_id" class="selectpicker"
                                    data-style="btn-info" data-live-search="true" title="اكتب او اختار اسم العميل">
                                <option
                                    @if(isset($outer_client_id) && $outer_client_id == "all")
                                    selected
                                    @endif
                                    value="all">كل العملاء
                                </option>
                                @foreach($outer_clients as $outer_client)
                                    <option
                                        @if(isset($outer_client_id) && $outer_client->id == $outer_client_id)
                                        selected
                                        @endif
                                        value="{{$outer_client->id}}">{{$outer_client->client_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-3 pull-right no-print">
                            <label for="" class="d-block">من تاريخ</label>
                            <input type="date" @if(isset($from_date) && !empty($from_date)) value="{{$from_date}}"
                                   @endif class="form-control" name="from_date"/>
                        </div>
                        <div class="col-lg-3 pull-right no-print">
                            <label for="" class="d-block">الى تاريخ</label>
                            <input type="date" @if(isset($to_date) && !empty($to_date)) value="{{$to_date}}"
                                   @endif  class="form-control" name="to_date"/>
                        </div>
                        <div class="col-lg-3 pull-right">
                            <button class="btn btn-md btn-danger"
                                    style="font-size: 15px; height: 40px; margin-top: 25px;" type="submit">
                                <i class="fa fa-check"></i>
                                عرض التقرير
                            </button>
                        </div>
                    </form>
                    <div class="clearfix"></div>
                    @if(isset($cashs) && !empty($cashs))
                        <p class="alert alert-sm alert-danger mt-2 mb-2 text-center">
                            تقرير ما تم تحصيله من العملاء
                        </p>
                        <div class="table-responsive">
                            <table class="table table-condensed table-striped table-bordered text-center table-hover">
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
                                    <th class="text-center">خزنة الدفع</th>
                                    <th class="text-center no-print">المسؤول</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $i=0; $totalCashs = 0;
                                @endphp
                                @foreach ($cashs as $key => $cash)
                                    <tr>
                                        <td>{{ $cash->cash_number }}</td>
                                        <td>
                                            @if(empty($cash->outer_client_id))
                                                عميل مبيعات نقدية
                                            @else
                                                {{$cash->outerClient->client_name}}
                                            @endif
                                        </td>
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
                                        <td class="no-print">{{ $cash->client->name }}</td>
                                    </tr>
                                    <?php $totalCashs = $totalCashs + floatval($cash->amount); ?>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row mt-3">
                            <span class=" col-lg-4 col-sm-12 alert alert-secondary alert-sm mr-5">
                                اجمالى  ما تم تحصيله
                                ( {{floatval($totalCashs)}} )
                            </span>
                        </div>
                        <div class="clearfix"></div>
                        <div class="mt-3 no-print">
                            <button type="button" onclick="window.print()" class="btn btn-md btn-info pull-right">
                                <i class="fa fa-print"></i>
                                طباعة التقرير
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
<script src="{{asset('app-assets/js/jquery.min.js')}}"></script>
<script>

</script>
