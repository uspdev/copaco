[![Build Status](https://travis-ci.org/uspdev/copaco.svg?branch=master)](https://travis-ci.org/uspdev/copaco)

![GitHub pull requests](https://img.shields.io/github/issues-pr-raw/uspdev/copaco.svg) 
![GitHub closed pull requests](https://img.shields.io/github/issues-pr-closed-raw/uspdev/copaco.svg)

![GitHub issues](https://img.shields.io/github/issues/uspdev/copaco.svg) 
![GitHub closed issues](https://img.shields.io/github/issues-closed/uspdev/copaco.svg)

# Sistema de COntrole de PArque COmputacional

Sistema desenvolvido em Laravel para promover a integração e paz entre os devs da USP! :penguin:
Tem por objetivo tornar a gerência dos equipamentos que navegam em sua rede mais eficiente e prática.

Funcionalidades:

 - Cadastro de equipamentos com MAC Address
 - Cadastro de redes
 - Atribuição automática de IPs livres
 - Geração de `dhcpd.conf` com suporte a multi redes/subredes
 - Geração de configuração para servidores freeradius, basicamente para entregarem a vlan correspondente ao MACaddress

## Instalação de bibliotecas e dependências

    php7+
    php-bcmath
    php-ldap
    php-curl

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

    SUPERADMINS_USERNAMES=14234,zezinho,9876663

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
