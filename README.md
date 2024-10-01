
# Gestão de Projetos de Energia Solar

O sistema é uma aplicação voltada para empresas que atuam no setor de energia solar, permitindo o cadastro, visualização, atualização e exclusão de informações relacionadas aos projetos de energia solar, incluindo dados sobre clientes, local da instalação e equipamentos


## Instalação

Rode essa aplicação usando o docker

Windows
```
https://docs.docker.com/desktop/install/windows-install/
```

Ubuntu
```
https://docs.docker.com/engine/install/ubuntu/
```

Depois de instalar o docker, rode o comando:
```bash
  docker compose up -d
```

Para gerar o Swagger:
```
docker-compose exec app php artisan l5-swagger:generate
```
Para acessar a documentação
```
http://localhost:8000/api/documentation#/
```

## Rodando os testes

Para rodar os testes, rode o seguinte comando

```bash
  docker-compose exec app php artisan test
```


## Apêndice

Criei uma posta chamada docs, dentro dela tem uma imagem do relacionamento de entidades.
Tambem tem o link do postman para a collection caso queira usar.