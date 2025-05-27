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
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['pick up', 'delivery'])->nullable();
            $table->enum('status', ['on progress', 'ready', 'finish'])->nullable();
            $table->string('resi', 45)->nullable();
            $table->unsignedBigInteger('orders_id');

            // Foreign key constraint to 'orders' table
            $table->foreign('orders_id')->references('id')->on('orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deliveries');
    }
};
