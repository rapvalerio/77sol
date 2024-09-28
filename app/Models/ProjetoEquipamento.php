<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjetoEquipamento extends Model
{
    use HasFactory;
    protected $table = 'projetos_equipamentos';
    protected $fillable = ['projeto_id', 'equipamento_id', 'quantidade'];
}
