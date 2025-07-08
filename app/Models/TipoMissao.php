<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoMissao extends Model
{
    protected $table = "tipo_missao";

    protected $fillable = ['nome', 'descricao'];

    /**
     * Relacionamento com Missões (N:N)
     */
    public function missoes()
    {
        return $this->belongsToMany(Missao::class, 'missao_tipo');
    }
}
