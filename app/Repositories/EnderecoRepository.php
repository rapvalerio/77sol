<?php

namespace App\Repositories;
use App\Models\Endereco;

class EnderecoRepository{
    public function create(array $data)
    {
        return Endereco::create($data);
    }

    public function findById(string $id) {
        return Endereco::findOrFail($id);
    }

    public function findAll(){
        return Endereco::all();
    }

    public function update(string $id, array $data){
        $endereco = Endereco::find($id);
        
        if (!$endereco) {
            throw new \Exception('Instalação não encontrada.');
        }

        $endereco->update($data);
        return $endereco;
    }

    public function delete(int $id){
        return Endereco::destroy($id);
    }
}