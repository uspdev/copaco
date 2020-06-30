[![Build Status](https://travis-ci.org/uspdev/copaco.svg?branch=master)](https://travis-ci.org/uspdev/copaco)

![GitHub pull requests](https://img.shields.io/github/issues-pr-raw/uspdev/copaco.svg) 
![GitHub closed pull requests](https://img.shields.io/github/issues-pr-closed-raw/uspdev/copaco.svg)

![GitHub issues](https://img.shields.io/github/issues/uspdev/copaco.svg) 
![GitHub closed issues](https://img.shields.io/github/issues-closed/uspdev/copaco.svg)

# Sistema de COntrole de PArque COmputacional

Sistema desenvolvido em Laravel e tem por objetivo tornar a gerência dos equipamentos que navegam em sua rede mais eficiente e prática.

Funcionalidades:

 - Cadastro de equipamentos com MAC Address
 - Cadastro de redes
 - Atribuição automática de IPs livres
 - Geração de `dhcpd.conf` com suporte a multi redes/subredes
 - Geração de `dhcpd.conf` com uma única subrede
 - Geração de configuração para servidores freeradius, tanto por arquivo, quanto por banco de dados,
 no contexto do mac-authentication, isto é, entrega de vlan correspondente ao MACaddress

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

# Usuários

O sistema trabalha tanto com usuário local, quanto integrado a bilbioteca de senha única da USP.
Configurar os usernames do *SUPERADMINS*, isto é, pessoes que terão permissão total no sistema:

    SUPERADMINS_USERNAMES=14234,zezinho,9876663
    
O auto-cadastro de usuários com login local é permitido via um código de autorização
que você deve infomar para as pessoas que poderão fazer esse autocadastro:

    CODIGO_ACESSO='MEU-CODIGO-SECRETO'

Se quiser usar apenas senha única e desativar o cadastro de login local:

    SOMENTE_SENHAUNICA=true

## Publicando Assets 

Para ter a front disponível utilize o comando:

    php artisan deploy:assets

## FreeRadius 

Se for usar o Freeradius, criar um segundo banco de dados com o [esquema](https://github.com/FreeRADIUS/freeradius-server/blob/master/raddb/mods-config/sql/main/mysql/schema.sql) e setar as variáveis no .env:

    FREERADIUS_HABILITAR=True
    FREERADIUS_HOST=localhost
    FREERADIUS_USER=freeradius
    FREERADIUS_DB=freeradius
    FREERADIUS_PASSWD=freeradius
    FREERADIUS_MACADDR_SEPARATOR='-'
    FREERADIUS_MACADDR_CASE=lower

## Seeders que podem ajudar na produção de dados aleatórios:

    php artisan migrate:fresh --seed

## Testes TDD

    ./vendor/bin/phpunit

# Geração de arquivos para servidor dhcp e freeradius

Crie uma chave no .env para autorizar as requisições:

    CONSUMER_DEPLOY_KEY=d34dhd892nfAzt1OMC0x

Exemplo de como consumir um dhcpd.conf:

    curl -s -d "consumer_deploy_key=d34dhd892nfAzt1OMC0x" -X POST http://localhost:8000/api/dhcpd.conf
    curl -s -d "consumer_deploy_key=d34dhd892nfAzt1OMC0x" -X POST http://localhost:8000/api/uniquedhcpd.conf

Exemplo de como consumir um *mods-config/files/authorize* para freeradius:

    curl -s -d "consumer_deploy_key=d34dhd892nfAzt1OMC0x" -X POST http://localhost:8000/api/freeradius/authorize_file

## Contribuindo com o projeto

### Passos iniciais

Siga o guia no site do [uspdev](https://uspdev.github.io/contribua)

### Padrões de Projeto

Utilizamos a [PSR-2](https://www.php-fig.org/psr/psr-2/) para padrões de projeto. Ajuste seu editor favorito para a especificação.
