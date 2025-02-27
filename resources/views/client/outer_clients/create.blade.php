@extends('client.layouts.app-main')
<style>
    .btn.dropdown-toggle.bs-placeholder {
        height: 40px;
    }

    .form-control {
        height: 40px !important;
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
                    <div class="col-12 d-flex flex-wrap justify-content-between align-items-center">
                        <h5  class="    alert alert-sm custom-title">
                            {{ __('sidebar.add-new-client') }} </h5>
                        <a class="btn btn-sm pull-left text-white px-3 py-1" style="background-color: #ec6880;" href="{{ route('client.outer_clients.index') }}">
                            {{ __('main.back') }}</a>
                        
                    </div>
                    <div class="clearfix"></div>
                    <br>

                    <form class="parsley-style-1" id="selectForm2" name="selectForm2"
                        action="{{ route('client.outer_clients.store', 'test') }}" enctype="multipart/form-data"
                        method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="company_id" value="{{ $company_id }}">
                        <h5 class="col-lg-12 d-block mb-2">{{ __('main.main-information') }}</h5>
                        <hr>
                        <div class="row">
                            <div class="form-group  col-lg-6     " >
                                <label for="order">{{ __('clients.client-name') }} </label>
                                <input type="text" name="client_name" class="form-control" required>
                            </div>
                            <div class="form-group  col-lg-6     " >
                                <label for="client_id"> {{ __('clients.assigned-user') }} </label>
                                <select name="client_id" class="form-control">
                                    <option value=""> {{ __('clients.all-users') }} </option>
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group     col-lg-6" >
                                <label style="display: block" for="note"> {{ __('clients.client-notes') }} </label>
                                <div class="d-flex">

                                <input type="text" name="notes[]" class="form-control"
                                    style="width:100%; display: inline; float: right;">
                                <button type="button" id="add_note" class="btn btn-md btn-warning d-flex align-items-center justify-content-center py-1"
                                    >
                                    <i class="fa fa-plus" style="font-size: 17px; font-weight: bold;"></i>
                                </button>
                                <div class="clearfix"></div>
                                <div class="dom2"></div>
                                </div>
                            </div>
                            <div class="form-group      col-lg-6">
                                <label for="prev_balance">{{ __('clients.client-indebtedness') }}</label>
                                <input style="margin-right:5px;margin-left:5px;" type="radio" value="for" name="balance" />
                                {{ __('main.for') }}
                                <input style="margin-right:5px;margin-left:5px;" checked type="radio" value="on"
                                    name="balance" /> {{ __('main.on') }}
                                <input required type="number" value="0" name="prev_balance" class="form-control"  step="any"
                                    dir="ltr" />
                            </div>
                            <div class="form-group     col-lg-6">
                                <label style="display: block" for="phone">{{ __('clients.phone-with-code') }}</label>
                                <div class="d-flex">
                                    <input type="text" name="phones[]" class="form-control"
                                    dir="ltr">
                                <button type="button" id="add_phone" class="btn btn-md btn-warning d-flex align-items-center justify-content-center py-1"
                                    >
                                    <i class="fa fa-plus" style="font-size: 17px; font-weight: bold;"></i>
                                </button>
                                <div class="clearfix"></div>
                                <div class="dom1"></div>
                                </div>
                            </div>
                            <div class="form-group     col-lg-6" >
                                <label style="display: block" for="address"> {{ __('clients.client-address') }} </label>
                                <div class="d-flex">

                                <input type="text" name="addresses[]" class="form-control"
                                   >
                                    <button type="button" id="add_address" class="btn btn-md btn-warning d-flex align-items-center justify-content-center py-1"
                                    >
                                    <i class="fa fa-plus" style="font-size: 17px; font-weight: bold;"></i>
                                </button>
                                
                                <div class="clearfix"></div>
                                <div class="dom3"></div>
                                </div>
                            </div>
                    </div>
                        <div class="clearfix"></div>
                        <!-- <a href="javascript:;" class="btn btn-link open_extras"  style="display: none">
                           <i class="fa fa-plus"></i>
                           {{ __('clients.additional-options') }}
                        </a> -->
                        <div class="clearfix"></div>
                        <div class="extras" >
                        <div class="row" >
                                <div class="form-group  col-lg-6     "    >
                                    <label for="client_category">{{ __('clients.dealing-type') }}</label>
                                    <select name="client_category" class="form-control" required>
                                        <option value="">{{ __('clients.choose-type') }}</option>
                                        <option selected value="جملة">جملة</option>
                                        <option value="قطاعى">قطاعى</option>
                                    </select>
                                </div>
                                <div class="form-group col-lg-6     "    >
                                    <label for="client_email">{{ __('main.email-address') }}</label>
                                    <input type="email" name="client_email" dir="ltr" class="form-control">
                                </div>
                                <div class="clearfix"></div>

                                <div class="form-group      col-lg-6"    >
                                    <label for="shop_name">{{ __(key: 'clients.client-company-name') }}</label>
                                    <input type="text" name="shop_name" class="form-control"    >
                                </div>
                                <div class="form-group      col-lg-6"    >
                                    <label for="client_national">{{ __('clients.client-nationality') }}</label>
                                    <select name="client_national" class="form-control">
                                        <option value="">{{ __('main.choose-country') }}</option>
                                        @foreach ($timezones as $timezone)
                                            <option @if ($timezone->country_name == 'السعودية') selected @endif
                                                value="{{ $timezone->country_name }}">{{ $timezone->country_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group      col-lg-6"    >
                                    <label for="tax_number">{{ __('main.tax-number') }}</label>
                                    <input type="text" name="tax_number" class="form-control" dir="ltr" />
                                </div>
                                <div class="clearfix"></div>

                        </div>
                        <div class="clearfix"></div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-end">
                            <button class="btn btn-warning px-3 py-1" type="submit">{{ __('main.add') }}</button>
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
        $('#add_note').on("click", function() {
            $('<div><input autofocus type="text" name="notes[]" class="form-control"     style="margin:10px 0; display:inline;float:right;width:90%"  />' +
                '<button type="button" class="btn btn-danger btn-sm delete_note" style="width:7%;height: 35px;display: inline; float: left;padding: 5px; margin-top: 10px"><i style="font-size: 18px;" class="fa fa-trash"></i></button>' +
                '<div class="clearfix"></div></div>').insertBefore('.dom2');
            $('.delete_note').on('click', function() {
                $(this).parent().remove();
            });
        });
        $('#add_address').on("click", function() {
            $('<div><input autofocus type="text" name="addresses[]" class="form-control"     style="margin:10px 0; display:inline;float:right;width:90%"  />' +
                '<button type="button" class="btn btn-danger btn-sm delete_address" style="width:7%;height: 35px;display: inline; float: left;padding: 5px; margin-top: 10px"><i style="font-size: 18px;" class="fa fa-trash"></i></button>' +
                '<div class="clearfix"></div></div>').insertBefore('.dom3');
            $('.delete_address').on('click', function() {
                $(this).parent().remove();
            });
        });

        $('.open_extras').on('click', function() {
            $('.extras').fadeIn(300);
            $(this).fadeOut(300);
        });
    </script>
@endsection
