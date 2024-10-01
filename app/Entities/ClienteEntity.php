<?php

namespace App\Entities;

class ClienteEntity {
    private $id;
    private $nome;
    private $email;
    private $telefone;
    private $documento;

    public function __construct($nome, $email, $telefone, $documento) {
        $this->nome = $nome;
        $this->email = $email;
        $this->telefone = $telefone;
        $this->documento = $documento;
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

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getTelefone() {
        return $this->telefone;
    }

    public function setTelefone($telefone) {
        $this->telefone = $telefone;
    }

    public function getDocumento() {
        return $this->documento;
    }

    public function setDocumento($documento) {
        $this->documento = $documento;
    }

    public function toArray() {
        return [
            "id"=> $this->getId(),
            "nome"=> $this->getNome(),
            "email"=> $this->getEmail(),
            "telefone"=> $this->getTelefone(),
            "documento"=> $this->getDocumento(),
        ];
    }

}