@extends('site.layouts.app-main')
<style>
    span.text-danger {
        font-size: 20px;
        font-weight: bold;
    }

    select.form-control {
        padding: 0;
    }

    .form-control {
        height: 50px !important;
    }

</style>
@section('content')
    <!-- ==========Banner-Section========== -->
    <section class="banner-section" style="padding-top:140px!important; ">
        <div class="banner-bg bg_img bg-fixed" data-background="{{ asset('assets/images/banner/banner01.jpg') }}"></div>
        <div class="container">
            <div class="banner-content">

                <h1 class="text-center mb-5">
                    {{ __('main.create-new-company') }}
                </h1>
                <form action="{{ route('company.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="col-lg-3 col-xs-12 pull-right text-right">
                        <div class="form-group">
                            <label for="" class="d-block"> {{ __('main.company-name') }}
                                <span class="text-danger ">*</span>
                            </label>
                            <input value="{{ old('company_name') }}" required type="text" class="form-control text-right"
                                dir="rtl" name="company_name" placeholder="{{ __('main.Aknana for business incubators and accelerators') }}"/>
                        </div>
                    </div>
                    <div class="col-lg-3 col-xs-12 pull-right text-right">
                        <div class="form-group">
                            <label for="" class="d-block"> {{ __('main.company-phone') }}
                            </label>
                            <input value="{{ old('phone_number') }}" type="text" class="form-control text-left" dir="ltr"
                                placeholder="eg : +966562354761" name="phone_number" />
                        </div>
                    </div>
                    <div class="col-lg-3 col-xs-12 pull-right text-right">
                        <div class="form-group">
                            <label for="" class="d-block"> {{ __('main.country') }}
                            </label>
                               <select name="country" class="form-control selectpicker show-tick" data-live-search="true"data-style="btn-info" title="{{ __('main.choose-country') }}" id="">
                            <option value="موريتانيا">  {{ __('main.Mauritania') }}</option>
                            <option value="مصر"> {{ __('main.Egypt') }}</option>
                            <option value="سوريا"> {{ __('main.syria') }}</option>
                            <option value="ليبيا"> {{ __('main.Libya') }}</option>
                            <option value="السودان"> {{ __('main.Sudan') }}</option>
                            <option value="تونس"> {{ __('main.Tunisia') }}</option>
                            <option value="الجزائر"> {{ __('main.Algeria') }}</option>
                            <option value="المغرب"> {{ __('main.Morocco') }}</option>
                            <option value="الصومال"> {{ __('main.Somalia') }}</option>
                            <option value="جيبوتى"> {{ __('main.Djibouti') }}</option>
                            <option value="جزر القمر"> {{ __('main.Comoros') }} </option>
                            <option value="فلسطين"> {{ __('main.Palestine') }}</option>
                            <option value="لبنان">  {{ __('main.Lebanon') }}</option>
                            <option value="الاردن"> {{ __('main.Jordan') }}</option>
                            <option value="العراق"> {{ __('main.Iraq') }}</option>
                            <option value="الكويت"> {{ __('main.Kuwait') }}</option>
                            <option value="قطر">  {{ __('main.Qatar') }}</option>
                            <option value="البحرين"> {{ __('main.Bahrain') }}</option>
                            <option value="الامارات"> {{ __('main.United Arab Emirates') }}</option>
                            <option selected value="السعودية"> {{ __('main.Saudi Arabia') }}</option>
                            <option value="سلطنة عمان"> {{ __('main.Oman') }}</option>
                            <option value="اليمن"> {{ __('main.Yemen') }}</option>
                        </select>
                        </div>
                    </div>
                    <div class="col-lg-3 col-xs-12 pull-right text-right">
                        <div class="form-group">
                            <label for="" class="d-block"> {{ __('main.currency') }}
                            </label>
                           <select name="currency" class="form-control selectpicker show-tick" data-live-search="true"
                            data-style="btn-danger" title="اختر العملة" id="">
                            <option value="أوقية موريتانية">  {{ __('main.Mauritanian Ouguiya') }}</option>
                            <option value="جنيه مصري"> {{ __('main.Egyptian Pound') }}</option>
                            <option value="ليرة سورية">{{ __('main.Syrian Pound') }}</option>
                            <option value="دينار ليبي"> {{ __('main.Libyan Dinar') }}</option>
                            <option value="جنيه سوداني"> {{ __('main.Sudanese Pound') }}</option>
                            <option value="دينار تونسي">  {{ __('main.Tunisian Dinar') }}</option>
                            <option value="دينار جزائري">  {{ __('main.Algerian Dinar') }}</option>
                            <option value="درهم مغربي">  {{ __('main.Moroccan Dirham') }}</option>
                            <option value="شلن صومالي"> {{ __('main.Somali Shilling') }}</option>
                            <option value="فرنك جيبوتي"> {{ __('main.Djiboutian Franc') }}</option>
                            <option value="فرنك قمري"> {{ __('main.Comorian Franc') }}</option>
                            <option value="شيكل إسرائيلي">  {{ __('main.Palestine') }}</option>
                            <option value="ليرة لبنانية"> {{ __('main.Lebanese Pound') }}</option>
                            <option value="دينار أردني">  {{ __('main.Jordanian Dinar') }}</option>
                            <option value="دينار عراقي"> {{ __('main.Iraqi Dinar') }}</option>
                            <option value="دينار كويتي">{{ __('main.Kuwaiti Dinar') }}</option>
                            <option value="ريال قطري"> {{ __('main.Qatari Riyal') }}</option>
                            <option value="دينار بحريني"> {{ __('main.Bahraini Dinar') }}</option>
                            <option value="درهم إماراتي"> {{ __('main.United Arab Emirates Dirham') }}</option>
                            <option selected value="ريال سعودي"> {{ __('main.Saudi Riyal') }}</option>
                            <option value="ريال عماني">{{ __('main.Omani Rial') }}</option>
                            <option value="دولار امريكى">{{ __('main.US Dollar') }}</option>
                            <option value="جنيه استرلينى"> {{ __('main.British Pound') }}</option>
                            <option value="يورو"> {{ __('main.Euro') }}</option>
                            <option value="دولار كندى">{{ __('main.Canadian Dollar') }}</option>
                        </select>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-lg-12 col-xs-12 text-center justify-content-center text-center mt-3">
                        <button type="submit" dir="rtl" class="col-lg-4 btn btn-md btn-outline-danger"
                            style="color: #fff !important;">
                            <i class="fa fa-check" style="color: #fff !important;"></i>
                            {{ __('main.create-new-company') }}
                        </button>
                        <div class="form-group checkgroup text-center mt-3" dir="rtl">
                            <a href="{{ route('client.login') }}" class="forget-pass text-white">
                                {{ __('main.login-instead') }}
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
