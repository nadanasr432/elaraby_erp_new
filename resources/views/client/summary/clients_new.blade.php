@extends('client.layouts.app-main')
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
    @if (session('success'))
        <div class="alert alert-success alert-dismissable fade show">
            <button class="close" data-dismiss="alert" aria-label="Close">×</button>
            {{ session('success') }}
        </div>
    @endif
    
    <div class="row">
        <div class="col-md-12">
            <div class="card mg-b-20">
                <div class="card-body">
                    <div class="col-12 no-print">
                        <h5 style="min-width: 300px;" class="pull-right alert alert-sm alert-success">
                            كشف حساب العميل
                        </h5>
                    </div>
                    <div class="clearfix no-print"></div>
                    <hr class="no-print">
                  <form class="parsley-style-1 no-print" id="selectForm2" name="selectForm2"
                        action="{{ route('clients.summary.post.new') }}" enctype="multipart/form-data" method="get"
                        onsubmit="return validateDates()">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="d-block"> اختر العميل <span class="text-danger">*</span></label>
                                <select required name="outer_client_id" id="outer_client_id" class="selectpicker"
                                    data-style="btn-danger" data-live-search="true" title="اكتب او اختار اسم العميل">
                                    @foreach ($outer_clients as $outer_client)
                                        <option @if (isset($outer_client_k) && $outer_client_k->id == $outer_client->id) selected @endif
                                            value="{{ $outer_client->id }}">{{ $outer_client->client_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="d-block"> من تاريخ <span class="text-danger">*</span></label>
                                <input type="date" @if (isset($from_date) && !empty($from_date)) value="{{ $from_date }}" @endif
                                    class="form-control" name="from_date" />
                            </div>
                            <div class="col-md-4">
                                <label class="d-block"> الى تاريخ <span class="text-danger">*</span></label>
                                <input @if (isset($to_date) && !empty($to_date)) value="{{ $to_date }}" @endif type="date"
                                    class="form-control" name="to_date" />
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button class="btn btn-success pd-x-20" name="submit" value="all" type="submit">
                                <i class="fa fa-check"></i>
                                عرض كشف الحساب
                            </button>
                            <button class="btn btn-info pd-x-20" name="submit" value="today" type="submit">
                                <i class="fa fa-check"></i>
                                كشف حساب اليوم
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
<script>
    function validateDates() {
        const fromDate = document.querySelector('[name="from_date"]').value;
        const toDate = document.querySelector('[name="to_date"]').value;

        if (fromDate && !toDate) {
            alert('يرجى اختيار المده من تاريخ - الى تاريخ .');
            return false;

        }

        if (toDate && !fromDate) {
            alert('يرجى اختيار المده من تاريخ - الى تاريخ .');
            return false;
        }

        return true;
    }
</script>
