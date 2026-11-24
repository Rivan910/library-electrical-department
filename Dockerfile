# =========================
# Stage 1: Build Frontend
# =========================
FROM node:22-alpine AS frontend

WORKDIR /app

# Copy file dependency Node
COPY package*.json ./

# Install dependency
RUN npm ci

# Copy project untuk kebutuhan Vite
COPY . .

# Build CSS dan JavaScript
RUN npm run build


# =========================
# Stage 2: Laravel + FrankenPHP
# =========================
FROM dunglas/frankenphp:latest-php8.2

WORKDIR /app

# Install PHP extensions yang dibutuhkan Laravel dan PhpSpreadsheet
RUN install-php-extensions \
    pdo_mysql \
    gd \
    intl \
    zip \
    opcache

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy seluruh project Laravel
COPY . /app

# Copy hasil build Vite dari stage frontend
COPY --from=frontend /app/public/build /app/public/build

# Install dependency Laravel
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Pastikan folder Laravel bisa ditulis
RUN mkdir -p storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache

RUN chmod -R 775 storage bootstrap/cache

# Railway memberikan PORT melalui environment variable
CMD ["frankenphp", "run", "--config", "/etc/caddy/Caddyfile"]