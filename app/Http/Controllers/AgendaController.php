<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Profissional;
use App\Models\Agenda;
use Illuminate\Support\Facades\DB;

class AgendaController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'profissional_id' => 'required',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fim' => 'required|date_format:H:i',
        ]);
        
        Agenda::create($request->all());
        return response()->json(['message', 'Horario cadastrado com sucesso!']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $profissionais = Profissional::all();
        $diasDaSemana = DB::table('dias_semana')->get();
        return view('cadastrar-agendamento', ['profissionais' => $profissionais, 'diasDaSemana' => $diasDaSemana]);
    }
}
