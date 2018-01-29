A small app that promote integration and peace between USP devs!

Features:
 - Add equipments with MAC Address 
 - Add new network
 - Generate dhcpd.conf for multi subnet setup

Deploy procudures:
 
    composer install
    cp .env.example .env
    php artisan key:generate

Compile assests:

    npm install  
    npm run dev
