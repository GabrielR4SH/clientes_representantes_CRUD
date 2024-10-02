@extends('layouts.app')

@section('title', 'Lista de Clientes')

@section('content')
<h1 class="text-center font-weight-bold mb-4">Lista de Clientes</h1>

<div class="table-responsive">
    <div class="container d-flex justify-content-center">
        <table class="table table-bordered table-striped table-hover bg-white">
            <thead class="thead-light">
                <tr>
                    <th scope="col">Nome</th>
                    <th scope="col">CPF</th>
                    <th scope="col">Data Nasc</th>
                    <th scope="col">Sexo</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Cidade</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($clientes as $cliente)
                <tr>
                    <td>{{ $cliente->nome }}</td>
                    <!-- Formatação do CPF -->
                    <td>{{ preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "$1.$2.$3-$4", $cliente->cpf) }}</td>
                    
                    <!-- Formatação da Data de Nascimento -->
                    <td>{{ \Carbon\Carbon::parse($cliente->data_nascimento)->format('d/m/Y') }}</td>
                    
                    <td>{{ $cliente->sexo }}</td>
                    <td>{{ $cliente->estado }}</td>
                    <td>{{ $cliente->cidade ? $cliente->cidade->nome : 'N/A' }}</td>
                    <td>
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <a href="{{ route('clientes.edit', $cliente->id) }}" class="btn btn-primary" style="margin-right: 10px;">Editar</a>
                            <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja deletar este cliente?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Deletar</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="py-4 d-flex justify-content-center">
        {{ $clientes->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection
