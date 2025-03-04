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
                    <div class="col-12 d-flex flex-wrap justify-content-between">
                        <h5  class=" alert alert-sm custom-title">
                            @lang('main.Update Client Information')</h5>
                        <a class="btn btnn text-white py-1 px-3" style="background-color: #36c7d6" href="{{ route('client.outer_clients.index') }}">
                            {{ __('main.back') }}</a>
                        
                    </div>
                    <div class="clearfix"></div>
                    <br>

                    <form class="parsley-style-1" id="selectForm2" name="selectForm2"
                        action="{{ route('client.outer_clients.update', $outer_client->id) }}"
                        enctype="multipart/form-data" method="post">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="company_id" value="{{ $company_id }}">
                        <h5 class="col-lg-12 d-block mb-2">{{ __('main.main-information') }}</h5>
                        <hr>
                        <div class="row g-3 align-items-center">
                            <!-- Client Name -->
                            <div class="col-lg-4 col-md-6">
                                <div class="form-group" dir="rtl">
                                    <label for="order">اسم العميل</label>
                                    <input value="{{ $outer_client->client_name }}" type="text" name="client_name"
                                        class="form-control" required>
                                </div>
                            </div>
                        
                            <!-- Assigned User -->
                            <div class="col-lg-4 col-md-6">
                                <div class="form-group" dir="rtl">
                                    <label for="client_id">المستخدم المخصص له</label>
                                    <select name="client_id" class="form-control">
                                        <option value="">كل المستخدمين</option>
                                        @foreach ($clients as $client)
                                            <option @if ($outer_client->client_id == $client->id) selected @endif
                                                value="{{ $client->id }}">{{ $client->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        
                            <!-- Client Notes -->
                            <div class="col-lg-4 col-md-12">
                                <div class="form-group" dir="ltr">
                                    <label for="note">ملاحظات العميل</label>
                                    <button type="button" id="add_note" class="btn btn-sm btn-success">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                    <div class="d-flex gap-2">
                                        
                                    </div>
                                    <div class="notes-container mt-2">
                                        @if ($outer_client->notes->isEmpty())
                                            <div class="d-flex gap-2 align-items-center">
                                                <input type="text" class="form-control note" name="notes[]" dir="ltr">
                                            </div>
                                        @endif
                                        @foreach ($outer_client->notes as $note)
                                            <div class="d-flex gap-2  mt-2">
                                                <input type="text" class="form-control note" name="notes[]" dir="ltr" 
                                                       value="{{ $note->client_note }}">
                                                <button type="button" class="btn btn-danger btn-sm delete_phone">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                           
                                        @endforeach
                                    </div>
                        
                                    <div class="dom2"></div>
                                </div>
                            </div>

                            <!-- Client Debt -->
                            <div class="col-lg-4 col-md-12">
                                <div class="form-group" dir="rtl">
                                    <label for="prev_balance">مديونية العميل</label>
                                    <div class="d-flex align-items-center gap-2">
                                        <input type="radio" value="for" name="balance" 
                                            @if ($outer_client->prev_balance < 0) checked @endif> له
                                        <input type="radio" value="on" name="balance" 
                                            @if ($outer_client->prev_balance > 0) checked @endif> عليه
                                    </div>
                                    <input required value="{{ abs((float)$outer_client->prev_balance) ?? 0 }}" 
                                           type="number" name="prev_balance" disabled class="form-control" dir="ltr">
                                </div>
                            </div>
                        
                            <!-- Client Phone Numbers -->
                            <div class="col-lg-4 col-md-12">
                                <div class="form-group" dir="ltr">
                                    <label for="phone">رقم الهاتف بمفتاح الدولة</label>
                                    <button type="button" id="add_phone" class="btn btn-sm btn-success ms-2">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                    
                                    <div class="phones-container mt-2">
                                        @if ($outer_client->phones->isEmpty())
                                            <div class="d-flex gap-2">
                                                <input type="text" class="form-control phone" name="phones[]" dir="ltr">
                                            </div>
                                        @endif
                        
                                        @foreach ($outer_client->phones as $phone)
                                            <div class="d-flex gap-2 mt-2">
                                                <input type="text" class="form-control phone" name="phones[]" dir="ltr" 
                                                       value="{{ $phone->client_phone }}">
                                                <button type="button" class="btn btn-danger btn-sm delete_phone">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="dom1"></div>
                                </div>
                            </div>
                        
                            <!-- Client Addresses -->
                            <div class="col-lg-4 col-md-12">
                                <div class="form-group" dir="ltr">
                                    <label for="address">عنوان العميل</label>
                                    <button type="button" id="add_address" class="btn btn-sm btn-success ms-2">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                    
                                    <div class="addresses-container mt-2">
                                        @if ($outer_client->addresses->isEmpty())
                                            <div class="d-flex gap-2">
                                                <input type="text" class="form-control address" name="addresses[]" dir="ltr">
                                            </div>
                                        @endif
                        
                                        @foreach ($outer_client->addresses as $address)
                                            <div class="d-flex gap-2 mt-2">
                                                <input type="text" class="form-control address" name="addresses[]" dir="ltr" 
                                                       value="{{ $address->client_address }}">
                                                <button type="button" class="btn btn-danger btn-sm delete_address">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="dom3"></div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="clearfix"></div>
                        <a href="javascript:;" class="btn btn-link open_extras">
                            <i class="fa fa-plus"></i>
                            خيارات اضافية
                        </a>
                        <div class="clearfix"></div>
                        <div class="extras" style="display: none">
                            <div class="row">
                                <div class="form-group  col-lg-4  ">
                                    <label for="client_category">فئة التعامل</label>
                                    <select name="client_category" class="form-control" required>
                                        <option value="">اختر الفئة</option>
                                        <option @if ($outer_client->client_category == 'جملة') selected @endif value="جملة">جملة
                                        </option>
                                        <option @if ($outer_client->client_category == 'قطاعى') selected @endif value="قطاعى">قطاعى
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group col-lg-4  " >
                                    <label for="client_email">البريد الالكترونى</label>
                                    <input type="email" name="client_email" dir="ltr"
                                        value="{{ $outer_client->client_email }}" class="form-control">
                                </div>

                                <div class="form-group col-lg-4" >
                                    <label for="shop_name">اسم محل / شركة العميل</label>
                                    <input type="text" name="shop_name" value="{{ $outer_client->shop_name }}"
                                        class="form-control" >
                                </div>
                                <div class="form-group col-lg-4" >
                                    <label for="client_national">جنسية العميل</label>
                                    <select name="client_national" class="form-control">
                                        <option value="">اختر دولة</option>
                                        @foreach ($timezones as $timezone)
                                            <option @if ($outer_client->client_national == $timezone->country_name) selected @endif
                                                value="{{ $timezone->country_name }}">{{ $timezone->country_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-lg-4" >
                                    <label for="tax_number">الرقم الضريبى</label>
                                    <input type="text" name="tax_number" value="{{ $outer_client->tax_number }}"
                                        class="form-control" dir="ltr" />
                                </div>
                                <div class="clearfix"></div>

                            </div>
                        </div>

                        <div class="clearfix"></div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-start">
                            <button class="btn btnn btn-warning py-1 px-3 pd-x-20" type="submit">تحديث</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('app-assets/js/jquery.min.js') }}"></script>
    <script>
        $('.delete_phone').on('click', function() {
            $(this).parent().remove();
        });
        $('#add_phone').on("click", function() {
            $('<div><input autofocus type="text" name="phones[]" class="form-control" dir="ltr" style="margin:10px 0; display:inline;float:right;width:80%"  />' +
                '<button type="button" class="btn btn-danger btn-sm delete_phone" style="width:15%;height: 30px;display: inline; float: left;padding: 5px; margin-top: 10px"><i style="font-size: 18px;" class="fa fa-trash"></i></button>' +
                '<div class="clearfix"></div></div>').insertBefore('.dom1');
            $('.delete_phone').on('click', function() {
                $(this).parent().remove();
            });
        });
        $('.delete_note').on('click', function() {
            $(this).parent().remove();
        });
        $('#add_note').on("click", function() {
            $('<div><input autofocus type="text" name="notes[]" class="form-control" dir="rtl" style="margin:10px 0; display:inline;float:right;width:90%"  />' +
                '<button type="button" class="btn btn-danger btn-sm delete_note" style="width:7%;height: 35px;display: inline; float: left;padding: 5px; margin-top: 10px"><i style="font-size: 18px;" class="fa fa-trash"></i></button>' +
                '<div class="clearfix"></div></div>').insertBefore('.dom2');
            $('.delete_note').on('click', function() {
                $(this).parent().remove();
            });
        });

        $('.delete_address').on('click', function() {
            $(this).parent().remove();
        });
        $('#add_address').on("click", function() {
            $('<div><input autofocus type="text" name="addresses[]" class="form-control" dir="rtl" style="margin:10px 0; display:inline;float:right;width:90%"  />' +
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
