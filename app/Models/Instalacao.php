<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Instalacao extends Model
{
    protected $fillable = ['descricao'];
    protected $table = 'instalacoes';
}
