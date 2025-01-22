<?php

namespace App\Http\Controllers;

use App\Models\Profissional;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class ProfissionalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Profissional::select(['id', 'nome', 'profissao']);
            return DataTables::of($data)->make(true);
        }

        return view('profissionais');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    // Método para buscar os dados do profissional e retornar para o modal
    public function edit($id)
    {
        // Buscar o profissional pelo ID
        $profissional = Profissional::findOrFail($id);

        // Retornar os dados como JSON para o AJAX
        return response()->json($profissional);
    }

    /**
     * Criar um novo profissional
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'profissao' => 'required|string|max:255',
        ]);
    
        Profissional::create($request->all());
    
        return response()->json(['message' => 'Profissional cadastrado com sucesso!'], 200);
    }

    /**
     * Atualizar o registro de um profissional no banco
     */
    public function update(Request $request, $id)
    {
        // Validar os dados recebidos
        $request->validate([
            'nome' => 'required|string|max:255',
            'profissao' => 'required|string|max:255',
        ]);

        // Buscar o profissional e atualizar os dados
        $profissional = Profissional::findOrFail($id);
        $profissional->update($request->all());

        // Retornar uma resposta de sucesso
        return response()->json(['message' => 'Profissional atualizado com sucesso!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Buscar o profissional no banco de dados
        $profissional = Profissional::findOrFail($id);

        // Excluir o profissional
        $profissional->delete();

        // Retornar uma resposta JSON de sucesso
        return response()->json(['message' => 'Profissional excluído com sucesso!']);
    }
}
