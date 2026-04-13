<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Hapus kolom boolean is_stock
            $table->dropColumn('is_stock');
            // Tambah kolom stock integer dengan default 0
            $table->integer('stock')->default(0)->after('on_sale');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('stock');
            $table->boolean('is_stock')->default(true)->after('on_sale');
        });
    }
};