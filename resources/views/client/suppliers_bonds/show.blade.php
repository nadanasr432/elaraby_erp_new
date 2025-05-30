@extends('client.layouts.app-main')
<style>
    table thead tr th,
    table tbody tr td {
        border: inherit !important;
    }

    @media print {
        button {
            display: none !important;
        }
    }
</style>
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card mg-b-20">
                <div class="card-body">
                    <div class="row">
                        {{-- <div class="w-50">
                            <h5 class="mb-4 w-100 alert alert-sm" style="text-align: left; font-size: 22px !important;">
                                {{ __('sidebar.electronic-stamp') }}</h5>
                            <img style="width: 200px; display: block;margin-right: auto; margin-top: 37px; margin-bottom: -12; border-radius: 8px; background: white; padding: 16px; border: 1px solid #c9c7c7;"
                                src="{{ asset('assets/images/electronic_stamps/' . $electronicStamp->img) }}"
                                alt="electronic_stamp">
                        </div> --}}
                        <div class="w-100 mb-2 d-flex flex-column justify-content-center align-items-center">
                            <h5 class="w-100 alert alert-sm text-bold" style="text-align: center; font-size: 22px !important;color: black; font-weight: 600 !important;">
                                {{ __('bonds.bond_for_supplier') }}</h5>
                            <img style="width: 200px; display: block;border-radius: 8px; background: white; padding: 16px; border: 1px solid #c9c7c7;"
                                src="{{ asset($company_data->company_logo) }}" alt="company_logo">
                        </div>
                    </div>
                    <div class="row" style="padding: 12px; border: 1px solid gray; margin: 10px;">
                        <div class="col-6" style="border-left:1px solid gray;">
                            <span
                                style="font-size: 18px !important; color: black; font-weight: 600 !important; margin-left: 11px;@if (Config::get('app.locale') == 'en') float:right; @endif">{{ __('bonds.supplier_name') }}
                                :</span>
                            <span
                                style="font-size: 17px !important;color:color: #5c5858; font-weight: 600;">{{ $supplierBond->supplier }}</span>
                        </div>

                        <div class="col-6">
                            <span
                                style="font-size: 18px !important; color: black; font-weight: 600 !important; margin-left: 11px;">{{ __('bonds.account') }}
                                :</span>
                            <span style="font-size: 17px !important;color: #5c5858; font-weight: 600;">
                                @if ($supplierBond->account == 'النقدية في الخزينة')
                                    كاش
                                @elseif ($supplierBond->account == 'العقد النقدية')
                                    شبكه
                                @elseif ($supplierBond->account == 'حساب البنك الجاري')
                                    تحويل بنكي
                                @else
                                    {{ $supplierBond->account }}
                                @endif
                            </span>
                        </div>
                    </div>

                    <div class="row" style="padding: 12px; border: 1px solid gray; margin: 10px;">
                        <div class="col-6" style="border-left:1px solid gray;">
                            <span
                                style="font-size: 18px !important; color: black; font-weight: 600 !important; margin-left: 11px;">{{ __('bonds.type') }}
                                :</span>
                            <span
                                style="font-size: 17px !important;color: #5c5858; font-weight: 600;">{{ $supplierBond->type }}</span>
                        </div>

                        <div class="col-6">
                            <span
                                style="font-size: 18px !important; color: black; font-weight: 600 !important; margin-left: 11px; @if (Config::get('app.locale') == 'en') float:right; @endif">
                                {{ __('bonds.date') }} :</span>
                            <span
                                style="font-size: 17px !important;color: #5c5858; font-weight: 600;">{{ $supplierBond->date }}</span>
                        </div>
                    </div>

                    <div class="row" style="padding: 12px; border: 1px solid gray; margin: 10px;">
                        <div class="col-6" style="border-left:1px solid gray;">
                            <span
                                style="font-size: 18px !important; color: black; font-weight: 600 !important; margin-left: 11px;@if (Config::get('app.locale') == 'en') float:right; @endif">{{ __('bonds.amount') }}
                                :</span>
                            <span
                                style="font-size: 17px !important;color: #5c5858; font-weight: 600;">{{ $supplierBond->amount }}</span>
                        </div>
                        <div class="col-6" style="border-left:1px solid gray;">
                            <span
                                style="font-size: 18px !important; color: black; font-weight: 600 !important; margin-left: 11px;@if (Config::get('app.locale') == 'en') float:right; @endif">{{ __('bonds.notes') }}
                                :</span>
                            <span style="font-size: 17px !important;color: #5c5858; font-weight: 600;">
                                @if ($supplierBond->notes != '')
                                    {{ $supplierBond->notes }}
                                @else
                                    --
                                @endif
                            </span>
                        </div>
                    </div>

                    <div class="row" style="margin: 10px;">
                        <button onclick="printThisPage()"
                            style="border-color: #ff4961 !important; background-color: #ff4961 !important; color: #FFFFFF; font-weight: bold; font-size: 15px !important;"
                            class="w-50 btn btn-info pd-x-20" type="submit">{{ __('bonds.print') }}</button>

                        <button id="backk"
                            onclick="window.location.href='https://elaraby-erp.net/ar/client/suppliers-bonds/index'"
                            style="border-color: #2C303B !important; background-color: #2C303B !important; color: #FFFFFF; font-weight: bold; font-size: 15px !important;"
                            class="w-50 btn btn-info pd-x-20" type="submit">{{ __('bonds.back') }}</button>
                    </div>
                    <div class="row">
                        <div class="col-6 d-flex flex-column justify-content-start align-items-start" style="text-align: start;">
                            <h5 class="alert alert-sm" style="text-align: start; font-size: 22px !important;">
                                {{ __('sidebar.electronic-stamp') }}
                            </h5>
                            <img style="width: 200px; display: block; border-radius: 8px; background: white; padding: 16px; border: 1px solid #c9c7c7;"
                                src="{{ asset('assets/images/electronic_stamps/' . $electronicStamp->img) }}"
                                alt="electronic_stamp">
                        </div>
                        <div class="col-6" style="text-align:start;">
                            <span
                                style="font-size: 18px !important; color: black; font-weight: 600 !important;">توقيع:</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script src="{{ asset('app-assets/js/jquery.min.js') }}"></script>
<script>
    function printThisPage() {
        window.print();
    }
</script>
