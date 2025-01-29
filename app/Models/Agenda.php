<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory;

    protected $fillable = [
        'profissional_id',
        'hora_inicio',
        'hora_fim',
        'status',
        'dia_semana',
    ];

    // Relacionamento com o modelo Profissional
    public function profissional()
    {
        return $this->belongsTo(Profissional::class);
    }
}
