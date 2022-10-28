FROM php:7.4-fpm-alpine as back_end

LABEL maintainer="Specify Collections Consortium <github.com/specify>"

# Install zip PHP module
RUN apk add --no-cache libzip-dev \
  && docker-php-ext-install zip

# Install CURL PHP module
RUN apk add --no-cache php-curl libcurl3 libcurl3-dev \
  && docker-php-ext-install curl

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
RUN echo -e \
  "\n\nmemory_limit = -1" \
  "\nmax_execution_time = 3600" \
  "\nbuffer-size=65535" \
  "\noutput_buffering=65535" \
  >>"$PHP_INI_DIR/php.ini"

RUN addgroup -S specify -g 1001 && adduser -S specify -G specify -u 1001
USER specify

WORKDIR /home/specify

COPY --chown=specify:specify ./ ./sp7-stats

RUN mkdir working_dir
RUN chmod -R 777 working_dir

CMD ["php-fpm"]