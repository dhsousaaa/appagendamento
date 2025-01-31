<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgendaProfissional extends Model
{
    use HasFactory;
    protected $table = 'agenda_profissional';

    protected $fillable = [
        'profissional_id',
        'dia_id',
        'hora_inicio',
        'hora_fim',
    ];

    public function profissional() {
        return $this->belongsTo(Profissional::class);
    }

    public function dia() {
        return $this->belongsTo(DiaSemana::class);
    }
}
