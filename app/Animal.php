<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id', 'especie_id', 'nome_pet'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }

    public function especie()
    {
        return $this->belongsTo(Especie::class);
    }

    public function agendamento()
    {
        return $this->hasOne(AgendamentoServico::class);
    }
}
