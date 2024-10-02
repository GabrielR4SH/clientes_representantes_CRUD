<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Cidade;

class ClienteController extends Controller
{
    public function index()
    {
        $cidades = Cidade::all();
        $clientes = Cliente::paginate(5);
        return view('clientes.index', compact('clientes', 'cidades'));
    }

    public function edit($id)
    {
        $cliente = Cliente::find($id);
        $cidades = Cidade::all(); // Para usar no modal de edição
        return view('clientes.edit', compact('cliente', 'cidades'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|string|max:100',
            'cpf' => 'required|string|size:11|unique:clientes,cpf,' . $id,
            'data_nascimento' => 'required|date',
            'idade' => 'required|integer',
            'sexo' => 'nullable|string|size:1',
            'cidade' => 'required|string|max:100',
            'estado' => 'required|string|size:2',
        ]);

        $cliente = Cliente::find($id);
        $cliente->update($request->all());

        return redirect()->route('clientes.index')->with('success', 'Cliente editado com sucesso.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:100',
            'cpf' => 'required|string|size:11|unique:clientes',
            'data_nascimento' => 'required|date',
            'idade' => 'required|integer',
            'sexo' => 'nullable|string|size:1',
            'cidade' => 'required|string|max:100',
            'estado' => 'required|string|size:2',
        ]);

        Cliente::create($request->all());

        return redirect()->route('clientes.index')->with('success', 'Cliente inserido com sucesso!');
    }

    public function destroy($id)
    {
        $cliente = Cliente::find($id);

        if ($cliente) {
            $cliente->delete();
            return redirect()->route('clientes.index')->with('success', 'Cliente deletado com sucesso.');
        } else {
            return redirect()->route('clientes.index')->with('error', 'Cliente não encontrado.');
        }
    }
}
