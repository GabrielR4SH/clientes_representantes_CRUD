@extends('layouts.app')

@section('title', 'Representantes')

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
        </div>
    @endif

    <h1 class="text-center font-weight-bold mb-4">Representantes</h1>
    <hr>

    <div class="text-left mb-3">
        <a href="{{ route('clientes.index') }}" class="btn btn-primary">Gerenciar Clientes</a>
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#createRepModal">
            Adicionar Representante <i class="fas fa-plus"></i>
        </button>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover bg-white">
            <thead class="thead-light">
                <tr>
                    <th scope="col">Nome</th>
                    <th scope="col">Cidade</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($representantes as $representante)
                    <tr>
                        <td>{{ $representante->nome }}</td>
                        <td>{{ $representante->cidade->nome ?? 'Sem cidade' }}</td>
                        <td>
                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                data-target="#editRepModal{{ $representante->id }}">
                                Editar
                            </button>
                            <form action="{{ route('representantes.destroy', $representante->id) }}" method="POST" style="display:inline;"
                                onsubmit="return confirm('Tem certeza que deseja deletar este representante?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Deletar</button>
                            </form>
                        </td>
                    </tr>

                    <!-- Modal de Edição -->
                    <div class="modal fade" id="editRepModal{{ $representante->id }}" tabindex="-1" role="dialog"
                        aria-labelledby="editRepModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editRepModalLabel">Editar Representante</h5>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('representantes.update', $representante->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <label for="nome">Nome</label>
                                            <input type="text" class="form-control" name="nome" value="{{ $representante->nome }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="cidade">Cidade</label>
                                            <select class="form-control" name="cidade_id" required>
                                                @foreach ($cidades as $cidade)
                                                    <option value="{{ $cidade->id }}" {{ $representante->cidade_id == $cidade->id ? 'selected' : '' }}>
                                                        {{ $cidade->nome }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Paginação -->
    <div class="d-flex justify-content-center">
        {{ $representantes->links() }}
    </div>

    <!-- Modal para criar representante -->
    <div class="modal fade" id="createRepModal" tabindex="-1" role="dialog" aria-labelledby="createRepModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createRepModalLabel">Criar Representante</h5>
                </div>
                <div class="modal-body">
                    <form action="{{ route('representantes.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="nome">Nome</label>
                            <input type="text" class="form-control" name="nome" required>
                        </div>
                        <div class="form-group">
                            <label for="cidade">Cidade</label>
                            <select class="form-control" name="cidade_id" required>
                                @foreach ($cidades as $cidade)
                                    <option value="{{ $cidade->id }}">{{ $cidade->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Criar Representante</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
