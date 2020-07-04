<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServicoFotos extends Model
{
    public $timestamps = false;
    protected $table = 'servico_fotos';

    protected $fillable = [
        'foto', 'is_thumb'
    ];

    public function servico()
    {
        return $this->belongsTo(Servico::class);
    }

}
