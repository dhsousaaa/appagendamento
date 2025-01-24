<?php

namespace App\Http\Controllers;

use App\Models\Servico;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ServicoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Servico::select(['id', 'nome', 'valor']);
            return DataTables::of($data)->make(true);
        }
        return view('servicos');
    }

    /**
     * Criar um novo servico
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'valor' => 'required|numeric|min:0',
        ]);
    
        Servico::create([
            'nome' => $request->nome,
            'valor' => $request->valor,
        ]);
    
        return back()->with(['message' => 'Profissional cadastrado com sucesso!'], 200);
    }

    // Método para buscar os dados do servico e retornar para o modal
    public function edit($id)
    {
        // Buscar o profissional pelo ID
        $servico = Servico::findOrFail($id);

        // Retornar os dados como JSON para o AJAX
        return response()->json($servico);
    }

    /**
     * Atualizar o registro de um servico no banco
     */
    public function update(Request $request, $id)
    {
        // Validar os dados recebidos
        $request->validate([
            'nome' => 'required|string|max:255',
            'valor' => 'required|numeric|min:0',
        ]);

        // Buscar o servico e atualizar os dados
        $servico = Servico::findOrFail($id);
        $servico->update($request->all());

        // Retornar uma resposta de sucesso
        return response()->json(['message' => 'Serviço atualizado com sucesso!'], 200);
    }

    /**
     * Remove um servico da tabela
     */
    public function destroy($id)
    {
        // Buscar o servico no banco de dados
        $servico = Servico::findOrFail($id);

        // Excluir o servico
        $servico->delete();

        // Retornar uma resposta JSON de sucesso
        return response()->json(['message' => 'Profissional excluído com sucesso!']);
    }
}
