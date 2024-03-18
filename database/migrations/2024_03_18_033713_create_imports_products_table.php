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
        Schema::create('imports_products', function (Blueprint $table) {
            $table->id();
            $table->string('amount');
            $table->string('price');
            $table->bigInteger('storage_id')->unsigned();
            $table->bigInteger('employee_id')->unsigned();
            $table->bigInteger('products_id')->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imports_products');
    }
};
