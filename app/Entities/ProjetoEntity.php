<?php

namespace App\Entities;

class ProjetoEntity {
    private $id;
    private $nome;
    private $cliente_id;
    private $endereco_id;
    private $instalacao_id;

    public function __construct($nome, $cliente_id, $endereco_id, $instalacao_id) {
        $this->nome = $nome;
        $this->cliente_id = $cliente_id;
        $this->endereco_id = $endereco_id;
        $this->instalacao_id = $instalacao_id;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function getClienteId() {
        return $this->cliente_id;
    }

    public function setClienteId($cliente_id) {
        $this->cliente_id = $cliente_id;
    }

    public function getEnderecoId() {
        return $this->endereco_id;
    }

    public function setEnderecoId($endereco_id) {
        $this->endereco_id = $endereco_id;
    }

    public function getInstalacaoId() {
        return $this->instalacao_id;
    }

    public function setInstalacaoId($instalacao_id) {
        $this->instalacao_id = $instalacao_id;
    }

    public function toArray() {
        return [
            "id"=> $this->getId(),
            "nome"=> $this->getNome(),
            "cliente_id"=> $this->getClienteId(),
            "endereco_id"=> $this->getEnderecoId(),
            "instalacao_id"=> $this->getInstalacaoId(),
        ];
    }

}