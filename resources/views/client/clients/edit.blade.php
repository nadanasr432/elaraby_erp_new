@extends('client.layouts.app-main')
<style>
</style>
@section('content')
    <!-- row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">

            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>الاخطاء :</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card">
                <div class="card-body">
                    <div class="col-lg-12 margin-tb">
                        <div class="d-flex flex-wrap justify-content-between">
                            <h5  class=" alert custom-title">
                                تعديل بيانات المستخدم
                            </h5>
                            <a class="btn btnn text-white py-1 px-3" style="background-color: #ec6880"
                                href="{{ route('client.clients.index') }}">{{ __('main.back') }}</a>
                        </div>
                        
                    </div>
                    <br>
                    <form action="{{ route('client.clients.update', $client->id) }}" method="post">
                        @csrf
                        @method('PATCH')
                        <div class="row mb-3 mt-3">
                            <div class="parsley-input  col-md-4 mb-1" id="fnWrapper">
                                <label> اسم المستخدم : <span class="tx-danger">*</span></label>
                                {{-- {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!} --}}
                                <input type="text" name="name" value="{{ $client->name }}" class="form-control"
                                    required>
                            </div>

                            <div class="parsley-input  col-md-4 mb-1 mg-t-20 mg-md-t-0" id="lnWrapper">
                                <label> البريد الالكترونى : <span class="tx-danger">*</span></label>
                                {{-- {!! Form::text('email', null, ['class' => 'form-control text-left', 'dir' => 'ltr', 'required']) !!} --}}
                                <input type="text" name="email" value="{{ $client->email }}" class="form-control"
                                    required>
                            </div>
                            <div class="parsley-input  col-md-4 mb-1 mg-t-20 mg-md-t-0" id="lnWrapper">
                                <label class="form-label"> الحالة </label>
                                <select name="Status" id="select-beast" class="form-control">
                                    <option value="active" @if ($client->Status == 'active') selected @endif> مفعل
                                    </option>

                                    <option value="blocked" @if ($client->Status == 'blocked') selected @endif> معطل
                                    </option>

                                </select>
                            </div>
                        </div>

                        <div class="row  mb-3 mt-3">
                            <div class="parsley-input   col-md-4 mb-1 mg-t-20 mg-md-t-0" id="lnWrapper">
                                <label> كلمة المرور : <span class="tx-danger">*</span></label>
                                {{-- {!! Form::password('password', ['class' => 'form-control', 'required']) !!} --}}
                                <input type="password" name="password" class="form-control" required>
                            </div>

                            <div class="parsley-input   col-md-4 mb-1 mg-t-20 mg-md-t-0" id="lnWrapper">
                                <label> تأكيد كلمة المرور : <span class="tx-danger">*</span></label>
                                {{-- {!! Form::password('confirm-password', ['class' => 'form-control', 'required']) !!} --}}
                                <input type="password" name="confirm-password" class="form-control" required>
                            </div>
                            <div class="parsley-input   col-md-4 mb-1 mg-t-20 mg-md-t-0" id="lnWrapper">
                                <label> الصلاحية </label>
                                <select name="role_name[]" id="role_name" class="selectpicker form-control py-1"
                                    data-live-search="true"  title="Choose Privileges">
                                    @foreach ($roles as $role)
                                        <option @if (in_array($role, $clientRole)) selected @endif> {{ $role }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="  col-md-4 mb-1 mg-t-20 mg-md-t-0 branch"
                                @if (in_array('مديرالنظام', $client->role_name)) style="display: none" @endif>
                                <label class="form-label"> اختر الفرع </label>
                                <select id="branch_id" data-live-search="true" title="اختر الفرع"
                                    class="form-control selectpicker show-tick py-1" name="branch_id">
                                    @foreach ($branches as $branch)
                                        <option @if ($branch->id == $client->branch_id) selected @endif
                                            value="{{ $branch->id }}">
                                            {{ $branch->branch_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                        <div class="col-lg-12 text-start mt-3 mb-3">
                            <button class="btn btnn btn-warning py-1 px-3" type="submit"> تحديث</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- main-content closed -->
@endsection

<script src="{{ asset('app-assets/js/jquery.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#role_name').on('change', function() {
            var role_name = $(this).val();
            $('#branch_id').val("");
            $('#branch_id').selectpicker('refresh');
            if (role_name != "مدير النظام") {
                $('.branch').show();
            } else {
                $('.branch').hide();
            }
        });
    });
</script>
