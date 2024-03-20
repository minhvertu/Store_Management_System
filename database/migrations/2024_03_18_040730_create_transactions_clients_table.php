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
        Schema::create('transactions_clients', function (Blueprint $table) {
            $table->id();
            $table->string('price');
            $table->string('amount');
            $table->string('product_detail');
            $table->bigInteger('shop_id')->unsigned()->nullable();
            $table->bigInteger('client_id')->unsigned()->nullable();
            $table->bigInteger('products_id')->unsigned()->nullable();
            $table->timestamps();

             //FOREIGN KEY CONSTRAINTS
             $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
             $table->foreign('products_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions_clients');
    }
};
