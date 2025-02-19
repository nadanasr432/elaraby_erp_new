@extends('client.layouts.app-main')
<style>
.custom-title::before {
    content: "";  
    display: inline-block;
    width: 32px;
    height: 2px;
    background-color: #ec6880;
    align-self: flex-end;
    bottom: 4px;

}
</style>
@section('content')
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>الاخطاء :</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="card mg-b-20">
                <div class="card-body">
                    <div class="col-12  d-flex flex-wrap align-items-center justify-content-between">
                        <h5 style="white-space: nowrap" class="alert alert-sm font-weight-bold m-0 d-flex custom-title align-items-end">
                            {{ __('sidebar.add-new-storage') }}
                        </h5>
                        <a class="btn text-white px-3 py-1"style="background-color: #ec6880" href="{{ route('client.stores.index') }}">
                            {{ __('main.back') }} </a>
                        
                    </div>
                    <div class="clearfix"></div>
                    <br>

                    <form class="parsley-style-1" id="selectForm2" name="selectForm2"
                        action="{{ route('client.stores.store', 'test') }}" enctype="multipart/form-data" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="company_id" value="{{ $company_id }}">
                        <h5 class="col-lg-12 d-block mb-2">{{ __('main.main-information') }}</h5>
                        <hr>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label> {{ __('stores.store-name') }} <span class="text-danger">*</span></label>
                                <input dir="rtl" required class="form-control" name="store_name" type="text">
                            </div>

                            <div class="col-md-6">
                                <label> {{ __('stores.inside-a-branch') }} <span class="text-danger">*</span></label>
                               <div class="d-flex w-100">
                                    <select required name="branch_id" class="form-control">
                                    <option value="">Choose a branch</option>
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}">{{ $branch->branch_name }}</option>
                                    @endforeach
                                    </select>
                                    <a target="_blank" href="{{ route('client.branches.create') }}" role="button"
                                        class="btn btn-sm btn-warning open_popup d-flex align-items-center">
                                        <i class="fa fa-plus"></i>
                                    </a>
                               </div>
                            </div>

                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center d-flex justify-content-start">
                            <button style="background-color: #222751 !important; box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);" class="btn btn-info pd-x-20 px-5 py-1" type="submit">{{ __('main.add') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
<script src="{{ asset('app-assets/js/jquery.min.js') }}"></script>
<script>
    $(document).ready(function() {

    });
</script>
