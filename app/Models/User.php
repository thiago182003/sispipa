<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Scopes\ExcludeAdminInactiveScope;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'nome',
        'nomeguerra',
        'cpf',
        'identidade',
        'identidade_emissor',
        'identidade_data',
        'identidade_militar',
        'telefone',
        'email',
        'veterano',
        'dtnascimento',
        'dtpraca',
        'om_servico_id',
        'om_vinculo_id',
        'secao_id',
        'postograduacao_id',
        'password',
        'status',
        'level',
        'img',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'dtnascimento' => 'date',
        'dtpraca' => 'date',
        'email_verified_at' => 'datetime',
        'veterano' => 'boolean',
    ];

    protected $appends = ['pg_nome'];

    // protected static function booted()
    // {
    //     static::addGlobalScope(new ExcludeAdminInactiveScope);
    // }

    /**
     * Relação com a Organização Militar onde o usuário serve.
     */
    public function omServico()
    {
        return $this->belongsTo(Oms::class, 'om_servico_id');
    }

    /**
     * Relação com a Organização Militar de vínculo.
     */
    public function omVinculo()
    {
        return $this->belongsTo(Oms::class, 'om_vinculo_id');
    }

    /**
     * Relação com a Seção do usuário.
     */
    public function secao()
    {
        return $this->belongsTo(Secoes::class, 'secao_id');
    }

    /**
     * Relação com o Posto ou Graduação do usuário.
     */
    public function postoGraduacao()
    {
        return $this->belongsTo(\App\Models\PostoGraduacoes::class, 'postograduacao_id');
    }

    /**
     * Mutator: Hash da senha antes de salvar.
     */
    public function setPasswordAttribute($value)
    {
        if ($value) {
            $this->attributes['password'] = Hash::make($value);
        }
    }

    /**
     * Mutator: Formatar CPF antes de salvar.
     */
    public function setCpfAttribute($value)
    {
        $this->attributes['cpf'] = preg_replace('/\D/', '', $value);
    }

    /**
     * Accessor: Exibir CPF formatado.
     */
    public function getCpfAttribute($value)
    {
        return $value ? preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $value) : null;
    }

    /**
     * Accessor: Retorna o caminho completo da imagem.
     */
    public function getImgUrlAttribute()
    {
        return $this->img ? asset('storage/' . $this->img) : asset('images/default-user.png');
    }

    public function situacao()
    {
        return $this->belongsTo(Situacoes::class, 'situacao_id');
    }

    public function pgNome(): Attribute
    {
        return Attribute::make(
            get: fn () => ($this->postoGraduacao ? "{$this->postoGraduacao->sigla} " : "") .
                ($this->veterano ? "R/1 PTTC " : "") .
                $this->nomeguerra
        );
    }

    public function missoes(){
        return $this->belongsToMany(Missao::class,'missao_militar');
    }

    public const NIVEL_ADMIN = 1;
    public const NIVEL_ADMINISTRATIVO = 2;
    public const NIVEL_FINANCEIRO = 3;
    public const NIVEL_OPERACIONAL = 4;
    public const NIVEL_GESTOR_OPERACIONAL = 5;
}
