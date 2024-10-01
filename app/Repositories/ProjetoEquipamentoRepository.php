<?php

namespace App\Repositories;
use App\Models\ProjetoEquipamento;

class ProjetoEquipamentoRepository{
    public function create(array $data)
    {
        return ProjetoEquipamento::create($data);
    }

    public function findAll() {
        return ProjetoEquipamento::all();
    }

    public function findById($id){
        return ProjetoEquipamento::findOrFail($id);
    }

    public function update(string $id, array $data){
        $projeto = ProjetoEquipamento::find($id);
        
        if (!$projeto) {
            throw new \Exception('Equipamentos do projeto não encontrados.');
        }

        $projeto->update($data);
        return $projeto;
    }

    public function delete(int $id){
        return ProjetoEquipamento::destroy($id);
    }
}