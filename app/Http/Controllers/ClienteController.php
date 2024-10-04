<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Cidade;
use App\Models\Representante;

class ClienteController extends Controller
{
    public function index(Request $request)
    {
        // Inicia a query base de clientes
        $query = Cliente::query();

        // Filtro por nome
        if ($request->filled('nome')) {
            $query->where('nome', 'like', '%' . $request->nome . '%');
        }

        // Filtro por CPF
        if ($request->filled('cpf')) {
            $query->where('cpf', 'like', $request->cpf . '%');
        }

        // Filtro por sexo
        if ($request->filled('sexo')) {
            $query->where('sexo', $request->sexo);
        }

        // Filtro por cidade
        if ($request->filled('cidade')) {
            $query->where('cidade_id', $request->cidade);
        }

        // Paginação dos clientes

        $clientes = $query->paginate(5);
        $cidades = Cidade::all();
        $representantes = Representante::all();
        return view('clientes.index', compact('clientes', 'cidades', 'representantes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:100',
            'cpf' => 'required|string|size:11',
            'data_nascimento' => 'required|date',
            'sexo' => 'required|string|size:1|in:M,F',
            'cidade' => 'required|exists:cidades,id',
            'estado' => 'required|string|max:2|regex:/^[A-Za-z]{2}$/',
        ]);
        Cliente::create([
            'nome' => $validated['nome'],
            'cpf' => $validated['cpf'],
            'data_nascimento' => $validated['data_nascimento'],
            'sexo' => $validated['sexo'],
            'cidade_id' => $validated['cidade'],
            'estado' => strtoupper($validated['estado']), 
        ]);
        return redirect()->route('clientes.index')->with('success', 'Cliente criado com sucesso!');
    }



    public function edit($id)
    {
        $cliente = Cliente::with('cidade', 'representantes')->findOrFail($id);
        $cidades = Cidade::all();
        $representantes = Representante::all();

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
            'representantes' => 'nullable|array',
            'representantes.*' => 'exists:representantes,id',
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

        // Atualiza os representantes associados
        if ($request->has('representantes')) {
            $cliente->representantes()->sync($request->representantes);
        }

        return redirect()->route('clientes.index')->with('success', 'Cliente atualizado com sucesso.');
    }

    public function destroy($id)
    {        
        $cliente = Cliente::findOrFail($id);
        $cliente->delete();

        return redirect()->route('clientes.index')->with('success', 'Cliente deletado com sucesso.');
    }
}
