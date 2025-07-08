<?php

namespace App\Http\Controllers;

use App\Models\Missao;
use App\Models\User;
use Illuminate\Http\Request;

class MissaoController extends Controller
{
    public function index()
    {
        $missoes = Missao::all();

        // Para cada missão, busque os dados completos dos militares
        foreach ($missoes as $missao) {
            if (!is_array($missao->objetivos)) {
                $missao->objetivos = $missao->objetivos ? json_decode($missao->objetivos, true) : [];
            }
            $militaresDetalhados = [];
            foreach ($missao->militares as $militar) {
                if (isset($militar['id']) && $militar['id']) {
                    $user = \App\Models\User::with(['postoGraduacao', 'omServico'])->find($militar['id']);
                    if ($user) {
                        $militaresDetalhados[] = [
                            'nomeguerra' => $user->nomeguerra,
                            'postograduacao' => $user->postoGraduacao->nome ?? '',
                            'om_servico' => $user->omServico->nome ?? '',
                        ];
                    }
                } else {
                    // Militar não listado (preenchido manualmente)
                    $posto = null;
                    $om = null;
                    if (!empty($militar['postograduacao_id'])) {
                        $posto = \App\Models\PostoGraduacoes::find($militar['postograduacao_id']);
                    }
                    if (!empty($militar['om_servico_id'])) {
                        $om = \App\Models\Oms::find($militar['om_servico_id']);
                    }
                    $militaresDetalhados[] = [
                        'nomeguerra' => $militar['nome'] ?? 'Não informado',
                        'postograduacao' => $posto ? $posto->nome : '',
                        'om_servico' => $om ? $om->nome : '',
                    ];
                }
            }
            // Adiciona os militares detalhados à missão
            $missao->militares_detalhados = $militaresDetalhados;
        }

        return view('operacional.missoes.index', compact('missoes'));
    }

    public function create()
    {
        $militares = \App\Models\User::with(['postoGraduacao', 'omServico'])->get();
        $municipios = \App\Models\Municipio::orderBy('nome')->get();
        $postos = \App\Models\PostoGraduacoes::orderBy('nome')->get();
        $oms = \App\Models\Oms::orderBy('nome')->get();
        $objetivos = \App\Models\Objetivo::orderBy('nome')->get(); // Adicione esta linha
        return view('operacional.missoes.criar', compact('militares', 'municipios', 'postos', 'oms', 'objetivos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after_or_equal:data_inicio',
            'objetivos' => 'required|array|min:1',
            'militares' => 'required|array|min:2|max:4',
        ]);

        $objetivosSelecionados = $request->input('objetivos', []);
        $municipiosPorObjetivo = $request->input('municipios_por_objetivo', []);

        $objetivos = [];
        foreach ($objetivosSelecionados as $objetivoId) {
            $municipios = isset($municipiosPorObjetivo[$objetivoId]) ? json_decode($municipiosPorObjetivo[$objetivoId], true) : [];
            $objetivoNome = \App\Models\Objetivo::find($objetivoId)->nome ?? $objetivoId;
            $objetivos[$objetivoNome] = $municipios;
        }

        Missao::create([
            'data_inicio' => $request->data_inicio,
            'data_fim' => $request->data_fim,
            'objetivos' => $objetivos, // Agora é um array de IDs
            'militares' => $request->militares,
            'status' => null,
            'observacao' => null,
        ]);

        return redirect()->route('operacional.missoes.index')->with('success', 'Missão criada com sucesso!');
    }

    public function edit(Missao $missao)
    {
        $militares = \App\Models\User::with(['postoGraduacao', 'omServico'])->get();
        $municipios = \App\Models\Municipio::orderBy('nome')->get();
        $postos = \App\Models\PostoGraduacoes::orderBy('nome')->get();
        $oms = \App\Models\Oms::orderBy('nome')->get();
        return view('operacional.missoes.editar', compact('missao', 'militares', 'municipios', 'postos', 'oms'));
    }

    public function update(Request $request, Missao $missao)
    {
        $request->validate([
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after_or_equal:data_inicio',
            'objetivos' => 'required|array',
            'militares' => 'required|array|min:2|max:4',
        ]);

        $objetivosSelecionados = $request->input('objetivos', []);
        $municipiosPorObjetivo = $request->input('municipios_por_objetivo', []);

        $objetivos = [];
        foreach ($objetivosSelecionados as $objetivoId) {
            $municipios = isset($municipiosPorObjetivo[$objetivoId]) ? json_decode($municipiosPorObjetivo[$objetivoId], true) : [];
            $objetivoNome = \App\Models\Objetivo::find($objetivoId)->nome ?? $objetivoId;
            $objetivos[$objetivoNome] = $municipios;
        }

        $missao->update([
            'data_inicio' => $request->data_inicio,
            'data_fim' => $request->data_fim,
            'objetivos' => $objetivos,
            'militares' => $request->militares,
        ]);

        return redirect()->route('operacional.missoes.index')->with('success', 'Missão atualizada com sucesso!');
    }

    public function atualizarStatus(Request $request, Missao $missao)
    {
        $request->validate([
            'status' => 'required|in:aprovado,reprovado,parcial',
            'observacao' => 'nullable|string|max:1000'
        ]);

        $missao->status = $request->status;
        $missao->observacao = $request->status === 'parcial' ? $request->observacao : null;
        $missao->save();

        return response()->json([
            'success' => true,
            'status' => $missao->status,
            'observacao' => $missao->observacao,
        ]);
    }

    public function destroy(Missao $missao)
    {
        $missao->delete();
        return response()->json(['success' => true]);
    }
}