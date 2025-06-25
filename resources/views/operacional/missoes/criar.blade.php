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
            <label class="form-label">Objetivo da Missão:</label>
            <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" id="cloro" onchange="toggleObjetivo('cloro')">
                <label class="form-check-label" for="cloro">Entrega de Cloro</label>
            </div>
            <div id="objetivo-cloro" class="ms-4 mb-3" style="display:none;">
                <div id="municipios-cloro-list" class="mb-2"></div>
                <div class="input-group mb-2" style="max-width:400px;">
                    <input type="text" class="form-control" id="autocomplete-cloro" placeholder="Digite o nome do município..." autocomplete="off" oninput="mostrarSugestoes('cloro')">
                    <button type="button" class="btn btn-success" onclick="adicionarMunicipio('cloro')">Adicionar</button>
                </div>
                <div id="sugestoes-cloro" class="list-group position-absolute" style="z-index:10; max-width:400px;"></div>
                <input type="hidden" name="objetivos[Entrega de Cloro]" id="input-cloro">
            </div>
            <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" id="compdec" onchange="toggleObjetivo('compdec')">
                <label class="form-check-label" for="compdec">Visita Compdec</label>
            </div>
            <div id="objetivo-compdec" class="ms-4 mb-3" style="display:none;">
                <div id="municipios-compdec-list" class="mb-2"></div>
                <div class="input-group mb-2" style="max-width:400px;">
                    <input type="text" class="form-control" id="autocomplete-compdec" placeholder="Digite o nome do município..." autocomplete="off" oninput="mostrarSugestoes('compdec')">
                    <button type="button" class="btn btn-success" onclick="adicionarMunicipio('compdec')">Adicionar</button>
                </div>
                <div id="sugestoes-compdec" class="list-group position-absolute" style="z-index:10; max-width:400px;"></div>
                <input type="hidden" name="objetivos[Visita CompDec]" id="input-compdec">
            </div>
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
window.militaresOptionsHtml = `{!! collect($militares)->map(function($militar){
    return '<option value="' . $militar->id . '">' .
        ($militar->postoGraduacao->nome ?? 'Sem posto') . ' ' .
        $militar->nomeguerra . ' (OM: ' . ($militar->omServico->nome ?? 'Sem OM') . ')' .
        '</option>';
})->implode('') !!}`;
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
</style>
@endsection