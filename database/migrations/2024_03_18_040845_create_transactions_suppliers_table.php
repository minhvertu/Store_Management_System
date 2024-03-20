<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions_suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('import_price');
            $table->string('amount');
            $table->string('product_detail');
            $table->bigInteger('shop_id')->unsigned();
            $table->bigInteger('supplier_id')->unsigned();
            $table->bigInteger('products_id')->unsigned();
            $table->timestamps();

             //FOREIGN KEY CONSTRAINTS
             $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
             $table->foreign('products_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions_suppliers');
    }
};
