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
            $table->bigInteger('shop_id')->unsigned();
            $table->bigInteger('client_id')->unsigned();
            $table->bigInteger('products_id')->unsigned();
            $table->timestamps();
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
