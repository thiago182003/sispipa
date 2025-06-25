<?php

namespace App\Http\Controllers;

use App\Models\TipoMissao;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class TipoMissaoController extends Controller
{
    public function index(){
        return view('operacional.missoes.tipomissoes');
    }

    public function getAll(Request $request)
    {
        $tipomissoes  = TipoMissao::all(); // Corrige o uso de orderBy
        return response()->json(["data" => $tipomissoes]); // Retorna JSON para requisições AJAX
    }

    public function store(Request $request)
    {
        $id = $request->input('id'); // Verifica se o ID foi enviado

        $rules = [
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string|max:255',
        ];

        $validated = $request->validate($rules); // Valida os dados de entrada
        // dd($validated);
        try {
            if ($id) {
                // Atualiza o registro existente
                $tipomissoes = TipoMissao::findOrFail($id);
                $this->update($request, $tipomissoes);
                return response()->json([
                    'message' => 'Tipo de missão atualizado com sucesso!',
                    'data' => $tipomissoes,
                ], 200);
            } else {
                // Cria um novo registro
                $validated['ord'] = 99;
                $validated['instituicao_id'] = 1;
                $tipomissoes = TipoMissao::create($validated);
                return response()->json([
                    'message' => 'Tipo de missão cadastrado com sucesso!',
                    'data' => $tipomissoes,
                ], 201);
            }
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Tipo de missão não encontrado.',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro interno do servidor: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function show(Request $request)
    {
        try {
            $tipomissoes = TipoMissao::findOrFail($request->id);
            return response()->json($tipomissoes, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Tipo de missão não encontrado.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro interno do servidor: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, TipoMissao $modulo)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'string|max:255',
        ]);
    
        try {
            $modulo->update($validated);
    
            return response()->json([
                'message' => 'Tipo de missão atualizado com sucesso!',
                'data' => $modulo,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro ao atualizar o Tipo de missão: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(Request $request)
    {
        try {
            // Busca a OM pelo ID
            $tipomissoes = TipoMissao::findOrFail($request->id);
            // Remove a imagem associada, se existir
            $tipomissoes->delete();
    
            return response()->json(['message' => 'Tipo de missão removido com sucesso!'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Tipo de missão não encontrado.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro interno do servidor: ' . $e->getMessage()], 500);
        }
    }
}
