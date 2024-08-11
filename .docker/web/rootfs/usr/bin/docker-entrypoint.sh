#!/bin/sh
# Set shell options:
#   -e, exit immediately if a command exits with a non-zero status
set -e

php artisan optimize:clear

exec "$@"
