<?php
  namespace App\Entity;

  use App\Abstract\Pessoa;
  use App\Entity\Pedido;

  Class Cliente extends Pessoa
  {
    private string $endereco;
    private array $historicoPedidos;

     public function __construct(int $id, string $nome, string $email, string $telefone, string $endereco)
     {
        parent::__construct($id, $nome, $email, $telefone);
        $this->endereco = $endereco;
        $this->historicoPedidos = [];
     }
    public function exibirInformacoes():void
    {
        echo "\n--- Informações do Cliente ---\n";
        echo "ID: " . $this->getId() . "\n";
        echo "Nome: " . $this->getNome() . "\n";
        echo "Email: " . $this->getEmail() . "\n";
        echo "Telefone: " . $this->getTelefone() . "\n";
        echo "Endereço: " . $this->endereco . "\n";
        echo "------------------------------\n";
        
    }

    public function fazerPedido($pedido):string
    {
        $this->historicoPedidos[] = $pedido;
        return "Pedido registrado";
    }

    public function verHistoricoPedidos():void
    {
        if (empty($this->historicoPedidos)) {
            echo "Não ha pedidos no historico";
            return;
        }
        foreach ($this->historicoPedidos as $pedido) {
            $pedido->exibirDetalhesPedido();
        }
    }

    public function getEndereco():string
    {
        return $this->endereco;
    }
    public function gethistoricoPedidos():array
    {
        return $this->historicoPedidos;
    }
}