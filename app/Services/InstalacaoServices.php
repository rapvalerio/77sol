<?php
namespace App\Services;
use App\Entities\InstalacaoEntity;
use App\Models\Instalacao;
use App\Repositories\InstalacaoRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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

    public function buscaInstalacao(string $id = null){
        if($id == null){
            return $this->instalacaoRepository->findAll();
        }

        return $this->instalacaoRepository->findById($id);
    }

    public function editaInstalacao(array $data, string $id){
        $instalacao = $this->instalacaoRepository->findById($id);

        $instalacaoEntity = new InstalacaoEntity($instalacao['descricao']);

        $descricao = isset($data['descricao'])?$data['descricao']:$instalacaoEntity->getDescricao();

        $instalacaoEntity->setId($id);
        return $this->instalacaoRepository->update($id, [
            'descricao'=> $descricao,
        ]);
    }

    public function removerInstalacao(string $id){
        $instalacao = $this->instalacaoRepository->findById($id);
    
        if (!$instalacao) {
            throw new \Exception('Instalação não encontrada.');
        }

        return $this->instalacaoRepository->delete($id);
    }
}