@extends('site.layouts.app-main')
<style>
</style>
@section('content')
    <!-- ==========Speaker-Single========== -->
    <section class="about-section mt-5 padding-bottom" style=" padding-top: 200px!important;">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-lg-6 pull-right">
                    <div class="about-thumb w-100">
                        <img class="w-100" src="{{ asset('images/about01.png') }}" alt="about">
                    </div>
                </div>
                <div class="col-lg-6 pull-left">
                    <div class="event-about-content">
                        <div class="section-header-3 left-style m-0">
                            <span class="cate">
                                {{ $system->name }}
                            </span>
                            <h2 class="title">{{ __('about.know-a-lot-about-us') }}</h2>
                            <p>{{ __('about.the-company-was-founded-in-2010') }}</p>
                            <p>{{ __('about.this-program-was-designed-to-meet-the-needs-of-the-user') }} </p>
                            <a href="{{ route('index3') }}" class="custom-button">
                                {{ __('index.get-a-trial-version-now') }}
                            </a>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </section>
    <!-- ==========Speaker-Single========== -->

    <!-- ==========Philosophy-Section========== -->
    <div class="philosophy-section padding-top padding-bottom bg-one bg_img bg_quater_img"
        data-background="{{ asset('images/about-bg.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 offset-lg-3 bg-two">
                    <div class="philosophy-content">
                        <div class="section-header-3 left-style">
                            <span class="cate">{{ __('about.take-a-quick-look-at') }}</span>
                            <h2 class="title">{{ __('about.vision-goal-and-mission') }}</h2>
                            <p class="ml-0">
                                {{ __('about.we-hope-with-hope-to-include-companies-that-need-to-run-their-business') }}
                            </p>
                        </div>
                        <ul class="phisophy-list">
                            <li>
                                <div class="thumb">
                                    <img src="{{ asset('images/icon1.png') }}" alt="philosophy">
                                </div>
                                <h5 class="title">
                                    {{ __('about.honesty-in-dealing-and-respect') }}
                                </h5>
                            </li>
                            <li>
                                <div class="thumb">
                                    <img src="{{ asset('images/icon2.png') }}" alt="philosophy">
                                </div>
                                <h5 class="title">
                                    {{ __('about.clarity-and-transparency') }}
                                </h5>
                            </li>
                            <li>
                                <div class="thumb">
                                    <img src="{{ asset('images/icon3.png') }}" alt="philosophy">
                                </div>
                                <h5 class="title">
                                    {{ __('about.constant-follow-up-with-our-clients') }}
                                </h5>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ==========Philosophy-Section========== -->

    <!-- ==========About-Counter-Section========== -->
    <section class="about-counter-section padding-bottom padding-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="section-header-3 left-style mb-lg-0">
                        <span class="cate">{{ __('about.facts-and-figures') }}</span>
                        <h2 class="title">{{ __('about.numbers-for-us') }}</h2>
                        <p>{{ __('about.the-company-approach-to-dealing-with-companies') }} </p>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="about-counter">
                        <div class="counter-item">
                            <div class="counter-thumb">
                                <img src="{{ asset('images/about-counter01.png') }}" alt="about">
                            </div>
                            <div class="counter-content">
                                <h3 class="title odometer" data-odometer-final="30"></h3>
                                <h3 class="title">100+</h3>
                            </div>
                            <span class="d-block info">{{ __('main.client') }}</span>
                        </div>
                        <div class="counter-item">
                            <div class="counter-thumb">
                                <img src="{{ asset('images/about-counter02.png') }}" alt="about">
                            </div>
                            <div class="counter-content">
                                <h3 class="title odometer" data-odometer-final="30"></h3>
                                <h3 class="title">24/7</h3>
                            </div>
                            <span class="d-block info">
                                {{ __('main.ongoing-technical-support') }}
                            </span>
                        </div>
                        <div class="counter-item">
                            <div class="counter-thumb">
                                <img src="{{ asset('images/about-counter03.png') }}" alt="about">
                            </div>
                            <div class="counter-content">
                                <h3 class="title odometer" data-odometer-final="30"></h3>
                                <h3 class="title">30</h3>
                            </div>
                            <span class="d-block info">
                                {{ __('main.program-sections-screen') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ==========About-Counter-Section========== -->
@endsection
