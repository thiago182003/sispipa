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
    <!-- Users List Table -->
    <div class="card">
        <div class="card-header border-bottom">
            <h5 class="card-title mb-0">Buscar Militares</h5>
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
                        <th>Nome de guerra</th>
                        <th>Nome</th>
                        <th>Seção</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div class="modal-onboarding modal fade " id="modalMilitar" data-bs-backdrop="static" tabindex="-1"
            aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content text-center">
                    <div class="modal-header border-0">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-0">
                        <div class="onboarding-content mb-0">
                            <form id="form-militar" onsubmit="return false">
                                @csrf
                                <div class="row g-3">
                                    <!-- Nome Completo -->
                                    <div class="col-sm-8">
                                        <div class="mb-2">
                                            <label for="nome" class="form-label">Nome</label>
                                            <input type="hidden" class="form-control" id="id" name="id" />
                                            <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome completo" required />
                                        </div>
                                    </div>
                            
                                    <!-- Nome de Guerra -->
                                    <div class="col-sm-4">
                                        <div class="mb-2">
                                            <label for="nomeguerra" class="form-label">Nome de guerra</label>
                                            <input type="text" class="form-control" id="nomeguerra" name="nomeguerra" placeholder="Nome de guerra" />
                                        </div>
                                    </div>
                            
                                    <!-- CPF -->
                                    <div class="col-sm-6">
                                        <div class="mb-2">
                                            <label for="cpf" class="form-label">CPF</label>
                                            <input type="text" class="form-control" id="cpf" name="cpf" placeholder="***.***.***-**" required />
                                        </div>
                                    </div>
                            
                                    <!-- Posto/Graduação -->
                                    
                                    {{-- <x-select label="Posto/Graduação" name="postograduacao_id" :options={{$postoGraduacoes}} /> --}}
                                    <div class="col-sm-6">
                                        <x-select label="Posto/Graduação" name="postograduacao_id" :options=$postoGraduacoes campo="sigla"/>
                                    </div>
                            
                                    <!-- Telefone -->
                                    <div class="col-sm-6">
                                        <div class="mb-2">
                                            <label for="telefone" class="form-label">Telefone</label>
                                            <input type="text" class="form-control" id="telefone" name="telefone" placeholder="(**) *****-****" required />
                                        </div>
                                    </div>
                            
                                    <!-- Email -->
                                    <div class="col-sm-6">
                                        <div class="mb-2">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email" name="email" placeholder="email@exemplo.com" required />
                                        </div>
                                    </div>
                            
                                    <!-- Veterano -->
                                    <div class="col-sm-2">
                                        <div class="mb-2">
                                            <label for="veterano" class="form-label">Veterano</label>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="veterano" name="veterano" />
                                            </div>
                                        </div>
                                    </div>
                            
                                    <!-- Data de Nascimento -->
                                    <div class="col-sm-5">
                                        <div class="mb-2">
                                            <label for="dtnascimento" class="form-label">Data de Nascimento</label>
                                            <input type="date" class="form-control" id="dtnascimento" name="dtnascimento" required />
                                        </div>
                                    </div>
                            
                                    <!-- Data de Praça -->
                                    <div class="col-sm-5">
                                        <div class="mb-2">
                                            <label for="dtpraca" class="form-label">Data de Praça</label>
                                            <input type="date" class="form-control" id="dtpraca" name="dtpraca" required />
                                        </div>
                                    </div>
                            
                                    <!-- OM Serviço -->
                                    <div class="col-sm-6">
                                        <x-select label="OM Serviço" name="om_servico_id" :options=$oms campo="sigla" />
                                        {{-- <x-select label="" name="situacao" campo="nome" selected="{{$militar->situacao_id}}" :options=$situacoes /> --}}
                                    </div>
                            
                                    <!-- OM Vínculo -->
                                    <div class="col-sm-6">
                                        <x-select label="OM Vínculo" name="om_vinculo_id" :options=$oms campo="sigla" />
                                        {{-- <x-select label="" name="situacao" campo="nome" selected="{{$militar->situacao_id}}" :options=$situacoes /> --}}
                                    </div>
                            
                                    <!-- Seção -->
                                    <div class="col-sm-6">
                                        <x-select label="Seção" name="secao_id" :options=$secoes campo="sigla" />
                                        {{-- <x-select label="" name="situacao" campo="nome" selected="{{$militar->situacao_id}}" :options=$situacoes /> --}}
                                    </div>
                            
                                    <!-- Nível -->
                                    <div class="col-sm-6">
                                        <div class="mb-2">
                                            <label for="level" class="form-label">Nível</label>
                                            <select class="form-select" id="level" name="level" required>
                                                <option value="">Selecione...</option>
                                                <option value="1">Admin</option>
                                                <option value="2">Administrativo</option>
                                                <option value="3">Financeiro</option>
                                                <option value="4">Operacional</option>
                                                <option value="5">Gestor Operacional</option> <!-- NOVO NÍVEL -->
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            
                                <!-- Botões -->
                                <div class="modal-footer border-0">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                    <button type="submit" class="btn btn-primary">Salvar</button>
                                </div>
                            </form>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Alterar Senha -->
    <div class="modal fade" id="modalAlterarSenha" tabindex="-1" aria-labelledby="modalAlterarSenhaLabel" aria-hidden="true">
      <div class="modal-dialog">
        <form id="formAlterarSenha" onsubmit="return false;">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modalAlterarSenhaLabel">Alterar Senha de <span id="nomeMilitarSenha"></span></h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
              <input type="hidden" id="idMilitarSenha" name="idMilitarSenha">
              <div class="mb-3">
                <label for="novaSenha" class="form-label">Nova Senha</label>
                <input type="password" class="form-control" id="novaSenha" name="novaSenha" required>
              </div>
              <div class="mb-3">
                <label for="confirmaSenha" class="form-label">Confirmação da Senha</label>
                <input type="password" class="form-control" id="confirmaSenha" name="confirmaSenha" required>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-primary" onclick="salvarNovaSenha()">Salvar Senha</button>
            </div>
          </div>
        </form>
      </div>
    </div>
@endsection
