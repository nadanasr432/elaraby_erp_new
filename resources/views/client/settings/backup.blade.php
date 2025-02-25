@extends('client.layouts.app-main')
<style>
    .nav-link  {
        border-radius: 5px !important;
        margin: 2px;
    }

    .active {
        background: #222751;
        color: #fff;

    } 
    .active:hover{
        color: #fff;

    }

    .form-control,
    .input-group-addon {
        padding: 10px !important;
        height: 40px !important;
        border: 1px solid #ddd;
        border-right: 0;
    }

    .input-group-addon {
        border-top-left-radius: 5px !important;
        border-bottom-left-radius: 5px !important;
        border-top-right-radius: 0 !important;
        border-bottom-right-radius: 0 !important;
    }

    .input-spec {
        border-right: 0;
        border-top-left-radius: 0 !important;
        border-bottom-left-radius: 0 !important;
        border-top-right-radius: 5px !important;
        border-bottom-right-radius: 5px !important;
    }
</style>
@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissable fade show">
            <button class="close" data-dismiss="alert" aria-label="Close">×</button>
            {{ session('success') }}
        </div>
    @endif
    <div class="bg-white p-2 m-1">
        <div class="row">
            <div class="col-12">
                <p class="alert custom-title">
                    الاعدادات العامة للنظام
                </p>
            </div>
            <div class="px-2 d-flex flex-wrap">

            <a class="nav-link text-dark" style="border:1px solid #bbb" href="{{ route('client.basic.settings.edit') }}">
                <i class="fa fa-home"></i> {{ __('main.main-information') }} للنظام</a>
    
            <a class="nav-link text-dark" style="border:1px solid #bbb" href="{{ route('client.extra.settings.edit') }}">
                <i class="fa fa-money"></i> البيانات الاضافية للنظام </a>
    
            <a class="nav-link  active" style="border:1px solid #bbb" href="{{ route('client.backup.settings.edit') }}">
                <i class="fa fa-copy"></i> اعدادات النسخة الاحتياطية </a>
            <a class="nav-link text-dark " style="border:1px solid #bbb" href="{{ route('client.get.product_expires') }}">
                <i class="fa fa-copy"></i> اعدادات صلاحية المنتجات </a>
    
            <a class="nav-link text-dark " style="border:1px solid #bbb" href="{{ route('client.billing.settings.edit') }}">
                <i class="fa fa-envelope"></i> بيانات الفواتير والضرائب </a>
            </div>
            <div class="col-12 mt-3">
                <div class="row text-center">
                    <div class="col-lg-12">
                        <div class="col-lg-6 col-xs-12 pull-right">
                            <div class="card">
                                <div class="card-body" style="border-radius: 0 !important;">
                                    <h4 class="alert alert-sm alert-danger" style="padding: 10px 10px; margin:0 auto 10px;"><i
                                            class="fa fa-download"></i> تحميل النسخة الاحتياطية من قاعدة
                                        البيانات </h4>
                                    <a class="btn btn-danger btn-sm" href="{{ route('client.get.backup') }}"><i
                                            class="fa fa-download"></i> اضغط هنا لتحميلها </a> <br>
                                    <div class="text-danger">تحذير : يجب جيدا الاحتفاظ بهذه النسخة وعدم العبث
                                        بها
                                    </div>
                                    <div class="text-danger">تنوية : يجب المداومة على اخذ نسخة احتياطية من
                                        البيانات كل يوم
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xs-12 pull-right">
                            <div class="card">
                                <div class="card-body" style="border-radius: 0 !important;">
                                    <h4 class="alert alert-sm alert-success" style="padding: 10px 10px; margin:0 auto 10px;"><i
                                            class="fa fa-upload"></i> رفع النسخة الاحتياطية الى قاعدة
                                        البيانات </h4>
                                    <form method="POST" action="{{ route('client.restore') }}" enctype="multipart/form-data">
                                        @csrf
                                        @method('POST')
                                        <input class="form-control" required type="file" name="sql_file"
                                            style="margin: 10px auto; width: 80%;  " />
                                        <button type="submit" class="btn btn-success btn-sm" name="submit"><i
                                                class="fa fa-upload"></i> اضغط هنا لرفعها
                                        </button>
                                        <br>
                                    </form>
                                    <div class="text-success">تحذير : بعد عملية الرفع لن تكون قادرا على العودة
                                        الى ما كنت عليه مؤخرا
                                    </div>
                                    <div class="text-success">تنوية : سيتم تغيير كل البيانات بناءا على النسخة
                                        التى ستقوم برفعها
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
