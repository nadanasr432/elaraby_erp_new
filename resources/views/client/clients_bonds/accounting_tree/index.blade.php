@extends('client.layouts.app-main')
<style>
    .btn.dropdown-toggle.bs-placeholder {
        height: 40px;
    }

    .bootstrap-select {
        width: 80% !important;
    }

    .form-control {
        height: 45px !important;
        padding: 10px !important;
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
                    <a class="btn btn-primary btn-sm pull-left" href="{{ route('client.products.index') }}">
                        {{ __('main.back') }}</a>
                </div>
                <div class="clearfix"></div>
                <br>
                <form class="parsley-style-1" id="selectForm2" name="selectForm2" action="{{ route('client.accouning_tree.store') }}" enctype="multipart/form-data" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="company_id" value="">
                    <h5 class="col-lg-12 d-block mb-2">{{ __('main.main-information') }}</h5>
                    <hr>
                    <div class="alert alert-danger" id="showErrMsg" style="display:none">

                    </div>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-md-4 text-center">
                            <input type="radio" name="type" value="level_one" id="level_one"><label for="level_one" class="px-1"> مستوى أول </label>
                        </div>
                        <div class="col-md-4 text-center">
                            <input type="radio" name="type" value="main" id="main"><label for="main" class="px-1"> رئيسي </label>
                        </div>
                        <div class="col-md-4 text-center">
                            <input type="radio" name="type" value="sub" id="sub"><label for="sub" class="px-1"> فرعي </label>
                        </div>
                    </div>
                    <div class="row mb-3 pull-right">

                        <div class="form-group  col-lg-4  pull-right" dir="rtl">
                            <label for="store_id">رقم الحساب</label>
                            <input type="hidden" name="account_id" id="account_id" value="">
                            <input type="number" step="any" name="account_number" id="account_number" class="form-control" @if($id !=Null) value="{{$id+1}}" @else value="1" @endif">
                        </div>
                        <div class="form-group  col-lg-4  pull-right" dir="rtl">
                            <label style="display: block;">اسم الحساب </label>
                            <input type="text" class="form-control" value="" dir="ltr" name="account_name" id="account_name" required />
                        </div>
                        <div class="form-group  col-lg-4  pull-right" dir="rtl">
                            <label style="display: block;">الاسم بالانجليزي </label>
                            <input type="text" class="form-control" value="" dir="ltr" name="account_name_en" id="account_name_en" required />
                        </div>

                        <div class="col-lg-6 pull-right">
                            <label class="d-block" for="unit_id"> المستوى</label>
                            <input type="text" class="form-control" value="" id="level" disabled>
                            <input type="hidden" name="level" class="form-control" value="" id="level1">
                        </div>

                        <div class="form-group col-lg-6  pull-right" dir="rtl">
                            <label for="model"> حساب رئيسي</label>
                            <select name="parent_id" class="form-control" id="parent_id">
                                <option value=""> حساب رئيسي </option>
                                @if(count($parent_id)>0)
                                @foreach($parent_id as $parent)
                                <option value="{{$parent->id}}">{{$parent->account_name}} - {{$parent->account_number}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-lg-6  pull-right" dir="rtl">
                            <label for="model"> نوع الحساب </label>
                            <select name="account_type" class="form-control" id="account_type">
                                <option> إختار نوع الحساب </option>
                                <option value="أصول">أصول</option>
                                <option value="خصوم">خصوم</option>
                                <option value="إيرادات">إيرادات</option>
                                <option value="مصروفات">مصروفات</option>
                            </select>
                            <input type="hidden" name="account_type1" id="account_type1">
                        </div>
                        <div class="form-group col-lg-6  pull-right" dir="rtl">
                            <label for="model"> نوع الميزانية </label>
                            <select name="type_budget" class="form-control" id="type_budget">
                                <option disabled> إختار نوع الميزانية </option>
                                <option value="حساب متاجرة">حساب متاجرة</option>
                                <option value="حساب أرباح و خسائر">حساب أرباح و خسائر</option>
                                <option value="ميزانية">ميزانية</option>
                                <option value="بضاعة أول المدة">بضاعة أول المدة</option>
                                <option value="أخرى">أخرى</option>
                                <option value="بضاعة آخر المدة">بضاعة آخر المدة</option>
                            </select>
                        </div>
                        <div class="form-group col-lg-3  pull-right" dir="rtl">
                            <label for="model"> مبلغ سنة ماضية </label>
                            <input type="text" name="last_year_amount" id="last_year_amount" class="form-control" disabled>
                        </div>
                        <div class="form-group col-lg-3  pull-right" dir="rtl">
                            <label for="model"> رصيد مدين </label>
                            <input type="text" name="debit_balance" value="" id="debit_balance" class="form-control" disabled>
                        </div>
                        <div class="form-group col-lg-3  pull-right" dir="rtl">
                            <label for="model"> رصيد دائن </label>
                            <input type="text" name="credit" id="credit" value="" class="form-control" disabled>
                        </div>
                        <div class="form-group col-lg-3  pull-right" dir="rtl">
                            <label for="model"> الرصيد </label>
                            <input type="text" name="balance" id="balance" value="" class="form-control" disabled>
                        </div>

                    </div>
                    <div class="clearfix"></div>
                    <div class="col-xs-12 col-sm-12 col-md-12 text-left">
                        <a class="btn btn-md btn-info pd-x-20 d-none" id="new">إضافة جديد</a>
                        <button class="btn btn-md btn-warning pd-x-20 d-none" type="submit" id="edit">تعديل</button>
                        <button class="btn btn-md btn-success pd-x-20" type="submit" id="save">حفظ</button>
                        <a class="btn btn-md btn-danger pd-x-20 d-none" id="delete">حذف</a>
                    </div>

                    <div class="clearfix"></div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card mg-b-20">
            <div class="card-body">
                <div class="col-12">
                    <h4>الشجرة المحاسبية</h4>
                </div>
                <div class="clearfix"></div>
                <br>
                <div class="col-md-6">

                    <ul id="tree1">
                        @foreach($categories as $category)
                        @if ($category->childs->first && $category->first)
                        @continue
                        @endif
                        <li class="user-{{ $category->id }}">
                            <i class="fa fa-file" style="font-size: 20px !important;"></i> {{$category->account_number}}-{{ $category->account_name }}

                            @if(count($category->childs))
                            @include('client.accounting_tree.manageChild',['childs' => $category->childs])
                            @endif
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="modal" id="modaldemo9">
    <div class="modal-dialog modal-dialog-centered" bank="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header text-center">
                <h6 class="modal-title w-100" style="font-family: 'Cairo'; ">حذف عملية </h6>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body">
                <h3 class="text-center">تم حذف البيانات بنجاح</h3>
            </div>
            <div class="modal-footer">
                <a class="btn btn-warning" onclick="window.location.reload(1);">اغلاق</a>

            </div>

        </div>
    </div>
</div>

<script src="{{ asset('app-assets/js/jquery.min.js') }}"></script>
<script>
    $("ul li")
        .click(function(event) {
            //event.target is what you clicked on
            //you can wrap it in a jQuert element via $() to use jQuery features
            var $el = $(event.target);

            var htmlClass = $el.attr("class");

            var id = htmlClass.split("-")[1];

            console.log("My ID is: ", id);
            $.ajax({
                type: 'POST',
                url: "{{url('client/edit-accounting_tree')}}",
                data: {
                    id: id,

                },
                success: function(response) {
                    console.log(response);
                    $('#account_id').val(response.id);
                    $('#balance').val(response.balance);
                    $('#credit').val(response.credit);
                    $('#debit_balance').val(response.debit_balance);
                    $('#last_year_amount').val(response.last_year_amount);
                    $('#type_budget').val(response.type_budget);
                    $('#account_type').val(response.account_type);
                    $('#account_type1').val(response.account_type);
                    $('#parent_id').val(response.parent_id);
                    $('#level').val(response.level);
                    $('#level1').val(response.level);
                    $('#account_name_en').val(response.account_name_en);
                    $('#account_name').val(response.account_name);
                    $('#account_number').val(response.account_number);
                    $('#type').val(response.type);
                    if (response.type == 'level_one') {
                        $('#level_one').prop('checked', true);
                        document.getElementById('parent_id').disabled = true;
                        document.getElementById('type_budget').disabled = true;
                        document.getElementById('level').value = 'مستوى أول';
                        document.getElementById('level1').value = 'مستوى أول';
                        document.getElementById('type_budget').value = 'أخرى';
                    }
                    if (response.type == 'main') {
                        $('#main').prop('checked', true);
                        document.getElementById('parent_id').disabled = false;
                        document.getElementById('account_type').disabled = true;
                        document.getElementById('account_type').value = 'إختار نوع الحساب';
                    }
                    if (response.type == 'sub') {
                        $('#sub').prop('checked', true);
                        document.getElementById('parent_id').disabled = false;
                        document.getElementById('type_budget').disabled = true;
                        document.getElementById('type_budget').value = 'أخرى';

                        document.getElementById('account_type').disabled = true;
                        document.getElementById('account_type').value = 'إختار نوع الحساب';
                    }

                    document.getElementById('save').classList.add('d-none');
                    document.getElementById('delete').classList.remove('d-none');
                    document.getElementById('edit').classList.remove('d-none');
                    document.getElementById('new').classList.remove('d-none');
                }
            });
        });
</script>

<script>
    document.getElementById('level_one').addEventListener('change', function() {
        // التحقق مما اذا كان الـ radio button محددا
        if (this.checked) {
            // تعديل خاصية الـ disabled للحقول التي تريد إلغاء تفعيلها
            document.getElementById('parent_id').disabled = true;
            document.getElementById('type_budget').disabled = true;
            document.getElementById('level').value = 'مستوى أول';
            document.getElementById('level1').value = 'مستوى أول';
            document.getElementById('type_budget').value = 'أخرى';
        }
    });
    document.getElementById('main').addEventListener('change', function() {
        // التحقق مما اذا كان الـ radio button محددا
        if (this.checked) {
            // تعديل خاصية الـ disabled للحقول التي تريد إلغاء تفعيلها
            document.getElementById('parent_id').disabled = false;
            document.getElementById('account_type').disabled = true;
            document.getElementById('account_type').value = 'إختار نوع الحساب';

        }
    });

    document.getElementById('sub').addEventListener('change', function() {
        // التحقق مما اذا كان الـ radio button محددا
        if (this.checked) {
            // تعديل خاصية الـ disabled للحقول التي تريد إلغاء تفعيلها
            document.getElementById('parent_id').disabled = false;
            document.getElementById('type_budget').disabled = true;
            document.getElementById('type_budget').value = 'أخرى';

            document.getElementById('account_type').disabled = true;
            document.getElementById('account_type').value = 'إختار نوع الحساب';
        }
    });

    $('#parent_id').change(function() {
        // جلب القيمة المحددة من الـ select
        var selectedValue = $(this).val();
        console.log(selectedValue);
        // إرسال طلب AJAX لجلب البيانات من الخادم
        $.ajax({
            url: "{{ url('client/get_data_accounting_tree') }}",
            method: 'POST',
            data: {
                selectedValue: selectedValue
            },
            success: function(response) {
                console.log(response.account_number);
                console.log(response.level);
                // تحديث الحقول بالبيانات المسترجعة من الخادم
                $('#account_number').val(response.account_number);
                $('#level').val(response.level);
                $('#level1').val(response.level);
                $('#account_type').val('أصول')
                $('#account_type1').val('أصول')
                // وهكذا
            }
        });
    });
</script>

<script>
    $("#new")
        .click(function(event) {

            window.location.reload(1);
        })
</script>

<script>
    $("#delete")
        .click(function(event) {
            var id = document.getElementById('account_id').value;
            console.log(id);
            $.ajax({
                url: "{{ url('client/delete_data_accounting_tree') }}",
                method: 'POST',
                data: {
                    id: id
                },
                success: function() {

                    // تحديث الحقول بالبيانات المسترجعة من الخادم
                    $('#modaldemo9').modal('show');
                    setTimeout(() => {
                        window.location.reload(1);
                    }, 6000);
                }
            });
        })
</script>
@endsection
