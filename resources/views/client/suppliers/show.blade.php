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
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <div class="col-lg-12 margin-tb">
                            <a class="btn pull-left btn-danger btn-sm" href="{{ route('client.suppliers.index') }}">
                                {{ __('main.back') }} </a>
                            <h5 class="pull-right alert alert-sm alert-info"> عرض بيانات المورد </h5>
                        </div>
                        <br>
                    </div>
                </div>
                <div class="card-body p-3">
                    <div class="col-lg-4 pull-right p-2">
                        <p class="alert alert-secondary alert-sm" dir="rtl">
                            اسم المورد :
                            {{ $supplier->supplier_name }}
                        </p>
                    </div>
                    <div class="col-lg-4 pull-right p-2">
                        <p class="alert alert-secondary alert-sm" dir="rtl">
                            فئة التعامل :
                            {{ $supplier->supplier_category }}
                        </p>
                    </div>
                    <div class="clearfix"></div>

                    <div class="clearfix"></div>
                    <div class="col-lg-4 pull-right p-2">
                        <p class="alert alert-secondary alert-sm" dir="rtl">
                            مستحقات المورد :
                            @if ($supplier->prev_balance > 0)
                                له
                                {{ floatval($supplier->prev_balance) }}
                            @elseif($supplier->prev_balance < 0)
                                عليه
                                {{ floatval(abs($supplier->prev_balance)) }}
                            @else
                                0
                            @endif
                        </p>
                    </div>
                    <div class="col-lg-4 pull-right p-2">
                        <p class="alert alert-secondary alert-sm" dir="rtl">
                            اسم المحل او الشركة :
                            {{ $supplier->shop_name }}
                        </p>
                    </div>
                    <div class="col-lg-4 pull-right p-2">
                        <p class="alert alert-secondary alert-sm" dir="rtl">
                            جنسية المورد :
                            {{ $supplier->supplier_national }}
                        </p>
                    </div>
                    <div class="clearfix"></div>

                    <div class="col-lg-6 pull-right p-2">
                        <p class="alert alert-secondary alert-sm" dir="rtl">
                            البريد الالكترونى :
                            {{ $supplier->supplier_email }}
                        </p>
                    </div>

                    <div class="col-lg-6 pull-right p-2">
                        <p class="alert alert-secondary alert-sm" dir="rtl">
                            الرقم الضريبى :
                            {{ $supplier->tax_number }}
                        </p>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-lg-6 pull-right p-2">
                        <p class="alert alert-secondary alert-sm" dir="rtl">
                            تليفون المورد :
                            @if (!$supplier->phones->isEmpty())
                                @foreach ($supplier->phones as $phone)
                                    <span class="badge badge-success">{{ $phone->supplier_phone }}</span>
                                @endforeach
                            @endif
                        </p>
                    </div>
                    <div class="col-lg-6 pull-right p-2">
                        <p class="alert alert-secondary alert-sm" dir="rtl">
                            عنوان المورد :
                            @if (!$supplier->addresses->isEmpty())
                                @foreach ($supplier->addresses as $address)
                                    <span class="badge badge-success">{{ $address->supplier_address }}</span>
                                @endforeach
                            @endif
                        </p>
                    </div>
                    <div class="col-lg-6 pull-right p-2">
                        <p class="alert alert-secondary alert-sm" dir="rtl">
                            ملاحظات المورد :
                            @if (!$supplier->notes->isEmpty())
                                @foreach ($supplier->notes as $note)
                                    <span class="badge badge-danger">{{ $note->supplier_note }}</span>
                                @endforeach
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
