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
                @if (!$safes->isEmpty())
                    <h5 class="text-center" style="width: 80%; margin: 20px auto!important;">
                        {{ __('main.company-safes-data') }}
                    </h5>
                    <table dir="rtl" class="text-center table table-bordered">
                        <thead>
                            <th>{{ __('safes.safe-number') }}</th>
                            <th>{{ __('safes.safe-name') }}</th>
                            <th> {{ __('safes.in-branch') }}</th>
                        </thead>
                        <tbody>
                            @php $i=0; @endphp
                            @foreach ($safes as $safe)
                                <tr>
                                    <td> {{ ++$i }} </td>
                                    <td> {{ $safe->safe_name }} </td>
                                    <td> {{ $safe->branch->branch_name }} </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
                <h5 class="text-center mt-5 " style="width: 80%; margin: 20px auto!important;">
                    {{ __('sidebar.add-new-store') }}
                </h5>
                <form action="{{ route('company.safe.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="company_id" value="{{ $_GET['company_id'] }}">
                    <div class="col-lg-4 col-xs-12 pull-right text-right">
                        <div class="form-group">
                            <label for="" class="d-block"> {{ __('safes.safe-name') }}
                                <span class="text-danger pull-left">*</span>
                            </label>
                            <input required type="text" class="form-control text-right" dir="rtl" name="safe_name" />
                        </div>
                    </div>

                    <div class="col-lg-4 col-xs-12 pull-right text-right">
                        <div class="form-group">
                            <label for="" class="d-block"> {{ __('safes.in-branch') }}
                                <span class="text-danger pull-left">*</span>
                            </label>
                            <select required name="branch_id" class="form-control">
                                <option value="">{{ __('branches.branche-name') }}</option>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}">{{ $branch->branch_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-lg-12 col-xs-12 text-center justify-content-center mt-5">
                        <div class="form-group">
                            <button type="submit" style="color: #fff !important;"
                                class="col-lg-4 btn btn-md btn-outline-danger text-center" dir="rtl">
                                <i class="fa fa-check" style="color: #fff !important;"></i>
                                {{ __('main.save') }}
                            </button>
                            @if (!$safes->isEmpty())
                                <a role="button" href="{{ route('to.admin.login', $_GET['company_id']) }}"
                                    style="color: #fff !important;height: 50px!important;"
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
