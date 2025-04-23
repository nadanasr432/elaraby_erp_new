
<?php
$company = \App\Models\Company::FindOrFail($itemsInSaleBillReturn[0]->company_id);
?>
<!DOCTYPE html>
<html>

<head>
    <title>
          @if (!empty($itemsInSaleBillReturn[0]->outer_client_id))
            <?php
            echo $itemsInSaleBillReturn[0]->OuterClient->client_name . ' - فاتورة رقم ' . $itemsInSaleBillReturn[0]->bill->company_counter; ?>
        @else
            <?php echo 'فاتورة مرتجع' . ' - فاتورة رقم ' . $itemsInSaleBillReturn[0]->bill->company_counter; ?>
        @endif
    </title>
    <meta charset="utf-8" />
    <link href="{{ asset('/assets/css/bootstrap.min.css') }}" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <style type="text/css" media="screen">
        @font-face {
            font-family: 'Cairo';
            src: url({{ asset('fonts/Cairo.ttf') }});
        }

        .btn {
            font-size: 1.2rem !important;
        }

        .invoice-container {
            width: 80%;
            margin: auto;
        }

        .bordernone {
            border: none !important;
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
            border-bottom: 1px solid #2d2d2d20 !important;
            padding-bottom: 4px !important;
            padding-top: 4px !important;
            font-size: 18px !important;
        }

        .txtheader {
            font-weight: 700;
            font-size: 28px;
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
    </style>
    <style type="text/css" media="print">
        #buttons {
            display: none !important;
        }

        .right,
        .left {
            background: #f2f2f2 !important;
            width: 48%;
            font-size: 17px !important;
            border-radius: 2px;
            overflow: hidden;
            font-weight: 400;
        }

        tr {
            border-bottom: 1px solid #2d2d2d20 !important;
            padding-bottom: 10px !important;
            padding-top: 10px !important;
        }

        .txtheader {
            font-weight: 700;
            font-size: 28px;
        }

        .tete>* {
            text-align: right !important;
        }
    </style>
</head>

<body>
    @php
        $company = \App\Models\Company::FindOrFail($itemsInSaleBillReturn[0]->company_id);
        $companyId = Auth::user()->company_id;
        $currentColor = \App\Services\SettingsService::getSettingValue($companyId, 'color', 'print4', '#222751');
        // If the form was submitted, set the color in the settings
        if (request()->isMethod('post')) {
            if (Auth::check()) {
                $color = request('page_color', '#222751'); // Default to white if no color is selected
                // Call the setSetting function directly in Blade
                \App\Services\SettingsService::setSetting($companyId, 'color', $color, 'print4');
            } else {
                // Optionally, handle unauthenticated users if needed (e.g., redirect or show an error message)
                return redirect()->route('login'); // Redirect to login or show an error
            }
            $currentColor = \App\Services\SettingsService::getSettingValue($companyId, 'color', 'print4', '#222751');
        }

        // Get the current page color from the settings

    @endphp
    <div class="invoice-container border mt-4">
        <div class="text-center" id="buttons">
            <button class="btn  btn-success" onclick="window.print()">@lang('sales_bills.Print the invoice')</button>
            <a class="btn  btn-danger" href="{{ route('client.sale_bills.create1') }}">@lang('sales_bills.back') </a>
            <button class="show_hide_header btn  btn-warning no-print" dir="ltr">
                <i class="fa fa-eye-slash"></i>
                @lang('sales_bills.Show or hide the header')
            </button>
            <button class="show_hide_footer btn  btn-primary no-print" dir="ltr">
                <i class="fa fa-eye-slash"></i>
                @lang('sales_bills.Show or hide the footer')
            </button>
            <button class="btn  btn-success" dir="ltr" onclick="sendToWhatsApp()">
                <i class="fa fa-whatsapp"></i>
                @lang('sales_bills.Send to whatsapp')
            </button>
            <div class="col-md-3">
                <div class="card shadow-sm border-light rounded p-3 mb-3">
                    <button type="button" class="btn  btn-primary rounded-pill shadow-sm w-100" data-bs-toggle="modal"
                        data-bs-target="#colorModal"
                        style="border-color: {{ old('page_color', $currentColor ?? '#222751') }}; background-color: {{ old('page_color', $currentColor ?? '#222751') }};">
                        @lang('main.Choose Print Color')
                    </button>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="colorModal" tabindex="-1" aria-labelledby="colorModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="colorModalLabel">@lang('main.Select Print Color')</h5>
                            <button type="button" class="btn btn-close" data-bs-dismiss="modal"
                                aria-label="Close">X</button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ url()->current() }}">
                                @csrf
                                <div class="mb-3 text-center">
                                    <input type="color" class="form-control form-control-color mx-auto"
                                        id="page_color" name="page_color"
                                        value="{{ old('page_color', $currentColor ?? '#222751') }}"
                                        title="Choose your color" style="width: 120px; height: 40px; cursor: pointer;">
                                </div>
                                <button type="submit" class="btn btn-secondary">@lang('main.save')</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="all-data" style="border-top: 1px solid #2d2d2d20;padding-top: 25px;">

            @if (!empty($company->basic_settings->header))
                <div class="headerImg">
                    <img class="img-footer" src="{{ asset($company->basic_settings->header) }}" />
                </div>
            @endif
           
            @if (app()->getLocale() == 'en')
                <div class="header-container d-flex align-items-center">
                    <div class="logo">
                        <img class="logo" style="object-fit: scale-down;" width="204"
                            src="{{ asset($company->company_logo) }}">
                    </div>
                      
                    <div class="txtheader mx-auto text-center">
                       @if (!empty($itemsInSaleBillReturn[0]->outer_client_id))
                                فاتورة مرتجع رقم
                                {{ $itemsInSaleBillReturn[0]->bill->company_counter }}
                        @else                         
                                فاتورة مرتجع رقم
                                {{ $itemsInSaleBillReturn[0]->bill->company_counter }}                         
                        @endif
                    </div>

                    <div class="qrcode ">
                        {!! SimpleSoftwareIO\QrCode\Facades\QrCode::size(80)->generate(Request::url()) !!}
                       

                        <!--<img width="200"-->
                        <!--    src="{{ asset($company->basic_settings->electronic_stamp) }}" />-->
                    </div>


                </div>
            @else
                <div class="header-container d-flex align-items-center">

                    <div class="qrcode ">
                        {!! SimpleSoftwareIO\QrCode\Facades\QrCode::size(80)->generate(Request::url()) !!}
                       

                        <!--<img width="200"-->
                        <!--    src="{{ asset($company->basic_settings->electronic_stamp) }}" />-->
                    </div>
                    <div class="txtheader mx-auto text-center">
                       @if (!empty($itemsInSaleBillReturn[0]->outer_client_id))
                            
                                فاتورة مرتجع رقم
                                {{ $itemsInSaleBillReturn[0]->bill->company_counter }}
                           
                        @else
                          
                                فاتورة مرتجع رقم
                                {{ $itemsInSaleBillReturn[0]->bill->company_counter }}
                           
                        @endif
                    </div>

                    <div class="logo">
                        <img class="logo" style="object-fit: scale-down;" width="204"
                            src="{{ asset($company->company_logo) }}">
                    </div>

                </div>
            @endif
            <hr class="mt-1 mb-2">
                <div class="products-details" style="padding: 0px 18px;">
                    <table
                        style="width: 100%;width: 100%; border-radius: 8px !important; overflow: hidden; border: 1px solid;box-shadow: rgb(99 99 99 / 20%) 0px 2px 0px 0px;">
                        <thead style="font-size:18px !important;">
                            <tr
                                style="font-size:18px !important; background:{{ $currentColor }}; color: white; height: 44px !important; text-align: center;">
                                <th>@lang('sales_bills.Release Date')</th>
                                <th>@lang('sales_bills.invoice number')</th>
                                <th>@lang('sales_bills.commercial register')</th>

                            </tr>
                        </thead>
                        <tbody style="font-size:18px !important;">

                            <tr class="even"
                                style="font-size:18px !important; height: 40px !important; text-align: center;">
                                <td>{{ $itemsInSaleBillReturn[0]->date }}</td>
                                <td>               
                                    {{ $itemsInSaleBillReturn[0]->bill->company_counter }}
                                </td>
                                <td>{{ $company->civil_registration_number }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
          
                <!------------FIRST ROW----------------->
                <div class="invoice-information row justify-content-around mt-3" style=" padding: 0px 24px;">
                    <div class="col-12 pr-2 pl-2">
                        <table style="width: 100%;">
                            <tr class="d-flex pt-1"
                                style="background:{{ $currentColor }}; color: white; font-size: 16px;border-radius: 7px 7px 0 0;padding: 8px !important;">

                                <td width="50%" class="text-left pr-2">@lang('sales_bills.invoice from')</td>
                                <td width="50%" class="text-left pr-2">@lang('sales_bills.Customer data')</td>
                            </tr>
                        </table>
                    </div>
                    <div class="right pr-2 pl-2"
                        style="border-left: 1px solid #2d2d2d2d !important;border-bottom: 1px solid #25252525;left: -5px;">
                        <table style="width: 100%;">
                            <tr class="d-flex bordernone">

                                <td width="40%" class="text-left">@lang('main.name')</td>
                                <td width="60%" class="text-right">{{ $company->company_name }}</td>
                            </tr>
                            <tr class="d-flex pt-1 bordernone">

                                <td width="40%" class="text-left">@lang('sales_bills.Tax Number') </td>
                                <td width="60%" class="text-right">{{ $company->tax_number ?? '-' }}</td>
                            </tr>
                            <tr class="d-flex pt-1 bordernone">

                                <td width="40%" class="text-left">@lang('sales_bills.phone')</td>
                                <td width="60%" class="text-right">{{ $company->phone_number ?? '-' }}</td>
                            </tr>
                            <tr class="d-flex pt-1 bordernone">

                                <td width="40%" class="text-left">@lang('sales_bills.address')</td>
                                <td width="60%" class="text-right">
                                    {{ $company->company_address ?? '-' }}
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="left pr-2 pl-2"
                        style="right: -5px;position:relative;border-bottom: 1px solid #25252525;">
                        @if (!empty($itemsInSaleBillReturn[0]->outer_client_id))
                            <table style="width: 100%;">
                                <tr class="d-flex bordernone">

                                    <td width="40%" class="text-left">@lang('sales_bills.client-name')</td>
                                    <td width="60%" class="text-right centerTd">
                                        {{ $itemsInSaleBillReturn[0]->OuterClient->client_name }}
                                    </td>
                                </tr>
                                <tr class="d-flex pt-1 bordernone">

                                    <td width="40%" class="text-left">@lang('sales_bills.Tax Number')</td>
                                    <td width="60%" class="text-right">
                                       {{ $itemsInSaleBillReturn[0]->OuterClient->tax_number }}</td>
                                </tr>
                                <tr class="d-flex pt-1 bordernone">

                                    <td width="40%" class="text-left">@lang('sales_bills.phone')</td>
                                    <td width="60%" class="text-right">
                                         @if (!empty($itemsInSaleBillReturn[0]->OuterClient->phones[0]))
                                                {{ $itemsInSaleBillReturn[0]->OuterClient->phones[0]->client_phone }}
                                            @endif
                                        </td>
                                </tr>
                                <tr class="d-flex pt-1 bordernone">

                                    <td width="40%" class="text-left">@lang('sales_bills.address')</td>
                                    <td width="60%" class="text-right">
                                         @if (!empty($itemsInSaleBillReturn[0]->OuterClient->addresses[0]))
                                                {{ $itemsInSaleBillReturn[0]->OuterClient->addresses[0]->client_address }}
                                            @endif
                                        </td>
                                </tr>
                            </table>
                        @endif
                    </div>


                </div>
           
            <!-------------------------------------->
                <div class="products-details mt-2" style=" padding: 0px 16px;">
                    <table class="invoice-information"
                        style="width: 100%;background:#222751; border-radius: 8px !important; overflow: hidden;box-shadow: rgb(99 99 99 / 20%) 0px 2px 0px 0px;">
                        <thead>
                            <tr
                                style="font-size:18px !important; background:{{ $currentColor }}; color: white; height: 44px !important; text-align: center;">          
                                <td >م</td>
                                <td >الصنف</td>
                                <td >سعر الوحدة</td>
                                <td >عدد المرتجع</td>
                                <td >الاجمالي</td>
                                <td >الاجمالي شامل الضريبة
                                </td>
                                <td >التاريخ</td>
                            </tr>

                        </thead>
                        <tbody style="font-size: 14px !important;">
                           @php
                                    $i = 0;
                                    $total = 0;
                                    $totalTax = 0;
                                @endphp
                                @foreach ($itemsInSaleBillReturn as $item)

                                    <tr
                                        style="font-size:18px !important; height: 34px !important; text-align: center; background: #f8f9fb">
                                      <td>{{ ++$i }}</td>
                                        <td>{{ $item->product->product_name }}</td>
                                        <td>{{ $item->product_price }}</td>
                                        <td>{{ $item->return_quantity }}</td>
                                        <td>{{ $item->quantity_price }}</td>
                                        <td>
                                            <?php
                                            if ($taxOption == 1) {
                                                $total += $item->quantity_price;
                                                $totalTax += $item->quantity_price - ($item->quantity_price * 20) / 23;
                                                echo $item->quantity_price;
                                            } else {
                                                $totalTax += ($item->quantity_price * 15) / 100;
                                                $prodTotalPrice = $item->quantity_price + ($item->quantity_price * 15) / 100;
                                                $total += $prodTotalPrice;
                                                echo $prodTotalPrice;
                                            }
                                            ?>
                                        </td>
                                        <td>{{ $item->date }}</td>
                                    </tr>
                                @endforeach
                            
                        </tbody>

                    </table>
                </div>
        
  
        
                <div class="row px-4 pt-2 d-flex justify-content-between">

                    <div class="products-details p-0 col-6"
                        style="border: 1px solid #2d2d2d1c; border-radius: 7px; overflow: hidden; box-shadow: rgb(149 157 165 / 20%) 0px 8px 24px;">
                        <table
                            style="width: 100%;width: 100%; border-radius: 8px !important; overflow: hidden; border: 1px solid;box-shadow: rgb(99 99 99 / 20%) 0px 2px 0px 0px;">
                                <tr
                                    style="border-bottom:1px solid #2d2d2d30;font-weight: bold;font-size:16px !important; height: 37px !important; text-align: center;background: #f8f9fb">

                                    <td style="text-align: left;padding-right: 14px;">@lang('sales_bills.tax')</td>
                                    <td dir="rtl">
                                     
                                        {{ round($totalTax, 3) }}
                                         <img src="{{ asset('images/Sr_coin.svg') }}" width="15px">
                                    </td>
                                </tr>
                            <tr
                                style="border-bottom:1px solid #2d2d2d30;font-weight: bold;font-size:16px !important; height: 37px !important; text-align: center;background: #f8f9fb">
                                <td style="text-align: left;padding-right: 14px;">@lang('sales_bills.Total, excluding tax')</td>
                                <td dir="rtl">
                                {{ round($total, 3) }}
                                    <img src="{{ asset('images/Sr_coin.svg') }}" width="15px">
                                </td>
                            </tr>
                        </table>
                    </div>

                </div>
          
            <br>
            @if (!empty($company->basic_settings->footer))
                <div class="footerImg">
                    <img class="img-footer" src="{{ asset($company->basic_settings->footer) }}" />
                </div>
                <br>
            @endif
        </div>
    </div>

</body>
<script src="{{ asset('app-assets/js/jquery.min.js') }}"></script>

<script type="text/javascript">
    $('.show_hide_header').on('click', function() {
        $('.headerImg').slideToggle();
    });
    $('.show_hide_footer').on('click', function() {
        $('.footerImg').slideToggle();
    });
</script>

</html>