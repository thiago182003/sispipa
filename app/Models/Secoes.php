<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Secoes extends Model
{

    protected $fillable = [
        'nome','sigla','om_id','superior_id'
    ];

    public function oms()
    {
        return $this->belongsTo(Oms::class, 'om_id');
    }

    public function superior()
    {
        return $this->belongsTo(Secoes::class, 'superior_id');
    }
}
