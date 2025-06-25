@extends('layouts.layout')

@push('styles')
    <link rel="stylesheet" href="{{ asset('/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('/vendor/libs/datatables-bs5/datatables-bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('/vendor/libs/datatables-responsive-bs5/reponsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('/vendor/libs/@form-validation/form-validation.css') }}" />
    <link rel="stylesheet" href="{{ asset('/vendor/libs/sweetalert2/sweetalert2.css') }}" />
@endpush

@push('scripts')
    <script script src={{ asset('/vendor/libs/moment/moment.js') }}></script>
    <script script src={{ asset('/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}></script>
    <script script src={{ asset('/vendor/libs/select2/select2.js') }}></script>
    <script script src={{ asset('/vendor/libs/@form-validation/popular.js') }}></script>
    <script script src={{ asset('/vendor/libs/@form-validation/bootstrap5.js') }}></script>
    <script script src={{ asset('/vendor/libs/@form-validation/auto-focus.js') }}></script>
    <script script src={{ asset('/vendor/libs/cleave-zen/cleave-zen.js') }}></script>
    <script script src={{ asset('/vendor/libs/sweetalert2/sweetalert2.js') }}></script>
    <script src={{ asset('/js/pages/novofinanceiro.js') }}></script>
@endpush

@section('content')
    <input type="hidden" value="{{ route('administrativo.instituicoes.getall') }}" id="urlInstituicoes" name="urlInstituicoes" />
    <div class="card">
        <div class="card-header border-bottom mb-3">
            <h5 class="card-title mb-0">Inserir situações financeiras</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('financeiro.store') }}">
                @csrf
                <input type="hidden" name="id" value="{{ $situacao->id ?? '' }}">

                <div class="row">
                    <div class="col-2 mb-4">
                        <label for="ano" class="form-label">Ano</label>
                        <input type="year" class="form-control" id="ano" name="ano" maxlength="4" value="{{ $situacao->ano ?? '' }}">
                    </div>
                    <div class="col-3 mb-4">
                        <label for="mes" class="form-label">Mês</label>
                        <select class="form-select" id="mes" name="mes">
                            @for ($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ (isset($situacao) && $situacao->mes == $i) ? 'selected' : '' }}>
                                    {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                                </option>
                            @endfor
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-2">
                        <label for="">Pessoa física</label>
                    </div>
                    <div class="col-3 mb-4">
                        <label for="pf_empenhado" class="form-label">Não Liquidado</label>
                        <input type="number" min="0" maxlength="15" class="form-control" id="pf_empenhado" name="pf_empenhado" value="{{ $situacao->pf_empenhado ?? '' }}">
                    </div>
                    <div class="col-3 mb-4">
                        <label for="pf_liquidado" class="form-label">Liquidado</label>
                        <input type="number" min="0" maxlength="15" class="form-control" id="pf_liquidado" name="pf_liquidado" value="{{ $situacao->pf_liquidado ?? '' }}">
                    </div>
                    <div class="col-3 mb-4">
                        <label for="pf_pago" class="form-label">Pago</label>
                        <input type="number" min="0" maxlength="15" class="form-control" id="pf_pago" name="pf_pago" value="{{ $situacao->pf_pago ?? '' }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-2">
                        <label for="">Pessoa Jurídica</label>
                    </div>
                    <div class="col-3 mb-4">
                        <label for="pj_empenhado" class="form-label">Não Liquidado</label>
                        <input type="number" min="0" maxlength="15" class="form-control" id="pj_empenhado" name="pj_empenhado" value="{{ $situacao->pj_empenhado ?? '' }}">
                    </div>
                    <div class="col-3 mb-4">
                        <label for="pj_liquidado" class="form-label">Liquidado</label>
                        <input type="number" min="0" maxlength="15" class="form-control" id="pj_liquidado" name="pj_liquidado" value="{{ $situacao->pj_liquidado ?? '' }}">
                    </div>
                    <div class="col-3 mb-4">
                        <label for="pj_pago" class="form-label">Pago</label>
                        <input type="number" min="0" maxlength="15" class="form-control" id="pj_pago" name="pj_pago" value="{{ $situacao->pj_pago ?? '' }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-2">
                        <button type="submit" class="btn btn-primary me-3 data-submit">Salvar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
