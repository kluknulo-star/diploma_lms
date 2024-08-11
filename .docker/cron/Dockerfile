FROM ghcr.io/kluknulo-star/docker-images/php-cron:8.3

USER root

RUN apk add --no-cache --update \
    php83-xmlreader \
    php83-xmlwriter \
    php83-xml \
    php83-gd

USER ${USER}

COPY --chown=${USER}:${USER} .docker/cron/rootfs /
COPY --chown=${USER}:${USER} . ${WORKDIR}

RUN composer install --no-dev --classmap-authoritative --no-scripts \
    && composer dump-autoload --no-interaction --no-scripts --classmap-authoritative
