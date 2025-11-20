<?php

namespace App\Entity;

use App\Abstracts\Pessoa;
use App\Entity\Pedido;

class Cliente extends Pessoa
{
    private string $endereco;
    private array $historicoPedidos;

    public function __construct(int $id, string $nome, string $email, string $telefone, string $endereco)
    {
        parent::__construct($id, $nome, $email, $telefone);
        $this->endereco = $endereco;
        $this->historicoPedidos = [];
    }
    
    public function getEndereco(): string
    {
        return $this->endereco;
    }
    public function getHistoricoPedidos(): array
    {
        return $this->historicoPedidos;
    }

    public function setEndereco(string $endereco): void
    {
        $this->endereco = $endereco;
    }

    public function exibirInformacoes(): void
    {
        echo "\n--- Informações do Cliente ---\n";
        echo "ID: " . $this->getId() . "\n";
        echo "Nome: " . $this->getNome() . "\n";
        echo "Email: " . $this->getEmail() . "\n";
        echo "Telefone: " . $this->getTelefone() . "\n";
        echo "Endereço: " . $this->endereco . "\n";
        echo "------------------------------\n";
    }

    public function fazerPedido(Pedido $pedido): string
    {
        $this->historicoPedidos[] = $pedido;
        return "Pedido registrado";
    }

    public function verHistoricoPedidos(): void
    {
        if (empty($this->historicoPedidos)) {
            echo "Não há pedidos no histórico\n";
            return;
        }
        echo "\n--- Histórico de Pedidos de " . $this->getNome() . " ---\n";
        foreach ($this->historicoPedidos as $pedido) {
            $pedido->exibirDetalhesPedido();
        }
    }
}