<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Projeto;


class Cliente extends Model
{
    use HasFactory;
    protected $fillable = ['nome', 'email', 'telefone', 'documento'];

    public function projetos()
    {
        return $this->hasMany(Projeto::class);
    }
}
