FROM node:latest AS node
FROM php:8.1-apache

COPY --from=node /usr/local/lib/node_modules /usr/local/lib/node_modules
COPY --from=node /usr/local/bin/node /usr/local/bin/node
RUN ln -s /usr/local/lib/node_modules/npm/bin/npm-cli.js /usr/local/bin/npm

RUN apt-get update && apt-get install -y \
  git \
  zip \
  wkhtmltopdf \
  && rm -rf /var/lib/apt/lists/*

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions gd xdebug soap imap calendar pdo_mysql redis tokenizer

RUN a2enmod rewrite

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

ENV APACHE_DOCUMENT_ROOT /app/public

WORKDIR /app

COPY ./docker/php/apache.conf /etc/apache2/sites-enabled/000-default.conf

RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Add user for laravel application
RUN addgroup --system www && useradd -g www www \
    && chown -R www-data:www-data /app/ \
    && chmod -R +rwX /app/

#link & enable wkhtmltopdf execute
RUN ln -s /usr/bin/wkhtmltopdf /usr/local/bin/wkhtmltopdf

RUN chmod +x /usr/local/bin/wkhtmltopdf

EXPOSE 80
