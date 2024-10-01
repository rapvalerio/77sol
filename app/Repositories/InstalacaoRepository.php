<?php

namespace App\Repositories;
use App\Models\Instalacao;

class InstalacaoRepository{
    public function create(array $data)
    {
        return Instalacao::create($data);
    }

    public function findById(int $id): ?Instalacao {
        return Instalacao::find($id);
    }

    public function findAll(){
        return Instalacao::all();
    }

    public function update(string $id, array $data){
        $instalacao = Instalacao::find($id);
        
        if (!$instalacao) {
            throw new \Exception('Instalação não encontrada.');
        }

        $instalacao->update($data);
        return $instalacao;
    }

    public function delete(int $id){
        return Instalacao::destroy($id);
    }
}