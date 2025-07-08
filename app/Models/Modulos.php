<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modulos extends Model
{
    protected $table = "modulos";
    protected $fillable = [
        'nome',
        'descricao',
    ];

}
