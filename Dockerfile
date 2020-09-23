FROM php:7.4-fpm

RUN apt-get update && apt-get install -y \
    libxml2-dev \
    libzip-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    zip \
    unzip \
    git \
    curl

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_sqlite mbstring zip exif pcntl bcmath gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN groupadd -g 1000 web
RUN useradd -G web,root -u 1000 -s /bin/bash -m -d /home/web web
RUN mkdir -p /home/web/.composer && chown -R web:web /home/web

WORKDIR /var/www
USER web

EXPOSE 8000
CMD ["php", "artisan", "serve"]
