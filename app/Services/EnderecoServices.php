<?php
namespace App\Services;
use App\Entities\EnderecoEntity;
use App\Models\Endereco;
use App\Repositories\EnderecoRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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

    public function buscaEndereco(string $id = null){
        if($id == null){
            return $this->enderecoRepository->findAll();
        }
        return $this->enderecoRepository->findById($id);
    }

    public function editaEndereco(array $data, string $id){
        $endereco = $this->enderecoRepository->findById($id);

        if(!$endereco){
            throw new ModelNotFoundException();
        }

        $enderecoEntity = new EnderecoEntity($endereco['uf']);

        $uf = isset($data['uf'])?$data['uf']:$enderecoEntity->getUf();

        $enderecoEntity->setId($id);

        return $this->enderecoRepository->update($id, [
            'uf'=> $uf
        ]);
    }

    public function removerEndereco(string $id){
        $instalacao = $this->enderecoRepository->findById($id);
    
        if (!$instalacao) {
            throw new \Exception('Endereço não encontrado.');
        }

        return $this->enderecoRepository->delete($id);
    }
}