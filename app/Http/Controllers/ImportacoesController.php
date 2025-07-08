<?php

namespace App\Http\Controllers;

use App\Models\MissoesAntigas;
use App\Models\Planilhao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Cast\Double;

class ImportacoesController extends Controller
{
    public function planilhao()
    {
        return view("importacoes.planilhao");
    }

    public function ouvidoria()
    {
        return view("importacoes.ouvidoria");
    }

    public function planilhaoupload(Request $request)
    {
        try {
            $request->validate([
                'planilhao' => 'required|mimes:csv,txt'
            ]);
            $delimitador = "\t";
            $arquivo = fopen($request->file('planilhao'), 'r');

            $cabecalho = fgetcsv($arquivo, 0, $delimitador); //leu a primeira linha do cabecalho

            if (feof($arquivo)) {
                exit('Você importou um CSV vazio');
            }
            DB::statement('truncate Table planilhao');
            while ($linha = fgetcsv($arquivo, 0, $delimitador)) {
                $teste = new Planilhao();
                $teste["UG"] = $linha[0];
                $teste["NOME_UG"] = $linha[1];
                $teste["ICFEX"] = $linha[2];
                $teste["PROGRAMA"] = $linha[3];
                $teste["NOME_PROGRAMA"] = $linha[4];
                $teste["ACAO"] = $linha[5];
                $teste["NOME_ACAO"] = $linha[6];
                $teste["UGR"] = $linha[7];
                $teste["NOME_UGR"] = $linha[8];
                $teste["PTRES"] = $linha[9];
                $teste["FONTE"] = $linha[10];
                $teste["NOME_FONTE"] = $linha[11];
                $teste["PI"] = $linha[12];
                $teste["NOME_PI"] = $linha[13];
                $teste["ND"] = $linha[14];
                $teste["SI"] = $linha[15];
                $teste["NE"] = $linha[16];
                $teste["TIPOEMPENHO"] = $linha[17];
                $teste["CHAVE"] = $linha[18];
                $teste["EMISSAO"] = $linha[19];
                $teste["FAV"] = $linha[20];
                $teste["NOME_FAV"] = $linha[21];
                $teste["COD_AMPARO"] = $linha[22];
                $teste["MOD_LIC"] = $linha[23];
                $teste["REF_DISP"] = $linha[24];
                $teste["OBS"] = $linha[25];
                $teste["LOCAL"] = $linha[26];
                $teste["RP"] = $linha[27];
                $teste["NOME_RP"] = $linha[28];
                $teste["TIPO_CREDITO"] = $linha[29];
                $teste["NOME_TIPO_CREDITO"] = $linha[30];
                $teste["PO"] = $linha[31];
                $teste["AUTOR_EMENDA"] = $linha[32];
                $teste["NOME_AUTOR_EMENDA"] = $linha[33];
                $teste["NOME_UO"] = $linha[34];
                $teste["UO"] = $linha[35];
                $teste["A_LIQUIDAR"] = (float) str_replace(',', '.', $linha[36]);
                $teste["EM_LIQUIDACAO"] = (float) str_replace(',', '.', $linha[37]);
                $teste["LIQUIDADO"] = (float) str_replace(',', '.', $linha[38]);
                $teste["PAGO"] = (float) str_replace(',', '.', $linha[39]);
                $teste->save();
            }
            return response()->json(['message' => 'Arquivo enviado com sucesso!']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao importar o arquivo: ' . $e->getMessage()]);
        }
    }

    public function custo()
    {
        return view("importacoes.custo");
    }

    public function missoes()
    {
        return view("importacoes.missoes");
    }

    public function missoesupload(Request $request)
{
    try {
        $request->validate([
    'missoes' => 'required|mimes:csv,txt,xls,xlsx|mimetypes:text/plain,text/csv,application/csv,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
]);

        $delimitador = ";";
        $arquivo = fopen($request->file('missoes'), 'r');

        $conteudo = stream_get_contents($arquivo);
        $conteudoUtf8 = mb_convert_encoding($conteudo, 'UTF-8', 'ISO-8859-1');
        fclose($arquivo);
// Detecta se não está em UTF-8 e converte
if (!mb_check_encoding($conteudo, 'UTF-8')) {
    $conteudo = mb_convert_encoding($conteudo, 'UTF-8', 'ISO-8859-1');
}

$arquivoTemp = tmpfile();
fwrite($arquivoTemp, $conteudo);
rewind($arquivoTemp);
        $cabecalho = fgetcsv($arquivoTemp, 0, $delimitador);

        if (feof($arquivoTemp)) {
            return response()->json(['error' => 'Você importou um CSV vazio'], 400);
        }

        DB::statement('truncate Table missao_Temp');

        while ($linha = fgetcsv($arquivoTemp, 0, $delimitador)) {
            $missao = new MissoesAntigas();
            $missao["militar"]    = $linha[0] ?? null;
            $missao["nivel"]      = $linha[1] ?? null;
            $missao["guerra"]     = $linha[2] ?? null;
            $missao["om"]         = $linha[3] ?? null;
            $missao["ida"]        = isset($linha[4]) ? \Carbon\Carbon::createFromFormat('d/m/Y', $linha[4])->format('Y-m-d') : null;
            $missao["retorno"]    = isset($linha[5]) ? \Carbon\Carbon::createFromFormat('d/m/Y', $linha[5])->format('Y-m-d') : null;
            $missao["mes"]        = $linha[6] ?? null;
            $missao["mes_id"]     = $linha[7] ?? null;
            $missao["missao"]     = $linha[8] ?? null;
            $missao["valores"]    = isset($linha[9]) ? (float) str_replace(['R$', '.', ','], ['', '', '.'], $linha[9]) : 0;
            $missao["diarias"]    = isset($linha[10]) ? (float) str_replace(',', '.', $linha[10]) : 0;
            $missao["ano"]        = $linha[11] ?? null;
            $missao["meta"]       = $linha[12] ?? null;
            $missao["equipe"]     = (isset($linha[13]) && $linha[13] !== '' ? (int)$linha[13] : null);
            $missao["boletim"]    = $linha[14] ?? null;

            $missao->save();
        }

        fclose($arquivoTemp);
        return response()->json(['message' => 'Arquivo enviado com sucesso!']);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Erro ao importar o arquivo: ' . $e->getMessage()], 500);
    }
}

    public function custoupload(Request $request)
    {
        try {
            $request->validate([
                'custo' => 'required|mimes:csv,txt'
            ]);
            $delimitador = ";";
            $arquivo = fopen($request->file('custo'), 'r');

            $cabecalho = fgetcsv($arquivo, 0, $delimitador); //leu a primeira linha do cabecalho

            if (feof($arquivo)) {
                exit('Você importou um CSV vazio');
            }

            while ($linha = fgetcsv($arquivo, 0, $delimitador)) {
                $teste = new Planilhao();
                $teste["UG"] = $linha[0];
                $teste["NOME_UG"] = $linha[1];
                $teste["ICFEX"] = $linha[2];
                $teste["PROGRAMA"] = $linha[3];
                $teste["NOME_PROGRAMA"] = $linha[4];
                $teste["ACAO"] = $linha[5];
                $teste["NOME_ACAO"] = $linha[6];
                $teste["UGR"] = $linha[7];
                $teste["NOME_UGR"] = $linha[8];
                $teste["PTRES"] = (float) str_replace(',', '.', str_replace('.', '', $linha[9]));
                if ($teste["PTRES"] == "") {
                    continue;
                }
                if ($teste->save()) {
                    continue;
                } else {
                    return response()->json(['error' => 'Erro ao importar o arquivo: ' . "Erro"]);
                }
            }
            return response()->json(['message' => 'Arquivo enviado com sucesso!']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao importar o arquivo: ' . "Erro"]);
        }
    }
}
