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
        Schema::create('profissionals', function (Blueprint $table) {
            $table->id(); // ID auto-increment
            $table->string('nome', 255); // Nome (string, até 255 caracteres)
            $table->string('profissao', 255); // Profissão (string, até 255 caracteres)
            $table->timestamps(); // Data de criação e atualização (created_at e updated_at)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profissionals');
    }
};
