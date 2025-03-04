@extends('client.layouts.app-main')
<style>
    .btn.dropdown-toggle.bs-placeholder {
        height: 40px;
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
                    <div class="col-12 d-flex flex-wrap justify-content-between ">
                        <h5 class=" alert custom-title">
                            {{ __('sidebar.add-new-supplier') }} </h5>
                        <a class="btn btnn px-3 py-1 text-white" style="background-color: #36c7d6" href="{{ route('client.suppliers.index') }}">
                            {{ __('main.back') }}
                        </a>
                        
                    </div>
                    <div class="clearfix"></div>
                    <br>

                    <form class="parsley-style-1" id="selectForm2" name="selectForm2"
                        action="{{ route('client.suppliers.store', 'test') }}" enctype="multipart/form-data"
                        method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="company_id" value="{{ $company_id }}">
                        <h5 class="col-lg-12 d-block mb-2">{{ __('main.main-information') }}</h5>
                        <hr>
                        <div class="row ">

                            <div class="form-group  col-lg-6  " dir="rtl">
                                <label for="order">{{ __('suppliers.supplier-name') }}</label>
                                <input type="text" name="supplier_name" class="form-control" required>
                            </div>

                            <div class="form-group  col-lg-6" dir="ltr">
                                <label style="display: block" for="note"> {{ __('suppliers.supplier-notes') }} </label>
                                <div class="d-flex align-items-center gap-2 ">
                                    <button type="button" id="add_note" class="btn btn-warning text-center py-1">
                                        <i class="fa fa-plus" style="font-size: 17px; font-weight: bold;"></i>
                                    </button>
                                    <input type="text" name="notes[]" class="form-control w-100"
                                    style="width:90%; display: inline; float: right;" dir="rtl">
                                    
                                    <div class="clearfix"></div>
                                    <div class="dom2"></div>
                                </div>
                                
                            </div>

                        </div>
                        <div class="row">

                            <div class="form-group   col-lg-6" dir="rtl">
                                <label for="prev_balance">{{ __('clients.client-indebtedness') }}</label>
                                <input style="margin-right:5px;margin-left:5px;" checked type="radio" value="for"
                                    name="balance" /> {{ __('main.for') }}
                                <input style="margin-right:5px;margin-left:5px;" type="radio" value="on" name="balance" />
                                {{ __('main.on') }}
                                <input type="number" step="any" required value="0" name="prev_balance" class="form-control"
                                    dir="ltr" />
                            </div>
                            <div class="form-group  col-lg-6" dir="ltr">
                                <label style="display: block" for="phone"> {{ __('suppliers.phone-with-code') }} </label>
                                <div class="d-flex align-items-center gap-2 justify-content-between">
                                    <button type="button" id="add_phone" class="btn btn-warning text-center py-1">
                                        <i class="fa fa-plus" style="font-size: 17px; font-weight: bold;"></i>
                                    </button>
                                    <input type="text" name="phones[]" class="form-control w-100"
                                    style="width:80%; display: inline; float: right;" dir="ltr">
                                
                                <div class="clearfix"></div>
                                <div class="dom1"></div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group  col-lg-6" dir="ltr">
                                <label style="display: block"
                                    for="address">{{ __('suppliers.supplier-address') }}</label>
                                <div class="d-flex align-items-center gap-2 justify-content-between">
                                    <button type="button" id="add_address" class="btn btn-warning text-center py-1">
                                        <i class="fa fa-plus" style="font-size: 17px; font-weight: bold;"></i>
                                    </button>
                                    <input type="text" name="addresses[]" class="form-control"
                                    style="width:90%; display: inline; float: right;" dir="rtl">
                                
                                <div class="clearfix"></div>
                                <div class="dom3"></div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <a style="color: #36c7d6" href="javascript:;" class="btn open_extras mb-2" >
                            <i class="fa fa-plus"></i>
                            {{ __('suppliers.additional-options') }}
                        </a>
                        <div class="clearfix"></div>
                        <div class="extras" style="display: none">
                            <div class="row">
                                <div class="form-group  col-lg-4  pull-right">
                                    <label for="supplier_category">{{ __('suppliers.dealing-type') }}</label>
                                    <select name="supplier_category" class="form-control" required>
                                        <option value="">{{ __('suppliers.choose-type') }}</option>
                                        <option selected value="جملة">جملة</option>
                                        <option value="قطاعى">قطاعى</option>
                                    </select>
                                </div>
                                <div class="form-group col-lg-4 ">
                                    <label for="supplier_email">{{ __('main.email-address') }}</label>
                                    <input type="email" name="supplier_email" dir="ltr" class="form-control">
                                </div>
                                <div class="clearfix"></div>
                                <div class="form-group  col-lg-4">
                                    <label for="shop_name">{{ __('suppliers.supplier-company-name') }}</label>
                                    <input type="text" name="shop_name" class="form-control" dir="rtl">
                                </div>
                                <div class="form-group   col-lg-4">
                                    <label for="supplier_national">{{ __('suppliers.supplier-nationality') }}</label>
                                    <select name="supplier_national" class="form-control">
                                        <option value="">{{ __('main.choose-country') }}</option>
                                        @foreach ($timezones as $timezone)
                                            <option @if ($timezone->country_name == 'السعودية') selected @endif
                                                value="{{ $timezone->country_name }}">{{ $timezone->country_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group   col-lg-4">
                                    <label for="tax_number">{{ __('main.tax-number') }}</label>
                                    <input type="text" name="tax_number" class="form-control" dir="ltr" />
                                </div>
                                <div class="clearfix"></div>

                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-end ">
                            <button class="btn btnn btn-warning px-5 py-1" type="submit">{{ __('main.add') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('app-assets/js/jquery.min.js') }}"></script>
    <script>
        $('#add_phone').on("click", function() {
            $('<div><input autofocus type="text" name="phones[]" class="form-control" dir="ltr" style="margin:10px 0; display:inline;float:right;width:80%"  />' +
                '<button type="button" class="btn btn-danger btn-sm delete_phone" style="width:15%;height: 30px;display: inline; float: left;padding: 5px; margin-top: 10px"><i style="font-size: 18px;" class="fa fa-trash"></i></button>' +
                '<div class="clearfix"></div></div>').insertBefore('.dom1');
            $('.delete_phone').on('click', function() {
                $(this).parent().remove();
            });
        });
        $('#add_address').on("click", function() {
            $('<div><input autofocus type="text" name="addresses[]" class="form-control" dir="rtl" style="margin:10px 0; display:inline;float:right;width:90%"  />' +
                '<button type="button" class="btn btn-danger btn-sm delete_address" style="width:7%;height: 30px;display: inline; float: left;padding: 5px; margin-top: 10px"><i style="font-size: 18px;" class="fa fa-trash"></i></button>' +
                '<div class="clearfix"></div></div>').insertBefore('.dom3');
            $('.delete_address').on('click', function() {
                $(this).parent().remove();
            });
        });
        $('#add_note').on("click", function() {
            $('<div><input autofocus type="text" name="notes[]" class="form-control" dir="rtl" style="margin:10px 0; display:inline;float:right;width:90%"  />' +
                '<button type="button" class="btn btn-danger btn-sm delete_note" style="width:7%;height: 35px;display: inline; float: left;padding: 5px; margin-top: 10px"><i style="font-size: 18px;" class="fa fa-trash"></i></button>' +
                '<div class="clearfix"></div></div>').insertBefore('.dom2');
            $('.delete_note').on('click', function() {
                $(this).parent().remove();
            });
        });
        $('.open_extras').on('click', function() {
            $('.extras').fadeIn(300);
            $(this).fadeOut(300);
        });
    </script>
@endsection
