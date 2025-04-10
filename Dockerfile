FROM php:7.4-apache
# FROM php:8.0-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    git \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && rm -rf /var/lib/apt/lists/*  # Cleanup

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install pdo pdo_mysql zip gd

# Enable Apache modules
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy Apache configuration
COPY apache.conf /etc/apache2/sites-available/000-default.conf

# Set permissions
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html


# FROM php:7.4-apache

# # Install system dependencies
# RUN apt-get update && apt-get install -y \
#     libzip5 \
#     zip \
#     unzip \
#     git \
#     libpng-dev \
#     libjpeg-dev \
#     libfreetype6-dev

# # Install PHP extensions
# RUN docker-php-ext-install pdo pdo_mysql zip
# RUN docker-php-ext-configure gd --with-freetype --with-jpeg
# RUN docker-php-ext-install gd

# # Enable Apache modules
# RUN a2enmod rewrite

# # Set working directory
# WORKDIR /var/www/html

# # Copy Apache configuration
# COPY apache.conf /etc/apache2/sites-available/000-default.conf

# # Set permissions
# RUN chown -R www-data:www-data /var/www/html
# RUN chmod -R 755 /var/www/html
