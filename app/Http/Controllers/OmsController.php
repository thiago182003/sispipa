<?php

namespace App\Http\Controllers;

use App\Models\Oms;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class OmsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $oms = Oms::all();
        return view ("administrativo.oms.index",compact('oms'));
    }

    public function getAll(Request $request){
        $search = $request->input('search') ?? ""; // Parâmetro de busca
        // dd($search);
        $oms = Oms::query()
            ->when($search, function ($query, $search) {
                $query->where('nome', 'like', "%{$search}%")
                    ->orWhere('sigla', 'like', "%{$search}%");
            })->get();

        // $instituicoes = Instituicoes::all();

        return response()->json(["data" => $oms]); // Retorna JSON para requisições AJAX
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
            'nome' => 'required|string|max:255',
            'sigla' => 'required|string|max:50',
            'img' => 'nullable|image|max:2048', // Máx 2MB
            'superior_id' => 'nullable|exists:oms,id',
        ];

        try {
            $validated = $request->validate($rules);
            if ($id) {
                $Om = Oms::findOrFail($id);
                $this->update($request,$Om);
                return response()->json(['message' => 'Om atualizada com sucesso!', 'Om' => $Om], 200);
            } else {
                $Om = Oms::create($validated);
                return response()->json(['message' => 'Om cadastrada com sucesso!', 'Om' => $Om], 201);
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
            $oms = Oms::findOrFail($request->id);
            return response()->json($oms, 200);
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
    public function update(Request $request, Oms $om)
    {
        $validated = $request->validate([
            'nome' => 'sometimes|required|string|max:255',
            'sigla' => 'sometimes|required|string|max:50',
            'img' => 'nullable|image|max:2048',
            'superior_id' => 'nullable|exists:oms,id',
        ]);

        if ($request->hasFile('img')) {
            if ($om->img) {
                Storage::disk('public')->delete($om->img);
            }
            $validated['img'] = $request->file('img')->store('oms', 'public');
        }

        $om->update($validated);
        return response()->json(['message' => 'OM atualizada com sucesso!', 'data' => $om]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try{
            $om = Oms::findOrFail($request->id);
            if ($om->img) {
                Storage::disk('public')->delete($om->img);
            }
            $om->delete();
            return response()->json(['message' => 'OM removida com sucesso!'], 200);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'OM não encontrada.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro interno do servidor.' . $e->getMessage()], 500);
        }
    }
}
