FROM php:8.4-fpm-alpine

# 安装必要的 PHP 扩展
RUN apk add --no-cache icu-dev postgresql-dev \
    && docker-php-ext-install intl pdo pdo_pgsql
# 从官方 Composer 镜像中拷贝二进制文件到我们的容器中
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
WORKDIR /var/www/html