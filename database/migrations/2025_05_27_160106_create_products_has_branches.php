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
        Schema::create('products_has_branches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('products_id')->constrained()->onDelete('cascade');
            $table->foreignId('branches_id')->constrained()->onDelete('cascade');
            $table->integer('stock')->nullable();
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products_has_branches');
    }
};
