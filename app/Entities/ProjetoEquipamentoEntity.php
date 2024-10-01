<?php

namespace App\Entities;

class ProjetoEquipamentoEntity {
    private $id;
    private $projeto_id;
    private $equipamento_id;
    private $quantidade;

    public function __construct($projeto_id, $equipamento_id, $quantidade) {
        $this->projeto_id = $projeto_id;
        $this->equipamento_id = $equipamento_id;
        $this->quantidade = $quantidade;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getProjetoId() {
        return $this->projeto_id;
    }

    public function getEquipamentoId() {
        return $this->equipamento_id;
    }

    public function getQuantidade() {
        return $this->quantidade;
    }

    // Setters
    public function setId($id) {
        $this->id = $id;
    }

    public function setProjetoId($projeto_id) {
        $this->projeto_id = $projeto_id;
    }

    public function setEquipamentoId($equipamento_id) {
        $this->equipamento_id = $equipamento_id;
    }

    public function setQuantidade($quantidade) {
        $this->quantidade = $quantidade;
    }

    public function toArray() {
        return [
            'id' => $this->getId(),
            'projeto_id' => $this->getProjetoId(),
            'equipamento_id' => $this->getEquipamentoId(),
            'quantidade' => $this->getQuantidade(),
        ];
    }
}
