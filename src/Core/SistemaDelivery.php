<?php

namespace App\Core;

use App\Entity\Cliente;
use App\Entity\Entregador;
use App\Entity\Restaurante;
use App\Entity\Produto;
use App\Entity\Pedido;
use App\Entity\ItemPedido;
use App\Core\Relatorio;

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

    private function lerInput(string $prompt): string
    {
        echo $prompt;
        $input = trim(readline());
        return $input;
    }

    private function lerInputInt(string $prompt): int
    {
        while (true) {
            $input = $this->lerInput($prompt);
            if (is_numeric($input) && (int)$input == $input) {
                return (int)$input;
            } else {
                echo "Entrada inválida. Por favor, digite um número inteiro.\n";
            }
        }
    }

    private function lerInputFloat(string $prompt): float
    {
        while (true) {
            $input = $this->lerInput($prompt);
            if (is_numeric($input)) {
                return (float)$input;
            } else {
                echo "Entrada inválida. Por favor, digite um número decimal.\n";
            }
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
            $opcao = $this->lerInputInt("Escolha uma opção: ");

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
        $nome = $this->lerInput("Nome do Cliente: ");
        $email = $this->lerInput("Email do Cliente: ");
        $telefone = $this->lerInput("Telefone do Cliente: ");
        $endereco = $this->lerInput("Endereço do Cliente: ");

        $cliente = new Cliente($this->nextClienteId++, $nome, $email, $telefone, $endereco);
        $this->clientes[] = $cliente;
        echo "Cliente '" . $cliente->getNome() . "' cadastrado com sucesso! ID: " . $cliente->getId() . "\n";
    }

    private function cadastrarRestaurante(): void
    {
        echo "\n--- Cadastro de Restaurante ---\n";
        $nome = $this->lerInput("Nome do Restaurante: ");
        $endereco = $this->lerInput("Endereço do Restaurante: ");
        $telefone = $this->lerInput("Telefone do Restaurante: ");

        $restaurante = new Restaurante($this->nextRestauranteId++, $nome, $endereco, $telefone);
        $this->restaurantes[] = $restaurante;
        echo "Restaurante '" . $restaurante->getNome() . "' cadastrado com sucesso! ID: " . $restaurante->getId() . "\n";
    }

    private function cadastrarEntregador(): void
    {
        echo "\n--- Cadastro de Entregador ---\n";
        $nome = $this->lerInput("Nome do Entregador: ");
        $email = $this->lerInput("Email do Entregador: ");
        $telefone = $this->lerInput("Telefone do Entregador: ");
        $cnh = $this->lerInput("CNH do Entregador: ");
        $veiculo = $this->lerInput("Veículo do Entregador: ");

        $entregador = new Entregador($this->nextEntregadorId++, $nome, $email, $telefone, $cnh, $veiculo);
        $this->entregadores[] = $entregador;
        echo "Entregador '" . $entregador->getNome() . "' cadastrado com sucesso! ID: " . $entregador->getId() . "\n";
    }

    private function adicionarProdutoAoRestaurante(): void
    {
        echo "\n--- Adicionar Produto ao Restaurante ---\n";
        if (empty($this->restaurantes)) {
            echo "Nenhum restaurante cadastrado. Cadastre um restaurante primeiro.\n";
            return;
        }

        $this->listarRestaurantes();
        $restauranteId = $this->lerInputInt("Digite o ID do restaurante para adicionar o produto: ");
        $restaurante = $this->findRestauranteById($restauranteId);

        if (!$restaurante) {
            echo "Restaurante não encontrado.\n";
            return;
        }

        $nome = $this->lerInput("Nome do Produto: ");
        $descricao = $this->lerInput("Descrição do Produto: ");
        $preco = $this->lerInputFloat("Preço do Produto: ");
        $categoria = $this->lerInput("Categoria do Produto: ");

        $produto = new Produto($this->nextProdutoId++, $nome, $descricao, $preco, $categoria);
        $restaurante->adicionarProduto($produto);
    }

    private function fazerPedidoCLI(): void
    {
        echo "\n--- Fazer Pedido ---\n";
        if (empty($this->clientes)) {
            echo "Nenhum cliente cadastrado. Cadastre um cliente primeiro.\n";
            return;
        }
        if (empty($this->restaurantes)) {
            echo "Nenhum restaurante cadastrado. Cadastre um restaurante primeiro.\n";
            return;
        }

        $this->listarClientes();
        $clienteId = $this->lerInputInt("Digite o ID do cliente que fará o pedido: ");
        $cliente = $this->findClienteById($clienteId);
        if (!$cliente) {
            echo "Cliente não encontrado.\n";
            return;
        }

        $this->listarRestaurantes();
        $restauranteId = $this->lerInputInt("Digite o ID do restaurante: ");
        $restaurante = $this->findRestauranteById($restauranteId);
        if (!$restaurante) {
            echo "Restaurante não encontrado.\n";
            return;
        }

        $novoPedido = new Pedido($this->nextPedidoId++, $cliente, $restaurante);

        while (true) {
            $restaurante->exibirCardapio();
            $produtoId = $this->lerInputInt("Digite o ID do produto para adicionar ao pedido (0 para finalizar): ");
            if ($produtoId === 0) {
                break;
            }

            $produto = $restaurante->getProdutoById($produtoId);
            if ($produto && $produto->isDisponivel()) {
                $quantidade = $this->lerInputInt("Quantidade: ");
                if ($quantidade > 0) {
                    $itemPedido = new ItemPedido($produto, $quantidade);
                    $novoPedido->adicionarItem($itemPedido);
                } else {
                    echo "Quantidade deve ser maior que zero.\n";
                }
            } else {
                echo "Produto não encontrado ou indisponível.\n";
            }
        }

        if (empty($novoPedido->getItens())) {
            echo "Pedido vazio. Cancelando pedido.\n";
            return;
        }

        $novoPedido->calcularTotal();
        $this->pedidos[] = $novoPedido;
        $cliente->fazerPedido($novoPedido);
        echo "Pedido #" . $novoPedido->getId() . " criado com sucesso! Total: " . $novoPedido->getTotal() . "\n";
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

    private function atribuirEntregadorAoPedido(): void
    {
        echo "\n--- Atribuir Entregador a Pedido ---\n";
        if (empty($this->pedidos)) {
            echo "Nenhum pedido para atribuir.\n";
            return;
        }
        if (empty($this->entregadores)) {
            echo "Nenhum entregador cadastrado.\n";
            return;
        }

        $this->listarPedidos();
        $pedidoId = $this->lerInputInt("Digite o ID do pedido para atribuir: ");
        $pedido = $this->findPedidoById($pedidoId);
        if (!$pedido) {
            echo "Pedido não encontrado.\n";
            return;
        }

        if ($pedido->getStatus() !== 'pendente') {
            echo "Pedido #" . $pedido->getId() . " já está em andamento ou finalizado (Status: " . $pedido->getStatus() . ").\n";
            return;
        }

        $this->listarEntregadores();
        $entregadorId = $this->lerInputInt("Digite o ID do entregador para atribuir: ");
        $entregador = $this->findEntregadorById($entregadorId);
        if (!$entregador) {
            echo "Entregador não encontrado.\n";
            return;
        }

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
        if (empty($this->pedidos)) {
            echo "Nenhum pedido para finalizar.\n";
            return;
        }

        $this->listarPedidos();
        $pedidoId = $this->lerInputInt("Digite o ID do pedido para finalizar: ");
        $pedido = $this->findPedidoById($pedidoId);

        if (!$pedido) {
            echo "Pedido não encontrado.\n";
            return;
        }

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
            echo "Nenhum entregador foi encontrado para este pedido.\n";
            return;
        }

        $entregadorResponsavel->finalizarEntrega($pedido);

        echo "Pedido #" . $pedido->getId() . " entregue com sucesso!\n";
    }

    private function relatorioRestaurantes(): void
    {
        echo "\n--- Relatório de Restaurantes ---\n";

        $relatorio = new Relatorio($this->pedidos);
        $resultado = $relatorio->gerarRelatorioRestaurantes();

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