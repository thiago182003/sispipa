<?php

namespace App\Http\Controllers;

use App\Models\Situacoes;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SituacoesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view ("administrativo.situacoes.index");
    }

    public function getAll(Request $request){
        $situacoes = Situacoes::all();
        return response()->json(["data" => $situacoes]); // Retorna JSON para requisições AJAX
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
        $id = $request->input('id'); // Se ID for enviado, atualizar
        
        $rules = [
            'nome' => 'required',
            'descricao' => 'nullable'
        ];

        try {
            $validated = $request->validate($rules);
            $validated['status'] = $validated['status'] ?? 1;
            // dd($validated);
            if ($id) {
                $plano = Situacoes::findOrFail($id);
                $plano->update($validated);
                return response()->json(['message' => 'Plano atualizado com sucesso!', 'plano' => $plano], 200);
            } else {
                $plano = Situacoes::create($validated);
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

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        try{
            $situacao = Situacoes::findOrFail($request->id);
            return response()->json($situacao, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro interno do servidor.' . $e->getMessage()], 500);
        }
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try{
            $plano = Situacoes::findOrFail($request->id);
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

    public function versituacoes(){
        $situacoes = Situacoes::all();
        $militares = User::where('level','>','0')->with('situacao','postoGraduacao')->get();
        return view("e1.situacao",compact('situacoes','militares'));
    }

    public function situacoesmilitares(){
        $militares = User::where('level','>','0')->with('situacao','postoGraduacao')->get();
        return response()->json(["data" => $militares]);
    }

    public function salvarsituacoes(Request $request){
        $request->validate([
            'id' => 'required|exists:users,id', // considerando que a tabela é "users"
            'situacao' => 'required|string', // ajuste conforme o tipo da situação
        ]);
    
        try {
            $militar = User::findOrFail($request->id);
            // Aqui você pode atualizar a situação do militar. Por exemplo:
            $militar->situacao_id = $request->situacao; // supondo que o campo 'situacao' exista
            $militar->save();
    
            return response()->json(['success' => 'Situação atualizada com sucesso!']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao atualizar a situação.'], 500);
        }
    }
}
