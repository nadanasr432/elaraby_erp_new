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
                            تقرير راس المال
                        </h5>
                    </div>
                    <div class="clearfix"></div>
                    <hr>
                    <form action="{{route('client.report7.post')}}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="col-lg-3 pull-right no-print">
                            <label for="" class="d-block">اسم الخزنة</label>
                            <select required name="safe_id" id="safe_id" class="selectpicker"
                                    data-style="btn-info" data-live-search="true" title="اكتب او اختار اسم الخزنة">
                                <option
                                    @if(isset($safe_id) && $safe_id == "all")
                                    selected
                                    @endif
                                    value="all">كل الخزن
                                </option>
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
                    @if(isset($capitals) && !empty($capitals))
                        <p class="alert alert-sm alert-danger mt-2 mb-2 text-center">
                            تقرير راس المال
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
                                        <td>
                                            {{floatval($capital->amount)}}
                                        </td>
                                        <td>{{ $capital->safe->safe_name }}</td>
                                        <td>
                                            {{floatval($capital->balance_before)}}
                                        </td>
                                        <td>
                                            {{floatval($capital->balance_after)}}
                                        </td>
                                        <td>{{ $capital->created_at }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if(isset($capital_amounts) && !empty($capital_amounts))
                            <div class="row mt-2">
                                <span class=" col-lg-4 col-sm-12 alert alert-secondary alert-sm mr-5">
                                    اجمالى المبالغ
                                    ( {{floatval($capital_amounts)}} )
                                </span>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
<script src="{{asset('app-assets/js/jquery.min.js')}}"></script>
<script>

</script>
