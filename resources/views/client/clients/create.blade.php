@extends('client.layouts.app-main')
<style>

</style>
@section('content')
    <!-- main-content closed -->
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Errors :</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- row opened -->
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="col-12">
                        <a class="btn btn-primary btn-sm pull-left"
                            href="{{ route('client.clients.index') }}">{{ __('main.back') }}</a>
                        <h5 style="min-width: 300px;" class="pull-right alert alert-sm alert-success">
                            {{ __('sidebar.add-new-user') }}
                        </h5>
                    </div>
                </div>
                <div class="card-body p-1 m-1">
                    <form action="{{ route('client.clients.store') }}" method="post">
                        {{ csrf_field() }}
                        <div class="row m-t-3 mb-3">
                            <div class="col-md-4">
                                <label> {{ __('main.username') }} <span class="text-danger">*</span></label>
                                <input class="form-control mg-b-20" name="name" required type="text">
                            </div>
                            <div class="parsley-input col-md-4 mg-t-20 mg-md-t-0" id="lnWrapper">
                                <label> {{ __('main.email') }} : <span class="text-danger">*</span></label>
                                <input class="form-control  mg-b-20" style="text-align: left;direction:ltr;"
                                    data-parsley-class-handler="#lnWrapper" name="email" required="" type="email">
                            </div>
                            <div class="parsley-input col-md-4 mg-t-20 mg-md-t-0" id="lnWrapper">
                                <label class="form-label"> {{ __('main.status') }} </label>
                                <select name="Status" id="select-beast" class="form-control">
                                    <option selected value="active">{{ __('main.active') }}</option>
                                    <option value="blocked">{{ __('main.deactive') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="row m-t-3 mb-3">
                            <div class="parsley-input col-md-3 mg-t-20 mg-md-t-0" id="lnWrapper">
                                <label> {{ __('main.password') }} : <span class="text-danger">*</span></label>
                                <input class="form-control  mg-b-20" style="text-align: left;direction:ltr;"
                                    data-parsley-class-handler="#lnWrapper" name="password" required="" type="password">
                            </div>
                            <div class="parsley-input col-md-3 mg-t-20 mg-md-t-0" id="lnWrapper">
                                <label> {{ __('main.confirm-password') }} : <span class="text-danger">*</span></label>
                                <input class="form-control  mg-b-20" style="text-align: left;direction:ltr;"
                                    data-parsley-class-handler="#lnWrapper" name="confirm-password" required=""
                                    type="password">
                            </div>
                            <div class="parsley-input col-md-3 mg-t-20 mg-md-t-0" id="lnWrapper">
                                <label class="form-label"> {{ __('main.permission') }} </label>
                                <select id="role_name" data-live-search="true" data-style="btn-info"
                                    title="{{ __('main.permission') }}" class="form-control selectpicker" required
                                    name="role_name[]">
                                    @foreach ($roles as $role)
                                        <option value="{{ $role }}">{{ $role }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mg-t-20 mg-md-t-0 branch" style="display: none;">
                                <label class="form-label"> {{ __('branches.branche-name') }} </label>
                                <select id="branch_id" data-live-search="true" data-style="btn-danger" title="اختر الفرع"
                                    class="form-control selectpicker show-tick" name="branch_id">
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}">{{ $branch->branch_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button class="btn btn-info pd-x-20" type="submit">{{ __('main.save') }}</button>
                        </div>
                    </form>
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
<script src="{{ asset('app-assets/js/jquery.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#role_name').on('change', function() {
            var role_name = $(this).val();
            $('#branch_id').val("");
            $('#branch_id').selectpicker('refresh');
            if (role_name != "مدير النظام") {
                $('.branch').show();
            } else {
                $('.branch').hide();
            }
        });
    });
</script>
