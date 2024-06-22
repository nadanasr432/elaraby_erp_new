@extends('client.layouts.app-main')
<style>

</style>
@section('content')
    <div class="company_details printy" style="display: none;">
        <div class="text-center">
            <img class="logo" style="width: 20%;" src="{{ asset($company->company_logo) }}" alt="">
        </div>
        <div class="text-center">
            <div class="col-lg-12 text-center justify-content-center">
                <p class="alert alert-secondary text-center alert-sm"
                   style="margin: 10px auto; font-size: 17px;line-height: 1.9;" dir="rtl">
                    {{ $company->company_name }} -- {{ $company->business_field }} <br>
                    {{ $company->company_owner }} -- {{ $company->phone_number }} <br>
                </p>
            </div>
        </div>
    </div>


    @if (isset($quotation_k) && !empty($quotation_k))
        <h6 class="alert alert-sm alert-danger text-center">
            <i class="fa fa-info-circle"></i>
            بيانات عناصر عرض السعر رقم
            {{ $quotation_k->quotation_number }}
        </h6>
        <div class="col-lg-12 mb-3 printy alert alert-secondary alert-sm">
            <div class="col-4 pull-right">
                اسم العميل :
                {{ $quotation_k->outerClient->client_name }}
            </div>
            <div class="col-4 pull-right">
                تاريخ بدأ العرض :
                {{ $quotation_k->start_date }}
            </div>
            <div class="col-4 pull-right">
                تاريخ انتهاء العرض :
                {{ $quotation_k->expiration_date }}
            </div>
            <div class="clearfix"></div>
        </div>

        <?php
        $tax_value_added = $company->tax_value_added;
        $sum = array();
        if (!$elements->isEmpty()) {
        $i = 0;
        echo "<table class='table table-condensed table-striped table-bordered'>";
        echo "<thead>";
        echo "<th>  # </th>";
        echo "<th> اسم المنتج </th>";
        echo "<th> سعر الوحدة </th>";
        echo "<th> الكمية </th>";
        //echo "<th> الملاحظات </th>";
        echo "<th>  الاجمالى </th>";
        echo "</thead>";
        echo "<tbody>";
        foreach ($elements as $element) {
            array_push($sum, $element->quantity_price);
            echo "<tr>";
            echo "<td>" . ++$i . "</td>";
            echo "<td>" . $element->product->product_name . "</td>";
            echo "<td>" . floatval($element->product_price) . "</td>";
            echo "<td>" . floatval($element->quantity) . " " . $element->unit->unit_name . "</td>";
            //echo "<td>" . $element->quotation->notes . "</td>";
            echo "<td>" . floatval($element->quantity_price) . "</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
        $total = array_sum($sum);
        $percentage = ($tax_value_added / 100) * $total;
        $after_total = $total + $percentage;
        echo "
                <div class='clearfix'></div>
                "; ?>
        @if($quotation_k->notes)
            <div class='alert alert-dark alert-sm text-left'>
                الملاحظات:
                <span class="ml-3">{{$quotation_k->notes}}</span>
            </div>
        @endif
        <?php echo "<div class='alert alert-dark alert-sm text-center before_totals'>
                    <div class='pull-right col-6 '>
                        اجمالى عرض السعر
                        " . floatval($total) . " " . $currency . "
                    </div>
                    <div class='pull-left col-6 '>
                        اجمالى عرض السعر بعد القيمة المضافة
                        " . floatval($after_total) . " " . $currency . "
                    </div>
                    <div class='clearfix'></div>
                </div>";
        echo "
                <div class='clearfix'></div>
                <div class='alert alert-dark alert-sm text-center printy'>";
        foreach ($extras as $key) {
            if ($key->action == "discount") {
                echo "<div class='pull-right col-6 '>";
                if ($key->action_type == "pound") {
                    echo " خصم " . $key->value . " " . $currency;
                } else {
                    echo " خصم " . $key->value . " % ";
                }
                echo "</div>";
            } else {
                echo "<div class='pull-right col-6 '>";
                if ($key->action_type == "pound") {
                    echo " مصاريف شحن " . $key->value . " " . $currency;
                } else {
                    echo " مصاريف شحن " . $key->value . " % ";
                }
                echo "</div>";
            }
        }
        echo "<div class='clearfix'></div>";
        echo "</div>";
        echo "
                <div class='clearfix'></div>
                <div class='col-lg-12 col-md-12 col-sm-12 after_totals'>
                    <div class='alert alert-secondary alert-sm text-center'>
                           اجمالى عرض السعر النهائى بعد الضريبة  والخصم :
                            " . floatval($after_total_all) . " " . $currency . "
                    </div>
                </div>";
        }
        ?>
    @endif




    <script src="{{ asset('app-assets/js/jquery.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            window.print();
            // setTimeout(function(){
            //     window.location.href='quotations';
            // },3500);
        });
    </script>
@endsection
