<?php

namespace App\Repositories;
use App\Models\Equipamento;

class EquipamentoRepository{
    public function create(array $data)
    {
        return Equipamento::create($data);
    }

    public function findById(int $id) {
        return Equipamento::find($id);
    }

    public function findAll(){
        return Equipamento::all();
    }

    public function update(string $id, array $data){
        $equipamento = Equipamento::find($id);
        
        if (!$equipamento) {
            throw new \Exception('Equipamento não encontrado.');
        }

        $equipamento->update($data);
        return $equipamento;
    }

    public function delete(int $id){
        return Equipamento::destroy($id);
    }
}