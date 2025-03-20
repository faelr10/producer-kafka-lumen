# Imagem do PHP com Apache
FROM php:8.2-apache

# Instalar dependências do Kafka
RUN apt-get update && apt-get install -y \
    librdkafka-dev \
    && pecl install rdkafka \
    && docker-php-ext-enable rdkafka

# Instalar extensões do PHP
RUN docker-php-ext-install pdo pdo_mysql

# Instalar Composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Definir o diretório de trabalho
WORKDIR /var/www/html
COPY . .

# Ajustar permissões
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage

# Expor a nova porta
EXPOSE 8001

# Alterar a porta do servidor Lumen para 8001
CMD ["php", "-S", "0.0.0.0:8001", "-t", "public"]
