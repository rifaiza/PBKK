<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class ModifyTokenableIdTypeOnPersonalAccessTokensTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('personal_access_tokens', function (Blueprint $table) {
            // Ubah tipe kolom menggunakan raw SQL karena Laravel tidak bisa ubah langsung tipe kolom string
            DB::statement('ALTER TABLE personal_access_tokens MODIFY tokenable_id CHAR(26) NOT NULL;');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('personal_access_tokens', function (Blueprint $table) {
            // Kembalikan ke BIGINT jika dibutuhkan
            DB::statement('ALTER TABLE personal_access_tokens MODIFY tokenable_id BIGINT UNSIGNED NOT NULL;');
        });
    }
}
