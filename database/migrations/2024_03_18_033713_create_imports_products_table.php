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
            $table->string('amount');
            $table->string('price');
            $table->bigInteger('storage_id')->unsigned()->nullable();
            $table->bigInteger('employee_id')->unsigned()->nullable();
            $table->bigInteger('products_id')->unsigned()->nullable();
            $table->timestamps();

        //FOREIGN KEY CONSTRAINTS
            $table->foreign('storage_id')->references('id')->on('storages')->onDelete('cascade');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('products_id')->references('id')->on('products')->onDelete('cascade');
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
