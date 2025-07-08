@extends('layouts.layout')

@section('content')
<div class="container">
    <h1 class="mb-4">Criar Missão</h1>
    <form action="{{ route('operacional.missoes.store') }}" method="POST">
        @csrf
        <div class="mb-3 row">
            <label class="form-label col-12">Período da missão:</label>
            <div class="col-md-6 mb-2 mb-md-0">
                <input type="date" name="data_inicio" class="form-control" required>
            </div>
            <div class="col-md-6">
                <input type="date" name="data_fim" class="form-control" required>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Objetivos da Missão:</label>
            <table class="table table-bordered align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width: 70px;">Selecionar</th>
                        <th>Nome do Objetivo</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($objetivos as $objetivo)
                    <tr>
                        <td class="text-center">
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input objetivo-checkbox" id="objetivo-{{ $objetivo->id }}" name="objetivos[]" value="{{ $objetivo->id }}" onchange="toggleObjetivo('{{ $objetivo->id }}')">
                            </div>
                        </td>
                        <td>
                            <label for="objetivo-{{ $objetivo->id }}" class="mb-0">{{ $objetivo->nome }}</label>
                            <div class="municipios-objetivo mt-2" id="municipios-objetivo-{{ $objetivo->id }}" style="display:none;">
                                <label class="form-label">Municípios para este objetivo:</label>
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control municipio-autocomplete" id="autocomplete-{{ $objetivo->id }}" placeholder="Digite o nome do município" autocomplete="off" oninput="mostrarSugestoes('{{ $objetivo->id }}')">
                                    <button type="button" class="btn btn-primary" onclick="adicionarMunicipio({{ $objetivo->id }})">Adicionar</button>
                                </div>
                                <div class="list-group position-absolute w-50 sugestoes-municipio" id="sugestoes-{{ $objetivo->id }}" style="z-index:10;"></div>
                                <div id="municipios-{{ $objetivo->id }}-list" class="mb-2"></div>
                                <input type="hidden" name="municipios_por_objetivo[{{ $objetivo->id }}]" id="input-{{ $objetivo->id }}">
                                <small class="text-muted">Digite e selecione municípios para este objetivo.</small>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mb-3">
            <label class="form-label">Nome dos militares que irão:</label>
            <div id="militares-lista">
                @for($i=1; $i<=2; $i++)
                <div class="d-flex mb-2 align-items-center position-relative">
                    <input type="text" class="form-control me-2 autocomplete-militar" 
                           name="militares[{{ $i }}][autocomplete]" 
                           placeholder="Digite o nome do militar..." 
                           autocomplete="off"
                           data-index="{{ $i }}">
                    <input type="hidden" name="militares[{{ $i }}][id]" class="militar-id-hidden">
                    <div class="list-group position-absolute w-100 sugestoes-militar" style="z-index:10; top:100%; left:0;"></div>
                    <button type="button" class="btn btn-secondary ms-2" onclick="liberarManual(this)">Militar não listado</button>
                </div>
                @endfor
            </div>
            <button type="button" class="btn btn-link" onclick="adicionarMilitar()">Adicionar Militar</button>
        </div>
        <button type="submit" class="btn btn-success">Salvar Missão</button>
    </form>
</div>
<script>
window.municipiosArray = @json($municipios->pluck('nome'));
window.militaresArray = @json($militares->map(function($m){
    return [
        'id' => $m->id,
        'nome' => ($m->postoGraduacao->nome ?? '') . ' ' . $m->nomeguerra . ' (' . ($m->omServico->nome ?? '') . ')'
    ];
}));
window.postosOptionsHtml = `{!! collect($postos)->map(function($posto){
    return '<option value="' . $posto->id . '">' . $posto->nome . '</option>';
})->implode('') !!}`;
window.omsOptionsHtml = `{!! collect($oms)->map(function($om){
    return '<option value="' . $om->id . '">' . $om->nome . '</option>';
})->implode('') !!}`;
</script>
<script src="{{ asset('js/pages/missoes.js') }}"></script>
<style>
.list-group.position-absolute {
    background: #fff;
    border: 1px solid #dee2e6;
    border-radius: 0.375rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}
.list-group.position-absolute .list-group-item {
    background: #fff;
    cursor: pointer;
}
.list-group.position-absolute .list-group-item:hover {
    background: #f1f3f4;
}
.manual-fields input,
.manual-fields select {
    min-width: 150px;
    margin-bottom: 0;
}
.manual-fields .btn {
    margin-top: 4px;
}
.manual-fields {
    width: 100%;
}
</style>
@endsection