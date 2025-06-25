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
    <script script src={{ asset('/vendor/libs/moment/moment.js') }}></script>
    <script script src={{ asset('/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}></script>
    <script script src={{ asset('/vendor/libs/select2/select2.js') }}></script>
    <script script src={{ asset('/vendor/libs/@form-validation/popular.js') }}></script>
    <script script src={{ asset('/vendor/libs/@form-validation/bootstrap5.js') }}></script>
    <script script src={{ asset('/vendor/libs/@form-validation/auto-focus.js') }}></script>
    <script script src={{ asset('/vendor/libs/@form-validation/auto-focus.js') }}></script>
    <script script src={{ asset('/vendor/libs/cleave-zen/cleave-zen.js') }}></script>
    <script script src={{ asset('/vendor/libs/sweetalert2/sweetalert2.js') }}></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src={{ asset('/js/pages/militar.js') }}></script>
@endpush

@section('content')

<div class="card">
    <div class="card-header border-bottom mb-3">
        <h5 class="card-title mb-0">Resetar Senha</h5>
    </div>
    <form class="card-body" method="post" action="{{route('administrativo.militares.updatePassword')}}">
        @csrf
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row g-6">
            <div class="col-md-4">
                <label class="form-label" for="multicol-username">Senha antiga</label>
                <div class="input-group input-group-merge">
                    <input type="password" id="current_password" name="current_password" class="form-control" placeholder="············" aria-describedby="multicol-password2">
                    <span class="input-group-text cursor-pointer" id="multicol-password2"><i class="icon-base bx bx-hide"></i></span>
                </div>
            </div>
            <div class="col-md-4">
                <label class="form-label" for="multicol-email">Nova Senha</label>
                <div class="input-group input-group-merge">
                    <input type="password" id="new_password" name="new_password" class="form-control" placeholder="············" aria-describedby="multicol-password2">
                    <span class="input-group-text cursor-pointer" id="multicol-password2"><i class="icon-base bx bx-hide"></i></span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-password-toggle">
                    <label class="form-label" for="multicol-password">Repita a nova senha</label>
                    <div class="input-group input-group-merge">
                        <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="form-control" placeholder="············" aria-describedby="multicol-password2">
                        <span class="input-group-text cursor-pointer" id="multicol-password2"><i class="icon-base bx bx-hide"></i></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="pt-6">
            <button type="submit" class="btn btn-primary me-3">Submit</button>
        </div>
    </form>
</div>

@endsection