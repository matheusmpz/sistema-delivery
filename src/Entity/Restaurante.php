<?php

namespace App\Entity;
use App\Entity\Produto;

class Restaurante
{
    private int $id;
    private string $nome;
    private string $endereco;
    private string $telefone;
    private array $cardapio;

    public function __construct(int $id, string $nome, string $endereco, string $telefone)
    {
        $this->id = $id;
        $this->nome = $nome;
        $this->endereco = $endereco;
        $this->telefone = $telefone;
        $this->cardapio = [];
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

    public function getProdutoById(int $id): ?Produto
    {
        return $this->cardapio[$id] ?? null;
    }

    public function setNome(string $nome): void
    {
        $this->nome = $nome;
    }

    public function setEndereco(string $endereco): void
    {
        $this->endereco = $endereco;
    }

    public function setTelefone(string $telefone): void
    {
        $this->telefone = $telefone;
    }

    public function adicionarProduto(Produto $produto): void
    {
        $this->cardapio[$produto->getId()] = $produto;
        echo "Produto '{$produto->getNome()}' adicionado ao cardápio de {$this->nome}.\n";
    }

    public function removerProduto(int $id): void
    {
        if (isset($this->cardapio[$id])) {
            $nomeProduto = $this->cardapio[$id]->getNome();
            unset($this->cardapio[$id]);
            echo "Produto '{$nomeProduto}' removido do cardápio de {$this->nome}.\n";
        } else {
            echo "ERRO: Produto com ID #{$id} não encontrado no cardápio.\n";
        }
    }
    

    public function exibirCardapio(): void
    {
        echo "\n--- Cardápio: {$this->nome} ---\n";
        if (empty($this->cardapio)) {
            echo "O cardápio está vazio.\n";
            return;
        }

        foreach ($this->cardapio as $produto) {
            echo "ID: " . $produto->getId() . 
                 " | Nome: " . $produto->getNome() . 
                 " | Preço: R$" . number_format($produto->getPreco(), 2, ',', '.') . "\n";
        }
        echo "---------------------------\n";
    }
}