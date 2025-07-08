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
{{-- <script> var urlSecao = ;</script> --}}
<script script src={{ asset('/vendor/libs/moment/moment.js') }}></script>
<script script src={{ asset('/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}></script>
<script script src={{ asset('/vendor/libs/select2/select2.js') }}></script>
<script script src={{ asset('/vendor/libs/@form-validation/popular.js') }}></script>
<script script src={{ asset('/vendor/libs/@form-validation/bootstrap5.js') }}></script>
<script script src={{ asset('/vendor/libs/@form-validation/auto-focus.js') }}></script>
<script script src={{ asset('/vendor/libs/@form-validation/auto-focus.js') }}></script>
<script script src={{ asset('/vendor/libs/cleave-zen/cleave-zen.js') }}></script>
<script script src={{ asset('/vendor/libs/sweetalert2/sweetalert2.js') }}></script>
<script src={{ asset('/js/pages/planodeferias.js') }}></script>
{{-- <script src={{ asset('/js/pages/app-user-list.js') }}></script> --}}
@endpush

@section('content')
    <!-- Users List Table -->
    <div class="card">
        <div class="card-header border-bottom">
            <h5 class="card-title mb-0">Plano de Férias</h5>
        </div>
        <div class="card-datatable">
            <table class="datatables-users table border-top">
                <thead>
                    <tr>
                        <th>Militar</th>
                        <th>Qtd. Parcelas</th>
                        <th>1º Período</th>
                        <th>2º Período</th>
                        <th>3º Período</th>
                        <th>Ano Referência</th> <!-- NOVA COLUNA -->
                        <th>Boletim</th>         <!-- NOVA COLUNA -->
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
        {{-- @php
            $options = [
                "Militar" => "militar.pg_nome",
                "Qtd. Parcelas" => "qtdparcelas",
                "1º Período" => "periodo1",
                "2º Período" => "periodo2",
                "3º Período" => "periodo3",
            ]   
        @endphp
        <x-datatable-component :options=$options id="dt-plano" link="{{route('getplanodeferias')}}" titulobotao="Adicionar Plano"/> --}}
        <!-- Offcanvas to add new user -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddUser" aria-labelledby="offcanvasAddUserLabel">
            <div class="offcanvas-header border-bottom">
                <h5 id="offcanvasAddUserLabel" class="offcanvas-title">Adicionar Plano de Férias</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body mx-0 flex-grow-0 p-6 h-100">
                <form class="add-new-user pt-0" id="form-secao" onsubmit="return false">
                    @csrf
                    <input type="hidden" class="form-control" id="id" name="id" />
                    <div class="mb-6 form-control-validation">
                        <label class="form-label" for="selMilitar">Militar</label>
                        <select id="selMilitar" name="militar_id" class="form-select">
                            <option value="">Selecione um militar</option>
                            @foreach ($militares as $militar)
                                <option value="{{$militar->id}}" > {{$militar->pg_nome}} </option>
                            @endforeach
                        </select>
                        <div id="dias-disponiveis" class="form-text mt-1"></div> <!-- NOVO ELEMENTO -->
                    </div>
                    <div class="mb-6 form-control-validation">
                        <label class="form-label" for="qtdparcelas">Qtd. Parcelas</label>
                        <select id="qtdparcelas" name="qtdparcelas" class="form-select" required>
                            <option value="">Selecione</option>
                            <option value="1">01 - 30 dias</option>
                            <option value="2">02 - 15 dias</option>
                            <option value="3">03 - 10 dias</option>
                        </select>
                    </div>
                    <div id="periodos-container">
                        <!-- Campos de períodos serão inseridos aqui via JS -->
                    </div>
                    <div class="mb-6 form-control-validation">
                        <label class="form-label" for="anoreferencia">Ano Referência</label>
                        <input type="text" id="anoreferencia" name="anoreferencia" class="form-control" placeholder="Ano Referência" maxlength="4" pattern="\d{4}" required aria-label="Ano Referência"/>
                    </div>
                    <div id="mudancas-container"></div>
                    <button type="button" class="btn btn-outline-secondary mb-3" id="btn-add-mudanca">
                        Mudança no Plano
                    </button>
                    {{-- O campo boletim permanece depois --}}
                    <div class="mb-6 form-control-validation">
                        <label class="form-label" for="boletim">Boletim</label>
                        <input type="text" id="boletim" name="boletim" class="form-control" placeholder="Informe o boletim" maxlength="100" required />
                    </div>
                    <button type="submit" class="btn btn-primary me-3 data-submit">Salvar</button>
                    <button type="reset" class="btn btn-label-danger" data-bs-dismiss="offcanvas">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
@endsection
