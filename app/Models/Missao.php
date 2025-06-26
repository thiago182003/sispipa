<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Missao extends Model
{
    use HasFactory;

    protected $table = 'missoes';

    protected $fillable = [
        'data_inicio',
        'data_fim',
        'objetivos',
        'militares',
        'status',      // adicionado
        'observacao',  // adicionado
    ];

    protected $casts = [
        'objetivos' => 'array',
        'militares' => 'array',
    ];
}