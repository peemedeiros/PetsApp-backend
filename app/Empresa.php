<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    public $timestamps = false;
    protected $table = "empresa";

    protected $fillable = [
        'user_id', 'razao_social', 'nome_fantasia', 'cnpj', 'telefone_empresa', 'cep',
        'logradouro', 'bairro', 'cidade', 'uf', 'complemento', 'numero', 'transporte'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function foto()
    {
        return $this->hasMany(EmpresaFotos::class);
    }

    public function categoria()
    {
        return $this->belongsToMany(Categoria::class, 'empresas_categorias');
    }
}
