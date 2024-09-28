<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Endereco;

class Projeto extends Model
{
    use HasFactory;
    protected $fillable = ['nome', 'cliente_id', 'endereco_id', 'instalacao_id'];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function endereco()
    {
        return $this->belongsTo(Endereco::class);
    }

    public function instalacao()
    {
        return $this->belongsTo(Instalacao::class);
    }

    public function equipamentos()
    {
        return $this->belongsToMany(Equipamento::class, 'projetos_equipamentos')->withPivot('quantidade');
    }
}
