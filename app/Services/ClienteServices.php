<?php
namespace App\Services;
use App\Entities\ClienteEntity;
use App\Repositories\ClienteRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
        $cliente = $this->clienteRepository->findById($id);

        $clienteEntity = new ClienteEntity($cliente['nome'], $cliente['email'], $cliente['telefone'], $cliente['documento']);

        $nome = isset($data['nome'])?$data['nome']:$clienteEntity->getNome();
        $email = isset($data['email'])?$data['email']:$clienteEntity->getEmail();
        $telefone = isset($data['telefone'])?$data['telefone']:$clienteEntity->getTelefone();
        $documento = isset($data['documento'])?$data['documento']:$clienteEntity->getDocumento();


        $clienteEntity->setId($id);

        return $this->clienteRepository->update($id, [
            'nome'=> $nome,
            'email'=> $email,
            'telefone'=> $telefone,
            'documento'=> $documento,
        ]);
    }

    public function removerCliente(string $id){
        $cliente = $this->clienteRepository->findById($id);
        return $cliente->delete();
    }
}