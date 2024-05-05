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
        Schema::create('clients_perrmissions', function (Blueprint $table) {
            $table->bigInteger('client_id')->unsigned();
            $table->bigInteger('permission_id')->unsigned();

        //FOREIGN KEY CONSTRAINTS
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');

        //SETTING THE PRIMARY KEYS
            $table->primary(['client_id','permission_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients_perrmissions');
    }
};
