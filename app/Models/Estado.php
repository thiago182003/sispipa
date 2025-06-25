<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    protected $table="estados";
    protected $fillable=['nome','sigla'];

    public function municipios(){
        return $this->belongsToMany(Municipio::class,'municipio_id');
    }
}
