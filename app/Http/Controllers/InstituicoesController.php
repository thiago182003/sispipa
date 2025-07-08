<?php

namespace App\Http\Controllers;

use App\Models\Instituicoes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class InstituicoesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view ("administrativo.instituicoes.index");
    }

    public function getAll(Request $request){
        $search = $request->input('search') ?? ""; // Parâmetro de busca
        $instituicoes = Instituicoes::query()
            ->when($search, function ($query, $search) {
                $query->where('nome', 'like', "%{$search}%")
                    ->orWhere('sigla', 'like', "%{$search}%");
            })->get();

        // $instituicoes = Instituicoes::all();

        return response()->json(["data" => $instituicoes]); // Retorna JSON para requisições AJAX
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("administrativo.instituicoes.instituicao");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'sigla' => 'required|string|max:10',
            'img' => 'max:255'
        ]);
        
        // dd($request);
        if($request->id){
            $this->update($request);
        }else{
            $instituicao = Instituicoes::create($validated);
        }
        return response()->json(['success'=>'Instituicao salva com sucesso.']);
        // return redirect()->route("instituicoes.index")->with('success','Instituicao salva com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $instituicao = Instituicoes::findOrFail($id);
        return response()->json($instituicao);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $instituicao = Instituicoes::findOrFail($id);
        return view("administrativo.instituicoes.instituicao",compact('instituicao'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $instituicao = Instituicoes::find($request->id);
        $instituicao->fill($request->all());
        // dd($request->all(),$instituicao);
        $instituicao->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {
            // Busca a instituição pelo ID
            $instituicao = Instituicoes::find($request->id);

            // Se não encontrar, retorna erro 404
            if (!$instituicao) {
                return response()->json(['error' => 'Instituição não encontrada.'], 404);
            }
    
            // Se houver imagem, tenta deletar
            if ($instituicao->imagem) {
                if (!Storage::disk('public')->exists($instituicao->imagem)) {
                    Log::warning("Imagem não encontrada: {$instituicao->imagem}");
                } else {
                    if (!Storage::disk('public')->delete($instituicao->imagem)) {
                        return response()->json(['error' => 'Erro ao deletar a imagem.'], 500);
                    }
                }
            }
    
            // Deleta a instituição
            $instituicao->delete();
    
            return response()->json(['success' => 'Instituição removida com sucesso.']);
    
        } catch (\Exception $e) {
            // Registra erro no log e retorna resposta de erro
            Log::error('Erro ao deletar instituição: ' . $e->getMessage());
            return response()->json(['error' => 'Ocorreu um erro ao tentar remover a instituição.'], 500);
        }

    }
}