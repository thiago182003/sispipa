@extends('layouts.layout')

@section('content')
<div class="container mt-4">
    <h3>Itinerários</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalItinerario">
        Criar Itinerário
    </button>

    <!-- Modal de criação -->
<div class="modal fade" id="modalItinerario" tabindex="-1" aria-labelledby="modalItinerarioLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="formItinerario" method="POST" action="{{ route('operacional.itinerarios.store') }}" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="modalItinerarioLabel">Novo Itinerário</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Municípios:</label>
                    <div id="municipios-container">
                        <div class="input-group mb-2 municipio-group">
                            <input type="text" name="municipios[]" class="form-control municipio-input" placeholder="Digite o nome do município" autocomplete="off" required>
                            <div class="list-group municipio-suggestions" style="display: none; position: absolute; z-index: 1000; width: calc(100% - 38px);"></div>
                            <button type="button" class="btn btn-success add-municipio">+</button>
                        </div>
                        <div class="input-group mb-2 municipio-group">
                            <input type="text" name="municipios[]" class="form-control municipio-input" placeholder="Digite o nome do município" autocomplete="off" required>
                            <div class="list-group municipio-suggestions" style="display: none; position: absolute; z-index: 1000; width: calc(100% - 38px);"></div>
                            <button type="button" class="btn btn-danger remove-municipio">-</button>
                        </div>
                    </div>
                    <small class="text-muted">Adicione pelo menos 2 municípios. Clique no botão "+" para adicionar mais.</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Salvar</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </form>
    </div>
</div>
    <!-- Tabela -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Número</th>
                <th>Municípios</th>
                <th style="width: 140px;">Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($itinerarios as $itinerario)
                <tr>
                    <td>{{ $itinerario->numero }}</td>
                    <td>
                        <span id="nome-itinerario-{{ $itinerario->id }}">
                            {{ implode(', ', $itinerario->municipios) }}
                        </span>

                        <form id="form-editar-{{ $itinerario->id }}" method="POST"
                              action="{{ route('operacional.itinerarios.update', $itinerario->id) }}"
                              class="d-none d-inline-block form-editar-itinerario">
                            @csrf
                            @method('PUT')
                            <div id="edit-municipios-container-{{ $itinerario->id }}" class="mb-2">
                                @foreach($itinerario->municipios as $index => $municipio)
                                <div class="input-group mb-2 municipio-group">
                                    <input type="text" name="municipios[]" value="{{ $municipio }}" 
                                           class="form-control form-control-sm municipio-input" required>
                                    <div class="list-group municipio-suggestions" style="display: none; position: absolute; z-index: 1000; width: calc(100% - 38px);"></div>
                                    @if($index > 1)
                                        <button type="button" class="btn btn-sm btn-danger remove-municipio">-</button>
                                    @elseif($index === 0)
                                        <button type="button" class="btn btn-sm btn-success add-municipio">+</button>
                                    @else
                                        <button type="button" class="btn btn-sm btn-danger remove-municipio">-</button>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                            <div class="input-group">
                                <button type="submit" class="btn btn-success btn-sm">Salvar</button>
                                <button type="button" class="btn btn-secondary btn-sm" onclick="cancelarEdicao({{ $itinerario->id }})">Cancelar</button>
                            </div>
                        </form>
                    </td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="editarItinerario({{ $itinerario->id }})">Editar</button>
                        <form action="{{ route('operacional.itinerarios.destroy', $itinerario->id) }}"
                              method="POST" class="d-inline"
                              onsubmit="return confirm('Excluir este itinerário?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Excluir</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="3">Nenhum itinerário encontrado.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Adicionar novo campo de município
    $(document).on('click', '.add-municipio', function() {
        const container = $(this).closest('#municipios-container, #edit-municipios-container');
        const newGroup = $(`
            <div class="input-group mb-2 municipio-group">
                <input type="text" name="municipios[]" class="form-control municipio-input" placeholder="Digite o nome do município" autocomplete="off" required>
                <div class="list-group municipio-suggestions" style="display: none; position: absolute; z-index: 1000; width: calc(100% - 38px);"></div>
                <button type="button" class="btn btn-danger remove-municipio">-</button>
            </div>
        `);
        container.append(newGroup);
        setupAutocomplete(newGroup.find('.municipio-input'), newGroup.find('.municipio-suggestions'));
    });

    // Remover campo de município
    $(document).on('click', '.remove-municipio', function() {
        const container = $(this).closest('#municipios-container, #edit-municipios-container');
        const groups = container.find('.municipio-group');
        
        if (groups.length > 2) {
            $(this).closest('.municipio-group').remove();
        } else {
            alert('O itinerário deve ter pelo menos dois municípios!');
        }
    });

    // Configurar autocomplete para todos os campos existentes e novos
    function setupAutocomplete(input, suggestions) {
        input.on('input', function() {
            const term = $(this).val();
            
            if (term.length > 2) {
                $.get('{{ route("operacional.itinerarios.buscar-municipios") }}', { term: term }, function(data) {
                    suggestions.empty();
                    
                    if (data.length > 0) {
                        data.forEach(function(municipio) {
                            suggestions.append(
                                `<a href="#" class="list-group-item list-group-item-action" 
                                   onclick="selectMunicipio(this, '${municipio}')">${municipio}</a>`
                            );
                        });
                        suggestions.show();
                    } else {
                        suggestions.hide();
                    }
                });
            } else {
                suggestions.hide();
            }
        });
    }

    // Configurar autocomplete para campos existentes
    $('.municipio-input').each(function() {
        const input = $(this);
        const suggestions = input.next('.municipio-suggestions');
        setupAutocomplete(input, suggestions);
    });

    // Esconder sugestões ao clicar fora
    $(document).click(function(e) {
        if (!$(e.target).closest('.municipio-input, .municipio-suggestions').length) {
            $('.municipio-suggestions').hide();
        }
    });
});

function selectMunicipio(element, municipio) {
    const input = $(element).closest('.municipio-group').find('.municipio-input');
    input.val(municipio);
    $(element).closest('.municipio-suggestions').hide();
}

function editarItinerario(id) {
    document.querySelectorAll('.form-editar-itinerario').forEach(f => f.classList.add('d-none'));
    document.querySelectorAll('[id^="nome-itinerario-"]').forEach(s => s.style.display = '');

    document.getElementById('nome-itinerario-' + id).style.display = 'none';
    document.getElementById('form-editar-' + id).classList.remove('d-none');
}

function cancelarEdicao(id) {
    document.getElementById('form-editar-' + id).classList.add('d-none');
    document.getElementById('nome-itinerario-' + id).style.display = '';
}
// Manipular o envio do formulário via AJAX
$('#formItinerario').on('submit', function(e) {
    e.preventDefault();
    
    // Validar se há pelo menos 2 municípios preenchidos
    let municipiosValidos = 0;
    $('.municipio-input').each(function() {
        if ($(this).val().trim() !== '') {
            municipiosValidos++;
        }
    });
    
    if (municipiosValidos < 2) {
        alert('Por favor, adicione pelo menos 2 municípios válidos');
        return false;
    }
    
    // Enviar o formulário via AJAX
    $.ajax({
        url: $(this).attr('action'),
        method: 'POST',
        data: $(this).serialize(),
        success: function(response) {
            // Fechar o modal
            $('#modalItinerario').modal('hide');
            
            // Recarregar a página para mostrar o novo itinerário
            location.reload();
            
            // Mostrar mensagem de sucesso
            alert('Itinerário criado com sucesso!');
        },
        error: function(xhr) {
            // Mostrar mensagem de erro
            alert('Erro ao criar itinerário: ' + xhr.responseJSON.message);
        }
    });
});
</script>
@endpush

@push('styles')
<style>
    .municipio-suggestions {
        max-height: 200px;
        overflow-y: auto;
        background-color: white;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .list-group-item {
        cursor: pointer;
        border: none;
        border-bottom: 1px solid #eee;
        padding: 8px 12px;
    }
    .list-group-item:last-child {
        border-bottom: none;
    }
    .list-group-item:hover {
        background-color: #f8f9fa;
        color: #0d6efd;
    }
    .municipio-group {
        position: relative;
    }
</style>
@endpush