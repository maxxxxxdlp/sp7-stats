FROM php:7.4-fpm-alpine as back_end

LABEL maintainer="Specify Collections Consortium <github.com/specify>"

# Install zip PHP module
RUN apk add --no-cache libzip-dev
RUN docker-php-ext-install zip

# Install CURL PHP module
RUN apk add --no-cache php-curl curl curl-dev libcurl
RUN docker-php-ext-install curl

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
RUN echo -e \
  "\n\nmemory_limit = -1" \
  "\nmax_execution_time = 3600" \
  "\nbuffer-size=65535" \
  "\noutput_buffering=65535" \
  >>"$PHP_INI_DIR/php.ini"

WORKDIR /home/specify
RUN mkdir ./working-dir && chown -R www-data:www-data ./working-dir

USER www-data

COPY --chown=www-data:www-data ./ ./sp7-stats