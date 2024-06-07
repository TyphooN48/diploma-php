FROM php:apache

RUN apt-get update -y && apt-get install -y zlib1g-dev libpng-dev

RUN apt-get update \
  && apt-get install -y --no-install-recommends libpq-dev \
  && docker-php-ext-install pdo_mysql gd

RUN rm -rf /etc/localtime
RUN ln -s /usr/share/zoneinfo/Europe/Moscow /etc/localtime
RUN echo "Europe/Moscow" > /etc/timezone

EXPOSE 80