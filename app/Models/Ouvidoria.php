<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ouvidoria extends Model
{
    protected $table = "ouvidoria";

    protected $fillable = [
        'hora',
        "nome",
        "municipio",
        "requerente",
        "email",
        "cpf",
        "telefone",
        "relato",
        "protocolo",
        "resolucao",
        "status",
        "dias"
    ];
}
