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
        Schema::table('product_size_amounts', function (Blueprint $table) {
            //
            $table->bigInteger('storage_id')->unsigned()->nullable();
            $table->foreign('storage_id')->references('id')->on('storages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_size_amounts', function (Blueprint $table) {
            //
        });
    }
};
