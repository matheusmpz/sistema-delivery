<?php

namespace App\Entity;

use App\Entity\Produto;

class ItemPedido
{
    private Produto $produto;
    private int $quantidade;
    private float $subtotal;

    public function __construct(Produto $produto, int $quantidade)
    {
        $this->produto = $produto;
        $this->quantidade = $quantidade;
        $this->calcularSubtotal();
    }

    private function calcularSubtotal(): void
    {
        $this->subtotal = $this->produto->getPreco() * $this->quantidade;
    }

    public function getProduto(): Produto
    {
        return $this->produto;
    }

    public function getQuantidade(): int
    {
        return $this->quantidade;
    }

    public function getSubtotal(): float
    {
        return $this->subtotal;
    }

    public function setQuantidade(int $quantidade): void
    {
        $this->quantidade = $quantidade;
        $this->calcularSubtotal();
    }
}
