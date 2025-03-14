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
                            تقرير المصاريف
                        </h5>
                    </div>
                    <div class="clearfix"></div>
                    <hr>
                    <form action="{{route('client.report14.post')}}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="col-lg-3 pull-right no-print">
                            <label for="fixed_expense" class="d-block"> نوع المصروف الثابت </label>
                            <select required name="fixed_expense" id="fixed_expense" class="selectpicker"
                                    data-style="btn-info" data-live-search="true"
                                    title="اكتب او اختار نوع المصروف الثابت ">
                                <option
                                    @if(isset($fixed_expense) && $fixed_expense == "all")
                                    selected
                                    @endif
                                    value="all">كل المصاريف
                                </option>
                                @foreach($fixed_expenses as $fixed)
                                    <option
                                        @if(isset($fixed_expense) && $fixed->id == $fixed_expense)
                                        selected
                                        @endif
                                        value="{{$fixed->id}}">{{$fixed->fixed_expense}}</option>
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
                    @if(isset($expenses) && !empty($expenses))
                        <p class="alert alert-sm alert-danger mt-2 mb-2 text-center">
                            تقرير المصروفات
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
                                    $i=0; $total = 0;
                                @endphp
                                @foreach ($expenses as $key => $expense)
                                    <tr>
                                        <td>{{ $expense->expense_number }}</td>
                                        <td>{{ $expense->expense_details }}</td>
                                        <td>{{ $expense->fixed->fixed_expense}}</td>
                                        <td>
                                            {{floatval($expense->amount)}}
                                        </td>
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
                                    <?php $total = $total + $expense->amount; ?>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row mt-3">
                            <span class="col-lg-4 col-sm-12 alert alert-secondary alert-sm mr-5">
                                اجمالى المصروفات
                                ( {{floatval($total)}} )
                            </span>
                        </div>

                    @endif
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
