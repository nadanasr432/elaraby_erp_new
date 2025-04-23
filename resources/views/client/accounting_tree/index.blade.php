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


    .tree, .tree ul {
        margin: 0;
        padding: 0;
        list-style: none
    }

    .tree ul {
        margin-left: 1em;
        position: relative
    }

    .tree ul ul {
        margin-left: .5em
    }

    .tree ul:before {
        content: "";
        display: block;
        width: 0;
        position: absolute;
        top: 0;
        bottom: 0;

        border-left: 1px solid
    }

    .tree li {
        margin: 0;
        padding: 0 1em;
        line-height: 2em;
        color: #369;
        font-weight: 700;
        position: relative;
        font-size: 18px !important;

    }

    .tree ul li:before {
        content: "";
        display: block;
        width: 10px;
        height: 0;
        border-top: 1px solid;
        margin-top: -1px;
        position: absolute;
        top: 1em;
        right: 0%;
    }

    .tree ul li:last-child:before {
        background: #fff;
        height: auto;
        top: 1em;
        bottom: 0
    }

    .indicator {
        margin-right: 5px;
    }

    .tree li a {
        text-decoration: none;
        color: #369;
    }

    .tree li button, .tree li button:active, .tree li button:focus {
        text-decoration: none;
        color: #369;
        border: none;
        background: transparent;
        margin: 0px 0px 0px 0px;
        padding: 0px 0px 0px 0px;
        outline: 0;
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
                <div class="card-body p-1">


                    <div class="card-header border-bottom border-secondary pb-1 pt-0 px-0">
                        <div class="d-flex justify-content-between align-items-baseline">
                            <h3 class="pull-right font-weight-bold">
                                {{ __('main.main-information') }}
                            </h3>
                            <div class="row mr-1">
                                <a onclick="history.back()"
                                   class="btn btn-danger pull-left text-white d-flex align-items-center ml-1"
                                   style="height: 37px; font-size: 11px !important;">
                                        <span
                                            style="border: 1px dashed;border-radius: 50%;margin-left: 10px;width: 20px;height: 20px;">
                                            <svg style="width: 10px;height: 15px;fill: #f5f1f1;margin-top: 1px;"
                                                 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome  - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path
                                                    d="M177.5 414c-8.8 3.8-19 2-26-4.6l-144-136C2.7 268.9 0 262.6 0 256s2.7-12.9 7.5-17.4l144-136c7-6.6 17.2-8.4 26-4.6s14.5 12.5 14.5 22l0 72 288 0c17.7 0 32 14.3 32 32l0 64c0 17.7-14.3 32-32 32l-288 0 0 72c0 9.6-5.7 18.2-14.5 22z"></path></svg>
                                        </span>
                                    العودة
                                </a>
                            </div>
                        </div>
                    </div>
                    <form class="parsley-style-1" id="selectForm2" name="selectForm2"
                          action="{{ route('client.accouning_tree.store') }}" enctype="multipart/form-data"
                          method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="company_id" value="">
                        <div class="alert alert-danger" id="showErrMsg" style="display:none">

                        </div>
                        <div class="row mb-1 mt-2">
                            <div class="col-md-4 text-center">
                                <input type="radio" name="type" value="level_one" id="level_one">
                                <label for="level_one"
                                       class="px-1">
                                    مستوى أول </label>
                            </div>
                            <div class="col-md-4 text-center">
                                <input type="radio" name="type" value="main" id="main">
                                <label for="main" class="px-1">
                                    رئيسي </label>
                            </div>
                            <div class="col-md-4 text-center">
                                <input type="radio" name="type" value="sub" id="sub"><label for="sub" class="px-1">
                                    فرعي </label>
                            </div>
                        </div>
                        <hr>

                        <div class="row mb-0 pull-right">

                            <div class="form-group  col-lg-4  pull-right" dir="rtl">
                                <label for="store_id">رقم الحساب</label>
                                <input type="hidden" name="account_id" id="account_id" value="">
                                <input type="number" name="account_number" id="account_number" placeholder="رقم الحساب"
                                       class="form-control"
                                       @if($id !=Null) value="{{$id+1}}" @else value="1" @endif">
                            </div>
                            <div class="form-group  col-lg-4  pull-right" dir="rtl">
                                <label style="display: block;">اسم الحساب </label>
                                <input type="text" class="form-control text-left" placeholder="اسم الحساب" value=""
                                       dir="ltr" name="account_name"
                                       id="account_name" required/>
                            </div>
                            <div class="form-group  col-lg-4  pull-right" dir="rtl">
                                <label style="display: block;">الاسم بالانجليزي </label>
                                <input type="text" class="form-control text-left" placeholder="الاسم بالانجليزي"
                                       value="" dir="ltr" name="account_name_en"
                                       id="account_name_en" required/>
                            </div>

                            <div class="col-lg-6 pull-right">
                                <label class="d-block" for="unit_id"> المستوى</label>
                                <input type="text" class="form-control" placeholder="المستوى" value="" id="level"
                                       disabled>
                                <input type="hidden" name="level" class="form-control" value="" id="level1">
                            </div>

                            <div class="form-group col-lg-6  pull-right" dir="rtl">
                                <label for="model"> حساب رئيسي</label>
                                <select name="parent_id" class="form-control" id="parent_id">
                                    <option value=""> حساب رئيسي</option>
                                    @if(count($parent_id)>0)
                                        @foreach($parent_id as $parent)
                                            <option value="{{$parent->id}}">{{$parent->account_name}}
                                                - {{$parent->account_number}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="form-group col-lg-6  pull-right" dir="rtl">
                                <label for="model"> نوع الحساب </label>
                                <select name="account_type" class="form-control" id="account_type">
                                    <option> إختار نوع الحساب</option>
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
                                    <option disabled> إختار نوع الميزانية</option>
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
                                <input type="text" name="last_year_amount" placeholder=" مبلغ سنة ماضية"
                                       id="last_year_amount" class="form-control"
                                       disabled>
                            </div>
                            <div class="form-group col-lg-3  pull-right" dir="rtl">
                                <label for="model"> رصيد مدين </label>
                                <input type="text" name="debit_balance" value="" placeholder=" رصيد مدين "
                                       id="debit_balance" class="form-control"
                                       disabled>
                            </div>
                            <div class="form-group col-lg-3  pull-right" dir="rtl">
                                <label for="model"> رصيد دائن </label>
                                <input type="text" name="credit" id="credit" placeholder="رصيد دائن" value=""
                                       class="form-control" disabled>
                            </div>
                            <div class="form-group col-lg-3  pull-right" dir="rtl">
                                <label for="model"> الرصيد </label>
                                <input type="text" name="balance" id="balance" placeholder="الرصيد" value=""
                                       class="form-control" disabled>
                            </div>

                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-left">
                            <a class="btn btn-md btn-info pd-x-20 d-none" id="new">إضافة جديد</a>
                            <button class="btn btn-md btn-warning pd-x-20 d-none" type="submit" id="edit">تعديل</button>
                            <button class="btn btn-md btn-success pd-x-20" type="submit" id="save">حفظ</button>
                            <a class="btn btn-md btn-danger pd-x-20 d-none" id="delete">حذف</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card mg-b-20">
                <div class="card-body px-0">
                    <div class="col-12">
                        <h3 class="pull-right font-weight-bold">
                            الشجرة المحاسبية
                        </h3>
                    </div>
                    <br>
                    <hr>
                    <div class="col-md-6">

                        <ul id="tree1" class="tree">
                            @foreach($categories as $category)
                                @if ($category->childs->first && $category->first)
                                    @continue
                                @endif
                                <li class="user-{{ $category->id }}">
                                    <i class="fa fa-file"
                                       style="font-size: 20px !important;"></i> {{$category->account_number}}
                                    -{{ $category->account_name }}

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
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                            aria-hidden="true">&times;</span></button>
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
        $("ul li").click(function (event) {
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

                }, success: function (response) {
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
        document.getElementById('level_one').addEventListener('change', function () {
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
        document.getElementById('main').addEventListener('change', function () {
            // التحقق مما اذا كان الـ radio button محددا
            if (this.checked) {
                // تعديل خاصية الـ disabled للحقول التي تريد إلغاء تفعيلها
                document.getElementById('parent_id').disabled = false;
                document.getElementById('account_type').disabled = true;
                document.getElementById('account_type').value = 'إختار نوع الحساب';

            }
        });

        document.getElementById('sub').addEventListener('change', function () {
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

        $('#parent_id').change(function () {
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
                success: function (response) {
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
        $("#new").click(function (event) {
            window.location.reload(1);
        })
    </script>

    <script>
        $("#delete")
            .click(function (event) {
                var id = document.getElementById('account_id').value;
                console.log(id);
                $.ajax({
                    url: "{{ url('client/delete_data_accounting_tree') }}",
                    method: 'POST',
                    data: {
                        id: id
                    },
                    success: function () {

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
