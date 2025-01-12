### First launch:

1. Copy .env.example to .env and change default ports:

    `NGINX_BACKEND_PORT=7020`

    `PHPMYADMIN_PORT=7022`

    `MARIADB_PORT=7023`

    `RABBITMQ_PORT=7024`

    `RABBITMA_SSL_PORT=7025`


2. Run commands in app root folder:

    `docker-compose down`
    
    `docker-compose up -d`
    
    `docker exec zt_esprzedaz-php php artisan migrate`



### Next launch

Run command `docker-compose up -d`
