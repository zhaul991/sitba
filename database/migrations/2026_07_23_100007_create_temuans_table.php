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
        Schema::create('temuans', function (Blueprint $table) {

            $table->id();

            $table->foreignId('inspeksi_id')
                ->constrained('inspeksis')
                ->cascadeOnDelete();

            $table->string('nomor_temuan');
            $table->text('uraian_temuan');
            $table->string('unsur_elemen');
            $table->string('tingkat_risiko');
            $table->string('lokasi');
            $table->string('status');

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temuans');
    }
};