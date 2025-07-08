<?php

namespace App\Http\Controllers;

use App\Models\Oms;
use App\Models\PostoGraduacoes;
use App\Models\Secoes;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function perfil(){
        return view("administrativo.profile");
    }

    public function militares(){
        $secoes = Secoes::all();
        $oms = Oms::all();
        $postoGraduacoes = PostoGraduacoes::all();
        // dd($postoGraduacoes);
        return view("administrativo.militares.militares", compact('secoes','oms','postoGraduacoes'));
    }

    public function getAll(Request $request){
        $search = $request->input('search') ?? ""; // Parâmetro de busca
        // dd($search);
        // $militares = User::query()
        //     ->when($search, function ($query, $search) {
        //         $query->where('nome', 'like', "%{$search}%")
        //             ->orWhere('sigla', 'like', "%{$search}%");
        //     })->with(['secao','postoGraduacao'])->get();

        $militares = User::with('secao','postoGraduacao')->where('level','>','0')->get();

        // $instituicoes = Instituicoes::all();
        // dd($militares);
        return response()->json(["data" => $militares]); // Retorna JSON para requisições AJAX
    }

    public function show(Request $request)
    {
        try {
            $militar = User::with('secao','postoGraduacao')->findOrFail($request->id);
            return response()->json($militar, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Militar não encontrado.'], 404);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $militar = User::findOrFail($request->id);
            $militar->delete();
            return response()->json(['message' => 'Militar excluído com sucesso!'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Militar não encontrado.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao excluir o militar.'], 500);
        }
    }

    public function store(Request $request)
    {
        $id = $request->input('id'); // Se ID for enviado, atualizar
        
        $request['veterano'] = $request['veterano'] == 'true' ? 1 : 0;
        $rules = [
            'nome' => 'required|string|max:255',
            'nomeguerra' => 'required|string|max:255',
            'cpf' => 'nullable|string|size:14|unique:users,cpf,' . $id,
            'identidade' => 'nullable|string|max:20',
            'identidade_emissor' => 'nullable|string|max:10',
            'identidade_data' => 'nullable|date',
            'identidade_militar' => 'nullable|string|max:20',
            'telefone' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:255',
            'veterano' => 'nullable',
            'dtnascimento' => 'nullable|date',
            'dtpraca' => 'nullable|date',
            'om_servico_id' => 'nullable|exists:oms,id',
            'om_vinculo_id' => 'nullable|exists:oms,id',
            'secao_id' => 'nullable|exists:secoes,id',
            'postograduacao_id' => 'nullable|exists:posto_graduacoes,id',
            'status' => 'nullable|string|max:50',
            'level' => 'nullable|integer',
            'img' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:6',
        ];
        // dd($request->all());
        $messages = [
            'cpf.unique' => 'Este CPF já está cadastrado.',
            // 'email.unique' => 'Este e-mail já está cadastrado.',
        ];

        // dd($request->all());

        try {
            $validated = $request->validate($rules, $messages);
            // dd($validated);
            if ($id) {
                // Atualiza o militar existente
                $militar = User::findOrFail($id);
                $militar->update($validated);
                return response()->json(['message' => 'Militar atualizado com sucesso!', 'militar' => $militar], 200);
            } else {
                // Cria um novo militar
                $validated['password'] = isset($validated['password']) ? $validated['password'] : preg_replace('/\D/', '', $validated['cpf']);
                $validated['status'] = 1;
                $militar = User::create($validated);
                // dd($validated,$militar);?:
                return response()->json(['message' => 'Militar cadastrado com sucesso!', 'militar' => $militar], 201);
            }
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Militar não encontrado.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro interno do servidor.' . $e->getMessage()], 500);
        }
    }

    public function resetview(){
        return view('administrativo.militares.alterarsenha');
    }

    public function resetarSenha(Request $request){
        $militar = User::findOrFail($request->id);
        $militar->password = preg_replace('/\D/', '', $militar->cpf);
        $militar->save();
    }

    public function listarMilitares()
    {
        $militares = \App\Models\User::with('postoGraduacao')
            ->select('id', 'nomeguerra', 'postograduacao_id')
            ->get()
            ->map(function($militar) {
                return [
                    'id' => $militar->id,
                    'nomeguerra' => $militar->nomeguerra,
                    'posto' => $militar->postoGraduacao ? $militar->postoGraduacao->nome : '',
                ];
            });
        return response()->json($militares);
    }

    public function buscar(Request $request)
    {
        $termo = $request->input('q');
        $militares = \App\Models\User::where('nomeguerra', 'like', "%{$termo}%")
            ->orWhere('nome', 'like', "%{$termo}%")
            ->limit(20)
            ->get();

        $results = [];
        foreach ($militares as $militar) {
            $results[] = [
                'id' => $militar->id,
                'text' => ($militar->postoGraduacao ? $militar->postoGraduacao->sigla . ' ' : '') . $militar->nomeguerra,
            ];
        }
        return response()->json(['results' => $results]);
    }

    public function getVeterano(Request $request)
    {
        $militar = \App\Models\User::find($request->id);
        if (!$militar) {
            return response()->json(['error' => 'Militar não encontrado'], 404);
        }
        return response()->json(['veterano' => (bool)$militar->veterano]);
    }
}
