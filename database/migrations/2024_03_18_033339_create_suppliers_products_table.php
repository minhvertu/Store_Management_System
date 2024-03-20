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
        Schema::create('suppliers_products', function (Blueprint $table) {
           
            $table->bigInteger('supplier_id')->unsigned()->nullable();
            $table->bigInteger('products_id')->unsigned()->nullable();
            $table->string('amount');
            $table->string('price');
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
        Schema::dropIfExists('suppliers_products');
    }
};
