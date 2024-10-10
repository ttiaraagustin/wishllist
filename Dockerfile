# Gunakan image resmi PHP dengan Apache
FROM php:8.1-apache

# Setel working directory di dalam container
WORKDIR /var/www/html

# Install dependencies yang diperlukan
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    curl

# Install ekstensi PHP yang diperlukan Laravel
RUN docker-php-ext-install pdo pdo_mysql mbstring gd xml

# Install Composer
COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer

# Copy semua file dari project ke dalam container
COPY . /var/www/html

# Set proper ownership and permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Expose port 80
EXPOSE 80

# Jalankan Composer install untuk menginstall dependencies Laravel
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Jalankan Laravel artisan commands jika diperlukan (misalnya untuk cache)
RUN php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

# Jalankan Apache di foreground
CMD ["apache2-foreground"]
