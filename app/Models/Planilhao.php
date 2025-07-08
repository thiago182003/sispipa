<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Planilhao extends Model
{
    protected $table = 'planilhao';

    protected $fillable = [
        "UG",
        "NOME_UG",
        "ICFEX",
        "PROGRAMA",
        "NOME_PROGRAMA",
        "ACAO",
        "NOME_ACAO",
        "UGR",
        "NOME_UGR",
        "PTRES",
        "FONTE",
        "NOME_FONTE",
        "PI",
        "NOME_PI",
        "ND",
        "SI",
        "NE",
        "TIPOEMPENHO",
        "CHAVE",
        "EMISSAO",
        "FAV",
        "NOME_FAV",
        "COD_AMPARO",
        "MOD_LIC",
        "REF_DISP",
        "OBS",
        "LOCAL",
        "RP",
        "NOME_RP",
        "TIPO_CREDITO",
        "NOME_TIPO_CREDITO",
        "PO",
        "AUTOR_EMENDA",
        "NOME_AUTOR_EMENDA",
        "NOME_UO",
        "UO",
        "A_LIQUIDAR",
        "EM_LIQUIDACAO",
        "LIQUIDADO",
        "PAGO"
    ];
}
