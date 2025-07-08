@extends('layouts.layout')

@push('styles')
<link rel="stylesheet" href="{{ asset('/vendor/libs/select2/select2.css') }}" />
<link rel="stylesheet" href="{{ asset('/vendor/libs/datatables-bs5/datatables-bootstrap5.css') }}" />
<link rel="stylesheet" href="{{ asset('/vendor/libs/sweetalert2/sweetalert2.css') }}" />
@endpush

@push('scripts')
<script src="{{ asset('/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
<script src="{{ asset('/vendor/libs/select2/select2.js') }}"></script>
<script src="{{ asset('/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
<script src="{{ asset('/js/pages/descontoemferias.js') }}"></script>
@endpush

@section('content')
<div class="card">
    <div class="card-header border-bottom d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Desconto em Férias</h5>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalDescontoFerias">
            <i class="bx bx-plus"></i> Adicionar Desconto
        </button>
    </div>
    <div class="card-datatable">
        <table class="datatables-descontos table border-top">
            <thead>
                <tr>
                    <th>Militar</th>
                    <th>Qtd Dias Descontados</th>
                    <th>DIEx</th>
                    <th>Ano de Referência</th>
                    <th>Ações</th>
                </tr>
            </thead>
        </table>
    </div>
    <!-- Modal para adicionar/editar desconto -->
    <div class="modal fade" id="modalDescontoFerias" tabindex="-1" aria-labelledby="modalDescontoFeriasLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="form-desconto" enctype="multipart/form-data" onsubmit="return false">
                @csrf
                <input type="hidden" id="id" name="id" />
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalDescontoFeriasLabel">Adicionar Desconto em Férias</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="militar_id" class="form-label">Militar</label>
                            <select id="militar_id" name="militar_id" class="form-select" required>
                                <option value="">Selecione</option>
                                @foreach ($militares as $militar)
                                    <option value="{{ $militar->id }}">
                                        {{ $militar->postoGraduacao->sigla ?? '' }}{{ $militar->veterano ? ' R/1 PTTC' : '' }} {{ $militar->nomeguerra }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="qtd_dias" class="form-label">Qtd Dias Descontados</label>
                            <input type="number" min="1" max="60" id="qtd_dias" name="qtd_dias" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="diex_numero" class="form-label">DIEx (número e complemento)</label>
                            <input type="text" id="diex_numero" name="diex_numero" class="form-control" required maxlength="100">
                        </div>
                        <div class="mb-3">
                            <label for="diex_arquivo" class="form-label">Upload DIEx (PDF)</label>
                            <input type="file" id="diex_arquivo" name="diex_arquivo" class="form-control" accept="application/pdf">
                        </div>
                        <div class="mb-3">
                            <label for="anoreferencia" class="form-label">Ano de Referência</label>
                            <input type="text" id="anoreferencia" name="anoreferencia" class="form-control" maxlength="4" pattern="\d{4}" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Salvar</button>
                        <button type="button" class="btn btn-label-danger" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection