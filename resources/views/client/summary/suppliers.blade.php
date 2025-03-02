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
                        <h5  class=" alert custom-title">
                            كشف حساب المورد
                        </h5>
                    </div>
                    <div class="clearfix no-print"></div>
                    <hr class="no-print">
                    <form class="parsley-style-1 no-print" id="selectForm2" name="selectForm2"
                        action="{{ route('suppliers.summary.post') }}" enctype="multipart/form-data" method="get"
                        onsubmit="return validateDates()">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="d-block"> اختر المورد <span class="text-danger">*</span></label>
                                <select required name="supplier_id" id="supplier_id" class="form-control"
                                    data-live-search="true" title="اكتب او اختار اسم المورد">
                                    @foreach ($suppliers as $supplier)
                                        <option @if (isset($supplier_k) && $supplier_k->id == $supplier->id) selected @endif
                                            value="{{ $supplier->id }}">{{ $supplier->supplier_name }}</option>
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
                        <div class="col-xs-12 col-sm-12 col-md-12 ">
                            <button class="btn btnn btn-warning py-1 px-3" name="submit" value="all" type="submit">
                                <i class="fa fa-check"></i>
                                عرض كشف الحساب
                            </button>
                            <button class="btn btnn text-white px-3 py-1" style="background-color: #ec6880" name="submit" value="today" type="submit">
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
