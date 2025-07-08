@extends('layouts.layout')

@section('content')
<div class="container mt-4">
    <h3>Itinerários</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Botão para abrir o modal -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalItinerario">
        Criar Itinerário
    </button>

    <!-- Modal de criação -->
    <div class="modal fade" id="modalItinerario" tabindex="-1" aria-labelledby="modalItinerarioLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('operacional.itinerarios.store') }}" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalItinerarioLabel">Novo Itinerário</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="municipio">Município:</label>
                        <input type="text" id="municipioInput" name="municipio" class="form-control" placeholder="Digite o nome do município" required autocomplete="off">
                        <div id="municipioSuggestions" class="list-group" style="display: none;"></div>
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
                <th>Município</th>
                <th style="width: 140px;">Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($itinerarios as $itinerario)
                <tr>
                    <td>
                        <span id="nome-itinerario-{{ $itinerario->id }}">{{ $itinerario->municipio }}</span>

                        <form id="form-editar-{{ $itinerario->id }}" method="POST"
                              action="{{ route('operacional.itinerarios.update', $itinerario->id) }}"
                              class="d-none d-inline-block form-editar-itinerario">
                            @csrf
                            @method('PUT')
                            <div class="input-group">
                                <input type="text" name="municipio" value="{{ $itinerario->municipio }}"
                                       class="form-control form-control-sm" style="width:200px;" required>
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
                <tr><td colspan="2">Nenhum itinerário encontrado.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
<script>
    // Autocomplete para municípios
    $(document).ready(function() {
        const municipioInput = $('#municipioInput');
        const suggestionsDiv = $('#municipioSuggestions');
        
        municipioInput.on('input', function() {
            const term = $(this).val();
            
            if (term.length > 2) {
                $.get('{{ route("operacional.itinerarios.index") }}', { term: term }, function(data) {
                    suggestionsDiv.empty();
                    
                    if (data.length > 0) {
                        data.forEach(function(municipio) {
                            suggestionsDiv.append(
                                `<a href="#" class="list-group-item list-group-item-action" 
                                   onclick="selectMunicipio('${municipio}')">${municipio}</a>`
                            );
                        });
                        suggestionsDiv.show();
                    } else {
                        suggestionsDiv.hide();
                    }
                });
            } else {
                suggestionsDiv.hide();
            }
        });
        
        // Esconder sugestões ao clicar fora
        $(document).click(function(e) {
            if (!$(e.target).closest('#municipioInput, #municipioSuggestions').length) {
                suggestionsDiv.hide();
            }
        });
    });
    
    function selectMunicipio(municipio) {
        $('#municipioInput').val(municipio);
        $('#municipioSuggestions').hide();
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
</script>
@endpush

@push('styles')
<style>
    #municipioSuggestions {
        position: absolute;
        z-index: 1000;
        width: 100%;
        max-height: 200px;
        overflow-y: auto;
    }
    .list-group-item {
        cursor: pointer;
    }
    .list-group-item:hover {
        background-color: #f8f9fa;
    }
</style>
@endpush