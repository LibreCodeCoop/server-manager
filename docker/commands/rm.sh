#!/bin/bash

# globals
BASE=$1
DOMAIN=$2
DOCKER="${BASE}/sm/docker"
rm="${DOCKER}/php/rm.php"
replace="${DOCKER}/php/replace.php"

php ${rm} b=${BASE} d=${DOMAIN}
php ${replace} b=${BASE} d=${DOMAIN} t=docker-compose.yml s=true
rm -f "${BASE}/sm/docker/enabled/${DOMAIN}"
rm -rf "${BASE}/app/${DOMAIN}"
rm -rf "${BASE}/repo/${DOMAIN}"
