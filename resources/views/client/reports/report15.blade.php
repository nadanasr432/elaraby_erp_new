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
                <div class="card-body">
                    <div class="col-12">
                        <h5 style="min-width: 300px;" class="pull-right alert alert-sm alert-danger">
                            تقرير حركة بنك
                        </h5>
                    </div>
                    <div class="clearfix"></div>
                    <hr>
                    <form action="{{route('client.report15.post')}}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="col-lg-3 pull-right no-print">
                            <label for="bank_id" class="d-block"> اخترالبنك </label>
                            <select required name="bank_id" id="bank_id" class="selectpicker"
                                    data-style="btn-info" data-live-search="true"
                                    title="اكتب او اختار البنك ">
                                @foreach($banks as $bank)
                                    <option
                                        @if(isset($bank_id) && $bank->id == $bank_id)
                                        selected
                                        @endif
                                        value="{{$bank->id}}">{{$bank->bank_name}}</option>
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
                    @if(isset($bank_k) && !empty($bank_k))
                        <p class="alert alert-sm alert-danger mt-2 mb-2 text-center">
                            تقرير حركة بنك
                        </p>
                        <div class="table-responsive">
                            <table class="table table-condensed table-striped table-bordered text-center table-hover">
                                <thead>
                                <tr>
                                    <th class="text-center">اسم البنك</th>
                                    <th class="text-center">رصيد البنك</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>{{ $bank_k->bank_name }}</td>
                                    <td>
                                        {{floatval($bank_k->bank_balance)}}
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    @endif
                    @if(isset($bank_modifications) && !empty($bank_modifications))
                        <p class="alert alert-sm alert-danger mt-2 mb-2 text-center">
                            تعديلات رصيد البنك
                        </p>
                        <div class="table-responsive">
                            <table class="table table-condensed table-striped table-bordered text-center table-hover">
                                <thead>
                                <tr>
                                    <th class="text-center">اسم البنك</th>
                                    <th class="text-center">رصيد ما قبل التعديل</th>
                                    <th class="text-center">رصيد ما بعد التعديل</th>
                                    <th class="text-center"> سبب التعديل</th>
                                    <th class="text-center"> تاريخ</th>
                                    <th class="text-center"> المسؤول</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php $i=0; @endphp
                                @foreach($bank_modifications as $modification)
                                    <tr>
                                        <td>{{ $modification->bank->bank_name }}</td>
                                        <td>
                                            {{floatval($modification->balance_before)}}
                                        </td>
                                        <td>
                                            {{floatval($modification->balance_after)}}
                                        </td>
                                        <td>{{ $modification->reason}}</td>
                                        <td>{{ $modification->created_at }}</td>
                                        <td>{{ $modification->client->name }}</td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    @endif
                    @if(isset($bank_processes) && !empty($bank_processes))
                        <p class="alert alert-sm alert-danger mt-2 mb-2 text-center">
                            عمليات السحب والايداع للبنك
                        </p>
                        <div class="table-responsive">
                            <table class="table table-condensed table-striped table-bordered text-center table-hover">
                                <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center"> نوع العملية</th>
                                    <th class="text-center">اسم البنك</th>
                                    <th class="text-center"> المبلغ</th>
                                    <th class="text-center"> رصيد ما قبل</th>
                                    <th class="text-center"> رصيد ما بعد</th>
                                    <th class="text-center">السبب</th>
                                    <th class="text-center">التاريخ</th>
                                    <th class="text-center">المسؤول</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $i=0;
                                @endphp
                                @foreach ($bank_processes as $key => $process)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>
                                            @if($process->process_type == "withdrawal")
                                                سحب نقدى
                                            @elseif($process->process_type == "deposit")
                                                ايداع نقدى
                                            @endif
                                        </td>
                                        <td>{{ $process->bank->bank_name }}</td>
                                        <td>
                                            {{floatval($process->amount)}}
                                        </td>
                                        <td>
                                            {{floatval($process->balance_before)}}
                                        </td>
                                        <td>
                                            {{floatval($process->balance_after)}}
                                        </td>
                                        <td>{{ $process->reason }}</td>
                                        <td>{{ $process->created_at }}</td>
                                        <td>{{ $process->client->name }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                    @if(isset($bank_transfers) && !empty($bank_transfers))
                        <p class="alert alert-sm alert-danger mt-2 mb-2 text-center">
                            عمليات التحويل من والى البنك
                        </p>
                        <div class="table-responsive">
                            <table class="table table-condensed table-striped table-bordered text-center table-hover">
                                <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center"> بنك السحب</th>
                                    <th class="text-center"> بنك الايداع</th>
                                    <th class="text-center"> المبلغ</th>
                                    <th class="text-center">السبب</th>
                                    <th class="text-center">التاريخ</th>
                                    <th class="text-center">المسؤول</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $i=0;
                                @endphp
                                @foreach ($bank_transfers as $key => $transfer)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $transfer->withdrawal->bank_name }}</td>
                                        <td>{{ $transfer->deposit->bank_name }}</td>
                                        <td>{{floatval( $transfer->amount  )}}</td>
                                        <td>{{ $transfer->reason }}</td>
                                        <td>{{ $transfer->created_at }}</td>
                                        <td>{{ $transfer->client->name }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                    @if(isset($bank_safe_transfers) && !empty($bank_safe_transfers))
                        <p class="alert alert-sm alert-danger mt-2 mb-2 text-center">
                            عمليات التحويل من البنك الى الخزن
                        </p>
                        <div class="table-responsive">
                            <table class="table table-condensed table-striped table-bordered text-center table-hover">
                                <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center"> البنك</th>
                                    <th class="text-center"> الخزنة</th>
                                    <th class="text-center"> المبلغ</th>
                                    <th class="text-center">السبب</th>
                                    <th class="text-center">المسؤول</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $i=0;
                                @endphp
                                @foreach ($bank_safe_transfers as $key => $transfer)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $transfer->bank->bank_name }}</td>
                                        <td>{{ $transfer->safe->safe_name }}</td>
                                        <td>
                                            {{floatval($transfer->amount)}}
                                        </td>
                                        <td>{{ $transfer->reason }}</td>
                                        <td>{{ $transfer->client->name }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                    @if(isset($safe_bank_transfers) && !empty($safe_bank_transfers))
                        <p class="alert alert-sm alert-danger mt-2 mb-2 text-center">
                            عمليات التحويل من الخزن الى البنك
                        </p>
                        <div class="table-responsive">
                            <table class="table table-condensed table-striped table-bordered text-center table-hover">
                                <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center"> الخزنة</th>
                                    <th class="text-center"> البنك</th>
                                    <th class="text-center"> المبلغ</th>
                                    <th class="text-center">السبب</th>
                                    <th class="text-center">المسؤول</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $i=0;
                                @endphp
                                @foreach ($safe_bank_transfers as $key => $transfer)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $transfer->safe->safe_name }}</td>
                                        <td>{{ $transfer->bank->bank_name }}</td>
                                        <td>
                                            {{floatval($transfer->amount)}}
                                        </td>
                                        <td>{{ $transfer->reason }}</td>
                                        <td>{{ $transfer->client->name }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                    @if(isset($bank_cash) && !$bank_cash->isEmpty())
                        <p class="alert alert-sm alert-warning mt-3 text-center">
                            مدفوعات بنكية من العملاء لهذا البنك
                        </p>
                        <div class="table-responsive">
                            <table
                                class="table table-condensed table-striped table-bordered text-center table-hover">
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
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $i=0;
                                @endphp
                                @foreach ($bank_cash as $key => $cash)
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
                                        <td>{{ $cash->bank->bank_name }}</td>
                                        <td>{{ $cash->bank_check_number }}</td>
                                        <td>{{ $cash->notes }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                    @if(isset($bank_buy_cash) && !$bank_buy_cash->isEmpty())
                        <p class="alert alert-sm alert-warning mt-3 text-center">
                            مدفوعات بنكية الى الموردين من هذا البنك
                        </p>
                        <div class="table-responsive">
                            <table
                                class="table table-condensed table-striped table-bordered text-center table-hover">
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
                                    <th class="text-center">البنك</th>
                                    <th class="text-center">رقم المعاملة</th>
                                    <th class="text-center">ملاحظات</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $i=0;
                                @endphp
                                @foreach ($bank_buy_cash as $key => $cash)
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
                                        <td>{{ $cash->bank->bank_name }}</td>
                                        <td>{{ $cash->bank_check_number }}</td>
                                        <td>{{ $cash->notes }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
<script src="{{asset('app-assets/js/jquery.min.js')}}"></script>
<script>
    $(document).ready(function () {

    });
</script>
