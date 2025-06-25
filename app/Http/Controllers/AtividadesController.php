<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Atividade;
use Illuminate\Support\Facades\Auth;

class AtividadesController extends Controller
{
    public function index()
    {
       return view('gestao.atividades.index');
    }

    public function store(Request $request)
    {
        $atividade = new Atividade();
        $atividade->user_id = $request->user_id; // Use o usuário selecionado
        $atividade->title = $request->title;
        $atividade->start = $request->start;
        $atividade->end = $request->end;
        $atividade->color = '#007bff'; // Azul ao criar
        $atividade->status = 'pendente'; // Adicione esse campo na migration/model se quiser controlar o status
        $atividade->save();

        return response()->json(['success' => true]);
    }

   public function show()
{
    $atividades = \App\Models\Atividade::with('user.secao', 'user.postoGraduacao')->get();
    $hoje = now()->toDateString();
    foreach ($atividades as $atividade) {
        if ($atividade->status == 'finalizada') {
            $atividade->color = '#28a745'; // verde
        } elseif ($atividade->end && $atividade->end < $hoje) {
            $atividade->color = '#ff0000'; // vermelho
        } else {
            $atividade->color = '#007bff'; // azul
        }
        // Corrija aqui: pegue a seção pelo relacionamento do usuário
        $atividade->criador = $atividade->user
            ? ($atividade->user->postoGraduacao ? $atividade->user->postoGraduacao->sigla : '') . ' ' . $atividade->user->nomeguerra
            : '';
        $atividade->secao = $atividade->user && $atividade->user->secao
            ? $atividade->user->secao->nome
            : '';
    }
    return response()->json($atividades);
}

    public function update(Request $request)
    {
        $atividade = Atividade::find($request->id);
        if ($atividade) {
            if ($request->has('status')) {
                $atividade->status = $request->status;
            }
            if ($request->has('title')) {
                $atividade->title = $request->title;
            }
            if ($request->has('start')) {
                $atividade->start = $request->start;
            }
            if ($request->has('color')) {
                $atividade->color = $request->color;
            }
            $atividade->save();
        }
        return response()->json(['success' => true]);
    }

    public function destroy(Request $request)
    {
        $atividade = Atividade::find($request->id);
        if ($atividade) {
            $atividade->delete();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 404);
    }

    
}
