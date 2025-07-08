<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presencas extends Model
{
    protected $table = "presencas";
    protected $fillable = [
        'data',
        'user_id',
        'situacao_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function situacao()
    {
        return $this->belongsTo(Situacoes::class, 'situacao_id');
    }
}
