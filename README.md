# Gestão de Projetos de Energia Solar

O sistema é uma aplicação voltada para empresas que atuam no setor de energia solar, permitindo o cadastro, visualização, atualização e exclusão de informações relacionadas aos projetos de energia solar, incluindo dados sobre clientes, local da instalação e equipamentos.

## Índice

- [Descrição](#descrição)
- [Instalação](#instalação)
- [Rodando os testes](#rodando-os-testes)
- [Documentação da API](#documentação-da-api)
- [Uso do Sistema](#uso-do-sistema)
- [Apêndice](#apêndice)

## Descrição

O sistema permite gerenciar projetos de energia solar, incluindo:

- **Clientes**: Cadastro e gerenciamento dos clientes.
- **Projetos**: Criação e gerenciamento dos projetos associados aos clientes.
- **Equipamentos**: Gerenciamento dos equipamentos utilizados nos projetos.
- **Instalações**: Tipos de instalação para os projetos.
- **Endereços**: Localização dos projetos.

## Instalação

Siga as instruções abaixo para instalar e executar a aplicação usando Docker.

### Pré-requisitos

- **Docker**: Certifique-se de que o Docker está instalado em sua máquina.

#### Instalação do Docker

- **Windows**:
  [Instruções de instalação](https://docs.docker.com/desktop/install/windows-install/)

- **Ubuntu**:
  [Instruções de instalação](https://docs.docker.com/engine/install/ubuntu/)

- **Mac**:
  [Instruções de instalação](https://docs.docker.com/desktop/install/mac-install/)

### Passo a Passo

1. **Clone o repositório:**
    ```bash
    git clone https://github.com/rapvalerio/77sol.git
    ```
2. **Navegue até o diretório do projeto:**
    ```bash
    cd 77sol
    ```
3. **Inicie os contêineres Docker:**
    ```bash
    docker-compose up -d --build
    ```
4. **Instale as dependências do Composer:**
    ```bash
    docker-compose run --rm app composer install
    ```
5. **Crie o arquivo .env**
    ```bash
    cp .env.example .env
    ```
6. **Adicione os valores para o banco de dados**
    ```bash
    DB_CONNECTION=mysql
    DB_HOST=db
    DB_PORT=3306
    DB_DATABASE=laravel
    DB_USERNAME=root
    DB_PASSWORD=root
    ```
7. **Execute as migrações para criar as tabelas no banco de dados:**
    ```bash
    docker-compose exec app php artisan migrate
    ```
8. **Gere a documentação Swagger:**
    ```bash
    docker-compose exec app php artisan l5-swagger:generate
    ```
9. **Acesse a aplicação:**
    ```bash
    Abra o navegador e acesse http://localhost:8000/api/documentation
    ```

# Rodando os testes
Para executar os testes automatizados, utilize o seguinte comando:
```bash
docker-compose exec app php artisan test
```
# Documentação da API
A documentação completa da API está disponível via Swagger.
-  **Gerar a documentação Swagger:**
    ```bash
    docker-compose exec app php artisan l5-swagger:generate
    ```
- **Acessar a documentação Swagger:**
    ```bash
    docker-compose exec app php artisan l5-swagger:generate
    ```
    Abra o navegador e acesse:
    ```bash
    http://localhost:8000/api/documentation#/
    ```
- **O que você encontrará na documentação:**
    - Lista de todos os endpoints da API.
    - Descrição dos parâmetros de entrada e saída.
    - Modelos de requisição e resposta.
    - Códigos de status HTTP retornados.
    - Possibilidade de testar os endpoints diretamente na interface.
# Uso do Sistema
### Exemplo Rápido: Criando um Novo Cliente
Embora a documentação detalhada esteja disponível no Swagger, aqui está um exemplo de como criar um novo cliente usando curl:
```bash
curl -X POST "http://localhost:8000/api/clientes" \
-H "Content-Type: application/json" \
-d '{
"nome": "João Silva",
"email": "joao@example.com",
"telefone": "(11) 91234-5678",
"documento": "12345678901"
}'
```
**Resposta esperada:**
```json
{
  "id": 1,
  "nome": "João Silva",
  "email": "joao@example.com",
  "telefone": "(11) 91234-5678",
  "documento": "12345678901",
  "created_at": "2023-10-01T12:00:00Z",
  "updated_at": "2023-10-01T12:00:00Z"
}

```
**Exemplo Rápido: Criando um Novo Projeto com Equipamentos**
```bash
curl -X POST "http://localhost:8000/api/projetos" \
-H "Content-Type: application/json" \
-d '{
  "nome": "Projeto Solar X",
  "cliente_id": 1,
  "endereco_id": 2,
  "instalacao_id": 3,
  "equipamentos": [
    {
      "equipamento_id": 1,
      "quantidade": 10
    },
    {
      "equipamento_id": 2,
      "quantidade": 5
    }
  ]
}'
```
**Resposta esperada:**
```json
{
  "id": 5,
  "nome": "Projeto Solar X",
  "cliente_id": 1,
  "endereco_id": 2,
  "instalacao_id": 3,
  "equipamentos": [
    {
      "equipamento_id": 1,
      "quantidade": 10
    },
    {
      "equipamento_id": 2,
      "quantidade": 5
    }
  ],
  "created_at": "2023-10-01T15:00:00Z",
  "updated_at": "2023-10-01T15:00:00Z"
}
```
Para mais exemplos e detalhes, consulte a [documentação da API](http://localhost:8000/api/documentation#/).

# Apêndice
- **Diagrama de Entidade-Relacionamento (DER):**
    - Criei uma pasta chamada docs, dentro dela há uma imagem do relacionamento de entidades (der.jpg)

- **Collection do Postman:**
Também há o link do Postman para a collection, caso queira usar.
    - O arquivo postman.txt está na pasta docs.
