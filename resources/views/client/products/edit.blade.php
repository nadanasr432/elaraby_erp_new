@extends('client.layouts.app-main')
<style>
    .btn.dropdown-toggle.bs-placeholder {
        height: 40px;
    }

    .bootstrap-select {
        width: 80% !important;
    }

    .form-control {
        height: 45px !important;
        padding: 10px !important;
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
    <div class="row p-0">
        <div class="col-md-12">
            <div class="card">
                <!------HEADER----->
                <div class="card-header border-bottom border-secondary p-1">
                    <div class="d-flex justify-content-between align-items-baseline">
                        <h3 class="pull-right font-weight-bold ml-1">
                            تعديل باينات المنتج
                        </h3>
                        <a class="btn btn-danger btn-sm pull-left p-1" onclick="history.back()">
                            عودة للخلف
                        </a>
                    </div>
                </div>

                <!------HEADER----->
                <div class="card-body p-2">
                    <form class="parsley-style-1" id="selectForm2" name="selectForm2"
                        action="{{ route('client.products.update', $product->id) }}" enctype="multipart/form-data"
                        method="POST">
                        @method('PUT')
                        {{ csrf_field() }}
                        <input type="hidden" name="company_id" value="{{ $company_id }}">
                        <div class="alert alert-danger" id="showErrMsg" style="display:none">

                        </div>

                        <div class="row p-0">
                            <!----store---->
                            <div class="form-group col-lg-3 pr-0" dir="rtl">
                                <label for="store_id">
                                    اسم المخزن
                                    <span class="text-danger font-weight-bold">*</span>
                                </label>
                                <select required name="store_id" id="store" class="form-control">
                                    <option value="">اختر المخزن choose the store</option>
                                    @foreach ($stores as $store)
                                        <option @if ($store->id == $product->store_id) selected @endif
                                            value="{{ $store->id }}">{{ $store->store_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!---------------------->

                            <!----category_id---->
                            <div class="form-group col-lg-3 pr-0" dir="rtl">
                                <label for="store_id">
                                    الفئة الرئيسية
                                    <span class="text-danger font-weight-bold">*</span>
                                </label>
                                <select required name="category_id" id="category" class="form-control">
                                    <option value="">اختر الفئة الرئيسية</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            @if ($category->id == $product->category_id) selected @endif
                                            type="{{ $category->category_type }}">{{ $category->category_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <!---------------------->

                            <!----sub_category---->
                            <div class="form-group col-lg-3 pr-0" dir="rtl">
                                <label for="store_id">
                                    الفئة الفرعية
                                    <span class="text-danger font-weight-bold">*</span>
                                </label>
                                <select name="sub_category_id" id="sub_category" class="form-control">
                                    <option value="">اختر الفئة الفرعية</option>
                                    @foreach ($sub_categories as $category)
                                        <option @if ($category->id == $product->sub_category_id) selected @endif
                                            value="{{ $category->id }}">
                                            {{ $category->sub_category_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <!-------------------->

                            <!----product_model---->
                            <div class="form-group col-lg-3 pr-0" dir="rtl">
                                <label> موديل المنتج</label>
                                <input type="text" name="product_model" value="{{ $product->product_model }}"
                                    placeholder="موديل المنتج" class="form-control" id='model'>
                            </div>
                            <!---------------------->

                            <!----product_name---->
                            <div class="form-group col-lg-3 pr-0" dir="rtl">
                                <label>
                                    اسم المنتج
                                    <span class="text-danger font-weight-bold">*</span>
                                </label>
                                <input type="text" name="product_name" id="order_name" placeholder="اسم المنتج"
                                    value="{{ $product->product_name }}" class="form-control" required>
                            </div>
                            <!---------------------->

                            <!----unit_id---->
                            <div class="form-group col-lg-3 pr-0">
                                <label>
                                    وحدة المنتج
                                    <span class="text-danger font-weight-bold">*</span>
                                </label>
                                <select name="unit_id" class="form-control">
                                    <option value="">اختر وحدة</option>
                                    @foreach ($units as $unit)
                                        <option value="{{ $unit->id }}"
                                            @if ($unit->id == $product->unit_id) selected @endif>{{ $unit->unit_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <!---------------------->

                            <!----code_universal---->
                            <div class="form-group col-lg-3 pr-0" dir="rtl">
                                <label>
                                    رقم الباركود
                                    <span class="text-danger font-weight-bold">*</span>
                                </label>
                                <input type="text" class="form-control" value="{{ $product->code_universal }}"
                                    dir="ltr" placeholder="رقم الباركود" id="order_universal" name="code_universal" />
                            </div>
                            <!---------------------->

                            <!----first_balance---->
                            <div class="form-group col-lg-3 pr-0" dir="rtl">
                                <label>
                                    رصيد المخازن
                                    <span class="text-danger font-weight-bold">*</span>
                                </label>
                                <input type="number" step="0.01" required placeholder="رصيد المخازن"
                                    name="first_balance" id="first_balance" value="{{ $product->first_balance }}"
                                    class="form-control">
                            </div>
                            <!---------------------->

                            <!----purchasing_price--->
                            <div class="form-group col-lg-3 pr-0" dir="rtl">
                                <label>
                                    سعر التكلفة
                                    <span class="text-danger font-weight-bold">*</span>
                                </label>
                                <input type="number" step="0.01" name="purchasing_price" id='purchasing_price'
                                    class="form-control" value="{{ $product->purchasing_price }}"
                                    placeholder="سعر التكلفة">
                            </div>
                            <!---------------------->

                            <!----wholesale_price--->
                            <div class="form-group col-lg-3 pr-0" dir="rtl">
                                <label>
                                    سعر الجملة
                                    <span class="text-danger font-weight-bold">*</span>
                                </label>
                                <input type="number" step="0.01" name="wholesale_price" id="wholesale_price"
                                    class="form-control" value="{{ $product->wholesale_price }}"
                                    placeholder="سعر الجملة">
                            </div>
                            <!-------------------->

                            <!----sector_price--->
                            <div class="form-group col-lg-3 pr-0" dir="rtl">
                                <label>
                                    سعر القطاعى
                                    <span class="text-danger font-weight-bold">*</span>
                                </label>
                                <input type="number" step="0.01" name="sector_price" placeholder="سعر القطاعي"
                                    id="sector_price" value="{{ $product->sector_price }}" class="form-control">
                            </div>
                            <!-------------------->

                            <!----min_balance--->
                            <div class="form-group pull-right col-lg-3" dir="rtl">
                                <label>رصيد حد أدنى المخازن</label>
                                <input type="number" step="0.01" name="min_balance" id="min_balance"
                                    class="form-control" value="{{ $product->min_balance }}" />
                            </div>
                            <!-------------------->

                            <!-------color------->
                            <div class="form-group  col-lg-6 d-none" dir="rtl">
                                <label>اختر لون</label>
                                <input style="width: 100%!important;" type="color" placeholder="اختر اللون"
                                    name="color" id="color" />
                            </div>
                            <!---------------------->

                            <!----description---->
                            <div class="form-group col-lg-6" dir="rtl">
                                <label>وصف المنتج</label>
                                <textarea name="description" id="description" class="form-control" placeholder="وصف المنتج. . . ."
                                    style="height: 60% !important;" rows="2">{{ $product->description }}</textarea>
                            </div>
                            <!-------------------->

                            <div class="form-group col-lg-6 pull-right" dir="rtl">
                                <label>صورة المنتج</label>
                                <input accept=".jpg,.png,.jpeg" type="file" name="product_pic"
                                    oninput="pic.src=window.URL.createObjectURL(this.files[0])" id="file"
                                    class="form-control">
                                <label class="d-block mt-2"> معاينة الصورة</label>
                                <img id="pic" src="{{ asset($product->product_pic) }}"
                                    style="width: 100px; height:100px;" />
                            </div>
                            <!---------------------->

                        </div>
                        <!--ROW END-->


                        <button class="btn btn-md btn-success w-100 font-weight-bold" type="submit">تحديث</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script src="{{ asset('app-assets/js/jquery.min.js') }}"></script>
    <script>
        $("#selectForm2").submit(function(e) {
            e.preventDefault();

            var first_balance = $("#first_balance").val();
            var purchasing_price = $("#purchasing_price").val();
            var wholesale_price = $("#wholesale_price").val();
            var sector_price = $("#sector_price").val();
            var min_balance = $("#min_balance").val();


            if (isNaN(first_balance)) {
                $("#showErrMsg").text("غير مسموح بالاحرف في هذا الحقل ارقام فقط!!");
                $("#showErrMsg").show("slow");
                $("#first_balance").css("border-color", "red");
                $("#first_balance").val("");


                setTimeout(function() {
                    $("#showErrMsg").hide("slow");
                }, 4000);

                return false;
            } else {
                $("#first_balance").css("border-color", "#CACFE7");
            }


            if (isNaN(purchasing_price)) {
                $("#showErrMsg").text("غير مسموح بالاحرف في هذا الحقل ارقام فقط!!");
                $("#showErrMsg").show("slow");
                $("#purchasing_price").css("border-color", "red");
                $("#purchasing_price").val("");


                setTimeout(function() {
                    $("#showErrMsg").hide("slow");
                }, 4000);

                return false;
            } else {
                $("#purchasing_price").css("border-color", "#CACFE7");
            }

            if (isNaN(wholesale_price)) {
                $("#showErrMsg").text("غير مسموح بالاحرف في هذا الحقل ارقام فقط!!");
                $("#showErrMsg").show("slow");
                $("#wholesale_price").css("border-color", "red");
                $("#wholesale_price").val("");


                setTimeout(function() {
                    $("#showErrMsg").hide("slow");
                }, 4000);

                return false;
            } else {
                $("#wholesale_price").css("border-color", "#CACFE7");
            }

            if (isNaN(sector_price)) {
                $("#showErrMsg").text("غير مسموح بالاحرف في هذا الحقل ارقام فقط!!");
                $("#showErrMsg").show("slow");
                $("#sector_price").css("border-color", "red");
                $("#sector_price").val("");


                setTimeout(function() {
                    $("#showErrMsg").hide("slow");
                }, 4000);

                return false;
            } else {
                $("#sector_price").css("border-color", "#CACFE7");
            }

            if (isNaN(min_balance)) {
                $("#showErrMsg").text("غير مسموح بالاحرف في هذا الحقل ارقام فقط!!");
                $("#showErrMsg").show("slow");
                $("#min_balance").css("border-color", "red");
                $("#min_balance").val("");


                setTimeout(function() {
                    $("#showErrMsg").hide("slow");
                }, 4000);

                return false;
            } else {
                $("#min_balance").css("border-color", "#CACFE7");
            }

            $(this).submit();

        }); //end...


        $(window).on('load', function() {
            var category_name = $('#category').val();
            var category_type = $('#category').children("option:selected").attr('type');
            if (category_type == 'خدمية') {
                $('#first_balance').val("").attr('readonly', true);
                $('#order_universal').val("").attr('readonly', true);
                $('#min_balance').attr('readonly', true);
                $('#store').attr('disabled', true);
            } else {
                $('#first_balance').attr('readonly', false);
                $('#model').attr('readonly', false);
                $('#order_universal').attr('readonly', false);
                $('#min_balance').attr('readonly', false);
                $('#store').attr('disabled', false);
            }
        });
        $('#category').on('change', function() {
            var category_name = $(this).val();
            var category_type = $(this).children("option:selected").attr('type');
            if (category_type == 'خدمية') {
                $('#first_balance').val("").attr('readonly', true);
                $('#order_universal').val("").attr('readonly', true);
                $('#min_balance').attr('readonly', true);
                $('#store').attr('disabled', true);
            } else {
                $('#first_balance').attr('readonly', false);
                $('#model').attr('readonly', false);
                $('#order_universal').attr('readonly', false);
                $('#min_balance').attr('readonly', false);
                $('#store').attr('disabled', false);
            }
        });
    </script>
@endsection
