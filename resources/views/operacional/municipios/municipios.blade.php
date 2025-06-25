@extends('layouts.layout')

@section('content')
<div class="container">
    <h1>Importar Municípios</h1>
    <form action="{{ route('operacional.municipios.importar') }}" method="POST" enctype="multipart/form-data" class="mb-4">
        @csrf
        <div class="mb-3">
            <label for="csv_file" class="form-label">Selecione o arquivo CSV:</label>
            <input type="file" name="csv_file" id="csv_file" class="form-control" accept=".csv" required>
        </div>
        <button type="submit" class="btn btn-primary">Importar</button>
    </form>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
</div>
@endsection