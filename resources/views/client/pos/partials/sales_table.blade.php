<div class="table-responsive">
    <table class="defaultTableMain table table-condensed table-striped table-bordered text-center table-hover" id="example-table">
        <thead>
            <tr>
                <th class="text-center">{{ __('pos.invoice-number') }}</th>
                <th class="text-center">{{ __('pos.client-name') }}</th>
                <th class="text-center">{{ __('pos.invoice-date') }}</th>
                <th class="text-center">{{ __('pos.invoice-status') }}</th>
                <th class="text-center">{{ __('main.amount') }}</th>
                <th class="text-center">{{ __('main.paid-amount') }}</th>
                <th class="text-center">{{ __('main.remaining-amount') }}</th>
                <th class="text-center">{{ __('main.taxes') }}</th>
                <th class="text-center">{{ __('main.items') }}</th>
                <th class="text-center">{{ __('main.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @php
                $sum1 = 0; // total-invoices-including-tax
                $sum2 = 0; // main.paid-amount
                $sum3 = 0; // total-tax-for-all-invoices
                $totalCash = 0; // total-cash
                $totalBank = 0; // total-bank
            @endphp

            @foreach ($pos_sales as $pos)
                @php
                    $totalAmount = $pos->total_amount;
                    $totalPaid = 0;
                    $restAmount = $totalAmount;
                    $bill_id = 'pos_' . $pos->id;
                    $cash = App\Models\Cash::where('bill_id', $bill_id)->first();
                    $bankCash = App\Models\BankCash::where('bill_id', $bill_id)->first();
                @endphp
                <tr>
                    <td>{{ $pos->company_counter }}</td>
                    <td>{{ $pos->outerClient->client_name ?? 'زبون' }}</td>
                    <td>{{ explode(' ', $pos->created_at)[0] }}</td>
                    <td>
                        @if ($cash)
                            @php $totalCash += $cash->amount; @endphp
                            مدفوعة كاش
                        @elseif ($bankCash)
                            @php $totalBank += $bankCash->amount; @endphp
                            مدفوعة شيك بنكى
                        @else
                            غير مدفوعة - دين على العميل
                        @endif
                    </td>
                    <td>{{ number_format($totalAmount, 2) }}</td>
                    <td>
                        @if ($cash)
                            @php
                                $totalPaid = $cash->amount;
                                $restAmount = $totalAmount - $totalPaid;
                                $sum2 += $totalPaid;
                            @endphp
                            {{ number_format($totalPaid, 2) }}
                        @elseif ($bankCash)
                            @php
                                $totalPaid = $bankCash->amount;
                                $restAmount = $totalAmount - $totalPaid;
                                $sum2 += $totalPaid;
                            @endphp
                            {{ number_format($totalPaid, 2) }}
                        @else
                            @php $sum2 += 0; @endphp
                            0
                        @endif
                    </td>
                    <td>{{ number_format($restAmount, 2) }}</td>
                    <td>
                        @php
                            $tax_amount = $pos->value_added_tax == 1
                                ? $pos->total_amount - ($pos->total_amount / 1.15)
                                : $pos->tax_amount;
                            $sum3 += $tax_amount;
                        @endphp
                        {{ number_format($tax_amount, 2) }}
                    </td>
                    <td>{{ $pos->elements->count() }}</td>
                    <td>
                        <a href="{{ route('pos.open.print', $pos->id) }}" class="btn btn-sm btn-primary" title="{{ __('pos.print-invoice') }}">
                            <i class="fa fa-print"></i> {{ __('pos.print') }}
                        </a>
                        <button class="btn btn-sm btn-danger delete-specific-pos" data-pos-id="{{ $pos->id }}" title="{{ __('pos.delete-invoice') }}">
                            <i class="fa fa-trash"></i> {{ __('pos.delete') }}
                        </button>
                    </td>
                </tr>
                @php $sum1 += $totalAmount; @endphp
            @endforeach
        </tbody>
    </table>
</div>
<div class="row mb-3 mt-3 text-center">
    <div class="badge badge-dark mb-1 p-1" style="margin-right: 5px; width: fit-content; font-size: 11px !important; font-weight: bold;">
        مبيعات الكاش: <span>{{ number_format($totalCash, 2) }}</span>
    </div>
    <div class="badge badge-warning mb-1 p-1" style="margin-right: 5px; width: fit-content; font-size: 11px !important; font-weight: bold;">
        مبيعات الشبكة: <span>{{ number_format($totalBank, 2) }}</span>
    </div>
    <div class="badge badge-danger mb-1 p-1" style="margin-right: 5px; width: fit-content; font-size: 11px !important; font-weight: bold;">
        {{ __('pos.total-tax-for-all-invoices') }}: <span>{{ number_format($sum3, 2) }}</span>
    </div>
    <div class="badge badge-primary mb-1 p-1" style="margin-right: 5px; width: fit-content; font-size: 11px !important; font-weight: bold;">
        {{ __('main.paid-amount') }}: <span>{{ number_format($sum2, 2) }}</span>
    </div>
    <div class="badge badge-success mb-1 p-1" style="margin-right: 5px; width: fit-content; font-size: 11px !important; font-weight: bold;">
        {{ __('pos.total-invoices-including-tax') }}: <span>{{ number_format($sum1, 2) }}</span>
    </div>
</div>
