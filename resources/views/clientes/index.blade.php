@extends('layouts.app')

@section('title', 'Lista de Clientes')

@section('content')
<h1 class="text-xl font-bold mb-4">Lista de Clientes</h1>
<div class="overflow-x-auto">
    <table class="min-w-full bg-white dark:bg-gray-800">
        <thead class="bg-gray-200 dark:bg-gray-700">
            <tr>
                <th class="py-3 px-4 text-left text-xs font-medium text-gray-700 dark:text-white uppercase tracking-wider">
                    Nome
                </th>
                <th class="py-3 px-4 text-left text-xs font-medium text-gray-700 dark:text-white uppercase tracking-wider">
                    CPF
                </th>
                <th class="py-3 px-4 text-left text-xs font-medium text-gray-700 dark:text-white uppercase tracking-wider">
                    Idade
                </th>
                <th class="py-3 px-4 text-left text-xs font-medium text-gray-700 dark:text-white uppercase tracking-wider">
                    Sexo
                </th>
                <th class="py-3 px-4 text-left text-xs font-medium text-gray-700 dark:text-white uppercase tracking-wider">
                    Cidade
                </th>
                <th class="py-3 px-4 text-left text-xs font-medium text-gray-700 dark:text-white uppercase tracking-wider">
                    Ações
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($clientes as $cliente)
            <tr class="border-b dark:border-gray-700">
                <td class="py-4 px-4">{{ $cliente->nome }}</td>
                <td class="py-4 px-4">{{ $cliente->cpf }}</td>
                <td class="py-4 px-4">{{ $cliente->idade }}</td>
                <td class="py-4 px-4">{{ $cliente->sexo }}</td>
                <td class="py-4 px-4">{{ $cliente->cidade ? $cliente->cidade->nome : 'N/A' }}</td>
                <td class="py-4 px-4">
                    <a href="{{ route('clientes.edit', $cliente->id) }}" class="bg-blue-500 text-white px-2 py-1 rounded">Editar</a>
                    <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Tem certeza que deseja deletar este cliente?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Deletar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <br>
    {{ $clientes->links() }}
</div>
@endsection
