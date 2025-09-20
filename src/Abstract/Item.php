<?php

namespace App\Abstracts;

abstract class Item
{
    protected int $id;
    protected string $nome;
    protected string $descricao;
    protected float $preco;

    public function __construct(int $id, string $nome, string $descricao, float $preco)
    {
        $this->id = $id;
        $this->nome = $nome;
        $this->descricao = $descricao;
        $this->preco = $preco;
    }

    abstract public function exibirDetalhes(): void;

    protected function formatarPreco(): string
    {
        return "R$ " . number_format($this->preco, 2, ",", ".");
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function getDescricao(): string
    {
        return $this->descricao;
    }

    public function getPreco(): float
    {
        return $this->preco;
    }
}
