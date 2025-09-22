<?php

namespace App\Entity;
use App\Entity\Produto;

class Restaurante {
    private int $id;
    private string $nome;
    private string $endereco;
    private string $telefone;
    private array $cardapio; 

    public function __construct(int $id, string $nome, string $endereco, string $telefone){
        $this->id = $id;
        $this->nome = $nome;
        $this->endereco = $endereco;
        $this->telefone = $telefone;
        $this->cardapio = [];
    }

    function adicionarProduto(Produto $produto) {
        $this->cardapio[] = $produto;
    }

    function removerProduto(int $produtoId): void  {
        foreach($this->cardapio as $produto){
            if($produto->getId() == $produtoId ){
                unset($this->cardapio[$produto]);
                echo "Produto '" . $produto->getNome() . "' removido do cardápio do restaurante '" . $this->nome . "'.\n";
                return;
            
            }
        }
        echo "Produto não encontrado!";
    }     

    public function exibirCardapio(): void
    {
        echo "\n--- Cardápio do Restaurante: " . $this->getNome() . " ---\n";
        foreach ($this->cardapio as $produto) {
            echo "ID: " . $produto->getId() . " | " . $produto->getNome() . " | R$ " . $produto->getPreco() . "\n";
        }
        echo "-----------------------------------------\n";
    }

    public function getProdutoById(int $produtoId): ?Produto
    {
        foreach ($this->cardapio as $produto) {
            if ($produto->getId() === $produtoId) {
                return $produto;
            }
        }
        return null;
    }
    
    public function getId(): int
    {
        return $this->id;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function getEndereco(): string
    {
        return $this->endereco;
    }

    public function getTelefone(): string
    {
        return $this->telefone;
    }

    public function getCardapio(): array
    {
        return $this->cardapio;
    }
}