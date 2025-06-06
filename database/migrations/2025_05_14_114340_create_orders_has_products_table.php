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
        Schema::create('orders_has_products', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('orders_id')->constrained()->onDelete('cascade');
            $table->foreignId('products_id')->constrained()->onDelete('cascade');
            $table->integer('quantity')->nullable();
            $table->integer('price')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders_has_products');
    }
};
