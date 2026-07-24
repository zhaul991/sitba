<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('temuans', function (Blueprint $table) {
            $table->date('tanggal_close')
                ->nullable()
                ->after('status');

            $table->text('keterangan_penutupan')
                ->nullable()
                ->after('tanggal_close');
        });
    }

    public function down(): void
    {
        Schema::table('temuans', function (Blueprint $table) {
            $table->dropColumn([
                'tanggal_close',
                'keterangan_penutupan',
            ]);
        });
    }
};
