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
<script src={{ asset('/js/pages/modulos.js') }}></script>
{{-- <script src={{ asset('/js/pages/app-user-list.js') }}></script> --}}
@endpush

@section('content')
    <input type="hidden" value="{{route('administrativo.instituicoes.getall')}}" id="urlInstituicoes" name="urlInstituicoes" />
    <!-- Users List Table -->
    <div class="card">
        <div class="card-header border-bottom">
            <h5 class="card-title mb-0">Buscar Modulos</h5>
            <div class="d-flex justify-content-between align-items-center row pt-4 gap-md-0 g-6">
                <div class="col-md-4 user_role"></div>
                <div class="col-md-4 user_plan"></div>
                <div class="col-md-4 user_status"></div>
            </div>
        </div>
        <div class="card-datatable">
            <table class="datatables-users table border-top">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th class="col-2">Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
        <!-- Offcanvas to add new user -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddUser" aria-labelledby="offcanvasAddUserLabel">
            <div class="offcanvas-header border-bottom">
                <h5 id="offcanvasAddUserLabel" class="offcanvas-title">Adicionar instituição</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body mx-0 flex-grow-0 p-6 h-100">
                <form class="add-new-user pt-0" id="form-instituicao" onsubmit="return false">
                        
                    <div class="mb-6 form-control-validation">
                        <label class="form-label" for="nome">Nome</label>
                        <input type="hidden" class="form-control" id="id" name="id" />
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
