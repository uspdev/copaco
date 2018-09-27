[![Build Status](https://travis-ci.org/uspdev/copaco.svg?branch=master)](https://travis-ci.org/uspdev/copaco)

![GitHub pull requests](https://img.shields.io/github/issues-pr-raw/uspdev/copaco.svg) 
![GitHub closed pull requests](https://img.shields.io/github/issues-pr-closed-raw/uspdev/copaco.svg)

![GitHub issues](https://img.shields.io/github/issues/uspdev/copaco.svg) 
![GitHub closed issues](https://img.shields.io/github/issues-closed/uspdev/copaco.svg)

# Sistema de COntrole de PArque COmputacional

Pequeno aplicativo desenvolvido em Laravel para promover a integração e paz entre os devs da USP! :penguin:

Funcionalidades:
 - Cadastro de equipamentos com MAC Address
 - Cadastro de redes
 - Atribuição automática de IPs livres
 - Geração de `dhcpd.conf` com suporte a multi redes/subredes

## Instalação de bibliotecas e dependências

    node
    php7+
    php-bcmath
    php-ldap
    php-curl

Procure pela biblioteca em sua distribuição.

## Procedimentos de deploy

Em seu terminal:

```
composer install
cp .env.example .env
```

Editar o arquivo `.env`

- Dados da conexão
- Dados do OAuth e números USP dos admins do sistema

```
    SENHAUNICA_KEY=
    SENHAUNICA_SECRET=
    SENHAUNICA_CALLBACK_ID=
```

Rode as migrations

```
php artisan key:generate
php artisan migrate
```

Caso falte alguma dependência, siga as instruções do `composer`.

Configurar os *SUPERADMINS* que terão permissão total no sistema:

    SUPERADMINS_IDS=1,23
    SUPERADMINS_SENHAUNICA=5385361,123
    SUPERADMINS_LDAP=admin,xuxa

## Compile os assests com npm

    npm install
    npm run dev

## Publicando Assets do AdminLTE

Para ter a font disponível usando o AdminLTE, utilize o comando:

    php artisan deploy:assets

## FreeRadius 

Se for usar o Freeradius, criar um segundo banco de dados com o [esquema](https://github.com/FreeRADIUS/freeradius-server/blob/master/raddb/mods-config/sql/main/mysql/schema.sql) e setar as variáveis no .env:

    FREERADIUS_HABILITAR=True
    FREERADIUS_HOST=localhost
    FREERADIUS_USER=freeradius
    FREERADIUS_DB=freeradius
    FREERADIUS_PASSWD=freeradius

## Setup para usuário local de desenvolvimento

Caso você não possua o token de utilização da senha única, proceda da seguinte forma:

No seu arquivo .env, verifique se o seu `APP_ENV` está configurado para **local**.

Rode o comando de setup::

    php artisan copaco:setup_dev

Caso já tenha rodado o comando anteriormente, dê um refresh:

    php artisan migrate:refresh

Você deve ver a seguinte saída:

```
Gerando usuário para dev...
Seeding: DevUserSeeder
Seu developer id é: 11223344
Configure-o em seu arquivo .env
```

No seu arquivo `.env`, configure as entradas:

    SENHAUNICA_OVERRIDE=true
    DEVELOPER_ID=<numero gerado pelo seeder>

Assim é possível logar no sistema sem necessidade do token configurado no seu ambiente de desenvolvimento

## Seeders que podem ajudar na produção de dados aleatórios:

    php artisan migrate --seed

## Testes TDD

    ./vendor/bin/phpunit

Criar uma chave no .env para requisições no servidores dhcp e freeradius, exemplo:

    CONSUMER_DEPLOY_KEY=d34dhd892nfAzt1OMC0x

Exemplo de como consumir um dhcpd.conf:

    curl -s -d "consumer_deploy_key=d34dhd892nfAzt1OMC0x" -X POST http://localhost:8000/dhcpd.conf

Exemplo de como consumir um mods-config/files/authorize para freeradius:

    curl -s -d "consumer_deploy_key=d34dhd892nfAzt1OMC0x" -X POST http://localhost:8000//freeradius/authorize-file

## Contribuindo com o projeto

### Passos iniciais

Siga o guia no site do [uspdev](https://uspdev.github.io/contribua)

### Padrões de Projeto

Utilizamos a [PSR-2](https://www.php-fig.org/psr/psr-2/) para padrões de projeto. Ajuste seu editor favorito para a especificação.
