<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('inspeksi_petugas', function (Blueprint $table) {

            $table->id();

            $table->foreignId('inspeksi_id')
                  ->constrained('inspeksis')
                  ->cascadeOnDelete();


            $table->foreignId('petugas_id')
                  ->constrained('petugas')
                  ->cascadeOnDelete();


            $table->timestamps();

        });
    }


    public function down(): void
    {
        Schema::dropIfExists('inspeksi_petugas');
    }

};