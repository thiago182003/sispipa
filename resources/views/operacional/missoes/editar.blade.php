{{-- filepath: c:\Users\pipa\sysrm\resources\views\operacional\missoes\editar.blade.php --}}
@extends('layouts.layout')

@section('content')
<div class="container">
    <h1 class="mb-4">Editar Missão</h1>
    <form action="{{ route('operacional.missoes.update', $missao->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3 row">
            <label class="form-label col-12">Período da missão:</label>
            <div class="col-md-6 mb-2 mb-md-0">
                <input type="date" name="data_inicio" class="form-control" value="{{ $missao->data_inicio }}" required>
            </div>
            <div class="col-md-6">
                <input type="date" name="data_fim" class="form-control" value="{{ $missao->data_fim }}" required>
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
                    @foreach(\App\Models\Objetivo::orderBy('nome')->get() as $objetivo)
                    <tr>
                        <td class="text-center">
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input objetivo-checkbox"
                                    id="objetivo-{{ $objetivo->id }}"
                                    name="objetivos[]" value="{{ $objetivo->id }}"
                                    onchange="toggleObjetivo('{{ $objetivo->id }}')"
                                    {{ array_key_exists($objetivo->nome, $missao->objetivos ?? []) ? 'checked' : '' }}>
                            </div>
                        </td>
                        <td>
                            <label for="objetivo-{{ $objetivo->id }}" class="mb-0">{{ $objetivo->nome }}</label>
                            <div class="municipios-objetivo mt-2" id="municipios-objetivo-{{ $objetivo->id }}" style="{{ array_key_exists($objetivo->nome, $missao->objetivos ?? []) ? '' : 'display:none;' }}">
                                <label class="form-label">Municípios para este objetivo:</label>
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control municipio-autocomplete"
                                           id="autocomplete-{{ $objetivo->id }}"
                                           placeholder="Digite o nome do município"
                                           autocomplete="off"
                                           oninput="mostrarSugestoes('{{ $objetivo->id }}')">
                                    <button type="button" class="btn btn-primary" onclick="adicionarMunicipio({{ $objetivo->id }})">Adicionar</button>
                                </div>
                                <div class="list-group position-absolute w-50 sugestoes-municipio" id="sugestoes-{{ $objetivo->id }}" style="z-index:10;"></div>
                                <div id="municipios-{{ $objetivo->id }}-list" class="mb-2">
                                    @if(array_key_exists($objetivo->nome, $missao->objetivos ?? []))
                                        @foreach($missao->objetivos[$objetivo->nome] as $municipio)
                                            <span class="badge bg-primary me-2 mb-2">{{ $municipio }}</span>
                                        @endforeach
                                    @endif
                                </div>
                                <input type="hidden" name="municipios_por_objetivo[{{ $objetivo->id }}]" id="input-{{ $objetivo->id }}"
                                    value='@json($missao->objetivos[$objetivo->nome] ?? [])'>
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
                @php
                    $militaresMissao = $missao->militares ?? [];
                    $militaresMissao = array_values($militaresMissao);
                    $total = max(count($militaresMissao), 2);
                @endphp
                @for($i=0; $i<$total; $i++)
                <div class="d-flex mb-2 align-items-center position-relative">
                    <input type="text" class="form-control me-2 autocomplete-militar"
                           name="militares[{{ $i+1 }}][autocomplete]"
                           placeholder="Digite o nome do militar..."
                           autocomplete="off"
                           data-index="{{ $i+1 }}"
                           value="{{ $militaresMissao[$i]['autocomplete'] ?? '' }}">
                    <input type="hidden" name="militares[{{ $i+1 }}][id]" class="militar-id-hidden"
                           value="{{ $militaresMissao[$i]['id'] ?? '' }}">
                    <div class="list-group position-absolute w-100 sugestoes-militar" style="z-index:10; top:100%; left:0;"></div>
                    <button type="button" class="btn btn-secondary ms-2" onclick="liberarManual(this)">Militar não listado</button>
                </div>
                @endfor
            </div>
            <button type="button" class="btn btn-link" onclick="adicionarMilitar()">Adicionar Militar</button>
        </div>
        <button type="submit" class="btn btn-success">Salvar Alterações</button>
        <a href="{{ route('operacional.missoes.index') }}" class="btn btn-secondary">Cancelar</a>
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
window.militaresArray = {!! $militares->map(function($m){
    return [
        'id' => $m->id,
        'nome' => ($m->postoGraduacao->nome ?? '') . ' ' . $m->nomeguerra . ' (' . ($m->omServico->nome ?? '') . ')'
    ];
})->toJson() !!};
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
.manual-fields {
    width: 100%;
}
.manual-fields input,
.manual-fields select {
    min-width: 150px;
    margin-bottom: 0;
}
.manual-fields .btn {
    margin-top: 4px;
}
</style>
@endsection

<script>
function liberarManual(btn) {
    let div = btn.closest('.d-flex');
    // Remove autocomplete e id oculto
    div.querySelector('.autocomplete-militar').value = '';
    div.querySelector('.militar-id-hidden').value = '';
    // Adiciona campos manuais se não existirem
    if (!div.querySelector('.manual-fields')) {
        let manualFields = document.createElement('div');
        manualFields.className = 'manual-fields d-flex flex-wrap align-items-center gap-2 mt-2';
        manualFields.innerHTML = `
            <input type="text" class="form-control" name="${div.querySelector('.autocomplete-militar').name.replace('[autocomplete]', '[nome]')}" placeholder="Nome completo do militar" required>
            <select class="form-select" name="${div.querySelector('.autocomplete-militar').name.replace('[autocomplete]', '[postograduacao_id]')}" required>
                <option value="">Posto/Graduação</option>
                ${window.postosOptionsHtml}
            </select>
            <select class="form-select" name="${div.querySelector('.autocomplete-militar').name.replace('[autocomplete]', '[om_servico_id]')}" required>
                <option value="">OM</option>
                ${window.omsOptionsHtml}
            </select>
        `;
        div.appendChild(manualFields);
    }
    // Desabilita autocomplete
    div.querySelector('.autocomplete-militar').setAttribute('readonly', true);
    btn.disabled = true;
}

</script>