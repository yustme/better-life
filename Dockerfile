FROM php:7.3

RUN apt-get update \
 && apt-get install wget git curl -y \
 && rm -r /var/lib/apt/lists/*

#install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin/ --filename=composer

#install symfony
RUN wget https://get.symfony.com/cli/installer -O - | bash \
 && mv /root/.symfony/bin/symfony /usr/local/bin/symfony

WORKDIR /code