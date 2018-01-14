#!/usr/bin/env bash

BASE=$1
DOMAIN=$2
DOCKER="${BASE}/sm/docker"
enable="${DOCKER}/php/enable.php"

php ${enable} b=${BASE} d=${DOMAIN}
