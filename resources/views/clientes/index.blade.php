@extends('layouts.app')

@section('title', 'Lista de Clientes')

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <h1 class="text-center font-weight-bold mb-4">Lista de Clientes</h1>

    <div class="text-left mb-3">
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#createClientModal">
            Adicionar Cliente
        </button>
    </div>

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
                            <td>{{ preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', "$1.$2.$3-$4", $cliente->cpf) }}</td>
                            <td>{{ \Carbon\Carbon::parse($cliente->data_nascimento)->format('d/m/Y') }}</td>
                            <td>{{ $cliente->sexo }}</td>
                            <td>{{ $cliente->estado }}</td>
                            <td>{{ $cliente->cidade->nome ?? 'N/A' }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editClientModal{{ $cliente->id }}">
                                        Editar
                                    </button>
                                    <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja deletar este cliente?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Deletar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <!-- Modal de Edição -->
                        <div class="modal fade" id="editClientModal{{ $cliente->id }}" tabindex="-1" role="dialog" aria-labelledby="editClientModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editClientModalLabel">Editar Cliente</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('clientes.update', $cliente->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group">
                                                <label for="nome">Nome</label>
                                                <input type="text" class="form-control" name="nome" value="{{ $cliente->nome }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="cpf">CPF</label>
                                                <input type="text" class="form-control" name="cpf" value="{{ $cliente->cpf }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="data_nascimento">Data de Nascimento</label>
                                                <input type="date" class="form-control" name="data_nascimento" value="{{ $cliente->data_nascimento }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Sexo</label><br>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="sexo" value="M" {{ $cliente->sexo == 'M' ? 'checked' : '' }} required>
                                                    <label class="form-check-label">Masculino</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="sexo" value="F" {{ $cliente->sexo == 'F' ? 'checked' : '' }} required>
                                                    <label class="form-check-label">Feminino</label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="cidade">Cidade</label>
                                                <select class="form-control" name="cidade" required onchange="updateEstado(this)">
                                                    <option value="" disabled>Selecione uma cidade</option>
                                                    @foreach ($cidades as $cidade)
                                                        <option value="{{ $cidade->id }}" data-estado="{{ $cidade->estado }}" {{ $cliente->cidade_id == $cidade->id ? 'selected' : '' }}>
                                                            {{ $cidade->nome }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="estado">Estado</label>
                                                <input type="text" class="form-control" name="estado" value="{{ $cliente->estado }}" readonly>
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
        <div class="py-4 d-flex justify-content-center">
            {{ $clientes->links('pagination::bootstrap-4') }}
        </div>
    </div>

    <!-- Modal para criar cliente -->
    <div class="modal fade" id="createClientModal" tabindex="-1" role="dialog" aria-labelledby="createClientModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createClientModalLabel">Criar Cliente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('clientes.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="nome">Nome</label>
                            <input type="text" class="form-control" name="nome" required>
                        </div>
                        <div class="form-group">
                            <label for="cpf">CPF</label>
                            <input type="text" class="form-control" name="cpf" required>
                        </div>
                        <div class="form-group">
                            <label for="data_nascimento">Data de Nascimento</label>
                            <input type="date" class="form-control" name="data_nascimento" required>
                        </div>
                        <div class="form-group">
                            <label>Sexo</label><br>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="sexo" value="M" required>
                                <label class="form-check-label">Masculino</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="sexo" value="F" required>
                                <label class="form-check-label">Feminino</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="cidade">Cidade</label>
                            <select class="form-control" name="cidade" required onchange="updateEstado(this)">
                                <option value="" disabled selected>Selecione uma cidade</option>
                                @foreach ($cidades as $cidade)
                                    <option value="{{ $cidade->id }}" data-estado="{{ $cidade->estado }}">{{ $cidade->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="estado">Estado</label>
                            <input type="text" class="form-control" name="estado" readonly>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Criar Cliente</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateEstado(selectElement) {
            const estadoInput = selectElement.closest('.modal').querySelector('input[name="estado"]');
            const selectedOption = selectElement.options[selectElement.selectedIndex];

            if (selectedOption) {
                estadoInput.value = selectedOption.getAttribute('data-estado');
            }
        }
    </script>
@endsection
