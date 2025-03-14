<table>
    <thead>
        <tr>
            <th style="border-radius: 0 10px 0 0">{{ __('sidebar.invoice number') }}</th>
            <th>{{ __('sidebar.customer name') }}</th>
            <th>{{ __('sidebar.Invoice date') }}</th>
            <th>{{ __('sidebar.Billing time') }}</th>
            <th>{{ __('products.store') }}</th>
            <th>{{ __('sidebar.Final total') }}</th>
            <th>{{ __('sales_bills.tax') }}</th>
            <th>{{ __('sidebar.Number of items') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($sale_bills as $sale_bill)
            <tr>
                <td>{{ $sale_bill->company_counter }}</td>
                <td>{{ $sale_bill->OuterClient->client_name ?? 'Cash Client' }}</td>
                <td>{{ $sale_bill->date }}</td>
                <td>{{ $sale_bill->time }}</td>
                <td>{{ $sale_bill->store?->store_name ?? ' ' }}</td>
                <td>{{ $sale_bill->final_total }}</td>
                <td>{{ $sale_bill->total_tax }}</td>
                <td>{{ $sale_bill->elements->count() }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
