<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id('SaleID');
            $table->string('InvoiceNumber');
            $table->date('InvoiceDate');
            $table->string('CustomerName');
            $table->string('CustomerEmail');
            $table->string('CustomerPhone');
            $table->string('CustomerState');
            $table->unsignedBigInteger('ProductID');
            $table->integer('Quantity');
            $table->float('GstPercentage');
            $table->float('TotalCost');
            $table->float('GstAmount');
            $table->timestamps();

            $table->foreign('ProductID')->references('pid')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales');
    }
};
