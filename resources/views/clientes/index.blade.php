@extends('layouts.app')

@section('title', 'Clientes')

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

    <h1 class="text-center font-weight-bold mb-4">Clientes</h1>
    <hr>

    <div class="row mb-3">
        <div class="col">
            <a href="{{ route('cidades.index') }}" class="btn btn-primary">Gerenciar Cidades</a>
            <a href="{{ route('representantes.index') }}" class="btn btn-primary">Gerenciar Representantes</a>
        </div>
        <div class="col-auto ml-auto">
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#createClientModal">
                Adicionar Cliente <i class="fas fa-plus"></i>
            </button>
        </div>
    </div>

    <!-- Formulário de Pesquisa de Clientes -->
    <div class="border p-4 mb-4" style="border-radius: 5px;">
        <h5>
            <button class="btn btn-info" id="toggleSearchForm" style="cursor: pointer;">
                Buscar Clientes
                <i class="fas fa-search"></i>
            </button>
        </h5>
        <form method="GET" action="{{ route('clientes.index') }}" id="searchForm" style="display: none;">
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="cpf">CPF</label>
                    <input type="text" class="form-control" name="cpf" id="cpf" placeholder="Digite o CPF"
                        value="{{ request('cpf') }}">
                </div>
                <div class="form-group col-md-4">
                    <label for="data_nascimento">Data de Nascimento</label>
                    <input type="date" class="form-control" name="data_nascimento" id="data_nascimento"
                        value="{{ request('data_nascimento') }}">
                </div>
                <div class="form-group col-md-4">
                    <label>Sexo</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="sexo" id="sexoM" value="M"
                            {{ request('sexo') == 'M' ? 'checked' : '' }}>
                        <label class="form-check-label" for="sexoM">Masculino</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="sexo" id="sexoF" value="F"
                            {{ request('sexo') == 'F' ? 'checked' : '' }}>
                        <label class="form-check-label" for="sexoF">Feminino</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="estado">Estado</label>
                    <input type="text" class="form-control" name="estado" id="estado"
                        value="{{ request('estado') }}">
                </div>
                <div class="form-group col-md-6">
                    <label for="cidade">Cidade</label>
                    <select class="form-control" name="cidade" id="cidade">
                        <option value="">Selecione uma cidade</option>
                        @foreach ($cidades as $cidade)
                            <option value="{{ $cidade->id }}" {{ request('cidade') == $cidade->id ? 'selected' : '' }}>
                                {{ $cidade->nome }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <br>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Pesquisar</button>
                <a href="{{ route('clientes.index') }}" class="btn btn-secondary">Limpar</a>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('toggleSearchForm').addEventListener('click', function() {
            const searchForm = document.getElementById('searchForm');
            if (searchForm.style.display === 'none' || searchForm.style.display === '') {
                searchForm.style.display = 'block';
            } else {
                searchForm.style.display = 'none';
            }
        });
    </script>

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
                            <td>{{ $cliente->cidade->nome ?? 'Sem cidade associada' }}</td>
                            <td>
                                <div class="d-flex">
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#editClientModal{{ $cliente->id }}">
                                        Editar
                                    </button>
                                    <div style="margin-left: 10px;">
                                        <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST"
                                            onsubmit="return confirm('Tem certeza que deseja deletar este cliente?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Deletar</button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <!-- Modal de Edição -->
                        <div class="modal fade" id="editClientModal{{ $cliente->id }}" tabindex="-1" role="dialog"
                            aria-labelledby="editClientModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editClientModalLabel">Editar Cliente</h5>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('clientes.update', $cliente->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group">
                                                <label for="nome">Nome</label>
                                                <input type="text" class="form-control" name="nome"
                                                    value="{{ $cliente->nome }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="cpf">CPF</label>
                                                <input type="text" class="form-control" name="cpf"
                                                    value="{{ $cliente->cpf }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="data_nascimento">Data de Nascimento</label>
                                                <input type="date" class="form-control" name="data_nascimento"
                                                    value="{{ $cliente->data_nascimento }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Sexo</label><br>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="sexo"
                                                        value="M" {{ $cliente->sexo == 'M' ? 'checked' : '' }}
                                                        required>
                                                    <label class="form-check-label">Masculino</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="sexo"
                                                        value="F" {{ $cliente->sexo == 'F' ? 'checked' : '' }}
                                                        required>
                                                    <label class="form-check-label">Feminino</label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="cidade">Cidade</label>
                                                <select class="form-control" name="cidade" required
                                                    onchange="updateEstado(this)">
                                                    <option value="" disabled>Selecione uma cidade</option>
                                                    @foreach ($cidades as $cidade)
                                                        <option value="{{ $cidade->id }}"
                                                            data-estado="{{ $cidade->estado }}"
                                                            {{ $cliente->cidade_id == $cidade->id ? 'selected' : '' }}>
                                                            {{ $cidade->nome }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="estado">Estado</label>
                                                <input type="text" class="form-control" name="estado"
                                                    value="{{ $cliente->estado }}" readonly>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Cancelar</button>
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
                                    <option value="{{ $cidade->id }}" data-estado="{{ $cidade->estado }}">
                                        {{ $cidade->nome }}
                                    </option>
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
