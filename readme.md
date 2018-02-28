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

Procure pela biblioteca em sua distribuição.

## Procedimentos de deploy
 
    composer install

Caso falte alguma dependência, siga as instruções do `composer`.

Depois gere seu arquivo de configuração do Laravel e a chave da aplicação:

    cp .env.example .env
    php artisan key:generate

## Compile os assests com npm

    npm install  
    npm run dev

## Contribuindo com o projeto

### Passos iniciais

Siga o guia no site do [uspdev](https://uspdev.github.io/contribua)

### Padrões de Projeto

Utilizamos a [PSR-2](https://www.php-fig.org/psr/psr-2/) para padrões de projeto. Ajuste seu editor favorito para a especificação.
