@extends('layouts.layout')
@section('content')
<div class="container">
    <h1>Missões</h1>
    <a href="{{ route('operacional.missoes.create') }}" class="btn btn-primary mb-3">Criar nova missão</a>
    <table class="table">
        <thead>
            <tr>
                <th>Período</th>
                <th>Objetivos</th>
                <th>Militares</th>
            </tr>
        </thead>
        <tbody>
            @foreach($missoes as $missao)
                <tr>
                    <td>{{ $missao->data_inicio }} a {{ $missao->data_fim }}</td>
                    <td>
                        @foreach($missao->objetivos as $objetivo => $municipios)
                            @php
                                // Remove vazios e verifica se há municípios
                                $municipios_filtrados = array_filter($municipios, fn($m) => !empty($m));
                            @endphp
                            @if(count($municipios_filtrados) > 0)
                                <strong>{{ $objetivo }}</strong>
                                <ul>
                                    @foreach($municipios_filtrados as $municipio)
                                        <li>{{ $municipio }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        @endforeach
                    </td>
                    <td>
                        <ul>
                        @foreach($missao->militares_detalhados ?? [] as $militar)
        <li>
            {{ $militar['postograduacao'] }} {{ $militar['nomeguerra'] }} ({{ $militar['om_servico'] }})
        </li>
    @endforeach
    </ul>
</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection