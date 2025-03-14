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
                            تقرير مديونية العملاء
                        </h5>
                    </div>
                    <div class="clearfix"></div>
                    <hr>
                    <form action="{{route('client.report5.post')}}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="col-lg-4 pull-right no-print">
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
                        <div class="col-lg-4 pull-right">
                            <button class="btn btn-md btn-danger"
                                    style="font-size: 15px; height: 40px; margin-top: 25px;" type="submit">
                                <i class="fa fa-check"></i>
                                عرض التقرير
                            </button>
                        </div>
                    </form>
                    <div class="clearfix"></div>
                    @if(isset($outerClients) && !empty($outerClients))
                        <p class="alert alert-sm alert-danger mt-2 mb-2 text-center">
                            تقرير مديونية العملاء
                        </p>
                        <div class="table-responsive">
                            <table class="table table-condensed table-striped table-bordered text-center table-hover">
                                <thead>
                                <tr>
                                    <th class="text-center">تكويد</th>
                                    <th class="text-center">الاسم</th>
                                    <th class="text-center">الفئة</th>
                                    <th class="text-center"> مديونية</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $i=0;
                                @endphp
                                @foreach ($outerClients as $key => $outer_client)
                                    <tr>
                                        <td>{{ $outer_client->client_number }}</td>
                                        <td>{{ $outer_client->client_name }}</td>
                                        <td>{{ $outer_client->client_category }}</td>
                                        <td>
                                            @if($outer_client->prev_balance > 0 )
                                                عليه
                                                {{floatval( $outer_client->prev_balance  )}}
                                            @elseif($outer_client->prev_balance < 0)
                                                له
                                                {{floatval( abs($outer_client->prev_balance)  )}}
                                            @else
                                                0
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if(isset($total_balances) && !empty($total_balances))
                            <div class="col-lg-6 pull-right p-2">
                                <p class="alert alert-info alert-sm" dir="rtl">
                                    اجمالى مديونيات العملاء :
                                    @if($total_balances > 0 )
                                        عليهم
                                        {{floatval( $total_balances  )}}
                                    @elseif($total_balances < 0)
                                        لهم
                                        {{floatval( abs($total_balances)  )}}
                                    @else
                                        0
                                    @endif
                                    {{$currency}}
                                </p>
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
