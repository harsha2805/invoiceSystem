@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Sales List</h1>
        <hr>
        <table id="salesTable" class="table display">
            <thead>
                <tr>
                    <th>Invoice Number</th>
                    <th>Customer Name</th>
                    <th>Customer Email</th>
                    <th>Customer Phone</th>
                    <th>Customer State</th>
                    <th>Total Cost</th>
                    <th>GST Amount</th>
                    <th class="no-sort">Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data will be populated by DataTables via AJAX -->
            </tbody>
        </table>
        <a href="{{ route('sales.export.csv') }}" class="btn btn-success">Export to CSV</a>
        <a href="{{ route('sales.export.pdf') }}" class="btn btn-danger">Export to PDF</a>
        <a href="{{ route('sales.create') }}" class="btn btn-primary">+ Create Invoice</a>
    </div>

    <script>
        $(document).ready(function() {
            $('#salesTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('sales.data') }}",
                    type: 'GET'
                },
                columns: [{
                        data: 'InvoiceNumber'
                    },
                    {
                        data: 'CustomerName'
                    },
                    {
                        data: 'CustomerEmail'
                    },
                    {
                        data: 'CustomerPhone'
                    },
                    {
                        data: 'CustomerState'
                    },
                    {
                        data: 'TotalCost'
                    },
                    {
                        data: 'GstAmount'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                paging: true,
                ordering: true,
                info: true,
                autoWidth: false,
                columnDefs: [{
                    targets: 'no-sort',
                    orderable: false
                }]
            });
        });
    </script>
@endsection
