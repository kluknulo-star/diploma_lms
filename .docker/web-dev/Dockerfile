FROM ghcr.io/kluknulo-star/docker-images/php-nginx:8.3-dev

USER root

RUN apk add --no-cache --update \
    php83-xmlreader \
    php83-xmlwriter \
    php83-xml \
    php83-gd

USER ${USER}

COPY --chown=${USER}:${USER} . ${WORKDIR}

HEALTHCHECK --timeout=10s CMD curl --silent --fail http://127.0.0.1:8080/fpm-ping
