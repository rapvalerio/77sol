<?php

namespace App\Repositories;
use App\Models\Cliente;

class ClienteRepository{
    public function create(array $data)
    {
        return Cliente::create($data);
    }

    public function findById(string $id) {
        return Cliente::findOrFail($id);
    }

    public function findAll(){
        return Cliente::all();
    }

    public function update(string $id, array $data){
        $cliente = Cliente::find($id);
        
        if (!$cliente) {
            throw new \Exception('Cliente não encontrado.');
        }

        $cliente->update($data);
        return $cliente;
    }

    public function delete(int $id){
        return Cliente::destroy($id);
    }
}