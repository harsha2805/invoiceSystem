<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use League\CommonMark\Reference\Reference;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id('pid')->autoIncrement();
            $table->unsignedBigInteger('cid');
            $table->string('product_name');
            $table->integer('qty');
            $table->decimal('rate', 10, 2);
            $table->decimal('gst', 5, 2);
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('cid')->references('cid')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
