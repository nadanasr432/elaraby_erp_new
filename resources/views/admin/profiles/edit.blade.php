@extends('admin.layouts.app-main')
<!-- Internal Data table css -->
<style>

    [role='combobox'] {
        left: -90px !important;
        width: 220px;
    }
</style>

@section('content')
    @if (session('success'))

        <div class="alert alert-success alert-dismissable fade show">
            <button class="close" data-dismiss="alert" aria-label="Close">×</button>
            {{ session('success') }}
        </div>
    @endif

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

    <!-- row -->
    <div id="form-control-repeater">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" style="font-family: 'Cairo';" id="tel-repeater">البيانات الاساسية</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-h font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a data-action="collapse"><i class="la la-minus"></i></a></li>
                                <li><a data-action="reload"><i class="la la-refresh"></i></a></li>
                                <li><a data-action="expand"><i class="la la-expand"></i></a></li>
                                <li><a data-action="close"><i class="la la-close"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body">
                            {!! Form::model($user, ['method' => 'PATCH','class'=> 'row','route' => ['admin.profile.update', Auth::user()->id ]]) !!}
                            <div class="form-group col-md-6 mb-2">
                                <label for=""> الاسم </label>
                                <input type="text" class="form-control" required value="{{ Auth::user()->name }}"
                                       placeholder="الاسم" name="name">
                            </div>
                            <div class="form-group col-md-6 mb-2">
                                <label for=""> البريد الالكترونى </label>
                                <input type="text" class="form-control text-left" dir="ltr" required
                                       value="{{ Auth::user()->email }}" placeholder="البريد الالكترونى" name="email">
                            </div>

                            <div class="form-group col-md-6 mb-2">
                                <label for="">كلمة المرور</label>
                                <input type="password" class="form-control" style="text-align: left;" dir="ltr" required
                                       placeholder="كلمة المرور" name="password">
                            </div>
                            <div class="form-group col-md-6 mb-2">
                                <label for=""> تاكيد كلمة المرور </label>
                                <input type="password" class="form-control" style="text-align: left;" dir="ltr" required
                                       placeholder="تاكيد كلمة المرور" name="confirm-password">
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="col-lg-12 text-center">
                                <button type="reset" name="reset" class="btn btn-info btn-sm">
                                    <i class="la la-refresh"></i> اعادة ضبط
                                </button>
                                <button type="submit" name="submit" class="btn btn-success btn-sm">
                                    <i class="la la-check"></i> تحديث البيانات
                                </button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" style="font-family: 'Cairo';" id="tel-repeater"> البيانات الشخصية </h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-h font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a data-action="collapse"><i class="la la-minus"></i></a></li>
                                <li><a data-action="reload"><i class="la la-refresh"></i></a></li>
                                <li><a data-action="expand"><i class="la la-expand"></i></a></li>
                                <li><a data-action="close"><i class="la la-close"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body">
                            {!! Form::model($user, ['method' => 'PATCH','class'=> 'row','enctype' => 'multipart/form-data','route' => ['admin.profile.store', Auth::user()->id ]]) !!}


                            <div class="col-md-6" id="lnWrapper">
                                <label> النوع : <span class="text-danger">*</span></label>
                                <select required name="gender" id="select-beast" class="form-control">
                                    <option value="">حدد النوع</option>
                                    <option @if($profile->gender == "male")
                                            selected
                                            @endif value="male">ذكر
                                    </option>
                                    <option @if($profile->gender == "female")
                                            selected
                                            @endif value="female">انثى
                                    </option>
                                    <option @if($profile->gender == "other")
                                            selected
                                            @endif value="other">اخرى
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-6" id="lnWrapper">
                                <label class="form-label d-block"> العمر <span class="text-danger">*</span></label>
                                <input value="{{$profile->age}}" type="text" min="1" required max="100" name="age"
                                       class="form-control">
                            </div>

                            <div class="col-md-6" id="lnWrapper">
                                <label class="form-label d-block"> المدينة او البلد <span
                                        class="text-danger">*</span></label>
                                <input value="{{$profile->city_name}}" type="text" required name="city_name"
                                       class="form-control">
                            </div>

                            <div class="col-lg-6 mb-2">
                                <label for=""> الصورة الشخصية </label>
                                <input accept=".jpg,.png,.jpeg" type="file" oninput="pic.src=window.URL.createObjectURL(this.files[0])" id="file"
                                       name="profile_pic" class="form-control">
                            </div>
                            <div class="col-lg-12 text-center mb-2">
                                <label for="" class="d-block"> معاينة الصورة </label>
                                <img id="pic" src="{{asset($profile->profile_pic)}}"
                                     style="width: 100px; height:100px;"/>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="col-lg-12 text-center">
                                <button type="reset" name="reset" id="reset-btn" class="btn btn-info btn-sm">
                                    <i class="la la-refresh"></i> اعادة ضبط
                                </button>
                                <button type="submit" name="submit" class="btn btn-success btn-sm">
                                    <i class="la la-check"></i> تحديث البيانات
                                </button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <script src="{{ asset('app-assets/js/jquery.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#reset-btn').on('click', function () {
                var $image = $('#pic');
                $image.removeAttr('src').replaceWith($image.clone());
            });
        });
    </script>
@endsection

