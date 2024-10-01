<?php
namespace App\Services;
use App\Entities\EquipamentoEntity;
use App\Models\Equipamento;
use App\Repositories\EquipamentoRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
        $equipamento = $this->equipamentoRepository->findById($id);

        if(!$equipamento){
            throw new ModelNotFoundException();
        }

        $equipamentoEntity = new EquipamentoEntity($equipamento['descricao']);

        $descricao = isset($data['descricao'])?$data['descricao']:$equipamentoEntity->getDescricao();

        $equipamentoEntity->setId($id);
        return $this->equipamentoRepository->update($id, [
            'descricao'=> $descricao
        ]);
    }

    public function removerEquipamento(string $id){
        $instalacao = $this->equipamentoRepository->findById($id);
    
        if (!$instalacao) {
            throw new \Exception('Instalação não encontrada.');
        }

        return $this->equipamentoRepository->delete($id);
    }
}