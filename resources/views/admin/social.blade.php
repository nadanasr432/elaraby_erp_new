@extends('admin.layouts.app-main')
<style>
</style>
@section('content')
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success alert-dismissable text-center fade show">
            <button class="close" data-dismiss="alert" aria-label="Close">×</button>
            <span>{{ session('success') }}</span>
        </div>
    @endif
    <div class="row">
        <div style="color: #fff !important;font-size: 16px;" class="alert w-100 alert-purple alert-sm text-center">
            معلومات مواقع التواصل الاجتماعى
        </div>

        <div class="col-lg-12 pull-right">
            <form action="{{route('update.social.links')}}" method="POST">
                @csrf
                @method('POST')
                <div class="form-group">
                    <label class="d-block">رقم الواتساب</label>
                    <input required type="text" dir="ltr" class="form-control" value="{{$social->whatsapp_number}}" name="whatsapp_number"/>
                </div>
                <div class="form-group">
                    <label class="d-block">رسالة الواتساب</label>
                    <input required type="text" dir="rtl" class="form-control" value="{{$social->whatsapp_message}}" name="whatsapp_message"/>
                </div>

                <div class="form-group">
                    <label class="d-block">البريد الالكترونى</label>
                    <input required dir="ltr" type="email" class="form-control" value="{{$social->email_link}}" name="email_link"/>
                </div>

                <div class="form-group">
                    <label class="d-block">رابط الصفحة على فيسبوك</label>
                    <input required dir="ltr" type="text" class="form-control" value="{{$social->facebook_link}}" name="facebook_link"/>
                </div>

                <div class="form-group">
                    <button class="btn btn-md btn-block btn-outline-danger" type="submit">
                        <i class="fa fa-check"></i>
                        حفظ معلومات التواصل الاجتماعى
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
