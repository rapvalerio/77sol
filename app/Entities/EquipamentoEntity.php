<?php

namespace App\Entities;

class EquipamentoEntity {
    public $id;
    public $descricao;

    public function __construct($descricao) {
        $this->descricao = $descricao;
    }

    public function getId() {
        return $this->id;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function setId(int $id) {
        $this->id = $id;
    }

    public function setDescricao(string $descricao) {
        $this->descricao = $descricao;
    }

    public function toArray() {
        return [
            "id"=> $this->id,
            "descricao" => $this->descricao,
        ];
    }
}