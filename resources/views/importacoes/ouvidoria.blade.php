@extends('layouts.layout')

@push('styles')
    <link rel="stylesheet" href="{{ asset('/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('/vendor/libs/datatables-bs5/datatables-bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('/vendor/libs/datatables-responsive-bs5/reponsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    {{-- <link rel="stylesheet" href="{{ asset('/css/jquery.dataTables.min.css') }}" /> --}}
@endpush

@push('scripts')
    <script script src={{ asset('/vendor/libs/moment/moment.js') }}></script>
    <script script src={{ asset('/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}></script>
    <script script src={{ asset('/vendor/libs/select2/select2.js') }}></script>
    <script script src={{ asset('/vendor/libs/cleave-zen/cleave-zen.js') }}></script>
    <script script src={{ asset('/vendor/libs/sweetalert2/sweetalert2.js') }}></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    {{-- <script src={{ asset('/js/pages/versituacoes.js') }}></script> --}}
    <script>
        $(document).ready(function() {
            $('#syncButton').click(function() {
                $.ajax({
                    url: "{{ route('sincronizar') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    beforeSend: function() {
                        $('#syncButton').text("🔄 Sincronizando...");
                        $('#syncButton').attr("disabled", true);
                    },
                    success: function(response) {
                        $('#syncButton').text("✅ Sincronizado!");
                        $('#syncButton').attr("disabled", false);
                        alert("Sincronização concluída!");
                    },
                    error: function() {
                        $('#syncButton').text("❌ Erro!");
                        $('#syncButton').attr("disabled", false);
                        alert("Erro ao sincronizar!");
                    }
                });
            });
        });
    </script>
@endpush



@section('content')

    @if(session('success'))
        <div class="alert alert-success" id="successMessage">
            {{ session('success') }}
        </div>
    @endif

    <!-- Users List Table -->
    <div class="card">
        <h5 class="card-header">Importar Ouvidoria</h5>
        <div class="card-body">
            <button id="syncButton" class="btn btn-primary">🔄 Sincronizar Dados</button>
        </div>
    </div>
@endsection