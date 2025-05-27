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
        Schema::create('orders_has_bundles', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('orders_id');
            $table->unsignedBigInteger('bundles_id');
            $table->integer('amount')->nullable();
            $table->decimal('price', 10, 2)->nullable();

            // Foreign keys
            $table->foreign('orders_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('bundles_id')->references('id')->on('bundles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders_has_bundles');
    }
};
