<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Projeto;

/**
 * @OA\Schema(
 *     schema="Cliente",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="nome", type="string", example="João Silva"),
 *     @OA\Property(property="email", type="string", example="joao@email.com"),
 *     @OA\Property(property="telefone", type="string", example="(11) 99999-9999"),
 *     @OA\Property(property="documento", type="string", example="12345678901"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2024-09-29T00:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-09-29T00:00:00Z")
 * )
 */
class Cliente extends Model
{
    use HasFactory;
    protected $fillable = ['nome', 'email', 'telefone', 'documento'];

    public function projetos()
    {
        return $this->hasMany(Projeto::class);
    }
}
