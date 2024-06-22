@extends('admin.layouts.app-main')
<style>

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
                        <a class="btn btn-primary btn-sm pull-left" href="{{ route('admin.packages.index') }}">
                            عودة
                            للخلف</a>
                        <h5 style="min-width: 300px;" class="pull-right alert alert-sm alert-success">
                            اضافة باقة جديدة
                        </h5>
                    </div>
                    <div class="clearfix"></div>
                    <br>

                    <form class="parsley-style-1" id="selectForm2" name="selectForm2"
                          action="{{route('admin.packages.store','test')}}" enctype="multipart/form-data"
                          method="post">
                        {{csrf_field()}}
                        <h5 class="col-lg-12 d-block mb-2">البيانات الاساسية</h5>
                        <hr>
                        <div class="row mb-1">
                            <div class="col-lg-4 pull-right">
                                <div class="form-group">
                                    <label> اسم الباقة <span class="text-danger">*</span></label>
                                    <input dir="rtl" required class="form-control" name="package_name" type="text">
                                </div>
                            </div>
                            <div class="col-lg-4 pull-right">
                                <div class="form-group">
                                    <label> عدد المستخدمين <span class="text-danger">*</span></label>
                                    <span class="d-inline pull-left">
                                        <input type="checkbox" class="check"/>
                                        غير محدود
                                    </span>
                                    <input required class="form-control" dir="ltr" name="users_count" type="text">
                                </div>
                            </div>
                            <div class="col-lg-4 pull-right">
                                <div class="form-group">
                                    <label> عدد الموظفين <span class="text-danger">*</span></label>
                                    <span class="d-inline pull-left">
                                        <input type="checkbox" class="check"/>
                                        غير محدود
                                    </span>
                                    <input required class="form-control" dir="ltr" name="employees_count" type="text">
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-lg-4 pull-right">
                                <div class="form-group">
                                    <label> عدد العملاء <span class="text-danger">*</span></label>
                                    <span class="d-inline pull-left">
                                        <input type="checkbox" class="check"/>
                                        غير محدود
                                    </span>
                                    <input required class="form-control" dir="ltr" name="outer_clients_count"
                                           type="text">
                                </div>
                            </div>
                            <div class="col-lg-4 pull-right">
                                <div class="form-group">
                                    <label> عدد الموردين <span class="text-danger">*</span></label>
                                    <span class="d-inline pull-left">
                                        <input type="checkbox" class="check"/>
                                        غير محدود
                                    </span>
                                    <input required class="form-control" dir="ltr" name="suppliers_count" type="text">
                                </div>
                            </div>
                            <div class="col-lg-4 pull-right">
                                <div class="form-group">
                                    <label> عدد الفواتير <span class="text-danger">*</span></label>
                                    <span class="d-inline pull-left">
                                        <input type="checkbox" class="check"/>
                                        غير محدود
                                    </span>
                                    <input required class="form-control" dir="ltr" name="bills_count" type="text">
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-lg-4 pull-right">
                                <div class="form-group">
                                    <label for="">شاشة المنتجات بفروعها</label>
                                    <select name="products" required class="form-control">
                                        <option value="">اختر هل تظهر ام لا ؟</option>
                                        <option value="1"> تظهر</option>
                                        <option value="0"> لا تظهر</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 pull-right">
                                <div class="form-group">
                                    <label for="">شاشة الديون بفروعها</label>
                                    <select name="debt" required class="form-control">
                                        <option value="">اختر هل تظهر ام لا ؟</option>
                                        <option value="1"> تظهر</option>
                                        <option value="0"> لا تظهر</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 pull-right">
                                <div class="form-group">
                                    <label for="">شاشة البنوك والخزن بفروعها</label>
                                    <select name="banks_safes" required class="form-control">
                                        <option value="">اختر هل تظهر ام لا ؟</option>
                                        <option value="1"> تظهر</option>
                                        <option value="0"> لا تظهر</option>
                                    </select>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-lg-4 pull-right">
                                <div class="form-group">
                                    <label for="">شاشة المبيعات بفروعها</label>
                                    <select name="sales" required class="form-control">
                                        <option value="">اختر هل تظهر ام لا ؟</option>
                                        <option value="1"> تظهر</option>
                                        <option value="0"> لا تظهر</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 pull-right">
                                <div class="form-group">
                                    <label for="">شاشة المشتريات بفروعها</label>
                                    <select name="purchases" required class="form-control">
                                        <option value="">اختر هل تظهر ام لا ؟</option>
                                        <option value="1"> تظهر</option>
                                        <option value="0"> لا تظهر</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 pull-right">
                                <div class="form-group">
                                    <label for="">شاشة الماليات بفروعها</label>
                                    <select name="finance" required class="form-control">
                                        <option value="">اختر هل تظهر ام لا ؟</option>
                                        <option value="1"> تظهر</option>
                                        <option value="0"> لا تظهر</option>
                                    </select>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-lg-3 pull-right">
                                <div class="form-group">
                                    <label for="">شاشة التسويق بفروعها</label>
                                    <select name="marketing" required class="form-control">
                                        <option value="">اختر هل تظهر ام لا ؟</option>
                                        <option value="1"> تظهر</option>
                                        <option value="0"> لا تظهر</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 pull-right">
                                <div class="form-group">
                                    <label for="">شاشة دفتر اليومية</label>
                                    <select name="accounting" required class="form-control">
                                        <option value="">اختر هل تظهر ام لا ؟</option>
                                        <option value="1"> تظهر</option>
                                        <option value="0"> لا تظهر</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 pull-right">
                                <div class="form-group">
                                    <label for="">شاشة التقارير بفروعها</label>
                                    <select name="reports" required class="form-control">
                                        <option value="">اختر هل تظهر ام لا ؟</option>
                                        <option value="1"> تظهر</option>
                                        <option value="0"> لا تظهر</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 pull-right">
                                <div class="form-group">
                                    <label for="">شاشة الضبط بفروعها</label>
                                    <select name="settings" required class="form-control">
                                        <option value="">اختر هل تظهر ام لا ؟</option>
                                        <option value="1"> تظهر</option>
                                        <option value="0"> لا تظهر</option>
                                    </select>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button class="btn btn-info pd-x-20" type="submit">اضافة</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

<script src="{{asset('app-assets/js/jquery.min.js')}}"></script>
<script>
    $(document).ready(function () {
        $('.check').on('click', function () {
            if(this.checked){
                $(this).parent().parent().find('input[type="text"]').val('غير محدود').attr('readonly',true);
            }
            else{
                $(this).parent().parent().find('input[type="text"]').val('').attr('readonly',false);
            }
        });
    });
</script>
