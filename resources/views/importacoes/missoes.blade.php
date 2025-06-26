@extends('layouts.layout')

@push('styles')
    <link rel="stylesheet" href="{{ asset('/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('/vendor/libs/datatables-bs5/datatables-bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('/vendor/libs/datatables-responsive-bs5/reponsive.bootstrap5.css') }}" />
    {{-- <link rel="stylesheet" href="{{ asset('/vendor/libs/@form-validation/form-validation.css') }}" /> --}}
    <link rel="stylesheet" href="{{ asset('/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    <link rel="stylesheet" href="{{ asset('/vendor/libs/dropzone/dropzone.css') }}" />
    {{-- <link rel="stylesheet" href="{{ asset('/css/jquery.dataTables.min.css') }}" /> --}}
@endpush

@push('scripts')
    <script src="{{ asset('/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    {{-- <script src="{{ asset('/vendor/libs/select2/select2.js') }}"></script> --}}
    {{-- <script src="{{ asset('/vendor/libs/@form-validation/popular.js') }}"></script> --}}
    {{-- <script src="{{ asset('/vendor/libs/@form-validation/bootstrap5.js') }}"></script> --}}
    {{-- <script src="{{ asset('/vendor/libs/@form-validation/auto-focus.js') }}"></script> --}}
    {{-- <script src="{{ asset('/vendor/libs/@form-validation/auto-focus.js') }}"></script> --}}
    <script src="{{ asset('/vendor/libs/cleave-zen/cleave-zen.js') }}"></script>
    <script src="{{ asset('/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('/vendor/libs/dropzone/dropzone.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="{{ asset('/js/pages/missao.js') }}"></script>
@endpush

@section('content')
    <!-- Users List Table -->
    <div class="card">
        <h5 class="card-header">Importar Missões</h5>
        <div class="card-body">
            <form id="uploadmissoes" method="POST" action="{{ url('/administrativo/importacoes/missoes') }}" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label for="missoes" class="form-label"><strong>Missões pra importar</strong></label>
        <br>
        <label for="missoes" class="form-label">Selecione o arquivo CSV com as missões a serem importadas</label>
        <input class="form-control" type="file" id="missoes" name="missoes">
    </div>
    <button type="submit" class="btn btn-primary">Enviar</button>
</form>
            <div id="message"></div>
        </div>
    </div>
@endsection
