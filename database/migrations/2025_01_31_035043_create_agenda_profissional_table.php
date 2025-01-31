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
        Schema::create('agenda_profissional', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profissional_id')->constrained('profissionais')->onDelete('cascade');
            $table->foreignId('dia_id')->constrained('dias_semana')->onDelete('cascade');
            $table->time('hora_inicio');
            $table->time('hora_fim');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agenda_profissional');
    }
};
