<?php

namespace App\Http\Controllers;

use App\Models\Planodeferias;
use App\Models\PlanodeferiasMudanca;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PlanodeferiasController extends Controller
{
    //
    public function index(){
        $militares = User::where('level','>','0')->get();
        return view('e1.planodeferias', compact('militares'));
    }

    public function getplanodeferias(Request $request){
        $dados = Planodeferias::with(['militar.postoGraduacao'])->get();

        // Garante que todos os registros tenham o campo boletim (mesmo que null)
        $dados = $dados->map(function($item) {
            $item->boletim = $item->boletim ?? '';
            return $item;
        });

        if ($request->wantsJson()) {
            return response()->json(["data" => $dados]);
        }

        return view('planos.index', compact('dados'));
    }

    public function show(Request $request){
        try{
            $plano = Planodeferias::with('mudancas')->findOrFail($request->id);
            return response()->json($plano, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro interno do servidor.' . $e->getMessage()], 500);
        }
    }

    public function delete(Request $request){
        try{
            $plano = Planodeferias::findOrFail($request->id);
            $plano->delete();
            return response()->json(['message' => 'Plano deletado com sucesso!'], 200);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Plano não encontrado.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro interno do servidor.' . $e->getMessage()], 500);
        }
    }

    public function store(Request $request){
        $id = $request->input('id');
        $qtdparcelas = $request->input('qtdparcelas');

        $rules = [
            'qtdparcelas' => 'required',
            'militar_id' => 'required',
            'anoreferencia' => 'required',
            'boletim' => 'nullable|string|max:100',
            'status' => 'nullable',
        ];

        // Regras dinâmicas para períodos
        if ($qtdparcelas >= 1) {
            $rules['p1inicio'] = 'required|date';
            $rules['p1fim'] = 'required|date';
        }
        if ($qtdparcelas >= 2) {
            $rules['p2inicio'] = 'required|date';
            $rules['p2fim'] = 'required|date';
        }
        if ($qtdparcelas == 3) {
            $rules['p3inicio'] = 'required|date';
            $rules['p3fim'] = 'required|date';
        }

        try {
            $validated = $request->validate($rules);
            $validated['status'] = $validated['status'] ?? 1;

            // Salva o plano normalmente
            if ($id) {
                $plano = Planodeferias::findOrFail($id);
                $plano->update($validated);
            } else {
                $plano = Planodeferias::create($validated);
            }

            // Salva as mudanças (DIEx e PDF)
            if ($request->has('diex_alteracao')) {
                foreach ($request->diex_alteracao as $idx => $diex) {
                    $pdf = $request->file('pdf_alteracao')[$idx] ?? null;
                    $pdfPath = null;
                    if ($pdf) {
                        $pdfPath = $pdf->store('mudancas_pdf', 'public');
                    }
                    PlanodeferiasMudanca::create([
                        'planodeferias_id' => $plano->id,
                        'diex' => $diex,
                        'pdf_path' => $pdfPath,
                    ]);
                }
            }

            return response()->json(['message' => $id ? 'Plano atualizado com sucesso!' : 'Plano cadastrado com sucesso!', 'plano' => $plano], $id ? 200 : 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Plano não encontrado.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro interno do servidor.' . $e->getMessage()], 500);
        }
    }
}
