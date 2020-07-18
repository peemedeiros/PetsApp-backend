<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Especie extends Model
{
    public $timestamps = false;

    protected $fillable = [
      'titulo'
    ];

    public function animais()
    {
        return $this->hasMany(Animal::class);
    }

}
