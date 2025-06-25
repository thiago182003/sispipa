@extends('layouts.layout')

@push('styles')
    <link rel="stylesheet" href="{{ asset('/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('/vendor/libs/datatables-bs5/datatables-bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('/vendor/libs/datatables-responsive-bs5/reponsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('/vendor/libs/@form-validation/form-validation.css') }}" />
    <link rel="stylesheet" href="{{ asset('/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    {{-- <link rel="stylesheet" href="{{ asset('/css/jquery.dataTables.min.css') }}" /> --}}
@endpush
@push('scripts')
{{-- <script> var urlInstituicoes = ;</script> --}}
<script script src={{ asset('/vendor/libs/moment/moment.js') }}></script>
<script script src={{ asset('/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}></script>
<script script src={{ asset('/vendor/libs/select2/select2.js') }}></script>
<script script src={{ asset('/vendor/libs/@form-validation/popular.js') }}></script>
<script script src={{ asset('/vendor/libs/@form-validation/bootstrap5.js') }}></script>
<script script src={{ asset('/vendor/libs/@form-validation/auto-focus.js') }}></script>
<script script src={{ asset('/vendor/libs/@form-validation/auto-focus.js') }}></script>
<script script src={{ asset('/vendor/libs/cleave-zen/cleave-zen.js') }}></script>
<script script src={{ asset('/vendor/libs/sweetalert2/sweetalert2.js') }}></script>
<script src={{ asset('/js/pages/situacaofinanceira.js') }}></script>
{{-- <script src={{ asset('/js/pages/app-user-list.js') }}></script> --}}
@endpush

@section('content')
    <!-- Users List Table -->
    <div class="card">
        <div class="card-header border-bottom">
            <h5 class="card-title mb-0">Buscar Situações financeiras</h5>
        </div>
        <div class="card-datatable">
            <table class="dt-complex-header table table-bordered table-responsive">
                <thead>
                    <tr>
                        <th rowspan="2" class="col-1">Ano</th>
                        <th rowspan="2">mes</th>
                        <th colspan="3">pessoa fisica</th>
                        <th colspan="3">pessoa juridica</th>
                        <th rowspan="2" class="col-1">Ações</th>
                    </tr>
                    <tr>
                        <th>Não Liquidado</th>
                        <th>Liquidado</th>
                        <th>Pago</th>
                        <th>Não Liquidado</th>
                        <th>Liquidado</th>
                        <th>Pago</th>
                    </tr>
                </thead>
            </table>
        </div>
        <!-- Offcanvas to add new user -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddUser" aria-labelledby="offcanvasAddUserLabel">
            <div class="offcanvas-header border-bottom">
                <h5 id="offcanvasAddUserLabel" class="offcanvas-title">Adicionar Situação financeira</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body mx-0 flex-grow-0 p-6 h-100">
                <form class="add-new-user pt-0" id="form-instituicao" onsubmit="return false">
                    @csrf
                    <div class="mb-6 form-control-validation">
                        <label class="form-label" for="nome">Tipo</label>
                        <input type="hidden" class="form-control" id="id" name="id" />
                        <select type="text" class="form-control" id="nome" name="nome" placeholder="Nome da instituição"
                            aria-label="Nome da instituição" >
                            <option>Pessoa Fisica</option>
                            <option>Pessoa Juridica</option>
                        </select>
                    </div>
                    <div class="mb-6 form-control-validation">
                        <label class="form-label" for="nome">Mes</label>
                        <select class="select-control" id="nome" name="nome" placeholder="Nome da instituição"
                            aria-label="Nome da instituição" >
                            <option value="1">Janeiro</option>
                            <option value="2">Fevereiro</option>
                            <option value="3">Março</option>
                            <option value="4">Abril</option>
                            <option value="5">Maio</option>
                            <option value="6">Junho</option>
                            <option value="7">Julho</option>
                            <option value="8">Agosto</option>
                            <option value="9">Setembro</option>
                            <option value="10">Outubro</option>
                            <option value="11">Novembro</option>
                            <option value="12">Dezembro</option>
                        </select>
                    </div>
                    <div class="mb-6 form-control-validation">
                        <label class="form-label" for="nome">Ano</label>
                        <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome da instituição"
                            aria-label="Nome da instituição" />
                    </div>
                    <div class="mb-6 form-control-validation">
                        <label class="form-label" for="nome">Não Liquidado</label>
                        <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome da instituição"
                            aria-label="Nome da instituição" />
                    </div>
                    <div class="mb-6 form-control-validation">
                        <label class="form-label" for="nome">Liquidado</label>
                        <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome da instituição"
                            aria-label="Nome da instituição" />
                    </div>
                    <div class="mb-6 form-control-validation">
                        <label class="form-label" for="nome">Pago</label>
                        <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome da instituição"
                            aria-label="Nome da instituição" />
                    </div>
                    <button type="submit" class="btn btn-primary me-3 data-submit">Salvar</button>
                    <button type="reset" class="btn btn-label-danger" data-bs-dismiss="offcanvas">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
@endsection
