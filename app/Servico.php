<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Servico extends Model
{
    public $timestamps = false;

    protected $fillable = ['id_subcategoria', 'id_empresa', 'nome', 'preco'];

    public function subcategoria()
    {
        return $this->hasOne(Subcategoria::class);
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function foto()
    {
        return $this->hasMany(ServicoFotos::class);
    }

}
