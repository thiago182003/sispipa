<?php
namespace App\Http\Controllers;

use App\Models\Itinerario;
use App\Models\Municipio;
use Illuminate\Http\Request;

class ItinerarioController extends Controller
{
    public function index()
    {
        $itinerarios = Itinerario::orderBy('numero')->get();
        $municipios = Municipio::orderBy('nome')->pluck('nome')->toArray();
        
        return view('operacional.missoes.itinerarios', compact('itinerarios', 'municipios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'municipios' => 'required|array|min:2',
            'municipios.*' => 'required|string|exists:municipios,nome'
        ]);

        Itinerario::create([
            'municipios' => $request->municipios
        ]);

        return redirect()->route('operacional.itinerarios.index')
            ->with('success', 'Itinerário criado com sucesso!');
    }

    public function update(Request $request, Itinerario $itinerario)
    {
        $request->validate([
            'municipios' => 'required|array|min:2',
            'municipios.*' => 'required|string|exists:municipios,nome'
        ]);

        $itinerario->update([
            'municipios' => $request->municipios
        ]);

        return redirect()->route('operacional.itinerarios.index')
            ->with('success', 'Itinerário atualizado com sucesso!');
    }

    public function destroy(Itinerario $itinerario)
    {
        $itinerario->delete();
        return redirect()->route('operacional.itinerarios.index')
            ->with('success', 'Itinerário excluído com sucesso!');
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