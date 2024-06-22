@extends('site.layouts.app-main')
<style>
</style>
@section('content')
    <!-- ======= Contact Section ======= -->
    <section class="contact-section padding-bottom" style=" padding-top: 200px!important;">
        <div class="contact-container">
            <div class="bg-thumb bg_img" data-background="{{ asset('images/contact.jpg') }}"></div>
            <div class="container">
                <div class="row justify-content-between">
                    <div class="col-md-7 col-lg-6 col-xl-5">
                        @if (session('success'))
                            <div class="clearfix"></div>
                            <div class="alert alert-success text-center" style="border-radius: 0;">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if (count($errors) > 0)
                            <div class="clearfix"></div>
                            <div class="alert alert-danger text-right" dir="rtl">
                                <strong>الاخطاء :</strong>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="section-header-3 left-style text-right">
                            <span class="cate">{{ __('main.contact-us') }}</span>
                            <h4 class="title">{{ __('main.always-be-in-touch-with-us') }}</h4>
                            <p>
                                {{ __('main.we-like-to-talk-about-how-we-can-work-together') }}
                                <br>
                                {{ __('main.send-us-a-message-below-and-we-will-respond-as-soon-as-possible') }}
                            </p>
                        </div>
                        <form action="{{ route('send.message') }}" method="post" class="contact-form"
                            id="contact_form_submit">
                            @csrf
                            @method('POST')
                            <div class="form-group">
                                <label for="name" class="float-right"> {{ __('main.name') }} <span>*</span></label>
                                <input required type="text" name="name" id="name" placeholder="{{ __('main.name') }}" @if(LaravelLocalization::getCurrentLocale() == 'en') style="direction: ltr!important;" @else style="direction: rtl !important;" @endif />
                            </div>
                            <div class="form-group">
                                <label for="phone" class="float-right"> {{ __('main.phone') }} <span>*</span></label>
                                <input required type="number" name="phone" id="phone"
                                    placeholder="{{ __('main.phone') }} " @if(LaravelLocalization::getCurrentLocale() == 'en') style="direction: ltr!important;" @else style="direction: rtl !important;" @endif/>
                            </div>
                            <div class="form-group">
                                <label for="subject" class="float-right"> {{ __('main.subject') }}
                                    <span>*</span></label>
                                <input required type="text" name="subject" id="subject"
                                    placeholder="{{ __('main.subject') }}" @if(LaravelLocalization::getCurrentLocale() == 'en') style="direction: ltr!important;" @else style="direction: rtl !important;" @endif/>
                            </div>
                            <div class="form-group">
                                <label for="message" class="float-right"> {{ __('main.message') }}
                                    <span>*</span></label>
                                <textarea required id="message" name="message" rows="5"
                                    placeholder="{{ __('main.message') }}" @if(LaravelLocalization::getCurrentLocale() == 'en') style="direction: ltr!important;" @else style="direction: rtl !important;" @endif></textarea>
                            </div>
                            <div class="form-group">
                                <input type="submit" value="{{ __('main.send-message') }}">
                            </div>
                        </form>
                    </div>
                    <div class="col-md-5 col-lg-6">
                        <div class="padding-top padding-bottom contact-info">
                            <div class="info-area">
                                <div class="info-item">
                                    <div class="info-thumb">
                                        <img src="{{ asset('images/contact01.png') }}" alt="contact">
                                    </div>
                                    <div class="info-content">
                                        <h6 class="title">{{ __('main.phone') }} / {{ __('main.whatsapp') }}
                                        </h6>
                                        <a style="direction: ltr!important;"
                                            href="Tel:{{ $informations->whatsapp_number }}">{{ $informations->whatsapp_number }}</a>
                                    </div>
                                </div>
                                <div class="info-item">
                                    <div class="info-thumb">
                                        <img src="{{ asset('images/contact02.png') }}" alt="contact">
                                    </div>
                                    <div class="info-content">
                                        <h6 class="title">{{ __('main.email') }}</h6>
                                        <a
                                            href="Mailto:{{ $informations->email_link }}">{{ $informations->email_link }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ==========Contact-Section========== -->
@endsection
