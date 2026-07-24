<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('tindak_lanjuts', function (Blueprint $table) {

            $table->id();


            $table->foreignId('temuan_id')
                  ->constrained('temuans')
                  ->cascadeOnDelete();


            $table->text('rencana_perbaikan');


            $table->string('pic');


            $table->date('deadline');


            $table->string('status')
                  ->default('Open');


            $table->text('catatan')
                  ->nullable();


            $table->timestamps();

        });
    }


    public function down(): void
    {
        Schema::dropIfExists('tindak_lanjuts');
    }

};
