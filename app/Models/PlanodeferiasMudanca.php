<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanodeferiasMudanca extends Model
{
    protected $fillable = ['planodeferias_id', 'diex', 'pdf_path'];

    public function plano()
    {
        return $this->belongsTo(Planodeferias::class, 'planodeferias_id');
    }
}