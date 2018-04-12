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
 
    - composer install
    - cp .env.example .env
    - Editar o arquivo .env
        - Dados da conexão
        - Dados do OAuth e números USP dos admins do sistema
        ```
        SENHAUNICA_KEY=
        SENHAUNICA_SECRET=
        SENHAUNICA_CALLBACK_ID=

        CODPES_ADMINS=
        ```
    - php artisan key:generate
    - php artisan migrate

Caso falte alguma dependência, siga as instruções do `composer`.

## Compile os assests com npm

    npm install  
    npm run dev

## Contribuindo com o projeto

### Passos iniciais

Siga o guia no site do [uspdev](https://uspdev.github.io/contribua)

### Padrões de Projeto

Utilizamos a [PSR-2](https://www.php-fig.org/psr/psr-2/) para padrões de projeto. Ajuste seu editor favorito para a especificação.
