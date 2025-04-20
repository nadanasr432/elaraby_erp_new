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
                    <form class="parsley-style-1" id="selectForm2" name="selectForm2"
                        action="{{ route('client.cost_center.store') }}" enctype="multipart/form-data" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="company_id" value="">
                        <h5 class="col-lg-12 d-block mb-2">{{ __('main.main-information') }}</h5>

                        <div class="alert alert-danger" id="showErrMsg" style="display:none">

                        </div>
                        <hr>
                        <div class="row mb-3">

                            <div class="col-md-4 text-center">
                                <input type="radio" name="level" value="0" id="main" checked><label
                                    for="main" class="px-1"> رئيسي </label>
                            </div>
                            <div class="col-md-4 text-center">
                                <input type="radio" name="level" value="1" id="sub"><label for="sub"
                                    class="px-1"> فرعي </label>
                            </div>
                        </div>
                        <div class="row mb-3 pull-right">

                            <div class="form-group  col-lg-4  pull-right" dir="rtl">
                                <label for="store_id">رقم المركز</label>
                                <input type="hidden" name="account_id" id="account_id" value="">
                                <input type="number" name="account_number" id="account_number" class="form-control"
                                    @if ($id != null) value="{{ $id + 1 }}" @else value="1" @endif">
                            </div>
                            <div class="form-group  col-lg-4  pull-right" dir="rtl">
                                <label style="display: block;">اسم المركز </label>
                                <input type="text" class="form-control" value="" dir="ltr" name="account_name"
                                    id="account_name" required />
                            </div>
                            <div class="form-group  col-lg-4  pull-right" dir="rtl">
                                <label style="display: block;">الاسم بالانجليزي </label>
                                <input type="text" class="form-control" value="" dir="ltr"
                                    name="account_name_en" id="account_name_en" required />
                            </div>



                            <div class="form-group col-lg-4  pull-right" dir="rtl">
                                <label for="model"> مركز رئيسي</label>
                                <select name="parent_id" class="form-control" id="parent_id" disabled>
                                    <option value=""> مركز رئيسي </option>
                                    @if (count($categories) > 0)
                                        @foreach ($categories as $parent)
                                            <option value="{{ $parent->id }}">{{ $parent->account_name }} -
                                                {{ $parent->account_number }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="form-group  col-lg-4  pull-right" dir="rtl">
                                <label style="display: block;">الشخص المسئول </label>
                                <input type="text" class="form-control" value="" dir="ltr"
                                    name="responsible_name" id="responsible_name" required />
                            </div>
                            <div class="form-group  col-lg-4  pull-right" dir="rtl">
                                <label style="display: block;">الإميل</label>
                                <input type="text" class="form-control" value="" dir="ltr" name="email"
                                    id="email" required />
                            </div>

                            <div class="form-group col-lg-4  pull-right" dir="rtl">
                                <label for="model"> الهاتف </label>
                                <input type="text" name="phone" id="phone" class="form-control">
                            </div>
                            <div class="form-group col-lg-4  pull-right" dir="rtl">
                                <label for="model"> الموقع </label>
                                <input type="text" name="location" id="location" class="form-control">
                            </div>
                            <div class="form-group col-lg-4  pull-right" dir="rtl">
                                <label for="model"> القيمة </label>
                                <input type="text" name="value" id="value" class="form-control">
                            </div>
                            <div class="form-group col-lg-4  pull-right" dir="rtl">
                                <label for="model"> المدة </label>
                                <input type="text" name="period" id="period" class="form-control">
                            </div>

                            <div class="form-group col-lg-4  pull-right" dir="rtl">
                                <label for="model"> تاريخ البداية </label>
                                <input type="date" name="started_at" id="started_at" class="form-control">
                            </div>
                            <div class="form-group col-lg-4  pull-right" dir="rtl">
                                <label for="model"> تاريخ الإنتهاء </label>
                                <input type="date" name="ended_at" id="ended_at" class="form-control">
                            </div>


                        </div>
                        <div class="clearfix"></div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-left">
                            <a class="btn btn-md btn-info pd-x-20 d-none" id="new">إضافة جديد</a>
                            <button class="btn btn-md btn-warning pd-x-20 d-none" type="submit"
                                id="edit">تعديل</button>
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
                        <h4>مراكز التكلفة </h4>
                    </div>
                    <div class="clearfix"></div>
                    <br>
                    <div class="col-md-6">

                        <ul id="tree1">
                            @foreach ($categories as $category)
                                @if ($category->childs->first && $category->first)
                                    @continue
                                @endif
                                <li class="user-{{ $category->id }}">
                                    <i class="fa fa-file" style="font-size: 20px !important;"></i>
                                    {{ $category->account_number }}-{{ $category->account_name }}

                                    @if (count($category->childs))
                                        @include('client.cost_center.manageChild', [
                                            'childs' => $category->childs,
                                        ])
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
                    url: "{{ url('client/cost_center/get') }}",
                    data: {
                        id: id,


                    },
                    success: function(response) {
                        console.log(response);
                        dateTimeValue = response.started_at;
                        var started_at = dateTimeValue.split(' ')[0];
                        dateTimeValue = response.ended_at;
                        var ended_at = dateTimeValue.split(' ')[0];
                        // alert(started_at);

                        $('#account_id').val(response.id);
                        $('#value').val(response.value);
                        $('#period').val(response.period);
                        $('#started_at').val(started_at);
                        $('#ended_at').val(ended_at);
                        $('#responsible_name').val(response.responsible_name);
                        $('#email').val(response.email);
                        $('#phone').val(response.phone);
                        $('#location').val(response.location);
                        $('#level').val(response.level);
                        $('#account_name_en').val(response.account_name_en);
                        $('#account_name').val(response.account_name);
                        $('#account_number').val(response.account_number);

                        $('#type').val(response.type);

                        if (response.level == '0') {
                            $('#main').prop('checked', true);
                            document.getElementById('parent_id').disabled = false;
                        }
                        if (response.level == '1') {
                            $('#sub').prop('checked', true);
                            document.getElementById('parent_id').disabled = false;
                            document.getElementById('parent_id').value = response.parent_id;

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
        document.getElementById('main').addEventListener('change', function() {

            // التحقق مما اذا كان الـ radio button محددا
            if (this.checked) {

                // تعديل خاصية الـ disabled للحقول التي تريد إلغاء تفعيلها
                document.getElementById('parent_id').disabled = true;
                document.getElementById('parent_id').selectedIndex = 0;

            }
        });

        document.getElementById('sub').addEventListener('change', function() {
            // التحقق مما اذا كان الـ radio button محددا
            if (this.checked) {
                // تعديل خاصية الـ disabled للحقول التي تريد إلغاء تفعيلها
                document.getElementById('parent_id').disabled = false;


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
                var result = confirm("هل انت متأكد من الالغاء؟");
                if (result) {
                    var id = document.getElementById('account_id').value;
                    console.log(id);
                    $.ajax({
                        url: "{{ url('client/cost_center/delete_cost_center') }}",
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
                }
            })
    </script>
@endsection
