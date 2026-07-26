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
    Schema::create('laporan_temuan', function (Blueprint $table) {
        $table->id();

        $table->foreignId('laporan_id')
            ->constrained('laporans')
            ->cascadeOnUpdate()
            ->cascadeOnDelete();

        $table->foreignId('temuan_id')
            ->constrained('temuans')
            ->cascadeOnUpdate()
            ->cascadeOnDelete();

        $table->boolean('menutup_temuan')->default(false);
        $table->text('catatan_verifikasi')->nullable();

        $table->timestamps();

        $table->unique(['laporan_id', 'temuan_id']);
        $table->index(['temuan_id', 'menutup_temuan']);
    });
}

    /**
     * Reverse the migrations.
     */
   public function down(): void
{
    Schema::dropIfExists('laporan_temuan');
}
};
