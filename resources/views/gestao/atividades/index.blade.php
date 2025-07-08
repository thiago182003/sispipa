@extends('layouts.layout')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.8/index.global.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.6.2/dist/select2-bootstrap4.min.css" rel="stylesheet" />
<style>
    .select2-container--bootstrap4 .select2-selection--single {
        height: calc(2.5rem + 2px);
        padding: 0.375rem 0.75rem;
        font-size: 1rem;
        border-radius: 0.375rem;
        border: 1px solid #ced4da;
        background-color: #fff;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.8/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/locales/pt-br.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var atividadeModal = new bootstrap.Modal(document.getElementById('atividadeModal'));
        var modalOpcoes = new bootstrap.Modal(document.getElementById('modalOpcoes'));
        var atividadeForm = document.getElementById('atividadeForm');
        var selectUsuario = document.getElementById('usuario');

        // Defina o onsubmit apenas uma vez
        atividadeForm.onsubmit = function(e) {
            e.preventDefault();
            fetch('{{ route('gestao.atividades.store') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    user_id: selectUsuario.value,
                    title: document.getElementById('title').value,
                    start: atividadeForm.dataset.start, // Usar data attribute para passar a data
                    end: document.getElementById('end').value,
                    color: '#007bff'
                })
            }).then(() => {
                calendar.refetchEvents();
                atividadeModal.hide();
            });
        };

        var calendar = new FullCalendar.Calendar(calendarEl, {
            locale: 'pt-br',
            selectable: true,
            editable: true,
            initialView: 'dayGridMonth',
            themeSystem: 'bootstrap5',
            events: '{{ route('administrativo.atividades.show') }}',
            select: function(info) {
                // Limpa o campo militar e outros campos do formulário
                $('#usuario').val(null).trigger('change'); // Limpa o Select2
                document.getElementById('title').value = '';
                document.getElementById('end').value = '';
                atividadeForm.dataset.start = info.startStr; // Salva a data selecionada
                atividadeModal.show();
            },
            eventClick: function(info) {
                // Exibe título, criador e seção
                document.getElementById('atividadeTitulo').innerHTML =
                    `<strong>${info.event.title}</strong>
                    <br><small>Criado por: ${info.event.extendedProps.criador}</small>
                    <br><small>Seção: ${info.event.extendedProps.secao}</small>`;
                document.getElementById('btnConcluir').onclick = function() {
                    fetch('{{ route('administrativo.atividades.update') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            id: info.event.id,
                            status: 'finalizada'
                        })
                    }).then(() => {
                        calendar.refetchEvents();
                        modalOpcoes.hide();
                    });
                };
                document.getElementById('btnExcluir').onclick = null;
                document.getElementById('btnExcluir').onclick = function() {
                    if (confirm('Você deseja realmente excluir esta atividade?')) {
                        fetch('{{ route('administrativo.atividades.destroy') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ id: info.event.id })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                calendar.refetchEvents();
                                modalOpcoes.hide();
                            } else {
                                alert('Erro ao excluir atividade!');
                            }
                        });
                    }
                };
                modalOpcoes.show();
            },
            eventDrop: function(info) {
                fetch('{{ route('administrativo.atividades.update') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        id: info.event.id,
                        title: info.event.title,
                        start: info.event.startStr,
                        color: info.event.backgroundColor
                    })
                }).then(() => calendar.refetchEvents());
            }
        });
        calendar.render();
    });

    $(document).ready(function() {
        $('#usuario').select2({
            dropdownParent: $('#atividadeModal'),
            theme: 'bootstrap4', // Troque para bootstrap4
            placeholder: 'Digite o nome do militar',
            ajax: {
                url: '{{ route('administrativo.militares.buscar') }}',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return { q: params.term };
                },
                processResults: function(data) {
                    return { results: data.results };
                },
                cache: true
            },
            minimumInputLength: 2
        });
    });
</script>

@endpush

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Atividades</h5>
    </div>
    <div class="card-body">
        <div id="calendar"></div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="atividadeModal" tabindex="-1" aria-labelledby="atividadeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="atividadeForm">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="atividadeModalLabel">Nova Atividade</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="usuario" class="form-label">Militar</label>
            <select id="usuario" name="usuario" required style="width: 100%;" class="select2-bootstrap4"></select>
          </div>
          <div class="mb-3">
            <label for="title" class="form-label">Atividade</label>
            <input type="text" class="form-control" id="title" name="title" required>
          </div>
          <div class="mb-3">
            <label for="end" class="form-label">Data limite</label>
            <input type="date" class="form-control" id="end" name="end" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Modal de Opções -->
<div class="modal fade" id="modalOpcoes" tabindex="-1" aria-labelledby="modalOpcoesLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalOpcoesLabel">Opções da Atividade</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body">
        <p id="atividadeTitulo"></p>
        <button type="button" class="btn btn-success" id="btnConcluir">Concluir Atividade</button>
        <button type="button" class="btn btn-danger" id="btnExcluir">Excluir Atividade</button>
      </div>
    </div>
  </div>
</div>
@endsection
