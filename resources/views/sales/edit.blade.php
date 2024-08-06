@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="my-4">Edit Sale</h1>

        <div class="row">
            <div class="col-md-8">
                @php
                    $InvoiceNumber = $customerDetails->InvoiceNumber;
                @endphp
                <form action="{{ route('sales.update', $InvoiceNumber) }}">
                    @csrf
                    @method('POST')
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="invoiceNumber">Invoice Number</label>
                                <input type="text" class="form-control bg-light" id="invoiceNumber" name="invoiceNumber"
                                    value="{{ $customerDetails->InvoiceNumber }}" readonly>
                            </div>

                            <div class="form-group">
                                <label for="invoiceDate">Invoice Date</label>
                                <input type="date" class="form-control bg-light" id="invoiceDate" name="invoiceDate"
                                    value="{{ $customerDetails->InvoiceDate }}"readonly>
                            </div>

                            <div class="form-group">
                                <label for="customerName">Customer Name</label>
                                <input type="text" class="form-control" id="customerName" name="customerName"
                                    value="{{ $customerDetails->CustomerName }}">
                            </div>

                            <div class="form-group">
                                <label for="customerEmail">Customer Email</label>
                                <input type="email" class="form-control" id="customerEmail" name="customerEmail"
                                    value="{{ $customerDetails->CustomerEmail }}">
                            </div>

                            <div class="form-group">
                                <label for="customerPhone">Customer Phone</label>
                                <input type="text" class="form-control" id="customerPhone" name="customerPhone"
                                    value="{{ $customerDetails->CustomerPhone }}">
                            </div>

                            <div class="form-group">
                                <label for="customerState">Customer State</label>
                                <select class="form-control" id="customerState" name="customerState">
                                    @foreach ($states as $state)
                                        <option value="{{ $state }}"
                                            {{ $customerDetails->CustomerState === $state ? 'selected' : '' }}>
                                            {{ $state }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <hr>

                            <h3>Products</h3>

                            <table class="table table-bordered" id="products-table">
                                <thead>
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Quantity</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($sales as $sale)
                                        <tr>
                                            <td class="bg-light">{{ $sale->product->product_name }}</td>
                                            <td>
                                                <input type="number" class="form-control "
                                                    name="products[{{ $sale->ProductID }}][Quantity]"
                                                    value="{{ $sale->Quantity }}" min={{ $sale->Quantity }} required>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="my-4">
                        <button type="submit" class="btn btn-primary mr-2">Update Sale</button>
                        <a href="{{ url('/sales') }}" class="btn btn-secondary">Back to Sales</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection