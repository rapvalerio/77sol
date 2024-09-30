<?php
namespace App\Services;
use App\Entities\EnderecoEntity;
use App\Models\Endereco;
use App\Repositories\EnderecoRepository;

class EnderecoServices {

    protected $enderecoRepository;

    public function __construct(EnderecoRepository $enderecoRepository)
    {
        $this->enderecoRepository = $enderecoRepository;
    }

    public function criaEndereco(array $data){
        $enderecoEntity = new EnderecoEntity($data['uf']);
        return $this->enderecoRepository->create($enderecoEntity->toArray());
    }

    public function buscaEndereco(string $id){
        return $this->enderecoRepository->findById($id);
    }

    public function editaEndereco(array $data, string $id){
        $enderecoEntity = new EnderecoEntity($data['uf']);
        $enderecoEntity->setId($id);
        return $this->enderecoRepository->update($id, $enderecoEntity->toArray());
    }

    public function removerEndereco(string $id){
        $instalacao = $this->enderecoRepository->findById($id);
    
        if (!$instalacao) {
            throw new \Exception('Endereço não encontrado.');
        }

        return $this->enderecoRepository->delete($id);
    }
}