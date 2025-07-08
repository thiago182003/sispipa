<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planodeferias extends Model
{
    use HasFactory;

    protected $table = 'planodeferias'; // Se o nome da tabela for diferente do esperado

    protected $fillable = [
        'qtdparcelas',
        'p1inicio',
        'p1fim',
        'p2inicio',
        'p2fim',
        'p3inicio',
        'p3fim',
        'militar_id',
        'anoreferencia',
        'status',
        'boletim', // NOVO
    ];

    protected $appends = ['periodo1','periodo2','periodo3'];

    public function militar()
    {
        return $this->belongsTo(User::class, 'militar_id');
    }

    public function periodo1(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (!$this->p1inicio || !$this->p1fim) {
                    return null; // Retorna null se não houver ambas as datas
                }

                return strtoupper(Carbon::parse($this->p1inicio)->translatedFormat('d M') . 
                    ' à ' . 
                    Carbon::parse($this->p1fim)->translatedFormat('d M'));
            }
        );
    }

    public function periodo2(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (!$this->p2inicio || !$this->p2fim) {
                    return null; // Retorna null se não houver ambas as datas
                }

                return strtoupper(Carbon::parse($this->p2inicio)->translatedFormat('d M') . 
                    ' à ' . 
                    Carbon::parse($this->p2fim)->translatedFormat('d M'));
            }
        );
    }

    public function periodo3(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (!$this->p3inicio || !$this->p3fim) {
                    return null; // Retorna null se não houver ambas as datas
                }

                return strtoupper(Carbon::parse($this->p3inicio)->translatedFormat('d M') . 
                    ' à ' . 
                    Carbon::parse($this->p3fim)->translatedFormat('d M'));
            }
        );
    }

    public function mudancas()
    {
        return $this->hasMany(PlanodeferiasMudanca::class, 'planodeferias_id');
    }
}
