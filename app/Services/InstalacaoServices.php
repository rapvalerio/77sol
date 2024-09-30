<?php
namespace App\Services;
use App\Entities\InstalacaoEntity;
use App\Models\Instalacao;
use App\Repositories\InstalacaoRepository;

class InstalacaoServices {

    protected $instalacaoRepository;

    public function __construct(InstalacaoRepository $instalacaoRepository)
    {
        $this->instalacaoRepository = $instalacaoRepository;
    }

    public function criaInstalacao(array $data){
        $instalacaoEntity = new InstalacaoEntity($data['descricao']);
        return $this->instalacaoRepository->create($instalacaoEntity->toArray());
    }

    public function buscaInstalacao(string $id){
        return $this->instalacaoRepository->findById($id);
    }

    public function editaInstalacao(array $data, string $id){
        $instalacaoEntity = new InstalacaoEntity($data['descricao']);
        $instalacaoEntity->setId($id);
        return $this->instalacaoRepository->update($id, $instalacaoEntity->toArray());
    }

    public function removerInstalacao(string $id){
        $instalacao = $this->instalacaoRepository->findById($id);
    
        if (!$instalacao) {
            throw new \Exception('Instalação não encontrada.');
        }

        return $this->instalacaoRepository->delete($id);
    }
}