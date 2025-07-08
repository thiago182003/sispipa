<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemissoes extends Model
{
   protected $table = "permissoes";
    protected $fillable = [
        'nome',
        'descricao',
        'modulo_id',
        'user_id',
        'level',
    ];

    public function modulo()
    {
        return $this->belongsTo(Modulos::class, 'modulo_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
