<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MetodoPagamento extends Model
{
    public $timestamps = false;
    protected $table = 'metodo_pagamento';

    protected $fillable = [
        'titulo'
    ];

}
