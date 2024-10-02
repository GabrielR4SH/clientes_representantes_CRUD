<?php

namespace App\Http\Controllers;

use App\Models\Representante;
use App\Models\Cidade;
use Illuminate\Http\Request;

class RepresentanteController extends Controller
{
    public function index()
    {
        // Paginação: 5 representantes por página
        $representantes = Representante::with('cidade')->paginate(5);
        $cidades = Cidade::all();
        return view('representantes.index', compact('representantes', 'cidades'));
    }

    public function store(Request $request)
    {
        $request->validate(['nome' => 'required', 'cidade_id' => 'required']);
        Representante::create($request->all());
        return redirect()->route('representantes.index')->with('success', 'Representante criado com sucesso.');
    }

    public function update(Request $request, $id)
    {
        $request->validate(['nome' => 'required', 'cidade_id' => 'required']);
        $representante = Representante::findOrFail($id);
        $representante->update($request->all());
        return redirect()->route('representantes.index')->with('success', 'Representante atualizado com sucesso.');
    }

    public function destroy($id)
    {
        Representante::destroy($id);
        return redirect()->route('representantes.index')->with('success', 'Representante deletado com sucesso.');
    }
}
