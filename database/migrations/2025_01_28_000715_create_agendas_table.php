<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('agendas', function (Blueprint $table) {
            $table->id(); // Chave primária

            // Chave estrangeira com a tabela 'profissionais'
            $table->foreignId('profissional_id')->constrained('profissionais')->onDelete('cascade');

            // Campos de horário
            $table->time('hora_inicio');
            $table->time('hora_fim');

            // Campo de status
            $table->enum('status', ['disponivel', 'reservado', 'cancelado'])->default('disponivel');

            // Campo para o dia da semana (como número de 1 a 7)
            $table->integer('dia_semana')->unsigned(); // 1 = Segunda, 7 = Domingo

            $table->timestamps(); // Campos created_at e updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agendas');
    }
};
