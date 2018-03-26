FROM php:7.1-fpm

# git
RUN apt-get update && apt-get install -y git

# mysql
RUN docker-php-ext-install mysqli

# mcrypt
RUN apt-get -y install libmcrypt-dev
RUN docker-php-ext-configure mcrypt
RUN docker-php-ext-install mcrypt

# redis
#RUN docker-php-source extract \
#    && curl -L -o /tmp/redis.tar.gz https://github.com/phpredis/phpredis/archive/3.0.0.tar.gz \
#    && tar xfz /tmp/redis.tar.gz \
#    && rm -r /tmp/redis.tar.gz \
#    && mv phpredis-3.0.0 /usr/src/php/ext/redis \
#    && docker-php-ext-install redis

# memcached
#RUN apt-get update && apt-get install -y libmemcached-dev zlib1g-dev
#RUN curl -L -o /tmp/memcached.tar.gz https://github.com/php-memcached-dev/php-memcached/archive/php7.tar.gz \
#  && tar xfz /tmp/memcached.tar.gz \
#  && rm -r /tmp/memcached.tar.gz \
#  && mv php-memcached-php7 /usr/src/php/ext/memcached \
#  && docker-php-ext-install memcached
