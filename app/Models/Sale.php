<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $primaryKey = 'SaleID';
    protected $fillable = [
        'InvoiceNumber',
        'InvoiceDate',
        'CustomerName',
        'CustomerEmail',
        'CustomerPhone',
        'CustomerState',
        'TotalCost',
        'GstAmount',
        'ProductID',
        'Quantity',
        'GstPercentage'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'ProductID', 'pid');
    }
}
