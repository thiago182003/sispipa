<?php

namespace App\Http\Controllers;

use App\Models\Planodeferias;
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

        if ($request->wantsJson()) {
            return response()->json(["data" => $dados]);
        }

        return view('planos.index', compact('dados'));
    }

    public function show(Request $request){
        try{
            $plano = Planodeferias::findOrFail($request->id);
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

        $id = $request->input('id'); // Se ID for enviado, atualizar
        
        $rules = [
            'qtdparcelas' => 'required',
            'p1inicio' => 'required',
            'p1fim' => 'required',
            'p2inicio' => 'nullable',
            'p2fim' => 'nullable',
            'p3inicio' => 'nullable',
            'p3fim' => 'nullable',
            'militar_id' => 'nullable',
            'anoreferencia' => 'nullable',
            'status' => 'nullable',
        ];

        try {
            $validated = $request->validate($rules);
            $validated['status'] = $validated['status'] ?? 1;
            // dd($validated);
            if ($id) {
                $plano = Planodeferias::findOrFail($id);
                $plano->update($validated);
                return response()->json(['message' => 'Plano atualizado com sucesso!', 'plano' => $plano], 200);
            } else {
                $plano = Planodeferias::create($validated);
                return response()->json(['message' => 'Plano cadastrado com sucesso!', 'plano' => $plano], 201);
            }
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Plano não encontrado.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro interno do servidor.' . $e->getMessage()], 500);
        }
    }
}
