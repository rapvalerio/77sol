<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projetos extends Model
{
    use HasFactory;
    protected $fillable = ['nome', 'cliente_id', 'endereco_id', 'instalacao_id'];
}
