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
    <div class="bg-white p-2 m-1">
        <div class="row">
            <div class="col-12">
                <p class="alert custom-title">
                    {{ __('sidebar.screens-settings') }}
                </p>
            </div>
        </div>
        <div class="row mt-2 mb-2">
            <div class="col-lg-12 text-center">
                <div class="card mg-b-20">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-condensed table-striped table-bordered text-center table-hover"
                                id="example-table">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">{{ __('branches.branche-name') }}</th>
                                        <th class="text-center"> {{ __('main.screens') }}</th>
                                        <th class="text-center">{{ __('main.edit') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 0;
                                    @endphp
                                    @foreach ($screens as $screen)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $screen->branch->branch_name }}</td>
                                            <td>
                                                @if ($screen->products == '1')
                                                    <i class="fa fa-check"></i>
                                                    شاشة المنتجات
                                                    <br />
                                                @endif
                                                @if ($screen->debt == '1')
                                                    <i class="fa fa-check"></i>
                                                    شاشة الديون
                                                    <br />
                                                @endif
    
                                                @if ($screen->banks_safes == '1')
                                                    <i class="fa fa-check"></i>
                                                    شاشة البنوك والخزن
                                                    <br />
                                                @endif
                                                @if ($screen->sales == '1')
                                                    <i class="fa fa-check"></i>
                                                    شاشة المبيعات
                                                    <br />
                                                @endif
                                                @if ($screen->purchases == '1')
                                                    <i class="fa fa-check"></i>
                                                    شاشة المشتريات
                                                    <br />
                                                @endif
                                                @if ($screen->finance == '1')
                                                    <i class="fa fa-check"></i>
                                                    شاشة الماليات
                                                    <br />
                                                @endif
                                                @if ($screen->marketing == '1')
                                                    <i class="fa fa-check"></i>
                                                    شاشة التسويق
                                                    <br />
                                                @endif
                                                @if ($screen->accounting == '1')
                                                    <i class="fa fa-check"></i>
                                                    شاشة دفتر اليومية
                                                    <br />
                                                @endif
                                                @if ($screen->reports == '1')
                                                    <i class="fa fa-check"></i>
                                                    شاشة التقارير
                                                    <br />
                                                @endif
                                                @if ($screen->settings == '1')
                                                    <i class="fa fa-check"></i>
                                                    شاشة الضبط والاعدادات
                                                    <br />
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('screens.settings.edit', $screen->id) }}"
                                                    class="btn " data-toggle="tooltip" title="تعديل"
                                                    data-placement="top"><svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M18.21 4.87258C18.6 4.48258 18.6 3.83258 18.21 3.46258L15.87 1.12258C15.5 0.732578 14.85 0.732578 14.46 1.12258L12.62 2.95258L16.37 6.70258M0.5 15.0826V18.8326H4.25L15.31 7.76258L11.56 4.01258L0.5 15.0826Z" fill="#4AA16A"/>
                                                        </svg>
                                                        </a>
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
    </div>
@endsection
