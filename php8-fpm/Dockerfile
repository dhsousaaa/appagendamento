FROM ronisaha/php-8-debain:fpm-8.2.8

RUN apt-get update && apt-get install -y \
    apt-utils \ 
    curl \
    build-essential \
    openssl \
    libssl-dev \
    zlib1g-dev \
    libzip-dev \
    ca-certificates \
    unzip

RUN docker-php-ext-install pdo pdo_mysql bcmath opcache zip

RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get update && apt-get install nodejs -y

RUN apt-get install -y --no-install-recommends libcurl4-openssl-dev \
    && pecl install mongodb \
    && echo "extension=mongodb.so" >> /usr/local/etc/php/conf.d/docker-fpm.ini

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# RUN npm install

EXPOSE 9000

ENTRYPOINT ["php-fpm"]
