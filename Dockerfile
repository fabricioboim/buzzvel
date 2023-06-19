FROM php:8.1.1-fpm

# Arguments
ARG user=fabricio
ARG uid=1000

RUN apt-get update && \
    apt-get install -y software-properties-common && \
    rm -rf /var/lib/apt/lists/*

RUN apt-get update && apt-get install -y \
    autoconf automake libtool m4 \
    libbz2-dev \
    libzip-dev \
    git \
    grep \
    libtool \
    make \
    autoconf \
    g++ \
    bash \
    zip \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libpq-dev

RUN apt-get -y update && \
    docker-php-ext-install gd pdo \
    pdo_pgsql \
    pgsql \
    gd \
    zip

# Install system dependencies
RUN apt-get update && apt-get install -y \
    # git \
    curl \
    # libpng-dev \
    libonig-dev \
    libxml2-dev
    # \
    # zip \
    # unzip

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd sockets

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Install redis
RUN pecl install -o -f redis \
    &&  rm -rf /tmp/pear \
    &&  docker-php-ext-enable redis

# Set working directory
WORKDIR /var/www

USER $user
