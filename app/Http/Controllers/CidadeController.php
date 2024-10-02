<?php

namespace App\Http\Controllers;

use App\Models\Cidade;
use Illuminate\Http\Request;

class CidadeController extends Controller
{
    public function index()
    {
        // Paginação: 5 cidades por página
        $cidades = Cidade::paginate(5);
        return view('cidades.index', compact('cidades'));
    }

    public function store(Request $request)
    {
        $request->validate(['nome' => 'required', 'estado' => 'required']);
        Cidade::create($request->all());
        return redirect()->route('cidades.index')->with('success', 'Cidade criada com sucesso.');
    }

    public function update(Request $request, $id)
    {
        $request->validate(['nome' => 'required', 'estado' => 'required']);
        $cidade = Cidade::findOrFail($id);
        $cidade->update($request->all());
        return redirect()->route('cidades.index')->with('success', 'Cidade atualizada com sucesso.');
    }

    public function destroy($id)
    {
        Cidade::destroy($id);
        return redirect()->route('cidades.index')->with('success', 'Cidade deletada com sucesso.');
    }
}
