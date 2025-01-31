<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profissional extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nome','profissao'
    ];

    public function agendaProfissional() {
        return $this->hasMany(AgendaProfissional::class, 'profissional_id');
    }
}
