<?php

namespace App\Repositories;
use App\Entities\ProjetoEntity;
use App\Models\Projeto;
use DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProjetoRepository{
    public function create(ProjetoEntity $projetoEntity, array $equipamentoData)
    {
        try{
            DB::beginTransaction();

            $data = $projetoEntity->toArray();

            $projeto = Projeto::create($data)->load('equipamentos');

            if (isset($equipamentoData)) {
                $equipamentos = [];

                foreach ($equipamentoData as $equipamento) {
                    $equipamentos[$equipamento['equipamento_id']] = ['quantidade' => $equipamento['quantidade']];
                }

                $projeto->equipamentos()->attach($equipamentos);
            }

            DB::commit();

            return $projeto->load('equipamentos');
        }catch(\Exception $e){
            DB::rollBack();
            dd($e->getMessage());
            throw $e;
        }
    }

    public function find(array $data) {
        $query = Projeto::with('equipamentos');

        if (isset($data['id'])) {
            $projeto = $query->find($data['id']);
            
            if (!$projeto) {
                throw new \Exception('Projeto não encontrado.');
            }

            return $projeto;
        }

        if (isset($data['nome'])) {
            return $query->where('nome', 'like', '%' . $data['nome'] . '%')->get();
        }

        return $query->get();
    }

    public function findById($id){
        return Projeto::with('equipamentos')->findOrFail($id);
    }

    public function update(ProjetoEntity $projetoEntity, ?array $equipamentosData)
    {
        try {
            DB::beginTransaction();
            $projeto = Projeto::findOrFail($projetoEntity->getId());
            $projeto->update($projetoEntity->toArray());

            if ($equipamentosData !== null) {
                $equipamentos = [];
                foreach ($equipamentosData as $equipamento) {
                    $equipamentos[$equipamento['equipamento_id']] = ['quantidade' => $equipamento['quantidade']];
                }
                $projeto->equipamentos()->sync($equipamentos);
            }

            DB::commit();
            return $projeto->load('equipamentos');

        } catch(\Exception $e){
            DB::rollBack();
            throw $e;
        }
    }

    public function delete(int $id){
        $projeto = Projeto::find($id);

        if (!$projeto) {
            throw new ModelNotFoundException('Projeto não encontrado.');
        }

        DB::beginTransaction();
        try {
            $projeto->equipamentos()->detach();

            DB::commit();
            return $projeto->delete();
        } catch(\Exception $e){
            DB::rollBack();
            throw $e;
        }
    }
}