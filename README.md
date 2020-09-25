# Simple Transactions API

Простая реализация [тестового задания](specification.pdf). Решил задействовать фреймворк, чтобы не тратить время на базовые вещи вроде роутинга и работы с БД.

## Установка

Описана сборка проекта в минимальной комплектации, на базе встроенного в PHP веб-сервера, с базой данных SQLite. После установки приложение будет доступно на http://localhost:8000/

### С помощью docker-compose

    git clone git@github.com:eugenezadorin/test-transactions-api.git
    cd test-transactions-api
    cp .env.example .env
    touch database/database.sqlite
    docker-compose up -d
    docker-compose exec app composer install
    docker-compose exec app php artisan key:generate
    docker-compose exec app php artisan migrate --seed
    docker-compose exec app php artisan serve --host=0.0.0.0

### В Windows

Понадобится git, PHP, composer.

Конфигурация php должна соответствовать [требованиям Laravel](https://laravel.com/docs/8.x/installation#server-requirements).

    # клонируем исходный код проекта
    git clone git@github.com:eugenezadorin/test-transactions-api.git
    cd test-transactions-api

    # устанавливаем зависимости
    composer install

    # производим базовую настройку
    copy .env.example .env
    php artisan key:generate

    # создаем базу данных и наполняем её тестовыми данными
    php -r "touch('database/database.sqlite');"
    php artisan migrate --seed

    # запускаем проект на http://localhost:8000/
    php artisan serve
