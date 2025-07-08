<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostoGraduacoes extends Model
{
    protected $table = "posto_graduacoes";
    protected $fillable = [
        'nome',
        'sigla',
        'ord',
        'img',
        'instituicao_id',
    ];
    public function user()
    {
        return $this->hasMany(User::class, 'posto_graduacao_id');
    }

    public function instituicao()
    {
        return $this->belongsTo(Instituicoes::class, 'instituicao_id');
    }
}
