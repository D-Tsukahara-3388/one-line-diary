FROM php:8.2-fpm

# パッケージインストール
RUN apt-get update \
  && apt-get install --no-install-recommends -y \
  apt-transport-https \
    apt-utils \
    build-essential \
    curl \
    debconf-utils \
    gcc \
    git \
    mariadb-client \
    libfontconfig1 \
    libfreetype6-dev \
    libicu-dev \
    libjpeg62-turbo-dev \
    libmagickwand-dev \
    libpng-dev \
    libxrender1 \
    libzip-dev \
    locales \
    #ssl-cert \
    unzip \
    vim \
    zlib1g-dev \
  && docker-php-ext-install \
    zip \
    pdo_mysql \
    intl \
    sockets \
  && docker-php-ext-configure gd --enable-gd --with-jpeg \
  && docker-php-ext-install -j$(nproc) gd \
  && docker-php-ext-install opcache \
  && apt-get clean \
  && pecl install imagick \
  && docker-php-ext-enable imagick \
  && rm -rf /var/lib/apt/lists/* \
  && echo "en_US.UTF-8 UTF-8" >/etc/locale.gen \
  && locale-gen

# Redis拡張をインストール
RUN pecl install redis && docker-php-ext-enable redis

# Composer インストール
COPY --from=composer /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /composer
ENV PATH $PATH:/composer/vendor/bin

# NVMのインストール
ENV NODE_VERSION=20.18.0
RUN curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.7/install.sh | bash

# NVMの環境設定
ENV NVM_DIR=/root/.nvm
RUN . "$NVM_DIR/nvm.sh" && nvm install ${NODE_VERSION}
RUN . "$NVM_DIR/nvm.sh" && nvm use v${NODE_VERSION}
RUN . "$NVM_DIR/nvm.sh" && nvm alias default v${NODE_VERSION}

# PATHを設定
ENV PATH="$NVM_DIR/versions/node/v${NODE_VERSION}/bin/:$PATH"

# laravel インストール
COPY ./src /var/www/html/
WORKDIR /var/www/html/
RUN chmod -R a+w storage/ bootstrap/cache
RUN composer install
RUN cp .env.example .env
RUN php artisan key:generate
RUN php artisan storage:link

# TimeZone settings
ENV TZ Asia/Tokyo
RUN echo "${TZ}" > /etc/timezone \
   && dpkg-reconfigure -f noninteractive tzdata

