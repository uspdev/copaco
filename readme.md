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

## Publicando Assets do AdminLTE

Para ter o font disponível usando o AdminLTE, utilize o comando:

    php artisan vendor:publish --provider="JeroenNoten\LaravelAdminLte\ServiceProvider" --tag=assets



## Setup para usuário local de desenvolvimento

Caso você não possua o token de utilização da senha única, proceda da seguinte forma:

No seu arquivo .env, verifique se o seu `APP_ENV` está configurado para **local**.

Rode as migragions com o  `Seeder`:

    php artisan migrate --seed

Caso já tenha rodado as migrations anteriormente, dê um refresh:

    php artisan migrate:refresh --seed

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


## Contribuindo com o projeto

### Passos iniciais

Siga o guia no site do [uspdev](https://uspdev.github.io/contribua)

### Padrões de Projeto

Utilizamos a [PSR-2](https://www.php-fig.org/psr/psr-2/) para padrões de projeto. Ajuste seu editor favorito para a especificação.
