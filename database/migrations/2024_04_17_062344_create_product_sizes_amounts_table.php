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
        Schema::create('product_sizes_amounts', function (Blueprint $table) {
            $table->id();
            $table->string('amount');
            $table->bigInteger('size_id')->unsigned()->nullable();
            $table->bigInteger('storage_id')->unsigned()->nullable();
             
           
            $table->timestamps();
             //FOREIGN KEY CONSTRAINTS
            $table->foreign('size_id')->references('id')->on('sizes')->onDelete('cascade');
            $table->foreign('storage_id')->references('id')->on('storages')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_sizes_amounts');
    }
};
