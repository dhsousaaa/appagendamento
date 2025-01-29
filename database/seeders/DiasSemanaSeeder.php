<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DiasSemanaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('dias_semana')->insert([
            ['nome' => 'Segunda-feira'],
            ['nome' => 'Terça-feira'],
            ['nome' => 'Quarta-feira'],
            ['nome' => 'Quinta-feira'],
            ['nome' => 'Sexta-feira'],
            ['nome' => 'Sábado'],
            ['nome' => 'Domingo'],
        ]);
    }
}
