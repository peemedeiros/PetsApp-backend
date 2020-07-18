<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EnderecoCliente extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id', 'nome_endereco', 'cep', 'logradouro', 'cidade', 'estado',
        'complemento', 'numero'
    ];

    public function usuarioEndereco()
    {
        return $this->belongsTo(User::class);
    }
}
