<table>
    <thead>
        <tr>
            <th>Invoice Number</th>
            <th>Customer Name</th>
            <th>Invoice Date</th>
            <th>Total</th>
            <th>Number of Items</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($sale_bills as $sale_bill)
            <tr>
                <td>{{ $sale_bill->company_counter }}</td>
                <td>{{ $sale_bill->OuterClient->client_name ?? 'Cash Client' }}</td>
                <td>{{ $sale_bill->date }}</td>
                <td>{{ $sale_bill->final_total }}</td>
                <td>{{ $sale_bill->elements->count() }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
