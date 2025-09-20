<?php
namespace App\Abstracts;

abstract class Pessoa {
    protected int $id;
    protected string $nome;
    protected string $email;
    protected string $telefone;

    public function __construct(int $id, string $nome, string $email, string $telefone)
    {
        $this->id = $id;
        $this->nome = $nome;
        $this->email = $email;
        $this->telefone = $telefone;
    }

    abstract public function exibirInformacoes(): void;

    protected function validarEmail(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getTelefone(): string

    {
        return $this->telefone;
    }
}
