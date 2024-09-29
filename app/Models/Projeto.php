<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Endereco;

/**
 * @OA\Schema(
 *     schema="Projeto",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="nome", type="string", example="Fazenda Solar"),
 *     @OA\Property(property="cliente_id", type="integer", example=1),
 *     @OA\Property(property="endereco_id", type="integer", example=1),
 *     @OA\Property(property="instalacao_id", type="integer", example=1),
 *     @OA\Property(
 *         property="equipamentos",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/ProjetoEquipamento")
 *     ),
 *     @OA\Property(property="cliente", ref="#/components/schemas/Cliente"),
 *     @OA\Property(property="endereco", ref="#/components/schemas/Endereco"),
 *     @OA\Property(property="instalacao", ref="#/components/schemas/Instalacao")
 * )
 */


class Projeto extends Model
{
    use HasFactory;
    protected $fillable = ['nome', 'cliente_id', 'endereco_id', 'instalacao_id'];
    protected $hidden = ['created_at', 'updated_at'];

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
