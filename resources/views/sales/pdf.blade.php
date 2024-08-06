<!DOCTYPE html>
<html>

<head>
    <title>Sales PDF</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>

<body>
    <h1>Sales Report</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Invoice Number</th>
                <th>Invoice Date</th>
                <th>Customer Name</th>
                <th>Product</th>
                <th>Rate</th>
                <th>Quantity</th>
                <th>Total Cost</th>
                <th>GST Percentage</th>
                <th>GST Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sales as $sale)
                <tr>
                    <td>{{ $sale->SaleID }}</td>
                    <td>{{ $sale->InvoiceNumber }}</td>
                    <td>{{ $sale->InvoiceDate }}</td>
                    <td>{{ $sale->CustomerName }}</td>
                    <td>{{ $sale->product->product_name }}</td>
                    <td>{{ $sale->product->rate }}</td>
                    <td>{{ $sale->Quantity }}</td>
                    <td>{{ $sale->TotalCost }}</td>
                    <td>{{ $sale->GstPercentage }}</td>
                    <td>{{ $sale->GstAmount }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
