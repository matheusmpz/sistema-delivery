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

    function exibirCardapio() {
        echo "Cardápio do restaurante: " . $this->nome . "<br>";
        foreach ($this->cardapio as $produto) {
            echo "- " . $produto->nome . " | R$ " . $produto->preco . "<br>";
        }
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