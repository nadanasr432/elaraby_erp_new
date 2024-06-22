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
                            تقرير مديونية الموردين
                        </h5>
                    </div>
                    <div class="clearfix"></div>
                    <hr>
                    <form action="{{route('client.report6.post')}}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="col-lg-4 pull-right no-print">
                            <label for="" class="d-block">اسم المورد</label>
                            <select required name="supplier_id" id="supplier_id" class="selectpicker"
                                    data-style="btn-info" data-live-search="true" title="اكتب او اختار اسم المورد">
                                <option
                                    @if(isset($supplier_id) && $supplier_id == "all")
                                    selected
                                    @endif
                                    value="all">كل الموردين
                                </option>
                                @foreach($suppliers as $supplier)
                                    <option
                                        @if(isset($supplier_id) && $supplier->id == $supplier_id)
                                        selected
                                        @endif
                                        value="{{$supplier->id}}">{{$supplier->supplier_name}}</option>
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
                    @if(isset($Suppliers) && !empty($Suppliers))
                        <p class="alert alert-sm alert-danger mt-2 mb-2 text-center">
                            تقرير مديونية الموردين
                        </p>
                        <div class="table-responsive">
                            <table class="table table-condensed table-striped table-bordered text-center table-hover">
                                <thead>
                                <tr>
                                    <th class="text-center">الاسم</th>
                                    <th class="text-center">الفئة</th>
                                    <th class="text-center"> مديونية</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $i=0;
                                @endphp
                                @foreach ($Suppliers as $key => $supplier)
                                    <tr>
                                        <td>{{ $supplier->supplier_name }}</td>
                                        <td>{{ $supplier->supplier_category }}</td>
                                        <td>{{floatval( $supplier->prev_balance  )}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if(isset($total_balances) && !empty($total_balances))
                            <div class="col-lg-4 pull-right p-2">
                                <p class="alert alert-info alert-sm" dir="rtl">
                                    اجمالى مستحقات الموردين :
                                    {{floatval( $total_balances  )}} {{$currency}}
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
