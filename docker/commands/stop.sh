#!/usr/bin/env bash

BASE=$1
DOMAIN=$2
DOCKER="${BASE}/docker"

replace="${DOCKER}/php/replace.php"
php ${replace} b=${BASE} d=${DOMAIN} t=docker-compose.yml s=true