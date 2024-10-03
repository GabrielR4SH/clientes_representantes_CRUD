@extends('layouts.app')

@section('title', 'Atribuição de Representantes')

@section('content')

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <h1 class="text-center font-weight-bold mb-4">Atribuição de Representantes</h1>
    <hr>
    <div class="row mb-3">
        <div class="col">
            <a href="{{ route('clientes.index') }}" class="btn btn-primary">Voltar aos clientes</a>
        </div>
    </div> 
    <div class="table-responsive">
        <div class="container d-flex justify-content-center">
            <table class="table table-bordered table-striped table-hover bg-white">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">Cliente</th>
                        <th scope="col">Representante(s)</th>
                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($clientes as $cliente)
                        <tr>
                            <td>{{ $cliente->nome }}</td>
                            <td>
                                @forelse($cliente->representantes as $representante)
                                    <span>{{ $representante->nome }}</span><br>
                                @empty
                                    <span>Sem representante atribuído</span>
                                @endforelse
                            </td>
                            <td>
                                <div class="d-flex">
                                    @if ($cliente->representantes->count() < 1)
                                        <!-- Botão para atribuir representante -->
                                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#assignRepresentativeModal{{ $cliente->id }}">
                                            Atribuir Representante
                                        </button>
                                    @else
                                        <!-- Formulário para remover representante -->
                                        <form action="{{ route('clientes.representantes.destroy', [$cliente->id, $cliente->representantes->first()->id]) }}" method="POST" class="mr-2">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Remover Representante</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>

                        <!-- Modal para atribuir um representante -->
                        <div class="modal fade" id="assignRepresentativeModal{{ $cliente->id }}" tabindex="-1" role="dialog" aria-labelledby="assignRepresentativeModalLabel{{ $cliente->id }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="assignRepresentativeModalLabel{{ $cliente->id }}">Selecionar Representante</h5>
                                        
                                    </div>
                                    <form action="{{ route('clientes.representantes.store', $cliente->id) }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="representante_id">Escolha o Representante</label>
                                                <select class="form-control" id="representante_id" name="representante_id" required>
                                                    <option value="">Selecione um representante</option>
                                                    @foreach ($representantes as $representante)
                                                        @if ($representante->cidade_id == $cliente->cidade_id)
                                                            <option value="{{ $representante->id }}">{{ $representante->nome }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                            <button type="submit" class="btn btn-primary">Atribuir</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
            
        </div>
        <div class="d-flex justify-content-center">
            {{ $clientes->links() }}
        </div>
    </div>

@endsection
