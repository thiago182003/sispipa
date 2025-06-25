<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Municipio;

class MunicipioController extends Controller
{
    public function index(){
        return view('operacional.municipios.municipios');
    }

    public function getall(){
        $dados = Municipio::with(['estado'])->get();
        return response()->json(["data" => $dados]);
    }

    public function importar(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt',
        ]);

        $file = $request->file('csv_file');
        $handle = fopen($file->getRealPath(), 'r');
        $header = fgetcsv($handle, 1000, ';'); // Lê o cabeçalho

        $importados = 0;
        while (($data = fgetcsv($handle, 1000, ';')) !== FALSE) {
            // Limpa o nome removendo espaços e pontos e vírgulas extras
            $nome = trim($data[0]);
            $nome = rtrim($nome, ';');
            Municipio::create([
                'nome' => $nome,
            ]);
            $importados++;
        }
        fclose($handle);

        return redirect()->route('operacional.municipios')->with('success', "$importados municípios importados com sucesso!");
    }
}
