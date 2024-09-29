<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Projeto;

/**
 * @OA\Schema(
 *     schema="Equipamento",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="descricao", type="string", example="Inversor"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2024-09-29T00:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-09-29T00:00:00Z")
 * )
 */

class Equipamento extends Model
{
    use HasFactory;
    protected $fillable = ['descricao'];

    public function projetos()
    {
        return $this->belongsToMany(Projeto::class, 'projetos_equipamentos')->withPivot('quantidade');
    }
}
