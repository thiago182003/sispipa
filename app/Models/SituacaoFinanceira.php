<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SituacaoFinanceira extends Model
{
    protected $table = "situacao_financeira";
    protected $fillable = ['ano','mes',
                            'pf_empenhado',
                            'pf_liquidado',
                            'pf_pago',
                            'pj_empenhado',
                            'pj_liquidado',
                            'pj_pago'];
}
