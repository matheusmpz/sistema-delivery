<?php

namespace App\Core;

use App\Entity\Pedido;


class Relatorio
{
   private array $pedidos;

   public function __construct(array $pedidos)
   {
      $this->pedidos = $pedidos;
   }

   public function gerarRelatorioRestaurante():array
   {
      $resultado = [];
      foreach($this->pedidos as $pedido)
      {
         $restaurante = $pedido->getRestaurante()->getNome();
         $valor = $pedido->getTotal();
         if(!isset($resultado[$restaurante]))
         {
            $resultado[$restaurante] = [
                    'total_pedidos' => 0,
                    'total_arrecadado' => 0.0
            ];
         }
         $resultado[$restaurante] ['total_pedidos'] ++;
         $resultado[$restaurante] ['total_arrecadado'] += $valor;
      } 
      return $resultado;
   }

   public function gerarRelatorioEntregadores(): array
    {
        $resultado = [];
        foreach ($this->pedidos as $pedido) 
      {
         $entregador = $pedido->getEntregador();
         if (!$entregador || $pedido->getStatus() !== 'Pedido entregue') 
         {
           continue;
         }
         $nome = $entregador->getNome();

         if (!isset($resultado[$nome])) 
           { 
             $resultado[$nome] = [
                    'total_entregas' => 0,
                    'valor_recebido' => 0.0
              ];
            }
            $resultado[$nome]['total_entregas']++;
            $resultado[$nome]['valor_recebido'] = $resultado[$nome]['total_entregas'] * 7;
        }
        return $resultado;
    }
}