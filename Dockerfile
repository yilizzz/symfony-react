FROM php:8.4-fpm-alpine

# 1. 安装依赖、PHP 扩展以及 bash
# 在 Alpine 中，nodejs 和 npm 通常就在官方仓库里
RUN apk add --no-cache \
    icu-dev \
    postgresql-dev \
    bash \
    curl \
    nodejs \
    npm \
    && docker-php-ext-install intl pdo pdo_pgsql

# 2. 复制 Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 3. 设置工作目录
WORKDIR /var/www/html