@extends('client.layouts.app-main')
<style>
    .box {
        width: 100%;
        height: auto;
        border: 1px solid #aaa;
        box-shadow: 0px 0px 8px #888;
        background: rgba(255, 255, 255, 1);
        color: #000;
        border-radius: 10px;
    }

    .box h3 {
        font-size: 18px !important;
    }

    .active {
        background: #000 !important;
        color: #fff;
    }
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
    @if (session('error'))
        <div class="alert alert-danger alert-dismissable text-center fade show">
            <button class="close" data-dismiss="alert" aria-label="Close">×</button>
            <span>{{ session('error') }}</span>
        </div>
    @endif
    <div class="row">
        <div class="w-100 alert text-center alert-sm alert-danger">
            الاشتراكات المتاحة لهذه الباقة
            ( {{$package->package_name}} )
        </div>
        <a href="{{route('go.to.upgrade')}}" class="btn btn-link btn-md">
            العودة الى الصفحة السابقة
        </a>
        <div class="col-lg-12">
            @if(!$types->isEmpty())
                @foreach($types as $type)
                    <div class="col-lg-4 pull-right">
                        <div class="box m-1 p-1">
                            <p>
                                اسم الاشتراك :
                                {{$type->type_name}}
                            </p>
                            <p>
                                سعر الاشتراك 
                                بالريال السعودى
                                 :
                                {{$type->type_price}}
                            </p>
                            <p>
                                مدة الاشتراك بالايام :
                                {{$type->period}}
                            </p>
                            <p>
                                الباقة :
                                {{$type->package->package_name}}
                            </p>
                            <?php
                            $message = "السلام عليكم . أريد الاشتراك فى باقة " . $type->package->package_name . " ( "
                                . $type->type_name . " ) " . " والتى سعرها "
                                . $type->type_price . " 
                                ريال سعودى
                                 .. ومدتها " . $type->period . " يوم ";
                            $message .= " - اسم الشركة : " . $company->company_name . " - اسم مقدم الطلب :  " . $user->name;
                            ?>
                            <a target="_blank" href="https://wa.me/{{$informations->whatsapp_number}}?text={{$message}}"
                               class="btn btn-md btn-block btn-outline-success">
                                <i class="fa fa-whatsapp"></i>
                                اشترك معنا عن طرق الواتساب
                            </a>
                        </div>
                    </div>
                @endforeach
            @else
                <p class="alert alert-sm alert-danger text-center">
                    لا يوجد اشتراكات لهذه الباقة حاليا .. تواصل مع الادارة بشان هذا
                </p>
            @endif
        </div>

    </div>
@endsection
<script src="{{asset('app-assets/js/jquery.min.js')}}"></script>
<script>
    $(document).ready(function () {

    });
</script>
