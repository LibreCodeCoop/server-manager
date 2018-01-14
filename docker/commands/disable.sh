#!/usr/bin/env bash

BASE=$1
DOMAIN=$2
DOCKER="${BASE}/sm/docker"
disable="${DOCKER}/php/disable.php"

php ${disable} b=${BASE} d=${DOMAIN}