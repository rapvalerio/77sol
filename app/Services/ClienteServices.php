<?php
namespace App\Services;
use App\Entities\ClienteEntity;
use App\Repositories\ClienteRepository;

class ClienteServices {

    protected $clienteRepository;

    public function __construct(ClienteRepository $clienteRepository)
    {
        $this->clienteRepository = $clienteRepository;
    }

    public function criaCliente(array $data){
        $clienteEntity = new ClienteEntity($data['nome'], $data['email'], $data['telefone'], $data['documento']);

        return $this->clienteRepository->create($clienteEntity->toArray());
    }

    public function buscaCliente(string $id = null){
        if($id == null){
            return $this->clienteRepository->findAll();
        }

        return $this->clienteRepository->findById($id);
    }

    public function editaCliente(array $data, string $id){
        $clienteEntity = new ClienteEntity($data['nome'], $data['email'], $data['telefone'], $data['documento']);
        $clienteEntity->setId($id);

        return $this->clienteRepository->update($id, $clienteEntity->toArray());
    }

    public function removerCliente(string $id){
        $cliente = $this->clienteRepository->findById($id);
    
        if (!$cliente) {
            throw new \Exception('Cliente não encontrado.');
        }

        return $this->clienteRepository->delete($id);
    }
}