<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Itinerario extends Model
{
    protected $fillable = ['numero', 'municipios'];
    
    protected $casts = [
        'municipios' => 'array'
    ];
    
    protected static function booted()
    {
        static::creating(function ($itinerario) {
            $itinerario->numero = self::max('numero') + 1;
        });
    }
}