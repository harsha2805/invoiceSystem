@extends('layouts.app')

@section('content')
    @php
        $totalProductCost = 0;
        $totalGst = 0;
        $totalCost = 0;
    @endphp
    <div class="container">
        <h2>Sale Details</h2>
        <div class="card mt-4">
            <div class="card-header">
                Invoice Details
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Invoice Number:</strong> {{ $customerDetails->InvoiceNumber }}</p>
                        <p><strong>Invoice Date:</strong> {{ $customerDetails->InvoiceDate }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                Customer Information
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Name:</strong> {{ $customerDetails->CustomerName }}</p>
                        <p><strong>Email:</strong> {{ $customerDetails->CustomerEmail }}</p>
                        <p><strong>Phone:</strong> {{ $customerDetails->CustomerPhone }}</p>
                        <p><strong>State:</strong> {{ $customerDetails->CustomerState }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                Products
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Rate</th>
                            <th>Quantity</th>
                            <th>GST (%)</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sales as $sale)
                            <tr>
                                <td>{{ $sale->product->product_name }}</td>
                                <td>{{ $sale->product->rate }}</td>
                                <td>{{ $sale->Quantity }}</td>
                                <td>{{ $sale->GstAmount }}</td>
                                <td>{{ $sale->TotalCost + $sale->GstAmount }}</td>
                                @php
                                    $totalGst += $sale->GstAmount;
                                    $totalProductCost += $sale->TotalCost;
                                    $totalCost += $totalGst + $totalProductCost;
                                @endphp
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card mt-4 ">
            <div class="card-header">
                Totals
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Product Cost:</strong> {{ $totalProductCost }}</p>
                        <p><strong>Total GST:</strong> {{ $totalGst }}</p>
                        <p><strong>Total Cost:</strong> {{ $totalCost }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Edit Button --}}
        <div class="mt-4">
            <a href="{{ route('sales.edit', $sale->InvoiceNumber) }}" class="btn btn-primary">Edit Sale</a>
        </div>
    </div>
@endsection
