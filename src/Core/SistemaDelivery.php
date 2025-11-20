<?php

namespace App\Core;

use App\Entity\Cliente;
use App\Entity\Entregador;
use App\Entity\Restaurante;
use App\Entity\Produto;
use App\Entity\Pedido;
use App\Entity\ItemPedido;
use App\Core\Relatorio;
use App\Util\ConsoleInput;

class SistemaDelivery
{
    private array $clientes;
    private array $restaurantes;
    private array $entregadores;
    private array $pedidos;

    private int $nextClienteId = 1;
    private int $nextRestauranteId = 1;
    private int $nextEntregadorId = 1;
    private int $nextProdutoId = 1;
    private int $nextPedidoId = 1;

    public function __construct()
    {
        $this->clientes = [];
        $this->restaurantes = [];
        $this->entregadores = [];
        $this->pedidos = [];
    }

    public function iniciar(): void
    {
        echo "Bem-vindo ao Sistema de Delivery!\n";
        $this->menuPrincipal();
    }

    private function buscarClienteInterativo(): ?Cliente
    {
        if (empty($this->clientes)) {
            echo "Nenhum cliente cadastrado.\n";
            return null;
        }
        $this->listarClientes();
        while (true) {
            $id = ConsoleInput::lerInputInt("Digite o ID do cliente (ou 0 para cancelar): ");
            
            if ($id === 0) return null;
            
            $cliente = $this->findClienteById($id);
            if ($cliente) return $cliente;
            
            echo "Cliente não encontrado. Tente novamente.\n";
        }
    }

    private function buscarRestauranteInterativo(): ?Restaurante
    {
        if (empty($this->restaurantes)) {
            echo "Nenhum restaurante cadastrado.\n";
            return null;
        }
        $this->listarRestaurantes();
        while (true) {
            $id = ConsoleInput::lerInputInt("Digite o ID do restaurante (ou 0 para cancelar): ");
            if ($id === 0) return null;

            $restaurante = $this->findRestauranteById($id);
            if ($restaurante) return $restaurante;

            echo "Restaurante não encontrado. Tente novamente.\n";
        }
    }

    private function buscarPedidoInterativo(): ?Pedido
    {
        if (empty($this->pedidos)) {
            echo "Nenhum pedido cadastrado.\n";
            return null;
        }
        $this->listarPedidos();
        while (true) {
            $id = ConsoleInput::lerInputInt("Digite o ID do pedido (ou 0 para cancelar): ");
            if ($id === 0) return null;

            $pedido = $this->findPedidoById($id);
            if ($pedido) return $pedido;

            echo "Pedido não encontrado. Tente novamente.\n";
        }
    }

    private function buscarEntregadorInterativo(): ?Entregador
    {
        if (empty($this->entregadores)) {
            echo "Nenhum entregador cadastrado.\n";
            return null;
        }
        $this->listarEntregadores();
        while (true) {
            $id = ConsoleInput::lerInputInt("Digite o ID do entregador (ou 0 para cancelar): ");
            if ($id === 0) return null;

            $entregador = $this->findEntregadorById($id);
            if ($entregador) return $entregador;

            echo "Entregador não encontrado. Tente novamente.\n";
        }
    }

    public function menuPrincipal(): void
    {
        while (true) {
            echo "\n--- Menu Principal ---\n";
            echo "1. Cadastrar Cliente\n";
            echo "2. Cadastrar Restaurante\n";
            echo "3. Cadastrar Entregador\n";
            echo "4. Adicionar Produto ao Cardápio de um Restaurante\n";
            echo "5. Fazer Pedido\n";
            echo "6. Listar Clientes\n";
            echo "7. Listar Restaurantes\n";
            echo "8. Listar Entregadores\n";
            echo "9. Listar Pedidos\n";
            echo "10. Atribuir Entregador a um Pedido\n";
            echo "11. Finalizar Entrega do Pedido\n";
            echo "12. Relatório de Restaurantes\n";
            echo "13. Relatório de Entregadores\n";
            echo "0. Sair\n";
            $opcao = ConsoleInput::lerInputInt("Escolha uma opção: ");

            switch ($opcao) {
                case 1:
                    $this->cadastrarCliente();
                    break;
                case 2:
                    $this->cadastrarRestaurante();
                    break;
                case 3:
                    $this->cadastrarEntregador();
                    break;
                case 4:
                    $this->adicionarProdutoAoRestaurante();
                    break;
                case 5:
                    $this->fazerPedidoCLI();
                    break;
                case 6:
                    $this->listarClientes();
                    break;
                case 7:
                    $this->listarRestaurantes();
                    break;
                case 8:
                    $this->listarEntregadores();
                    break;
                case 9:
                    $this->listarPedidos();
                    break;
                case 10:
                    $this->atribuirEntregadorAoPedido();
                    break;
                case 11:
                    $this->finalizarEntrega();
                    break;
                case 12:
                    $this->relatorioRestaurantes();
                    break;
                case 13:
                    $this->relatorioEntregadores();
                    break;
                case 0:
                    echo "Saindo do sistema. Até mais!\n";
                    return;
                default:
                    echo "Opção inválida. Tente novamente.\n";
            }
        }
    }

    private function cadastrarCliente(): void
    {
        echo "\n--- Cadastro de Cliente ---\n";
        $nome = ucwords(strtolower(ConsoleInput::lerInputTexto("Nome do Cliente: "))); 
        $email = ConsoleInput::lerInputEmail("Email do Cliente: ");
        $telefone = ConsoleInput::lerInputTelefone("Telefone do Cliente: ");
        $endereco = ConsoleInput::lerInputTexto("Endereço do Cliente: ");

        $cliente = new Cliente($this->nextClienteId++, $nome, $email, $telefone, $endereco);
        $this->clientes[] = $cliente;
        echo "Cliente '" . $cliente->getNome() . "' cadastrado com sucesso! ID: " . $cliente->getId() . "\n";
    }

    private function cadastrarRestaurante(): void
    {
        echo "\n--- Cadastro de Restaurante ---\n";
        $nome = ucwords(strtolower(ConsoleInput::lerInputTexto("Nome do Restaurante: ")));
        $endereco = ConsoleInput::lerInputTexto("Endereço do Restaurante: ");
        $telefone = ConsoleInput::lerInputTelefone("Telefone do Restaurante: ");

        $restaurante = new Restaurante($this->nextRestauranteId++, $nome, $endereco, $telefone);
        $this->restaurantes[] = $restaurante;
        echo "Restaurante '" . $restaurante->getNome() . "' cadastrado com sucesso! ID: " . $restaurante->getId() . "\n";
    }

    private function cadastrarEntregador(): void
    {
        echo "\n--- Cadastro de Entregador ---\n";
        $nome = ucwords(strtolower(ConsoleInput::lerInputTexto("Nome do Entregador: ")));
        $email = ConsoleInput::lerInputEmail("Email do Entregador: ");
        $telefone = ConsoleInput::lerInputTelefone("Telefone do Entregador: ");
        
        $cnh = ConsoleInput::lerInputCNH("CNH do Entregador (11 dígitos): ");
        $veiculo = ConsoleInput::lerInputVeiculo();

        $entregador = new Entregador($this->nextEntregadorId++, $nome, $email, $telefone, $cnh, $veiculo);
        $this->entregadores[] = $entregador;
        echo "Entregador '" . $entregador->getNome() . "' cadastrado com sucesso! ID: " . $entregador->getId() . "\n";
    }

    private function adicionarProdutoAoRestaurante(): void
    {
        echo "\n--- Adicionar Produto ao Restaurante ---\n";
        $restaurante = $this->buscarRestauranteInterativo();
        if (!$restaurante) return;

        $nome = ucwords(strtolower(ConsoleInput::lerInputTexto("Nome do Produto: ")));
        $descricao = ConsoleInput::lerInputTexto("Descrição do Produto: ");
        $preco = ConsoleInput::lerInputPrecoPositivo("Preço do Produto (R$): ");
        $categoria = ucwords(strtolower(ConsoleInput::lerInputTexto("Categoria do Produto: ")));

        $produto = new Produto($this->nextProdutoId++, $nome, $descricao, $preco, $categoria);
        $restaurante->adicionarProduto($produto);
        echo "Produto adicionado com sucesso!\n";
    }

    private function fazerPedidoCLI(): void
    {
        echo "\n--- Fazer Pedido ---\n";
        
        $cliente = $this->buscarClienteInterativo();
        if (!$cliente) return;

        $restaurante = $this->buscarRestauranteInterativo();
        if (!$restaurante) return;

        $novoPedido = new Pedido($this->nextPedidoId++, $cliente, $restaurante);

        while (true) {
            $restaurante->exibirCardapio();
            $produtoId = ConsoleInput::lerInputInt("Digite o ID do produto (0 para finalizar seleção): ");
            
            if ($produtoId === 0) {
                break;
            }

            $produto = $restaurante->getProdutoById($produtoId);
            
            if ($produto && $produto->isDisponivel()) {
                $quantidade = ConsoleInput::lerInputQuantidade("Quantidade para '" . $produto->getNome() . "': ");
                
                $itemPedido = new ItemPedido($produto, $quantidade);
                $novoPedido->adicionarItem($itemPedido);
                echo "Item adicionado!\n";
            } else {
                echo "Produto não encontrado ou indisponível. Tente outro ID.\n";
            }
        }

        if (empty($novoPedido->getItens())) {
            echo "Pedido vazio. Cancelando pedido.\n";
            return;
        }

        $novoPedido->calcularTotal();
        $this->pedidos[] = $novoPedido;
        $cliente->fazerPedido($novoPedido);
        echo "Pedido #" . $novoPedido->getId() . " criado com sucesso! Total: R$ " . number_format($novoPedido->getTotal(), 2, ',', '.') . "\n";
    }

    private function atribuirEntregadorAoPedido(): void
    {
        echo "\n--- Atribuir Entregador a Pedido ---\n";
        
        $pedido = $this->buscarPedidoInterativo();
        if (!$pedido) return;

        if ($pedido->getStatus() !== 'pendente') {
            echo "Pedido #" . $pedido->getId() . " já está processado (Status: " . $pedido->getStatus() . ").\n";
            return;
        }

        $entregador = $this->buscarEntregadorInterativo();
        if (!$entregador) return;

        if (!$entregador->getdisponibilidade()) {
            echo "Entregador " . $entregador->getNome() . " não está disponível no momento.\n";
            return;
        }

        $entregador->aceitarPedido($pedido);
        echo "Entregador " . $entregador->getNome() . " atribuído ao pedido #" . $pedido->getId() . ".\n";
    }

    private function finalizarEntrega(): void
    {
        echo "\n--- Finalizar Entrega ---\n";
        
        $pedido = $this->buscarPedidoInterativo();
        if (!$pedido) return;

        if ($pedido->getStatus() !== 'Pedido a caminho') {
            echo "O pedido #" . $pedido->getId() . " não está em entrega (Status atual: " . $pedido->getStatus() . ").\n";
            return;
        }

        $entregadorResponsavel = null;
        foreach ($this->entregadores as $entregador) {
            foreach ($entregador->getpedidosAtuais() as $pedidoAtual) {
                if ($pedidoAtual->getId() === $pedido->getId()) {
                    $entregadorResponsavel = $entregador;
                    break 2;
                }
            }
        }

        if (!$entregadorResponsavel) {
            echo "Nenhum entregador vinculado a este pedido foi encontrado.\n";
            return;
        }

        $entregadorResponsavel->finalizarEntrega($pedido);
        echo "Pedido #" . $pedido->getId() . " entregue com sucesso!\n";
    }

    private function listarClientes(): void
    {
        echo "\n--- Clientes Cadastrados ---\n";
        if (empty($this->clientes)) {
            echo "Nenhum cliente cadastrado.\n";
            return;
        }
        foreach ($this->clientes as $cliente) {
            $cliente->exibirInformacoes();
        }
    }

    private function listarRestaurantes(): void
    {
        echo "\n--- Restaurantes Cadastrados ---\n";
        if (empty($this->restaurantes)) {
            echo "Nenhum restaurante cadastrado.\n";
            return;
        }
        foreach ($this->restaurantes as $restaurante) {
            echo "ID: " . $restaurante->getId() . ", Nome: " . $restaurante->getNome() . ", Endereço: " . $restaurante->getEndereco() . "\n";
        }
    }

    private function listarEntregadores(): void
    {
        echo "\n--- Entregadores Cadastrados ---\n";
        if (empty($this->entregadores)) {
            echo "Nenhum entregador cadastrado.\n";
            return;
        }
        foreach ($this->entregadores as $entregador) {
            $entregador->exibirInformacoes();
        }
    }

    private function listarPedidos(): void
    {
        echo "\n--- Pedidos Realizados ---\n";
        if (empty($this->pedidos)) {
            echo "Nenhum pedido realizado.\n";
            return;
        }
        foreach ($this->pedidos as $pedido) {
            $pedido->exibirDetalhesPedido();
        }
    }

    private function relatorioRestaurantes(): void
    {
        echo "\n--- Relatório de Restaurantes ---\n";
        $relatorio = new Relatorio($this->pedidos);
        $resultado = $relatorio->gerarRelatorioRestaurante();

        if (empty($resultado)) {
            echo "Nenhum pedido foi registrado.\n";
            return;
        }

        foreach ($resultado as $rest => $dados) {
            echo "Restaurante: $rest\n";
            echo "Total de Pedidos: " . $dados['total_pedidos'] . "\n";
            echo "Total Arrecadado: R$ " . number_format($dados['total_arrecadado'], 2, ',', '.') . "\n\n";
        }
    }

    private function relatorioEntregadores(): void
    {
        echo "\n--- Relatório de Entregadores ---\n";
        $relatorio = new Relatorio($this->pedidos);
        $resultado = $relatorio->gerarRelatorioEntregadores();

        if (empty($resultado)) {
            echo "Nenhuma entrega finalizada ainda.\n";
            return;
        }

        foreach ($resultado as $nome => $dados) {
            echo "Entregador: $nome\n";
            echo "Total de Entregas: " . $dados['total_entregas'] . "\n";
            echo "Valor Recebido: R$ " . number_format($dados['valor_recebido'], 2, ',', '.') . "\n\n";
        }
    }

    private function findClienteById(int $id): ?Cliente
    {
        foreach ($this->clientes as $cliente) {
            if ($cliente->getId() === $id) {
                return $cliente;
            }
        }
        return null;
    }

    private function findRestauranteById(int $id): ?Restaurante
    {
        foreach ($this->restaurantes as $restaurante) {
            if ($restaurante->getId() === $id) {
                return $restaurante;
            }
        }
        return null;
    }

    private function findEntregadorById(int $id): ?Entregador
    {
        foreach ($this->entregadores as $entregador) {
            if ($entregador->getId() === $id) {
                return $entregador;
            }
        }
        return null;
    }

    private function findPedidoById(int $id): ?Pedido
    {
        foreach ($this->pedidos as $pedido) {
            if ($pedido->getId() === $id) {
                return $pedido;
            }
        }
        return null;
    }
}