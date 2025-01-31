<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiaSemana extends Model
{
    use HasFactory;

    protected $table = 'dias_semana';

    protected $fillable = ['nome'];

    public function agendaProfissional() {
        return $this->hasMany(AgendaProfissional::class, 'dia_id');
    }
}
