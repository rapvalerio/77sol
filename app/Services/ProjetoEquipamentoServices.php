<?php
namespace App\Services;
use App\Entities\ProjetoEquipamentoEntity;
use App\Repositories\ProjetoEquipamentoRepository;

class ProjetoEquipamentoServices {

    protected $projetoEquipamentoRepository;

    public function __construct(ProjetoEquipamentoRepository $projetoEquipamentoRepository)
    {
        $this->projetoEquipamentoRepository = $projetoEquipamentoRepository;
    }

    public function criar(array $data){
        $projetoEquipamentoEntity = new ProjetoEquipamentoEntity($data['projeto_id'], $data['equipamento_id'], $data['quantidade']);

        return $this->projetoEquipamentoRepository->create($projetoEquipamentoEntity->toArray());
    }

    public function buscar(string $id = null){
        if($id == null){
            return $this->projetoEquipamentoRepository->findAll();
        }

        $projetoEquipamento = $this->projetoEquipamentoRepository->findById($id);

        if (!$projetoEquipamento) {
            throw new \Exception('Equipamento do projeto não encontrados.');
        }

        return $projetoEquipamento;
    }

    public function editar(array $data, string $id){
        $projetoEquipamento = $this->projetoEquipamentoRepository->findById($id);
        
        if (!$projetoEquipamento) {
            throw new \Exception('Equipamento do projeto não encontrados.');
        }

        $projetoEquipamentoEntity = new ProjetoEquipamentoEntity($projetoEquipamento['projeto_id'], $projetoEquipamento['equipamento_id'], $projetoEquipamento['quantidade']);

        $projetoId = isset($data['projeto_id'])?$data['projeto_id']:$projetoEquipamentoEntity->getProjetoId();
        $equipamentoId = isset($data['equipamento_id'])?$data['equipamento_id']:$projetoEquipamentoEntity->getEquipamentoId();
        $quantidade = isset($data['quantidade'])?$data['quantidade']:$projetoEquipamentoEntity->getQuantidade();

        $projetoEquipamentoEntity->setId($id);

        return $this->projetoEquipamentoRepository->update($id, [
            'projeto_id' => $projetoId,
            'equipamento_id' => $equipamentoId,
            'quantidade' => $quantidade,
        ]);
    }

    public function remover(string $id){
        $projetoEquipamento = $this->projetoEquipamentoRepository->findById($id);
    
        if (!$projetoEquipamento) {
            throw new \Exception('Equipamento do projeto não encontrados.');
        }

        return $this->projetoEquipamentoRepository->delete($id);
    }
}