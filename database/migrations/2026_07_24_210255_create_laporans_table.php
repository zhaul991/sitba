<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporans', function (Blueprint $table) {
            $table->id();

            $table->foreignId('bandara_id')
                ->constrained('bandaras')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->string('nomor_surat');
            $table->date('tanggal_surat');
            $table->string('perihal')->nullable();
            $table->text('keterangan')->nullable();
            $table->string('file_surat');

            $table->timestamps();

            $table->index(['bandara_id', 'tanggal_surat']);
            $table->index('nomor_surat');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporans');
    }
};
