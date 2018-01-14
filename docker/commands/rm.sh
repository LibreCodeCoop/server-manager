#!/bin/bash

# globals
BASE=$1
DOMAIN=$2
DOCKER="${BASE}/sm/docker"

rm="${DOCKER}/php/rm.php"
disable="${DOCKER}/php/disable.php"

php ${disable} b=${BASE} d=${DOMAIN}
php ${rm} b=${BASE} d=${DOMAIN}

rm -f "${BASE}/sm/docker/enabled/${DOMAIN}"
rm -rf "${BASE}/app/${DOMAIN}"
rm -rf "${BASE}/repo/${DOMAIN}.git"
