<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ships', function (Blueprint $table) {
            $table->id(); // bigint unsigned primary key
            $table->enum('type', ['pick up', 'delivery'])->nullable();
            $table->string('address')->nullable();
            $table->enum('status', ['on progress', 'ready', 'finish'])->nullable();
            $table->string('resi', 45)->nullable();
            $table->unsignedBigInteger('orders_id');
            $table->timestamps();
            $table->softDeletes();

            $table->unsignedBigInteger('created_id')->nullable();
            $table->unsignedBigInteger('updated_id')->nullable();
            $table->unsignedBigInteger('deleted_id')->nullable();

            // Optional: Foreign key constraint (uncomment if you have orders table)
            // $table->foreign('orders_id')->references('id')->on('orders')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ships');
    }
};
