@extends('client.layouts.app-main')
<style>
    .bootstrap-select {
        width: 75% !important;
        height: 40px !important;
    }

    .btn {
        height: 40px !important;
    }

    .btn-sm {
        height: 30px !important;
        padding: 5px !important;
    }

    .emptyInput {
        border: 2px solid red !important;
    }
</style>
@section('content')

    <!---CONDITIONS FOR SALEBILLS--->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <!------HEADER----->
                <div class="card-header border-bottom border-secondary p-1">
                    <div class="d-flex justify-content-between align-items-baseline">
                        <h3 class="pull-right font-weight-bold">
                            {{__('sales_bills.termsAndConditionsSaleBills')}}
                        </h3>
                        <a class="btn btn-danger pull-left p-1" href="http://arabygithub.test/ar/client/journal/get">
                            {{__('sales_bills.back')}}
                        </a>
                    </div>
                </div>

                <div class="card-body p-1">
                    <div class="row col-12 p-0 pl-1 ">
                        <div class="col-md-12 pr-0">
                            <label> {{__('sales_bills.termsAndConditionsSaleBills')}} <span class="text-danger">*</span></label>
                            <textarea rows="8" class="form-control saleBillsInput"
                                      placeholder="{{__('sales_bills.termsAndConditionsSaleBills')}}">{!! $policies->sale_bill_condition !!}</textarea>
                        </div>
                        <div class="col-12 text-center pt-2 pr-0 pl-0">
                            <button
                                class="btn btn-success w-100 font-weight-bold updateConditionSaleBills"
                                style="width: 91px !important;float: right;margin-right: 12px;">
                                {{__('sales_bills.update')}}
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!---========================--->

    <!---CONDITIONS FOR SALEBILLS--->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <!------HEADER----->
                <div class="card-header border-bottom border-secondary p-1">
                    <div class="d-flex justify-content-between align-items-baseline">
                        <h3 class="pull-right font-weight-bold">
                            {{__('sales_bills.termsAndConditionsQuotation')}}
                        </h3>
                    </div>
                </div>

                <div class="card-body p-1">
                    <div class="row col-12 p-0 pl-1 ">
                        <div class="col-md-12 pr-0">
                            <label>{{__('sales_bills.termsAndConditionsQuotation')}} <span class="text-danger">*</span></label>
                            <textarea rows="8" class="form-control quotationInput"
                                      placeholder="{{__('sales_bills.termsAndConditionsQuotation')}}">{!! $policies->quotation_condition !!}</textarea>
                        </div>
                        <div class="col-12 text-center pt-2 pr-0 pl-0">
                            <button
                                class="btn btn-success w-100 font-weight-bold updateConditionQuotation"
                                style="width: 91px !important;float: right;margin-right: 12px;">
                                {{__('sales_bills.update')}}
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!---========================--->
@endsection
<script src="{{ asset('app-assets/js/jquery.min.js') }}"></script>
<script>
    $(document).ready(function () {

        $('.saleBillsInput,.quotationInput').summernote({
            height: 150
        });

        //sale bills condition input
        $('.updateConditionSaleBills').on('click', function () {
            var saleBillsInput = $('.saleBillsInput').val();
            /*
            if (saleBillsInput.length === 0) {
                $('.saleBillsInput').addClass('emptyInput');
                return false;
            }
            $('.saleBillsInput').removeClass('emptyInput');
            */
            $.post("{{ route('saleBills.updateConditions') }}", {
                "_token": "{{ csrf_token() }}",
                condition: saleBillsInput
            }, function (data) {
                if (data)
                    Swal.fire({
                        icon: 'success',
                        title: 'تم التحديث بنجاح!',
                        timer: 1200,
                        showConfirmButton: false,

                    })
            });
        });
        //=======================================

        //sale bills condition input
        $('.updateConditionQuotation').on('click', function () {
            var quotationInput = $('.quotationInput').val();
            /*
            if (quotationInput.length === 0) {
                $('.quotationInput').addClass('emptyInput');
                return false;
            }
            $('.quotationInput').removeClass('emptyInput');
            */
            $.post("{{ route('quotation.updateConditions') }}", {
                "_token": "{{ csrf_token() }}",
                condition: quotationInput
            }, function (data) {
                if (data)
                    Swal.fire({
                        icon: 'success',
                        title: 'تم التحديث بنجاح!',
                        timer: 1200,
                        showConfirmButton: false,
                    })
            });
        });
        //=======================================

    });
</script>
