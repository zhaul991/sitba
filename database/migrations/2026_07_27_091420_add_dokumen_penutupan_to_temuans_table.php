<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('temuans', function (Blueprint $table) {

            $table->string('dokumen_penutupan')
                ->nullable()
                ->after('keterangan_penutupan');

        });
    }


    public function down(): void
    {
        Schema::table('temuans', function (Blueprint $table) {

            $table->dropColumn('dokumen_penutupan');

        });
    }
};
