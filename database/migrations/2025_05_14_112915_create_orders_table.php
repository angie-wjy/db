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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date')->nullable();
            $table->decimal('total', 10, 0)->nullable();
            $table->string('status', 45)->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->unsignedBigInteger('created_id')->nullable();
            $table->unsignedBigInteger('updated_id')->nullable();
            $table->unsignedBigInteger('deleted_id')->nullable();

            $table->unsignedBigInteger('customers_id');
            $table->unsignedBigInteger('employees_id')->nullable();
            $table->unsignedBigInteger('admins_id')->nullable();
            $table->unsignedBigInteger('branches_id')->nullable();


            // Foreign keys
            $table->foreign('customers_id')->references('id')->on('users');
            $table->foreign('employees_id')->references('id')->on('users');
            $table->foreign('admins_id')->references('id')->on('users');
            $table->foreign('branches_id')->references('id')->on('branches');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('employees_id')->nullable(false)->change();
        });
    }
};
