<?php

namespace App\Util;

class ConsoleInput
{
    public static function lerInput(string $prompt): string
    {
        echo $prompt;
        $input = trim(readline());
        return $input;
    }

    public static function lerInputTexto(string $prompt, int $minLen = 3): string
    {
        while (true) {
            $input = self::lerInput($prompt);
            if (strlen($input) >= $minLen) {
                return $input;
            }
            echo "Entrada muito curta. Por favor, digite pelo menos $minLen caracteres.\n";
        }
    }

    public static function lerInputEmail(string $prompt): string
    {
        while (true) {
            $input = self::lerInput($prompt);
            if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
                return $input;
            }
            echo "E-mail inválido. Tente novamente (ex: nome@exemplo.com).\n";
        }
    }

    public static function lerInputTelefone(string $prompt): string
    {
        while (true) {
            $input = self::lerInput($prompt);
            if (ctype_digit($input) && strlen($input) >= 8) {
                return $input;
            } else {
                echo "Telefone inválido. Digite apenas números (mínimo 8 dígitos).\n";
            }
        }
    }

    public static function lerInputCNH(string $prompt): string
    {
        while (true) {
            $input = self::lerInput($prompt);
            if (ctype_digit($input) && strlen($input) === 11) {
                return $input;
            }
            echo "CNH inválida. A CNH deve conter exatamente 11 números.\n";
        }
    }

    public static function lerInputVeiculo(): string
    {
        echo "\nSelecione o veículo:\n";
        echo "[1] Moto\n";
        echo "[2] Carro\n";
        echo "[3] Bicicleta\n";
        
        while (true) {
            $opcao = self::lerInputInt("Opção: ");
            switch ($opcao) {
                case 1: return "Moto";
                case 2: return "Carro";
                case 3: return "Bicicleta";
                default: echo "Opção inválida. Escolha 1, 2 ou 3.\n";
            }
        }
    }

    public static function lerInputInt(string $prompt): int
    {
        while (true) {
            $input = self::lerInput($prompt);
            if (is_numeric($input) && (int)$input == $input) {
                return (int)$input;
            }
            echo "Entrada inválida. Por favor, digite um número inteiro.\n";
        }
    }

    public static function lerInputQuantidade(string $prompt): int
    {
        while (true) {
            $qtd = self::lerInputInt($prompt);
            if ($qtd > 0 && $qtd <= 100) {
                return $qtd;
            } elseif ($qtd > 100) {
                echo "Quantidade muito alta (limite de 100 por item). Tente novamente.\n";
            } else {
                echo "Quantidade deve ser maior que zero.\n";
            }
        }
    }

    public static function lerInputFloat(string $prompt): float
    {
        while (true) {
            $input = self::lerInput($prompt);
            $inputTratado = str_replace(',', '.', $input);
            if (is_numeric($inputTratado)) {
                return (float)$inputTratado;
            }
            echo "Entrada inválida. Digite um número decimal (ex: 10.50).\n";
        }
    }

    public static function lerInputPrecoPositivo(string $prompt): float
    {
        while (true) {
            $valor = self::lerInputFloat($prompt);
            if ($valor > 0) {
                return $valor;
            }
            echo "O preço deve ser maior que R$ 0,00.\n";
        }
    }
}