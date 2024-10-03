<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Cidade;

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

        // Retorna a view com os clientes e as cidades
        return view('clientes.index', compact('clientes', 'cidades'));
    }



    public function edit($id)
    {
        $cliente = Cliente::with('cidade')->findOrFail($id); // Incluindo a cidade
        $cidades = Cidade::all();
        return view('clientes.index', compact('cliente', 'cidades'));
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
        ]);

        Cliente::create([
            'nome' => $request->nome,
            'cpf' => $request->cpf,
            'data_nascimento' => $request->data_nascimento,
            'sexo' => $request->sexo,
            'cidade_id' => $request->cidade,
            'estado' => $request->estado,
        ]);

        return redirect()->route('clientes.index')->with('success', 'Cliente inserido com sucesso!');
    }


    public function destroy($id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->delete();

        return redirect()->route('clientes.index')->with('success', 'Cliente deletado com sucesso.');
    }
}
