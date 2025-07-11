<?php

namespace App\Http\Controllers;

use App\Models\Objetivo;
use Illuminate\Http\Request;

class ObjetivoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $objetivos = Objetivo::orderBy('nome')->get();
        return view('operacional.missoes.objetivo', compact('objetivos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(['nome' => 'required|string|max:255|unique:objetivos,nome']);
        Objetivo::create(['nome' => $request->nome]);
        return redirect()->route('objetivos.index')->with('success', 'Objetivo cadastrado!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, $id)
{
    // 1) Valida os dados
    $request->validate([
        'nome' => 'required|string|max:255',
    ]);

    // 2) Busca o objetivo ou dá 404
    $objetivo = Objetivo::findOrFail($id);

    // 3) Atualiza e salva
    $objetivo->nome = $request->nome;
    $objetivo->save();

    // 4) Redireciona de volta com mensagem de sucesso
    return redirect()
        ->route('objetivos.index')
        ->with('success', 'Objetivo atualizado com sucesso!');
}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Objetivo $objetivo)
    {
        $objetivo->delete();
        return redirect()->route('objetivos.index')->with('success', 'Objetivo excluído!');
    }
}
