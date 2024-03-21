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
        Schema::table('users', function (Blueprint $table) {
            //
            $table->string('image')->nullable();
            $table->string('address');
            $table->string('phone_number');
            $table->date('birth_day');
            $table->bigInteger('role_id')->unsigned()->nullable();
            $table->bigInteger('shop_id')->unsigned()->nullable();

              //FOREIGN KEY CONSTRAINTS 
              $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
              $table->foreign('shop_id')->references('id')->on('shops')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
