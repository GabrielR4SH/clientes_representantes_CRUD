@extends('layouts.app')

@section('title', 'Lista de Cidades')

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

    <h1 class="text-center font-weight-bold mb-4">Lista de Cidades</h1>
    <hr>

    <div class="text-left mb-3">
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#createCityModal">
            Adicionar Cidade
        </button>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover bg-white">
            <thead class="thead-light">
                <tr>
                    <th scope="col">Nome</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cidades as $cidade)
                    <tr>
                        <td>{{ $cidade->nome }}</td>
                        <td>{{ $cidade->estado }}</td>
                        <td>
                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                data-target="#editCityModal{{ $cidade->id }}">
                                Editar
                            </button>
                            <form action="{{ route('cidades.destroy', $cidade->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Deletar</button>
                            </form>
                        </td>
                    </tr>

                    <!-- Modal de Edição -->
                    <div class="modal fade" id="editCityModal{{ $cidade->id }}" tabindex="-1" role="dialog"
                        aria-labelledby="editCityModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editCityModalLabel">Editar Cidade</h5>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('cidades.update', $cidade->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <label for="nome">Nome</label>
                                            <input type="text" class="form-control" name="nome" value="{{ $cidade->nome }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="estado">Estado</label>
                                            <input type="text" class="form-control" name="estado" value="{{ $cidade->estado }}" required>
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
        {{ $cidades->links() }}
    </div>

    <!-- Modal para criar cidade -->
    <div class="modal fade" id="createCityModal" tabindex="-1" role="dialog" aria-labelledby="createCityModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createCityModalLabel">Criar Cidade</h5>
                </div>
                <div class="modal-body">
                    <form action="{{ route('cidades.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="nome">Nome</label>
                            <input type="text" class="form-control" name="nome" required>
                        </div>
                        <div class="form-group">
                            <label for="estado">Estado</label>
                            <input type="text" class="form-control" name="estado" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Criar Cidade</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
