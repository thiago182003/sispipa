<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Oms extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'sigla', 'img', 'superior_id'];

    /**
     * Relacionamento com a OM superior.
     */
    public function superior(): BelongsTo
    {
        return $this->belongsTo(Oms::class, 'superior_id');
    }

    /**
     * Acessor para obter a URL da imagem.
     */
    protected function img(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ? Storage::url($value) : null
        );
    }

    public function secoes(){
        return $this->hasMany(Secoes::class, 'om_id');
    }
}
