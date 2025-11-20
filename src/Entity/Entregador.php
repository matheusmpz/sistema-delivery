<?php

namespace App\Entity;
use App\Abstracts\Pessoa;
use App\Entity\Pedido;

class Entregador extends Pessoa
{
    private string $cnh;
    private string $veiculo;
    private bool $disponibilidade;
    private array $pedidosAtuais;

    public function __construct(int $id, string $nome, string $email, string $telefone, string $cnh, string $veiculo)
    {
        parent::__construct($id, $nome, $email, $telefone);
        $this->cnh = $cnh;
        $this->veiculo = $veiculo;
        $this->disponibilidade = true;
        $this->pedidosAtuais = [];
    }

    public function setCnh(string $cnh): void
    {
        $this->cnh = $cnh;
    }
    

    public function setVeiculo(string $veiculo): void
    {
        $this->veiculo = $veiculo;
    }

    public function setDisponibilidade(bool $disponibilidade): void
    {
        $this->disponibilidade = $disponibilidade;
    }
    
    public function exibirInformacoes(): void
    {
        echo "\n--- Informações do Entregador ---\n";
        echo "ID: " . $this->getId() . "\n";
        echo "Nome: " . $this->getNome() . "\n";
        echo "Email: " . $this->getEmail() . "\n";
        echo "Telefone: " . $this->getTelefone() . "\n";
        echo "CNH: " . $this->getCnh() . "\n";
        echo "Veiculo: " . $this->getVeiculo() . "\n";
        echo "Disponibilidade: " . ($this->getDisponibilidade() ? 'Disponível' : 'Ocupado') . "\n";
        echo "Pedidos Atuais (" . count($this->pedidosAtuais) . "):\n";
        
        foreach ($this->pedidosAtuais as $pedido) {
            echo "  - Pedido #" . $pedido->getId() . " (Restaurante: " . $pedido->getRestaurante()->getNome() . ")\n";
        }
        echo "------------------------------\n";
    }

    public function aceitarPedido(Pedido $pedido): void
    {
        if ($this->disponibilidade) {
            $this->pedidosAtuais[] = $pedido;
            $pedido->setEntregador($this);
            $pedido->atualizarStatus("Pedido a caminho"); 
            
            $this->disponibilidade = false; 
            
            echo "Entregador '{$this->getNome()}' aceitou o pedido #{$pedido->getId()}.\n";
        } else {
            echo "Entregador '{$this->getNome()}' não está disponível para novos pedidos.\n";
        }
    }

    public function finalizarEntrega(Pedido $pedido): void
    {
        $keyToRemove = null;
        foreach ($this->pedidosAtuais as $key => $pedidoAtual) {
            if ($pedidoAtual->getId() === $pedido->getId()) {
                $keyToRemove = $key;
                break;
            }
        }

        if ($keyToRemove !== null) {
            unset($this->pedidosAtuais[$keyToRemove]);
            
            $this->pedidosAtuais = array_values($this->pedidosAtuais);

            $pedido->atualizarStatus('Pedido entregue');
            
            if (empty($this->pedidosAtuais)) {
                $this->disponibilidade = true;
            }
            echo "Entregador '{$this->getNome()}' finalizou a entrega do pedido #{$pedido->getId()}. Status: Disponível.\n";
        } else {
            echo "ERRO: Pedido #{$pedido->getId()} não encontrado na lista atual do entregador '{$this->getNome()}'.\n";
        }
    }


    public function getCnh(): string
    {
        return $this->cnh;
    }

    public function getDisponibilidade(): bool
    {
        return $this->disponibilidade;
    }

    public function getVeiculo(): string
    {
        return $this->veiculo;
    }

    public function getPedidosAtuais(): array
    {
        return $this->pedidosAtuais;
    }
}