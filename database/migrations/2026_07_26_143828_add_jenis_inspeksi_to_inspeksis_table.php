<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inspeksis', function (Blueprint $table) {
            $table->string('jenis_inspeksi')
                  ->after('tanggal');
        });
    }


    public function down(): void
    {
        Schema::table('inspeksis', function (Blueprint $table) {
            $table->dropColumn('jenis_inspeksi');
        });
    }
};
