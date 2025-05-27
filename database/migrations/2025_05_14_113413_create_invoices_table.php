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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id(); 
            $table->string('invoice_number', 100)->nullable();
            $table->integer('total_amount')->nullable();
            $table->enum('payment_status', ['Pending', 'Paid', 'Cancelled'])->nullable();
            $table->dateTime('issued_at')->nullable();
            $table->dateTime('paid_at')->nullable();
            $table->timestamp('created_at')->nullable();
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
        Schema::dropIfExists('invoices');
    }
};
