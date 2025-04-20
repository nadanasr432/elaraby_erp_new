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
    <div class="row">
        <div class="col-12">
            <p class="alert alert-danger alert-sm text-center">
                اعدادات نقطة البيع
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card mg-b-20">
                <div class="card-body">
                    <form action="{{route('pos.settings.update')}}" method="POST">
                        @csrf
                        @method("PATCH")
                        <input type="hidden" name="pos_setting_id" value="{{$pos_setting->id}}" />
                        <div class="col-lg-4 pull-right">
                            <div class="form-group">
                                <label for="">اختر الفرع</label>
                                <select disabled name="branch_id" required class="form-control">
                                    <option value="">اختر الفرع</option>
                                    @foreach($branches as $branch)
                                        <option
                                            @if($pos_setting->branch_id == $branch->id)
                                            selected
                                            @endif
                                            value="{{$branch->id}}">{{$branch->branch_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 pull-right">
                            <div class="form-group">
                                <label for="">اختر محتوى شاشة نقطة البيع لهذا الفرع</label>
                                <select name="pos[]" required
                                        class="form-control selectpicker show-tick"
                                        data-style="btn-danger" multiple data-live-search="true"
                                        data-title="اختر الشاشات">
                                    <option @if($pos_setting->status == "open") selected @endif value="status">اقفال اليومية</option>
                                    <option @if($pos_setting->discount == "1") selected @endif value="discount">الخصم</option>
                                    <option @if($pos_setting->tax == "1") selected @endif value="tax">ضريبة الطلب</option>
                                    <option @if($pos_setting->suspension == "1") selected @endif value="suspension">تعليق الفاتورة</option>
                                    <option @if($pos_setting->payment == "1") selected @endif value="payment">تسجيل الدفع</option>
                                    <option @if($pos_setting->print_save == "1") selected @endif value="print_save">حفظ وطباعة</option>
                                    <option @if($pos_setting->cancel == "1") selected @endif value="cancel">الغاء الفاتورة</option>
                                    <option @if($pos_setting->suspension_tab == "1") selected @endif value="suspension_tab">الفواتير المعلقة سابقا</option>
                                    <option @if($pos_setting->edit_delete_tab == "1") selected @endif value="edit_delete_tab">تعديل وحذف الفاتورة</option>
                                    <option @if($pos_setting->add_outer_client == "1") selected @endif value="add_outer_client">اضافة عميل جديد</option>
                                    <option @if($pos_setting->add_product == "1") selected @endif value="add_product">اضافة منتج جديد</option>
                                    <option @if($pos_setting->fast_finish == "1") selected @endif value="fast_finish">زر دفع خزنة رئيسية وحفظ الفاتورة</option>
                                    <option @if($pos_setting->product_image == "1") selected @endif value="product_image">صورة المنتج</option>
                                    <option @if($pos_setting->enableTableNum == "1") selected @endif value="tableNum">إظهار رقم الطاولة</option>
                                    <option @if($pos_setting->enableProdInvoice == "1") selected @endif value="enableProdInvoice">اظهار فاتورة الاعداد</option>
                                </select>
                            </div>
                        </div>

                        <div class="clearfix"></div>
                        <div class="col-lg-12 text-center">
                            <button class="btn btn-md btn-success"
                                    style="font-size: 15px; margin-top: 25px;" type="submit">
                                <i class="fa fa-check"></i>
                                حفظ التغييرات
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
