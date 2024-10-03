<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Representante;
use Illuminate\Http\Request;

class ClientRepresentativeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Pega todos os clientes com seus representantes, paginados
        $clientes = Cliente::with('representantes')->paginate(5);  // Paginação de 5 itens por página

        // Pega todos os representantes paginados
        // Agora, só buscamos representantes da mesma cidade do cliente
        $representantes = Representante::paginate(5); // Paginação de 5 itens por página

        // Retorna a view, passando tanto os clientes quanto os representantes
        return view('representantes_clientes.index', compact('clientes', 'representantes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $clienteId)
    {
        // Valida se o representante foi selecionado
        $request->validate([
            'representante_id' => 'required|exists:representantes,id'
        ]);

        // Encontra o cliente pelo ID
        $cliente = Cliente::findOrFail($clienteId);
        // Encontra o representante selecionado
        $representante = Representante::findOrFail($request->representante_id);

        // Verifica se o representante está na mesma cidade do cliente
        if ($representante->cidade_id != $cliente->cidade_id) {
            return redirect()->route('clientes.representantes.index')
                ->with('error', 'O representante deve ser da mesma cidade do cliente.');
        }

        // Atribui o representante ao cliente
        $cliente->representantes()->attach($representante->id);

        return redirect()->route('clientes.representantes.index')
            ->with('success', 'Representante atribuído com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($clienteId, $representanteId)
    {
        // Remove a relação entre o cliente e o representante
        $cliente = Cliente::findOrFail($clienteId);
        $cliente->representantes()->detach($representanteId);

        return redirect()->route('clientes.representantes.index')->with('success', 'Representante removido com sucesso.');
    }
}
