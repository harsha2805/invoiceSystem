@extends('layouts.app')

@section('content')
    <div class="container">
        <form id="salesForm">
            @csrf
            {{-- section1 --}}
            <div class="row" style="padding-top: 20px;">
                <div class="col-md-3 col-sm-6">
                    <div class="form-group row">
                        <label for="invoiceNumber" class="col-sm-4 col-form-label text-right labelStyles">Invoice_No:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control form-control-sm font-weight-bold text-dark bg-light"
                                id="invoiceNumber" name="invoiceNumber" required readonly>
                            @error('invoiceNumber')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                </div>
                <div class="col-md-3 col-sm-6">
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="form-group row">
                        <label for="invoiceDate"
                            class="col-sm-4 col-form-label text-right font-weight-bold labelStyles">Invoice_Date:</label>
                        <div class="col-sm-8">
                            <input type="date" class="form-control form-control-sm" id="invoiceDate" name="invoiceDate"
                                required>
                            @error('invoiceDate')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- section2 --}}
            <div class="container mt-4 border rounded">
                <h4 class="pt-2 pb-2 labelStyles">Customer Info</h4>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-floating mb-3">
                            <input type="text" class="form-control" id="customerName" name="customerName" placeholder=" "
                                pattern="[a-zA-Z]+" required>
                            @error('customerName')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <label for="customerName">Customer Name</label>
                        </div>
                        <div class="form-group form-floating mb-3">
                            <input type="text" class="form-control" id="customerPhone" name="customerPhone"
                                placeholder=" " required pattern="\d{10}" maxlength="10">
                            @error('customerPhone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <label for="customerPhone">Customer Phone</label>
                        </div>
                    </div>
                    <div class="col-md-6 pb-2">
                        <div class="form-group form-floating mb-3">
                            <input type="email" class="form-control" id="customerEmail" name="customerEmail"
                                placeholder=" " required>
                            @error('customerEmail')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <label for="customerEmail">Email address</label>
                        </div>
                        <div class="form-group form-floating mb-3">
                            <select class="form-control" id="customerState" name="customerState" required>
                                <option value="">Select State</option>
                                @foreach ($states as $state)
                                    <option value="{{ $state }}">{{ $state }}</option>
                                @endforeach
                            </select>
                            <label for="customerState">Customer State</label>
                        </div>
                    </div>
                </div>
            </div>

            {{-- section3 --}}
            <div class="container mt-4 border rounded">
                <h4 class="pt-2 pb-2 labelStyles">Product Sale Information</h4>
                <div id="productRowsContainer">
                    <div class="product-row d-flex flex-wrap align-items-center mb-2 product-row-template d-none">
                        <div class="col-md-2 col-sm-6 mb-3">
                            <div class="form-group">
                                <select class="form-control product-dropdown" name="ProductID">
                                    <option value="" selected disabled>Select Product</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->pid }}" data-rate="{{ $product->rate }}"
                                            data-gst="{{ $product->gst }}" data-quantity="{{ $product->qty }}">
                                            {{ $product->product_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-6 mb-3">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-text">₹</span>
                                    <input type="text" class="form-control rate-input bg-light" disabled
                                        placeholder="Rate" name="rate" readonly>
                                    @error('rate')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-6 mb-3">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-danger btn-number-minus" data-type="minus">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </span>
                                    <input type="number" name="quant[]" class="form-control input-number quantity-input"
                                        placeholder="Quantity">
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-success btn-number-plus" data-type="plus">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-6 mb-3">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-text gst-percent"></span>
                                    <input type="text" class="form-control gst-input bg-light" disabled
                                        placeholder="GST" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-6 mb-3">
                            <div class="form-group">
                                <input type="text" class="form-control total-input bg-light" disabled
                                    placeholder="Total" readonly>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-6 mb-3">
                            <button type="button" class="btn btn-danger remove-product-row d-none me-2">-</button>
                            <button type="button" class="btn btn-primary add-product-row">+</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid" id= "total-content">
                <div class="row justify-content-end mt-4">
                    <div class="col-12 col-lg-4">
                        <div class="border rounded p-3">
                            <h4 class="pt-2 pb-2 labelStyles">Summary</h4>
                            <div class="row mb-3">
                                <div class="col-6">Product Cost</div>
                                <div class="col-1">:</div>
                                <div class="col-5"><span id="productCost">0.00</span></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6">Total GST</div>
                                <div class="col-1">:</div>
                                <div class="col-5"><span id="totalGst">0.00</span></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6">Total Cost</div>
                                <div class="col-1">:</div>
                                <div class="col-5"><span id="totalCost">0.00</span></div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 mb-3">
                                    <button type="button" class="btn btn-warning w-100 reset-form">Reset
                                        Form</button>
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <button type="submit" class="btn btn-success w-100">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection


@push('custom-scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const productRowsContainer = document.getElementById('productRowsContainer');
            const templateRow = productRowsContainer.querySelector('.product-row-template');
            const totalContent = document.getElementById('total-content')

            const invoiceDateInput = document.getElementById('invoiceDate');
            const today = new Date();
            const maxDate = new Date(today.getFullYear(), today.getMonth(), today.getDate() + 3);
            const minDate = new Date(today.getFullYear(), today.getMonth(), today.getDate() - 3);

            invoiceDateInput.max = maxDate.toISOString().split('T')[0];
            invoiceDateInput.min = minDate.toISOString().split('T')[0];

            function updateAddRemoveButtons() {
                const rows = productRowsContainer.querySelectorAll('.product-row:not(.product-row-template)');
                rows.forEach((row, index) => {
                    const addButton = row.querySelector('.add-product-row');
                    const removeButton = row.querySelector('.remove-product-row');
                    if (index === rows.length - 1) {
                        addButton.classList.remove('d-none');
                        removeButton.classList.add('d-none');
                    } else {
                        addButton.classList.add('d-none');
                        removeButton.classList.remove('d-none');
                    }
                });
            }

            function addProductRow() {
                const rowCount = document.querySelectorAll('.product-row:not(.product-row-template)').length;
                const newRow = templateRow.cloneNode(true);
                newRow.classList.remove('product-row-template', 'd-none');
                newRow.querySelectorAll('select, input').forEach(input => {
                    input.disabled = false;
                });
                newRow.querySelector('.product-dropdown').setAttribute('name', `products[${rowCount}][ProductID]`);
                newRow.querySelector('.quantity-input').setAttribute('name', `products[${rowCount}][Quantity]`);
                newRow.querySelector('.gst-input').placeholder = "GST";
                newRow.querySelector('.total-input').placeholder = "Total";
                productRowsContainer.appendChild(newRow);
                updateAddRemoveButtons();
                initializeSelect2(newRow.querySelector('.product-dropdown'));
            }

            function removeProductRow(row) {
                row.remove();
                updateAddRemoveButtons();
                updateTotalCosts();
            }

            function updateTotalCosts() {
                let totalCost = 0;
                let totalGstAmount = 0;
                let totalProductCost = 0
                const rows = productRowsContainer.querySelectorAll('.product-row:not(.product-row-template)');
                rows.forEach(row => {
                    const rate = parseFloat(row.querySelector('.rate-input').value) || 0;
                    const gstPercent = parseFloat(row.querySelector('.gst-percent').textContent) || 0;
                    const quantity = parseInt(row.querySelector('.quantity-input').value) || 0;
                    const cost = rate * quantity;
                    const gstAmount = (cost * gstPercent) / 100;
                    totalProductCost += cost;
                    totalCost += (cost + gstAmount);
                    totalGstAmount += gstAmount;
                    row.querySelector('.total-input').value = (cost + gstAmount).toFixed(2);
                    row.querySelector('.gst-input').value = gstAmount.toFixed(2);
                });

                document.getElementById('totalCost').textContent = totalCost.toFixed(2);
                document.getElementById('totalGst').textContent = totalGstAmount.toFixed(2);
                document.getElementById('productCost').textContent = totalProductCost.toFixed(2);
            }

            function updateRowDetails(row, selectedOption) {
                const rateInput = row.querySelector('.rate-input');
                const gstPercentSpan = row.querySelector('.gst-percent');
                const gstInput = row.querySelector('.gst-input');
                const quantity = row.querySelector('.quantity-input');
                quantity.value = selectedOption.dataset.quantity;
                quantity.setAttribute('min', selectedOption.dataset.quantity);
                rateInput.value = selectedOption.dataset.rate;
                gstPercentSpan.textContent = selectedOption.dataset.gst;
                gstInput.value = (selectedOption.dataset.gst * selectedOption.dataset.rate / 100).toFixed(2);
                updateTotalCosts();
            }

            function initializeSelect2(selectElement) {
                $(selectElement).select2({
                    width: '100%',
                    dropdownParent: $(selectElement).closest('.product-row'),
                    placeholder: 'Select or type to search',
                    allowClear: true,
                    tags: false,
                }).on('select2:select', function(e) {
                    const selectedOption = e.params.data.element;
                    updateRowDetails(selectElement.closest('.product-row'), selectedOption);
                    handleProductChange();
                    updateDropdownOptions();
                }).on('select2:unselect', function(e) {
                    handleProductChange();
                    updateDropdownOptions();
                });
            }


            function updateDropdownOptions() {
                const selectedValues = Array.from(document.querySelectorAll('.product-dropdown'))
                    .map(dropdown => dropdown.value)
                    .filter(value => value !== "");

                document.querySelectorAll('.product-dropdown').forEach(dropdown => {
                    $(dropdown).find('option').each(function() {
                        if (selectedValues.includes(this.value) && this.value !== dropdown.value) {
                            $(this).attr('disabled', 'disabled');
                        } else {
                            $(this).removeAttr('disabled');
                        }
                    });
                    $(dropdown).trigger('change.select2');
                });
            }

            function handleProductChange() {
                const selectedProducts = Array.from(document.querySelectorAll('.product-dropdown'))
                    .map(dropdown => dropdown.value)
                    .filter(value => value !== "");
                getInvoiceNumber(selectedProducts);
            }

            function getInvoiceNumber(selectedProducts) {
                $.ajax({
                    url: "{{ route('getInvoiceNumber') }}",
                    type: 'POST',
                    data: {
                        products: selectedProducts
                    },
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    },
                    success: function(response) {
                        document.getElementById('invoiceNumber').value = response.invoiceNumber;
                    },
                    error: function() {
                        alert('An error occurred while generating the invoice number.');
                    }
                });
            }

            productRowsContainer.addEventListener('click', function(event) {
                const target = event.target;
                if (target.matches('.add-product-row')) {
                    addProductRow();
                } else if (target.matches('.remove-product-row')) {
                    removeProductRow(target.closest('.product-row'));
                } else if (target.closest('.btn-number-minus')) {
                    const inputField = target.closest('.product-row').querySelector('.quantity-input');
                    let currentValue = parseInt(inputField.value);
                    const minValue = parseInt(inputField.getAttribute('min')) || 0;
                    if (!isNaN(currentValue) && currentValue > minValue) {
                        inputField.value = currentValue - 1;
                        updateTotalCosts();
                    }
                } else if (target.closest('.btn-number-plus')) {
                    const inputField = target.closest('.product-row').querySelector('.quantity-input');
                    let currentValue = parseInt(inputField.value);
                    if (!isNaN(currentValue)) {
                        inputField.value = currentValue + 1;
                        updateTotalCosts();
                    }
                }
            });

            totalContent.addEventListener('click', function(event) {
                const target = event.target;
                if (target.matches('.reset-form')) {
                    const rows = productRowsContainer.querySelectorAll(
                        '.product-row:not(.product-row-template)');
                    rows.forEach(row => {
                        row.remove();
                    });
                    document.getElementById('invoiceNumber').value = " ";
                    addProductRow();
                    updateDropdownOptions();
                    updateTotalCosts();
                } else {

                }
            });

            productRowsContainer.addEventListener('input', function(event) {
                if (event.target.matches('.quantity-input') || event.target.matches('.rate-input')) {
                    updateTotalCosts();
                }
            });

            productRowsContainer.addEventListener('change', function(event) {
                if (event.target.matches('.product-dropdown')) {
                    const selectedOption = event.target.selectedOptions[0];
                    if (selectedOption) {
                        updateRowDetails(event.target.closest('.product-row'), selectedOption);
                    }
                }
            });

            document.getElementById('salesForm').addEventListener('submit', function(event) {
                if (confirm("Are you sure you want to save?")) {
                    event.preventDefault();
                    const productRows = document.querySelectorAll(
                        '.product-row:not(.product-row-template)');
                    let isValid = true;
                    productRows.forEach(row => {
                        const productDropdown = row.querySelector('.product-dropdown');
                        if (!productDropdown.value) {
                            isValid = false;
                            productDropdown.focus();
                        }
                    });
                    if (!isValid) {
                        alert('Please select a product in all product rows.');
                        return;
                    }

                    const formData = new FormData(this);
                    $.ajax({
                        url: "{{ route('sales.save') }}",
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                        success: function(data) {
                            if (data.success) {
                                window.location.href = data.redirect;
                            } else {
                                alert('An error occurred while saving the sale.');
                            }
                        },
                        error: function() {
                            alert('An error occurred while saving the sale.');
                        }
                    });
                }
            });

            addProductRow();
            updateTotalCosts();
        });
    </script>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif


@endpush
