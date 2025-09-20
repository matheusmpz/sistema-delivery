<?php

namespace App\Entity;

use App\Abstracts\Item;

class Produto extends Item
{
    private string $categoria;
    private bool $disponivel;

    public function __construct(int $id, string $nome, string $descricao, float $preco, string $categoria)
    {
        parent::__construct($id, $nome, $descricao, $preco);
        $this->categoria = $categoria;
        $this->disponivel = true; 
    }

    public function exibirDetalhes(): void
    {
        echo "\n--- Detalhes do Produto ---\n";
        echo "ID: " . $this->getId() . "\n";
        echo "Nome: " . $this->getNome() . "\n";
        echo "Descrição: " . $this->getDescricao() . "\n";
        echo "Preço: " . $this->formatarPreco() . "\n";
        echo "Categoria: " . $this->categoria . "\n";
        echo "Disponibilidade: " . ($this->disponivel ? 'Disponível' : 'Indisponível') . "\n";
        echo "------------------------------\n";
    }

    public function alterarDisponibilidade(bool $status): void
    {
        $this->disponivel = $status;
        echo "Disponibilidade do produto '" . $this->getNome() . "' alterada para " . ($status ? 'Disponível' : 'Indisponível') . ".\n";
    }

    public function getCategoria(): string
    {
        return $this->categoria;
    }

    public function setCategoria(string $categoria): void
    {
        $this->categoria = $categoria;
    }

    public function isDisponivel(): bool
    {
        return $this->disponivel;
    }
}