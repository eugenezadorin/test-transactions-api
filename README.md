# Simple Transactions API

Простая реализация [тестового задания](specification.pdf). Решил задействовать фреймворк, чтобы не тратить время на базовые вещи вроде роутинга и работы с БД.

## Предварительные требования

- git
- PHP
- composer

Конфигурация php должна соответствовать [требованиям Laravel](https://laravel.com/docs/8.x/installation#server-requirements).

## Установка

Ниже приведен базовый пример установки и запуска проекта в Windows с базой данных SQLite.

В случае использования другой ОС или СУБД (например MySQL) порядок установки может отличаться. Подробности [в документации](https://laravel.com/docs/8.x/installation).

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
