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
            <p class="alert alert-info alert-sm text-center">
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
                                                class="btn btn-sm btn-info" data-toggle="tooltip" title="تعديل"
                                                data-placement="top"><i class="fa fa-edit"></i></a>
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
