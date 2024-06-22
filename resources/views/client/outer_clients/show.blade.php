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
                            <a class="btn pull-left btn-danger btn-sm" href="{{ route('client.outer_clients.index') }}">
                                {{ __('main.back') }} </a>
                            <h5 class="pull-right alert alert-sm alert-info"> عرض بيانات العميل </h5>
                        </div>
                        <br>
                    </div>
                </div>
                <div class="card-body p-3">
                    <div class="col-lg-4 pull-right p-2">
                        <p class="alert alert-secondary alert-sm" dir="rtl">
                            اسم العميل :
                            {{ $outer_client->client_name }}
                        </p>
                    </div>
                    <div class="col-lg-4 pull-right p-2">
                        <p class="alert alert-secondary alert-sm" dir="rtl">
                            فئة التعامل :
                            {{ $outer_client->client_category }}
                        </p>
                    </div>
                    <div class="clearfix"></div>
                    <div class="clearfix"></div>
                    <div class="col-lg-4 pull-right p-2">
                        <p class="alert alert-secondary alert-sm" dir="rtl">
                            مديونية العميل :
                            @if ($outer_client->prev_balance > 0)
                                عليه
                                {{ floatval($outer_client->prev_balance) }}
                            @elseif($outer_client->prev_balance < 0)
                                له
                                {{ floatval(abs($outer_client->prev_balance)) }}
                            @else
                                0
                            @endif
                        </p>
                    </div>
                    <div class="col-lg-4 pull-right p-2">
                        <p class="alert alert-secondary alert-sm" dir="rtl">
                            اسم المحل او الشركة :
                            {{ $outer_client->shop_name }}
                        </p>
                    </div>
                    <div class="col-lg-4 pull-right p-2">
                        <p class="alert alert-secondary alert-sm" dir="rtl">
                            جنسية العميل :
                            {{ $outer_client->client_national }}
                        </p>
                    </div>
                    <div class="clearfix"></div>

                    <div class="col-lg-6 pull-right p-2">
                        <p class="alert alert-secondary alert-sm" dir="rtl">
                            البريد الالكترونى :
                            {{ $outer_client->client_email }}
                        </p>
                    </div>

                    <div class="col-lg-6 pull-right p-2">
                        <p class="alert alert-secondary alert-sm" dir="rtl">
                            الرقم الضريبى :
                            {{ $outer_client->tax_number }}
                        </p>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-lg-6 pull-right p-2">
                        <p class="alert alert-secondary alert-sm" dir="rtl">
                            تليفون العميل :
                            @if (!$outer_client->phones->isEmpty())
                                @foreach ($outer_client->phones as $phone)
                                    <span class="badge badge-success">{{ $phone->client_phone }}</span>
                                @endforeach
                            @endif
                        </p>
                    </div>
                    <div class="col-lg-6 pull-right p-2">
                        <p class="alert alert-secondary alert-sm" dir="rtl">
                            ملاحظات العميل :
                            @if (!$outer_client->notes->isEmpty())
                                @foreach ($outer_client->notes as $note)
                                    <span class="badge badge-danger">{{ $note->client_note }}</span>
                                @endforeach
                            @endif
                        </p>
                    </div>
                    <div class="col-lg-6 pull-right p-2">
                        <p class="alert alert-secondary alert-sm" dir="rtl">
                            عنوان العميل :
                            @if (!$outer_client->addresses->isEmpty())
                                @foreach ($outer_client->addresses as $address)
                                    <span class="badge badge-danger">{{ $address->client_address }}</span>
                                @endforeach
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
