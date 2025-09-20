<?php

namespace App\Entity;
use App\Abstract\Pessoa;
use App\Entity\Pedido;

Class Entregador extends Pessoa
{
    private string $cnh;
    private string $veiculo;
    public bool $disponibilidade;
    protected array $pedidosAtuais;

    public function __construct(string $cnh, string $veiculo,string $telefone,int $id, string $nome, string $email)
    {
        parent::__construct($id, $nome, $email, $telefone);
        $this->cnh = $cnh;
        $this->veiculo = $veiculo;
        $this->disponibilidade = true;
        $this->pedidosAtuais = [];
    }

    public function exibirInformacoes(): void
    {
        echo "\n--- Informações do Entregador ---\n";
        echo "CNH: " . $this->getcnh() . "\n";
        echo "Veiculo: " . $this->getVeiculo() . "\n";
        echo "Disponibilidade: " . $this->getdisponibilidade() . "\n";
        echo "Pedidos Atuais: " . $this->getpedidosAtuais() . "\n";

        echo "------------------------------\n";
    }

    public function aceitarPedido(Pedido $pedido): void
    {
        if ($this->disponibilidade){
            $this->pedidosAtuais[] = $pedido; 
            $pedido->atualizarStatus("Pedido a caminho");
            $this->disponibilidade = false; 
            echo "Entregador aceitou o pedido";
        }
        else{
            echo "Entregador não esta disponivel";
        }
    }

    public function finalizarEntrega(Pedido $pedido): void
    {
        $key = array_search($pedido, $this->pedidosAtuais);
        if ($key !== false) {
            unset($this->pedidosAtuais[$key]);
            $pedido->atualizarStatus('Pedido entregue');
            if (empty($this->pedidosAtuais)) {
                $this->disponibilidade = true; 
            }
            echo "Entregador Finalização";
        } else {
            echo "Pedido não encontrado na lista";
        }
    }

    public function getcnh(): string
    {
        return $this->cnh;
    }

    public function getVeiculo(): string{
        return $this->veiculo;
    }

    public function setVeiculo(string $veiculo): void {
        $this->veiculo = $veiculo;
    }

    public function getdisponibilidade(): string
    {
        return $this->disponibilidade;
    }

    public function setdisponibilidade(bool $disponibilidade):void
    {
        $this->disponibilidade = $disponibilidade;    
    }

    public function getpedidosAtuais(): array
    {
        return $this->pedidosAtuais;
    }

    public function setpedidosAtuais(): array
    {
        return $this->pedidosAtuais;
    }
}