<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Instituicoes extends Model
{
    protected $fillable = [
        'nome',
        'sigla',
        'img',
    ];
}
