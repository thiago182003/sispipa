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
    <script src={{ asset('/js/pages/versituacoes.js') }}></script>
@endpush

@section('content')
    <!-- Users List Table -->
    <div class="card">
        <h5 class="card-header">Situações</h5>
        <div class="table-responsive text-nowrap">
          <table class="table">
            <thead>
              <tr>
                <th>Militar</th>
                <th>Situação</th>
                <th>Ações</th>
              </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @foreach ($militares as $militar)
                  <tr data-id="{{ $militar->id }}">
                        <td><i class="icon-base fab fa-angular icon-md text-danger me-4"></i> <span>{{ $militar->pg_nome }}</span></td>
                        <td>
                            {{-- <x-select label="" name="situacao" campo="nome" selected="{{$militar->situacao_id}}" :options=$situacoes /> --}}
                            <select name="situacao" id="situacao" class="form-select">
                              <option>Selecione...</option>
                              @foreach($situacoes as $item)
                                  <option value="{{ $item->id }}" {{ $militar->situacao_id == $item->id ? 'selected' : '' }}>
                                      {{ $item['nome'] }}
                                  </option>
                              @endforeach
                            </select>
                        </td>
                        <td>
                            {{-- <a class="dropdown-item" href="javascript:;"><i class="icon-base bx bx-save me-1 salvar"></i> Salvar</a> --}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
          </table>
        </div>
        <button id="saveButton" class="btn btn-primary mt-3">Salvar Alterações</button>
      </div>
@endsection
