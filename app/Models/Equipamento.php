<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Projeto;

class Equipamento extends Model
{
    use HasFactory;
    protected $fillable = ['descricao'];

    public function projetos()
    {
        return $this->belongsToMany(Projeto::class, 'projetos_equipamentos')->withPivot('quantidade');
    }
}
