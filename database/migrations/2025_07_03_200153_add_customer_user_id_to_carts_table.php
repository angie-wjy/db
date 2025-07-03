<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->unsignedBigInteger('customer_user_id')->nullable()->after('id');

            // Jika customer_user_id mengacu ke kolom 'user_id' di tabel customers:
            $table->foreign('customer_user_id')->references('user_id')->on('customers')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->dropForeign(['customer_user_id']);
            $table->dropColumn('customer_user_id');
        });
    }
};
