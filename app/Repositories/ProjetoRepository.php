<?php

namespace App\Repositories;
use App\Models\Projeto;

class ProjetoRepository{
    public function create(array $data)
    {
        return Projeto::create($data);
    }

    public function find(array $data) {
        $query = Projeto::query();

        // Filtrar por ID, se fornecido
        if (isset($data['id'])) {
            return $query->where('id', $data['id'])->get();
        }

        // Filtrar por nome, se fornecido
        if (isset($data['nome'])) {
            return $query->where('nome', 'like', '%' . $data['nome'] . '%')->get();
        }

        return $query->get();
    }

    public function findById($id){
        $projeto = Projeto::find($id);

        if (!$projeto) {
            throw new \Exception('Projeto não encontrado.');
        }

        return $projeto;
    }

    public function update(string $id, array $data){
        $projeto = Projeto::find($id);
        
        if (!$projeto) {
            throw new \Exception('Projeto não encontrado.');
        }

        $projeto->update($data);
        return $projeto;
    }

    public function delete(int $id){
        return Projeto::destroy($id);
    }
}