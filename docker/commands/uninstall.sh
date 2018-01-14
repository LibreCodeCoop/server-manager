#!/bin/bash

# globals
BASE=$1
DOMAIN=$2
DOCKER="${BASE}/docker"
uninstall="${DOCKER}/php/uninstall.php"
replace="${DOCKER}/php/replace.php"

php ${uninstall} b=${BASE} d=${DOMAIN}
php ${replace} b=${BASE} d=${DOMAIN} t=docker-compose.yml s=true
rm -f "${BASE}/docker/${DOMAIN}"
rm -rf "${BASE}/${DOMAIN}"
