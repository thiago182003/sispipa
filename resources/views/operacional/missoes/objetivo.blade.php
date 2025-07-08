@extends('layouts.layout')

@section('content')
<div class="container">
    <h3>Cadastro de Objetivos</h3>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form method="POST" action="{{ route('objetivos.store') }}" class="mb-4">
        @csrf
        <div class="row g-2 align-items-center">
            <div class="col-auto">
                <input type="text" name="nome" class="form-control @error('nome') is-invalid @enderror" placeholder="Nome do Objetivo" required>
                @error('nome')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Cadastrar</button>
            </div>
        </div>
    </form>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Objetivo</th>
                <th style="width: 80px;">Ação</th>
            </tr>
        </thead>
        <tbody>
            @forelse($objetivos as $objetivo)
                <tr>
                    <td>
                        <span id="nome-objetivo-{{ $objetivo->id }}">{{ $objetivo->nome }}</span>
                        <form id="form-editar-{{ $objetivo->id }}" method="POST" action="{{ route('objetivos.update', $objetivo) }}" style="display:none;" class="d-inline">
                            @csrf
                            @method('PUT')
                            <input type="text" name="nome" value="{{ $objetivo->nome }}" class="form-control form-control-sm d-inline-block" style="width:180px;" required>
                            <button type="submit" class="btn btn-success btn-sm">Salvar</button>
                            <button type="button" class="btn btn-secondary btn-sm" onclick="cancelarEdicao({{ $objetivo->id }})">Cancelar</button>
                        </form>
                    </td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="editarObjetivo({{ $objetivo->id }}, '{{ addslashes($objetivo->nome) }}')">Editar</button>
                        <form method="POST" action="{{ route('objetivos.destroy', $objetivo) }}" onsubmit="return confirm('Excluir este objetivo?')" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Excluir</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="2">Nenhum objetivo cadastrado.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

<script>
function editarObjetivo(id, nome) {
    document.getElementById('nome-objetivo-' + id).style.display = 'none';
    document.getElementById('form-editar-' + id).style.display = 'inline-block';
}
function cancelarEdicao(id) {
    document.getElementById('form-editar-' + id).style.display = 'none';
    document.getElementById('nome-objetivo-' + id).style.display = '';
}
</script>