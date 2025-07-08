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
    <script script src={{ asset('/vendor/libs/moment/moment.js') }}></script>
    <script script src={{ asset('/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}></script>
    {{-- <script script src={{ asset('/vendor/libs/select2/select2.js') }}></script> --}}
    {{-- <script script src={{ asset('/vendor/libs/@form-validation/popular.js') }}></script> --}}
    {{-- <script script src={{ asset('/vendor/libs/@form-validation/bootstrap5.js') }}></script> --}}
    {{-- <script script src={{ asset('/vendor/libs/@form-validation/auto-focus.js') }}></script> --}}
    {{-- <script script src={{ asset('/vendor/libs/@form-validation/auto-focus.js') }}></script> --}}
    <script script src={{ asset('/vendor/libs/cleave-zen/cleave-zen.js') }}></script>
    <script script src={{ asset('/vendor/libs/sweetalert2/sweetalert2.js') }}></script>
    <script script src={{ asset('/vendor/libs/dropzone/dropzone.js') }}></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src={{ asset('/js/pages/planilhao.js') }}></script>
@endpush

@section('content')
    <!-- Users List Table -->
    <div class="card">
        <h5 class="card-header">Importar Planilhão SAG</h5>
        <div class="card-body">
            <form id="upload" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="planilhao" class="form-label"><strong>Planilhão do Sag pra importar</strong></label>
                    <br>
                    <label for="missoes" class="form-label">Selecione o arquivo CSV com as alterações a serem importadas</label>
                    <input class="form-control" type="file" id="planilhao" name="planilhao">
                </div>
                <button type="submit" class="btn btn-primary">Enviar</button>
            </form>
            <div id="message"></div>
        </div>
    </div>
@endsection
