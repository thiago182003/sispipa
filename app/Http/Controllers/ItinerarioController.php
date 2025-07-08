<?php
namespace App\Http\Controllers;

use App\Models\Itinerario;
use App\Models\Municipio;
use Illuminate\Http\Request;

class ItinerarioController extends Controller
{
    public function index()
    {
        $itinerarios = Itinerario::orderBy('created_at', 'desc')->get();
        $municipios = Municipio::orderBy('nome')->get()->pluck('nome')->toArray();
        return view('operacional.missoes.itinerarios', compact('itinerarios', 'municipios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'municipio' => 'required|string|max:255'
        ]);

        Itinerario::create([
            'municipio' => $request->municipio,
        ]);

        return redirect()->route('operacional.missoes.itinerarios.index')->with('success', 'Itinerário criado com sucesso!');
    }

    public function update(Request $request, Itinerario $itinerario)
    {
        $request->validate([
            'municipio' => 'required|string|max:255'
        ]);

        $itinerario->update([
            'municipio' => $request->municipio,
        ]);

        return redirect()->route('operacional.missoes.itinerarios.index')->with('success', 'Itinerário atualizado com sucesso!');
    }

    public function destroy(Itinerario $itinerario)
    {
        $itinerario->delete();
        return redirect()->route('operacional.missoes.itinerarios.index')->with('success', 'Itinerário excluído com sucesso!');
    }

    public function buscarMunicipios(Request $request)
    {
        $term = $request->input('term');
        $municipios = Municipio::where('nome', 'like', '%'.$term.'%')
                              ->orderBy('nome')
                              ->pluck('nome')
                              ->toArray();
        
        return response()->json($municipios);
    }
}