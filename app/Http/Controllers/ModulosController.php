<?php

namespace App\Http\Controllers;

use App\Models\Modulos;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ModulosController extends Controller
{
    public function index()
    {
        return view ("administrativo.modulos.index");
    }

    public function getAll(Request $request)
    {
        $modulos = Modulos::all(); // Corrige o uso de orderBy
        return response()->json(["data" => $modulos]); // Retorna JSON para requisições AJAX
    }

    public function store(Request $request)
    {
        $id = $request->input('id'); // Verifica se o ID foi enviado

        $rules = [
            'nome' => 'required|string|max:255',
        ];

        $validated = $request->validate($rules); // Valida os dados de entrada
        // dd($validated);
        try {
            if ($id) {
                // Atualiza o registro existente
                $modulos = Modulos::findOrFail($id);
                $this->update($request, $modulos);
                return response()->json([
                    'message' => 'Posto/Graduação atualizado com sucesso!',
                    'data' => $modulos,
                ], 200);
            } else {
                // Cria um novo registro
                $validated['ord'] = 99;
                $validated['instituicao_id'] = 1;
                $modulos = Modulos::create($validated);
                return response()->json([
                    'message' => 'Posto/Graduação cadastrado com sucesso!',
                    'data' => $modulos,
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

    public function show(Request $request)
    {
        try {
            $modulos = Modulos::findOrFail($request->id);
            return response()->json($modulos, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Posto/Graduação não encontrado.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro interno do servidor: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, Modulos $modulo)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
        ]);
    
        try {
            $modulo->update($validated);
    
            return response()->json([
                'message' => 'Modulo atualizado com sucesso!',
                'data' => $modulo,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro ao atualizar o Posto/Graduação: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(Request $request)
    {
        try {
            // Busca a OM pelo ID
            $modulos = Modulos::findOrFail($request->id);
            // Remove a imagem associada, se existir
            if ($modulos->img) {
                Storage::disk('public')->delete($modulos->img);
            }
            $modulos->delete();
    
            return response()->json(['message' => 'Modulo removido com sucesso!'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Modulo não encontrado.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro interno do servidor: ' . $e->getMessage()], 500);
        }
    }
}
