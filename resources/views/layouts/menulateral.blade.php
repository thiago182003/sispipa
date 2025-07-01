<aside id="layout-menu" class="layout-menu menu-vertical menu">
    <div class="app-brand demo ">
        <a href="index.html" class="app-brand-link">
            <span class="app-brand-logo demo">
                <span class="text-primary">
                    <img src={{ asset('/img/logo7rm.png') }} class="img-fluid" alt="Login image" width="28" />
                </span>
            </span>
            <span class="app-brand-text demo menu-text fw-bold ms-2">{{config("app.name")}}</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="icon-base bx bx-chevron-left"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>
    
    <ul class="menu-inner py-1">
        <!-- Dashboards -->
        @if (auth()->user()->level == 1) {{-- Admin --}}
        {{-- Administrativo --}}
        <li class="menu-item {{ request()->routeIs("administrativo.*") ? 'open active' : ''}}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon icon-base bx bx-layout"></i>
                <div>Administrativo</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('administrativo.militares') ? 'active' : '' }}">
                    <a href={{route("administrativo.militares")}} class="menu-link">
                        <div>Militares</div>
                    </a>
                </li>
                
                <li class="menu-item {{ request()->routeIs('administrativo.secoes.index') ? 'active' : '' }}">
                    <a href={{route("administrativo.secoes.index")}} class="menu-link">
                        <div>Seções</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('administrativo.situacoes.index') ? 'active' : '' }}">
                    <a href={{route("administrativo.situacoes.index")}} class="menu-link">
                        <div>Situações</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('administrativo.oms.index') ? 'active' : '' }}">
                    <a href={{route("administrativo.oms.index")}} class="menu-link">
                        <div>Organizações Militares</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('administrativo.modulos.index') ? 'active' : '' }}">
                    <a href={{route("administrativo.modulos.index")}} class="menu-link">
                        <div>Modulos</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('administrativo.pg.index') ? 'active' : '' }}">
                    <a href={{route("administrativo.pg.index")}} class="menu-link">
                        <div>Posto e Graduações</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('administrativo.versituacoes') ? 'active' : '' }}">
                    <a href="{{route('administrativo.versituacoes')}}" class="menu-link" >
                        <div>Situação do Militar</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('administrativo.planodeferias') ? 'active' : '' }}">
                    <a href="{{route('administrativo.planodeferias')}}" class="menu-link" >
                        <div>Plano de Férias</div>
                    </a>
                </li>
             
            </ul>
        </li>

        {{-- Operacional --}}
        <li class="menu-item {{ request()->routeIs("operacional.*") ? 'open active' : ''}}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon icon-base bx bx-layout"></i>
                <div>Operacional</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('operacional.missoes.*') ? 'active' : '' }}">
                    <a href="{{ route('operacional.missoes.index') }}" class="menu-link">
                        <div>Missões</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('operacional.municipios') ? 'active' : '' }}">
                    <a href="{{ route('operacional.municipios') }}" class="menu-link">
                        <div>Municípios</div>
                    </a>
                </li>
            </ul>
        </li>
        {{--Financeiro--}}         
        <li class="menu-item {{ request()->routeIs("financeiro.*") ? 'open active' : ''}}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon icon-base bx bx-money"></i>
                <div>Financeiro</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('financeiro.index') ? 'active' : '' }}">
                    <a href="{{route('financeiro.index')}}" class="menu-link" >
                        <div>Situação financeira</div>
                    </a>
                </li>
            </ul>
        </li>

        {{-- Importações --}}
        <li class="menu-item {{ request()->routeIs("importacoes.*") ? 'open active' : ''}}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon icon-base bx bx-import"></i>
                <div>Importações</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('importacoes.ouvidoria') ? 'active' : '' }}">
                    <a href="{{route('importacoes.ouvidoria')}}" class="menu-link" >
                        <div>Ouvidoria</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('importacoes.planilhao') ? 'active' : '' }}">
                    <a href="{{route('importacoes.planilhao')}}" class="menu-link" >
                        <div>Planilhão SAG</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('importacoes.missoes.importar') ? 'active' : '' }}">
                    <a href="{{route('importacoes.missoes.importar')}}" class="menu-link" >
                        <div>Missões</div>
                    </a>
                </li>
            </ul>
        </li>

    
@elseif (auth()->user()->level == 2) {{-- Administrativo --}}
   {{-- Administrativo --}}
        <li class="menu-item {{ request()->routeIs("administrativo.*") ? 'open active' : ''}}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon icon-base bx bx-layout"></i>
                <div>Administrativo</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('administrativo.militares') ? 'active' : '' }}">
                    <a href={{route("administrativo.militares")}} class="menu-link">
                        <div>Militares</div>
                    </a>
                </li>
                
                <li class="menu-item {{ request()->routeIs('administrativo.secoes.index') ? 'active' : '' }}">
                    <a href={{route("administrativo.secoes.index")}} class="menu-link">
                        <div>Seções</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('administrativo.situacoes.index') ? 'active' : '' }}">
                    <a href={{route("administrativo.situacoes.index")}} class="menu-link">
                        <div>Situações</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('administrativo.oms.index') ? 'active' : '' }}">
                    <a href={{route("administrativo.oms.index")}} class="menu-link">
                        <div>Organizações Militares</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('administrativo.modulos.index') ? 'active' : '' }}">
                    <a href={{route("administrativo.modulos.index")}} class="menu-link">
                        <div>Modulos</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('administrativo.pg.index') ? 'active' : '' }}">
                    <a href={{route("administrativo.pg.index")}} class="menu-link">
                        <div>Posto e Graduações</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('administrativo.versituacoes') ? 'active' : '' }}">
                    <a href="{{route('administrativo.versituacoes')}}" class="menu-link" >
                        <div>Situação do Militar</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('administrativo.planodeferias') ? 'active' : '' }}">
                    <a href="{{route('administrativo.planodeferias')}}" class="menu-link" >
                        <div>Plano de Férias</div>
                    </a>
                </li>
            </ul>
        </li>

{{-- Importações --}}
        <li class="menu-item {{ request()->routeIs("importacoes.*") ? 'open active' : ''}}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon icon-base bx bx-import"></i>
                <div>Importações</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('importacoes.ouvidoria') ? 'active' : '' }}">
                    <a href="{{route('importacoes.ouvidoria')}}" class="menu-link" >
                        <div>Ouvidoria</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('importacoes.planilhao') ? 'active' : '' }}">
                    <a href="{{route('importacoes.planilhao')}}" class="menu-link" >
                        <div>Planilhão SAG</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('importacoes.missoes.importar') ? 'active' : '' }}">
                    <a href="{{route('importacoes.missoes.importar')}}" class="menu-link" >
                        <div>Missões</div>
                    </a>
                </li>
            </ul>
        </li>
@elseif (auth()->user()->level == 3) {{-- Financeiro --}}
    {{-- Financeiro --}}
    <li class="menu-item {{ request()->routeIs("financeiro.*") ? 'open active' : ''}}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon icon-base bx bx-money"></i>
            <div>Financeiro</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item {{ request()->routeIs('financeiro.index') ? 'active' : '' }}">
                <a href="{{route('financeiro.index')}}" class="menu-link" >
                    <div>Situação financeira</div>
                </a>
            </li>
        </ul>
    </li>
    {{-- Importações --}}
    <li class="menu-item {{ request()->routeIs("importacoes.*") ? 'open active' : ''}}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon icon-base bx bx-import"></i>
            <div>Importações</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item {{ request()->routeIs('importacoes.ouvidoria') ? 'active' : '' }}">
                <a href="{{route('importacoes.ouvidoria')}}" class="menu-link" >
                    <div>Ouvidoria</div>
                </a>
            </li>
            <li class="menu-item {{ request()->routeIs('importacoes.planilhao') ? 'active' : '' }}">
                <a href="{{route('importacoes.planilhao')}}" class="menu-link" >
                    <div>Planilhão SAG</div>
                </a>
            </li>
            <li class="menu-item {{ request()->routeIs('importacoes.missoes.importar') ? 'active' : '' }}">
                <a href="{{route('importacoes.missoes.importar')}}" class="menu-link" >
                    <div>Missões</div>
                </a>
            </li>
        </ul>
    </li>
@elseif (auth()->user()->level == 4) {{-- Operacional --}}
    {{-- Operacional --}}
    <li class="menu-item {{ request()->routeIs("operacional.*") ? 'open active' : ''}}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon icon-base bx bx-layout"></i>
            <div>Operacional</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item {{ request()->routeIs('operacional.missoes.*') ? 'active' : '' }}">
                <a href="{{ route('operacional.missoes.index') }}" class="menu-link">
                    <div>Missões</div>
                </a>
            </li>
            <li class="menu-item {{ request()->routeIs('operacional.municipios') ? 'active' : '' }}">
                <a href="{{ route('operacional.municipios') }}" class="menu-link">
                    <div>Municípios</div>
                </a>
            </li>
        </ul>
    </li>
    {{-- Importações --}}
    <li class="menu-item {{ request()->routeIs("importacoes.*") ? 'open active' : ''}}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon icon-base bx bx-import"></i>
            <div>Importações</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item {{ request()->routeIs('importacoes.ouvidoria') ? 'active' : '' }}">
                <a href="{{route('importacoes.ouvidoria')}}" class="menu-link" >
                    <div>Ouvidoria</div>
                </a>
            </li>
            <li class="menu-item {{ request()->routeIs('importacoes.planilhao') ? 'active' : '' }}">
                <a href="{{route('importacoes.planilhao')}}" class="menu-link" >
                    <div>Planilhão SAG</div>
                </a>
            </li>
            <li class="menu-item {{ request()->routeIs('importacoes.missoes.importar') ? 'active' : '' }}">
                <a href="{{route('importacoes.missoes.importar')}}" class="menu-link" >
                    <div>Missões</div>
                </a>
            </li>
        </ul>
    </li>
@elseif (auth()->user()->level == 5) {{-- Gestor Operacional --}}
        {{-- Operacional --}}
        <li class="menu-item {{ request()->routeIs("operacional.*") ? 'open active' : ''}}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon icon-base bx bx-layout"></i>
                <div>Operacional</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('operacional.missoes.*') ? 'active' : '' }}">
                    <a href="{{ route('operacional.missoes.index') }}" class="menu-link">
                        <div>Missões</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('operacional.municipios') ? 'active' : '' }}">
                    <a href="{{ route('operacional.municipios') }}" class="menu-link">
                        <div>Municípios</div>
                    </a>
                </li>
            </ul>
        </li>
{{-- Importações --}}
        <li class="menu-item {{ request()->routeIs("importacoes.*") ? 'open active' : ''}}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon icon-base bx bx-import"></i>
                <div>Importações</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('importacoes.ouvidoria') ? 'active' : '' }}">
                    <a href="{{route('importacoes.ouvidoria')}}" class="menu-link" >
                        <div>Ouvidoria</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('importacoes.planilhao') ? 'active' : '' }}">
                    <a href="{{route('importacoes.planilhao')}}" class="menu-link" >
                        <div>Planilhão SAG</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('importacoes.missoes.importar') ? 'active' : '' }}">
                    <a href="{{route('importacoes.missoes.importar')}}" class="menu-link" >
                        <div>Missões</div>
                    </a>
                </li>
            </ul>
        </li>
    @endif

    {{-- Menu Gestão - deve ficar aqui, fora de qualquer @if --}}
    <li class="menu-item {{ request()->routeIs('gestao.*') ? 'open active' : '' }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon icon-base bx bx-task"></i>
            <div>Gestão</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item {{ request()->routeIs('gestao.atividades.index') ? 'active' : '' }}">
                <a href="{{ route('gestao.atividades.index') }}" class="menu-link">
                    <div>Atividades</div>
                </a>
            </li>
        </ul>
    </li>

</ul>
</aside>

<div class="menu-mobile-toggler d-xl-none rounded-1">
    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large text-bg-secondary p-2 rounded-1">
        <i class="bx bx-menu icon-base"></i>
        <i class="bx bx-chevron-right icon-base"></i>
    </a>
</div>
