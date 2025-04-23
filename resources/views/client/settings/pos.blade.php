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
                    <div class="table-responsive">
                        <table class="table table-condensed table-striped table-bordered text-center table-hover"
                               id="example-table">
                            <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">اسم الفرع</th>
                                <th class="text-center"> محتوى شاشة نقطة البيع</th>
                                <th class="text-center">تعديل</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $i=0;
                            @endphp
                            @foreach ($pos_settings as $pos_setting)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $pos_setting->branch ? $pos_setting->branch->branch_name : '' }}</td>
                                    <td>
                                        @if($pos_setting->status == "open")
                                            <i class="fa fa-check"></i>
                                            اقفال اليومية
                                            <br/>
                                        @endif
                                        @if($pos_setting->discount == "1")
                                            <i class="fa fa-check"></i>
                                            الخصم
                                            <br/>
                                        @endif

                                        @if($pos_setting->tax == "1")
                                            <i class="fa fa-check"></i>
                                            ضريبة الطلب
                                            <br/>
                                        @endif
                                        @if($pos_setting->suspension == "1")
                                            <i class="fa fa-check"></i>
                                            تعليق الفاتورة
                                            <br/>
                                        @endif
                                        @if($pos_setting->payment == "1")
                                            <i class="fa fa-check"></i>
                                            تسجيل الدفع
                                            <br/>
                                        @endif
                                        @if($pos_setting->print_save == "1")
                                            <i class="fa fa-check"></i>
                                            حفظ وطباعة الفاتورة
                                            <br/>
                                        @endif
                                        @if($pos_setting->cancel == "1")
                                            <i class="fa fa-check"></i>
                                            الغاء الفاتورة
                                            <br/>
                                        @endif
                                        @if($pos_setting->suspension_tab == "1")
                                            <i class="fa fa-check"></i>
                                            الفاتورة المعلقة سابقا
                                            <br/>
                                        @endif
                                        @if($pos_setting->edit_delete_tab == "1")
                                            <i class="fa fa-check"></i>
                                            تعديل وحذف الفواتير
                                            <br/>
                                        @endif
                                        @if($pos_setting->add_outer_client == "1")
                                            <i class="fa fa-check"></i>
                                            اضافة عميل جديد
                                            <br/>
                                        @endif


                                        @if($pos_setting->add_product == "1")
                                            <i class="fa fa-check"></i>
                                            اضافة منتج جديد
                                            <br/>
                                        @endif
                                        @if($pos_setting->fast_finish == "1")
                                            <i class="fa fa-check"></i>
                                            زر دفع خزنة رئيسية وحفظ الفاتورة
                                            <br/>
                                        @endif
                                        @if($pos_setting->product_image == "1")
                                            <i class="fa fa-check"></i>
                                            صورة المنتج
                                            <br/>
                                        @endif
                                        @if($pos_setting->enableTableNum == "1")
                                            <i class="fa fa-check"></i>
                                            اظهار رقم الطاولة
                                            <br/>
                                        @endif
                                        @if($pos_setting->enableProdInvoice == "1")
                                            <i class="fa fa-check"></i>
                                            اظهار فاتورة الاعداد
                                            <br/>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('pos.settings.edit', $pos_setting->id) }}"
                                           class="btn btn-sm btn-info" data-toggle="tooltip"
                                           title="تعديل" data-placement="top"><i class="fa fa-edit"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
