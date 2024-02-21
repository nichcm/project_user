# README

## Symfony PHP Project

Este repositório contém um projeto desenvolvido em Symfony em PHP. O Symfony é um framework PHP de código aberto para o desenvolvimento de aplicações web robustas e escaláveis.

### Configuração do Ambiente

Para começar a usar este projeto, siga as instruções abaixo para configurar seu ambiente:

1. **Clone o repositório:**
   ```bash
   git clone https://github.com/seu-usuario/project_user.git
    ```
2. **Instale as dependências do Composer:**
   ```
   cd project_user
   composer install
   ```
3.**Configuração do Banco de Dados:**
  Dentro da pasta principal do repositório, crie um arquivo com o nome ".env".
  Edite o arquivo .env e insira as informações de conexão do banco de dados de sua preferência:
  ```
  DATABASE_URL="mysql://local:senha@localhost:3306/symfony?serverVersion=5.7"
  ````
4.**Criar o Banco de Dados:**
  Após configurar o arquivo .env com os detalhes do seu banco de dados, execute o seguinte comando para criar o banco de dados:
  ```
  php bin/console doctrine:database:create
  ```
4.**Executar as Migrações (Opcional):**
  Se houver migrações pendentes, execute o seguinte comando para aplicá-las ao banco de dados:
  ```
  php bin/console doctrine:migrations:migrate
  ```
5.**Iniciar o Servidor de Desenvolvimento:**
```
symfony serve
```

Documentação Adicional
Para mais informações sobre como usar o Symfony, consulte a documentação oficial do Symfony.
