<?php
namespace App\Services;
use App\Entities\ProjetoEntity;
use App\Repositories\ProjetoRepository;

class ProjetoServices {

    protected $projetoRepository;

    public function __construct(ProjetoRepository $projetoRepository)
    {
        $this->projetoRepository = $projetoRepository;
    }

    public function criaProjeto(array $data){
        $projetoEntity = new ProjetoEntity($data['nome'], $data['cliente_id'], $data['endereco_id'], $data['instalacao_id']);

        return $this->projetoRepository->create($projetoEntity->toArray());
    }

    public function buscaProjeto(array $data){
        if(isset($data['id'])){
            return $this->projetoRepository->find(['id' => $data['id']]);
        }

        return $this->projetoRepository->find($data);
    }

    public function editaProjeto(array $data, string $id){
        $projeto = $this->projetoRepository->findById($id);
        $projetoEntity = new ProjetoEntity($projeto['nome'], $projeto['cliente_id'], $projeto['endereco_id'], $projeto['instalacao_id']);

        $nome = isset($data['nome'])?$data['nome']:$projetoEntity->getNome();
        $clienteId = isset($data['cliente_id'])?$data['cliente_id']:$projetoEntity->getClienteId();
        $enderecoId = isset($data['endereco_id'])?$data['endereco_id']:$projetoEntity->getEnderecoId();
        $instalacaoId = isset($data['instalacao_id'])?$data['instalacao_id']:$projetoEntity->getInstalacaoId();

        $projetoEntity->setId($id);

        return $this->projetoRepository->update($id, [
            'nome' => $nome,
            'cliente_id' => $clienteId,
            'endereco_id' => $enderecoId,
            'instalacao_id' => $instalacaoId
        ]);
    }

    public function removerProjeto(string $id){
        $this->projetoRepository->findById($id);

        return $this->projetoRepository->delete($id);
    }
}