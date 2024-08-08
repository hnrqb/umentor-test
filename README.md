# Documentação do Projeto umentor-test
- Projeto desenvolvido em PHP 5.6 utilizando o framework [Kohana](https://kohana.top/3.4/guide/kohana), com suporte adicional de JavaScript.

## Requisitos

- **PHP 5.6**
- **Composer** (para gerenciamento de dependências)
- **Servidor Web** (Apache ou Nginx)
- **MySQL** ou outro banco de dados compatível

## Passos para Configuração

### 1. Clonar o repositório

```bash
git clone https://github.com/hnrqb/umentor-test.git
cd umentor-test
```

### 2. Instalar as dependências do PHP
``` bash
composer install
```

### 3. Configuração do Banco de Dados
- Importe o arquivo **database.sql** fornecido.

### 4. Configuração do Servidor Web:
- Configure o virtual host no Apache ou Nginx para apontar para o diretório public/ do projeto.
  
  ```
  <VirtualHost *:80>
      DocumentRoot "/caminho/para/umentor-test/public"
      ServerName umentor-test.local
  
      <Directory "/caminho/para/xampp/htdocs/umentor-test/public">
          Options Indexes FollowSymLinks
          AllowOverride All
          Require all granted
      </Directory>
  </VirtualHost>
  ```

### 5. Inicie o servidor web e acesse o projeto através do navegador (http://umentor-test.local).

 



