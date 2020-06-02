<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmpresaFotos extends Model
{
    public $timestamps = false;
    protected $table = 'empresa_foto';

    protected $fillable = [
        'foto', 'is_logo'
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }
}
