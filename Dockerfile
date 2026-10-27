FROM php:8.3-fpm

# 1. أضفنا libicu-dev و intl هنا
RUN apt-get update && apt-get install -y git unzip libzip-dev libicu-dev \
    && docker-php-ext-install pdo_mysql zip pcntl bcmath intl

# 2. تثبيت وتفعيل إضافة Redis
RUN pecl install redis && docker-php-ext-enable redis

# 3. جلب Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 4. مجلد العمل
WORKDIR /var/www