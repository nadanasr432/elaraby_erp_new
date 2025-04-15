<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <link href="{{ asset('/assets/css/bootstrap.min.css') }}" rel="stylesheet" />
    <style>
        .table {
            margin-bottom: 0%
        }

        .vertical-line {
            border-left: 3px solid black;
            height: 100px;
            margin-right: 15px;
        }

        .right-line {
            display: inline-block;
            padding-right: 10px;
            border-right: 3px solid black;
            height: 100px;
            text-align: end;
            font-weight: bold;
            font-size: 18px;
        }

        .table thead th,
        td {
            vertical-align: middle !important;
            font-weight: 700;
            font-size: 13px;
        }

        th {
            color: #ffb500 !important;
            font-weight: 700 !important;
            font-size: 13px !important;
        }

        .btn {
            font-size: 1.2rem !important;
        }

        .text-container {
            text-decoration: underline !important;
            padding: 10px 0;
        }

        .table thead th {
            border-bottom: 1px solid black;
        }


        .custom-table th {
            font-weight: bold;
        }

        .custom-table td {
            font-size: 20px;
            vertical-align: middle;
            font-weight: 500;
        }

        .table-bordered td,
        .table-bordered tr,
        .table-bordered th {
            border: 1px solid black !important;
        }

        .custom-table td:nth-child(1),
        /* For dotted vertical lines between columns */
        .custom-table th:nth-child(1),
        .custom-table td:nth-child(2),
        .custom-table th:nth-child(2),
        .custom-table td:nth-child(3),
        .custom-table th:nth-child(3),
        .custom-table td:nth-child(4),
        .custom-table th:nth-child(4),
        .custom-table td:nth-child(5),
        .custom-table th:nth-child(5),
        .custom-table td:nth-child(6),
        .custom-table th:nth-child(6),
        .custom-table td:nth-child(7),
        .custom-table th:nth-child(7) {
            border-right: 2px dotted #bfb9b9;
            ;
        }

        .custom-table th:last-child,
        .custom-table td:last-child {
            border-right: none;
        }

        .custom-table tr {
            position: relative;
        }

        .custom-table thead tr::after {
            content: "";
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            border-bottom: 2px dashed #bfb9b9;
        }

        .custom-table tbody tr:last-child td {
            border-bottom: 2px dashed #bfb9b9;

        }

        .custom-table tbody tr:last-child {
            border-bottom: 2px dashed #bfb9b9;
            border-collapse: separate;
        }

        @font-face {
            font-family: 'Cairo';
            src: url({{ asset('fonts/Cairo.ttf') }});
        }

        .invoice-container {
            width: 80%;
            margin: auto;
        }

        .container {
            width: 100%;

        }

        .bordernone {
            border: none !important;
        }

        .border-black {
            border: 2px solid black;
        }

        .right,
        .left {
            width: 49%;
            background: #f8f9fb;
            font-size: 17px;
            border-radius: 2px;
            overflow: hidden;
            font-weight: 400;
        }

        tr {
            border-bottom: 1px solid black !important;
            padding-bottom: 4px !important;
            padding-top: 4px !important;
            font-size: 11px !important;
        }

        .txtheader {
            font-weight: 600;
            font-size: 20px;
        }

        .centerTd {
            font-weight: bold;
        }

        .border2 {
            border: 1px solid #2d2d2d03 !important;
        }

        .header-container {
            height: 180px;
            overflow: hidden;
        }

        .headerImg,
        .footerImg {
            height: 200px;
        }

        .headerImg img,
        .footerImg img {
            height: 100%;
            width: 100%;
            object-fit: scale-down;
        }

        .custom-print-table {
            background-color: #dbdbdb !important;
            border: 1px solid black !important;
        }

        @media print {
            #buttons {
                display: none !important;
            }

            .invoice-container {
                width: 100% !important;
                margin: auto;
            }
        }
    </style>

</head>

<body>
    <div class="text-center" id="buttons">
        <button class="btn  btn-success" onclick="window.print()">@lang('sales_bills.Print the invoice')</button>
        <a class="btn  btn-danger" href="{{ route('transport-policies.index') }}">@lang('sales_bills.back') </a>
        <button class="btn  btn-success" dir="ltr" onclick="sendToWhatsApp()">
            <i class="fa fa-whatsapp"></i>
            @lang('sales_bills.Send to whatsapp')
        </button>
    </div>
    <div class="invoice-container border">
        <div class="container d-flex justify-content-between mt-2 mb-2">
            <div class="col-md-4  d-flex justify-content-end">
                <div class="row">
                    <div class="col-md-12">
                        <span class="right-line d-flex justify-content-end">
                            <br>
                            بوليصة نقل
                            <br>
                            Transport Policy</span>
                    </div>
                </div>
            </div>

            <div class="logo col-md-4 d-flex justify-content-center ">
                <img class="logo" style="object-fit: scale-down;" width="130"
                    src="{{ asset($company->company_logo) }}">
            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="col-12 d-flex justify-content-end text-end">
                        <span>{{ $company->company_name }}</span>
                    </div>
                    <div class="col-12 d-flex justify-content-end text-end">
                        <span>العنوان: <strong>{{ $company->company_address }}</strong></span>
                    </div>
                    <div class="col-12 d-flex justify-content-end text-end">
                        <span>سجل تجاري:<strong
                                class="fw-bold fs-5">{{ $company->civil_registration_number }}</strong></span>
                    </div>
                    <div class="col-12 d-flex justify-content-end text-end">
                        <span>رخصة نقل:<strong class="fw-bold fs-5">{{ $company->transport_license }}</strong></span>
                    </div>
                    <div class="col-12 d-flex justify-content-end text-end">
                        <span>رقم ضريبي:<strong>{{ $company->tax_number }}</strong></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="container d-flex justify-content-between">
            <table class="col-md-4 table table-bordered text-center align-middle">
                <tbody>
                    <tr>
                        <td class="fw-bold text-start w-25"
                            style="background-color:cornflowerblue !important;color:#ffb500">Number/رقم</td>
                        <td class="fw-bold text-start w-25">{{ $policyNumber }}</td>
                    </tr>
                </tbody>
            </table>
            <table class="col-md-4 table table-bordered text-center align-middle">
                <tbody>
                    <tr>
                        <td class="fw-bold text-start w-25">{{ $transportPolicy->created_at->format('Y-m-d') }}</td>
                        <td class="fw-bold text-start w-25"
                            style="background-color:cornflowerblue !important;color:#ffb500">Date/التاريخ</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="container d-flex justify-content-between">
            <table class="col-md-12 table table-bordered text-center align-middle">
                <tbody>
                    <tr>
                        <td class="fw-bold text-start w-25"
                            style="background-color:cornflowerblue !important;color:#ffb500">Customer Name</td>
                        <td class="w-50">{{ $outerClient->client_name }}</td>
                        <td class="fw-bold text-end w-25"
                            style="background-color:cornflowerblue !important;color:#ffb500">اسم العميل</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="container d-flex justify-content-between">
            <table class="col-md-6 table table-bordered text-center align-middle">
                <tr style="background-color:cornflowerblue !important">
                    <th colspan="3" class="fw-bold fs-5" style="background-color:cornflowerblue !important">
                        receiver / المرسل اليه</th>
                </tr>
                <tbody>
                    <tr>
                        <td class="fw-bold text-start w-25">Name</td>
                        <td class="w-50">{{ $transportPolicy->receiver }}</td>
                        <td class="fw-bold text-end w-25">الاسم</td>
                    </tr>
                </tbody>
            </table>
            <table class="col-md-6 table table-bordered text-center align-middle">
                <tr style="background-color:cornflowerblue !important">
                    <th colspan="3" class="fw-bold fs-5" style="background-color:cornflowerblue !important">
                        sender / المرسل </th>
                </tr>
                <tbody>
                    <tr>
                        <td class="fw-bold text-start w-25">Name</td>
                        <td class="w-50">{{ $transportPolicy->sender }}</td>
                        <td class="fw-bold text-end w-25">الاسم</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="container d-flex justify-content-between">
            <table class="col-md-6 table table-bordered text-center align-middle">
                <tr style="background-color:cornflowerblue !important">
                    <th colspan="3" class="fw-bold fs-5" style="background-color:cornflowerblue !important">
                        discharging station /محطة التفريغ</th>
                </tr>
                <tbody>
                    <tr>
                        <td class="fw-bold text-start w-25">Country</td>
                        <td class="w-50">{{ $dischargingStation->country }}</td>
                        <td class="fw-bold text-end w-25">الدولة</td>
                    </tr>
                    <tr>
                        <td class="fw-bold text-start">Region</td>
                        <td>{{ $dischargingStation->region }}</td>
                        <td class="fw-bold text-end">المنطقة</td>
                    </tr>
                    <tr>
                        <td class="fw-bold text-start">City</td>
                        <td>{{ $dischargingStation->city }}</td>
                        <td class="fw-bold text-end">المدينة</td>
                    </tr>
                </tbody>
            </table>
            <table class="col-md-6 table table-bordered text-center align-middle">
                <tr style="background-color:cornflowerblue !important">
                    <th colspan="3" class="fw-bold fs-5" style="background-color:cornflowerblue !important">charging
                        station /محطة الشحن</th>
                </tr>
                <tbody>
                    <tr>
                        <td class="fw-bold text-start w-25">Country</td>
                        <td class="w-50">{{ $chargingStation->country }}</td>
                        <td class="fw-bold text-end w-25">الدولة</td>
                    </tr>
                    <tr>
                        <td class="fw-bold text-start">Region</td>
                        <td>{{ $chargingStation->region }}</td>
                        <td class="fw-bold text-end">المنطقة</td>
                    </tr>
                    <tr>
                        <td class="fw-bold text-start">City</td>
                        <td>{{ $chargingStation->city }}</td>
                        <td class="fw-bold text-end">المدينة</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="container d-flex justify-content-between">
            <table class="col-md-6 table table-bordered text-center align-middle">
                <tr>
                    <th colspan="3" class="fw-bold fs-5" style="background-color:cornflowerblue !important">Driver
                        Information / بيانات السائق</th>
                </tr>
                <tbody>
                    <tr>
                        <td class="fw-bold text-start w-25">Driver name</td>
                        <td class="w-50">{{ $driver->name }}</td>
                        <td class="fw-bold text-end w-25">اسم السائق</td>
                    </tr>
                    <tr>
                        <td class="fw-bold text-start">Iqama number</td>
                        <td>{{ $driver->iqama_number }}</td>
                        <td class="fw-bold text-end">رقم الاقامة</td>
                    </tr>
                    <tr>
                        <td class="fw-bold text-start">Nationality</td>
                        <td>{{ $driver->nationality }}</td>
                        <td class="fw-bold text-end">الجنسية</td>
                    </tr>
                    <tr>
                        <td class="fw-bold text-start">Mobile numder</td>
                        <td>{{ $driver->mobile_number }}</td>
                        <td class="fw-bold text-end">رقم الجوال</td>
                    </tr>
                </tbody>
            </table>
            <table class="col-md-6 table table-bordered text-center align-middle">
                <tr style="background-color:cornflowerblue !important">
                    <th colspan="3" class="fw-bold fs-5" style="background-color:cornflowerblue !important">Shipment
                        Information</th>
                </tr>
                <tbody>
                    <tr>
                        <td class="fw-bold text-start w-25">Payload type</td>
                        <td class="w-50">{{ $shipment->payload_type }}</td>
                        <td class="fw-bold text-end w-25">نوع الحمولة</td>
                    </tr>
                    <tr>
                        <td class="fw-bold text-start">Container no</td>
                        <td>{{ $shipment->containers_no }}</td>
                        <td class="fw-bold text-end">رقم الحاوية</td>
                    </tr>
                    <tr>
                        <td class="fw-bold text-start">Weight</td>
                        <td>{{ $shipment->weight }}</td>
                        <td class="fw-bold text-end">الوزن</td>
                    </tr>
                    <tr>
                        <td class="fw-bold text-start">Height</td>
                        <td>{{ $shipment->height }}</td>
                        <td class="fw-bold text-end">الارتفاع</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="container d-flex justify-content-between">
            <table class="col-md-6 table table-bordered text-center align-middle">
                <tr style="background-color:cornflowerblue !important">
                    <th colspan="3" class="fw-bold fs-5" style="background-color:cornflowerblue !important">
                        Vehicle information / بيانات المركبة </th>
                </tr>
                <tbody>
                    <tr>
                        <td class="fw-bold text-start w-25">Vehicle number</td>
                        <td class="w-50">{{ $vehicle->vehicle_number }}</td>
                        <td class="fw-bold text-end w-25">رقم المركبة</td>
                    </tr>
                    <tr>
                        <td class="fw-bold text-start">Plate Number</td>
                        <td>{{ $vehicle->plate_number }}</td>
                        <td class="fw-bold text-end">رقم اللوحة</td>
                    </tr>
                    <tr>
                        <td class="fw-bold text-start">Trailer type</td>
                        <td>{{ $vehicle->trailer_type }}</td>
                        <td class="fw-bold text-end">نوع المقطورة</td>
                    </tr>
                </tbody>
            </table>
            <table class="col-md-6 table table-bordered text-center align-middle">
                <tr style="background-color:cornflowerblue !important">
                    <th colspan="3" class="fw-bold fs-5" style="background-color:cornflowerblue !important">
                        information owner Vehicle / بيانات مالك المركبة </th>
                </tr>
                <tbody>
                    <tr>
                        <td class="fw-bold text-start w-25">Company name</td>
                        <td class="w-50">{{ $vehicleOwner->company_name }}</td>
                        <td class="fw-bold text-end w-25">اسم الشركة</td>
                    </tr>
                    <tr>
                        <td class="fw-bold text-start">Supervisor</td>
                        <td>{{ $vehicleOwner->supervisor_name }}</td>
                        <td class="fw-bold text-end">اسم المشرف</td>
                    </tr>
                    <tr>
                        <td class="fw-bold text-start">Mobile number</td>
                        <td>{{ $vehicleOwner->mobile_number }}</td>
                        <td class="fw-bold text-end">رقم الجوال</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="container d-flex justify-content-between">
            <table class="col-md-12 table table-bordered text-center align-middle">
                <tr style="background-color:cornflowerblue !important">
                    <th colspan="3" class="fw-bold fs-5" style="background-color:cornflowerblue !important">
                        Receive / الاستلام</th>
                </tr>
                <tr>
                    <th colspan="3" class="fw-bold fs-5 text-dark">I, the undersigned, acknowledge that the
                        shipment has been received in full and in good conditionاقر انا الموقع أدناه بأنه تم استلام
                        الشحنة كاملة وبحالة جيدة</th>
                </tr>
            </table>
        </div>
        <div class="container">
            <table class="table table-sm table-bordered  text-center" style="height: 200px;">
                <tbody>
                    <tr style="font-weight: bold;">
                        <td rowspan="8" class="qr-code">
                            الختم
                        </td>
                        <td>الملاحظات</td>
                    </tr>
                    <tr style="font-weight: bold;">
                        <td></td>

                    </tr>
                    <tr style="font-weight: bold;">
                        <td></td>
                    </tr>
                    <tr style="font-weight: bold;">
                        <td></td>

                    </tr>
                    <tr style="font-weight: bold;">
                        <td></td>

                    </tr style="font-weight: bold;">
                    <tr style="font-weight: bold;">
                        <td></td>
                    </tr>
                    <tr style="font-weight: bold;">
                        <td></td>

                    </tr>
                </tbody>
            </table>
        </div>
        <div class="container">
            <table class="table table-bordered text-center align-middle">
                <tbody>
                    <tr>
                        <td class="fw-bold text-start w-25">Recipient's name</td>
                        <td class="w-50"></td>
                        <td class="fw-bold text-end w-25">اسم المستلم</td>
                    </tr>
                    <tr>
                        <td class="fw-bold text-start">Date</td>
                        <td></td>
                        <td class="fw-bold text-end">التاريخ</td>
                    </tr>
                    <tr>
                        <td class="fw-bold text-start">Recipient's signature</td>
                        <td></td>
                        <td class="fw-bold text-end">توقيع بالاستلام</td>
                    </tr>
                    {{-- <tr>
                        <td class="fw-bold text-start">Stamp</td>
                        <td></td>
                        <td class="fw-bold text-end">الختم</td>
                    </tr> --}}
                </tbody>
            </table>
        </div>
    </div>
</body>
<script src="{{ asset('app-assets/js/jquery.min.js') }}"></script>
{{-- <script>
    function sendToWhatsApp() {
        const clientPhone = '{{ $sale_bill->outerClient->phones[0]->client_phone ?? '-' }}';
        const invoiceUrl = '{{ route('client.sale_bills.sent', [$sale_bill->token, 7, 2, 0]) }}';
        const message = `Please check your invoice at the following link: ${invoiceUrl}`;
        const whatsappUrl = `https://wa.me/${clientPhone}?text=${encodeURIComponent(message)}`;
        setTimeout(() => {
            window.open(whatsappUrl, '_blank');
        }, 1000);
    }
</script> --}}
<script type="text/javascript">
    $('.show_hide_header').on('click', function() {
        $('.headerImg').slideToggle();
    });
    $('.show_hide_footer').on('click', function() {
        $('.footerImg').slideToggle();
    });
</script>

</html>
