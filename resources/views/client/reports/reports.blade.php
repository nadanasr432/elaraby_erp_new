@extends('client.layouts.app-main')
<style>
    li.custom {
        list-style: none;
        margin-top: 20px;
        font-size: 15px;
        color: #000;
        height: 40px;
        width: 100%;
        padding: 5px;
        background: #fff;
        text-align: center;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-shadow: 1px 1px 5px #aaa;
    }

    li.custom a {
        width: 80%;
        margin: 5px auto;
        color: #000;
    }

    div.box {
        height: auto;
        background: #fff;
        border: 1px solid #aaa;
        border-radius: 5px;
        box-shadow: 1px 1px 5px #aaa;
    }

    .box .box-header {
        width: 100%;
        height: 30px;text-shadow: 0px 0px 1px orangered!important;
        padding: 0; color: orangered!important;
        text-align: center;
        font-size: 18px!important;
        border-bottom: 1px solid #aaa;
    }

    .box .box-body {
        width: 100%;
        height: auto;
        padding: 0;
        text-align: center;
        font-size: 15px;
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
                    <li class="custom">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="card mg-b-20">
                <div class="card-body">
                    <h4 class="alert alert-sm alert-secondary text-center" style="font-size: 20px!important;">
                        تقارير عامة
                    </h4>
                    <div class="col-lg-4 pull-right">
                        <div class="box m-1 p-1">
                            <div class="box-header">
                                تقارير المنتجات
                            </div>
                            <div class="box-body">
                                <li class="custom">
                                    <a href="{{ url('/client/report2/get') }}"><i
                                            class="fa fa-plus text-success tx-20"></i>
                                        مبيعات حسب المنتج
                                    </a>
                                </li>
                                <li class="custom">
                                    <a href="{{ url('/client/report4/get') }}"><i
                                            class="fa fa-plus text-success tx-20"></i>
                                        مشتريات حسب المنتج
                                    </a>
                                </li>
                                <li class="custom">
                                    <a href="{{ url('/client/report18/get') }}"><i
                                            class="fa fa-plus text-success tx-20"></i>
                                        تقرير المنتجات الاكثر مبيعا
                                    </a>
                                </li>
                                <li class="custom">
                                    <a href="{{ url('/client/report21/get') }}"><i
                                            class="fa fa-plus text-success tx-20"></i>
                                        تقرير حركة فرع
                                    </a>
                                </li>
                                <li class="custom">
                                    <a href="{{ url('/client/report19/get') }}"><i
                                            class="fa fa-plus text-success tx-20"></i>
                                        تقرير حركة منتج
                                    </a>
                                </li>
                            </div>
                        </div>
                        <div class="box m-1 p-1">
                            <div class="box-header">
                                تقارير كشف الحساب
                            </div>
                            <div class="box-body">
                                <li class="custom">
                                    <a href="{{ url('/client/clients-summary-get') }}"><i
                                            class="fa fa-plus text-success tx-20"></i>
                                        كشف حساب عميل
                                    </a>
                                </li>
                                <li class="custom">
                                    <a href="{{ url('/client/suppliers-summary-get') }}"><i
                                            class="fa fa-plus text-success tx-20"></i>
                                        كشف حساب مورد
                                    </a>
                                </li>
                                <li class="custom">
                                    <a href="{{ url('/client/employees-summary-get') }}"><i
                                            class="fa fa-plus text-success tx-20"></i>
                                        كشف حساب موظف
                                    </a>
                                </li>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 pull-right">
                        <div class="box m-1 p-1">
                            <div class="box-header">
                                تقارير الديون
                            </div>
                            <div class="box-body">
                                <li class="custom">
                                    <a href="{{ url('/client/report5/get') }}"><i
                                            class="fa fa-plus text-success tx-20"></i>
                                        مديونية العملاء
                                    </a>
                                </li>
                                <li class="custom">
                                    <a href="{{ url('/client/report6/get') }}"><i
                                            class="fa fa-plus text-success tx-20"></i>
                                        مديونية الموردين
                                    </a>
                                </li>
                            </div>
                        </div>
                        <div class="box m-1 p-1">
                            <div class="box-header">
                                تقارير المبيعات
                            </div>
                            <div class="box-body">
                                <li class="custom">
                                    <a href="{{ url('/client/report1/get') }}"><i
                                            class="fa fa-plus text-success tx-20"></i>
                                        مبيعات حسب العميل
                                    </a>
                                </li>
                                <li class="custom">
                                    <a href="{{ url('/client/report10/get') }}"><i
                                            class="fa fa-plus text-success tx-20"></i>
                                        تقرير كمية المنتجات المباعة
                                    </a>
                                </li>
                                <li class="custom">
                                    <a href="{{ url('/client/report22/get') }}"><i
                                            class="fa fa-plus text-success tx-20"></i>
                                        تقرير الاقرار الضريبى الشامل
                                    </a>
                                </li>
                            </div>
                        </div>
                        <div class="box m-1 p-1">
                            <div class="box-header">
                                تقارير المشتريات
                            </div>
                            <div class="box-body">
                                <li class="custom">
                                    <a href="{{ url('/client/report3/get') }}"><i
                                            class="fa fa-plus text-success tx-20"></i>
                                        مشتريات حسب المورد
                                    </a>
                                </li>
                                <li class="custom">
                                    <a href="{{ url('/client/report8/get') }}"><i
                                            class="fa fa-plus text-success tx-20"></i>
                                        تقرير كمية المنتجات المشتراه
                                    </a>
                                </li>
                                <li class="custom">
                                    <a href="{{ url('/client/report9/get') }}"><i
                                            class="fa fa-plus text-success tx-20"></i>
                                        تقرير تكلفة الشراء المنتجات
                                    </a>
                                </li>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 pull-right">
                        <div class="box m-1 p-1">
                            <div class="box-header">
                                تقارير البنوك والخزن
                            </div>
                            <div class="box-body">
                                <li class="custom">
                                    <a href="{{ url('/client/report15/get') }}"><i
                                            class="fa fa-plus text-success tx-20"></i>
                                        تقرير حركة بنك
                                    </a>
                                </li>
                                <li class="custom">
                                    <a href="{{ url('/client/report20/get') }}"><i
                                            class="fa fa-plus text-success tx-20"></i>
                                        تقرير حركة خزنة
                                    </a>
                                </li>
                            </div>
                        </div>
                        <div class="box m-1 p-1">
                            <div class="box-header">
                                تقارير المالية
                            </div>
                            <div class="box-body">
                                <li class="custom">
                                    <a href="{{ url('/client/report7/get') }}"><i
                                            class="fa fa-plus text-success tx-20"></i>
                                        تقرير راس المال
                                    </a>
                                </li>
                                <li class="custom">
                                    <a href="{{ url('/client/report11/get') }}"><i
                                            class="fa fa-plus text-success tx-20"></i>
                                        تقرير ما تم تحصيله من العملاء
                                    </a>
                                </li>
                                <li class="custom">
                                    <a href="{{ url('/client/report12/get') }}"><i
                                            class="fa fa-plus text-success tx-20"></i>
                                        تقرير ما تم دفعه الى الموردين
                                    </a>
                                </li>
                                <li class="custom">
                                    <a href="{{ url('/client/report13/get') }}"><i
                                            class="fa fa-plus text-success tx-20"></i>
                                        تقرير الارباح
                                    </a>
                                </li>
                                <li class="custom">
                                    <a href="{{ url('/client/report14/get') }}"><i
                                            class="fa fa-plus text-success tx-20"></i>
                                        تقرير المصاريف
                                    </a>
                                </li>
                                <li class="custom">
                                    <a href="{{ url('/client/report17/get') }}"><i
                                            class="fa fa-plus text-success tx-20"></i>
                                        تقرير المالية
                                    </a>
                                </li>
                                <li class="custom">
                                    <a href="{{ url('/client/report16/get') }}"><i
                                            class="fa fa-plus text-success tx-20"></i>
                                        تقرير العمل الشامل
                                    </a>
                                </li>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
<script src="{{asset('app-assets/js/jquery.min.js')}}"></script>
<script>

</script>
