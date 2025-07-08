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
<form id="form-editar-{{ $objetivo->id }}"
      method="POST"
      action="{{ route('objetivos.update', $objetivo->id) }}"
      class="d-inline form-editar-objetivo"
      style="display: none !important;">
    @csrf
    @method('PUT')
    <input type="text" name="nome" value="{{ $objetivo->nome }}"
           class="form-control-sm d-inline-block" style="width:180px;" required>
    <button type="submit" class="btn btn-success btn-sm">Salvar</button>
    <button type="button" class="btn btn-secondary btn-sm"
            onclick="cancelarEdicao({{ $objetivo->id }})">Cancelar</button>
</form>

                    </td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="editarObjetivo({{ $objetivo->id }})">Editar</button>
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

@push('scripts')
<script>
    function editarObjetivo(id) {
    // Esconde todos os formulários e mostra todos os textos
    document.querySelectorAll('.form-editar-objetivo').forEach(f => f.style.display = 'none');
    document.querySelectorAll('[id^="nome-objetivo-"]').forEach(s => s.style.display = '');

    // Esconde o texto e mostra o formulário do objetivo clicado
    document.getElementById('nome-objetivo-' + id).style.display = 'none';
    document.getElementById('form-editar-' + id).style.display = 'inline-block';
}

function cancelarEdicao(id) {
    const form = document.getElementById('form-editar-' + id);
    const span = document.getElementById('nome-objetivo-' + id);

    // Garante que o form suma, mesmo com estilos inline ou herdados
    form.style.display = 'none';
    form.classList.remove('d-inline'); // Evita conflitos com Bootstrap
    form.classList.add('d-none');

    // Garante que o span apareça corretamente
    span.style.display = '';
}
</script>
<style>
.form-editar-objetivo {
    display: none;
    margin-top: 5px;
}

</style>
@endpush