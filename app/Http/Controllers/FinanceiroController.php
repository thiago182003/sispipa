<?php
namespace App\Http\Controllers;

use App\Models\SituacaoFinanceira;
use Illuminate\Http\Request;

class FinanceiroController extends Controller
{
    /* ---------- LISTAGEM ---------- */
    public function index()
    {
        return view('financeiro.index');
    }

    public function getAll()          // ← camelCase igual à rota
    {
        return response()->json([
            'data' => SituacaoFinanceira::all()
        ]);
    }

    /* ---------- CRIAR / ATUALIZAR ---------- */
    public function store(Request $request)
{
    $data = $request->except('_token');

    $situacao = $request->filled('id')
        ? SituacaoFinanceira::findOrFail($request->id)   // update
        : new SituacaoFinanceira;                        // create

    $situacao->fill($data)->save();

    /* ---------- 1. Ajax? -> JSON ---------- */
    if ($request->ajax() || $request->wantsJson()) {
        return response()->json([
            'success' => true,
            'id'      => $situacao->id
        ]);
    }

    /* ---------- 2. Form normal -> redirect ---------- */
    return redirect()
        ->route('financeiro.index')          // rota da listagem
        ->with('success', 'Situação financeira salva com sucesso!');
}


    /* ---------- MOSTRAR 1 REGISTRO ---------- */
    public function show(Request $request)
    {
        return response()->json(
            SituacaoFinanceira::findOrFail($request->id)
        );
    }

    /* ---------- EXCLUIR ---------- */
    public function destroy(Request $request)
    {
        SituacaoFinanceira::findOrFail($request->id)->delete();

        return response()->json(['success' => true]);
    }

    /* ---------- FORM DE CRIAÇÃO (opcional) ---------- */
  public function create(Request $request)
{
    $situacao = null;

    if ($request->filled('id')) {
        $situacao = SituacaoFinanceira::find($request->id);
    }

    return view('financeiro.novo', compact('situacao'));
}
}
