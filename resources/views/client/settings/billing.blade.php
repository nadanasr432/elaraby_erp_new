@extends('client.layouts.app-main')
<style>
    .nav-link {
        border-radius: 5px !important;
        margin: 2px;
    }

    .active {
        background: #4e4ed5;
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
    <div class="row">
        <div class="col-12">
            <p class="alert alert-danger alert-sm text-center">
                الاعدادات العامة للنظام
            </p>
        </div>

        <a class="nav-link" style="border:1px solid #bbb" href="{{ route('client.basic.settings.edit') }}">
            <i class="fa fa-home"></i> {{ __('main.main-information') }} للنظام</a>

        <a class="nav-link" style="border:1px solid #bbb" href="{{ route('client.extra.settings.edit') }}">
            <i class="fa fa-money"></i> البيانات الاضافية للنظام </a>

        <a class="nav-link " style="border:1px solid #bbb" href="{{ route('client.backup.settings.edit') }}">
            <i class="fa fa-copy"></i> اعدادات النسخة الاحتياطية </a>

        <a class="nav-link active" style="border:1px solid #bbb" href="{{ route('client.billing.settings.edit') }}">
            <i class="fa fa-envelope"></i> بيانات الفواتير والضرائب </a>
        <div class="col-12 mt-3">
            <form action="{{ route('client.billing.settings.update') }}" method="POST">
                @csrf
                @method('PATCH')
                <input type="hidden" name="company_id" value="{{ $company->id }}" />
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-4 col-xs-12 pull-right">
                            <div class="form-group">
                                <label for="tax_number">الرقم الضريبى</label>
                                <input style="width:100%" type="text" class="form-control" dir="ltr"
                                    name="tax_number" id="tax_number"
                                    @if ($company->tax_number) value="{{ $company->tax_number }}" 
                                        disabled @endif />
                            </div>
                        </div>
                        <div class="col-lg-4 col-xs-12 pull-right">
                            <div class="form-group">
                                <label for="civil_register">السجل التجاري</label>
                                <input type="text" class="form-control" dir="ltr" name="civil_registration_number"
                                    value="{{ $company->civil_registration_number }}" id="civil_registration_number" />
                            </div>
                        </div>
                        <div class="col-lg-4 col-xs-12 pull-right">
                            <div class="form-group" dir="ltr">
                                <label for="tax_value_added">ضريبة القيمة المضافة</label>
                                <div class="input-group">
                                    <span class="input-group-addon" style="font-size: 18px;font-weight: bold;">%</span>
                                    <input type="number" class="form-control input-spec"
                                        value="{{ $company->tax_value_added }}" name="tax_value_added"
                                        id="tax_value_added" />
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-lg-6 col-xs-12 pull-right">
                            <div class="form-group" dir="ltr">
                                <label class="d-block" for="">
                                    كل المستخدمين يرون منتجات
                                    الفرع الرئيسى فى نقاط البيع
                                </label>
                                <select name="all_users_access_main_branch" class="form-control">
                                    <option @if ($company->all_users_access_main_branch == 'yes') selected @endif value="yes">نعم
                                    </option>
                                    <option @if ($company->all_users_access_main_branch == 'no') selected @endif value="no">لا
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-xs-12 pull-right">
                    <div class="form-group">
                        <button class="btn btn-md btn-success"><i class="fa fa-check"></i> حفظ
                        </button>
                    </div>
                </div>
                <div class="clearfix"></div>
            </form>
            <hr>
            <p class="alert alert-sm alert-danger text-center">
                الضرايب
            </p>
            <form action="{{ route('store.tax') }}" method="POST">
                @csrf
                <input type="hidden" name="company_id" value="{{ $company->id }}" />
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-4 col-xs-12 pull-right">
                            <div class="form-group">
                                <label for="tax_number">اسم الضريبة</label>
                                <input style="width:100%" required type="text" class="form-control" dir="rtl"
                                    name="tax_name" id="tax_name" />
                            </div>
                        </div>
                        <div class="col-lg-4 col-xs-12 pull-right">
                            <div class="form-group" dir="ltr">
                                <label for="tax_value">قيمة الضريبة</label>
                                <div class="input-group">
                                    <span class="input-group-addon" style="font-size: 18px;font-weight: bold;">%</span>
                                    <input required type="number" class="form-control input-spec" name="tax_value"
                                        id="tax_value" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-xs-12 pull-right">
                    <div class="form-group">
                        <button class="btn btn-md btn-success"><i class="fa fa-check"></i> حفظ
                        </button>
                    </div>
                </div>
                <div class="clearfix"></div>
            </form>
            <hr>
            <table class="table table-bordered table-condensed table-hover table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>اسم الضريبة</th>
                        <th>قيمة الضريبة</th>
                        <th>حذف</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 0; ?>
                    @foreach ($taxes as $tax)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $tax->tax_name }}</td>
                            <td>{{ $tax->tax_value }} %</td>
                            <td>
                                <form class="d-inline" action="{{ route('delete.tax') }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" value="{{ $tax->id }}" name="tax_id" />
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <p class="alert alert-sm alert-info text-center">
                بيانات السنة المالية
            </p>
            <form action="{{ route('client.fiscal.settings.update') }}" method="POST">
                @csrf
                @method('PATCH')
                <input type="hidden" name="company_id" value="{{ $company->id }}" />

                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-4 col-xs-12 pull-right">
                            <div class="form-group">
                                <label for="tax_number">السنة المالية</label>
                                <input style="width:100%" readonly type="text" class="form-control" dir="ltr"
                                    value="{{ $fiscal->fiscal_year }}" name="fiscal_year" id="fiscal_year" />
                            </div>
                        </div>
                        <div class="col-lg-4 col-xs-12 pull-right">
                            <div class="form-group">
                                <label for="tax_number"> تبدأ يوم </label>
                                <input style="width:100%" type="date" class="form-control" dir="ltr"
                                    value="{{ $fiscal->start_date }}" name="start_date" id="start_date" />
                            </div>
                        </div>
                        <div class="col-lg-4 col-xs-12 pull-right">
                            <div class="form-group">
                                <label for="tax_number"> تنتهى يوم </label>
                                <input style="width:100%" type="date" class="form-control" dir="ltr"
                                    value="{{ $fiscal->end_date }}" name="end_date" id="end_date" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-xs-12 pull-right">
                    <div class="form-group">
                        <button class="btn btn-md btn-success"><i class="fa fa-check"></i> حفظ
                        </button>
                    </div>
                </div>
                <div class="clearfix"></div>
            </form>
        </div>
    </div>
@endsection
<script src="{{ asset('app-assets/js/jquery.min.js') }}"></script>
<script>
    $(document).ready(function() {

    });
</script>
