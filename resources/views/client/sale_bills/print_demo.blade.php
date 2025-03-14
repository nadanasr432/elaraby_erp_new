@extends('client.layouts.app-main')
<style>
    .form-control {
        height: 45px !important;
        padding: 10px !important;
        border-radius: 0 !important;
    }

</style>
@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissable fade show text-center">
            <button class="close" data-dismiss="alert" aria-label="Close">×</button>
            {{ session('success') }}
        </div>
    @endif
    @if (count($errors) > 0)
        <div class="alert alert-dark no-print">
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
    <h1 class="alert alert-lg alert-info text-center">
        نموذج طباعة الفاتورة
        ( مسميات حقول طباعة فاتورة المبيعات )
    </h1>
    <p dir="rtl" class="text-danger mt-2 mb-3">
        <span>*** </span>
        أنت الان على وشك التعديل فى مسميات حقول طباعة فاتورة المبيعات
    </p>
    <form action="{{route('print.demo.update')}}" method="POST">
        @csrf
        @method('POST')
        <div class="col-lg-3 pull-right">
            <div class="form-group">
                <label class="d-block">
                    حقل تاريخ الفاتورة
                </label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">
                            <img src="{{asset('images/lang/ar.png')}}" alt="">
                        </span>
                    </div>
                    <input type="text" class="form-control"  aria-label="Username"
                           @if(isset($print_demo)) value="{{$print_demo->bill_date_ar}}" @endif dir="rtl"
                           aria-describedby="basic-addon1" name="bill_date_ar">
                </div>
                <div class="input-group">
                    <input type="text" class="form-control"  aria-label="Username"
                           @if(isset($print_demo)) value="{{$print_demo->bill_date_en}}" @endif dir="ltr"
                           aria-describedby="basic-addon1" name="bill_date_en">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">
                            <img src="{{asset('images/lang/en.png')}}" alt="">
                        </span>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-lg-3 pull-right">
            <div class="form-group">
                <label class="d-block">
                    حقل الرقم الضريبى
                </label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">
                            <img src="{{asset('images/lang/ar.png')}}" alt="">
                        </span>
                    </div>
                    <input type="text" class="form-control"  aria-label="Username"
                           @if(isset($print_demo)) value="{{$print_demo->tax_number_ar}}" @endif dir="rtl"
                           aria-describedby="basic-addon1" name="tax_number_ar">
                </div>
                <div class="input-group">
                    <input type="text" class="form-control"  aria-label="Username"
                           @if(isset($print_demo)) value="{{$print_demo->tax_number_en}}" @endif dir="ltr"
                           aria-describedby="basic-addon1" name="tax_number_en">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">
                            <img src="{{asset('images/lang/en.png')}}" alt="">
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 pull-right">
            <div class="form-group">
                <label class="d-block">
                    حقل رقم الفاتورة
                </label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">
                            <img src="{{asset('images/lang/ar.png')}}" alt="">
                        </span>
                    </div>
                    <input type="text" class="form-control"  aria-label="Username"
                           @if(isset($print_demo)) value="{{$print_demo->bill_id_ar}}" @endif dir="rtl"
                           aria-describedby="basic-addon1" name="bill_id_ar">
                </div>
                <div class="input-group">
                    <input type="text" class="form-control"  aria-label="Username"
                           @if(isset($print_demo)) value="{{$print_demo->bill_id_en}}" @endif dir="ltr"
                           aria-describedby="basic-addon1" name="bill_id_en">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">
                            <img src="{{asset('images/lang/en.png')}}" alt="">
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 pull-right">
            <div class="form-group">
                <label class="d-block">
                    حقل السجل التجارى
                </label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">
                            <img src="{{asset('images/lang/ar.png')}}" alt="">
                        </span>
                    </div>
                    <input type="text" class="form-control"  aria-label="Username"
                           @if(isset($print_demo)) value="{{$print_demo->commercial_number_ar}}" @endif dir="rtl"
                           aria-describedby="basic-addon1" name="commercial_number_ar">
                </div>
                <div class="input-group">
                    <input type="text" class="form-control"  aria-label="Username"
                           @if(isset($print_demo)) value="{{$print_demo->commercial_number_en}}" @endif dir="ltr"
                           aria-describedby="basic-addon1" name="commercial_number_en">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">
                            <img src="{{asset('images/lang/en.png')}}" alt="">
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-lg-3 pull-right">
            <div class="form-group">
                <label class="d-block">
                    حقل السجل المدنى
                </label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">
                            <img src="{{asset('images/lang/ar.png')}}" alt="">
                        </span>
                    </div>
                    <input type="text" class="form-control"  aria-label="Username"
                           @if(isset($print_demo)) value="{{$print_demo->civil_number_ar}}" @endif dir="rtl"
                           aria-describedby="basic-addon1" name="civil_number_ar">
                </div>
                <div class="input-group">
                    <input type="text" class="form-control"  aria-label="Username"
                           @if(isset($print_demo)) value="{{$print_demo->civil_number_en}}" @endif dir="ltr"
                           aria-describedby="basic-addon1" name="civil_number_en">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">
                            <img src="{{asset('images/lang/en.png')}}" alt="">
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 pull-right">
            <div class="form-group">
                <label class="d-block">
                    حقل اسم المؤسسة
                </label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">
                            <img src="{{asset('images/lang/ar.png')}}" alt="">
                        </span>
                    </div>
                    <input type="text" class="form-control"  aria-label="Username"
                           @if(isset($print_demo)) value="{{$print_demo->company_name_ar}}" @endif dir="rtl"
                           aria-describedby="basic-addon1" name="company_name_ar">
                </div>
                <div class="input-group">
                    <input type="text" class="form-control"  aria-label="Username"
                           @if(isset($print_demo)) value="{{$print_demo->company_name_en}}" @endif dir="ltr"
                           aria-describedby="basic-addon1" name="company_name_en">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">
                            <img src="{{asset('images/lang/en.png')}}" alt="">
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 pull-right">
            <div class="form-group">
                <label class="d-block">
                    حقل عنوان المؤسسة
                </label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">
                            <img src="{{asset('images/lang/ar.png')}}" alt="">
                        </span>
                    </div>
                    <input type="text" class="form-control"  aria-label="Username"
                           @if(isset($print_demo)) value="{{$print_demo->company_address_ar}}" @endif dir="rtl"
                           aria-describedby="basic-addon1" name="company_address_ar">
                </div>
                <div class="input-group">
                    <input type="text" class="form-control"  aria-label="Username"
                           @if(isset($print_demo)) value="{{$print_demo->company_address_en}}" @endif dir="ltr"
                           aria-describedby="basic-addon1" name="company_address_en">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">
                            <img src="{{asset('images/lang/en.png')}}" alt="">
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 pull-right">
            <div class="form-group">
                <label class="d-block">
                    حقل رقم جوال المؤسسة
                </label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">
                            <img src="{{asset('images/lang/ar.png')}}" alt="">
                        </span>
                    </div>
                    <input type="text" class="form-control"  aria-label="Username"
                           @if(isset($print_demo)) value="{{$print_demo->company_phone_number_ar}}" @endif dir="rtl"
                           aria-describedby="basic-addon1" name="company_phone_number_ar">
                </div>
                <div class="input-group">
                    <input type="text" class="form-control"  aria-label="Username"
                           @if(isset($print_demo)) value="{{$print_demo->company_phone_number_en}}" @endif dir="ltr"
                           aria-describedby="basic-addon1" name="company_phone_number_en">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">
                            <img src="{{asset('images/lang/en.png')}}" alt="">
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-lg-3 pull-right">
            <div class="form-group">
                <label class="d-block">
                    حقل اسم مقدم الخدمة
                </label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">
                            <img src="{{asset('images/lang/ar.png')}}" alt="">
                        </span>
                    </div>
                    <input type="text" class="form-control"  aria-label="Username"
                           @if(isset($print_demo)) value="{{$print_demo->client_name_ar}}" @endif dir="rtl"
                           aria-describedby="basic-addon1" name="client_name_ar">
                </div>
                <div class="input-group">
                    <input type="text" class="form-control"  aria-label="Username"
                           @if(isset($print_demo)) value="{{$print_demo->client_name_en}}" @endif dir="ltr"
                           aria-describedby="basic-addon1" name="client_name_en">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">
                            <img src="{{asset('images/lang/en.png')}}" alt="">
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 pull-right">
            <div class="form-group">
                <label class="d-block">
                    حقل اسم العميل
                </label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">
                            <img src="{{asset('images/lang/ar.png')}}" alt="">
                        </span>
                    </div>
                    <input type="text" class="form-control"  aria-label="Username"
                           @if(isset($print_demo)) value="{{$print_demo->outer_client_name_ar}}" @endif dir="rtl"
                           aria-describedby="basic-addon1" name="outer_client_name_ar">
                </div>
                <div class="input-group">
                    <input type="text" class="form-control"  aria-label="Username"
                           @if(isset($print_demo)) value="{{$print_demo->outer_client_name_en}}" @endif dir="ltr"
                           aria-describedby="basic-addon1" name="outer_client_name_en">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">
                            <img src="{{asset('images/lang/en.png')}}" alt="">
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 pull-right">
            <div class="form-group">
                <label class="d-block">
                    حقل عنوان العميل
                </label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">
                            <img src="{{asset('images/lang/ar.png')}}" alt="">
                        </span>
                    </div>
                    <input type="text" class="form-control"  aria-label="Username"
                           @if(isset($print_demo)) value="{{$print_demo->outer_client_address_ar}}" @endif dir="rtl"
                           aria-describedby="basic-addon1" name="outer_client_address_ar">
                </div>
                <div class="input-group">
                    <input type="text" class="form-control"  aria-label="Username"
                           @if(isset($print_demo)) value="{{$print_demo->outer_client_address_en}}" @endif dir="ltr"
                           aria-describedby="basic-addon1" name="outer_client_address_en">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">
                            <img src="{{asset('images/lang/en.png')}}" alt="">
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 pull-right">
            <div class="form-group">
                <label class="d-block">
                    حقل رقم جوال العميل
                </label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">
                            <img src="{{asset('images/lang/ar.png')}}" alt="">
                        </span>
                    </div>
                    <input type="text" class="form-control"  aria-label="Username"
                           @if(isset($print_demo)) value="{{$print_demo->outer_client_phone_ar}}" @endif dir="rtl"
                           aria-describedby="basic-addon1" name="outer_client_phone_ar">
                </div>
                <div class="input-group">
                    <input type="text" class="form-control"  aria-label="Username"
                           @if(isset($print_demo)) value="{{$print_demo->outer_client_phone_en}}" @endif dir="ltr"
                           aria-describedby="basic-addon1" name="outer_client_phone_en">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">
                            <img src="{{asset('images/lang/en.png')}}" alt="">
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-lg-3 pull-right">
            <div class="form-group">
                <label class="d-block">
                    حقل الرقم الضريبى للعميل
                </label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">
                            <img src="{{asset('images/lang/ar.png')}}" alt="">
                        </span>
                    </div>
                    <input type="text" class="form-control"  aria-label="Username"
                           @if(isset($print_demo)) value="{{$print_demo->outer_client_tax_number_ar}}" @endif dir="rtl"
                           aria-describedby="basic-addon1" name="outer_client_tax_number_ar">
                </div>
                <div class="input-group">
                    <input type="text" class="form-control"  aria-label="Username"
                           @if(isset($print_demo)) value="{{$print_demo->outer_client_tax_number_en}}" @endif dir="ltr"
                           aria-describedby="basic-addon1" name="outer_client_tax_number_en">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">
                            <img src="{{asset('images/lang/en.png')}}" alt="">
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 pull-right">
            <div class="form-group">
                <label class="d-block">
                    حقل كود المنتج
                </label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">
                            <img src="{{asset('images/lang/ar.png')}}" alt="">
                        </span>
                    </div>
                    <input type="text" class="form-control"  aria-label="Username"
                           @if(isset($print_demo)) value="{{$print_demo->product_code_ar}}" @endif dir="rtl"
                           aria-describedby="basic-addon1" name="product_code_ar">
                </div>
                <div class="input-group">
                    <input type="text" class="form-control"  aria-label="Username"
                           @if(isset($print_demo)) value="{{$print_demo->product_code_en}}" @endif dir="ltr"
                           aria-describedby="basic-addon1" name="product_code_en">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">
                            <img src="{{asset('images/lang/en.png')}}" alt="">
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 pull-right">
            <div class="form-group">
                <label class="d-block">
                    حقل موديل المنتج
                </label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">
                            <img src="{{asset('images/lang/ar.png')}}" alt="">
                        </span>
                    </div>
                    <input type="text" class="form-control"  aria-label="Username"
                           @if(isset($print_demo)) value="{{$print_demo->product_model_ar}}" @endif dir="rtl"
                           aria-describedby="basic-addon1" name="product_model_ar">
                </div>
                <div class="input-group">
                    <input type="text" class="form-control"  aria-label="Username"
                           @if(isset($print_demo)) value="{{$print_demo->product_model_en}}" @endif dir="ltr"
                           aria-describedby="basic-addon1" name="product_model_en">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">
                            <img src="{{asset('images/lang/en.png')}}" alt="">
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 pull-right">
            <div class="form-group">
                <label class="d-block">
                    حقل اسم المنتج
                </label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">
                            <img src="{{asset('images/lang/ar.png')}}" alt="">
                        </span>
                    </div>
                    <input type="text" class="form-control"  aria-label="Username"
                           @if(isset($print_demo)) value="{{$print_demo->product_name_ar}}" @endif dir="rtl"
                           aria-describedby="basic-addon1" name="product_name_ar">
                </div>
                <div class="input-group">
                    <input type="text" class="form-control"  aria-label="Username"
                           @if(isset($print_demo)) value="{{$print_demo->product_name_en}}" @endif dir="ltr"
                           aria-describedby="basic-addon1" name="product_name_en">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">
                            <img src="{{asset('images/lang/en.png')}}" alt="">
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-lg-3 pull-right">
            <div class="form-group">
                <label class="d-block">
                    حقل الكمية
                </label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">
                            <img src="{{asset('images/lang/ar.png')}}" alt="">
                        </span>
                    </div>
                    <input type="text" class="form-control"  aria-label="Username"
                           @if(isset($print_demo)) value="{{$print_demo->quantity_ar}}" @endif dir="rtl"
                           aria-describedby="basic-addon1" name="quantity_ar">
                </div>
                <div class="input-group">
                    <input type="text" class="form-control"  aria-label="Username"
                           @if(isset($print_demo)) value="{{$print_demo->quantity_en}}" @endif dir="ltr"
                           aria-describedby="basic-addon1" name="quantity_en">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">
                            <img src="{{asset('images/lang/en.png')}}" alt="">
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 pull-right">
            <div class="form-group">
                <label class="d-block">
                    حقل سعر الوحدة
                </label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">
                            <img src="{{asset('images/lang/ar.png')}}" alt="">
                        </span>
                    </div>
                    <input type="text" class="form-control"  aria-label="Username"
                           @if(isset($print_demo)) value="{{$print_demo->unit_price_ar}}" @endif dir="rtl"
                           aria-describedby="basic-addon1" name="unit_price_ar">
                </div>
                <div class="input-group">
                    <input type="text" class="form-control"  aria-label="Username"
                           @if(isset($print_demo)) value="{{$print_demo->unit_price_en}}" @endif dir="ltr"
                           aria-describedby="basic-addon1" name="unit_price_en">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">
                            <img src="{{asset('images/lang/en.png')}}" alt="">
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 pull-right">
            <div class="form-group">
                <label class="d-block">
                    حقل سعر الكمية
                </label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">
                            <img src="{{asset('images/lang/ar.png')}}" alt="">
                        </span>
                    </div>
                    <input type="text" class="form-control"  aria-label="Username"
                           @if(isset($print_demo)) value="{{$print_demo->quantity_price_ar}}" @endif dir="rtl"
                           aria-describedby="basic-addon1" name="quantity_price_ar">
                </div>
                <div class="input-group">
                    <input type="text" class="form-control"  aria-label="Username"
                           @if(isset($print_demo)) value="{{$print_demo->quantity_price_en}}" @endif dir="ltr"
                           aria-describedby="basic-addon1" name="quantity_price_en">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">
                            <img src="{{asset('images/lang/en.png')}}" alt="">
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-lg-12 mt-3 text-center">
            <button type="submit" class="btn btn-md btn-success">
                <i class="fa fa-save"></i>
                حفظ مسميات الحقول
            </button>
        </div>
    </form>
    <script src="{{ asset('app-assets/js/jquery.min.js') }}"></script>
    <script>

    </script>
@endsection
