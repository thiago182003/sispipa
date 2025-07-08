<?php

namespace App\Http\Controllers;

use App\Models\PostoGraduacoes;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostoGraduacoesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("administrativo.postograduacoes.index");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function getAll(Request $request)
    {
        $postograduacoes = PostoGraduacoes::orderBy('ord')->get(); // Corrige o uso de orderBy
        return response()->json(["data" => $postograduacoes]); // Retorna JSON para requisições AJAX
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $id = $request->input('id'); // Verifica se o ID foi enviado

        $rules = [
            'nome' => 'required|string|max:255',
            'sigla' => 'required|string|max:50',
            'img' => 'nullable|image|max:2048', // Máx 2MB
        ];

        $validated = $request->validate($rules); // Valida os dados de entrada
        // dd($validated);
        try {
            if ($id) {
                // Atualiza o registro existente
                $postograduacoes = PostoGraduacoes::findOrFail($id);
                $this->update($request, $postograduacoes);
                return response()->json([
                    'message' => 'Posto/Graduação atualizado com sucesso!',
                    'data' => $postograduacoes,
                ], 200);
            } else {
                // Cria um novo registro
                $validated['ord'] = 99;
                $validated['instituicao_id'] = 1;
                $postograduacoes = PostoGraduacoes::create($validated);
                return response()->json([
                    'message' => 'Posto/Graduação cadastrado com sucesso!',
                    'data' => $postograduacoes,
                ], 201);
            }
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Posto/Graduação não encontrado.',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro interno do servidor: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        try {
            $postograduacoes = PostoGraduacoes::findOrFail($request->id);
            return response()->json($postograduacoes, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Posto/Graduação não encontrado.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro interno do servidor: ' . $e->getMessage()], 500);
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
    public function update(Request $request, PostoGraduacoes $pg)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'sigla' => 'required|string|max:50',
            'img' => 'nullable|image|max:2048', // Máx 2MB
        ]);
    
        try {
            // Verifica e processa o upload da imagem
            if ($request->hasFile('img')) {
                // Remove a imagem antiga, se existir
                if ($pg->img) {
                    Storage::disk('public')->delete($pg->img);
                }
                // Armazena a nova imagem
                $validated['img'] = $request->file('img')->store('pgs', 'public');
            }
    
            // Atualiza os dados da OM
            $pg->update($validated);
    
            return response()->json([
                'message' => 'Posto/Graduação atualizado com sucesso!',
                'data' => $pg,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro ao atualizar o Posto/Graduação: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {
            // Busca a OM pelo ID
            $postograduacoes = PostoGraduacoes::findOrFail($request->id);
    
            // Remove a imagem associada, se existir
            if ($postograduacoes->img) {
                Storage::disk('public')->delete($postograduacoes->img);
            }
    
            // Exclui o registro da OM
            $postograduacoes->delete();
    
            return response()->json(['message' => 'Posto/Graduação removido com sucesso!'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Posto/Graduação não encontrado.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro interno do servidor: ' . $e->getMessage()], 500);
        }
    }
}
