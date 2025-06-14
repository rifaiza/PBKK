<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // database/migrations/[timestamp]_create_customers_table.php
Schema::create('customers', function (Blueprint $table) {
    $table->ulid('customer_id')->primary();
    $table->string('name');
    $table->string('email')->unique();
    $table->string('password');
    $table->string('phone');
    $table->text('address');
    $table->rememberToken();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};