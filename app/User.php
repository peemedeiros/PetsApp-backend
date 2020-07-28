<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    public $timestamps = false;

    protected $fillable = [
        'nome', 'email', 'password', 'celular', 'tipo_cadastro'
    ];

    protected $guarded = [
        'id'
    ];

    protected $hidden = [
        'password',
    ];

    public function endereco()
    {
        return $this->hasMany(EnderecoCliente::class);
    }

    public function animal()
    {
        return $this->hasMany(Animal::class);
    }

    public function empresa()
    {
      return $this->hasOne(Empresa::class);
    }

    public function agendamento()
    {
        return $this->hasOne(AgendamentoServico::class);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

}
