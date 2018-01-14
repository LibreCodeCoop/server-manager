#!/bin/bash

BASE=$1
DOMAIN=$2
down="${BASE}/sm/docker/php/down.php"

php ${down} b=${BASE} d=${DOMAIN}
