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
    <div class="row">
        <div class="col-md-12">
            <div class="card mg-b-20">
                <div class="card-body">
                    <form action="{{ route('screens.settings.update') }}" method="POST">
                        @csrf
                        @method("PATCH")
                        <input type="hidden" name="screen_id" value="{{ $screen->id }}" />
                        <div class="col-lg-4 pull-right">
                            <div class="form-group">
                                <label for="">{{ __('branches.branche-name') }}</label>
                                <select disabled name="branch_id" required class="form-control">
                                    <option value="">{{ __('branches.branche-name') }}</option>
                                    @foreach ($branches as $branch)
                                        <option @if ($screen->branch_id == $branch->id) selected @endif
                                            value="{{ $branch->id }}">{{ $branch->branch_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 pull-right">
                            <div class="form-group">
                                <label for="">{{ __('main.screens') }}</label>
                                <select name="screens[]" required class="form-control selectpicker show-tick"
                                    data-style="btn-danger" multiple data-live-search="true" data-title="اختر الشاشات">
                                    <option @if ($screen->products == '1') selected @endif value="products">شاشة المنتجات
                                    </option>
                                    <option @if ($screen->debt == '1') selected @endif value="debt">شاشة الديون
                                    </option>
                                    <option @if ($screen->banks_safes == '1') selected @endif value="banks_safes">شاشة
                                        البنوك والخزن</option>
                                    <option @if ($screen->sales == '1') selected @endif value="sales">المبيعات
                                    </option>
                                    <option @if ($screen->purchases == '1') selected @endif value="purchases">المشتريات
                                    </option>
                                    <option @if ($screen->finance == '1') selected @endif value="finance">الماليات
                                    </option>
                                    <option @if ($screen->marketing == '1') selected @endif value="marketing">التسويق
                                    </option>
                                    <option @if ($screen->accounting == '1') selected @endif value="accounting">دفتر
                                        اليومية</option>
                                    <option @if ($screen->reports == '1') selected @endif value="reports">التقارير
                                    </option>
                                    <option @if ($screen->settings == '1') selected @endif value="settings">الضبط
                                        والاعدادات</option>
                                </select>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-lg-12 text-center">
                            <button class="btn btn-md btn-success" style="font-size: 15px; margin-top: 25px;" type="submit">
                                <i class="fa fa-check"></i>
                                {{ __('main.save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
