# Sistema de Delivery

Projeto para a disciplina de Programação Orientada a Objetos  
Tema: Sistema de Delivery

## ☂️ Autores

Nome Completo | RA

- Matheus Pereira | 2038066
- Felipe Vicente | 2027906
- Alessandro Junior da Silva | 2022983
- Caio Falzoni | 2025686

## 🧙‍♂️ A escolha do tema

Após longas e diligentes deliberações entre os digníssimos membros desta confraria acadêmica, acerca da utilidade e grandeza que nosso labor haveria de possuir, eis que se recorreu ao nobre e ancestral rito do **_joquempô_**. E assim, por vontade do destino e graça dos céus, sagrou-se vitorioso o tema do honrado sistema de entregas, em detrimento do robusto tema das academias.

## 📝 Descrição

O **Sistema Delivery** é uma aplicação de linha de comando desenvolvida em PHP que permite cadastrar clientes, restaurantes, entregadores, produtos, e realizar pedidos. Foi criado para atender aos requisitos da disciplina de POO do curso de Ciências da Computação, aplicando os princípios de abstração e herança, uso de arrays, type casting e entrada de dados via teclado usando `readline()`.

## 🔧 Requisitos

- XAMPP
- PHP
- Composer
- Sistema operacional que suporte PHP CLI (Windows, Linux, macOS)

## 🚀 Instalação

1. Clone este repositório:

   ```
   https://github.com/matheusmpz/sistema-delivery.git
   ```

2. Acesse a pasta do projeto:

   ```
   cd <caminho ate a pasta>
   ```

3. Instale as dependências do Composer:
   ```
   composer install
   ```
4. Gere o autoload:

   ```
   composer dump-autoload
   ```

5. Para rodar o sistema, abra o terminal na pasta do projeto e execute:
   ```
   php index.php
   ```

## 🏦 Estrutura do Projeto

As classes do projeto dentro da pasta /src foram divididas em 3 partes sendo elas:

- **Abstracts**: contém classes abstratas usadas para herança
- **Entity**: classes das entidades principais (Cliente, Restaurante, etc.).
- **Core**: classe principal responsavel pelos menus, entrada de dados, menus, etc.

Isso foi decidido após realizar uma pesquisa e verificar que esse tipo de estrutura de pasta é comum em pequenos projetos de POO que utilizam o composer.

```
src/
├── Abstracts/
│   └── Item.php
│   └── Pessoa.php
├── Core/
│   └── SistemaDelivery.php
└── Entity/
    ├── Cliente.php
    ├── Restaurante.php
    ├── Entregador.php
    ├── Produto.php
    ├── Pedido.php
    └── ItemPedido.php
```

## 📄 Documentação

Arquivo de [Diagrama das Classes](docs/classes-sistema-delivery.excalidraw) presente na pasta /docs do projeto
