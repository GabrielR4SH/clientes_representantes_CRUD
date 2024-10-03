<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Cidade;
use App\Models\Representante; // Adicionando o modelo de Representante

class ClienteController extends Controller
{
    public function index(Request $request)
    {
        // Inicia a query
        $query = Cliente::query();

        // Filtra por nome
        if ($request->filled('nome')) {
            $query->where('nome', 'like', '%' . $request->nome . '%');
        }

        // Filtra por CPF
        if ($request->filled('cpf')) {
            $query->where('cpf', 'like', $request->cpf . '%');
        }

        // Filtra por sexo
        if ($request->filled('sexo')) {
            $query->where('sexo', $request->sexo);
        }

        // Filtra por cidade
        if ($request->filled('cidade')) {
            $query->where('cidade_id', $request->cidade);
        }

        // Realiza a pesquisa e paginando os resultados
        $clientes = $query->paginate(5);

        // Obtem todas as cidades para o select
        $cidades = Cidade::all();

        // Obtem todos os representantes para o select (se necessário para alguma ação, como atribuição)
        $representantes = Representante::all();

        // Retorna a view com os clientes, as cidades e os representantes
        return view('clientes.index', compact('clientes', 'cidades', 'representantes'));
    }

    public function edit($id)
    {
        $cliente = Cliente::with('cidade', 'representantes')->findOrFail($id); // Incluindo a cidade e representantes
        $cidades = Cidade::all();
        $representantes = Representante::all(); // Obtem todos os representantes

        return view('clientes.edit', compact('cliente', 'cidades', 'representantes'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|string|max:100',
            'cpf' => 'required|string|size:11|unique:clientes,cpf,' . $id,
            'data_nascimento' => 'required|date',
            'sexo' => 'nullable|string|size:1',
            'cidade' => 'required|exists:cidades,id',
            'estado' => 'required|string|max:2',
            'representantes' => 'nullable|array', // Permite múltiplos representantes
            'representantes.*' => 'exists:representantes,id', // Valida se os ids dos representantes são válidos
        ]);

        $cliente = Cliente::findOrFail($id);
        $cliente->update([
            'nome' => $request->nome,
            'cpf' => $request->cpf,
            'data_nascimento' => $request->data_nascimento,
            'sexo' => $request->sexo,
            'cidade_id' => $request->cidade,
            'estado' => $request->estado,
        ]);

        // Atualiza os representantes do cliente (se houver)
        if ($request->has('representantes')) {
            $cliente->representantes()->sync($request->representantes);
        }

        return redirect()->route('clientes.index')->with('success', 'Cliente editado com sucesso.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:100',
            'cpf' => 'required|string|size:11|unique:clientes',
            'data_nascimento' => 'required|date',
            'sexo' => 'nullable|string|size:1',
            'cidade' => 'required|exists:cidades,id',
            'estado' => 'required|string|max:2',
            'representantes' => 'nullable|array', // Permite múltiplos representantes
            'representantes.*' => 'exists:representantes,id', // Valida se os ids dos representantes são válidos
        ]);

        // Cria o cliente
        $cliente = Cliente::create([
            'nome' => $request->nome,
            'cpf' => $request->cpf,
            'data_nascimento' => $request->data_nascimento,
            'sexo' => $request->sexo,
            'cidade_id' => $request->cidade,
            'estado' => $request->estado,
        ]);

        // Atribui os representantes ao cliente
        if ($request->has('representantes')) {
            $cliente->representantes()->sync($request->representantes);
        }

        return redirect()->route('clientes.index')->with('success', 'Cliente inserido com sucesso!');
    }

    public function destroy($id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->delete();

        return redirect()->route('clientes.index')->with('success', 'Cliente deletado com sucesso.');
    }
}
