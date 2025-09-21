<?php

namespace App\Entity;

use App\Entity\Cliente;
use App\Entity\Restaurante;
use App\Entity\ItemPedido;

class Pedido
{
    private int $id;
    private Cliente $cliente;
    private Restaurante $restaurante;
    /**
     * @var ItemPedido[]
     */
    private array $itens;
    private string $status;
    private float $total;

    public function __construct(int $id, Cliente $cliente, Restaurante $restaurante)
    {
        $this->id = $id;
        $this->cliente = $cliente;
        $this->restaurante = $restaurante;
        $this->itens = [];
        $this->status = 'pendente';
        $this->total = 0.0;
    }

    public function adicionarItem(ItemPedido $itemPedido): void
    {
        $this->itens[] = $itemPedido;
        $this->calcularTotal();
        echo "Item \'" . $itemPedido->getProduto()->getNome() . "\' adicionado ao pedido #" . $this->id . ".\n";
    }

    public function removerItem(int $produtoId): void
    {
        foreach ($this->itens as $key => $itemPedido) {
            if ($itemPedido->getProduto()->getId() === $produtoId) {
                unset($this->itens[$key]);
                $this->calcularTotal();
                echo "Item \'" . $itemPedido->getProduto()->getNome() . "\' removido do pedido #" . $this->id . ".\n";
                return;
            }
        }
        echo "Produto com ID " . $produtoId . " não encontrado no pedido #" . $this->id . ".\n";
    }

    public function calcularTotal(): void
    {
        $this->total = 0;
        foreach ($this->itens as $itemPedido) {
            $this->total += $itemPedido->getSubtotal();
        }
    }

    public function atualizarStatus(string $novoStatus): void
    {
        $this->status = $novoStatus;
        echo "Status do pedido #" . $this->id . " atualizado para: " . $novoStatus . ".\n";
    }

    public function exibirDetalhesPedido(): void
    {
        echo "\n--- Detalhes do Pedido #" . $this->id . " ---\n";
        echo "Cliente: " . $this->cliente->getNome() . "\n";
        echo "Restaurante: " . $this->restaurante->getNome() . "\n";
        echo "Status: " . $this->status . "\n";
        echo "Itens:\n";
        foreach ($this->itens as $item) {
            echo "  - " . $item->getQuantidade() . "x " . $item->getProduto()->getNome() . " (" . $item->getProduto()->formatarPreco() . " cada) = R$ " . number_format($item->getSubtotal(), 2, ",", ".") . "\n";
        }
        echo "Total: R$ " . number_format($this->total, 2, ",", ".") . "\n";
        echo "----------------------------------\n";
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCliente(): Cliente
    {
        return $this->cliente;
    }

    public function getRestaurante(): Restaurante
    {
        return $this->restaurante;
    }

    public function getItens(): array
    {
        return $this->itens;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getTotal(): float
    {
        return $this->total;
    }
}
