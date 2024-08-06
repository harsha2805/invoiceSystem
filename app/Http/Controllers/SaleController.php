<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Symfony\Component\HttpFoundation\StreamedResponse;
use League\Csv\Writer;
use PDF;
use Carbon\Carbon;

class SaleController extends Controller
{
    public function index()
    {
        return view('sales.index');
    }

    public function getSalesData(Request $request)
    {

        $query = Sale::with('product');
        if ($request->has('search') && !empty($request->input('search')['value'])) {
            $searchTerm = $request->input('search')['value'];
            $query->where(function ($query) use ($searchTerm) {
                $query->where('InvoiceNumber', 'like', "%$searchTerm%")
                    ->orWhere('CustomerName', 'like', "%$searchTerm%")
                    ->orWhereHas('product', function ($q) use ($searchTerm) {
                        $q->where('product_name', 'like', "%$searchTerm%");
                    });
            });
        }
        $totalRows = $query->count();
        $offset = $request->input('start');

        $sales = $query->skip($request->input('start'))
            ->take($request->input('length'))
            ->get();
        return DataTables::of($sales)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $viewUrl = route('sales.view', $row->InvoiceNumber);
                $editUrl = route('sales.edit', $row->InvoiceNumber);
                return '<a href="' . $viewUrl . '" class="btn btn-sm btn-secondary">View</a>
                            <a href="' . $editUrl . '" class="btn btn-sm btn-primary">Edit</a>';
            })
            ->addColumn('product_name', function ($row) {
                return $row->product->name ?? 'N/A';
            })
            ->setTotalRecords($totalRows)
            ->setFilteredRecords($totalRows)
            ->setOffset($offset)
            ->make(true);

    }

    public function create()
    {
        $products = Product::all();
        $states = [
            'Andhra Pradesh',
            'Arunachal Pradesh',
            'Assam',
            'Bihar',
            'Chhattisgarh',
            'Goa',
            'Gujarat',
            'Haryana',
            'Himachal Pradesh',
            'Jharkhand',
            'Karnataka',
            'Kerala',
            'Madhya Pradesh',
            'Maharashtra',
            'Manipur',
            'Meghalaya',
            'Mizoram',
            'Nagaland',
            'Odisha',
            'Punjab',
            'Rajasthan',
            'Sikkim',
            'Tamil Nadu',
            'Telangana',
            'Tripura',
            'Uttar Pradesh',
            'Uttarakhand',
            'West Bengal',
        ];
        return view('sales.create', compact('products', 'states'));
    }

    public function store(Request $request)
    {
        $rules = [
            'customerName' => 'required|string|max:255',
            'customerEmail' => 'required|email',
            'customerPhone' => 'required|digits:10',
            'customerState' => 'required|string',
            'invoiceNumber' => 'required|string',
            'products' => 'required|array',
            'products.*.ProductID' => 'required|exists:products,pid',
            'products.*.Quantity' => 'required|integer|min:1',
            'invoiceDate' => 'required|date|after_or_equal:' . Carbon::today()->subDays(3)->format('Y-m-d') . '|before_or_equal:' . Carbon::today()->addDays(3)->format('Y-m-d'),

        ];

        $request->validate($rules);
        $totalCost = 0;
        $totalGstAmount = 0;

        foreach ($request->products as $product) {
            $productDetail = Product::find($product['ProductID']);
            if ($productDetail) {
                $quantity = $product['Quantity'];
                $cost = $productDetail->rate * $quantity;
                $gstAmount = ($cost * $productDetail->gst) / 100;
                $totalCost += $cost;
                $totalGstAmount += $gstAmount;

                Sale::create([
                    'InvoiceNumber' => $request->invoiceNumber,
                    'InvoiceDate' => $request->invoiceDate,
                    'CustomerName' => $request->customerName,
                    'CustomerEmail' => $request->customerEmail,
                    'CustomerPhone' => $request->customerPhone,
                    'CustomerState' => $request->customerState,
                    'ProductID' => $product['ProductID'],
                    'Quantity' => $quantity,
                    'GstPercentage' => $productDetail->gst,
                    'TotalCost' => $cost,
                    'GstAmount' => $gstAmount,
                ]);
            }
        }
        return response()->json(['success' => true, 'redirect' => url('/sales')]);
    }

    public function show($InvoiceNumber)
    {
        $sales = Sale::where('InvoiceNumber', $InvoiceNumber)->get();
        $customerDetails = $sales->first();
        return view('sales.show', compact('sales', 'customerDetails'));
    }
    public function edit($InvoiceNumber)
    {
        $sales = Sale::where('InvoiceNumber', $InvoiceNumber)->get();

        $products = Product::all();
        $states = [
            'Andhra Pradesh',
            'Arunachal Pradesh',
            'Assam',
            'Bihar',
            'Chhattisgarh',
            'Goa',
            'Gujarat',
            'Haryana',
            'Himachal Pradesh',
            'Jharkhand',
            'Karnataka',
            'Kerala',
            'Madhya Pradesh',
            'Maharashtra',
            'Manipur',
            'Meghalaya',
            'Mizoram',
            'Nagaland',
            'Odisha',
            'Punjab',
            'Rajasthan',
            'Sikkim',
            'Tamil Nadu',
            'Telangana',
            'Tripura',
            'Uttar Pradesh',
            'Uttarakhand',
            'West Bengal',
        ];

        $customerDetails = $sales->first();

        return view('sales.edit', compact('sales', 'products', 'states', 'customerDetails'));
    }

    public function update(Request $request, $InvoiceNumber)
    {
        $request->validate([
            'customerName' => 'required|string',
            'customerEmail' => 'required|email',
            'customerPhone' => 'required|digits:10',
            'customerState' => 'required|string',
            'products' => 'required|array',
            'products.*.Quantity' => 'required|integer|min:1',
        ]);

        $sales = Sale::where('InvoiceNumber', $InvoiceNumber)->get();

        foreach ($sales as $sale) {
            $sale->update([
                'CustomerName' => $request->customerName,
                'CustomerEmail' => $request->customerEmail,
                'CustomerPhone' => $request->customerPhone,
                'CustomerState' => $request->customerState,
            ]);
        }

        foreach ($request->products as $productId => $product) {
            $productDetail = Product::find($productId);
            if (!$productDetail) {
                continue;
            }

            $cost = $productDetail->rate * $product['Quantity'];
            $gstAmount = ($cost * $productDetail->gst) / 100;

            $updateQuantity = Sale::where('InvoiceNumber', $InvoiceNumber)->where('ProductID', $productId)->first();

            if ($updateQuantity) {
                $updateQuantity->update([
                    'Quantity' => $product['Quantity'],
                    'TotalCost' => $cost,
                    'GstAmount' => $gstAmount,
                ]);
            }
        }
        return redirect('/sales')->with('success', 'Sale updated successfully.');
    }

    public function generateInvoiceNumber(Request $request)
    {
        $products = $request->input('products');
        $categories = [];

        foreach ($products as $product) {
            $category = Product::find($product)->category;
            $categories[] = $category->category_name;
        }

        $categories = array_unique($categories);

        if (count($categories) > 1) {
            $prefix = 'GA-';
        } else {
            switch ($categories[0]) {
                case 'Food':
                    $prefix = 'FO-';
                    break;
                case 'Electronics':
                    $prefix = 'EL-';
                    break;
                case 'Apparel':
                    $prefix = 'AP-';
                    break;
                default:
                    $prefix = 'GA-';
                    break;
            }
        }

        $lastInvoice = Sale::where('InvoiceNumber', 'like', $prefix . '%')->latest('SaleID')->first();
        $number = $lastInvoice ? intval(substr($lastInvoice->InvoiceNumber, strlen($prefix))) + 1 : 1;
        $invoiceNumber = $prefix . str_pad($number, 3, '0', STR_PAD_LEFT);

        return response()->json(['invoiceNumber' => $invoiceNumber]);
    }
    public function exportCsv()
    {
        $sales = Sale::with('product')->get();
        $fileName = 'sales.csv';
        $stream = fopen('php://temp', 'w+');
        $csv = Writer::createFromStream($stream);

        $csv->insertOne([
            'Invoice Number',
            'Invoice Date',
            'Customer Name',
            'Customer Email',
            'Customer Phone',
            'Customer State',
            'Product Name',
            'Quantity',
            'GST Percentage',
            'Total Cost',
            'GST Amount',
        ]);

        foreach ($sales as $sale) {
            $csv->insertOne([
                $sale->InvoiceNumber,
                $sale->InvoiceDate,
                $sale->CustomerName,
                $sale->CustomerEmail,
                $sale->CustomerPhone,
                $sale->CustomerState,
                $sale->product->product_name,
                $sale->Quantity,
                $sale->GstPercentage,
                $sale->TotalCost,
                $sale->GstAmount,
            ]);
        }

        rewind($stream);
        $response = new StreamedResponse(function () use ($stream) {
            fpassthru($stream);
        });
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $fileName . '"');

        return $response;
    }
    public function exportPdf()
    {
        $sales = Sale::with('product')->get();
        $pdf = PDF::loadView('sales.pdf', compact('sales'));
        return $pdf->download('sales.pdf');
    }

}
