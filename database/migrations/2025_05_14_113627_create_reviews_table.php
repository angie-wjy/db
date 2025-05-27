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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('rate')->nullable();
            $table->string('text', 400)->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('created_id')->nullable();
            $table->unsignedBigInteger('updated_id')->nullable();
            $table->unsignedBigInteger('deleted_id')->nullable();

            $table->unsignedBigInteger('customers_id');
            $table->unsignedBigInteger('admins_id');
            $table->unsignedBigInteger('orders_id');

            $table->foreign('customers_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('admins_id')->references('id')->on('admins')->onDelete('cascade');
            $table->foreign('orders_id')->references('id')->on('orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
