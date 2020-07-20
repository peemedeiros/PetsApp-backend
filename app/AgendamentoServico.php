<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AgendamentoServico extends Model
{

    public $timestamps = false;
    protected $table = 'agendamento_servico';

    protected $fillable = [
        "user_id","animal_id","endereco_id",
        "transporte", "valor_transporte", "valor_total", "status",
        "data_agendamento"
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function animal()
    {
        return $this->belongsTo(Animal::class, 'animal_id');
    }

    public function servico()
    {
        return $this->belongsToMany(Servico::class, 'servicos_agendamentos');
    }

    public function endereco()
    {
        return $this->hasOne(EnderecoCliente::class, 'endereco_id');
    }

}