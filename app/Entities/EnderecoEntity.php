<?php

namespace App\Entities;

class EnderecoEntity {
    private $id;
    private $uf;

    public function __construct($uf) {
        $this->uf = $uf;
    }

    public function getId() {
        return $this->id;
    }

    public function getUf() {
        return $this->uf;
    }

    public function setId(int $id) {
        $this->id = $id;
    }

    public function setUf(string $uf) {
        $this->uf = $uf;
    }

    public function toArray() {
        return [
            "id"=> $this->id,
            "uf" => $this->uf,
        ];
    }
}