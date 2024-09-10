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
    <!-- row -->
    <div class="row p-0">
        <div class="col-md-12">
            <div class="card">
                <!------HEADER----->
                <div class="card-header border-bottom border-secondary p-1">
                    <div class="d-flex justify-content-between align-items-baseline">
                        <h3 class="pull-right font-weight-bold ml-1">
                            عرض باينات المنتج
                        </h3>
                        <a class="btn btn-danger btn-sm pull-left p-1"
                           onclick="history.back()">
                            عودة للخلف
                        </a>
                    </div>
                </div>

                <!------HEADER----->
                <div class="card-body p-2">

                    <div class="row p-0">
                        <!----store---->
                        <div class="form-group col-lg-3 pr-0" dir="rtl">
                            <label for="store_id">
                                اسم المخزن
                                <span class="text-danger font-weight-bold">*</span>
                            </label>
                            <input type="text" disabled class="form-control" value="{{$product->store->store_name ?? " "}}">
                        </div>
                        <!---------------------->

                        <!----category---->
                        <div class="form-group col-lg-3 pr-0" dir="rtl">
                            <label for="store_id">
                                الفئة الرئيسية
                                <span class="text-danger font-weight-bold">*</span>
                            </label>
                            <input disabled type="text" disabled class="form-control"
                                   value="{{$product->category->category_name}}">
                        </div>
                        <!---------------------->

                        <!----subcategory---->
                        <div class="form-group col-lg-3 pr-0" dir="rtl">
                            <label for="store_id">
                                الباركود
                                <span class="text-danger font-weight-bold">*</span>
                            </label>
                            <input type="text" disabled class="form-control"
                                   value="{{$product->subcategory ? $product->subcategory->sub_category_name : '-'}}">
                        </div>
                        <!---------------------->

                        <!----product_model---->
                        <div class="form-group col-lg-3 pr-0" dir="rtl">
                            <label> موديل المنتج</label>
                            <input disabled type="text" name="product_model" value="{{$product->product_model}}"
                                   placeholder="موديل المنتج" class="form-control"
                                   id='model'>
                        </div>
                        <!---------------------->

                        <!----product_name---->
                        <div class="form-group col-lg-3 pr-0" dir="rtl">
                            <label>
                                اسم المنتج
                                <span class="text-danger font-weight-bold">*</span>
                            </label>
                            <input disabled type="text" name="product_name" id="order_name"
                                   placeholder="اسم المنتج" value="{{$product->product_name}}" class="form-control"
                                   required>
                        </div>
                        <!---------------------->

                        <!----unit_id---->
                        <div class="form-group col-lg-3 pr-0" dir="rtl">
                            <label>
                                وحدة المنتج
                                <span class="text-danger font-weight-bold">*</span>
                            </label>
                            <input disabled type="text" name="product_name" id="order_name"
                                   placeholder="اسم المنتج" value="{{$product->unit ? $product->unit->unit_name : '-'}}"
                                   class="form-control"
                                   required>
                        </div>
                        <!---------------------->

                        <!----code_universal---->
                        <div class="form-group col-lg-3 pr-0" dir="rtl">
                            <label>
                                رقم الباركود
                                <span class="text-danger font-weight-bold">*</span>
                            </label>
                            <input disabled type="text" class="form-control" value="{{ $product->code_universal }}"
                                   dir="ltr"
                                   placeholder="رقم الباركود"
                                   id="order_universal" name="code_universal"/>
                        </div>
                        <!---------------------->

                        <!----first_balance---->
                        <div class="form-group col-lg-3 pr-0" dir="rtl">
                            <label>
                                رصيد المخازن
                                <span class="text-danger font-weight-bold">*</span>
                            </label>
                            <input disabled required placeholder="رصيد المخازن" type="number" name="first_balance"
                                   id="first_balance" value="{{$product->first_balance}}" class="form-control">
                        </div>
                        <!---------------------->

                        <!----purchasing_price--->
                        <div class="form-group col-lg-3 pr-0" dir="rtl">
                            <label>
                                سعر التكلفة
                                <span class="text-danger font-weight-bold">*</span>
                            </label>
                            <input disabled type="number" name="purchasing_price" id='purchasing_price'
                                   class="form-control" value="{{$product->purchasing_price}}"
                                   placeholder="سعر التكلفة">
                        </div>
                        <!---------------------->

                        <!----wholesale_price--->
                        <div class="form-group col-lg-3 pr-0" dir="rtl">
                            <label>
                                سعر الجملة
                                <span class="text-danger font-weight-bold">*</span>
                            </label>
                            <input disabled type="number" name="wholesale_price" id="wholesale_price"
                                   class="form-control" value="{{$product->wholesale_price}}"
                                   placeholder="سعر الجملة">
                        </div>
                        <!-------------------->

                        <!----sector_price--->
                        <div class="form-group col-lg-3 pr-0" dir="rtl">
                            <label>
                                سعر القطاعى
                                <span class="text-danger font-weight-bold">*</span>
                            </label>
                            <input disabled type="number" name="sector_price" placeholder="سعر القطاعي"
                                   id="sector_price" value="{{$product->sector_price}}"
                                   class="form-control">
                        </div>
                        <!-------------------->

                        <!----min_balance--->
                        <div class="form-group pull-right col-lg-3" dir="rtl">
                            <label>رصيد حد أدنى المخازن</label>
                            <input disabled type="number" name="min_balance" id="min_balance"
                                   class="form-control" value="{{$product->min_balance}}"/>
                        </div>
                        <!-------------------->

                        <!-------color------->
                        <div class="form-group  col-lg-6 d-none" dir="rtl">
                            <label>اختر لون</label>
                            <input disabled style="width: 100%!important;" type="color" placeholder="اختر اللون"
                                   name="color"
                                   id="color"/>
                        </div>
                        <!---------------------->

                        <!----description---->
                        <div class="form-group col-lg-6" dir="rtl">
                            <label>وصف المنتج</label>
                            <textarea disabled name="description" id="description" class="form-control"
                                      placeholder="وصف المنتج. . . ." style="height: 60% !important;"
                                      rows="2">{{$product->description}}</textarea>
                        </div>
                        <!-------------------->

                        @if($product->product_pic)
                            <div class="form-group col-lg-6 pull-right" dir="rtl">
                                <label>صورة المنتج</label>
                                <img id="pic" src="{{ asset($product->product_pic) }}"
                                     style="width: 100px; height:100px;"/>
                            </div>
                    @endif
                    <!---------------------->

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
