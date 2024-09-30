<?php
namespace App\Services;
use App\Entities\EquipamentoEntity;
use App\Models\Equipamento;
use App\Repositories\EquipamentoRepository;

class EquipamentoServices {

    protected $equipamentoRepository;

    public function __construct(EquipamentoRepository $equipamentoRepository)
    {
        $this->equipamentoRepository = $equipamentoRepository;
    }

    public function criaEquipamento(array $data){
        $equipamentoEntity = new EquipamentoEntity($data['descricao']);
        return $this->equipamentoRepository->create($equipamentoEntity->toArray());
    }

    public function buscaEquipamento(string $id = null){
        if($id == null){
            return $this->equipamentoRepository->findAll();
        }
        
        return $this->equipamentoRepository->findById($id);
    }

    public function editaEquipamento(array $data, string $id){
        $equipamentoEntity = new EquipamentoEntity($data['descricao']);
        $equipamentoEntity->setId($id);
        return $this->equipamentoRepository->update($id, $equipamentoEntity->toArray());
    }

    public function removerEquipamento(string $id){
        $instalacao = $this->equipamentoRepository->findById($id);
    
        if (!$instalacao) {
            throw new \Exception('Instalação não encontrada.');
        }

        return $this->equipamentoRepository->delete($id);
    }
}