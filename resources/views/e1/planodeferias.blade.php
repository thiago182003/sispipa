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
                    <div class="mb-6 form-control-validation">
                        <input type="hidden" class="form-control" id="id" name="id" />
                        <label class="form-label" for="selMilitar">Militar</label>
                        <select id="selMilitar" name="selMilitar" class="form-select">
                            <option value="">Selecione um militar</option>
                            @foreach ($militares as $militar)
                                <option value="{{$militar->id}}" > {{$militar->pg_nome}} </option>
                            @endforeach
                        </select>
                        {{-- <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome da seção"
                            aria-label="Nome da seção" /> --}}
                    </div>
                    <div class="mb-6 form-control-validation">
                        <label class="form-label" for="qtdparcelas">Qtd. Parcelas</label>
                        <input type="number" min='1' max="3" id="qtdparcelas" name="qtdparcelas" class="form-control" placeholder="Quantidade de parcelas"
                            aria-label="Quantidade de parcelas"/>
                    </div>
                    <div class="mb-6 form-control-validation">
                        <label class="form-label" for="p1inicio">Inicio - 1º Periodo</label>
                        <input type="date" id="p1inicio" name="p1inicio" class="form-control" placeholder="Inicio - 1º Periodo"
                            aria-label="Inicio - 1º Periodo"/>
                    </div>
                    <div class="mb-6 form-control-validation">
                        <label class="form-label" for="p1fim">Fim - 1º Periodo</label>
                        <input type="date" id="p1fim" name="p1fim" class="form-control" placeholder="Fim - 1º Periodo"
                            aria-label="Fim - 1º Periodo"/>
                    </div>
                    <div class="mb-6 form-control-validation">
                        <label class="form-label" for="p2inicio">Inicio - 2º Periodo</label>
                        <input type="date" id="p2inicio" name="p2inicio" class="form-control" placeholder="Inicio - 2º Periodo"
                            aria-label="Inicio - 2º Periodo"/>
                    </div>
                    <div class="mb-6 form-control-validation">
                        <label class="form-label" for="p2fim">Fim - 2º Periodo</label>
                        <input type="date" id="p2fim" name="p2fim" class="form-control" placeholder="Fim - 2º Periodo"
                            aria-label="Fim - 2º Periodo"/>
                    </div>
                    <div class="mb-6 form-control-validation">
                        <label class="form-label" for="p3inicio">Inicio - 3º Periodo</label>
                        <input type="date" id="p3inicio" name="p3inicio" class="form-control" placeholder="Inicio - 3º Periodo"
                            aria-label="Inicio - 3º Periodo"/>
                    </div>
                    <div class="mb-6 form-control-validation">
                        <label class="form-label" for="p3fim">Fim - 3º Periodo</label>
                        <input type="date" id="p3fim" name="p3fim" class="form-control" placeholder="Fim - 3º Periodo"
                            aria-label="Fim - 3º Periodo"/>
                    </div>
                    <div class="mb-6 form-control-validation">
                        <label class="form-label" for="p3inicio">Ano Referência</label>
                        <input type="text" id="anoreferencia" name="anoreferencia" class="form-control" placeholder="Ano Referência"
                            aria-label="Ano Referência"/>
                    </div>
                    <button type="submit" class="btn btn-primary me-3 data-submit">Salvar</button>
                    <button type="reset" class="btn btn-label-danger" data-bs-dismiss="offcanvas">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
@endsection
