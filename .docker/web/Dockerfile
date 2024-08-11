FROM ghcr.io/kluknulo-star/docker-images/php-nginx:8.3

ARG CI_COMMIT_SHORT_SHA
ENV SENTRY_RELEASE=${CI_COMMIT_SHORT_SHA}

USER root

RUN apk add --no-cache --update \
    php83-xmlreader \
    php83-xmlwriter \
    php83-xml \
    php83-gd

USER ${USER}

COPY --chown=${USER}:${USER} ./.docker/web/rootfs /
COPY --chown=${USER}:${USER} . ${WORKDIR}

RUN composer install --no-dev --classmap-authoritative --no-scripts \
    && composer dump-autoload --no-interaction --no-scripts --classmap-authoritative

HEALTHCHECK --timeout=10s CMD curl --silent --fail http://127.0.0.1:8080/fpm-ping
