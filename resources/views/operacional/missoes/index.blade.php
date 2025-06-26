@extends('layouts.layout')
@section('content')
<div class="container">
    <h1>Missões</h1>
    <a href="{{ route('operacional.missoes.create') }}" class="btn btn-primary mb-3">Criar nova missão</a>
    <table class="table">
        <thead>
            <tr>
                <th>Período</th>
                <th>Objetivos</th>
                <th>Militares</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($missoes as $missao)
                <tr id="missao-row-{{ $missao->id }}">
                    <td>{{ $missao->data_inicio }} a {{ $missao->data_fim }}</td>
                    <td>
                        @foreach($missao->objetivos as $objetivo => $municipios)
                            @php
                                $municipios_filtrados = array_filter($municipios, fn($m) => !empty($m));
                            @endphp
                            @if(count($municipios_filtrados) > 0)
                                <strong>{{ $objetivo }}</strong>
                                <ul>
                                    @foreach($municipios_filtrados as $municipio)
                                        <li>{{ $municipio }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        @endforeach
                    </td>
                    <td>
                        <ul>
                        @foreach($missao->militares_detalhados ?? [] as $militar)
                            <li>
                                {{ $militar['postograduacao'] }} {{ $militar['nomeguerra'] }} ({{ $militar['om_servico'] }})
                            </li>
                        @endforeach
                        </ul>
                    </td>
                    <td>
                        <div id="status-marcador-{{ $missao->id }}">
                            @if($missao->status === 'aprovado')
                                <span class="badge bg-success">Aprovado</span>
                            @elseif($missao->status === 'reprovado')
                                <span class="badge bg-danger">Reprovado</span>
                            @elseif($missao->status === 'parcial')
                                <span class="badge bg-warning text-dark">Aprovada Parcialmente</span>
                                @if($missao->observacao)
                                    <span class="text-muted" style="font-size:0.9em;opacity:0.7;">{{ $missao->observacao }}</span>
                                @endif
                            @endif
                        </div>
                        <div class="mt-2">
                            <span id="botoes-status-{{ $missao->id }}">
                                @if(is_null($missao->status) || $missao->status === '' || $missao->status === 'null')
                                    <button class="btn btn-sm btn-success" onclick="confirmarStatus({{ $missao->id }}, 'aprovado')">Aprovado</button>
                                    <button class="btn btn-sm btn-danger" onclick="confirmarStatus({{ $missao->id }}, 'reprovado')">Reprovado</button>
                                    <button class="btn btn-sm btn-warning text-dark" onclick="confirmarStatus({{ $missao->id }}, 'parcial')">Aprovada Parcialmente</button>
                                @endif
                            </span>
                            <a href="{{ route('operacional.missoes.edit', $missao->id) }}" class="btn btn-sm btn-primary ms-2">Editar</a>
                            <button class="btn btn-sm btn-outline-danger ms-1" onclick="excluirMissao({{ $missao->id }})">Excluir</button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal Observação -->
<div class="modal fade" id="modalObservacao" tabindex="-1" aria-labelledby="modalObservacaoLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="formObservacao" onsubmit="enviarStatusParcial(event)">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalObservacaoLabel">Observações</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">
          <textarea class="form-control" id="observacaoInput" name="observacao" rows="3" placeholder="Digite a observação..."></textarea>
          <input type="hidden" id="missaoIdParcial">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-warning text-dark">Confirmar Parcial</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
function confirmarStatus(missaoId, status) {
    let msg = '';
    if (status === 'aprovado') msg = 'Deseja realmente aprovar esta missão?';
    if (status === 'reprovado') msg = 'Deseja realmente reprovar esta missão?';
    if (status === 'parcial') {
        // Abre modal para observação
        document.getElementById('missaoIdParcial').value = missaoId;
        document.getElementById('observacaoInput').value = '';
        let modal = new bootstrap.Modal(document.getElementById('modalObservacao'));
        modal.show();
        return;
    }
    if (confirm(msg)) {
        enviarStatus(missaoId, status);
    }
}

function enviarStatus(missaoId, status, observacao = null) {
    fetch("{{ url('operacional/missoes') }}/" + missaoId + "/status", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ status, observacao })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            let marcadorDiv = document.getElementById('status-marcador-' + missaoId);
            let html = '';
            if (data.status === 'aprovado') html = '<span class="badge bg-success">Aprovado</span>';
            if (data.status === 'reprovado') html = '<span class="badge bg-danger">Reprovado</span>';
            if (data.status === 'parcial') {
                html = '<span class="badge bg-warning text-dark">Aprovada Parcialmente</span>';
                if (data.observacao) {
                    html += ' <span class="text-muted" style="font-size:0.9em;opacity:0.7;">' + data.observacao + '</span>';
                }
            }
            marcadorDiv.innerHTML = html;
            // Esconde os botões
            let botoesDiv = document.getElementById('botoes-status-' + missaoId);
            if (botoesDiv) botoesDiv.style.display = 'none';
        }
    });
}

// Envio do status parcial com observação
function enviarStatusParcial(event) {
    event.preventDefault();
    let missaoId = document.getElementById('missaoIdParcial').value;
    let observacao = document.getElementById('observacaoInput').value;
    if (!observacao.trim()) {
        alert('Digite uma observação.');
        return;
    }
    if (confirm('Deseja realmente aprovar parcialmente esta missão?')) {
        let modal = bootstrap.Modal.getInstance(document.getElementById('modalObservacao'));
        modal.hide();
        enviarStatus(missaoId, 'parcial', observacao);
    }
}

function excluirMissao(missaoId) {
    if (confirm('Tem certeza que deseja excluir esta missão?')) {
        fetch("{{ url('operacional/missoes') }}/" + missaoId, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                // Remove a linha da tabela
                let row = document.getElementById('missao-row-' + missaoId);
                if (row) row.remove();
            }
        });
    }
}
</script>
@endsection