<?php

namespace App\Http\Controllers;

use App\Models\Oms;
use App\Models\Secoes;
use Illuminate\Http\Request;

class SecoesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $oms = Oms::with('secoes')->get();
        // dd($oms);
        return view ("administrativo.secoes.index",compact('oms'));
    }

    public function getAll(Request $request){
        $search = $request->input('search') ?? ""; // Parâmetro de busca
        $secoes = Secoes::query()
            ->when($search, function ($query, $search) {
                $query->where('nome', 'like', "%{$search}%")
                    ->orWhere('sigla', 'like', "%{$search}%");
            })->with(['superior','oms'])->get();

        return response()->json(["data" => $secoes]); // Retorna JSON para requisições AJAX
    }

    public function getSecoes($id)
    {
        $secoes = Secoes::where('om_id', $id)->get();
        return response()->json($secoes);
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
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'sigla' => 'required|string|max:50',
            'om_id' => '',
            "superior_id" => ''
        ]);
        // dd($validated);
        
        // dd($request);
        if($request->id){
            $this->update($request);
        }else{
            $secoes = Secoes::create($validated);
            // dd($secoes);
        }
        return response()->json(['success'=>'Instituicao salva com sucesso.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        try{
            $secao = Secoes::findOrFail($request->id);
            return response()->json($secao, 200);
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
    public function update(Request $request)
    {
        $secao = Secoes::find($request->id);
        $secao->fill($request->all());
        $secao->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
