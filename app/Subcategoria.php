<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subcategoria extends Model
{
    public $timestamps = false;
    protected $table = "subcategoria";

    protected $fillable = ['subcategoria', 'id_categoria'];

    public function categoria()
    {
        return $this->hasMany(Categoria::class);
    }
}
