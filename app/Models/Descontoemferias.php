<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Descontoemferias extends Model
{
    use HasFactory;

    protected $table = 'descontoemferias';

    protected $fillable = [
        'militar_id',
        'qtd_dias',
        'diex_numero',
        'diex_arquivo',
        'anoreferencia',
    ];

    public function militar()
    {
        return $this->belongsTo(User::class, 'militar_id');
    }
}