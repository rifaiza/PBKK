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
    Schema::create('orders', function (Blueprint $table) {
        $table->string('order_id')->primary();
        $table->string('customer_id'); // tambahkan kolom dulu
        $table->date('order_date');
        $table->integer('total_amount');
        $table->string('status');
        $table->timestamps();

        // lalu tambahkan foreign key
        $table->foreign('customer_id')->references('customer_id')->on('customers')->onDelete('cascade');
    });
}



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
