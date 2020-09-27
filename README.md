# Simple Transactions API

Простая реализация [тестового задания](specification.pdf).

## Установка

Описана сборка проекта в минимальной комплектации, на базе встроенного в PHP веб-сервера, с базой данных SQLite. 
После установки приложение будет доступно на http://localhost:8000/

### С помощью docker-compose

    git clone git@github.com:eugenezadorin/test-transactions-api.git
    cd test-transactions-api
    cp .env.example .env
    touch database/database.sqlite
    docker-compose up -d
    docker-compose exec app composer install
    docker-compose exec app php artisan key:generate
    docker-compose exec app php artisan migrate --seed
    docker-compose exec app php artisan test
    docker-compose exec app php artisan serve --host=0.0.0.0

### В Windows

Понадобится git, PHP (>=7.4), composer.

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
    
    # прогоняем тесты
    php artisan test

    # запускаем проект на http://localhost:8000/
    php artisan serve
    
## Использование

API реализовано в соответствии со спецификацией JSON-RPC. Тестировать удобно с помощью утилиты [Postman](https://www.postman.com/).

Ниже примеры curl-запросов для экспресс-тестирования.

### Создание транзакции

    curl -X POST http://localhost:8000/api/v1/transactions -H "Content-Type: application/json" -d @tests/add_transaction.json
    
    # add_transaction.json
    {
        "jsonrpc":"2.0",
        "method":"AddTransaction@handle",
        "params": {
            "account_id": 1,
            "type": "debit",
            "amount": 1000,
            "currency": "USD",
            "reason": "refund"
        },
        "id" : 1
    }

### Получение баланса

    curl -X POST http://localhost:8000/api/v1/accounts -H "Content-Type: application/json" -d @tests/get_account_balance.json
    
    # get_account_balance.json
    {
        "jsonrpc":"2.0",
        "method":"GetAccountBalance@handle",
        "params": {
            "account_id": 1
        },
        "id" : 1
    }
    
### Получить возвраты за неделю

    curl -X POST http://localhost:8000/api/v1/transactions -H "Content-Type: application/json" -d @tests/get_weekly_refunds.json
    
    # get_weekly_refunds.json
    {
        "jsonrpc":"2.0",
        "method":"GetWeeklyRefunds@handle",
        "id" : 1
    }
    
## Примечания

1. Решил задействовать фреймворк, чтобы не тратить время на базовые вещи вроде роутинга и работы с БД.
2. Местами может показаться, что оверинжиниринг (например DTO-классы и Enums) - но это всё делается с целью упростить дальнейшую поддержку за счет типизации.
3. Пара тестов есть, в реальном проекте их конечно должно быть больше. Интересно было пощупать [pest](https://pestphp.com/).
4. Авторизацию намеренно оставил за скобками, чтобы проще было протестировать решение
5. Методы API (процедуры) реализованы в `app/Http/Procedures`
6. SQL-запрос реализован в рамках процедуры `GetWeeklyRefunds`
 
