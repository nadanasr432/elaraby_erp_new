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
                            تقرير المالية
                        </h5>
                    </div>
                    <div class="clearfix"></div>
                    <hr>
                    <form action="{{route('client.report17.post')}}" method="POST">
                        @csrf
                        @method('POST')

                        <div class="col-lg-3 pull-right no-print">
                            <label for="" class="d-block">اختر نوع العمليات</label>
                            <select required name="type" id="type" class="form-control">
                                <option
                                    @if(isset($type) && $type == "all")
                                    selected
                                    @endif
                                    value="all">كل العمليات
                                </option>
                                <option
                                    @if(isset($type) && $type == "purchases")
                                    selected
                                    @endif
                                    value="purchases">مشتريات
                                </option>
                                <option
                                    @if(isset($type) && $type == "sales")
                                    selected
                                    @endif
                                    value="sales"> مبيعات
                                </option>
                                <option
                                    @if(isset($type) && $type == "payments")
                                    selected
                                    @endif
                                    value="payments">مدفوعات
                                </option>
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
                    @if(isset($type) && !empty($type) && $type == "all")
                        <p class="alert alert-sm alert-danger mt-2 mb-2 text-center">
                            تقرير المالية
                        </p>
                        <div class="table-responsive">
                            <table class="table table-condensed table-striped table-bordered text-center table-hover">
                                <thead>
                                <tr>
                                    <th class="text-center"> م</th>
                                    <th class="text-center"> نوع العملية</th>
                                    <th class="text-center">المبلغ</th>
                                    <th class="text-center"> الخزنة</th>
                                    <th class="text-center"> التاريخ</th>
                                    <th class="text-center"> المسؤول</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i=0; ?>
                                @foreach($cashs as $cash)
                                    <tr>
                                        <td>{{++$i}}</td>
                                        <td>
                                            <?php
                                            if($cash->bill_id != ""){
                                                echo "فاتورة مبيعات عملاء ";
                                            }
                                            else{
                                                if ($cash->amount > 0){
                                                    echo "تحصيل من العميل " . $cash->outerClient->client_name;
                                                }
                                                else{
                                                    echo "سلفة الى العميل " . $cash->outerClient->client_name;
                                                }
                                            }
                                            ?>
                                        </td>
                                        <td>{{floatval( abs($cash->amount)  )}}</td>
                                        <td>{{$cash->safe->safe_name}}</td>
                                        <td>{{$cash->date}}</td>
                                        <td>{{$cash->client->name}}</td>
                                    </tr>
                                @endforeach
                                @foreach($buy_cashs as $cash)
                                    <tr>
                                        <td>{{++$i}}</td>
                                        <td>
                                            <?php
                                            if($cash->bill_id != ""){
                                                echo "فاتورة مشتريات";
                                            }
                                            else{
                                                if ($cash->amount > 0){
                                                    echo "  دفعة الى المورد " . $cash->supplier->supplier_name;
                                                }
                                                else{
                                                    echo "سلفة من المورد " . $cash->supplier->supplier_name;
                                                }
                                            }
                                            ?>
                                        </td>
                                        <td>{{floatval( abs($cash->amount)  )}}</td>
                                        <td>{{$cash->safe->safe_name}}</td>
                                        <td>{{$cash->date}}</td>
                                        <td>{{$cash->client->name}}</td>
                                    </tr>
                                @endforeach
                                @foreach($capitals as $capital)
                                    <tr>
                                        <td>{{++$i}}</td>
                                        <td>
                                            راس مال مضاف
                                        </td>
                                        <td>{{floatval( abs($capital->amount)  )}}</td>
                                        <td>{{$capital->safe->safe_name}}</td>
                                        <td>{{date('Y-m-d',strtotime($capital->created_at))}}</td>
                                        <td>{{$capital->client->name}}</td>
                                    </tr>
                                @endforeach
                                @foreach($expenses as $expense)
                                    <tr>
                                        <td>{{++$i}}</td>
                                        <td>
                                            مصروفات
                                            ( {{ $expense->expense_details }} )
                                        </td>
                                        <td>{{floatval( abs($expense->amount)  )}}</td>
                                        <td>{{$expense->safe->safe_name}}</td>
                                        <td>{{date('Y-m-d',strtotime($expense->created_at))}}</td>
                                        <td>{{$expense->client->name}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row mt-3 mb-3">
                            <span class="col-lg-4 col-sm-12 alert alert-secondary alert-sm mr-4">
                                اجمالى الداخل الى الخزن
                                <?php
                                $total_in = 0;
                                foreach ($cashs as $cash) {
                                    $total_in = $total_in + $cash->amount;
                                }
                                foreach ($capitals as $capital) {
                                    $total_in = $total_in + $capital->amount;
                                }
                                echo "( " . floatval($total_in) . " ) " . $currency;
                                ?>
                            </span>
                            <span class="col-lg-4 col-sm-12 alert alert-secondary alert-sm mr-4">
                                اجمالى الخارج من الخزن
                                <?php
                                $total_out = 0;
                                foreach ($buy_cashs as $cash) {
                                    $total_out = $total_out + $cash->amount;
                                }
                                foreach ($expenses as $expense) {
                                    $total_out = $total_out + $expense->amount;
                                }
                                echo "( " . floatval($total_out) . " ) " . $currency;
                                ?>
                            </span>

                            <span class="col-lg-4 col-sm-12 alert alert-secondary alert-sm mr-4">
                                اجمالى ارصدة الخزن
                                {{floatval($safes_balances)}} {{ $currency }}
                            </span>
                        </div>
                        <div class="clearfix"></div>
                    @endif
                    <div class="clearfix"></div>
                    @if(isset($type) && !empty($type) && $type == "purchases")
                        <p class="alert alert-sm alert-danger mt-2 mb-2 text-center">
                            تقرير المالية
                        </p>
                        <div class="table-responsive">
                            <table class="table table-condensed table-striped table-bordered text-center table-hover">
                                <thead>
                                <tr>
                                    <th class="text-center"> م</th>
                                    <th class="text-center"> نوع العملية</th>
                                    <th class="text-center">المبلغ</th>
                                    <th class="text-center"> الخزنة</th>
                                    <th class="text-center"> التاريخ</th>
                                    <th class="text-center"> المسؤول</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i=0; ?>
                                @foreach($buy_cashs as $cash)
                                    <tr>
                                        <td>{{++$i}}</td>
                                        <td>
                                            <?php
                                            if($cash->bill_id != ""){
                                                echo "فاتورة مشتريات";
                                            }
                                            else{
                                                if ($cash->amount > 0){
                                                    echo "  دفعة الى المورد " . $cash->supplier->supplier_name;
                                                }
                                                else{
                                                    echo "سلفة من المورد " . $cash->supplier->supplier_name;
                                                }
                                            }
                                            ?>
                                        </td>
                                        <td>{{floatval( abs($cash->amount)  )}}</td>
                                        <td>{{$cash->safe->safe_name}}</td>
                                        <td>{{$cash->date}}</td>
                                        <td>{{$cash->client->name}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                    <div class="clearfix"></div>
                    @if(isset($type) && !empty($type) && $type == "sales")
                        <p class="alert alert-sm alert-danger mt-2 mb-2 text-center">
                            تقرير المالية
                        </p>
                        <div class="table-responsive">
                            <table class="table table-condensed table-striped table-bordered text-center table-hover">
                                <thead>
                                <tr>
                                    <th class="text-center"> م</th>
                                    <th class="text-center"> نوع العملية</th>
                                    <th class="text-center">المبلغ</th>
                                    <th class="text-center"> الخزنة</th>
                                    <th class="text-center"> التاريخ</th>
                                    <th class="text-center"> المسؤول</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i=0; ?>
                                @foreach($cashs as $cash)
                                    <tr>
                                        <td>{{++$i}}</td>
                                        <td>
                                            <?php
                                            if($cash->bill_id != ""){
                                                echo "فاتورة مبيعات عملاء ";
                                            }
                                            else{
                                                if ($cash->amount > 0){
                                                    echo "تحصيل من العميل " . $cash->outerClient->client_name;
                                                }
                                                else{
                                                    echo "سلفة الى العميل " . $cash->outerClient->client_name;
                                                }
                                            }
                                            ?>
                                        </td>
                                        <td>{{floatval( abs($cash->amount)  )}}</td>
                                        <td>{{$cash->safe->safe_name}}</td>
                                        <td>{{$cash->date}}</td>
                                        <td>{{$cash->client->name}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                    <div class="clearfix"></div>
                    @if(isset($type) && !empty($type) && $type == "payments")
                        <p class="alert alert-sm alert-danger mt-2 mb-2 text-center">
                            تقرير المالية
                        </p>
                        <div class="table-responsive">
                            <table class="table table-condensed table-striped table-bordered text-center table-hover">
                                <thead>
                                <tr>
                                    <th class="text-center"> م</th>
                                    <th class="text-center"> نوع العملية</th>
                                    <th class="text-center">المبلغ</th>
                                    <th class="text-center">الموظف</th>
                                    <th class="text-center"> الخزنة</th>
                                    <th class="text-center"> التاريخ</th>
                                    <th class="text-center"> المسؤول</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i=0; ?>
                                @foreach($expenses as $expense)
                                    <tr>
                                        <td>{{++$i}}</td>
                                        <td>
                                            مصروفات
                                            ( {{ $expense->expense_details }} )
                                        </td>
                                        <td>{{floatval( abs($expense->amount)  )}}</td>
                                        <td>
                                            @if(!empty($expense->employee_id))
                                                {{$expense->employee->name}}
                                            @endif
                                        </td>
                                        <td>{{$expense->safe->safe_name}}</td>
                                        <td>{{date('Y-m-d',strtotime($expense->created_at))}}</td>
                                        <td>{{$expense->client->name}}</td>
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
