<?php

namespace App\Http\Controllers;

use App\Models\Descontoemferias;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class DescontoemferiasController extends Controller
{
    public function index()
    {
        $militares = User::with('postoGraduacao')->where('level', '>', 0)->get();
        return view('e1.descontoemferias', compact('militares'));
    }

    public function getAll(Request $request)
    {
        $dados = Descontoemferias::with('militar.postoGraduacao')->get();
        return response()->json(['data' => $dados]);
    }

    public function store(Request $request)
    {
        $id = $request->input('id');
        $rules = [
            'militar_id' => 'required|exists:users,id',
            'qtd_dias' => 'required|integer|min:1|max:60',
            'diex_numero' => 'required|string|max:100',
            'anoreferencia' => 'required|digits:4',
            'diex_arquivo' => 'nullable|file|mimes:pdf|max:2048',
        ];

        try {
            $validated = $request->validate($rules);

            if ($request->hasFile('diex_arquivo')) {
                $file = $request->file('diex_arquivo');
                $path = $file->store('diex', 'public');
                $validated['diex_arquivo'] = $path;
            }

            if ($id) {
                $registro = Descontoemferias::findOrFail($id);
                if ($request->hasFile('diex_arquivo') && $registro->diex_arquivo) {
                    Storage::disk('public')->delete($registro->diex_arquivo);
                }
                $registro->update($validated);
                return response()->json(['message' => 'Registro atualizado com sucesso!']);
            } else {
                Descontoemferias::create($validated);
                return response()->json(['message' => 'Registro criado com sucesso!']);
            }
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function download($id)
    {
        $registro = Descontoemferias::findOrFail($id);
        if (!$registro->diex_arquivo || !Storage::disk('public')->exists($registro->diex_arquivo)) {
            abort(404, 'Arquivo não encontrado');
        }
        return Storage::disk('public')->download($registro->diex_arquivo);
    }

    public function show(Request $request)
    {
        $registro = Descontoemferias::findOrFail($request->id);
        return response()->json($registro);
    }

    public function delete(Request $request)
    {
        $registro = Descontoemferias::findOrFail($request->id);
        if ($registro->diex_arquivo) {
            Storage::disk('public')->delete($registro->diex_arquivo);
        }
        $registro->delete();
        return response()->json(['message' => 'Registro deletado com sucesso!']);
    }

    public function getDescontos(Request $request)
    {
        $militar_id = $request->input('militar_id');
        $total_descontado = \App\Models\Descontoemferias::where('militar_id', $militar_id)->sum('qtd_dias');
        return response()->json(['total_descontado' => $total_descontado]);
    }
}