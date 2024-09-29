<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="ProjetoEquipamento",
 *     type="object",
 *     @OA\Property(property="projeto_id", type="integer", example=1, description="ID do projeto"),
 *     @OA\Property(property="equipamento_id", type="integer", example=1, description="ID do equipamento"),
 *     @OA\Property(property="quantidade", type="integer", example=10, description="Quantidade de equipamentos no projeto")
 * )
 */


class ProjetoEquipamento extends Model
{
    use HasFactory;
    protected $table = 'projetos_equipamentos';
    protected $fillable = ['projeto_id', 'equipamento_id', 'quantidade'];
}
