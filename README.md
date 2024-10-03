# Projeto Laravel CRUD - Gerenciamento de Clientes

Este projeto utiliza o **Laravel** para gerenciar informações sobre clientes, representações e cidades. O sistema é estruturado com **Vite** para o gerenciamento do Front-End

## Pré-requisitos

Antes de iniciar, certifique-se de ter os seguintes itens instalados:

- [PHP](https://www.php.net/) versão 8.0 ou superior
- [Composer](https://getcomposer.org/)
- [Node.js](https://nodejs.org/) versão 14.x ou superior
- [npm](https://www.npmjs.com/) ou [yarn](https://yarnpkg.com/)

## Como Executar o Projeto

Siga os passos abaixo para configurar e executar o projeto localmente:

### 1. Clone o Repositório

Clone este repositório para sua máquina local

### 2. Instale as Dependências
```bash
composer install
npm install
```

### 3. Crie o Arquivo de Configuração
```bash
cp .env.example .env
```

### 4. Configure o .env 
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nome_do_banco
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha

```

e execute suas migrações com o Seeder + Factory que já estão inclusas no Seeder
```bash
php artisan migrate --seed
```


### 5. Inicie o Servidor e abra outro terminal para iniciar o npm
```bash
php artisan serve
```

```bash
npm run dev
```
ou realize a construção no npm com:

```bash
npm run build
```

### 6 . Após seguir todos os passos, você poderá acessar a aplicação em http://localhost:8000.

![Projeto](https://github.com/user-attachments/assets/85515138-0beb-4dfd-9416-28ed84d2b49c)

( Quando um Representante é atribuido a um cliente a opção de atribuir é removida, deve entrar no gerenciamento de Clientes & Representantes para Remover a atribuição)

<hr>

⦁ Gerar um script SQL que a partir do ID do cliente, retorne todos os representantes que podem atendê-lo.
```bash
SELECT r.id, r.nome
FROM representantes r
JOIN clientes_representantes cr ON cr.representante_id = r.id
JOIN clientes c ON c.id = cr.cliente_id
WHERE c.id = 25;  
```


⦁ Gerar um script SQL que retorne todos os representantes de uma determinada cidade.
```bash
SELECT r.id, r.nome
FROM representantes r
WHERE r.cidade_id = 31;  
```

⦁ Gerar um script SQL que retorne todos os representantes de uma determinada cidade.

```bash
SELECT r.id, r.nome
FROM representantes r
WHERE r.cidade_id = 31;  --Substitua o ID por a cidade desejada 
```

### Bonus[Como achar o ID de uma cidade pra se aplicar no script acima]
```bash
SELECT id
FROM cidades
WHERE nome = 'Nome da Cidade';  -- Substitua 'Nome da Cidade' pelo nome da cidade que você deseja buscar
```
### ⚠️ Script do banco completo está na pasta database ⚠️


