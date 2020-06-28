<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    public $timestamps = false;
    protected $fillable = [ 'categoria' ];

    public function empresa()
    {
        return $this->belongsToMany(Empresa::class, 'empresas_categorias');
    }
}
