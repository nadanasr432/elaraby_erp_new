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
                    <div class="col-12">
                        <a class="btn btn-primary btn-sm pull-left" href="{{ route('client.suppliers.index') }}">
                            {{ __('main.back') }}</a>
                        <h5 style="min-width: 300px;" class="pull-right alert alert-sm alert-success">
                            اضافة مورد جديد </h5>
                    </div>
                    <div class="clearfix"></div>
                    <br>

                    <form class="parsley-style-1" id="selectForm2" name="selectForm2"
                        action="{{ route('client.suppliers.update', $supplier->id) }}" enctype="multipart/form-data"
                        method="post">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="company_id" value="{{ $company_id }}">
                        <h5 class="col-lg-12 d-block mb-2">{{ __('main.main-information') }}</h5>
                        <hr>
                        <div class="col-lg-6 col-xs-12 pull-right">

                            <div class="form-group  col-lg-12  pull-right" dir="rtl">
                                <label for="order">اسم المورد </label>
                                <input value="{{ $supplier->supplier_name }}" type="text" name="supplier_name"
                                    class="form-control" required>
                            </div>

                            <div class="form-group pull-right col-lg-12" dir="ltr">
                                <label for="note"> ملاحظات المورد </label>
                                <?php
                                echo "<button type='button' id='add_note' class='btn btn-sm btn-success pull-left'><i class='fa fa-plus'></i></button>";
                                echo "<div class='clearfix'></div>";
                                if ($supplier->notes->isEmpty()) {
                                    echo '<div>';
                                    echo "<input type='text' class='form-control note' name='notes[]' dir='ltr' style='margin :5px 0;width:85%;display:inline;float:left;' /> ";
                                    echo "<div class='clearfix'></div>";
                                    echo '</div>';
                                }
                                foreach ($supplier->notes as $note) {
                                    $note = $note->supplier_note;
                                    echo '<div>';
                                    echo "<input type='text' class='form-control note' name='notes[]' dir='ltr' style='margin :5px 0;width:85%;display:inline;float:left;' value='" . $note . "' /> ";
                                    echo "<button type='button' class='btn btn-md btn-danger delete_note' style='width:10%;display:inline;float:right;margin :5px;padding: 10px;'><i class='fa fa-trash'></i></button>";
                                    echo "<div class='clearfix'></div>";
                                    echo '</div>';
                                }
                                ?>
                                <div class="clearfix"></div>
                                <div class="dom2"></div>
                            </div>


                        </div>
                        <div class="col-lg-6 col-xs-12  pull-left">

                            <div class="clearfix"></div>
                            <div class="form-group  pull-right col-lg-6" dir="rtl">
                                <label for="prev_balance">مستحقات المورد</label>
                                <input style="margin-right:5px;margin-left:5px;"
                                    @if ($supplier->prev_balance > 0) checked @endif type="radio" value="for"
                                    name="balance" /> له
                                <input style="margin-right:5px;margin-left:5px;"
                                    @if ($supplier->prev_balance < 0) checked @endif type="radio" value="on"
                                    name="balance" /> عليه

                                <input required value="{{ abs($supplier->prev_balance) }}" type="text" name="prev_balance"
                                    class="form-control" dir="ltr" />
                            </div>
                            <div class="form-group pull-right col-lg-6" dir="ltr">
                                <label for="phone">رقم الهاتف بمفتاح الدولة</label>
                                <?php
                                echo "<button type='button' id='add_phone' class='btn btn-sm btn-success pull-left'><i class='fa fa-plus'></i></button>";
                                echo "<div class='clearfix'></div>";
                                if ($supplier->phones->isEmpty()) {
                                    echo '<div>';
                                    echo "<input type='text' class='form-control phone' name='phones[]' dir='ltr' style='margin :5px 0;width:85%;display:inline;float:left;' /> ";
                                    echo "<div class='clearfix'></div>";
                                    echo '</div>';
                                }
                                foreach ($supplier->phones as $phone) {
                                    $phone = $phone->supplier_phone;
                                    echo '<div>';
                                    echo "<input type='text' class='form-control phone' name='phones[]' dir='ltr' style='margin :5px 0;width:80%;display:inline;float:left;' value='" . $phone . "' /> ";
                                    echo "<button type='button' class='btn btn-md btn-danger delete_phone' style='width:15%;display:inline;float:right;margin :5px;padding: 10px;'><i class='fa fa-trash'></i></button>";
                                    echo "<div class='clearfix'></div>";
                                    echo '</div>';
                                }
                                ?>
                                <div class="clearfix"></div>
                                <div class="dom1"></div>
                            </div>

                            <div class="form-group pull-right col-lg-12" dir="ltr">
                                <label for="address">عنوان المورد</label>
                                <?php
                                echo "<button type='button' id='add_address' class='btn btn-sm btn-success pull-left'><i class='fa fa-plus'></i></button>";
                                echo "<div class='clearfix'></div>";
                                if ($supplier->addresses->isEmpty()) {
                                    echo '<div>';
                                    echo "<input type='text' class='form-control address' name='addresses[]' dir='ltr' style='margin :5px 0;width:85%;display:inline;float:left;' /> ";
                                    echo "<div class='clearfix'></div>";
                                    echo '</div>';
                                }
                                foreach ($supplier->addresses as $address) {
                                    $address = $address->supplier_address;
                                    echo '<div>';
                                    echo "<input type='text' class='form-control address' name='addresses[]' dir='ltr' style='margin :5px 0;width:90%;display:inline;float:left;' value='" . $address . "' /> ";
                                    echo "<button type='button' class='btn btn-md btn-danger delete_address' style='width:7%;display:inline;float:right;margin :5px;padding: 10px;'><i class='fa fa-trash'></i></button>";
                                    echo "<div class='clearfix'></div>";
                                    echo '</div>';
                                }
                                ?>
                                <div class="clearfix"></div>
                                <div class="dom3"></div>
                            </div>

                        </div>
                        <div class="clearfix"></div>
                        <a href="javascript:;" class="btn btn-link open_extras">
                            <i class="fa fa-plus"></i>
                            خيارات اضافية
                        </a>
                        <div class="clearfix"></div>
                        <div class="extras" style="display: none">
                            <div class="col-lg-12">

                                <div class="form-group  col-lg-4  pull-right" dir="rtl">
                                    <label for="supplier_category">فئة التعامل</label>
                                    <select name="supplier_category" class="form-control" required>
                                        <option value="">اختر الفئة</option>
                                        <option @if ($supplier->supplier_category == 'جملة') selected @endif value="جملة">جملة
                                        </option>
                                        <option @if ($supplier->supplier_category == 'قطاعى') selected @endif value="قطاعى">قطاعى
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group col-lg-4  pull-right" dir="rtl">
                                    <label for="supplier_email">البريد الالكترونى</label>
                                    <input type="email" name="supplier_email" dir="ltr"
                                        value="{{ $supplier->supplier_email }}" class="form-control">
                                </div>
                                <div class="clearfix"></div>

                                <div class="form-group  pull-right col-lg-4" dir="rtl">
                                    <label for="shop_name">اسم محل / شركة المورد</label>
                                    <input type="text" name="shop_name" value="{{ $supplier->shop_name }}"
                                        class="form-control" dir="rtl">
                                </div>
                                <div class="form-group  pull-right col-lg-4" dir="rtl">
                                    <label for="supplier_national">جنسية المورد</label>
                                    <select name="supplier_national" class="form-control">
                                        <option value="">اختر دولة</option>
                                        @foreach ($timezones as $timezone)
                                            <option @if ($supplier->supplier_national == $timezone->country_name) selected @endif
                                                value="{{ $timezone->country_name }}">{{ $timezone->country_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group  pull-right col-lg-4" dir="rtl">
                                    <label for="tax_number">الرقم الضريبى</label>
                                    <input type="text" name="tax_number" value="{{ $supplier->tax_number }}"
                                        class="form-control" dir="ltr" />
                                </div>
                                <div class="clearfix"></div>

                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button class="btn btn-info pd-x-20" type="submit">تحديث</button>
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
        $('.delete_address').on('click', function() {
            $(this).parent().remove();
        });
        $('#add_address').on("click", function() {
            $('<div><input autofocus type="text" name="addresses[]" class="form-control" dir="rtl" style="margin:10px 0; display:inline;float:right;width:90%"  />' +
                '<button type="button" class="btn btn-danger btn-sm delete_address" style="width:7%;height: 30px;display: inline; float: left;padding: 5px; margin-top: 10px"><i style="font-size: 18px;" class="fa fa-trash"></i></button>' +
                '<div class="clearfix"></div></div>').insertBefore('.dom3');
            $('.delete_address').on('click', function() {
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

        $('.open_extras').on('click', function() {
            $('.extras').fadeIn(300);
            $(this).fadeOut(300);
        });
    </script>
@endsection
