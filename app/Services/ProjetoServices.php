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
        $projetoEntity = new ProjetoEntity(
            $data['nome'], 
            $data['cliente_id'], 
            $data['endereco_id'], 
            $data['instalacao_id']);

        $equipamentosData = $data['equipamentos'] ?? [];

        return $this->projetoRepository->create($projetoEntity, $equipamentosData);
    }

    public function buscaProjeto(array $data){
        if(isset($data['id'])){
            return $this->projetoRepository->find(['id' => $data['id']]);
        }

        return $this->projetoRepository->find($data);
    }

    public function editaProjeto(array $data, string $id){
        $projeto = $this->projetoRepository->findById($id);
        
        $projetoEntity = new ProjetoEntity(
            $data['nome'] ?? $projeto->nome,
            $data['cliente_id'] ?? $projeto->cliente_id,
            $data['endereco_id'] ?? $projeto->endereco_id,
            $data['instalacao_id'] ?? $projeto->instalacao_id
        );

        $projetoEntity->setId($id);

        $equipamentosData = $data['equipamentos'] ?? null;

        return $this->projetoRepository->update($projetoEntity,$equipamentosData);
    }

    public function removerProjeto(string $id){
        return $this->projetoRepository->delete($id);
    }
}