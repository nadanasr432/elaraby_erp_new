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
        <div class="alert alert-danger alert-dismissable fade show">
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
                            <h5 class="pull-right alert alert-sm alert-success"> تقرير حركة خزنة </h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
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
                    <hr>
                    <form action="{{route('client.report20.post')}}" class="no-print" method="POST">
                        @csrf
                        @method('POST')
                        <div class="col-lg-3 pull-right no-print">
                            <label for="" class="d-block">اسم الخزنة </label>
                            <select required name="safe_id" id="safe_id" class="selectpicker"
                                    data-style="btn-warning" data-live-search="true" title="اكتب او اختار اسم الخزنة">
                                @foreach($safes as $safe)
                                    <option
                                        @if(isset($safe_id) && $safe->id == $safe_id)
                                        selected
                                        @endif
                                        value="{{$safe->id}}">{{$safe->safe_name}}</option>
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
                    @if(isset($safe_k) && !empty($safe_k))
                        <p class="alert alert-sm alert-danger mt-2 mb-2 text-center">
                            تقرير حركة خزنة
                        </p>
                    @endif
                    @if(isset($bank_safe_transfers) && !$bank_safe_transfers->isEmpty())
                        <hr>
                        <p class="alert alert-sm alert-success text-center">
                            عمليات التحويل من بنك الى خزنة
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
                                        <td>{{floatval( $transfer->amount  )}}</td>
                                        <td>{{ $transfer->reason }}</td>
                                        <td>{{ $transfer->client->name }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                    @if(isset($safe_bank_transfers) && !$safe_bank_transfers->isEmpty())
                        <hr>
                        <p class="alert alert-sm alert-success text-center">
                            عمليات التحويل من خزنة الى بنك
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
                                        <td>{{floatval( $transfer->amount  )}}</td>
                                        <td>{{ $transfer->reason }}</td>
                                        <td>{{ $transfer->client->name }}</td>

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                    @if(isset($safes_transfers) && !$safes_transfers->isEmpty())
                        <hr>
                        <p class="alert alert-sm alert-success text-center">
                            عمليات التحويل بين الخزن
                        </p>
                        <div class="table-responsive">
                            <table class="table table-condensed table-striped table-bordered text-center table-hover">
                                <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center"> من خزنة</th>
                                    <th class="text-center"> الى خزنة</th>
                                    <th class="text-center"> المبلغ</th>
                                    <th class="text-center">السبب</th>
                                    <th class="text-center">المسؤول</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $i=0;
                                @endphp
                                @foreach ($safes_transfers as $key => $transfer)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $transfer->fromSafe->safe_name }}</td>
                                        <td>{{ $transfer->toSafe->safe_name }}</td>
                                        <td>{{floatval( $transfer->amount  )}}</td>
                                        <td>{{ $transfer->reason }}</td>
                                        <td>{{ $transfer->client->name }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                    @if(isset($buy_cashs) && !$buy_cashs->isEmpty())
                        <hr>
                        <p class="alert alert-sm alert-success text-center">
                            مدفوعات الموردين وفواتير المشتريات
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
                                @php
                                    $i=0;
                                @endphp
                                @foreach($buy_cashs as $cash)
                                    <tr>
                                        <td>{{++$i}}</td>
                                        <td>
                                            <?php
                                            if ($cash->bill_id != "") {
                                                echo "فاتورة مشتريات";
                                            } else {
                                                if ($cash->amount > 0) {
                                                    echo "  دفعة الى المورد " . $cash->supplier->supplier_name;
                                                } else {
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

                    @if(isset($capitals) && !$capitals->isEmpty())
                        <hr>
                        <p class="alert alert-sm alert-success text-center">
                            مبالغ راس المال المضافة
                        </p>
                        <div class="table-responsive">
                            <table class="table table-condensed table-striped table-bordered text-center table-hover">
                                <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">المبلغ</th>
                                    <th class="text-center">الخزنة</th>
                                    <th class="text-center">رصيد ما قبل</th>
                                    <th class="text-center">رصيد ما بعد</th>
                                    <th class="text-center">تاريخ - وقت</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $i=0;
                                @endphp
                                @foreach ($capitals as $key => $capital)
                                    <tr>
                                        <td>{{++$i}}</td>
                                        <td>{{floatval( $capital->amount  )}}</td>
                                        <td>{{ $capital->safe->safe_name }}</td>
                                        <td>{{floatval( $capital->balance_before  )}}</td>
                                        <td>{{floatval( $capital->balance_after  )}}</td>
                                        <td>{{ $capital->created_at }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                    @if(isset($cashs) && !$cashs->isEmpty())
                        <hr>
                        <p class="alert alert-sm alert-success text-center">
                            مدفوعات العملاء وفواتير البيع عملاء
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
                                @php
                                    $i=0;
                                @endphp
                                @foreach($cashs as $cash)
                                    <tr>
                                        <td>{{++$i}}</td>
                                        <td>
                                            <?php
                                            if ($cash->bill_id != "") {
                                                echo "فاتورة مبيعات عملاء ";
                                            } else {
                                                if ($cash->amount > 0) {
                                                    echo "تحصيل من العميل " . $cash->outerClient->client_name;
                                                } else {
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

                    @if(isset($employees_cashs) && !$employees_cashs->isEmpty())
                        <hr>
                        <p class="alert alert-sm alert-success text-center">
                            مدفوعات الموظفين ورواتبهم
                        </p>

                        <table class="table table-condensed table-striped table-bordered text-center table-hover">
                            <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">اسم الموظف</th>
                                <th class="text-center"> التاريخ</th>
                                <th class="text-center"> المبلغ</th>
                                <th class="text-center"> الخزنة</th>
                                <th class="text-center"> ملاحظات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $i=0;
                            @endphp
                            @foreach ($employees_cashs as $key => $employee_cash)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $employee_cash->employee->name}}</td>
                                    <td>{{ $employee_cash->date}}</td>
                                    <td>{{ $employee_cash->amount}}</td>
                                    <td>{{ $employee_cash->safe->safe_name}}</td>
                                    <td>{{ $employee_cash->notes}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif

                    @if(isset($expenses) && !$expenses->isEmpty())
                        <hr>
                        <p class="alert alert-sm alert-success text-center">
                            المصروفات
                        </p>
                        <div class="table-responsive">
                            <table class="table table-condensed table-striped table-bordered text-center table-hover">
                                <thead>
                                <tr>
                                    <th class="text-center">رقم المصروف</th>
                                    <th class="text-center">بيان المصروف</th>
                                    <th class="text-center">نوع المصروف</th>
                                    <th class="text-center">المبلغ</th>
                                    <th class="text-center">الموظف</th>
                                    <th class="text-center">الصورة</th>
                                    <th class="text-center">خزنة الدفع</th>
                                    <th class="text-center">المسؤول</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $i=0;
                                @endphp
                                @foreach ($expenses as $key => $expense)
                                    <tr>
                                        <td>{{ $expense->expense_number }}</td>
                                        <td>{{ $expense->expense_details }}</td>
                                        <td>{{ $expense->fixed->fixed_expense}}</td>
                                        <td>{{floatval( $expense->amount  )}}</td>
                                        <td>
                                            @if(!empty($expense->employee_id))
                                                {{$expense->employee->name}}
                                            @endif
                                        </td>
                                        <td>
                                            <img data-toggle="modal" href="#modaldemo8"
                                                 src="{{asset($expense->expense_pic)}}"
                                                 style="width:50px; height: 50px;cursor:pointer;"
                                                 alt=""/>
                                        </td>
                                        <td>{{ $expense->safe->safe_name }}</td>
                                        <td>{{ $expense->client->name }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                    @if(isset($safe_k) && !empty($safe_k))
                        <div class="row mt-3">
                            <span class="col-lg-4 col-sm-12 alert alert-secondary alert-sm mr-5">
                                 الرصيدالحالى للخزنة
                                ( {{floatval( $safe_k->balance  ) }} )
                            </span>
                        </div>
                    @endif
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="modaldemo8">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-content-demo">
                <div class="modal-header text-center">
                    <h6 class="modal-title w-100"
                        style="font-family: 'Cairo'; ">عرض صورة المصروف </h6>
                    <button aria-label="Close" class="close"
                            data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <img id="image_larger" alt="image" style="width: 100%; "/>
                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn btn-sm btn-danger"><i class="fa fa-colse"></i> Close
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection
<script src="{{asset('app-assets/js/jquery.min.js')}}"></script>
<script>
    $(document).ready(function () {
        $('img').on('click', function () {
            var image_larger = $('#image_larger');
            var path = $(this).attr('src');
            $(image_larger).prop('src', path);
        });
    });
</script>
