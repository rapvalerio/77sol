<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Instalacao",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="descricao", type="string", example="Instalação Fotovoltaica"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2024-09-29T00:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-09-29T00:00:00Z")
 * )
 */

class Instalacao extends Model
{
    use HasFactory;
    protected $fillable = ['descricao'];
    protected $table = 'instalacoes';
}
