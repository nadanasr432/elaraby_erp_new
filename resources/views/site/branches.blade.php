@extends('site.layouts.app-main')
<style>
    table.table thead th {
        padding: 2px;
        color: #fff !important;
    }

    table.table tbody tr td {
        padding: 2px;
        color: #fff !important;
    }

    .form-control {
        height: 50px !important;
    }

</style>
@section('content')
    <!-- ==========Banner-Section========== -->
    <section class="banner-section">
        <div class="banner-bg bg_img bg-fixed" data-background="{{ asset('assets/images/banner/banner01.jpg') }}"></div>
        <div class="container">
            <div class="banner-content">
                @if (session('error'))
                    <div class="alert alert-danger fade show">
                        {{ session('error') }}
                    </div>
                @endif
                <h1 class="text-center">
                    {{ __('main.create-new-company') }}
                </h1>
                @if (!$branches->isEmpty())
                    <h5 class="text-center" style="width: 80%;
                                                margin: 20px auto!important;">
                        بيانات فروع الشركة
                    </h5>
                    <table dir="rtl" class="text-center table table-bordered">
                        <thead>
                            <th>{{ __('branches.branche-number') }}</th>
                            <th>{{ __('branches.branche-name') }}</th>
                            <th>{{ __('branches.branche-phone') }}</th>
                            <th>{{ __('branches.branche-address') }}</th>
                        </thead>
                        <tbody>
                            @php $i=0; @endphp
                            @foreach ($branches as $branch)
                                <tr>
                                    <td> {{ ++$i }} </td>
                                    <td> {{ $branch->branch_name }} </td>
                                    <td> {{ $branch->branch_phone }} </td>
                                    <td> {{ $branch->branch_address }} </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
                <h5 class="text-center" style="width: 80%; margin: 20px auto!important;">
                    {{ __('sidebar.add-new-branche') }}
                </h5>
                <form action="{{ route('company.branch.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="company_id" value="{{ $_GET['company_id'] }}">
                    <div class="col-lg-4 col-xs-12 pull-right text-right">
                        <div class="form-group">
                            <label for="" class="d-block"> {{ __('branches.branche-name') }}
                                <span class="text-danger pull-left">*</span>
                            </label>
                            <input required type="text" class="form-control text-right" dir="rtl" name="branch_name" />
                        </div>
                    </div>

                    <div class="col-lg-4 col-xs-12 pull-right text-right">
                        <div class="form-group">
                            <label for="" class="d-block"> {{ __('branches.branche-phone') }}
                                <span class="text-danger pull-left">*</span>
                            </label>
                            <input required type="text" class="form-control text-left" dir="ltr" name="branch_phone" />
                        </div>
                    </div>

                    <div class="col-lg-4 col-xs-12 pull-right text-right">
                        <div class="form-group">
                            <label for="" class="d-block"> {{ __('branches.branche-address') }}
                                <span class="text-danger pull-left">*</span>
                            </label>
                            <input required type="text" class="form-control text-right" dir="rtl" name="branch_address" />
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="col-lg-12 col-xs-12 justify-content-center mt-5 text-center">
                        <div class="form-group">
                            <button type="submit" dir="rtl" class="col-lg-4 btn btn-md btn-outline-danger"
                                style="color: #fff !important;">
                                <i class="fa fa-check" style="color: #fff !important;"></i>
                                {{ __('main.save') }}
                            </button>
                            @if (!$branches->isEmpty())
                                <a role="button" href="{{ route('to.stores', $_GET['company_id']) }}"
                                    style="color: #fff !important;height: 50px;"
                                    class="btn btn-md btn-outline-info text-center" dir="rtl">
                                    {{ __('main.next') }}
                                    <i class="fa fa-long-arrow-left" style="color: #fff !important;"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
