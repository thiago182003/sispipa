<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MissoesAntigas extends Model
{
    protected $table = "missao_Temp";
    protected $fillable = [
        'militar',
        'nivel',
        'guerra',
        'om',
        'ida',
        'retorno',
        'mes',
        'mes_id',
        'missao',
        'valores',
        'diarias',
        'ano',
        'meta',
        'equipe',
        'boletim',
    ];

    public $timestamps = false; // Adicione esta linha para desativar os timestamps
}
